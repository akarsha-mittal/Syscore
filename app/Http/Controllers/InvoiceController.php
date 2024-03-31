<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use GuzzleHttp\Client;
use Auth;
use DB;
class InvoiceController extends Controller
{
    /**
     * This function is used to show list view of invoices.
     */
    public function index(Request $request)
    {
        $from_date = ($request->input('from_date')) ? $request->input('from_date') : date("Y-m-d");
        $to_date   = ($request->input('to_date')) ? $request->input('to_date') : date("Y-m-d");

        $invoices = $this->getInvoicesBasedOnDateRange($from_date,$to_date);
        return view('invoices',compact('invoices'));
    }
    /**
     * This function is used to show generate invoice page.
     */
    public function show()
    {
        return view('invoices.add');
    }
    /**
     * This function is used to store data at time of generating invoice.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validate_data = $request->validate([
            'quantity.*' => 'required|numeric',
            'amount.*' => 'required|numeric',
            'description.*' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'invoice_description' => 'required|string|max:255',
            'payment_status' => 'required|in:0,1',
        ]);
        $count = count($validate_data['quantity']);
        if ($count<1 ||$count !== count($validate_data['amount']) || $count !== count($validate_data['description'])) {
            return redirect()->to('/invoices/add')->withErrors("Invalid data provided.");
        }

        try {
            $apiKey = env('GOOGLE_MAPS_API_KEY');
            $client = new Client();
            $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
                'query' => [
                    'address' => $request->address,
                    'key' => $apiKey,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            if ($data['status'] === 'OK') {
                $invoice                    = new Invoice();
                $invoice->user_id           = Auth::id();
                $invoice->address           = $validate_data['address'];
                $invoice->description       = $validate_data['invoice_description'];
                $invoice->payment_status    = $validate_data['payment_status'];
                $invoice->payment_date      = $validate_data['payment_status'] == 1 ? now() : null;
                $invoice->save();

                foreach ($validate_data['quantity'] as $key => $quantity) {
                    $invoiceItem                = new InvoiceItem();
                    $invoiceItem->invoice_id    = $invoice->id;
                    $invoiceItem->quantity      = $quantity;
                    $invoiceItem->description   = $validate_data['description'][$key];
                    $invoiceItem->amount        = $validate_data['amount'][$key];
                    $invoiceItem->save();
                }
                return redirect()->route('invoices')->with('success', 'Invoice created successfully.');
            } else {
                return redirect()->to('/invoices/add')->withErrors("Address validation failed. Please try again.");
            }
        } catch (\Exception $e) {
            return redirect()->to('/invoices/add')->withErrors("Failed to create invoice. Please try again.");
        }
    }
    /**
     * This function is used to download Invoice Based on invoiceid
     */
    public function downloadInvoice($id){
        $invoice        = Invoice::where('id',$id)->first();
        $invoice_items  = InvoiceItem::where('invoice_id',$id)->get();
        $spreadsheet    = new Spreadsheet();
        $sheet          = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Invoice Description');
        $sheet->setCellValue('B1', $invoice->description);
        $sheet->setCellValue('A2', 'Address');
        $sheet->setCellValue('B2', $invoice->address);
        $sheet->setCellValue('A3', 'Payment Status');
        $sheet->setCellValue('B3', ($invoice->payment_status==1) ? "Completed" : "Pending");
        $sheet->setCellValue('A4', 'Payment Date');
        $sheet->setCellValue('B4', ($invoice->payment_date!=null) ? $invoice->payment_date : "Not Available");
        $sheet->setCellValue('A6', 'Item Description');
        $sheet->setCellValue('B6', 'Quantity');
        $sheet->setCellValue('C6', 'Amount');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A4')->getFont()->setBold(true);
        $sheet->getStyle('A6')->getFont()->setBold(true);
        $sheet->getStyle('B6')->getFont()->setBold(true);
        $sheet->getStyle('C6')->getFont()->setBold(true);
        $count = 7;
        foreach($invoice_items as $item){
            $sheet->setCellValue('A'.$count, $item->description);
            $sheet->setCellValue('B'.$count, $item->quantity);
            $sheet->setCellValue('C'.$count, $item->amount);
            $count++;
        }
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(20);

        // Create a new Xlsx writer
        $writer = new Xlsx($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Invoice.xlsx"');
        header('Cache-Control: max-age=0');

        // Write the spreadsheet to the PHP output buffer
        $writer->save('php://output');

        exit;
    }
    /**
     * This function is used to download invoice details based on date range.
     */
    public function downloadInvoicesBasedOnDate($from_date,$end_date){
        $invoices = $this->getInvoicesBasedOnDateRange($from_date,$end_date);

        $spreadsheet    = new Spreadsheet();
        $sheet          = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Invoice Description');
        $sheet->setCellValue('B1', 'Address');
        $sheet->setCellValue('C1', 'Payment Status');
        $sheet->setCellValue('D1', 'Payment Date');
        $sheet->setCellValue('E1', 'Total Amount');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('B1')->getFont()->setBold(true);
        $sheet->getStyle('C1')->getFont()->setBold(true);
        $sheet->getStyle('D1')->getFont()->setBold(true);
        $sheet->getStyle('E1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $count = 2;
        foreach($invoices as $invoice){
            $invoice_items  = InvoiceItem::where('invoice_id',$invoice->id)->get();
            $total = 0;
            foreach($invoice_items as $item){
                $total_amount = $item->quantity * $item->amount;
                $total = $total+$total_amount;
            }
            $sheet->setCellValue('A'.$count, $invoice->description);
            $sheet->setCellValue('B'.$count, $invoice->address);
            $sheet->setCellValue('C'.$count, ($invoice->payment_status==1) ? "Completed" : "Pending");
            $sheet->setCellValue('D'.$count, ($invoice->payment_date!=null) ? $invoice->payment_date : "Not Available");
            $sheet->setCellValue('E'.$count, $total);
            $count++;
        }
        $writer = new Xlsx($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Invoice.xlsx"');
        header('Cache-Control: max-age=0');

        // Write the spreadsheet to the PHP output buffer
        $writer->save('php://output');

        exit;
    }
    /**
     * This function returns record of invoices based on date range.
     */
    public function getInvoicesBasedOnDateRange($from_date,$end_date){
        return Invoice::where('user_id',Auth::id())
        ->where(DB::raw('DATE(created_at)'),'>=',$from_date)
        ->where(DB::raw('DATE(created_at)'),'<=',$end_date)
        ->orderBy('id','DESC')->get();
    }
}

@extends('layouts.layout')
@section('htmlheader_title')
    Invoices
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Invoices</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Invoices</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    @php
        use Illuminate\Support\Str;
    @endphp
    <section class="content">
        <div class="container-fluid">
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                            <form action="{{ route('invoices') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="control-label">From Date</label>
                                        <input type="text" class="form-control" placeholder="Enter From Date"
                                            name="from_date" id="from_date" value="{{ date('Y-m-d') }}" required />
                                    </div>

                                    <div class="col-md-4">
                                        <label class="control-label">To Date</label>
                                        <input type="text" class="form-control" placeholder="Enter To Date"
                                            name="to_date" id="to_date" value="{{ date('Y-m-d') }}" required />
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">&nbsp;</label><br />
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                            <div class="col-md-2">
                                <label for="">&nbsp;</label><br />
                                <button class="download-all-invoices btn btn-primary">
                                    <i class="fa fa-download"></i>  Download</button>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group change">
                                    <label for="">&nbsp;</label><br />
                                    <a href="{{ route('invoices.show') }}"><button class="btn btn-primary"><i
                                                class="fas fa-plus"></i> Generate Invoice</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header row">
                            <div class="col-md-10"></div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        @include('layouts.partials.messages')

                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Invoice Description</th>
                                        <th>Payment Status</th>
                                        <th>Payment Date</th>
                                        <th>Created On</th>
                                        <th>Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sno = 1;
                                    @endphp
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td>{{ $sno++ }}</td>

                                            <td title="{{ $invoice->description }}">
                                                {{ Str::limit($invoice->description, $limit = 50, $end = '...') }}</td>
                                            <td>{{ $invoice->payment_status == 1 ? 'Completed' : 'Pending' }}</td>
                                            <td>{{ $invoice->payment_date }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d') }}
                                            </td>
                                            <td><button class="download-invoice btn btn-primary"
                                                    data-invoiceid="{{ $invoice->id }}"><i
                                                        class="fa fa-download"></i></button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </section>

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"
        rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

    <!-- Include DataTables JS -->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/buttons.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#example2').DataTable({
                paging: true,
                sorting: false,
                "lengthMenu": [
                    [4, -1],
                    [4, "All"]
                ],
            });
        });
        $(".download-invoice").on("click", function() {
            let id = $(this).attr("data-invoiceid");
            Url = "{{ route('download.invoice', [':id']) }}";
            Url = Url.replace(':id', id);
            window.location = Url;
        });
        $(".download-all-invoices").on("click", function() {
            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();
            let a = moment(from_date);
            let b = moment(to_date);
            let diff = Math.abs(a.diff(b, 'days'));
            if (diff < 30) {
                if (new Date(from_date) <= new Date(to_date)) {
                    Url = "{{ route('download.invoice-datewise', [':startdate', ':enddate']) }}";
                    Url = Url.replace(':startdate', from_date);
                    Url = Url.replace(':enddate', to_date);
                    window.location = Url;
                } else {
                    alert("start date is greater than end date");
                }
            } else {
                alert("Max 30 days can be selected.")
            }
        });
        $('#from_date').datepicker({
            "startDate": "2008-01-01",
            "endDate": "{{ date('Y-m-d') }}",
            "format": "yyyy-mm-dd",
            "autoclose": true
        });

        $('#to_date').datepicker({
            "startDate": "2008-01-01",
            "endDate": "{{ date('Y-m-d') }}",
            "format": "yyyy-mm-dd",
            "autoclose": true
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
@endsection

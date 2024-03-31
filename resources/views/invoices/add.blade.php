@extends('layouts.layout')
@section('htmlheader_title')
    Invoices
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Generate Invoices</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('invoices') }}">Invoices</a></li>
                        <li class="breadcrumb-item active">Generate Invoices</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        @include('layouts.partials.messages')

                        <form action="{{ route('invoices.add') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="card-body">
                                <h4> Item Details </h4>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="after-add-more row">
                                            <div class="col-md-4">
                                                <label class="control-label">Item Description</label>
                                                <input maxlength="200" type="text" class="form-control"
                                                    placeholder="Enter Item Description" name="description[]" required />
                                            </div>

                                            <div class="col-md-3">
                                                <label class="control-label">Quantity</label>
                                                <input maxlength="200" type="number" class="form-control"
                                                    placeholder="Enter Quantity" name="quantity[]" required />
                                            </div>

                                            <div class="col-md-3">
                                                <label class="control-label">Amount</label>
                                                <input maxlength="200" type="number" class="form-control"
                                                    placeholder="Enter Amount" name="amount[]" required step="any" />
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group change">
                                                    <label for="">&nbsp;</label><br />
                                                    <a class="btn btn-success add-more">+ Add More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="Enter Address"
                                        required>
                                    @if ($errors->has('address'))
                                        <span class="text-danger text-left">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Invoice Description</label>
                                    <input type="text" class="form-control" name="invoice_description"
                                        placeholder="Enter Invoice Description" required maxlength="200">
                                    @if ($errors->has('invoice_description'))
                                        <span
                                            class="text-danger text-left">{{ $errors->first('invoice_description') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Payment Status</label>
                                    <select name="payment_status" class="form-control">
                                        <option value="0">Pending</option>
                                        <option value="1">Completed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>

        </div>

    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $(document).on("click", ".add-more", function() {
                var html = $(".after-add-more").first().clone();

                //  $(html).find(".change").prepend("<label for=''>&nbsp;</label><br/><a class='btn btn-danger remove'>- Remove</a>");

                $(html).find(".change").html(
                    "<label for=''>&nbsp;</label><br/><a class='btn btn-danger remove'>- Remove</a>");


                $(".after-add-more").last().after(html);



            });

            $(document).on("click", ".remove", function() {
                $(this).parents(".after-add-more").remove();
            });
        });
    </script>
@endsection

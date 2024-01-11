@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form id="sale-details-form">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label text-black font-w500">Order Code <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="order_code" id="order_code" class="form-control"
                                            value="{{ $order_code }}" readonly>
                                        <span class="text-danger" id="codeError"></span>
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label class="form-label text-black font-w500">Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" value="{{ date('Y-m-d') }}" class="form-control"
                                            name="mdate" id="mdate">
                                        <span class="text-danger" id="date_Error"></span>
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label class="form-label text-black font-w500">Customer <span
                                                class="text-danger">*</span></label>
                                        <select id="customer" name="customer" class="single-select form-control wide">
                                            <option value="">Choose...</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="customer_Error"></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <div class="input-group">
                            <input name="output_value" id="output_value" type="text" class="form-control"
                                placeholder="Enter Product Code...">
                            <button id="go-btn" onclick="showItem();" class="btn btn-info btn-sm"
                                type="button">GO</button>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- qr scan  --}}
                        <section class="container" id="scan_page">
                            <center>
                                <div id="qr-reader" class="qr_card_res mb-3 scanner_qr"
                                    style="width: auto; max-width:700px; height: auto;  border-radius: 5px; box-shadow: 3px 12px 22px 0px #9BA8FF4D;">
                                </div>
                            </center>
                        </section>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Products</h4>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">
                            <table id="order-item-table" class="r-table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Unit Price</th>
                                        <th>Qty</th>
                                        <th style="text-align:right">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="order-item-table-tbody">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total Price</th>
                                        <th style="width:25%">
                                            <input style="text-align:right" type="text" value="0"
                                                class="form-control float-end" id="total-price" name="total-price" readonly>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary float-end btn-shadow" id="submit-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- product details --}}
        <div class="modal fade" id="add-product-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Product Details</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="add-product-form">
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Product Code</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="customer" id="sales_customer" hidden>
                                        <input type="date" name="sale_date" id="sales_date" hidden>
                                        <input type="text" name="product_id" id="product_id" hidden>
                                        <input type="text" name="sale_code" id="sales_code" class="form-control" hidden>
                                         <input type="text" name="product_code" id="product_code" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Product Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="product_name"
                                            id="product_name">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Quantity</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="quantity" id="quantity">
                                        <span class="text-danger" id="quanitityError"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-primary float-end btn-shadow"
                                        id="add-btn">Add Product</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    {{-- custom css  --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('pos/css/qr_scan.css') }}">
    <style>
        #qr-reader div span p {
            background-color: #eb8153;
        }

        .r-table th,
        .r-table td {
            border-color: #EEEEEE;
            padding: 7px 5px;
        }
    </style>
@endpush

@section('scripts')
    <script src="{{ asset('pos/js/CodeScan.js') }}"></script>
    <script src="{{ asset('pos/js/main.js') }}"></script>
    <script>
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess);

        // QR code
        var flag = true;

        function onScanSuccess(decodedText, decodedResult) {
            if (flag) {
                console.log(`Code scanned = ${decodedText}`, decodedResult);
                flag = false;
                setTimeout(() => flag = true, 3000);
                document.cookie = "decodedText = " + decodedText;
                $('#output_value').val(decodedText);
                showItem();
            }
        }

        function showItem() {
            let outputValue = $('#output_value').val();

            if (outputValue === '' || outputValue === null || outputValue === undefined) {
                toastr.error('Product code is required', 'Error Alert', {
                    timeOut: 3000,
                    fadeOut: 1000
                });
            } else {
                var data = {
                    'product_code': $('#output_value').val(),
                    'order_code': $('#order_code').val(),
                    'date': $('#mdate').val(),
                    'customer': $('#customer').val(),
                }

                console.log(data);

                $.ajax({
                    type: 'GET',
                    url: "{{ url('/show/product/details') }}",
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        let product = response.product;
                        let order = $('#order_code').val();
                        let customer = $('#customer').val();
                        let date = $('#mdate').val();

                        $('#sales_code').val(order);
                        $('#sales_customer').val(customer);
                        $('#sales_date').val(date);
                        $('#product_code').val(product.item_code);
                        $('#product_id').val(product.id);
                        $('#product_name').val(product.item_name);
                        $('#add-product-modal').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        }

        $('body').on('click', '#add-btn', function(event) {
            let formData = new FormData($('#add-product-form')[0]);

            $('#page-loader').show();
            $("#add-btn").html('Please Wait...');
            $("#add-btn").attr("disabled", true);

            $('#quanitityError').text("");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('/sale/item/store') }}",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#add-btn").html('Add Product');
                    $("#add-btn").attr("disabled", false);
                    $('#add-product-modal').modal('hide');
                    let products = response.products;

                    $('#order-item-table-tbody').html("");
                    let net_total = 0;

                    $.each(response.sales_items, function(key, item) {
                        let sell_price = parseFloat(item.sell_price);
                        let quantity = parseFloat(item.total_qty);
                        let total_price = sell_price * quantity;
                        net_total += total_price;

                        $('#order-item-table-tbody').append(
                            `<tr>
                                <td>${products[item.items_id]}</td>
                                <td style="text-align:right">${item.sell_price}</td>
                                <td style="text-align:right">${item.total_qty}</td>
                                <td style="text-align:right">${total_price}</td>
                            </tr>`
                        );
                    });
                    
                    $('#total-price').val(net_total.toFixed(2));

                    $('#page-loader').hide();

                },
                error: function(response) {
                    $('#quanitityError').text(response.responseJSON.errors.quantity);

                    $("#add-btn").html('Try Again');
                    $("#add-btn").attr("disabled", false);
                    $('#page-loader').hide();
                }

            });
        });

        $('body').on('click', '#submit-btn', function(event) {
            let formData = new FormData($('#add-product-form')[0]);
            let totalPrice = $('#total-price').val();

            formData.append('total_price', totalPrice);

            $('#page-loader').show();
            $("#submit-btn").html('Please Wait...');
            $("#submit-btn").attr("disabled", true);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('/sale/submit') }}",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == 1) {
                        $("#submit-btn").html('Submitted');
                        $("#submit-btn").attr("disabled", false);
                        toastr.success(response.message, 'Success Alert', {
                            timeOut: 3000,
                            fadeOut: 1000
                        });

                        window.location.reload();
                    } else {
                        $("#submit-btn").html('Try Again');
                        $("#submit-btn").attr("disabled", false);
                        toastr.error(response.message, 'Error Alert', {
                            timeOut: 3000,
                            fadeOut: 1000
                        });
                    }
                    $('#page-loader').hide();
                },
                error: function(response) {
                    $("#submit-btn").html('Try Again');
                    $("#submit-btn").attr("disabled", false);
                    $('#page-loader').hide();
                }
            });
        });
    </script>
@endsection

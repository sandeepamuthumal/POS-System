@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Purchases</h4>

                        <button type="button" class="btn btn-rounded btn-outline-primary shadow btn-sm sharp "
                            id="show-add-grn-model"><span class="btn-icon-start text-info"><i
                                    class="fa fa-plus color-info"></i>
                            </span>Add New Purchase</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="purchase-table" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Purchase Code</th>
                                        <th>Purchase Date</th>
                                        <th>Supplier</th>
                                        <th>Purchase Count</th>
                                        <th>Status </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- view Purchase item -->
        <div class="modal fade bd-example-modal-xl" id="view-purchase-item-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Purchase Items</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="view-purchase-item-table" class="r-table table-bordered table-striped"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th width = "10%">#</th>
                                    <th>Item Name</th>
                                    <th>Order QTY</th>
                                    <th>Purchase Price</th>
                                </tr>
                            </thead>
                            <tbody id="view-items-tbody">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Purchase -->
        <div class="modal fade bd-example-modal-xl" id="add-purchase-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add New Purchase</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form">
                            <form id="add-purchase-form">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Purchase Code <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="purchase_code" id="purchase_code" class="form-control"
                                            value="{{ $purchase_code }}" readonly>
                                        <span class="text-danger" id="codeError"></span>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" value="{{ date('Y-m-d') }}" class="form-control"
                                            name="mdate" id="mdate">
                                        <span class="text-danger" id="date_Error"></span>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Supplier <span
                                                class="text-danger">*</span></label>
                                        <select id="supplier" name="supplier" class="single-select form-control wide">
                                            <option value="">Choose...</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="supplier_Error"></span>
                                    </div>
                                </div>
                            </form>
                            <!-- Purchase Items -->
                            <hr>
                            <h6 class="modal-title">Purchase Items</h6>
                            <br>
                            <form id="add-purchase-item-form">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label text-black font-w500">Product Name</label>
                                        <select id="product_name" name="product_name"
                                            class="single-select form-control wide">
                                            <option value="">Choose...</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">
                                                    {{ $product->item_code . ' ' . $product->item_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="itemname_Error"></span>
                                    </div>

                                    <div class="mb-3 col-md-3">
                                        <label class="form-label text-black font-w500">Purchase Price</label>
                                        <input type="text" name="purchase_price" id="purchase_price"
                                            class="form-control">
                                        <span class="text-danger" id="purchase_priceError"></span>
                                    </div>

                                    {{-- <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Selling Price</label>
                                        <input type="text" name="selling_price" id="selling_price"
                                            class="form-control">
                                        <span class="text-danger" id="selling_priceError"></span>
                                    </div> --}}

                                    <div class="mb-3 col-md-5">
                                        <label class="form-label text-black font-w500">Quantity </label>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <input value="0" type="number" class="form-control"
                                                    name="quantity" id="quantity">
                                                <span class="text-danger" id="qty_Error"></span>
                                            </div>
                                            <div class="col-lg-4">
                                                <button type="button" id="add-purchase-item"
                                                    class="btn btn-rounded btn-info btn-sm float-end"><span
                                                        class="btn-icon-start text-info"><i class="fa fa-arrow-right"></i>
                                                    </span>Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </form>

                            <br>
                            <!-- purchase items TABLE -->
                            <table id="purchase-item-table" class="r-table table-bordered table-striped"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th width = "10%">#</th>
                                        <th>Item Name</th>
                                        <th>Order QTY</th>
                                        <th>Purchase Price</th>
                                    </tr>
                                </thead>
                                <tbody id="purchase-item-table-tbody">

                                </tbody>
                            </table>
                            <br>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary float-end btn-shadow"
                                    id="add-purchase-btn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Purchase -->
        <div class="modal fade bd-example-modal-xl" id="edit-purchase-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Purchase</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form">
                            <form id="edit-purchase-form">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Purchase Code <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="purchase_id" name="purchase_id" hidden>
                                        <input type="text" name="purchase_code" id="edit_purchase_code"
                                            class="form-control" readonly>
                                        <span class="text-danger" id="edit_codeError"></span>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" value="{{ date('Y-m-d') }}" class="form-control"
                                            name="mdate" id="edit_mdate">
                                        <span class="text-danger" id="edit_date_Error"></span>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Supplier <span
                                                class="text-danger">*</span></label>
                                        <select id="edit_supplier" name="supplier"
                                            class="single-select form-control wide">
                                            <option value="">Choose...</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="edit_supplier_Error"></span>
                                    </div>
                                </div>
                            </form>
                            <!-- Purchase Items -->
                            <hr>
                            <h6 class="modal-title">Purchase Items</h6>
                            <br>
                            <form id="edit-purchase-item-form">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Product Name</label>
                                        <select id="edit_product_name" name="product_name"
                                            class="single-select form-control wide">
                                            <option value="">Choose...</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">
                                                    {{ $product->item_code . ' ' . $product->item_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="edit_itemname_Error"></span>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Purchase Price</label>
                                        <input type="text" name="purchase_price" id="purchase_price"
                                            class="form-control">
                                        <span class="text-danger" id="edit_purchase_priceError"></span>
                                    </div>

                                    {{-- <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Selling Price</label>
                                        <input type="text" name="selling_price" id="selling_price"
                                            class="form-control">
                                        <span class="text-danger" id="edit_selling_priceError"></span>
                                    </div> --}}

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Quantity </label>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <input value="0" type="number" class="form-control"
                                                    name="quantity" id="edit_quantity">
                                                <span class="text-danger" id="qty_Error"></span>
                                            </div>
                                            <div class="col-lg-4">
                                                <button type="button" id="edit-add-purchase-item"
                                                    class="btn btn-rounded btn-info btn-sm float-end"><span
                                                        class="btn-icon-start text-info"><i class="fa fa-arrow-right"></i>
                                                    </span>Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </form>

                            <br>
                            <!-- purchase items TABLE -->
                            <table id="edit-purchase-item-table" class="r-table table-bordered table-striped"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th width = "10%">Position</th>
                                        <th>Item Name</th>
                                        <th>Order QTY</th>
                                        <th>Purchase Price</th>
                                        <th>Selling Price</th>
                                    </tr>
                                </thead>
                                <tbody id="edit-purchase-item-table-tbody">

                                </tbody>
                            </table>
                            <br>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary float-end btn-shadow"
                                    id="update-purchase-btn">Update</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .select2-container {
            z-index: 9999;
        }

        .r-table th,
        .r-table td {
            border-color: #EEEEEE;
            padding: 9px 7px;
            min-width: 140px;
        }

        #report_table th,
        td {
            min-width: 140px;
        }


        .hidden-column {
            display: none;
        }
    </style>
@endpush


@section('scripts')
    <script src="./admin/js/sweetalert2@11.js"></script>


    <script type="text/javascript">
        load_purchases();
        // add grn item
        function loadPurchaseItems(purchase_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('/load/purchase/items') }}",
                data: {
                    purchase_id: purchase_id
                },
                success: function(response) {
                    $('#purchase-item-table-tbody').html("");
                    let rowCount = 0;
                    console.log(response.purchase_items);

                    $.each(response.purchase_items, function(key, item) {
                        $('#purchase-item-table-tbody').append(
                            `<tr>
                                <td>${++rowCount}</td>
                                <td>${item.item_name}</td>
                                <td>${item.qty}</td>
                                <td>${item.purchase_price}</td>
                                <td>
                                    <button class="btn light btn-dark btn-sm" style="padding:5px 9px;border-radius:0px;border:none"
                                    type="button" onclick="delete_item_row(${item.id})"> <span class="text-danger"><i class="fa fa-times"></i></span>
                                    </button>
                                </td>
                            </tr>`
                        );
                    });

                    $('#page-loader').hide();
                },
                error: function(error) {
                    console.error(error);
                    $('#page-loader').hide();
                }
            });
        }

        function delete_item_row(item_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('/delete/purchase/item') }}",
                data: {
                    item_id: item_id
                },
                success: function(response) {
                    loadPurchaseItems(response.purchase_id);
                },
                error: function(error) {
                    toastr.error('Something went wrong!', 'Error Alert', {
                        timeOut: 4000,
                        fadeOut: 1000
                    });
                }
            });
        }

        // load GRN
        function load_purchases() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#page-loader').show();

            $.ajax({
                type: "POST",
                url: "{{ url('/purchase/load/active') }}",
                dataType: 'json',
                success: function(response) {
                    if (response !== "No-data") {

                        var table = $('#purchase-table').DataTable({
                            createdRow: function(row, data, index) {
                                $(row).addClass('selected')
                            },
                            language: {
                                paginate: {
                                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                                }
                            },
                            dom: 'Blfrtip',
                            buttons: [],
                            pageLength: 25,
                            lengthChange: true,
                            "order": [],
                            destroy: true,
                            tooltip: true,
                            data: response,
                            columns: [{
                                    data: 'code',
                                    title: 'Purchase Code'
                                },
                                {
                                    data: 'date',
                                    title: 'Purchase Date'
                                },

                                {
                                    data: 'supplier',
                                    title: 'Supplier Name'
                                },
                                {
                                    data: 'count',
                                    title: 'Purchase Count '
                                },
                                {
                                    data: 'status',
                                    title: 'Status'
                                },
                                {
                                    data: 'edit_button',
                                    title: 'Action'
                                },
                            ]

                        });

                    } else {

                        var table =
                            "<tr class=\"odd\"><td valign=\"top\" colspan=\"6\" class=\"dataTables_empty\">No active users available in table</td></tr>";

                        document.getElementById("purchase-table").innerHTML = table;

                    }

                    table.rows().every(function() {
                        this.nodes().to$().removeClass('selected')
                    });

                    $('#page-loader').hide();

                }
            });
        }

        //load grn code
        function load_grn_code() {
            $.ajax({
                type: "GET",
                url: "{{ url('/load/purchase/code') }}",
                success: function(response) {
                    $('#purchase_code').val(response.code);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        // item grn
        $('body').on('click', '#show-add-grn-model', function(event) {
            $("add-grn-btn").html('Create Item');

            load_grn_code();

            $('#add-purchase-modal').modal('show');
            $("#add-grn-btn").attr("disabled", false);
            $("#customers").attr("disabled", false);
        });

        $('body').on('click', '#add-purchase-btn', function(event) {
            let formData = new FormData($('#add-purchase-form')[0]);

            $('#page-loader').show();
            $("#add-purchase-btn").html('Please Wait...');
            $("#add-purchase-btn").attr("disabled", true);

            $('#supplier_Error').text("");

            // ajax
            $.ajax({
                type: "POST",
                url: "{{ url('/purchase/store') }}",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#add-purchase-btn").html('Created');
                    $("#add-purchase-btn").attr("disabled", false);
                    $('#add-purchase-modal').modal('hide');
                    toastr.success('Successfully Added!', 'Success Alert', {
                        timeOut: 4000,
                        fadeOut: 1000
                    });
                    $('#page-loader').hide();
                    load_purchases();
                    $('#purchase-item-table').find('tbody tr').empty();
                    $("#add-purchase-item").attr("disabled", false);
                    $("#add-purchase-btn").html('Submit');
                    $('#add-purchase-form').trigger("reset");
                    $('#supplier').val('').trigger('change');
                    $('#product_name').val('').trigger('change');
                },
                error: function(response) {
                    $('#supplier_Error').text(response.responseJSON.errors.supplier);

                    $("#add-purchase-btn").html('Try Again');
                    $("#add-purchase-btn").attr("disabled", false);
                    $('#page-loader').hide();
                }
            });
        });

        // add table data grn item
        $('body').on('click', '#add-purchase-item', function(event) {
            var formData = new FormData();

            var form1Data = $('#add-purchase-item-form').serializeArray();
            $.each(form1Data, function(index, field) {
                formData.append(field.name, field.value);
            });

            var form2Data = $('#add-purchase-form').serializeArray();
            $.each(form2Data, function(index, field) {
                formData.append(field.name, field.value);
            });

            $('#page-loader').show();
            $("#add-purchase-item").attr("disabled", true);
            $("#add-purchase-item").html('Please Wait...');

            $('#supplier_Error').text("");
            $('#itemname_Error').text("");
            $('#qty_Error').text("");
            $('#purchase_priceError').text("");
            $('#selling_priceError').text("");

            // ajax
            $.ajax({
                type: "POST",
                url: "{{ url('/add/purchase/item') }}",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    loadPurchaseItems(response.purchase_id);

                    $("#add-purchase-item").html(
                        '<span class="btn-icon-start text-info"><i class="fa fa-arrow-right"></i></span>Add'
                    );
                    $("#add-purchase-item").attr("disabled", false);

                },
                error: function(response) {
                    $('#supplier_Error').text(response.responseJSON.errors.supplier);
                    $('#itemname_Error').text(response.responseJSON.errors.product_name);
                    $('#qty_Error').text(response.responseJSON.errors.quantity);
                    $('#purchase_priceError').text(response.responseJSON.errors.purchase_price);
                    // $('#selling_priceError').text(response.responseJSON.errors.selling_price);

                    $("#add-purchase-item").html('Try Again');
                    $("#add-purchase-item").attr("disabled", false);
                    $('#page-loader').hide();
                }
            });
        });

        // view grn item
        $('body').on('click', '.view', function() {
            var id = $(this).data('id');

            $('#view-purchase-item-modal').modal('show');

            $('#page-loader').show();


            $.ajax({
                type: "GET",
                url: "{{ url('/load/purchase/items') }}",
                data: {
                    purchase_id: id
                },
                success: function(response) {
                    $('#view-items-tbody').html("");
                    let rowCount = 0;
                    console.log(response.purchase_items);

                    $.each(response.purchase_items, function(key, item) {
                        $('#view-items-tbody').append(
                            `<tr>
                                <td>${++rowCount}</td>
                                <td>${item.item_name}</td>
                                <td>${item.qty}</td>
                                <td>${item.purchase_price}</td>
                            </tr>`
                        );
                    });

                    $('#page-loader').hide();
                },
                error: function(error) {
                    console.error(error);
                    $('#page-loader').hide();
                }
            });
        });

        // edit grn item
        $('body').on('click', '.edit', function() {
            var id = $(this).data('id');
            $('#page-loader').show();
            $('#edit-purchase-modal').modal('show');

            // ajax
            $.ajax({
                type: "GET",
                url: "{{ url('/purchase/edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    var purchase = response.purchase;

                    $("#edit_purchase_code").val(purchase.purchase_code);
                    $("#edit_mdate").val(purchase.purchase_date);
                    $("#edit_supplier").val(purchase.suppliers_id).trigger('change');
                    $("#purchase_id").val(purchase.id).trigger('change');
                    $('#page-loader').hide();
                    load_items(purchase.id);
                }
            });
        });

        $('body').on('click', '#edit-add-purchase-item', function(event) {
            var formData = new FormData();

            var form1Data = $('#edit-purchase-item-form').serializeArray();
            $.each(form1Data, function(index, field) {
                formData.append(field.name, field.value);
            });

            var form2Data = $('#edit-purchase-form').serializeArray();
            $.each(form2Data, function(index, field) {
                formData.append(field.name, field.value);
            });

            $('#page-loader').show();
            $("#edit-add-purchase-item").attr("disabled", true);
            $("#edit-add-purchase-item").html('Please Wait...');

            $('#edit_supplier_Error').text("");
            $('#edit_itemname_Error').text("");
            $('#edit_qty_Error').text("");
            $('#edit_purchase_priceError').text("");
            $('#edit_selling_priceError').text("");

            // ajax
            $.ajax({
                type: "POST",
                url: "{{ url('/add/purchase/item') }}",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    load_items(response.purchase_id);

                    $("#edit-add-purchase-item").html(
                        '<span class="btn-icon-start text-info"><i class="fa fa-arrow-right"></i></span>Add'
                    );
                    $("#edit-add-purchase-item").attr("disabled", false);

                },
                error: function(response) {
                    $('#edit_supplier_Error').text(response.responseJSON.errors.supplier);
                    $('#edit_itemname_Error').text(response.responseJSON.errors.product_name);
                    $('#edit_qty_Error').text(response.responseJSON.errors.quantity);
                    $('#edit_purchase_priceError').text(response.responseJSON.errors.purchase_price);
                    // $('#edit_selling_priceError').text(response.responseJSON.errors.selling_price);

                    $("#edit-add-purchase-item").html('Try Again');
                    $("#edit-add-purchase-item").attr("disabled", false);
                    $('#page-loader').hide();
                }
            });
        });

        // update grn
        $('body').on('click', '#update-purchase-btn', function(event) {
            let formData = new FormData($('#edit-purchase-form')[0]);

            $('#page-loader').show();
            $("#update-purchase-btn").html('Please Wait...');
            $("#update-purchase-btn").attr("disabled", true);

            $('#edit_supplier_Error').text("");

            // ajax
            $.ajax({
                type: "POST",
                url: "{{ url('/purchase/store') }}",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#update-purchase-btn").html('Updated');
                    $("#update-purchase-btn").attr("disabled", false);
                    $('#edit-purchase-modal').modal('hide');
                    toastr.success('Successfully Updated!', 'Success Alert', {
                        timeOut: 4000,
                        fadeOut: 1000
                    });
                    $('#page-loader').hide();
                    load_purchases();
                    $('#edit_purchase-item-table').find('tbody tr').empty();
                    $("#edit_add-purchase-item").attr("disabled", false);
                    $("#update-purchase-btn").html('Update');
                    $('#edit-purchase-form').trigger("reset");
                    $('#edit_supplier').val('').trigger('change');
                    $('#edit_product_name').val('').trigger('change');
                },
                error: function(response) {
                    $('#edit_supplier_Error').text(response.responseJSON.errors.supplier);

                    $("#update-purchase-btn").html('Try Again');
                    $("#update-purchase-btn").attr("disabled", false);
                    $('#page-loader').hide();
                }
            });
        });

        function load_items(purchase_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('/load/purchase/items') }}",
                data: {
                    purchase_id: purchase_id
                },
                success: function(response) {
                    $('#edit-purchase-item-table-tbody').html("");
                    let rowCount = 0;
                    console.log(response.purchase_items);

                    $.each(response.purchase_items, function(key, item) {
                        $('#edit-purchase-item-table-tbody').append(
                            `<tr>
                                <td>${++rowCount}</td>
                                <td>${item.item_name}</td>
                                <td>${item.qty}</td>
                                <td>${item.purchase_price}</td>
                                <td>
                                    <button class="btn light btn-dark btn-sm" style="padding:5px 9px;border-radius:0px;border:none"
                                    type="button" onclick="edit_delete_item_row(${item.id})"> <span class="text-danger"><i class="fa fa-times"></i></span>
                                    </button>
                                </td>
                            </tr>`
                        );
                    });

                    $('#page-loader').hide();
                },
                error: function(error) {
                    console.error(error);
                    $('#page-loader').hide();
                }
            });
        }

        function edit_delete_item_row(item_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('/delete/purchase/item') }}",
                data: {
                    item_id: item_id
                },
                success: function(response) {
                    load_items(response.purchase_id);
                },
                error: function(error) {
                    toastr.error('Something went wrong!', 'Error Alert', {
                        timeOut: 4000,
                        fadeOut: 1000
                    });
                }
            });
        }

        function deleteData(data) {
            Swal.fire({
                title: 'Are you sure to delete Purchase?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete It!'
            }).then((result) => {
                if (result.isConfirmed) {

                    let url = '{{ route('delete_purchase', ':id') }}'
                    url = url.replace(':id', data)

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: url,
                        success: function() {
                            load_purchases();
                            Swal.fire(
                                'Deleted!',
                                'This purchase has been deleted.',
                                'success'
                            );

                        }
                    })

                }
            })
        }
    </script>
@endsection

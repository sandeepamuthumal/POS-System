@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">


        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <span id="session-message"></span>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create New Product</h4>

                    </div>
                    <div class="card-body">
                        <form action="{{ route('store_product') }}" method="post" enctype="multipart/form-data" autocomplete="chrome-off">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-label text-black font-w500">Product Code</label>
                                        <input type="text" name="product_code" id="product_code"
                                            class="form-control input-rounded form-control-sm" readonly value="{{ $product_code }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label text-black font-w500">Category</label>
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <select name="category" id="category_id"
                                                    class="single-select form-control wide">
                                                    <option value="" selected hidden>Choose...</option>
                                                    @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->category }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    @error('category')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="col-lg-2">
                                                <button class="btn btn-info btn-sm float-end" type="button"
                                                    onclick="add_category();"><i class="fa fa-plus color-info"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-label text-black font-w500">Product Name</label>
                                        <input type="text" name="product_name" id="product_name"
                                            class="form-control input-rounded form-control-sm">
                                        <span class="text-danger">
                                            @error('product_name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-label text-black font-w500">Quantity</label>
                                        <input type="number" name="quantity" id="quantity"
                                            class="form-control input-rounded form-control-sm">
                                        <span class="text-danger">
                                            @error('quantity')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <div class="form-group">
                                        <label class="form-label text-black font-w500">Description</label>
                                        <textarea name="description" class="form-control" cols="30" rows="10" id="comment"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-label text-black font-w500">Price</label>
                                        <input type="text" name="price" id="price"
                                            class="form-control input-rounded form-control-sm">
                                        <span class="text-danger">
                                            @error('price')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <div class="form-group">
                                        <label class="form-label text-black font-w500">Discount</label>
                                        <input type="text" name="discount" id="discount"
                                            class="form-control input-rounded form-control-sm">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label text-black font-w500">Product Image
                                        </label>
                                        <div class="form-file">
                                            <input type="file" class="form-file-input form-control p-2"
                                                name="product_image" style="border-radius:15px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        <div class="toolbar toolbar-bottom" style="text-align: right;">
                            <button type="reset" class="btn btn-dark">Reset</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <!--Add New category Modal -->
        <div class="modal fade" id="categoryModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label text-black font-w500">Category</label>
                                <input type="text" id="category_name" name="category_name" class="form-control"
                                    placeholder="Enter Category Name..">
                                <span class="text-danger" id="categorymodalError"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="cat-add-btn" class="btn btn-primary"
                            onclick="createCategory();">Create</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('css')
    <style>
        #product_image {
            width: 200px;
            height: 150px;
            align-items: center;
        }

        #product_image img {
            width: 100%;
            height: 100%;
        }
    </style>
@endpush

@section('scripts')
    <script>
        function add_category() {
            $('#categorymodalError').text("");
            $('#category_name').val('');
            $("#cat-add-btn").html('Create');
            $('#categoryModal').modal('show');
            $("#cat-add-btn").attr("disabled", false);
        }

        function load_category() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                url: "{{ url('/category/load') }}",
                dataType: 'json',
                success: function(response) {
                    console.log("categories ..." + response);
                    $('#category_id').html('<option value="">Choose...</option>');
                    $.each(response.categories, function(key, item) {
                        $('#category_id').append(
                            '<option value="' + item.id + '">' + item.category +
                            '</option>'
                        );
                    });
                }
            });
        }

        // function edit_site_details() {
        //     $('#page-loader').show();

        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });

        //     $.ajax({
        //         type: "GET",
        //         url: "{{ url('/sites/session/load') }}",
        //         dataType: 'json',
        //         success: function(response) {
        //             if (response.code == 200) {
        //                 var site = response.site;

        //                 console.log("session.............." + response);
        //                 $("#session-message").html('<div class="alert alert-warning alert-dismissible fade show">\
        //                                                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">\
        //                                                     </button>\
        //                                                     <strong>Warning!</strong> This site is a pending one! <a href="#">Fill the rest of details</a>\
        //                                                     </div>');
        //                 $("#btn-save").html('Update');
        //                 $('#edit-site-modal').modal('show');
        //                 $("#address").val(site.address);
        //                 $("#site_name").val(site.site_name);
        //                 $("#contact_no").val(site.site_contact);
        //                 $("#postal_code").val(site.postal_code);
        //                 $("#invoice_value").val(site.invoice_value);
        //                 $('#frequency').val(site.frequency);
        //                 $('#expected_hours').val(site.expected_hours);
        //                 $("#sign_date").val(site.contract_signed_date);
        //                 $("#annual_value").val(site.annual_value);
        //                 $("#site_image").html('<img src="/images/site/' + site
        //                     .site_image + '" alt="Site Image" title="Site Image">');

        //                 var cleaning_days = [];
        //                 cleaning_days = response.cleaning_days;
        //                 const cleaning_days_list = [];

        //                 var operators = [];
        //                 operators = response.operators;
        //                 const operators_list = [];

        //                 var auditors = [];
        //                 auditors = response.auditor;
        //                 const auditors_list = [];

        //                 var ops_managers = [];
        //                 ops_managers = response.ops_managers;
        //                 const ops_managers_list = [];

        //                 var invisible_ops_managers = [];
        //                 invisible_ops_managers = response.invisible_ops_managers;
        //                 const invisible_ops_managers_list = [];

        //                 var clients = response.clients;
        //                 const clients_list = [];

        //                 for (let x in cleaning_days) {
        //                     console.log(cleaning_days[x].cleaning_days_id);
        //                     cleaning_days_list.push(cleaning_days[x].cleaning_days_id);
        //                 }
        //                 for (let x in operators) {
        //                     console.log(operators[x].user_id);
        //                     operators_list.push(operators[x].user_id);
        //                 }
        //                 for (let x in auditors) {
        //                     console.log(auditors[x].user_id);
        //                     auditors_list.push(auditors[x].user_id);
        //                 }
        //                 for (let x in invisible_ops_managers) {
        //                     console.log(invisible_ops_managers[x].user_id);
        //                     invisible_ops_managers_list.push(invisible_ops_managers[x].user_id);
        //                 }
        //                 for (let x in ops_managers) {
        //                     console.log(ops_managers[x].user_id);
        //                     ops_managers_list.push(ops_managers[x].user_id);
        //                 }
        //                 for (let x in clients) {
        //                     console.log(clients[x].user_id);
        //                     clients_list.push(clients[x].user_id);
        //                 }

        //                 $("#client_admin_id").val(site.clients_id).trigger('change');
        //                 $("#category_id").val(site.categories_id).trigger('change');
        //                 $("#cleaning_days").val(cleaning_days_list).trigger('change');
        //                 $("#auditor").val(auditors_list).trigger('change');
        //                 $("#compliance").val(response.compliance).trigger('change');
        //                 $("#franchise").val(response.franchisee).trigger('change');
        //                 $("#operator").val(operators_list).trigger('change');
        //                 $("#ops_manager").val(ops_managers_list).trigger('change');
        //                 $("#ini_ops_manager").val(invisible_ops_managers_list).trigger('change');
        //                 $("#client_id").val(clients_list).trigger('change');

        //                 $('#page-loader').hide();
        //             } else {
        //                 $("#session-message").html("");
        //                 $('#page-loader').hide();
        //             }

        //         }
        //     });
        // }


        function createCategory() {
            var category_name = $('#category_name').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#cat-add-btn").html('Please Wait...');
            $("#cat-add-btn").attr("disabled", true);

            console.log("category =" + category_name);
            $.ajax({
                type: "POST",
                url: "{{ url('/category/store') }}",
                data: {
                    category_name: category_name
                },
                dataType: 'json',
                success: function(response) {
                    $('#categorymodalError').text("");
                    $("#cat-add-btn").html('Created');
                    $("#cat-add-btn").attr("disabled", false);
                    $('#categoryModal').modal('hide');

                    $('#category_name').val('');
                    toastr.success('Successfully Added Category!', 'Success Alert', {
                        timeOut: 3000,
                        fadeOut: 1000
                    });
                    load_category();
                },
                error: function(response) {
                    $('#categorymodalError').text(response.responseJSON.errors.category_name);
                    $("#cat-add-btn").html('Try Again');
                    $("#cat-add-btn").attr("disabled", false);
                }
            });
        }
    </script>
@endsection

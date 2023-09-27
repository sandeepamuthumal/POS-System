@extends('admin.layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>

    <div class="container-fluid">
        <!-- Edit Product -->
        <div class="modal fade bd-example-modal-lg" id="edit-product-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Product</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="edit-product-form">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Product Code</label>
                                        <input type="text" name="product_code" id="product_code" class="form-control" readonly>
                                        <span class="text-danger" id="edit_product_codeError"></span>
                                        <input type="text" name="product_id" class="form-control product_id" hidden>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Category</label>
                                        <select name="category" id="category_id" class="single-select form-control wide">
                                            <option value="">Choose...</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->category }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="edit_categoryError"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Product Name</label>
                                        <input type="text" name="product_name" id="product_name" class="form-control">
                                        <span class="text-danger" id="edit_product_nameError"></span>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Quantity</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Description</label>
                                        <textarea name="description" class="form-control" cols="30" rows="10" id="comment"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Price</label>
                                        <input type="text" name="price" id="price" class="form-control">
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Discount</label>
                                        <input type="text" name="discount" id="discount" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Product Image</label>
                                        <input type="file" class="form-file-input form-control p-2" name="product_image"
                                            style="border-radius:15px">
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <div class="product_image" id="product_image">

                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <button type="button" class="btn btn-primary float-end btn-shadow"
                                        id="update-btn">Update</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- row -->



        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>All Products</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs style-2">
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link active">Product Count <span
                                class="badge badge-primary shadow-primary">{{ $all_product_count }}</span></a>
                    </li>
                </ul>
                <a href="{{ route('create_product') }}"
                    class="btn btn-rounded btn-outline-primary shadow btn-sm sharp "><span
                        class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                    </span>Add New</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="example5" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Product Name</th>
                                <th>Code</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $item)
                                <tr>
                                    <td><img class="rounded-circle" width="35"
                                            src="{{ asset('uploads/products/' . $item->image) }}" alt=""></td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->item_code }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ number_format($item->unit_price, 2) }}</td>
                                    <td>{{ $item->available_stock }}</td>
                                    <td>
                                        <a href="javascript:void(0)" data-id="{{ $item->id }}"
                                            class="btn btn-xs btn-primary edit" data-toggle="tooltip" title="Edit"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <button type="button" class="btn btn-xs btn-danger show_confirm"
                                            data-toggle="tooltip" title="Delete"
                                            onclick="deleteData({{ $item->id }})"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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

        .select2-container--open {
            z-index: 9999999
        }
    </style>
@endpush

@section('scripts')
    <script src="./admin/js/sweetalert2@11.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '#show-add-model', function(event) {
            $("#add-btn").html('Create');
            $('#full_nameError').text("");
            $('#nicError').text("");
            $('#contact_Error').text("");
            $('#address_Error').text("");
            $('#add-customer-form').trigger("reset");
            $('#add-customer-modal').modal('show');
            $("#add-btn").attr("disabled", false);
        });


        $('body').on('click', '#add-btn', function(event) {
            let formData = new FormData($('#add-customer-form')[0]);

            $('#page-loader').show();
            $("#add-btn").html('Please Wait...');
            $("#add-btn").attr("disabled", true);

            $('#full_nameError').text("");
            $('#nicError').text("");
            $('#contact_Error').text("");
            $('#address_Error').text("");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            console.log(formData);

            $.ajax({
                type: "POST",
                url: "{{ url('/customer/store') }}",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.code == 200) {
                        $("#add-btn").html('Created');
                        $("#add-btn").attr("disabled", false);
                        $('#add-customer-modal').modal('hide');

                        toastr.success('Successfully Added Customer!', 'Success Alert', {
                            timeOut: 3000,
                            fadeOut: 1000
                        });

                        load_active_customers();


                    } else {
                        toastr.error('Something went wrong!', 'Error Alert', {
                            timeOut: 3000,
                            fadeOut: 1000
                        });
                        $("#add-btn").html('Try Again');
                        $("#add-btn").attr("disabled", false);
                        $('#page-loader').hide();
                    }
                },
                error: function(response) {
                    $('#full_nameError').text(response.responseJSON.errors
                        .full_name);
                    $('#nicError').text(response.responseJSON.errors.nic);
                    $('#contact_Error').text(response.responseJSON.errors.contact);
                    $('#address_Error').text(response.responseJSON.errors.address);

                    $("#add-btn").html('Try Again');
                    $("#add-btn").attr("disabled", false);
                    $('#page-loader').hide();
                }

            });


        });


        $('body').on('click', '.edit', function() {
            var id = $(this).data('id');

            $('#edit-product-modal').modal('show');

            $('#edit_product_nameError').text("");
            $('#edit_product_codeError').text("");
            $('#edit_categoryError').text("");

            $('#page-loader').show();

            // ajax
            $.ajax({
                type: "GET",
                url: "{{ url('/product/edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    var product = response.product;

                    $("#update-btn").html('Update');
                    $('#edit-product-modal').modal('show');
                    $("#product_name").val(product.item_name);
                    $("#product_code").val(product.item_code);
                    $(".product_id").val(product.id);
                    $("#category_id").val(product.categories_id).trigger('change');
                    $("#quantity").val(product.available_stock);
                    $("#comment").val(product.description);
                    $("#price").val(product.unit_price);
                    $("#discount").val(product.discount);
                    $("#product_image").html('<img src="/uploads/products/' + product.image +
                        '" alt="Product Image" title="Product Image">');

                    $('#page-loader').hide();

                }
            });
        });

        $('body').on('click', '#update-btn', function(event) {
            let EditformData = new FormData($('#edit-product-form')[0]);
            $("#update-btn").html('Please Wait...');
            $("#update-btn").attr("disabled", true);
            $('#page-loader').show();

            // ajax
            $.ajax({
                type: "POST",
                url: "{{ url('/product/update') }}",
                data: EditformData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#update-btn").html('Updated');
                    $("#update-btn").attr("disabled", false);
                    $('#edit-product-modal').modal('hide');
                    toastr.success('Successfully Updated Product!', 'Success Alert', {
                        timeOut: 4000,
                        fadeOut: 1000
                    });
                    $('#page-loader').hide();
                    window.location.reload();

                },
                error: function(response) {
                    toastr.error(response.responseJSON.errors, 'Error Alert', {
                        timeOut: 4000,
                        fadeOut: 1000
                    });

                    $('#edit_product_nameError').text(response.responseJSON.errors.product_name);
                    $('#edit_categoryError').text(response.responseJSON.errors.category);
                    $('#edit_product_codeError').text(response.responseJSON.errors.product_code);

                    $("#update-btn").html('Try Again');
                    $("#update-btn").attr("disabled", false);
                    $('#page-loader').hide();
                }
            });
        });


        function deleteData(data) {
            Swal.fire({
                title: 'Are you sure to delete Product?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete It!'
            }).then((result) => {
                if (result.isConfirmed) {

                    let url = '{{ route('delete_product', ':id') }}'
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
                            load_active_customers();
                            Swal.fire(
                                'Deleted!',
                                'This Product has been deleted.',
                                'success'
                            );

                        }
                    });

                    window.location.reload();

                    toastr.success('Successfully Deleted Product!', 'Success Alert', {
                        timeOut: 3000,
                        fadeOut: 1000
                    });
                }
            })
        }
    </script>
@endsection

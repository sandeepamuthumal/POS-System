@extends('admin.layouts.app')

@section('content')

    <div class="container-fluid">
     <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Items</h4>
                    <!-- <button type="button" class="btn btn-rounded btn-outline-primary shadow btn-sm sharp "
                        id="show-add-model"><span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                        </span>Add New Branches</button> -->
                    <button type="button" class="btn btn-rounded btn-outline-primary shadow btn-sm sharp "
                        id="show-add-item-model"><span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                        </span>Add New Items</button>
                    <button type="button" class="btn btn-rounded btn-outline-primary shadow btn-sm sharp "
                        id="show-add-categories-model"><span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                        </span>Add New Categories</button>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="user-table" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Category </th>
                                    <th>Item Name</th>
                                    <th>Unit Price</th>
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

        <!-- Add Branch -->
        <div class="modal fade bd-example-modal-lg" id="add-user-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add New Branch</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="add-branch-form">
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Branch Name</label>
                                        <input type="text" name="branch_name" class="form-control">
                                        <span class="text-danger" id="branch_nameError"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary float-end btn-shadow"
                                        id="add-btn">CREATE</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- row -->

        <!-- Add items -->
        <div class="modal fade bd-example-modal-lg" id="add-item-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add New Items</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="add-item-form">
                            <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Branch</label>
                                        <select id="branch" name="branch"
                                            class="single-select form-control wide">
                                            <option value="">Choose...</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Item Category</label>
                                        <select name="item_catergory" class="single-select form-control wide">
                                            <!-- <option value="" selected hidden>Choose...</option> -->
                                            <option value="">Choose...</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->category }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="category_Error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Item Name</label>
                                        <input type="text" name="item_name" class="form-control">
                                        <span class="text-danger" id="Itmes_nameError"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Item Price</label>
                                        <input type="text" name="item_price"  autocomplete="false"
                                            class="form-control">
                                        <span class="text-danger" id="Itmes_priceError"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-primary float-end btn-shadow"
                                        id="add-item-btn">Create Item</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Add categories -->
        <div class="modal fade bd-example-modal-lg" id="add-categories-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add New Categories</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="add-categories-form">
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Categories Name</label>
                                        <input type="text" name="categories_name" class="form-control">
                                        <span class="text-danger" id="categories_nameError"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary float-end btn-shadow"
                                        id="add-btn-categories">CREATE</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Update item --}}

        <div class="modal fade bd-example-modal-lg" id="edit-item-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">


                <div class="modal-content">


                    <div class="modal-header">
                        <h5 class="modal-title">Update Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="edit-item-form">
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Branch</label>
                                        <select id="branch" name="branch"
                                            class="custom-select form-control wide">
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Categories Name</label>
                                        <select id="category" name="category"
                                            class="custom-select form-control wide">
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Item Name</label>
                                        <input type="text" name="item_name" id="item_name" class="form-control">
                                        <input type="text" name="item_id" class="form-control item_id" hidden>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Item Price</label>
                                        <input type="text" name="item_price" id="item_price" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-primary float-end btn-shadow"
                                    id="btn-save">Update Item</button>
                                </div>
                            </form>
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
</style>
@endpush

@section('scripts')

    <script src="./admin/js/sweetalert2@11.js"></script>
    <script type="text/javascript">
        load_active_items();

        window.addEventListener("load", function() {
            setTimeout(function() {
                document.getElementById("add-password").value = "";
                document.getElementById("login_user_name").value = "";
            }, 500)
        });

        // load items
        function load_active_items() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#page-loader').show();

            $.ajax({
                type: "POST",
                url: "{{ url('/items/load/active') }}",
                dataType: 'json',
                success: function(response) {
                    console.log("active users ..." + response);
                    if (response !== "No-data") {

                        var table = $('#user-table').DataTable({
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
                            columns: [
                                {
                                    data: 'category',
                                    title: 'Category'
                                },
                                {
                                    data: 'item_name',
                                    title: 'Item Name'
                                },
                                {
                                    data: 'unit_price',
                                    title: 'Unit Price'
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

                        document.getElementById("user-table").innerHTML = table;

                    }

                    table.rows().every(function() {
                        this.nodes().to$().removeClass('selected')
                    });

                    $('#page-loader').hide();

                }
            });
        }

        function deleteData(data) {
            Swal.fire({
                title: 'Are you sure to deactivate user?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Deactivate It!'
            }).then((result) => {
                if (result.isConfirmed) {

                    let url = '{{ route('delete_item', ':id') }}'
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
                            load_active_items();
                            Swal.fire(
                                'Deactivated!',
                                'This user has been deactivated.',
                                'success'
                            );

                        }
                    })

                }
            })
        }

        function activateData(data) {
            Swal.fire({
                title: 'Are you sure to activate user?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Activate It!'
            }).then((result) => {
                if (result.isConfirmed) {

                    let url = '{{ route('delete_item', ':id') }}'
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
                            load_active_items();
                            Swal.fire(
                                'Activated!',
                                'This user has been Activated.',
                                'success'
                            );

                        }
                    })

                }
            })
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '.edit', function() {
                var id = $(this).data('id');

                $('#edit-item-modal').modal('show');
                $('#edit-item-form').trigger("reset");

                $('#page-loader').show();

                // ajax
                $.ajax({
                    type: "GET",
                    url: "{{ url('/item/edit') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        var item = response.item;
                        var branchhasitem = response.branchhasitem;
                        console.log(branchhasitem);

                        $("#btn-save").html('Update');
                        $('#edit-item-modal').modal('show');
                        $(".item_id").val(item.id);
                        $("#item_name").val(item.item_name);
                        $("#item_price").val(branchhasitem.unit_price);

                        $('#page-loader').hide();

                    }
                });
            });



            // item stote
            $('body').on('click', '#show-add-item-model', function(event) {
                $("#add-item-btn").html('Create Item');

                $('#add-item-form').trigger("reset");
                $('#add-item-modal').modal('show');
                $("#add-item-btn").attr("disabled", false);
            });

            $('body').on('click', '#add-item-btn', function(event) {
                let formData = new FormData($('#add-item-form')[0]);

                $('#page-loader').show();
                $("#add-item-btn").html('Please Wait...');
                $("#add-item-btn").attr("disabled", true);


                $('#category_Error').text("");
                $('#Itmes_nameError').text("");
                $('#Itmes_priceError').text("");

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('/item/store') }}",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#add-item-btn").html('Item Added');
                        $("#add-item-btn").attr("disabled", false);
                        $('#add-item-modal').modal('hide');
                        toastr.success('Successfully Added !', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $('#page-loader').hide();
                        load_active_items();
                    },
                    error: function(response) {

                        $('#category_Error').text(response.responseJSON.errors.item_catergory);
                        $('#Itmes_nameError').text(response.responseJSON.errors.item_name);
                        $('#Itmes_priceError').text(response.responseJSON.errors.item_price);

                        $("#add-item-btn").html('Try Again');
                        $("#add-item-btn").attr("disabled", false);
                        $('#page-loader').hide();
                    }
                });
            });

            // catagories stote

            $('body').on('click', '#show-add-categories-model', function(event) {
                $("#add-btn").html('Create Item');

                $('#add-categories-form').trigger("reset");
                $('#add-categories-modal').modal('show');
                $("#add-btn").attr("disabled", false);
            });

            $('body').on('click', '#add-btn-categories', function(event) {
                let formData = new FormData($('#add-categories-form')[0]);

                $('#page-loader').show();
                $("#add-btn-categories").html('Please Wait...');
                $("#add-btn-categories").attr("disabled", true);


                $('#categories_nameError').text("");

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('/categorie/store') }}",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#add-btn-categories").html('User Created');
                        $("#add-btn-categories").attr("disabled", false);
                        $('#add-categories-modal').modal('hide');
                        toastr.success('Successfully Added !', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $('#page-loader').hide();
                        load_active_items();
                        $.ajax({
                            url: '/items/load/active',
                            type: 'POST',
                            success: function(data) {
                            location.reload();
                            },
                            error: function(error) {
                            console.error(error);
                            }
                        });
                    },
                    error: function(response) {

                        $('#categories_nameError').text(response.responseJSON.errors.categories_name);

                        $("#add-item-btn").html('Try Again');
                        $("#add-item-btn").attr("disabled", false);
                        $('#page-loader').hide();
                    }
                });
            });

            // branch stote
            $('body').on('click', '#show-add-model', function(event) {
                $("#add-btn").html('Create');

                $('#add-branch-form').trigger("reset");
                $('#add-user-modal').modal('show');
                $("#add-btn").attr("disabled", false);
            });

            $('body').on('click', '#add-btn', function(event) {
                let formData = new FormData($('#add-branch-form')[0]);

                $('#page-loader').show();
                $("#add-btn").html('Please Wait...');
                $("#add-btn").attr("disabled", true);


                $('#branch_nameError').text("");

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('/branch/store') }}",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#add-btn").html('User Created');
                        $("#add-btn").attr("disabled", false);
                        $('#add-user-modal').modal('hide');
                        toastr.success('Successfully Added!', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $('#page-loader').hide();
                        load_active_items();

                        $.ajax({
                            url: '/items/load/active',
                            type: 'POST',
                            success: function(data) {
                            location.reload();
                            },
                            error: function(error) {
                            console.error(error);
                            }
                        });
                    },
                    error: function(response) {

                        $('#branch_nameError').text(response.responseJSON.errors.branch_name);

                        $("#add-btn").html('Try Again');
                        $("#add-btn").attr("disabled", false);
                        $('#page-loader').hide();
                    }
                });
            });

            // update item

            $('body').on('click', '#btn-save', function(event) {
                let EditformData = new FormData($('#edit-item-form')[0]);
                $("#btn-save").html('Please Wait...');
                $("#btn-save").attr("disabled", true);
                $('#page-loader').show();

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('/item/update') }}",
                    data: EditformData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.code == 200) {
                            $("#btn-save").html('Updated');
                            $("#btn-save").attr("disabled", false);
                            $('#edit-item-modal').modal('hide');
                            toastr.success('Successfully Updated User!', 'Success Alert', {
                                timeOut: 4000,
                                fadeOut: 1000
                            });
                            $('#page-loader').hide();
                            load_active_items();
                        } else {
                            toastr.error(response.message, 'Error Alert', {
                                timeOut: 4000,
                                fadeOut: 1000
                            });
                            $("#btn-save").html('Try Again');
                            $("#btn-save").attr("disabled", false);
                            $('#page-loader').hide();
                        }

                    },
                    error: function(response) {
                        console.log(response.responseJSON.errors);
                        toastr.error(response.responseJSON.errors, 'Error Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $("#btn-save").html('Try Again');
                        $("#btn-save").attr("disabled", false);
                        $('#page-loader').hide();
                    }
                });
            });
        });

    </script>
@endsection

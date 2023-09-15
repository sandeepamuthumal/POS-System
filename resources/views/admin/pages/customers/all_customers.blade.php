@extends('admin.layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>


    <div class="container-fluid">

        <!-- Add User -->
        <div class="modal fade bd-example-modal-lg" id="add-customer-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add New Customer</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="add-customer-form">


                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Full Name</label>
                                        <input type="text" name="full_name" class="form-control">
                                        <span class="text-danger" id="full_nameError"></span>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Address</label>
                                        <input type="text" name="address" class="form-control">
                                        <span class="text-danger" id="address_Error"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">NIC Number</label>
                                        <input type="text" name="nic" class="form-control">
                                        <span class="text-danger" id="nicError"></span>
                                    </div>


                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Contact Number</label>
                                        <input type="text" name="contact" class="form-control">
                                        <span class="text-danger" id="contact_Error"></span>
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


        <!-- Edit Customer -->
        <div class="modal fade bd-example-modal-lg" id="edit-customer-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Customer</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="edit-customer-form">


                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Full Name</label>
                                        <input type="text" name="full_name" id="full_name" class="form-control">
                                        <span class="text-danger" id="edit_full_nameError"></span>
                                        <input type="text" name="customer_id" class="form-control customer_id" hidden>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Address</label>
                                        <input type="text" name="address" id="address" class="form-control">
                                        <span class="text-danger" id="edit_address_Error"></span>
                                    </div>
                                </div>

                                <div class="row">


                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">NIC Number</label>
                                        <input type="text" name="nic" id="nic" class="form-control">
                                        <span class="text-danger" id="edit_nicError"></span>
                                    </div>


                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Contact Number</label>
                                        <input type="text" name="contact" id="contact" class="form-control">
                                        <span class="text-danger" id="edit_contact_Error"></span>
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
                    <h4>All Customers</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs style-2">
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link active">All Customers <span
                                class="badge badge-primary shadow-primary">{{ $all_customer_count }}</span></a>
                    </li>
                </ul>
                <button id="show-add-model" class="btn btn-rounded btn-outline-primary shadow btn-sm sharp "><span
                        class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                    </span>Add New</button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="customer-table" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>NIC Number</th>
                                <th>Contact Number</th>
                                <th>Status</th>
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
@endsection

@section('scripts')
    <script src="./admin/js/sweetalert2@11.js"></script>
    <script type="text/javascript">
        load_active_customers();

        function load_active_customers() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#page-loader').show();

            $.ajax({
                type: "GET",
                url: "{{ url('/customers/all') }}",
                dataType: 'json',
                success: function(response) {

                    if (response !== "No-data") {

                        var table = $('#customer-table').DataTable({
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
                                    data: 'count',
                                    title: '#'
                                },
                                {
                                    data: 'full_name',
                                    title: 'Full Name'
                                },
                                {
                                    data: 'nic',
                                    title: 'NIC Number'
                                },
                                {
                                    data: 'contact_no',
                                    title: 'Contact Number'
                                },
                                {
                                    data: 'status',
                                    title: 'Status'
                                },
                                {
                                    data: 'action',
                                    title: 'Action'
                                },

                            ]

                        });

                    } else {

                        var table =
                            "<tr class=\"odd\"><td valign=\"top\" colspan=\"6\" class=\"dataTables_empty\">No active Customers available in table</td></tr>";

                        document.getElementById("customer-table").innerHTML = table;

                    }

                    table.rows().every(function() {
                        this.nodes().to$().removeClass('selected')
                    });

                    $('#page-loader').hide();

                }
            });
        }

        $(document).ready(function() {
            $('.select2').select2(); // Initialize select2 on elements with select2 class
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

            $('#edit-customer-modal').modal('show');

            $('#edit_full_nameError').text("");
            $('#edit_nicError').text("");
            $('#edit_contact_Error').text("");
            $('#edit_address_Error').text("");


            $('#page-loader').show();

            // ajax
            $.ajax({
                type: "GET",
                url: "{{ url('/customer/edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    var customer = response.customer;
                    console.log(customer.address);

                    $("#update-btn").html('Update');
                    $('#edit-customer-modal').modal('show');
                    $("#full_name").val(customer.customer_name);
                    $(".customer_id").val(customer.id);
                    $("#nic").val(customer.nic);
                    $("#contact").val(customer.phone);
                    $("#address").val(customer.address);

                    $('#page-loader').hide();

                }
            });
        });

        $('body').on('click', '#update-btn', function(event) {
            let EditformData = new FormData($('#edit-customer-form')[0]);
            $("#update-btn").html('Please Wait...');
            $("#update-btn").attr("disabled", true);
            $('#page-loader').show();

            // ajax
            $.ajax({
                type: "POST",
                url: "{{ url('/customer/update') }}",
                data: EditformData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.code == 200) {
                        $("#update-btn").html('Updated');
                        $("#update-btn").attr("disabled", false);
                        $('#edit-customer-modal').modal('hide');
                        toastr.success('Successfully Updated Customer!', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $('#page-loader').hide();
                        load_active_customers();
                    } else {
                        toastr.error(response.message, 'Error Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $("#update-btn").html('Try Again');
                        $("#update-btn").attr("disabled", false);
                        $('#page-loader').hide();
                    }

                },
                error: function(response) {
                    console.log(response.responseJSON.errors);
                    toastr.error(response.responseJSON.errors, 'Error Alert', {
                        timeOut: 4000,
                        fadeOut: 1000
                    });

                    $('#edit_full_nameError').text(response.responseJSON.errors
                        .full_name);
                    $('#edit_nicError').text(response.responseJSON.errors.nic);
                    $('#edit_contact_Error').text(response.responseJSON.errors.contact);
                    $('#edit_address_Error').text(response.responseJSON.errors.address);

                    $("#update-btn").html('Try Again');
                    $("#update-btn").attr("disabled", false);
                    $('#page-loader').hide();
                }
            });
        });


        function deleteData(data) {
            Swal.fire({
                title: 'Are you sure to deactivate Customer?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Deactivate It!'
            }).then((result) => {
                if (result.isConfirmed) {

                    let url = '{{ route('delete_customer', ':id') }}'
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
                                'Deactivated!',
                                'This Customer has been deactivated.',
                                'success'
                            );

                        }
                    })

                }
            })
        }
    </script>
@endsection


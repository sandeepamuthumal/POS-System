@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Add User -->
        <div class="modal fade bd-example-modal-lg" id="add-user-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add New User</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="add-user-form">
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">User Type</label>
                                        <select name="user_type" class="custom-select form-control wide">
                                            <option value="" selected hidden>Choose...</option>
                                            @foreach ($user_types as $item)
                                                <option value="{{ $item->id }}">{{ $item->type }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="user_levelError"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Full Name</label>
                                        <input type="text" name="full_name" class="form-control">
                                        <span class="text-danger" id="full_nameError"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Email</label>
                                        <input type="email" name="email" class="form-control">
                                        <span class="text-danger" id="emailError"></span>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">User Name</label>
                                        <input type="text" name="user_name" class="form-control" id="login_user_name">
                                        <span class="text-danger" id="user_nameError"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Password</label>
                                        <div class="input-group transparent-append">
                                            <input type="password" class="form-control" id="add-password" name="password"
                                                required>
                                            <span class="input-group-text show-pass">
                                                <i class="fa fa-eye-slash"></i>
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                        <span class="text-danger" id="passwordError"></span>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Confirm Password</label>
                                        <div class="input-group show_hide_password">
                                            <input type="password" id="confirm_password" name="confirm_password"
                                                class="form-control" data-toggle="confirmpassword"
                                                placeholder="Confirm password here.." onkeyup="checkPassword()">

                                        </div>
                                        <span class="text-danger" id="confirm_passwordError"></span>
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

        {{-- Update User --}}

        <div class="modal fade bd-example-modal-lg" id="edit-user-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">


                <div class="modal-content">


                    <div class="modal-header">
                        <h5 class="modal-title">Update User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="edit-user-form">
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">User Type</label>
                                        <select id="user_level" name="user_type" class="custom-select form-control wide">
                                            @foreach ($user_types as $item)
                                                <option value="{{ $item->id }}">{{ $item->type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Full Name</label>
                                        <input type="text" name="full_name" id="full_name" class="form-control">
                                        <input type="text" name="user_id" class="form-control user_id" hidden>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Email</label>
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">User Name</label>
                                        <input type="text" name="user_name" id="user_name" autocomplete="false"
                                            class="form-control">
                                    </div>
                            </form>

                            <div class="mb-3 col-md-6">
                                <div class="accordion accordion-header-shadow accordion-rounded mt-2" id="accordion-ten">
                                    <div class="accordion-item">
                                        <div class="accordion-header collapsed rounded-lg" id="accord-10Three"
                                            data-bs-toggle="collapse" data-bs-target="#collapse10Three"
                                            aria-controls="collapse9Three" aria-expanded="true" role="button">
                                            <span class="accordion-header-icon"></span>
                                            <span class="accordion-header-text">Do you want to reset password ?</span>
                                            <span class="accordion-header-indicator"></span>
                                        </div>
                                        <div id="collapse10Three" class="collapse accordion__body"
                                            aria-labelledby="accord-10Three" data-bs-parent="#accordion-ten">
                                            <div class="accordion-body-text">
                                                <form name="userForm" class="form-horizontal" id="password_form">
                                                    <input type="text" hidden class="user_id" name="user_id">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">

                                                            <div class="form-group">
                                                                <label class="form-label">Old Password :</label>
                                                                <div class="input-group transparent-append">
                                                                    <input type="password" class="form-control"
                                                                        id="old_password" name="old_password"
                                                                        placeholder="Enter Current Password" required>
                                                                    <span class="input-group-text show-old-password">
                                                                        <i class="fa fa-eye-slash"></i>
                                                                        <i class="fa fa-eye"></i>
                                                                    </span>
                                                                    <span class="text-danger" id="passwordError"></span>
                                                                </div>


                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">New Password :</label>
                                                                <div class="input-group transparent-append">
                                                                    <input type="password" class="form-control"
                                                                        id="new_password" placeholder="Enter New Password"
                                                                        required>
                                                                    <span class="input-group-text show-new-password">
                                                                        <i class="fa fa-eye-slash"></i>
                                                                        <i class="fa fa-eye"></i>
                                                                    </span>
                                                                    <span class="text-danger" id="passwordError"></span>
                                                                </div>


                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Confirm Password :</label>
                                                                <div class="input-group transparent-append">
                                                                    <input type="password" class="form-control"
                                                                        id="new_confirm_password"
                                                                        placeholder="Reenter your new password" required>
                                                                    <span
                                                                        class="input-group-text show-new-confirm-password">
                                                                        <i class="fa fa-eye-slash"></i>
                                                                        <i class="fa fa-eye"></i>
                                                                    </span>
                                                                    <span class="text-danger" id="passwordError"></span>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>
                                                <button type="button" class="btn btn-primary btn-sm submit-btn w-4"
                                                    id="password-save">Change</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label text-black font-w500">Password</label>
                                <div class="input-group transparent-append">
                                    <input type="password" class="form-control user_password" autocomplete="false"
                                        id="users-password" name="password" required readonly>
                                    <span class="input-group-text show-users-password">
                                        <i class="fa fa-eye-slash"></i>
                                        <i class="fa fa-eye"></i>
                                    </span>
                                    <span class="text-danger" id="passwordError"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary float-end btn-shadow"
                                id="btn-save">Update</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>


    </div>

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Active Users</h4>
                    <button type="button" class="btn btn-rounded btn-outline-primary shadow btn-sm sharp "
                        id="show-add-model"><span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                        </span>Add New</button>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="user-table" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>User Type</th>
                                    <th>Full Name</th>
                                    <th>User Name</th>
                                    <th>Email </th>
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


    </div>
@endsection

@push('css')
    <style>
        .show-users-password {
            cursor: pointer
        }

        .show-users-password .fa-eye {
            display: none
        }

        .show-users-password.active .fa-eye-slash {
            display: none
        }

        .show-users-password.active .fa-eye {
            display: inline-block
        }

        .show-old-password {
            cursor: pointer
        }

        .show-old-password .fa-eye {
            display: none
        }

        .show-old-password.active .fa-eye-slash {
            display: none
        }

        .show-old-password.active .fa-eye {
            display: inline-block
        }

        .show-new-password {
            cursor: pointer
        }

        .show-new-password .fa-eye {
            display: none
        }

        .show-new-password.active .fa-eye-slash {
            display: none
        }

        .show-new-password.active .fa-eye {
            display: inline-block
        }

        .show-new-confirm-password {
            cursor: pointer
        }

        .show-new-confirm-password .fa-eye {
            display: none
        }

        .show-new-confirm-password.active .fa-eye-slash {
            display: none
        }

        .show-new-confirm-password.active .fa-eye {
            display: inline-block
        }
    </style>
@endpush

@section('scripts')
    <script src="./admin/js/sweetalert2@11.js"></script>
    <script type="text/javascript">
        load_active_users();

        window.addEventListener("load", function() {
            setTimeout(function() {
                document.getElementById("add-password").value = "";
                document.getElementById("login_user_name").value = "";
            }, 500)
        });

        $('.show-pass').on('click', function() {
            $(this).toggleClass('active');
            if ($('#add-password').attr('type') == 'password') {
                $('#add-password').attr('type', 'text');
            } else if (jQuery('#add-password').attr('type') == 'text') {
                $('#add-password').attr('type', 'password');
            }
        });

        $('.show-users-password').on('click', function() {
            $(this).toggleClass('active');
            if ($('#users-password').attr('type') == 'password') {
                $('#users-password').attr('type', 'text');
            } else if (jQuery('#users-password').attr('type') == 'text') {
                $('#users-password').attr('type', 'password');
            }
        });

        $('.show-old-password').on('click', function() {
            $(this).toggleClass('active');
            if ($('#old_password').attr('type') == 'password') {
                $('#old_password').attr('type', 'text');
            } else if (jQuery('#old_password').attr('type') == 'text') {
                $('#old_password').attr('type', 'password');
            }
        });

        $('.show-new-password').on('click', function() {
            $(this).toggleClass('active');
            if ($('#new_password').attr('type') == 'password') {
                $('#new_password').attr('type', 'text');
            } else if (jQuery('#new_password').attr('type') == 'text') {
                $('#new_password').attr('type', 'password');
            }
        });

        $('.show-new-confirm-password').on('click', function() {
            $(this).toggleClass('active');
            if ($('#new_confirm_password').attr('type') == 'password') {
                $('#new_confirm_password').attr('type', 'text');
            } else if (jQuery('#new_confirm_password').attr('type') == 'text') {
                $('#new_confirm_password').attr('type', 'password');
            }
        });

        function load_active_users() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#page-loader').show();

            $.ajax({
                type: "POST",
                url: "{{ url('/users/load/active') }}",
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
                            columns: [{
                                    data: 'type',
                                    title: 'User Type'
                                },
                                {
                                    data: 'full_name',
                                    title: 'Full Name'
                                },
                                {
                                    data: 'user_name',
                                    title: 'User Name'
                                },
                                {
                                    data: 'email',
                                    title: 'Email'
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

                    let url = '{{ route('delete_users', ':id') }}'
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
                            load_active_users();
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

                    let url = '{{ route('delete_users', ':id') }}'
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
                            load_active_users();
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

        function editUser($id) {
            $.ajax({
                type: "GET",
                url: "{{ url('/users/edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    var user = response.user;

                    $("#btn-save").html('Update');
                    $(".user_id").val(user.id);
                    $("#full_name").val(user.full_name);
                    $("#email").val(user.email);
                    $("#users-password").val(response.password);
                    $("#user_level").val(user.user_types_id);
                    $("#user_name").val(user.user_name);

                    $('#page-loader').hide();

                }
            });
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '.edit', function() {
                var id = $(this).data('id');

                $('#edit-user-modal').modal('show');
                $('#password_form').trigger("reset");

                $('#page-loader').show();

                // ajax
                $.ajax({
                    type: "GET",
                    url: "{{ url('/users/edit') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        var user = response.user;

                        $("#btn-save").html('Update');
                        $('#edit-user-modal').modal('show');
                        $(".user_id").val(user.id);
                        $("#full_name").val(user.full_name);
                        $("#email").val(user.email);
                        $("#users-password").val(response.password);
                        $("#user_level").val(user.user_types_id);
                        $("#user_name").val(user.user_name);

                        $('#page-loader').hide();

                    }
                });
            });

            $('body').on('click', '#password-save', function(event) {
                console.log($(".user_id").val());
                var id = $(".user_id").val();
                var old_password = $("#old_password").val();
                var new_password = $("#new_password").val();
                var confirm_password = $("#new_confirm_password").val();
                $("#password-save").html('Please Wait...');
                $("#password-save").attr("disabled", true);

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('/users/change/password') }}",
                    data: {
                        id: id,
                        old_password: old_password,
                        new_password: new_password,
                        confirm_password: confirm_password,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            $("#password-save").html('Updated');
                            $("#password-save").attr("disabled", false);
                            toastr.success('Successfully Changed Password!', 'Success Alert', {
                                timeOut: 4000,
                                fadeOut: 1000
                            });
                            $('#password_form').trigger("reset");
                            $("#password-save").html('Change');
                            load_active_users();
                            $("#users-password").val(new_password);
                        }
                        if (response.status == 400) {
                            toastr.error(response.msg, 'Error Alert', {
                                timeOut: 4000,
                                fadeOut: 1000
                            });
                            $("#password-save").html('Try Again');
                            $("#password-save").attr("disabled", false);
                        }

                    },
                    error: function(data) {
                        toastr.error('All fields are required and password field minimum of 6!',
                            'Error Alert', {
                                timeOut: 4000,
                                fadeOut: 1000
                            });
                        $("#password-save").html('Try Again');
                        $("#password-save").attr("disabled", false);
                    }
                });
            });

            $('body').on('click', '#show-add-model', function(event) {
                $("#add-btn").html('Create');

                $('#confirm_passwordError').text("");
                $('#passwordError').text("");
                $('#full_nameError').text("");
                $('#emailError').text("");
                $('#user_nameError').text("");
                $('#user_levelError').text("");

                document.getElementById("add-password").value = "";
                document.getElementById("login_user_name").value = "";

                $('#add-user-form').trigger("reset");
                $('#add-user-modal').modal('show');
                $("#add-btn").attr("disabled", false);
            });

            $('body').on('click', '#add-btn', function(event) {
                let formData = new FormData($('#add-user-form')[0]);

                $('#page-loader').show();
                $("#add-btn").html('Please Wait...');
                $("#add-btn").attr("disabled", true);

                $('#confirm_passwordError').text("");
                $('#passwordError').text("");
                $('#full_nameError').text("");
                $('#emailError').text("");
                $('#user_nameError').text("");
                $('#user_levelError').text("");

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('/users/store') }}",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#add-btn").html('User Created');
                        $("#add-btn").attr("disabled", false);
                        $('#add-user-modal').modal('hide');
                        toastr.success('Successfully Added User!', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $('#page-loader').hide();
                        load_active_users();
                    },
                    error: function(response) {
                        $('#confirm_passwordError').text(response.responseJSON.errors
                            .confirm_password);
                        $('#emailError').text(response.responseJSON.errors.email);
                        $('#passwordError').text(response.responseJSON.errors.password);
                        $('#user_levelError').text(response.responseJSON.errors.user_level);
                        $('#user_nameError').text(response.responseJSON.errors.user_name);
                        $('#full_nameError').text(response.responseJSON.errors.full_name);

                        $("#add-btn").html('Try Again');
                        $("#add-btn").attr("disabled", false);
                        $('#page-loader').hide();
                    }
                });
            });

            $('body').on('click', '#btn-save', function(event) {
                let EditformData = new FormData($('#edit-user-form')[0]);
                $("#btn-save").html('Please Wait...');
                $("#btn-save").attr("disabled", true);
                $('#page-loader').show();

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('/users/update') }}",
                    data: EditformData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.code == 200) {
                            $("#btn-save").html('Updated');
                            $("#btn-save").attr("disabled", false);
                            $('#edit-user-modal').modal('hide');
                            toastr.success('Successfully Updated User!', 'Success Alert', {
                                timeOut: 4000,
                                fadeOut: 1000
                            });
                            $('#page-loader').hide();
                            load_active_users();
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




@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Deactive Customers</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="deactive-customer-table" class="display" style="min-width: 845px">
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


    </div>
@endsection


@section('scripts')
    <script src="./admin/js/sweetalert2@11.js"></script>

    <script type="text/javascript">
        load_deactive_customers();

        function load_deactive_customers() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#page-loader').show();

            $.ajax({
                type: "POST",
                url: "{{ url('/customers/load/deactive') }}",
                dataType: 'json',
                success: function(response) {
                    console.log("deactive customers ..." + response);
                    if (response !== "No-data") {

                        var deactivetable = $('#deactive-customer-table').DataTable({
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
                                    data: 'contact',
                                    title: 'Contact Number'
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

                        var deactivetable =
                            "<tr class=\"odd\"><td valign=\"top\" colspan=\"5\" class=\"dataTables_empty\">No deactive customers available in table</td></tr>";

                        document.getElementById("deactive-customer-table").innerHTML = table;

                    }

                    deactivetable.rows().every(function() {
                        this.nodes().to$().removeClass('selected')
                    });

                    $('#page-loader').hide();

                }
            });
        }

        function activateData(data) {
            Swal.fire({
                title: 'Are you sure to activate Customer?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Activate It!'
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
                            load_deactive_customers();
                            Swal.fire(
                                'Activated!',
                                'This Customer has been Activated.',
                                'success'
                            );

                        }
                    })

                }
            })
        }
    </script>
@endsection

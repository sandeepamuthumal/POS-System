@extends('admin.layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>

    <div class="container-fluid">

        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>All Sales</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example5" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>Sale Code</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $item)
                                @php
                                    if ($item->customers_id == null) {
                                        $customer = 'Unknown';
                                    } else {
                                        $customer_data = DB::table('customers')
                                            ->where('id', $item->customers_id)
                                            ->select('customer_name')
                                            ->first();
                                        $customer = $customer_data->customer_name;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $item->sale_code }}</td>
                                    <td>{{ $customer }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->sale_date)->format('d/m/Y') }}</td>
                                    <td>{{ number_format($item->sale_total, 2) }}</td>
                                    <td>
                                        @if ($item->status == 1)
                                            <span class="badge badge-md light badge-success" style="">Completed</span>
                                        @else
                                            <span class="badge badge-md light badge-danger" style="">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('sales/receipt/view', $item->id) }}" target="_blank" type="button"
                                            class="btn btn-xs btn-warning" data-toggle="tooltip" title="Print Receipt"><i
                                                class="fa fa-print"></i></a>
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

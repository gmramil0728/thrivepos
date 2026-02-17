@extends('admin_dashboard')
@section('admin')
<div class="content">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Sales & Profit Report</h4>
                    <form action="{{ route('sales.report') }}" method="GET" class="row g-2 mb-3 d-print-none">
                        <div class="col-md-3">
                            <input type="date" name="start_date" class="form-control" value="{{ $start_date }}">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="end_date" class="form-control" value="{{ $end_date }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Generate Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card widget-flat border-start border-success border-4">
                    <div class="card-body">
                        <p class="text-muted fw-bold text-uppercase mb-1">Gross Sales</p>
                        <h3 class="mb-0 text-success">₱{{ number_format($totalSales, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card widget-flat border-start border-danger border-4">
                    <div class="card-body">
                        <p class="text-muted fw-bold text-uppercase mb-1">Expenses</p>
                        <h3 class="mb-0 text-danger">₱{{ number_format($totalExpenses, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card widget-flat border-start border-warning border-4">
                    <div class="card-body">
                        <p class="text-muted fw-bold text-uppercase mb-1">Payroll</p>
                        <h3 class="mb-0 text-warning">₱{{ number_format($totalSalary, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card widget-flat border-0 {{ $netProfit >= 0 ? 'bg-success' : 'bg-danger' }} text-white">
                    <div class="card-body">
                        <p class="text-white-50 fw-bold text-uppercase mb-1">Net Profit</p>
                        <h3 class="mb-0 text-white">₱{{ number_format($netProfit, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Order Details</h4>
                        <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Invoice No</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th class="text-end">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->order_date }}</td>
                                    <td><span class="badge badge-soft-info">{{ $order->invoice_no }}</span></td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td><span class="badge bg-success">{{ $order->order_status }}</span></td>
                                    <td class="text-end fw-bold">₱{{ number_format((float)$order->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('jscripts')
<script>
    $(document).ready(function() {
        if ($('#basic-datatable').length > 0) {
            $('#basic-datatable').DataTable({
                "searching": false, // This disables the search feature
                "pageLength": 10,
                // "order": [[2, "desc"]],
                "dom": '<"d-flex justify-content-between align-items-center mb-3"f><"table-responsive"t><"d-flex justify-content-between align-items-center mt-3"ip>',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search ledger...",
                    "info": "Showing _START_–_END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries found",
                    "emptyTable": "No records available",
                    "paginate": {
                        "previous": "<i class='mdi mdi-chevron-left'></i>",
                        "next":     "<i class='mdi mdi-chevron-right'></i>"
                    }
                },
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                }
            });
        }
    });
</script>
@endsection
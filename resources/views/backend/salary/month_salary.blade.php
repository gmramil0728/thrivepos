@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <div class="d-flex gap-2">
                            <form action="{{ route('payroll.report.pdf') }}" method="GET" target="_blank">
                                <input type="hidden" name="month" value="{{ request('month') }}">
                                <input type="hidden" name="year" value="{{ request('year') }}">
                                <input type="hidden" name="method" value="{{ request('method') }}">
                                
                                <button type="submit" class="btn btn-danger rounded-pill waves-effect">
                                    <i class="mdi mdi-file-pdf-outline me-1"></i> Export PDF Report
                                </button>
                            </form>
                    
                            <a href="{{ route('pay.salary') }}" class="btn btn-secondary rounded-pill waves-effect">
                                <i class="mdi mdi-arrow-left me-1"></i> Back to Payroll
                            </a>
                        </div>
                    </div>
                    <h4 class="page-title">Disbursement History</h4>
                </div>
            </div>
        </div>     

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">
                        <form action="{{ route('month.salary') }}" method="GET" id="filter-form">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Pay Month</label>
                                    <select name="month" class="form-select border-primary">
                                        <option value="">All Months</option>
                                        @foreach(range(1, 12) as $m)
                                            @php $monthName = date('F', mktime(0, 0, 0, $m, 1)); @endphp
                                            <option value="{{ $monthName }}" {{ request('month') == $monthName ? 'selected' : '' }}>
                                                {{ $monthName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Year</label>
                                    <select name="year" class="form-select border-primary">
                                        <option value="2026" {{ request('year') == '2026' ? 'selected' : '' }}>2026</option>
                                        <option value="2025" {{ request('year') == '2025' ? 'selected' : '' }}>2025</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Payment Method</label>
                                    <select name="method" class="form-select border-primary">
                                        <option value="">All Methods</option>
                                        <option value="Cash" {{ request('method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="Bank Transfer" {{ request('method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="Check" {{ request('method') == 'Check' ? 'selected' : '' }}>Check</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-filter-variant me-1"></i> Apply Filters
                                    </button>
                                    <a href="{{ route('month.salary') }}" class="btn btn-light waves-effect">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100 table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sl</th>
                                        <th>Reference</th>
                                        <th>Employee</th>
                                        <th>Pay Period</th>
                                        <th>Method</th>
                                        <th>Net Paid</th>
                                        <th>Status</th>
                                        <th class="text-center d-print-none">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paidsalary as $key=> $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td><code class="text-primary fw-bold">{{ $item->transaction_id }}</code></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($item->employee->image) }}" class="rounded-circle me-2 border" style="width:35px; height: 35px; object-fit: cover;">
                                                <div>
                                                    <span class="fw-medium d-block text-dark">{{ $item->employee->name }}</span>
                                                    <small class="text-muted">{{ $item->employee->designation ?? 'Staff' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-dark">{{ $item->salary_month }}</span> 
                                            <small class="text-muted">{{ $item->salary_year }}</small>
                                        </td>
                                        <td>{{ $item->payment_method }}</td>
                                        <td class="fw-bold text-dark">₱{{ number_format($item->paid_amount, 2) }}</td>
                                        <td><span class="badge bg-soft-success text-success border border-success px-2">Disbursed</span></td>
                                        <td class="text-center d-print-none">
                                            
                                            <a href="{{ route('view.payslip', $item->id) }}" class="btn btn-sm btn-outline-primary shadow-sm">
                                                <i class="mdi mdi-printer"></i> Slip
                                            </a>

                                            <a href="{{ route('payslip.download', $item->id) }}" class="btn btn-danger btn-sm" title="Download PDF">
                                                <i class="fa fa-file-pdf"></i> PDF Report
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="5" class="text-end">Total Disbursed:</th>
                                        <th colspan="3" class="text-primary">₱{{ number_format($paidsalary->sum('paid_amount'), 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .left-side-menu, .navbar-custom, .footer, .btn, .page-title-right, #filter-form, .d-print-none {
        display: none !important;
    }
    .content-page { margin-left: 0 !important; }
    .card { border: none !important; shadow: none !important; }
    .table-responsive { overflow: visible !important; }
}
</style>

@endsection
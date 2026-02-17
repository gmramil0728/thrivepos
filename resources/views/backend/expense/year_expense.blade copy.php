@extends('admin_dashboard')
@section('admin')

<style>
    /* Professional UI Enhancements */
    .card { border: none; border-radius: 15px; }
    .bg-gradient-primary { 
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); 
        border-radius: 20px;
    }
    .form-floating > .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
    }
    .form-floating > label { color: #94a3b8; }
    
    /* Modern Table Styling */
    #basic-datatable { border-collapse: separate; border-spacing: 0; }
    #basic-datatable thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #64748b;
        padding: 15px;
        border-bottom: 2px solid #edf2f7;
    }
    #basic-datatable tbody td { 
        padding: 18px 15px; 
        border-bottom: 1px solid #f1f5f9;
    }
    .ref-code {
        font-family: 'Monaco', 'Consolas', monospace;
        font-size: 0.85rem;
        background: #f1f5f9;
        padding: 4px 8px;
        border-radius: 6px;
    }
    .amount-text { font-weight: 700; color: #1e293b; font-size: 1rem; }

    @media print {
        .d-print-none, .btn, .dataTables_filter, .dataTables_length, .dataTables_paginate { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row align-items-center mb-4 pt-3">
            <div class="col">
                <h4 class="fw-bold mb-1">Expense Management</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Financials</a></li>
                        <li class="breadcrumb-item active">{{ request('start_date') ? 'Filtered Report' : 'Annual Overview' }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto d-print-none">
                <a href="{{ route('add.expense') }}" class="btn btn-primary rounded-pill px-4 shadow">
                    <i class="mdi mdi-plus me-1"></i> Add Expense
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="card bg-gradient-primary text-white mb-4 shadow-lg border-0">
                    <div class="card-body p-4 text-center">
                        <div class="avatar-md bg-white-50 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                            <i class="mdi mdi-currency-php font-24 text-white"></i>
                        </div>
                        <p class="text-white-50 text-uppercase fw-bold mb-1 small">Total Period Expenditure</p>
                        <h2 class="fw-bold mb-0">₱{{ number_format($totalAmount ?? 0, 2) }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body p-4">
                        <h6 class="text-uppercase fw-bold mb-3 small text-muted">Quick Filter</h6>
                        <form action="{{ route('year.expense') }}" method="GET">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" name="search_details" class="form-control" id="searchD" placeholder="Search..." value="{{ request('search_details') }}">
                                        <label for="searchD"><i class="mdi mdi-magnify me-1"></i>Search Description</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="date" name="start_date" class="form-control" id="startD" value="{{ request('start_date') }}">
                                        <label for="startD">From Date</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="date" name="end_date" class="form-control" id="endD" value="{{ request('end_date') }}">
                                        <label for="endD">To Date</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex h-100 gap-2">
                                        <button type="submit" class="btn btn-dark w-100 rounded-3">Filter</button>
                                        <a href="{{ route('year.expense') }}" class="btn btn-outline-light w-100 rounded-3 border text-dark">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                <h5 class="fw-bold mb-0">Transaction Ledger</h5>
                <button onclick="window.print()" class="btn btn-sm btn-light border d-print-none">
                    <i class="mdi mdi-printer me-1"></i> Print
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatable" class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Reference</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th class="text-end">Amount</th>
                                <th class="text-center d-print-none">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($yearexpense as $key=> $item)
                            <tr>
                                <td><span class="text-muted small">#{{ $key+1 }}</span></td>
                                <td><span class="ref-code text-primary">{{ $item->reference_no ?? 'REF-UNA' }}</span></td>
                                <td class="fw-medium text-dark">{{ date('M d, Y', strtotime($item->date)) }}</td>
                                <td class="text-muted">{{ \Illuminate\Support\Str::limit($item->details, 60) }}</td>
                                <td class="text-end amount-text">₱{{ number_format($item->amount, 2) }}</td>
                                <td class="text-center d-print-none">
                                    <div class="btn-group">
                                        <a href="{{ route('edit.expense', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-start">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <a href="{{ route('delete.expense', $item->id) }}" class="btn btn-sm btn-outline-danger rounded-end" id="delete">
                                            <i class="mdi mdi-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light-subtle">
                            <tr>
                                <td colspan="4" class="text-end py-3 text-muted fw-bold">TOTAL EXPENDITURE:</td>
                                <td class="text-end px-3 py-3 text-primary h4 mb-0 fw-bold">₱{{ number_format($totalAmount ?? 0, 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
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
                "pageLength": 10,
                "order": [[2, "desc"]], // Newest transactions first
                "dom": '<"d-flex justify-content-between mb-2"f>rt<"d-flex justify-content-between mt-2"ip>',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search ledger...",
                    "paginate": {
                        "previous": "<i class='mdi mdi-chevron-left'>",
                        "next": "<i class='mdi mdi-chevron-right'>"
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
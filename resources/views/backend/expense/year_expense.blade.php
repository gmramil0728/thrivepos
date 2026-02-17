@extends('admin_dashboard')
@section('admin')

{{-- <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"> --}}

<style>
    /* ── Design Tokens ─────────────────────────────────── */
    :root {
        --ink:          #0d0f14;
        --ink-2:        #1c2033;
        --ink-3:        #2e3248;
        --slate:        #64748b;
        --slate-light:  #94a3b8;
        --line:         #e8edf5;
        --line-soft:    #f1f5fb;
        --surface:      #f7f9fc;
        --accent:       #3b5bdb;
        --accent-glow:  rgba(59,91,219,0.13);
        --accent-light: #eef2ff;
        --danger:       #e03131;
        --danger-light: #fff5f5;
        --shadow-sm:    0 1px 3px rgba(15,23,42,0.06), 0 1px 2px rgba(15,23,42,0.04);
        --shadow-md:    0 4px 16px rgba(15,23,42,0.08), 0 2px 6px rgba(15,23,42,0.04);
        --shadow-lg:    0 12px 40px rgba(15,23,42,0.12), 0 4px 12px rgba(15,23,42,0.06);
        --radius:       14px;
        --radius-sm:    8px;
        --radius-xs:    5px;
    }

    /* ── Base overrides (scoped to this page) ──────────── */
    .content { font-family: 'Sora', sans-serif; background: var(--surface); }

    /* ── Page header ───────────────────────────────────── */
    .exp-page-header { margin-bottom: 28px; }
    .exp-page-header h4 {
        font-size: 1.55rem;
        font-weight: 700;
        letter-spacing: -0.03em;
        color: var(--ink);
        margin-bottom: 4px;
    }
    .exp-page-header .breadcrumb-item a { color: var(--slate); font-size: 0.8rem; }
    .exp-page-header .breadcrumb-item.active { color: var(--slate); font-size: 0.8rem; font-weight: 500; }
    .exp-page-header .breadcrumb-item + .breadcrumb-item::before { color: var(--slate-light); }

    .btn-add-expense {
        background: var(--ink) !important;
        color: #fff !important;
        border: none !important;
        border-radius: 30px !important;
        padding: 9px 20px !important;
        font-family: 'Sora', sans-serif !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        box-shadow: 0 2px 8px rgba(13,15,20,0.22) !important;
        transition: all 0.18s ease !important;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-add-expense:hover {
        background: var(--ink-2) !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(13,15,20,0.28) !important;
        color: #fff !important;
    }

    /* ── Hero stat card ────────────────────────────────── */
    .exp-hero-card {
        background: var(--ink) !important;
        border-radius: var(--radius) !important;
        border: none !important;
        box-shadow: var(--shadow-lg) !important;
        overflow: hidden;
        position: relative;
        min-height: 175px;
    }
    .exp-hero-card::before {
        content: '';
        position: absolute; top: -45px; right: -45px;
        width: 190px; height: 190px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
        pointer-events: none;
    }
    .exp-hero-card::after {
        content: '';
        position: absolute; bottom: -65px; left: 50px;
        width: 230px; height: 230px;
        background: rgba(59,91,219,0.18);
        border-radius: 50%;
        pointer-events: none;
    }
    .exp-hero-card .card-body { position: relative; z-index: 1; padding: 28px 26px !important; }
    .exp-hero-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: rgba(255,255,255,0.42);
        margin-bottom: 10px;
    }
    .exp-hero-value {
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.04em;
        color: #fff;
        line-height: 1.1;
    }
    .exp-hero-value .exp-hero-currency {
        font-size: 1rem;
        font-weight: 400;
        opacity: 0.55;
        margin-right: 2px;
    }
    .exp-hero-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(255,255,255,0.09);
        border-radius: 30px;
        padding: 4px 11px;
        font-size: 0.71rem;
        font-weight: 500;
        color: rgba(255,255,255,0.65);
        margin-top: 14px;
    }
    .exp-hero-dot {
        width: 7px; height: 7px;
        background: #69db7c;
        border-radius: 50%;
        display: inline-block;
    }

    /* ── Filter card ───────────────────────────────────── */
    .exp-filter-card {
        border: 1px solid var(--line) !important;
        border-radius: var(--radius) !important;
        box-shadow: var(--shadow-sm) !important;
    }
    .exp-filter-card .card-body { padding: 22px 24px !important; }
    .exp-filter-title {
        font-size: 0.69rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--slate-light);
        margin-bottom: 14px;
    }

    /* Override Bootstrap form-floating for the filter */
    .exp-filter-card .form-floating > .form-control {
        border: 1.5px solid var(--line) !important;
        border-radius: var(--radius-sm) !important;
        background: var(--surface) !important;
        font-family: 'Sora', sans-serif;
        font-size: 0.83rem;
        color: var(--ink);
        transition: border-color 0.18s, box-shadow 0.18s;
    }
    .exp-filter-card .form-floating > .form-control:focus {
        border-color: var(--accent) !important;
        box-shadow: 0 0 0 3px var(--accent-glow) !important;
        background: #fff !important;
    }
    .exp-filter-card .form-floating > label { color: var(--slate-light) !important; font-size: 0.82rem; }

    .btn-exp-filter {
        background: var(--ink) !important;
        color: #fff !important;
        border: none !important;
        border-radius: var(--radius-sm) !important;
        font-family: 'Sora', sans-serif !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        transition: all 0.18s ease !important;
    }
    .btn-exp-filter:hover { background: var(--ink-2) !important; color: #fff !important; transform: translateY(-1px); }

    .btn-exp-reset {
        background: transparent !important;
        color: var(--slate) !important;
        border: 1.5px solid var(--line) !important;
        border-radius: var(--radius-sm) !important;
        font-family: 'Sora', sans-serif !important;
        font-size: 0.82rem !important;
        font-weight: 500 !important;
        transition: all 0.18s ease !important;
    }
    .btn-exp-reset:hover { background: var(--line-soft) !important; color: var(--ink) !important; }

    /* ── Table card ────────────────────────────────────── */
    .exp-table-card {
        border: 1px solid var(--line) !important;
        border-radius: var(--radius) !important;
        box-shadow: var(--shadow-sm) !important;
        overflow: hidden;
    }
    .exp-table-card .card-header {
        background: #fff !important;
        border-bottom: 1px solid var(--line) !important;
        padding: 18px 22px !important;
    }
    .exp-table-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--ink);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .exp-entry-count {
        background: var(--line-soft);
        border-radius: 30px;
        padding: 2px 10px;
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--slate);
    }
    .btn-exp-print {
        background: transparent !important;
        color: var(--slate) !important;
        border: 1.5px solid var(--line) !important;
        border-radius: var(--radius-xs) !important;
        font-family: 'Sora', sans-serif !important;
        font-size: 0.78rem !important;
        font-weight: 500 !important;
        padding: 6px 14px !important;
        transition: all 0.16s ease !important;
    }
    .btn-exp-print:hover { background: var(--line-soft) !important; color: var(--ink) !important; }

    ── DataTable overrides ──────────────────────────────
    #basic-datatable { border-collapse: collapse !important; width: 100% !important; }

    #basic-datatable thead th {
        background: var(--surface) !important;
        text-transform: uppercase;
        font-size: 0.68rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.09em;
        color: var(--slate-light) !important;
        padding: 11px 16px !important;
        border-bottom: 1px solid var(--line) !important;
        border-top: none !important;
        white-space: nowrap;
        font-family: 'Sora', sans-serif;
    }

    #basic-datatable tbody tr {
        border-bottom: 1px solid var(--line-soft) !important;
        transition: background 0.14s ease;
    }
    #basic-datatable tbody tr:last-child { border-bottom: none !important; }
    #basic-datatable tbody tr:hover { background: var(--line-soft) !important; }

    #basic-datatable tbody td {
        padding: 5px 16px !important;
        font-size: 0.83rem;
        vertical-align: middle !important;
        border-top: none !important;
        font-family: 'Sora', sans-serif;
        color: var(--ink-3);
    }

    .dataTables_wrapper {
        padding-top: 0px;
    }

    /* Row number */
    .exp-row-num {
        font-size: 0.73rem;
        font-weight: 500;
        color: var(--slate-light);
    }

    /* Reference chip */
    .exp-ref-chip {
        display: inline-flex;
        align-items: center;
        background: var(--accent-light);
        color: var(--accent);
        border-radius: var(--radius-xs);
        padding: 3px 9px;
        font-family: 'DM Mono', monospace;
        font-size: 0.74rem;
        font-weight: 500;
        letter-spacing: 0.02em;
    }
    .exp-ref-chip.unassigned {
        background: var(--line-soft);
        color: var(--slate-light);
    }

    /* Date */
    .exp-date-cell { font-weight: 500; color: var(--ink-2); white-space: nowrap; }
    .exp-date-year { font-weight: 400; color: var(--slate-light); font-size: 0.77rem; }

    /* Amount */
    .exp-amount {
        font-weight: 700 !important;
        color: var(--ink) !important;
        font-size: 0.9rem !important;
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }
    .exp-amount-currency { font-weight: 400; color: var(--slate); font-size: 0.77rem; margin-right: 1px; }

    /* Action buttons */
    .exp-action-btn {
        width: 30px; height: 30px;
        border-radius: var(--radius-xs) !important;
        border: 1.5px solid var(--line) !important;
        background: #fff !important;
        color: var(--slate) !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 0.78rem !important;
        padding: 0 !important;
        transition: all 0.15s ease !important;
        line-height: 1 !important;
    }
    .exp-action-btn.edit:hover  { background: var(--accent-light) !important; border-color: var(--accent) !important; color: var(--accent) !important; }
    .exp-action-btn.delete:hover { background: var(--danger-light) !important; border-color: var(--danger) !important; color: var(--danger) !important; }

    /* Table footer total row */
    #basic-datatable tfoot td {
        background: var(--line-soft) !important;
        border-top: 2px solid var(--line) !important;
        padding: 14px 16px !important;
        font-family: 'Sora', sans-serif;
    }
    .exp-total-label {
        text-align: right;
        font-size: 0.72rem !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: var(--slate) !important;
    }
    .exp-total-value {
        text-align: right;
        font-weight: 700 !important;
        color: var(--accent) !important;
        font-size: 1.05rem !important;
        font-variant-numeric: tabular-nums;
    }

    /* DataTables search box */
    .dataTables_filter input {
        border: 1.5px solid var(--line) !important;
        border-radius: 30px !important;
        padding: 6px 14px !important;
        font-family: 'Sora', sans-serif !important;
        font-size: 0.8rem !important;
        color: var(--ink) !important;
        background: var(--surface) !important;
        outline: none !important;
        transition: border-color 0.18s, box-shadow 0.18s !important;
    }
    .dataTables_filter input:focus {
        border-color: var(--accent) !important;
        box-shadow: 0 0 0 3px var(--accent-glow) !important;
        background: #fff !important;
    }
    .dataTables_filter label { font-family: 'Sora', sans-serif; font-size: 0.8rem; color: var(--slate); }

    /* Pagination */
    .dataTables_paginate .paginate_button {
        border-radius: var(--radius-xs) !important;
        border: 1.5px solid var(--line) !important;
        font-family: 'Sora', sans-serif !important;
        font-size: 0.78rem !important;
        font-weight: 500 !important;
        color: var(--slate) !important;
        padding: 4px 10px !important;
        margin: 0 2px !important;
        background: #fff !important;
        transition: all 0.15s ease !important;
    }
    .dataTables_paginate .paginate_button:hover {
        background: var(--line-soft) !important;
        color: var(--ink) !important;
        border-color: var(--line) !important;
    }
    .dataTables_paginate .paginate_button.current,
    .dataTables_paginate .paginate_button.current:hover {
        background: var(--ink) !important;
        color: #fff !important;
        border-color: var(--ink) !important;
        font-weight: 700 !important;
    }
    .dataTables_paginate .paginate_button.disabled,
    .dataTables_paginate .paginate_button.disabled:hover {
        opacity: 0.35 !important;
        cursor: default !important;
        background: #fff !important;
    }
    .dataTables_info { font-family: 'Sora', sans-serif; font-size: 0.77rem; color: var(--slate-light); }

    /* ── Animations ────────────────────────────────────── */
    @keyframes expFadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .exp-hero-card   { animation: expFadeUp 0.3s ease both; }
    .exp-filter-card { animation: expFadeUp 0.35s 0.05s ease both; }
    .exp-table-card  { animation: expFadeUp 0.4s 0.1s ease both; }

    /* ── Print ─────────────────────────────────────────── */
    @media print {
        .d-print-none,
        .dataTables_filter,
        .dataTables_length,
        .dataTables_paginate,
        .exp-filter-card,
        .btn { display: none !important; }
        .exp-table-card { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
        #basic-datatable thead th { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row align-items-center mb-4 pt-3 exp-page-header">
            <div class="col">
                <h4>Expense Management</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Financials</a></li>
                        <li class="breadcrumb-item active">{{ request('start_date') ? 'Filtered Report' : 'Annual Overview' }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto d-print-none">
                <a href="{{ route('add.expense') }}" class="btn btn-add-expense">
                    <i class="mdi mdi-plus"></i> Add Expense
                </a>
                <a href="{{ route('expense.report.pdf', request()->query()) }}" class="btn btn-danger rounded-3 shadow-sm">
                    <i class="mdi mdi-file-pdf-box me-1"></i> Export PDF
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="card exp-hero-card mb-4">
                    <div class="card-body">
                        <p class="exp-hero-label">Total Period Expenditure</p>
                        <div class="exp-hero-value">
                            <span class="exp-hero-currency">₱</span>{{ number_format($totalAmount ?? 0, 2) }}
                        </div>
                        <div class="exp-hero-badge">
                            <span class="exp-hero-dot"></span>
                            {{ request('start_date') ? 'Filtered Period' : 'Annual Overview' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card exp-filter-card mb-4">
                    <div class="card-body">
                        <p class="exp-filter-title">Quick Filter</p>
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
                                        <button type="submit" class="btn btn-exp-filter w-100">Filter</button>
                                        <a href="{{ route('year.expense') }}" class="btn btn-exp-reset w-100">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card exp-table-card">
            {{-- <div class="card-header d-flex justify-content-between align-items-center">
                <div class="exp-table-title">
                    Transaction Ledger
                    <span class="exp-entry-count">{{ count($yearexpense) }} entries</span>
                </div>
                <button onclick="window.print()" class="btn btn-exp-print d-print-none">
                    <i class="mdi mdi-printer me-1"></i> Print
                </button>
            </div> --}}
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table id="basic-datatable" class="table table-hover align-middle pt-0">
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
                                <td><span class="exp-row-num">{{ str_pad($key+1, 2, '0', STR_PAD_LEFT) }}</span></td>
                                <td>
                                    <span class="exp-ref-chip {{ ($item->reference_no ?? null) ? '' : 'unassigned' }}">
                                        {{ $item->reference_no ?? 'REF-UNA' }}
                                    </span>
                                </td>
                                <td class="exp-date-cell">
                                    {{ date('M d', strtotime($item->date)) }}
                                    <span class="exp-date-year">{{ date('Y', strtotime($item->date)) }}</span>
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($item->details, 60) }}</td>
                                <td class="text-end exp-amount">
                                    <span class="exp-amount-currency">₱</span>{{ number_format($item->amount, 2) }}
                                </td>
                                <td class="text-center d-print-none">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('edit.expense', $item->id) }}" class="btn exp-action-btn edit" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <a href="#" class="btn exp-action-btn delete" onclick="return confirm('Delete this record?')" title="Delete">
                                            <i class="mdi mdi-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="exp-total-label">Total Expenditure</td>
                                <td class="exp-total-value text-end">
                                    <span class="exp-amount-currency">₱</span>{{ number_format($totalAmount ?? 0, 2) }}
                                </td>
                                <td class="d-print-none"></td>
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
                "searching": false, // This disables the search feature
                "pageLength": 10,
                // "order": [[2, "desc"]],
                "dom": '<"d-flex justify-content-between align-items-center mb-3"f><"table-responsive"t><"d-flex justify-content-between align-items-center mt-3"ip>',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search ledger...",
                    "info": "Showing _START_–_END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries found",
                    "emptyTable": "No expense records available",
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
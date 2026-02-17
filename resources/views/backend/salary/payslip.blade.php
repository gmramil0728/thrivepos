@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-print-none">
                    <div class="page-title-right">
                        <button onclick="window.print()" class="btn btn-primary waves-effect waves-light">
                            <i class="mdi mdi-printer me-1"></i> Print Payslip
                        </button>
                    </div>
                    <h4 class="page-title">Employee Payslip</h4>
                </div>

                <div class="card shadow-none border mt-3 p-4" id="payslip-container">
                    <div class="row mb-4">
                        <div class="col-sm-8 d-flex align-items-center">
                            @if($company && $company->logo)
                                <img src="{{ asset($company->logo) }}" alt="Logo" class="me-3" style="width: 60px; height: 60px; object-fit: contain;">
                            @endif
                            <div>
                                <h3 class="text-uppercase fw-bold text-primary mb-0">{{ $company->name ?? 'Your Company Name' }}</h3>
                                <p class="text-muted mb-0">
                                    {{ $company->address ?? 'Company Address Not Set' }}<br>
                                    @if($company->contact) Contact: {{ $company->contact }} @endif 
                                    @if($company->email) | Email: {{ $company->email }} @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-4 text-sm-end">
                            <h2 class="fw-bold mb-1">PAYSLIP</h2>
                            <p class="text-muted mb-0">Transaction Ref: <strong>{{ $payslip->transaction_id }}</strong></p>
                            <p class="text-muted">Date Generated: {{ date('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="row bg-light p-3 rounded mb-4 payslip-details">
                        <div class="col-6"> <table class="table table-borderless table-sm mb-0">
                                <tr><td class="fw-bold" width="150">Employee Name:</td><td>{{ $payslip->employee->name }}</td></tr>
                                <tr><td class="fw-bold">Employee ID:</td><td>EMP-{{ str_pad($payslip->employee_id, 4, '0', STR_PAD_LEFT) }}</td></tr>
                                <tr><td class="fw-bold">Designation:</td><td>{{ $payslip->employee->designation ?? 'Staff' }}</td></tr>
                            </table>
                        </div>
                        <div class="col-6"> <table class="table table-borderless table-sm mb-0 text-end">
                                <tr><td class="fw-bold">Pay Period:</td><td>{{ $payslip->salary_month }} {{ $payslip->salary_year }}</td></tr>
                                <tr><td class="fw-bold">Payment Method:</td><td>{{ $payslip->payment_method }}</td></tr>
                                <tr><td class="fw-bold">Payment Date:</td><td>{{ date('M d, Y', strtotime($payslip->created_at)) }}</td></tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Description</th>
                                        <th class="text-end">Earnings</th>
                                        <th class="text-end">Deductions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Basic Salary</td>
                                        <td class="text-end">₱{{ number_format($payslip->basic_salary, 2) }}</td>
                                        <td class="text-end">-</td>
                                    </tr>
                                    @if($payslip->advance_salary > 0)
                                    <tr>
                                        <td>Advance Salary Deduction</td>
                                        <td class="text-end">-</td>
                                        <td class="text-end" style="color: red;">₱{{ number_format($payslip->advance_salary, 2) }}</td>
                                    </tr>
                                    @endif
                                    </tbody>
                                <tfoot>
                                    <tr class="fw-bold fs-4">
                                        <td class="text-end">NET PAYABLE</td>
                                        <td colspan="2" class="text-end text-primary">₱{{ number_format($payslip->paid_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-6 text-center">
                            <div class="border-top pt-2 mx-auto" style="width: 200px;">
                                <p class="mb-0">Employee Signature</p>
                            </div>
                        </div>
                        <div class="col-6 text-center">
                            <div class="border-top pt-2 mx-auto" style="width: 200px;">
                                <p class="mb-0">Manager Signature</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12 text-center text-muted">
                            <small>This is a computer-generated payslip and does not require a physical stamp.</small>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
</div>

<style>
    @media print {
        /* Set page size and margins */
        @page {
            size: A4;
            margin: 10mm; /* Narrower margins to fit everything */
        }
    
        /* Force the card to be the only thing visible */
        .left-side-menu, .navbar-custom, .footer, .d-print-none, .page-title-box, .breadcrumb {
            display: none !important;
        }
    
        .content-page {
            margin-left: 0 !important;
            margin-top: 0 !important;
            padding: 0 !important;
        }
    
        .content {
            padding: 0 !important;
            margin: 0 !important;
        }
    
        /* Remove card borders/shadows for a flat paper look */
        .card {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
    
        /* Tighten spacing */
        .mb-4 { margin-bottom: 0.8rem !important; }
        .mt-5 { margin-top: 1.5rem !important; }
        .p-4 { padding: 0 !important; }
        
        /* Ensure tables don't stretch too wide or break across pages */
        table {
            page-break-inside: avoid;
            font-size: 12px; /* Slightly smaller text for print reliability */
        }
    
        .table-dark {
            background-color: #343a40 !important;
            color: white !important;
            -webkit-print-color-adjust: exact; /* Ensures header color prints */
        }
    
        /* Avoid accidental second page */
        html, body {
            height: auto;
            font-size: 12px;
            background: white !important;
            overflow: hidden;
        }
    
        #payslip-container {
            width: 100%;
            max-height: 280mm; /* Limit height to slightly less than A4 */
        }

        .payslip-details {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            background-color: #f8f9fa !important; /* Forces the light grey background to show */
            -webkit-print-color-adjust: exact;
        }

        .payslip-details .col-6 {
            width: 50% !important;
            flex: 0 0 50% !important;
            max-width: 50% !important;
        }

        /* Ensure text alignment stays correct in print */
        .text-end {
            text-align: right !important;
        }

        /* Tighten table padding for the detail section */
        .payslip-details table td {
            padding-top: 2px !important;
            padding-bottom: 2px !important;
        }
    }
    </style>

@endsection
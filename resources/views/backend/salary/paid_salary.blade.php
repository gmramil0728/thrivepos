@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('pay.salary') }}">Payroll</a></li>
                            <li class="breadcrumb-item active">Process Payment</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Process Salary Payment</h4>
                </div>
            </div>
        </div>     

        <div class="row">
            <div class="col-xl-8 col-lg-10 mx-auto">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                            <div>
                                <h4 class="text-primary mb-0"><i class="mdi mdi-cash-check me-2"></i>Pay Slip Confirmation</h4>
                                <p class="text-muted mb-0">Processing for: <strong>{{ date("F Y", strtotime('-1 month')) }}</strong></p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-soft-success text-success p-2 px-3 rounded-pill text-uppercase">
                                    {{ $paysalary->pay_type ?? 'Monthly' }} Cycle
                                </span>
                            </div>
                        </div>

                        <form method="post" action="{{ route('employe.salary.store') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $paysalary->id }}">
                            <input type="hidden" name="month" value="{{ date('F', strtotime('-1 month')) }}">
                            <input type="hidden" name="year" value="{{ date('Y') }}">

                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="d-flex align-items-center bg-light p-3 rounded">
                                        <img src="{{ (!empty($paysalary->image)) ? asset($paysalary->image) : asset('upload/no_image.jpg') }}" 
                                             class="rounded-circle img-thumbnail me-3" style="width: 70px; height: 70px;">
                                        <div>
                                            <h5 class="mb-1">{{ $paysalary->name }}</h5>
                                            <p class="text-muted mb-0">ID: EMP-{{ str_pad($paysalary->id, 4, '0', STR_PAD_LEFT) }} | {{ $paysalary->designation ?? 'Staff' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-header bg-light"><h6 class="mb-0">Earnings</h6></div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Basic Salary:</span>
                                                <span class="fw-bold">₱{{ number_format($paysalary->salary, 2) }}</span>
                                            </div>
                                            <input type="hidden" name="paid_amount" value="{{ $paysalary->salary }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-header bg-light"><h6 class="mb-0 text-danger">Deductions</h6></div>
                                        <div class="card-body">
                                            @php
                                                $advance = $paysalary['advance']['advance_salary'] ?? 0;
                                                $due = $paysalary->salary - $advance;
                                            @endphp
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Advance Taken:</span>
                                                <span class="text-danger fw-bold">-₱{{ number_format($advance, 2) }}</span>
                                            </div>
                                            <input type="hidden" name="advance_salary" value="{{ $advance }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="alert alert-success border-0 mb-4 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="alert-heading mb-1">Total Net Payable</h4>
                                            <p class="mb-0 text-dark">The amount to be disbursed to the employee.</p>
                                        </div>
                                        <h2 class="mb-0">₱{{ number_format($due, 2) }}</h2>
                                        <input type="hidden" name="due_salary" value="{{ $due }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Payment Method <span class="text-danger">*</span></label>
                                        <select name="payment_method" class="form-select" required>
                                            <option value="Cash" selected>Cash</option> <option value="Bank Transfer">Bank Transfer</option>
                                            <option value="Check">Check</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Transaction Reference</label>
                                        <input type="text" name="transaction_id" class="form-control" 
                                               placeholder="e.g., PAY-202602-0042" 
                                               value="PAY-{{ date('Ym') }}-{{ str_pad($paysalary->id, 4, '0', STR_PAD_LEFT) }}">
                                        <small class="text-muted">Auto-generated suggestion: Prefix-Date-EmpID</small>
                                    </div>
                                </div>

                                
                            </div> <div class="text-end mt-4 pt-3 border-top">
                                <a href="{{ route('pay.salary') }}" class="btn btn-light waves-effect me-2">Cancel</a>
                                <button type="submit" class="btn btn-success waves-effect waves-light px-4">
                                    <i class="mdi mdi-check-decagram me-1"></i> Confirm & Process Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-success { background-color: rgba(26, 188, 156, 0.1); }
    .card-header { font-weight: 600; letter-spacing: 0.5px; }
    .alert-success { background-color: #d1e7dd; color: #0f5132; }
</style>

@endsection
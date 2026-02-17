@extends('admin_dashboard')
@section('admin')


<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('year.expense') }}" class="btn btn-secondary rounded-pill waves-effect">
                            <i class="mdi mdi-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                    <h4 class="page-title">Expense Management</h4>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h4 class="header-title mb-4">
                            <i class="mdi mdi-cash-plus text-primary me-1"></i> Add New Expense
                        </h4>

                        <form method="post" action="{{ route('expense.store') }}" id="expenseForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="date" class="form-label fw-bold">Expense Date <span class="text-danger">*</span></label>
                                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                                               id="date" value="{{ date('Y-m-d') }}" required>
                                        @error('date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="amount" class="form-label fw-bold">Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" 
                                                   placeholder="0.00" required>
                                        </div>
                                        @error('amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="details" class="form-label fw-bold">Expense Details <span class="text-danger">*</span></label>
                                        <textarea name="details" class="form-control @error('details') is-invalid @enderror" 
                                                  id="details" rows="4" placeholder="Briefly describe the expense (e.g., Electricity Bill, Office Supplies)..." required></textarea>
                                        @error('details')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div> <div class="text-end mt-3">
                                <a href="{{ route('year.expense') }}" class="btn btn-light waves-effect me-1">Cancel</a>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    <i class="mdi mdi-content-save me-1"></i> Save Expense
                                </button>
                            </div>
                        </form>
                    </div>
                </div> </div> </div>
        </div> </div> @endsection
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
                            <i class="mdi mdi-pencil-box-outline text-warning me-1"></i> Edit Expense Record
                        </h4>

                        <form method="post" action="{{ route('expense.update', $expense->id) }}" id="expenseForm">
                            @csrf                            

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="date" class="form-label fw-bold">Expense Date <span class="text-danger">*</span></label>
                                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                                               id="date" value="{{ old('date', $expense->date) }}" required>
                                        @error('date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="amount" class="form-label fw-bold">Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">₱</span>
                                            <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" 
                                                   value="{{ old('amount', $expense->amount) }}" placeholder="0.00" required>
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
                                                  id="details" rows="4" required>{{ old('details', $expense->details) }}</textarea>
                                        @error('details')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-3">
                                <a href="{{ route('year.expense') }}" class="btn btn-light waves-effect me-1">Cancel</a>
                                <button type="submit" class="btn btn-warning waves-effect waves-light">
                                    <i class="mdi mdi-check-circle me-1"></i> Update Expense
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
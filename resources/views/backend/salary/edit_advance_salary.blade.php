@extends('admin_dashboard')
@section('admin')

<style>
    .select2-container--default .select2-selection--single {
        height: 38px !important;
        padding: 5px;
        border: 1px solid #ced4da;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    /* Make disabled inputs look clear but obviously unclickable */
    .form-control:disabled, .form-select:disabled {
        background-color: #f8f9fa;
        cursor: not-allowed;
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('all.advance.salary') }}">Advance Salary</a></li>
                            <li class="breadcrumb-item active">Edit Advance</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Advance Salary Management</h4>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-xl-8 col-lg-10 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="mb-4 text-uppercase bg-light p-2"><i class="mdi mdi-account-edit me-1"></i> Edit Advance Salary Request</h5>

                        <form method="post" action="{{ route('advance.salary.update') }}">
                            @csrf
                            
                            <input type="hidden" name="id" value="{{ $salary->id }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Employee Name</label>
                                        <select class="form-select select2-config" disabled>
                                            @foreach($employee as $item)
                                                <option value="{{ $item->id }}" {{ $item->id == $salary->employee_id ? 'selected' : '' }}>
                                                    {{ $item->name }} (Basic: ₱{{ number_format($item->salary, 2) }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="employee_id" value="{{ $salary->employee_id }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Salary Month</label>
                                        <select class="form-select" disabled> 
                                            @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                                <option value="{{ $month }}" {{ $salary->month == $month ? 'selected' : '' }}>{{ $month }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="month" value="{{ $salary->month }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Salary Year</label>
                                        <select class="form-select" disabled>
                                            @for($y = 2022; $y <= date('Y') + 1; $y++)
                                                <option value="{{ $y }}" {{ $salary->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                            @endfor
                                        </select>
                                        <input type="hidden" name="year" value="{{ $salary->year }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Request Date</label>
                                        <input type="date" class="form-control" value="{{ $salary->request_date }}" disabled>
                                        <input type="hidden" name="request_date" value="{{ $salary->request_date }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="advance_salary" class="form-label fw-bold">Advance Amount (₱) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" step="0.01" name="advance_salary" class="form-control @error('advance_salary') is-invalid @enderror" value="{{ old('advance_salary', $salary->advance_salary) }}">
                                        </div>
                                        @error('advance_salary')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div> 

                            <div class="text-end mt-3">
                                <a href="{{ route('all.advance.salary') }}" class="btn btn-light waves-effect me-1">Cancel</a>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    <i class="mdi mdi-content-save"></i> Update Changes
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

@section('jscripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2-config').select2({
                width: '100%'
            });
        });
    </script>
@endsection
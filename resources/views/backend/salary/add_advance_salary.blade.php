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
</style>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('all.advance.salary') }}">Advance Salary</a></li>
                            <li class="breadcrumb-item active">Add Advance</li>
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
                        <h5 class="mb-4 text-uppercase bg-light p-2"><i class="mdi mdi-cash-multiple me-1"></i> Request Advance Salary</h5>

                        <form method="post" action="{{ route('advance.salary.store') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="employee_id" class="form-label fw-bold">Employee Name <span class="text-danger">*</span></label>
                                        <select name="employee_id" class="form-select select2-config @error('employee_id') is-invalid @enderror" id="employee_id">
                                            <option selected disabled>-- Search Employee Name --</option>
                                            @foreach($employee as $item)
                                                <option value="{{ $item->id }}" {{ old('employee_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }} (Basic: ₱{{ number_format($item->salary, 2) }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('employee_id')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="month" class="form-label fw-bold">Salary Month <span class="text-danger">*</span></label>
                                        <select name="month" class="form-select @error('month') is-invalid @enderror">
                                            <option selected disabled>Select Month</option>
                                            @php $currentMonth = date('F'); @endphp
                                            @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                                <option value="{{ $month }}" {{ old('month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                            @endforeach
                                        </select>
                                        @error('month')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="year" class="form-label fw-bold">Salary Year <span class="text-danger">*</span></label>
                                        <select name="year" class="form-select @error('year') is-invalid @enderror">
                                            <option disabled>Select Year</option> @php $thisYear = date('Y'); @endphp
                                            
                                            @for($y = $thisYear; $y <= $thisYear + 1; $y++)
                                                <option value="{{ $y }}" 
                                                    {{ (old('year', $thisYear) == $y) ? 'selected' : '' }}>
                                                    {{ $y }}
                                                </option>
                                            @endfor
                                        </select>
                                        
                                        @error('year')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="request_date" class="form-label fw-bold">Request Date <span class="text-danger">*</span></label>
                                        <input type="date" name="request_date" class="form-control @error('request_date') is-invalid @enderror" value="{{ old('request_date', date('Y-m-d')) }}">
                                        @error('request_date')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="advance_salary" class="form-label fw-bold">Advance Amount (₱) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" step="0.01" name="advance_salary" class="form-control @error('advance_salary') is-invalid @enderror" placeholder="0.00" value="{{ old('advance_salary') }}">
                                        </div>
                                        @error('advance_salary')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div> <div class="text-end mt-3">
                                <a href="{{ route('all.advance.salary') }}" class="btn btn-light waves-effect me-1">Cancel</a>
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    <i class="mdi mdi-content-save"></i> Save Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> </div> </div> </div> 
@endsection

@section('jscripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2-config').select2({
                placeholder: "-- Search Employee Name --",
                allowClear: true,
                width: '100%' // Ensures it matches Bootstrap's width
            });
        });
    </script>
@endsection
@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    {{-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <a href="{{ route('add.advance.salary') }}" class="btn btn-primary rounded-pill waves-effect waves-light">
                                <i class="mdi mdi-plus-circle me-1"></i> Add Advance Salary 
                            </a>
                        </ol>
                    </div> --}}
                    <h4 class="page-title">Payroll Management</h4>
                </div>
            </div>
        </div>     

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="header-title text-uppercase text-primary">
                                <i class="mdi mdi-calendar-check me-1"></i> {{ date("F Y") }} Payroll Generation
                            </h4>
                        </div>
                        
                        <table id="basic-datatable" class="table dt-responsive nowrap w-100 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Sl</th>
                                    <th>Employee</th>
                                    <th>Name</th>
                                    <th>Type</th> <th>Month</th>
                                    <th>Basic Salary</th>
                                    <th>Advance</th>
                                    <th>Net Due</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($employee as $key=> $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td> 
                                        <img src="{{ (!empty($item->image)) ? asset($item->image) : asset('upload/no_image.jpg') }}" 
                                             class="rounded-circle img-thumbnail shadow-sm" 
                                             style="width:50px; height: 50px; object-fit: cover;"> 
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $item->name }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $typeColor = [
                                                'weekly' => 'bg-soft-warning text-warning',
                                                'bi-monthly' => 'bg-soft-info text-info',
                                                'monthly' => 'bg-soft-success text-success'
                                            ][$item->pay_type ?? 'monthly'];
                                        @endphp
                                        <span class="badge {{ $typeColor }} text-uppercase">
                                            {{ $item->pay_type ?? 'Monthly' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-primary text-primary px-2"> 
                                            {{ date("F", strtotime('-1 month')) }} 
                                        </span> 
                                    </td>
                                    <td class="fw-semibold">₱{{ number_format($item->salary, 2) }}</td>
                                    <td>
                                        @php
                                            $advance = $item['advance']['advance_salary'] ?? 0;
                                        @endphp
                                        @if($advance > 0)
                                            <span class="text-danger fw-bold">-₱{{ number_format($advance, 2) }}</span>
                                        @else
                                            <span class="text-muted">₱0.00</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $netDue = $item->salary - $advance;
                                        @endphp
                                        <span class="badge bg-success font-13 px-2">
                                            ₱{{ number_format($netDue, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            // Logic to check if this specific employee is already in the pay_salaries table for the current month
                                            $isAlreadyPaid = App\Models\PaySalary::where('employee_id', $item->id)
                                                              ->where('salary_month', date("F", strtotime("-1 month")))
                                                              ->where('salary_year', date('Y'))
                                                              ->exists();
                                        @endphp
                                    
                                        @if($isAlreadyPaid)
                                            <span class="badge bg-soft-success text-success p-2">
                                                <i class="mdi mdi-check-circle me-1"></i> Paid
                                            </span>
                                        @else
                                            <a href="{{ route('pay.now.salary',$item->id) }}" class="btn btn-blue btn-sm rounded-pill">
                                                Pay Now
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> </div> </div></div>
    </div> </div> <style>
    .bg-soft-primary { background-color: rgba(114, 124, 245, 0.1); }
    .bg-soft-success { background-color: rgba(10, 191, 128, 0.1); }
    .bg-soft-info { background-color: rgba(57, 175, 209, 0.1); }
    .bg-soft-warning { background-color: rgba(255, 190, 11, 0.1); }
    .img-thumbnail { padding: 0.15rem; background-color: #fff; border: 1px solid #dee2e6; }
</style>

@endsection
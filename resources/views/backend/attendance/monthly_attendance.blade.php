@extends('admin_dashboard')
@section('admin')

<style>
    .attendance-dot {
        height: 12px;
        width: 12px;
        border-radius: 50%;
        display: inline-block;
        border: 1px solid rgba(0,0,0,0.1);
    }
    .bg-dot-present { background-color: #1abc9c; }
    .bg-dot-absent { background-color: #e74c3c; }
    .bg-dot-leave { background-color: #f1c40f; }
    .bg-dot-none { background-color: #e9ecef; }
    
    .table-attendance thead th {
        padding: 5px;
        font-size: 10px;
        text-align: center;
        min-width: 25px;
    }
    .table-attendance td {
        padding: 8px 4px !important;
        text-align: center;
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Monthly Attendance Overview</h4>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('monthly.attendance') }}" method="GET" class="row align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Select Month</label>
                                <select name="month" class="form-select">
                                    @for($m=1; $m<=12; $m++)
                                        <option value="{{ sprintf('%02d', $m) }}" {{ $month == $m ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Select Year</label>
                                <select name="year" class="form-select">
                                    @for($y=date('Y'); $y>=date('Y')-5; $y--)
                                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Filter Grid</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="me-3"><span class="attendance-dot bg-dot-present"></span> Present</span>
                            <span class="me-3"><span class="attendance-dot bg-dot-absent"></span> Absent</span>
                            <span class="me-3"><span class="attendance-dot bg-dot-leave"></span> Leave</span>
                            <span class="me-3"><span class="attendance-dot bg-dot-none"></span> No Data</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-attendance table-centered mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="min-width: 150px; text-align: left !important;">Employee Name</th>
                                        @for($i=1; $i<=$daysInMonth; $i++)
                                            <th>{{ $i }}</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
                                    <tr>
                                        <td class="text-start fw-bold">{{ $employee->name }}</td>
                                        @for($i=1; $i<=$daysInMonth; $i++)
                                            @php
                                                $currentDate = sprintf('%04d-%02d-%02d', $year, $month, $i);
                                                $attend = $employee->attendance->where('date', $currentDate)->first();
                                            @endphp
                                            <td>
                                                @if($attend)
                                                    @if($attend->attend_status == 'Present')
                                                        <span class="attendance-dot bg-dot-present" title="{{ $currentDate }}: Present"></span>
                                                    @elseif($attend->attend_status == 'Leave')
                                                        <span class="attendance-dot bg-dot-leave" title="{{ $currentDate }}: Leave"></span>
                                                    @else
                                                        <span class="attendance-dot bg-dot-absent" title="{{ $currentDate }}: Absent"></span>
                                                    @endif
                                                @else
                                                    <span class="attendance-dot bg-dot-none" title="No Record"></span>
                                                @endif
                                            </td>
                                        @endfor
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
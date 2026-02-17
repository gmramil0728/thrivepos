@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <div class="btn-group">
                            <a href="{{ route('employee.attend.list') }}" class="btn btn-secondary rounded-pill waves-effect waves-light me-2">
                                <i class="mdi mdi-keyboard-backspace me-1"></i> Back
                            </a>
                            <a href="javascript:window.print()" class="btn btn-primary rounded-pill waves-effect waves-light">
                                <i class="mdi mdi-printer me-1"></i> Print Report
                            </a>
                        </div>
                    </div>
                    <h4 class="page-title">Attendance Details: {{ date('d M, Y', strtotime($details[0]->date)) }}</h4>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-md-4">
                <div class="card widget-flat bg-success text-white">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-account-check widget-icon"></i>
                        </div>
                        <h5 class="text-uppercase mt-0" title="Total Present">Present</h5>
                        <h3 class="mt-3 mb-3">{{ $details->where('attend_status', 'Present')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card widget-flat bg-danger text-white">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-account-remove widget-icon"></i>
                        </div>
                        <h5 class="text-uppercase mt-0" title="Total Absent">Absent</h5>
                        <h3 class="mt-3 mb-3">{{ $details->where('attend_status', 'Absent')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card widget-flat bg-warning text-white">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-account-clock widget-icon"></i>
                        </div>
                        <h5 class="text-uppercase mt-0" title="Total on Leave">Leave</h5>
                        <h3 class="mt-3 mb-3">{{ $details->where('attend_status', 'Leave')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%">Sl</th> 
                                    <th width="20%">Photo</th>
                                    <th width="40%">Employee Name</th>
                                    <th width="30%" class="text-center">Status</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($details as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td> 
                                    <td>
                                        <img src="{{ (!empty($item->employee->image)) ? url($item->employee->image) : url('upload/no_image.jpg') }}" 
                                             style="width:40px; height:40px;" class="rounded-circle img-thumbnail" alt="profile">
                                    </td>
                                    <td>
                                        <h5 class="m-0 font-14">{{ $item->employee->name ?? 'John Doe' }}</h5>
                                        <small class="text-muted">{{ $item->employee->designation ?? 'Staff' }}</small>
                                    </td>
                                    <td class="text-center">
                                        @if($item->attend_status == 'Present')
                                            <span class="badge bg-success p-2 px-3"><i class="mdi mdi-check-circle me-1"></i> Present</span>
                                        @elseif($item->attend_status == 'Leave')
                                            <span class="badge bg-warning p-2 px-3 text-dark"><i class="mdi mdi-clock-outline me-1"></i> Leave</span>
                                        @else
                                            <span class="badge bg-danger p-2 px-3"><i class="mdi mdi-close-circle me-1"></i> Absent</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> </div> </div></div>
    </div> </div> @endsection
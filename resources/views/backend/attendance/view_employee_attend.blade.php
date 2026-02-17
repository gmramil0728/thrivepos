@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <a href="{{ route('add.employee.attend') }}" class="btn btn-primary rounded-pill waves-effect waves-light">
                                <i class="mdi mdi-plus-circle me-1"></i> Add Attendance
                            </a>  
                        </ol>
                    </div>
                    <h4 class="page-title">Employee Attendance Management</h4>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="text-muted font-14 mb-3">
                            Below is the list of recorded daily attendance. Use the action buttons to review or modify logs.
                        </p>

                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%">Sl</th> 
                                    <th width="50%">Attendance Date</th>
                                    <th width="40%" class="text-center">Action</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($allData as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td> 
                                    <td>
                                        <span class="fw-bold text-dark">
                                            <i class="mdi mdi-calendar-check text-primary me-1"></i>
                                            {{ date('D, d M Y', strtotime($item->date)) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('employee.attend.view', $item->date) }}" 
                                           class="btn btn-info btn-sm rounded-pill waves-effect waves-light" 
                                           title="View Details">
                                           <i class="mdi mdi-eye"></i> View
                                        </a>

                                        <a href="{{ route('employee.attend.edit', $item->date) }}" 
                                           class="btn btn-blue btn-sm rounded-pill waves-effect waves-light" 
                                           title="Edit Attendance">
                                           <i class="mdi mdi-pencil"></i> Edit
                                        </a>

                                        {{-- Optional: If you have a delete route --}}
                                        {{-- 
                                        <a href="{{ route('employee.attend.delete', $item->date) }}" 
                                           class="btn btn-danger btn-sm rounded-pill waves-effect waves-light" 
                                           id="delete" title="Delete Log">
                                           <i class="mdi mdi-trash-can"></i>
                                        </a> 
                                        --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div> </div> </div></div>
        </div> </div> @endsection
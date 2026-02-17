@extends('admin_dashboard')
@section('admin')

<style>
    .badge-permission {
        font-size: 11px;
        font-weight: 500;
        margin: 2px;
        padding: 5px 10px;
        background-color: rgba(59, 175, 218, 0.15); /* Soft Blue */
        color: #3bafda;
        border: 1px solid rgba(59, 175, 218, 0.2);
    }
    .role-name {
        font-weight: 700;
        color: #343a40;
        font-size: 15px;
    }
    .table-card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>

<div class="content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="page-title mb-1">Roles & Permissions Map</h4>
                        <p class="text-muted small mb-0">Overview of permissions assigned to each security role.</p>
                    </div>
                    {{-- <div class="page-title-right">
                        <a href="{{ route('add.roles.permission') }}" class="btn btn-primary rounded-pill waves-effect waves-light shadow-sm">
                            <i class="mdi mdi-plus-circle me-1"></i> Add Role in Permission
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-12">
                <div class="card table-card">
                    <div class="card-body">
                        
                        <table id="basic-datatable" class="table dt-responsive nowrap w-100 table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;">Sl</th>
                                    <th style="width: 15%;">Role Name</th>
                                    <th style="width: 60%;">Permissions</th> 
                                    <th style="width: 20%; text-align: right;">Action</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($roles as $key => $item)
                                <tr class="align-middle">
                                    <td>{{ $key+1 }}</td> 
                                    <td><span class="role-name">{{ $item->name }}</span></td>
                                    <td> 
                                        <div class="d-flex flex-wrap">
                                            @foreach($item->permissions as $perm)
                                                <span class="badge rounded-pill badge-permission">
                                                    {{ $perm->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td> 
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.edit.roles', $item->id) }}" 
                                               class="btn btn-sm btn-outline-primary waves-effect me-1" 
                                               title="Edit Role Permissions">
                                                <i class="mdi mdi-pencil me-1"></i> Edit
                                            </a>
                                            <a href="{{ route('admin.delete.roles', $item->id) }}" 
                                               class="btn btn-sm btn-outline-danger waves-effect" 
                                               id="delete" 
                                               title="Delete Assignment">
                                                <i class="mdi mdi-trash-can me-1"></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div> </div> </div></div>
        </div> </div> @endsection
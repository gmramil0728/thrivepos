@extends('admin_dashboard')
@section('admin')

<style>
    .role-title {
        font-weight: 600;
        color: #343a40;
    }
    .card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.03em;
        border-bottom: 2px solid #edf2f9;
    }
</style>

<div class="content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="page-title mb-1">System Roles</h4>
                        <p class="text-muted small mb-0">Define and manage top-level user access groups.</p>
                    </div>
                    <div class="page-title-right">
                        {{-- <a href="{{ route('add.roles') }}" class="btn btn-primary rounded-pill waves-effect waves-light shadow-sm">
                            <i class="mdi mdi-plus-circle me-1"></i> Add New Role
                        </a> --}}
                        <button type="button" class="btn btn-primary rounded-pill waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                            <i class="mdi mdi-plus-circle me-1"></i> Add Roles 
                        </button>
                    </div>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100 table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">Sl No.</th>
                                        <th style="width: 70%;">Role Designation</th> 
                                        <th style="width: 20%; text-align: right;">Operations</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    @foreach($roles as $key => $item)
                                    <tr class="align-middle">
                                        <td><span class="text-muted">{{ $key+1 }}</span></td> 
                                        <td><span class="role-title">{{ $item->name }}</span></td> 
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="{{ route('edit.roles', $item->id) }}" 
                                                   class="btn btn-sm btn-outline-primary waves-effect waves-light me-1" 
                                                   data-bs-toggle="tooltip" title="Edit Role Name">
                                                    <i class="mdi mdi-pencil me-1"></i>Edit
                                                </a>
                                                <a href="{{ route('delete.roles', $item->id) }}" 
                                                   class="btn btn-sm btn-outline-danger waves-effect waves-light" 
                                                   id="delete"
                                                   data-bs-toggle="tooltip" title="Remove Role">
                                                    <i class="mdi mdi-trash-can me-1"></i>Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> </div> </div> </div></div>
        </div> </div> 

        <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px; border: none;">
                    <div class="modal-header bg-light" style="border-radius: 15px 15px 0 0;">
                        <h4 class="modal-title" id="myCenterModalLabel">Add New Role</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        
                        <form id="myForm" method="post" action="{{ route('roles.store') }}">
                            @csrf
        
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Role Name</label>
                                <input type="text" name="name" id="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="e.g. Manager, Editor"
                                       value="{{ old('name') }}">
                                
                                @error('name')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>
        
                            <div class="text-end">
                                <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    <i class="mdi mdi-content-save me-1"></i> Save Role
                                </button>
                            </div>
                        </form>
        
                    </div>
                </div></div></div>```
        
      
        
    
@endsection
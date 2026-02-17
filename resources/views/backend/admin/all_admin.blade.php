@extends('admin_dashboard')
@section('admin')

<style>
    .admin-profile-img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #f1f5f7;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #6c757d;
    }
    .badge-soft-danger {
        background-color: rgba(241, 85, 108, 0.1);
        color: #f1556c;
        border: 1px solid rgba(241, 85, 108, 0.2);
    }
    .page-title-box .count-badge {
        font-size: 1rem;
        vertical-align: middle;
        margin-left: 10px;
    }
</style>

<div class="content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title">
                        Admin Management 
                        <span class="badge rounded-pill bg-soft-info text-info count-badge">{{ count($alladminuser) }} Total</span>
                    </h4>
                    <div class="page-title-right">
                        <a href="{{ route('add.admin') }}" class="btn btn-primary rounded-pill waves-effect waves-light shadow-sm">
                            <i class="mdi mdi-account-plus me-1"></i> Add New Admin
                        </a>  
                    </div>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <table id="basic-datatable" class="table table-hover dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Profile</th>
                                    <th>Admin Identity</th>
                                    <th>Contact Info</th> 
                                    <th>Role Permissions</th> 
                                    <th width="15%" class="text-center">Actions</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($alladminuser as $key => $item)
                                <tr class="align-middle">
                                    <td><span class="text-muted fw-bold">{{ $key+1 }}</span></td>
                                    <td>
                                        <img src="{{ (!empty($item->photo)) ? url('upload/admin_image/'.$item->photo) : url('upload/no_image.jpg') }}" 
                                             class="admin-profile-img">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->name }}</div>
                                        <small class="text-muted">ID: #ADM-{{ 1000 + $item->id }}</small>
                                    </td>
                                    <td>
                                        <div><i class="mdi mdi-email-outline me-1 text-primary"></i>{{ $item->email }}</div>
                                        <div class="small text-muted"><i class="mdi mdi-phone-outline me-1"></i>{{ $item->phone }}</div>
                                    </td> 
                                    <td> 
                                        @foreach($item->roles as $role)
                                            <span class="badge badge-soft-danger px-2 py-1"> 
                                                <i class="mdi mdi-shield-check-outline me-1"></i>{{ $role->name }} 
                                            </span>
                                        @endforeach
                                    </td> 
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('edit.admin',$item->id) }}" 
                                               class="btn btn-sm btn-outline-blue waves-effect waves-light" 
                                               data-bs-toggle="tooltip" title="Edit Admin">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <a href="{{ route('delete.admin',$item->id) }}" 
                                               class="btn btn-sm btn-outline-danger waves-effect waves-light" 
                                               id="delete" data-bs-toggle="tooltip" title="Delete Admin">
                                                <i class="mdi mdi-trash-can"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> </div> </div></div>
        </div> </div> @endsection
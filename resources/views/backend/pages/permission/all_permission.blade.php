@extends('admin_dashboard')
@section('admin')

<style>
    .table-responsive { border-radius: 12px; }
    .badge-soft-info {
        background-color: rgba(59, 175, 218, 0.1);
        color: #3bafda;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
    }
    .action-icon { font-size: 1.1rem; }
    .page-title-box { padding: 20px 0; }
    .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); border-radius: 15px; }
    thead th { background-color: #f8f9fa; border-bottom: 2px solid #edf2f9 !important; color: #6c757d; font-weight: 700; text-transform: uppercase; font-size: 12px; }
</style>

<div class="content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="page-title mb-1">Access Control</h4>
                        <p class="text-muted small mb-0">Manage system-wide permissions and functional groups.</p>
                    </div>
                    <div class="page-title-right">
                        <a href="{{ route('add.permission') }}" class="btn btn-primary rounded-pill waves-effect waves-light shadow-sm">
                            <i class="mdi mdi-plus-circle me-1"></i> Add New Permission
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table table-hover dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">Sl</th>
                                        <th style="width: 40%;">Permission Name</th>
                                        <th style="width: 30%;">Group Name</th>
                                        <th style="width: 20%;" class="text-end">Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    @foreach($permissions as $key => $item)
                                    <tr class="align-middle">
                                        <td class="text-muted">{{ $key+1 }}</td> 
                                        <td><span class="fw-bold text-dark">{{ $item->name }}</span></td>
                                        <td>
                                            <span class="badge-soft-info">
                                                <i class="mdi mdi-folder-outline me-1"></i>{{ $item->group_name }}
                                            </span>
                                        </td> 
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="{{ route('edit.permission', $item->id) }}" 
                                                   class="btn btn-sm btn-outline-primary waves-effect waves-light me-1" 
                                                   data-bs-toggle="tooltip" title="Edit">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <a href="{{ route('delete.permission', $item->id) }}" 
                                                   class="btn btn-sm btn-outline-danger waves-effect waves-light" 
                                                   id="delete" 
                                                   data-bs-toggle="tooltip" title="Delete">
                                                    <i class="mdi mdi-trash-can"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> </div> </div> </div></div>
        </div> </div> @endsection

@section('jscripts')
<script>
    $(document).ready(function() {
        // Initialize Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection
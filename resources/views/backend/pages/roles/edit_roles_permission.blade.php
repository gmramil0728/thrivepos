@extends('admin_dashboard')
@section('admin')


<style type="text/css">
    .form-check-label { text-transform: capitalize; cursor: pointer; }
    .permission-group-card { border: 1px solid #e9ecef; border-radius: 10px; margin-bottom: 1.5rem; overflow: hidden; }
    .group-header { background-color: #f8f9fa; border-bottom: 1px solid #e9ecef; padding: 12px 20px; }
    .group-body { padding: 15px 20px; }
    .role-name-display { color: #4a81d4; font-weight: 700; border-left: 4px solid #4a81d4; padding-left: 15px; }
    .select-all-wrapper { background: #f0f4f8; border-radius: 8px; padding: 10px 20px; }
</style>

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title">Edit Role Permissions</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('all.roles') }}">Roles</a></li>
                            <li class="breadcrumb-item active">Edit Permissions</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>     

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        
                        <form id="myForm" method="post" action="{{ route('role.permission.update', $role->id) }}">
                            @csrf

                            <div class="row align-items-center mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-muted mb-1">Currently Editing Permissions for:</label>
                                        <h3 class="role-name-display my-0">{{ $role->name }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <div class="select-all-wrapper d-inline-block">
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" type="checkbox" id="masterCheckbox">
                                            <label class="form-check-label fw-bold" for="masterCheckbox">
                                                Select All Permissions
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="mb-4">

                            @foreach($permission_groups as $group)
                                @php
                                    $permissions = App\Models\User::getpermissionByGroupName($group->group_name);
                                @endphp
                                <div class="permission-group-card">
                                    <div class="group-header">
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input group-toggle" type="checkbox" 
                                                   id="group-{{ $loop->index }}" 
                                                   {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold text-dark" for="group-{{ $loop->index }}">
                                                {{ $group->group_name }} Module
                                            </label>
                                        </div>
                                    </div>
                                    <div class="group-body bg-white">
                                        <div class="row">
                                            @foreach($permissions as $permission)
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input permission-item" type="checkbox" 
                                                           name="permission[]" 
                                                           {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} 
                                                           value="{{ $permission->id }}" 
                                                           id="perm-{{ $permission->id }}">
                                                    <label class="form-check-label text-muted" for="perm-{{ $permission->id }}">
                                                        {{ str_replace($group->group_name.'.', '', $permission->name) }}
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <button type="button" onclick="window.history.back()" class="btn btn-light waves-effect me-1">Cancel</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light shadow">
                                        <i class="mdi mdi-content-save-check me-1"></i> Update Access Rights
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div> 
            </div> 
        </div> 

    </div> 
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // 1. Master Toggle (Select All)
        $('#masterCheckbox').click(function() {
            $('input[type="checkbox"]').prop('checked', $(this).is(':checked'));
        });

        // 2. Group Toggle (Select all in module)
        $('.group-toggle').click(function() {
            $(this).closest('.permission-group-card').find('.permission-item').prop('checked', $(this).is(':checked'));
        });

        // 3. Auto-sync Group Checkbox when individual items are changed
        $('.permission-item').click(function() {
            var $card = $(this).closest('.permission-group-card');
            var total = $card.find('.permission-item').length;
            var checked = $card.find('.permission-item:checked').length;
            $card.find('.group-toggle').prop('checked', total === checked);
        });
    });
</script>

@endsection
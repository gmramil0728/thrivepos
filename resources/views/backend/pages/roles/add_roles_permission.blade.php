@extends('admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<style type="text/css">
    .form-check-label { text-transform: capitalize; cursor: pointer; font-weight: 500; }
    .group-header { background-color: #f8f9fa; padding: 10px 15px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid #4a81d4; }
    .permission-box { padding: 15px; border: 1px solid #edf2f9; border-radius: 8px; margin-bottom: 20px; transition: all 0.3s; }
    .permission-box:hover { border-color: #4a81d4; background-color: #fbfcfe; }
    .select-all-label { font-weight: 700; color: #4a81d4; }
</style>

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title">Role-Based Access Control</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('all.roles') }}">Roles</a></li>
                            <li class="breadcrumb-item active">Assign Permissions</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>     

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        
                        <form id="myForm" method="post" action="{{ route('role.permission.store') }}">
                            @csrf

                            <div class="row mb-4 align-items-end">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="role_id" class="form-label fw-bold text-dark">Target Role</label>
                                        <select name="role_id" class="form-select border-primary" id="role_id">
                                            <option selected disabled>Choose a role to configure...</option>
                                            @foreach($roles as $role)          
                                                <option value="{{ $role->id }}"> {{ $role->name }}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8 text-md-end">
                                    <div class="form-check form-check-primary d-inline-block bg-light p-2 px-3 rounded border">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                        <label class="form-check-label select-all-label" for="selectAll">
                                            <i class="mdi mdi-check-all me-1"></i> Grant All Permissions
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                @foreach($permission_groups as $group)
                                <div class="col-md-12">
                                    <div class="permission-box">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="form-check form-check-primary group-header mb-md-0">
                                                    <input class="form-check-input group-checkbox" type="checkbox" id="group-{{ $loop->index }}">
                                                    <label class="form-check-label fw-bold text-primary" for="group-{{ $loop->index }}">
                                                        {{ $group->group_name }} Module
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="row">
                                                    @php
                                                        $permissions = App\Models\User::getpermissionByGroupName($group->group_name);
                                                    @endphp
                                                    @foreach($permissions as $permission)
                                                    <div class="col-md-4 col-sm-6 py-1">
                                                        <div class="form-check mb-1">
                                                            <input class="form-check-input permission-checkbox" 
                                                                   name="permission[]" 
                                                                   type="checkbox" 
                                                                   value="{{ $permission->id }}" 
                                                                   id="perm{{ $permission->id }}">
                                                            <label class="form-check-label text-muted" for="perm{{ $permission->id }}">
                                                                {{ str_replace($group->group_name.'.', '', $permission->name) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="text-end mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light shadow">
                                    <i class="mdi mdi-shield-check me-1"></i> Save Access Rules
                                </button>
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
        // 1. Master "Select All" Logic
        $('#selectAll').click(function() {
            if ($(this).is(':checked')) {
                $('input[type=checkbox]').prop('checked', true);
            } else {
                $('input[type=checkbox]').prop('checked', false);
            }
        });

        // 2. Group-specific "Select All" Logic
        $('.group-checkbox').click(function() {
            var isChecked = $(this).is(':checked');
            // Find all checkboxes in the same permission-box row and toggle them
            $(this).closest('.permission-box').find('.permission-checkbox').prop('checked', isChecked);
        });

        // 3. Sync Group Checkbox if individual items are manually toggled
        $('.permission-checkbox').click(function() {
            var $box = $(this).closest('.permission-box');
            var total = $box.find('.permission-checkbox').length;
            var checked = $box.find('.permission-checkbox:checked').length;
            
            $box.find('.group-checkbox').prop('checked', (total === checked));
        });
    });
</script>

@endsection
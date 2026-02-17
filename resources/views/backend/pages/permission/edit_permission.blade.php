@extends('admin_dashboard')
@section('admin')


<style>
    .form-label { font-weight: 600; color: #343a40; }
    .card { border-radius: 15px; border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }
    .invalid-feedback { font-size: 0.8rem; font-weight: 500; }
    .section-title { border-bottom: 2px solid #f8f9fa; padding-bottom: 10px; color: #4a81d4; }
</style>

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title">Edit Permission</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('all.permission') }}">All Permissions</a></li>
                            <li class="breadcrumb-item active">Edit Permission</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="card">
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="mdi mdi-alert-circle me-1"></i> {{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="tab-pane" id="settings">
                            <form id="myForm" method="post" action="{{ route('permission.update') }}">
                                @csrf
                                
                                <input type="hidden" name="id" value="{{ $permission->id }}">

                                <h5 class="mb-4 text-uppercase section-title">
                                    <i class="mdi mdi-shield-edit-outline me-1"></i> Update Permission Details
                                </h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Permission Name</label>
                                            <input type="text" name="name" id="name" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   value="{{ old('name', $permission->name) }}">
                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                            <small class="text-muted">Use <code>module.action</code> format.</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="group_name" class="form-label">Group Category</label>
                                            <select name="group_name" class="form-select @error('group_name') is-invalid @enderror" id="group_name">
                                                <option selected disabled>Select Group</option>
                                                @php
                                                    $groups = ['pos', 'employee', 'customer', 'supplier', 'salary', 'attendance', 'category', 'product', 'expense', 'orders', 'stock', 'roles','admins'];
                                                @endphp
                                                @foreach($groups as $group)
                                                    <option value="{{ $group }}" {{ (old('group_name', $permission->group_name) == $group) ? 'selected' : '' }}>
                                                        {{ ucfirst($group) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('group_name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div> <div class="text-end mt-3">
                                    <button type="button" onclick="window.history.back()" class="btn btn-light waves-effect me-1">Cancel</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-content-save-check me-1"></i> Update Permission
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> </div> </div>
        </div> </div> <script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: { required : true }, 
                group_name: { required : true }, 
            },
            messages :{
                name: { required : 'Please enter the permission name' }, 
                group_name: { required : 'Please select a group name' },
            },
            errorElement : 'span', 
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>

@endsection
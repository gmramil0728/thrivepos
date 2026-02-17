@extends('admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<style>
    .form-label { font-weight: 600; color: #444; font-size: 0.9rem; }
    .card { border-radius: 12px; border: none; }
    .input-group-text { background-color: #f8f9fa; border-right: none; color: #6c757d; }
    .form-control { border-left: none; }
    .form-control:focus { border-color: #ced4da; box-shadow: none; border-left: none; }
    .input-group:focus-within .input-group-text { border-color: #4a81d4; color: #4a81d4; }
    .input-group:focus-within .form-control { border-color: #4a81d4; }
    .section-title { 
        font-size: 1.1rem; 
        letter-spacing: 0.02em; 
        border-left: 4px solid #4a81d4; 
        padding-left: 15px; 
    }
</style>

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title">Manage System Role</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('all.roles') }}">Roles</a></li>
                            <li class="breadcrumb-item active">Edit Role</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>     

        <div class="row">
            <div class="col-lg-7 col-xl-6 offset-lg-2">
                <div class="card shadow-lg">
                    <div class="card-body p-4">

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 bg-soft-danger text-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0 list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="mdi mdi-alert-octagon-outline me-1"></i> {{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <form id="myForm" method="post" action="{{ route('roles.update') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $roles->id }}">

                            <div class="mb-4">
                                <h5 class="section-title text-primary text-uppercase">
                                    <i class="mdi mdi-account-key me-1"></i> Role Configuration
                                </h5>
                                <p class="text-muted small">Update the designation name for this security group.</p>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <label for="name" class="form-label">Role Designation Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="mdi mdi-shield-star-outline"></i></span>
                                            <input type="text" name="name" id="name" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   value="{{ old('name', $roles->name) }}"
                                                   placeholder="Enter role name...">
                                        </div>
                                        @error('name')
                                            <span class="text-danger small fw-bold mt-1 d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div> 

                            <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded">
                                <button type="button" onclick="window.history.back()" class="btn btn-sm btn-link text-muted text-decoration-none">
                                    <i class="mdi mdi-arrow-left me-1"></i> Back to List
                                </button>
                                <div>
                                    <button type="submit" class="btn btn-success waves-effect waves-light shadow">
                                        <i class="mdi mdi-check-all me-1"></i> Update Role
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
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: { required : true, minlength: 2 }, 
            },
            messages :{
                name: { 
                    required : 'Role name is required',
                    minlength: 'Role name must be at least 2 characters'
                }, 
            },
            errorElement : 'span', 
            errorPlacement: function (error, element) {
                error.addClass('text-danger small mt-1');
                element.closest('.form-group').append(error);
            },
            highlight : function(element){
                $(element).closest('.input-group').addClass('is-invalid');
                $(element).addClass('border-danger text-danger');
            },
            unhighlight : function(element){
                $(element).closest('.input-group').removeClass('is-invalid');
                $(element).removeClass('border-danger text-danger');
            },
        });
    });
</script>

@endsection
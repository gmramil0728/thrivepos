@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('all.admin') }}">All Admin</a></li>
                            <li class="breadcrumb-item active">Edit Admin</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Admin</h4>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-lg-8 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-pane" id="settings">
                            <form id="myForm" method="post" action="{{ route('admin.update') }}">
                                @csrf

                                <input type="hidden" name="id" value="{{ $adminuser->id }}">

                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Edit Admin Information</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $adminuser->name) }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $adminuser->email) }}">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $adminuser->phone) }}">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="roles" class="form-label">Assign Role</label>
                                            <select name="roles" class="form-select @error('roles') is-invalid @enderror" id="example-select">
                                                <option selected disabled>Select Roles</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}" {{ $adminuser->hasRole($role->name) ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('roles')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div> <div class="text-end">
                                    <button type="submit" class="btn btn-success waves-effect waves-light mt-2">
                                        <i class="mdi mdi-content-save"></i> Update Admin
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> </div> </div>
        </div> </div> @endsection

@section('jscripts')
<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                }, 
                email: {
                    required : true,
                    email: true
                }, 
                phone: {
                    required : true,
                }, 
                roles: {
                    required : true,
                }, 
            },
            messages :{
                name: {
                    required : 'Please Enter User Name',
                }, 
                email: {
                    required : 'Please Enter User Email',
                    email: 'Please enter a valid email address'
                },
                phone: {
                    required : 'Please Enter User Phone',
                }, 
                roles: {
                    required : 'Please Select a Role',
                }, 
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
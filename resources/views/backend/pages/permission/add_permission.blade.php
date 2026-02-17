@extends('admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title">Add New Permission</h4>
                    <div class="page-title-right">
                        <a href="{{ route('all.permission') }}" class="btn btn-outline-primary rounded-pill btn-sm">
                            <i class="mdi mdi-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>     

        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body">
                        
                        {{-- @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="mdi mdi-alert-circle me-1"></i> {{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif --}}

                        <form id="myForm" method="post" action="{{ route('permission.store') }}">
                            @csrf

                            <h5 class="mb-4 text-uppercase text-primary fw-bold">
                                <i class="mdi mdi-shield-plus me-1"></i> Permission Configuration
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Permission Name</label>
                                        <input type="text" name="name" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name') }}">
                                        
                                        @error('name')
                                            <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="group_name" class="form-label">Group Name</label>
                                        <select name="group_name" class="form-select @error('group_name') is-invalid @enderror" id="group_name">
                                            <option selected disabled>Select Module Group</option>
                                            <option value="pos" {{ old('group_name') == 'pos' ? 'selected' : '' }}>POS</option>
                                            <option value="employee" {{ old('group_name') == 'employee' ? 'selected' : '' }}>Employee</option>
                                            <option value="customer" {{ old('group_name') == 'customer' ? 'selected' : '' }}>Customer</option>
                                            <option value="supplier" {{ old('group_name') == 'supplier' ? 'selected' : '' }}>Supplier</option>
                                            <option value="salary" {{ old('group_name') == 'salary' ? 'selected' : '' }}>Salary</option>
                                            <option value="attendance" {{ old('group_name') == 'attendance' ? 'selected' : '' }}>Attendance</option>
                                            <option value="category" {{ old('group_name') == 'category' ? 'selected' : '' }}>Category</option>
                                            <option value="product" {{ old('group_name') == 'product' ? 'selected' : '' }}>Product</option>
                                            <option value="expense" {{ old('group_name') == 'expense' ? 'selected' : '' }}>Expense</option>
                                            <option value="orders" {{ old('group_name') == 'orders' ? 'selected' : '' }}>Orders</option>
                                            <option value="stock" {{ old('group_name') == 'stock' ? 'selected' : '' }}>Stock</option>
                                            <option value="roles" {{ old('group_name') == 'roles' ? 'selected' : '' }}>Roles</option> 
                                            <option value="admins" {{ old('group_name') == 'admins' ? 'selected' : '' }}>Admins</option> 
                                        </select>
                                        @error('group_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div> 

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-success waves-effect waves-light px-4">
                                    <i class="mdi mdi-content-save me-1"></i> Save Permission
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
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: { required : true }, 
                group_name: { required : true }, 
            },
            messages :{
                name: { required : 'Please enter the permission name' }, 
                group_name: { required : 'Please select a group module' },
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
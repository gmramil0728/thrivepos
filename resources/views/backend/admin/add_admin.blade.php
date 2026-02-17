@extends('admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<style>
    .form-label { font-weight: 600; color: #444; }
    .card { border-radius: 15px; border: none; }
    .image-preview-container {
        width: 120px;
        height: 120px;
        border: 3px solid #f1f5f7;
        border-radius: 50%;
        overflow: hidden;
        margin-bottom: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    .image-preview-container img { width: 100%; height: 100%; object-fit: cover; }
    .input-group-text { background-color: #f8f9fa; border-right: none; color: #6c757d; }
    /* Fix: Ensure border logic doesn't hide validation borders */
    .form-control { border-left: none; }
    .form-control.is-invalid { border-left: 1px solid #f1556c; } 
    .section-title { 
        font-size: 1.1rem; 
        border-left: 4px solid #4a81d4; 
        padding-left: 15px; 
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title">Admin Management</h4>
                </div>
            </div>
        </div>     

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form id="myForm" method="post" action="{{ route('admin.store') }}" enctype="multipart/form-data">
                            @csrf

                            <h5 class="section-title text-primary text-uppercase mb-4">
                                <i class="mdi mdi-account-plus me-1"></i> Create New Administrator
                            </h5>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label class="form-label">Full Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-account"></i></span>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="John Doe">
                                            </div>
                                            @error('name')
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3 form-group">
                                            <label class="form-label">Email Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                                                <input type="email" name="email" value="{{ old('email') }}" 
                                                       class="form-control @error('email') is-invalid @enderror" 
                                                       placeholder="admin@example.com">
                                            </div>
                                            @error('email')
                                                <span class="text-danger small fw-bold">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3 form-group">
                                            <label class="form-label">Phone Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-phone"></i></span>
                                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="+1 234 567 890">
                                            </div>
                                            @error('phone')
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3 form-group">
                                            <label class="form-label">Access Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-lock"></i></span>
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                                            </div>
                                            @error('password')
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3 form-group">
                                            <label class="form-label">Assign System Role</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-shield-account"></i></span>
                                                <select name="roles" class="form-select @error('roles') is-invalid @enderror">
                                                    <option selected disabled>Choose Role...</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}" {{ old('roles') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('roles')
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 border-start text-center">
                                    <label class="form-label d-block">Admin Photo</label>
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="image-preview-container">
                                            <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt="preview">
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="photo" id="image" class="form-control form-control-sm mt-2" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-success waves-effect waves-light shadow">
                                    <i class="mdi mdi-content-save-check me-1"></i> Create Administrator
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
        // Image Preview
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });

        // Client-side Validation (jQuery)
        $('#myForm').validate({
            rules: {
                name: { required : true }, 
                email: { required : true, email: true }, 
                phone: { required : true }, 
                password: { required : true, minlength: 6 }, 
                roles: { required : true }, 
            },
            errorElement : 'span', 
            errorPlacement: function (error, element) {
                error.addClass('text-danger small mt-1');
                element.closest('.form-group').append(error);
            },
            highlight : function(element){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element){
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endsection
@extends('admin_dashboard')
@section('admin')

<style>
    /* Profile Image Enhancement */
    .profile-upload-container {
        position: relative;
        text-align: center;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s ease;
    }
    .profile-upload-container:hover {
        border-color: #727cf5;
        background: #f1f3fa;
    }
    .profile-picture-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-bottom: 15px;
    }
    .section-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #6c757d;
        letter-spacing: 1px;
        border-bottom: 2px solid #f1f3fa;
        padding-bottom: 8px;
    }
</style>

<div class="content">
    <div class="container-fluid">

        <div class="row mt-3">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-center">
                    <h4 class="page-title">Edit Employee: {{ $employee->name }}</h4>
                    <div class="page-title-right">
                        <a href="{{ route('all.employee') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                            <i class="mdi mdi-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <form method="post" action="{{ route('employee.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $employee->id }}">

            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-3 text-uppercase font-14">Update Avatar</h5>
                            <div class="profile-upload-container">
                                <img id="showImage" 
                                     src="{{ $employee->image ? asset($employee->image) : url('upload/no_image.jpg') }}" 
                                     class="profile-picture-preview" alt="Preview">
                                <p class="text-muted font-13">Leave blank to keep the current photo.</p>
                                <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <span class="text-danger font-13">{{ $message }}</span>
                                @enderror
                            </div>
                            <hr>
                            <div class="text-start">
                                <p class="text-muted font-13">
                                    <strong>Member Since:</strong> 
                                    {{ $employee->created_at ? $employee->created_at->format('M d, Y') : 'N/A' }}
                                </p>
                                <p class="text-muted font-13">
                                    <strong>Last Updated:</strong> 
                                    {{ $employee->updated_at ? $employee->updated_at->diffForHumans() : 'Never' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="mb-4">
                                <p class="section-title text-uppercase mb-3"><i class="mdi mdi-account-details me-1"></i> Personal Information</p>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="mdi mdi-account"></i></span>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $employee->name) }}">
                                        </div>
                                        @error('name') <span class="text-danger font-13">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $employee->email) }}">
                                        </div>
                                        @error('email') <span class="text-danger font-13">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="mdi mdi-phone"></i></span>
                                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $employee->phone) }}">
                                        </div>
                                        @error('phone') <span class="text-danger font-13">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="mdi mdi-map-marker"></i></span>
                                            <input type="text" name="address" class="form-control" value="{{ old('address', $employee->address) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="section-title text-uppercase mb-3"><i class="mdi mdi-briefcase-variant-outline me-1"></i> Job Details</p>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Designation</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="mdi mdi-tie"></i></span>
                                            <input type="text" name="designation" class="form-control" value="{{ old('designation', $employee->designation ?? '') }}" placeholder="e.g. Sales Manager">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Monthly Salary <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" name="salary" class="form-control @error('salary') is-invalid @enderror" value="{{ old('salary', $employee->salary) }}" step="0.01">
                                        </div>
                                        @error('salary') <span class="text-danger font-13">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{ route('all.employee') }}" class="btn btn-light waves-effect me-1">Cancel Changes</a>
                                <button type="submit" class="btn btn-primary waves-effect waves-light px-4">
                                    <i class="mdi mdi-content-save-check me-1"></i> Save Updates
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

@endsection

@section('jscripts')
<script>
$(document).ready(function() {
    // Image preview with smooth fade
    $('#image').change(function(e) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#showImage').fadeOut(200, function() {
                $(this).attr('src', e.target.result).fadeIn(200);
            });
        }
        reader.readAsDataURL(this.files[0]);
    });
});
</script>
@endsection
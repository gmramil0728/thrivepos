@extends('admin_dashboard')
@section('admin')

<style>
    /* Modern Background & Typography */
    .content-page { background-color: #f8f9fa; }
    .page-title { font-weight: 700; color: #343a40; }

    /* Logo Upload Styling */
    .logo-container {
        position: relative;
        border: 2px dashed #dee2e6;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        background: #fff;
        transition: all 0.3s ease;
    }
    .logo-container:hover { border-color: #4a81d4; background: #f0f7ff; }
    
    .profile-picture {
        width: 100%;
        max-height: 200px;
        object-fit: contain;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    /* Form Card Styling */
    .settings-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid #e0e0e0;
    }

    .form-control:focus {
        border-color: #4a81d4;
        box-shadow: 0 0 0 3px rgba(74, 129, 212, 0.1);
    }

    .section-header {
        border-bottom: 2px solid #f8f9fa;
        padding-bottom: 10px;
        margin-bottom: 25px;
        color: #4a81d4;
        font-weight: 700;
    }

    .btn-update {
        padding: 10px 30px;
        border-radius: 30px;
        font-weight: 600;
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
    }
</style>

<div class="content">
    <div class="container-fluid">

        <div class="row mb-4 pt-3">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title mb-0">Company Settings</h4>
                        <p class="text-muted small mb-0">Manage your business identity and contact details</p>
                    </div>
                </div>
            </div>
        </div>

        <form method="post" action="{{ route('company.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $company->id }}">

            <div class="row">
                <div class="col-lg-4">
                    <div class="card settings-card">
                        <div class="card-body">
                            <h5 class="section-header"><i class="mdi mdi-camera me-1"></i> Branding</h5>
                            <div class="logo-container">
                                <img id="showImage" 
                                     src="{{ $company->logo ? asset($company->logo) : url('upload/no_image.jpg') }}" 
                                     class="profile-picture mb-3" 
                                     alt="Company Logo">
                                
                                <div class="text-start">
                                    <label for="logo" class="form-label">Upload New Logo</label>
                                    <input type="file" id="logo" name="logo" class="form-control @error('logo') is-invalid @enderror">
                                    <span class="text-muted small mt-1 d-block">Recommended: Square PNG or JPG</span>
                                    @error('logo')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card settings-card">
                        <div class="card-body">
                            <h5 class="section-header"><i class="mdi mdi-office-building me-1"></i> General Information</h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $company->name) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Official Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $company->email) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" 
                                           value="{{ old('contact', $company->contact) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tax ID (TIN)</label>
                                    <input type="text" name="tin" class="form-control @error('tin') is-invalid @enderror" 
                                           value="{{ old('tin', $company->tin) }}">
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Office Address</label>
                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                              rows="3">{{ old('address', $company->address) }}</textarea>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary btn-update waves-effect waves-light">
                                    <i class="mdi mdi-content-save me-1"></i> Save Changes
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
    // Elegant Preview with fade-in effect
    $('#logo').change(function(e) {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').fadeOut(200, function() {
                    $(this).attr('src', e.target.result).fadeIn(200);
                });
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>
@endsection
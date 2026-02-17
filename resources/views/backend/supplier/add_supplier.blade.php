@extends('admin_dashboard')
@section('admin')


<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('supplier.all') }}">Suppliers</a></li>
                            <li class="breadcrumb-item active">Add Supplier</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Add Supplier</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        
                        <form method="post" action="{{ route('supplier.store') }}" enctype="multipart/form-data">
                            @csrf

                            <h5 class="mb-4 text-uppercase text-primary">
                                <i class="mdi mdi-account-box-outline me-1"></i> Basic Information
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Supplier Name</label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name') }}" placeholder="Enter full name">
                                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Supplier Email</label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                               value="{{ old('email') }}" placeholder="email@example.com">
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Supplier Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                                               value="{{ old('phone') }}" placeholder="Contact number">
                                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="shopname" class="form-label">Supplier Shop Name</label>
                                        <input type="text" name="shopname" id="shopname" class="form-control @error('shopname') is-invalid @enderror" 
                                               value="{{ old('shopname') }}" placeholder="Business name">
                                        @error('shopname') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Supplier Address</label>
                                        <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" 
                                               value="{{ old('address') }}" placeholder="Street address">
                                        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Supplier Type</label>
                                        <select name="type" class="form-select @error('type') is-invalid @enderror" id="type">
                                            <option selected disabled>Select Type</option>
                                            <option value="Distributor" {{ old('type') == 'Distributor' ? 'selected' : '' }}>Distributor</option>
                                            <option value="Whole Seller" {{ old('type') == 'Whole Seller' ? 'selected' : '' }}>Whole Seller</option> 
                                        </select>
                                        @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 border-light">

                            <h5 class="mb-4 text-uppercase text-primary">
                                <i class="mdi mdi-bank-outline me-1"></i> Banking & Location
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="account_holder" class="form-label">Account Holder</label>
                                        <input type="text" name="account_holder" id="account_holder" class="form-control @error('account_holder') is-invalid @enderror" 
                                               value="{{ old('account_holder') }}">
                                        @error('account_holder') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="account_number" class="form-label">Account Number</label>
                                        <input type="text" name="account_number" id="account_number" class="form-control @error('account_number') is-invalid @enderror" 
                                               value="{{ old('account_number') }}">
                                        @error('account_number') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="bank_name" class="form-label">Bank Name</label>
                                        <input type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror" 
                                               value="{{ old('bank_name') }}">
                                        @error('bank_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="bank_branch" class="form-label">Bank Branch</label>
                                        <input type="text" name="bank_branch" id="bank_branch" class="form-control @error('bank_branch') is-invalid @enderror" 
                                               value="{{ old('bank_branch') }}">
                                        @error('bank_branch') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror" 
                                               value="{{ old('city') }}">
                                        @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 border-light">

                            <div class="row align-items-center bg-light-subtle p-3 rounded-3 mx-0">
                                <div class="col-md-6">
                                    <div class="mb-0">
                                        <label for="image" class="form-label fw-bold text-dark">Supplier Photo</label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                                        <small class="text-muted mt-1 d-block">Accepted formats: JPG, PNG. Max 2MB.</small>
                                        @error('image') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 text-center">
                                    <div class="image-preview-wrapper mt-2 mt-md-0">
                                        <img id="showImage" src="{{ url('upload/no_image.jpg') }}" 
                                             class="rounded-circle avatar-xl img-thumbnail shadow-sm border-white"
                                             alt="preview" style="width: 100px; height: 100px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="reset" class="btn btn-light waves-effect me-2">Cancel</button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light px-4">
                                    <i class="mdi mdi-content-save me-1"></i> Save Supplier Profile
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



@endsection

@section('jscripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Customer Management</a></li>
                            <li class="breadcrumb-item active">Add Customer</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Add Customer</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-pane" id="settings">
                            <form method="post" action="{{ route('customer.store') }}" enctype="multipart/form-data">
                                @csrf

                                <h5 class="mb-4 text-uppercase">
                                    <i class="mdi mdi-account-plus-outline me-1"></i> Customer Information
                                </h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Customer Name</label>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter full name" value="{{ old('name') }}">
                                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Customer Email</label>
                                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="example@mail.com" value="{{ old('email') }}">
                                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Customer Phone</label>
                                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="+1 234 567 890">
                                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="shopname" class="form-label">Shop Name</label>
                                            <input type="text" name="shopname" id="shopname" class="form-control @error('shopname') is-invalid @enderror">
                                            @error('shopname') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Customer Address</label>
                                            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror">
                                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <hr class="my-4">
                                    <h5 class="mb-4 text-uppercase">
                                        <i class="mdi mdi-bank-outline me-1"></i> Banking Details
                                    </h5>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="account_holder" class="form-label">Account Holder</label>
                                            <input type="text" name="account_holder" id="account_holder" class="form-control @error('account_holder') is-invalid @enderror">
                                            @error('account_holder') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="account_number" class="form-label">Account Number</label>
                                            <input type="text" name="account_number" id="account_number" class="form-control @error('account_number') is-invalid @enderror">
                                            @error('account_number') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="bank_name" class="form-label">Bank Name</label>
                                            <input type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror">
                                            @error('bank_name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="bank_branch" class="form-label">Bank Branch</label>
                                            <input type="text" name="bank_branch" id="bank_branch" class="form-control @error('bank_branch') is-invalid @enderror">
                                            @error('bank_branch') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror">
                                            @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Customer Profile Image</label>
                                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label d-block">Preview Image</label>
                                            <img id="showImage" src="{{ url('upload/no_image.jpg') }}" 
                                                 class="rounded-circle avatar-lg img-thumbnail" 
                                                 alt="profile-image" 
                                                 style="width: 100px; height: 100px; object-fit: cover;">
                                        </div>
                                    </div>
                                </div> <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="mdi mdi-content-save me-1"></i> Save Customer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div> </div> </div> </div> </div> </div> 

@endsection

@section('jscripts')

    <script type="text/javascript">
        $(document).ready(function(){
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

@endsection
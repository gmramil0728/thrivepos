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
                            <li class="breadcrumb-item active">Supplier Details</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Supplier Profile</h4>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-lg-4 col-xl-4">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <img src="{{ (!empty($supplier->image)) ? asset($supplier->image) : url('upload/no_image.jpg') }}" 
                             class="rounded-circle avatar-xl img-thumbnail mb-3" alt="profile-image">

                        <h4 class="mb-0">{{ $supplier->name }}</h4>
                        <p class="text-muted">{{ $supplier->type }} Supplier</p>

                        <div class="text-start mt-3">
                            <p class="text-muted font-13 text-uppercase"><strong>About :</strong></p>
                            <p class="text-muted mb-2 font-13"><strong>Shop :</strong> <span class="ms-2">{{ $supplier->shopname }}</span></p>
                            <p class="text-muted mb-2 font-13"><strong>City :</strong> <span class="ms-2">{{ $supplier->city }}</span></p>
                            <p class="text-muted mb-1 font-13"><strong>Address :</strong> <span class="ms-2">{{ $supplier->address }}</span></p>
                        </div>
                        
                        <div class="mt-3 pt-2 border-top">
                            <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-primary btn-sm waves-effect waves-light">Edit Profile</a>
                        </div>
                    </div>
                </div> </div>

            <div class="col-lg-8 col-xl-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        
                        <h5 class="mb-3 text-uppercase bg-light p-2 rounded">
                            <i class="mdi mdi-account-box-outline me-1 text-primary"></i> Contact Information
                        </h5>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-2">
                                <label class="form-label text-muted fw-normal mb-0">Email Address</label>
                                <p class="fw-bold text-dark">{{ $supplier->email }}</p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label text-muted fw-normal mb-0">Phone Number</label>
                                <p class="fw-bold text-dark">{{ $supplier->phone }}</p>
                            </div>
                        </div>

                        <h5 class="mb-3 text-uppercase bg-light p-2 rounded">
                            <i class="mdi mdi-bank me-1 text-primary"></i> Banking Details
                        </h5>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted fw-normal mb-0">Account Holder</label>
                                <p class="fw-bold text-dark border-bottom pb-1">{{ $supplier->account_holder }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted fw-normal mb-0">Account Number</label>
                                <p class="fw-bold text-dark border-bottom pb-1">{{ $supplier->account_number }}</p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label text-muted fw-normal mb-0">Bank Name</label>
                                <p class="fw-bold text-dark">{{ $supplier->bank_name }}</p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label text-muted fw-normal mb-0">Bank Branch</label>
                                <p class="fw-bold text-dark">{{ $supplier->bank_branch }}</p>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('supplier.all') }}" class="btn btn-secondary waves-effect">
                                <i class="mdi mdi-arrow-left me-1"></i> Back to List
                            </a>
                        </div>

                    </div>
                </div> </div> </div>
        </div> </div> 
@endsection
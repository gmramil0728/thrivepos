@extends('admin_dashboard')
@section('admin')



<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Profile</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Contacts</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Profile</h4>
                </div>
            </div>
        </div>     
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-4 col-xl-4">
                <div class="card text-center">
                    <div class="card-body">
                        <img src="{{ (!empty($adminData->photo)) ? url('upload/admin_image/'.$adminData->photo) : url('upload/no_image.jpg') }}" class="rounded-circle avatar-lg img-thumbnail"
                        alt="profile-image">

                        <h4 class="mb-0">{{ $adminData->name }}</h4>
                        <p class="text-dark">{{ $adminData->email }}</p>

                        {{-- <button type="button" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Follow</button>
                        <button type="button" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Message</button> --}}

                        <div class="text-start mt-3">
                            <h4 class="font-13 text-uppercase">About Me :</h4>
                            
                            <p class="text-dark mb-2 font-13"><strong>Full Name :</strong> <span class="ms-2">{{ $adminData->lastname }} {{ $adminData->firstname }}</span></p>
                        
                            <p class="text-dark mb-2 font-13"><strong>Mobile :</strong><span class="ms-2">{{ $adminData->phone }}</span></p>
                        
                            <p class="text-dark mb-2 font-13"><strong>Email :</strong> <span class="ms-2">{{ $adminData->email }}</span></p>
                        
                            {{-- <p class="text-dark mb-1 font-13"><strong>Location :</strong> <span class="ms-2">PH</span></p> --}}
                        </div>                                    

                        {{-- <ul class="social-list list-inline mt-3 mb-0">
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                            </li>
                        </ul>    --}}
                    </div>                                 
                </div> <!-- end card -->


            </div> <!-- end col-->

            <div class="col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.profile.changepassword.update') }}">
                            @csrf

                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Change Password</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="old_password" class="form-label">Old Password</label>
                                        <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" placeholder="Enter old password" name = "old_password">
                                        @error('old_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" placeholder="Enter new password" name="new_password">
                                        @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                </div> <!-- end col -->

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="new_password_confirmation" placeholder="Confirm Password" name = "new_password_confirmation">                                       
                                    </div>
                                    
                                </div>


                            </div> <!-- end row -->

                            
                            
                            <div class="text-end">
                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div> <!-- end card-->

            </div> <!-- end col -->
        </div>
        <!-- end row-->

    </div> <!-- container -->

</div> <!-- content -->




@endsection
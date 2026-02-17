@extends('admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Employee</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Employee</h4>
                </div>
            </div>
        </div>     
        <!-- end page title -->

        <div class="row">


            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('employee.update') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $employee->id }}">

                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Edit Employee</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $employee->name }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name = "email" value="{{ $employee->email }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name = "phone" value="{{ $employee->phone }}">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">Address</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" name = "address" value="{{ $employee->address }}">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">Employee Experience</label>
                                        <select name="experience" class="form-select @error('experience') is-invalid @enderror" id="example-select">
                                            <option selected disabled>Select Year</option>
                                            <option value="1 Year" {{ $employee->experience == '1 Year' ? 'selected' : ''}}>1 Year</option>
                                            <option value="2 Year" {{ $employee->experience == '2 Year' ? 'selected' : ''}}>2 Year</option>
                                            <option value="3 Year" {{ $employee->experience == '3 Year' ? 'selected' : ''}}>3 Year</option>
                                            <option value="4 Year" {{ $employee->experience == '4 Year' ? 'selected' : ''}}>4 Year</option>
                                            <option value="5 Year" {{ $employee->experience == '5 Year' ? 'selected' : ''}}>5 Year</option>
                                        </select>
                                        @error('experience')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="salary" class="form-label">Salary</label>
                                        <input type="text" class="form-control @error('salary') is-invalid @enderror" name = "salary" value="{{ $employee->salary }}">
                                        @error('salary')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="salary" class="form-label">Vacation</label>
                                        <input type="text" class="form-control @error('vacation') is-invalid @enderror" name = "vacation" value="{{ $employee->vacation }}">
                                        @error('vacation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="salary" class="form-label">City</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" name = "city" value="{{ $employee->city }}">
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="example-fileinput" class="form-label">Select Profile picture</label>
                                        <input type="file" id="image" name="image" class="form-control" @error('image') is-invalid @enderror>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="example-fileinput" class="form-label"></label>
                                        <img id="showImage" src="{{ (!empty($employee->image)) ? url($employee->image) : url('upload/no_image.jpg') }}" class="rounded-circle avatar-lg img-thumbnail"
                        alt="profile-image">
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


<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        })
    })

</script>

@endsection
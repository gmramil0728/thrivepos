<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Log In | Thrive ICT Solutions Corp</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('backend/assets/images/favicon.ico')}}">

		<!-- Bootstrap css -->
		<link href="{{asset('backend/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
		<!-- App css -->
		<link href="{{asset('backend/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style"/>
		<!-- icons -->
		<link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
		<!-- Head js -->
		<script src="{{asset('backend/assets/js/head.js')}}"></script>

        <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/toastr.css')}}" >

        

        

    </head>

    <body class="authentication-bg authentication-bg-pattern">

        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <div class="account-pages mt-5 mb-5">
                        <div class="container">
                            <div class="row justify-content-end">
                                <div class="col-md-8 col-lg-6 col-xl-4">
                                    <div class="card bg-pattern">
            
                                        <div class="card-body p-4">
                                            
                                            <div class="text-center w-100 m-auto">
                                                <div class="auth-logo">
                                                    <a href="" class="logo logo-dark text-center">
                                                        <span class="logo-lg">
                                                            <img src="{{asset('backend/assets/images/logo-dark.png')}}" alt="" height="40">
                                                        </span>
                                                    </a>
                                                                        
                                                </div>                                    
            
                                                <h3 class="bg-primary text-white py-1 px-1">
                                                    Point of Sale System
                                                </h3>
                                                
            
                                                <p class="text-muted mb-4 mt-3"></p>
                                            </div>
            
                                            
            
                                            <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-pill waves-effect waves-light w-100">Go to Dashboard</a>
                                            
                                        </div> <!-- end card-body -->
                                    </div>
                                    <!-- end card -->
            
                                    <div class="row mt-3">
                                        <div class="col-12 text-center">
                                        
                                        </div> <!-- end col -->
                                    </div>
                                    <!-- end row -->
            
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end container -->
                    </div>
                @else
                    <div class="account-pages mt-5 mb-5">
                        <div class="container">
                            <div class="row justify-content-end">
                                <div class="col-md-8 col-lg-6 col-xl-4">
                                    <div class="card bg-pattern">
            
                                        <div class="card-body p-4">
                                            
                                            <div class="text-center w-100 m-auto">
                                                <div class="auth-logo">
                                                    <a href="" class="logo logo-dark text-center">
                                                        <span class="logo-lg">
                                                            <img src="{{asset('backend/assets/images/logo-dark.png')}}" alt="" height="40">
                                                        </span>
                                                    </a>
                                                                        
                                                </div>                                    
            
                                                <h3 class="bg-primary text-white py-1 px-1">
                                                    Point of Sale System
                                                </h3>
                                                
            
                                                <p class="text-muted mb-4 mt-3"></p>
                                            </div>
            
                                            
            
                                            <form method="POST" action="{{ route('login') }}">
                                                @csrf
            
                                                <div class="mb-3">
                                                    <label for="login" class="form-label">Username</label>
                                                    <input class="form-control @error('login') is-invalid @enderror" type="text" id="login" name="login" placeholder="Enter your username">
                                                    @error('login')
                                                        <span class="text-danger"> {{ $message }} </span>
                                                    @enderror
                                                </div>
            
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password">
                                                        <div class="input-group-text" data-password="false">
                                                            <span class="password-eye"></span>
                                                        </div>
                                                    </div>
                                                    @error('password')
                                                        <span class="text-danger"> {{ $message }} </span>
                                                    @enderror
                                                </div>
            
                                                {{-- <div class="mb-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                                    </div>
                                                </div> --}}
            
                                                
            
                                                <div class="text-center d-grid">
                                                    <button class="btn btn-primary" type="submit"> Log In </button>
                                                </div>
            
                                            </form>
                                            
                                        </div> <!-- end card-body -->
                                    </div>
                                    <!-- end card -->
            
                                    <div class="row mt-3">
                                        <div class="col-12 text-center">
                                        
                                        </div> <!-- end col -->
                                    </div>
                                    <!-- end row -->
            
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end container -->
                    </div>
                @endauth
            </div>
        @endif
        

        
        <!-- end page -->


        <footer class="footer footer-alt">
            <script>document.write(new Date().getFullYear())</script> &copy; POS by <a href="" class="text-white-50">Thrive ICT Solutions Corp</a> 
        </footer>

        <!-- Vendor js -->
        <script src="{{asset('backend/assets/js/vendor.min.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('backend/assets/js/app.min.js')}}"></script>

        <script type="text/javascript" src="{{ asset('backend/assets/js/toastr.min.js') }}"></script>

        <script>
            @if(Session::has('message'))
            var type = "{{ Session::get('alert-type','info') }}"
            switch(type){
               case 'info':
               toastr.info(" {{ Session::get('message') }} ");
               break;
           
               case 'success':
               toastr.success(" {{ Session::get('message') }} ");
               break;
           
               case 'warning':
               toastr.warning(" {{ Session::get('message') }} ");
               break;
           
               case 'error':
               toastr.error(" {{ Session::get('message') }} ");
               break; 
            }
            @endif 
        </script>
        
    </body>
</html>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Thrive POS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Thrive ICT Solutions POS" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('backend/assets/images/favicon.png')}}">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Plugins css -->
        <link href="{{asset('backend/assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('backend/assets/libs/selectize/css/selectize.bootstrap3.css')}}" rel="stylesheet" type="text/css" />
        
        <!-- Bootstrap css -->
        <link href="{{asset('backend/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App css -->
        <link href="{{asset('backend/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style"/>
        <!-- icons -->
        <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Head js -->
        <script src="{{asset('backend/assets/js/head.js')}}"></script>

        <!-- third party css - datatable -->
        <link href="{{asset('backend/assets/libs/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/assets/libs/datatables/css/responsive.dataTables.min.css')}}" rel="stylesheet">

        <style>
            /* Add padding to the whole DataTable wrapper */
            .dataTables_wrapper {
                padding: 1.5rem; /* This creates the edge clearance */
            }
        
            /* Fix table-responsive overflow issues */
            .table-responsive {
                padding: 5px; /* Prevents shadow clipping on hover */
                border: none !important;
            }
        
            /* Style the search input to look modern */
            .dataTables_filter input {
                border-radius: 20px;
                padding: 6px 15px;
                border: 1px solid #dee2e6;
                outline: none;
            }
        
            /* Adjust the spacing between the table and the controls */
            #basic-datatable {
                margin-top: 20px !important;
                margin-bottom: 20px !important;
                border-collapse: separate !important;
                border-spacing: 0 8px !important; /* Adds vertical space between rows */
            }
        
            /* Optional: Add a subtle border to the table to define the edges */
            #basic-datatable tbody tr {
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.03);
                transition: transform 0.2s;
            }
        </style>
        
    </head>

    <!-- body start -->
    <body data-layout-mode="default" data-theme="light" data-topbar-color="light" data-menu-position="fixed" data-leftbar-color="dark" data-leftbar-size='default' data-sidebar-user='false'>

        {{-- <div id="preloader"><div id="status"><div class="spinner-border text-primary"></div></div></div> --}}



        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            @include('body.header')
            <!-- Topbar End -->

            <!-- ========== Left Sidebar Start ========== -->
            @include('body.sidebar')
            <!-- ========== Left Sidebar End  ========== -->



            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                
                @yield('admin')

                <!-- Footer Start -->
                @include('body.footer')
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->

        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="{{asset('backend/assets/js/vendor.min.js')}}"></script>

        <script src="{{ asset('backend/assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/jquery.validate.min.js') }}"></script>

        {{-- <script src="{{ asset('backend/assets/js/toastr.min.js') }}"></script> --}}
        {{-- SWEET ALERT --}}
        <script src="{{asset('backend/assets/js/sweetalert2@10.js')}}"></script>
        
        <script src="{{ asset('backend/assets/js/code.js') }}"></script>

        

        <!-- Plugins js-->
        <script src="{{asset('backend/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
        <script src="{{asset('backend/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

        <script src="{{asset('backend/assets/libs/selectize/js/standalone/selectize.min.js')}}"></script>

    
        
        @if(Route::currentRouteName() == 'dashboard')
            <!-- Dashboar 1 init js-->
            <script src="{{ asset('backend/assets/js/pages/dashboard-1.init.js') }}"></script>
        @endif

        
        <!-- third party js - datatable-->
        <script src="{{asset('backend/assets/libs/datatables/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('backend/assets/libs/datatables/js/dataTables.responsive.min.js')}}"></script>        

        

        <!-- App js-->

        {{-- <script src="{{asset('backend/assets/js/app.min.js')}}"></script> --}}
        <script src="{{asset('backend/assets/js/app.min.js')}}" defer></script>

        {{-- auto logout on idle --}}
        {{-- <script>
            let timeout;
            document.onmousemove = document.onkeypress = function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    window.location.href = "{{ route('admin.logout') }}";
                }, 900000); // 15 minutes
            };
        </script> --}}

        {{-- <script>
            window.addEventListener("load", function(){
                document.getElementById("preloader").style.display = "none";
            });
        </script> --}}
    
        {{-- <script>
            // SweetAlert Notifications
            @if(session('message'))
                Swal.fire({
                    icon: '{{ session('alert-type') }}',
                    title: '{{ session('alert-type') == 'success' ? 'Success!' : (session('alert-type') == 'error' ? 'Error!' : 'Info') }}',
                    text: '{{ session('message') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif    
        </script> --}}

            
        

        @yield('jscripts')
        
        
    </body>
</html>
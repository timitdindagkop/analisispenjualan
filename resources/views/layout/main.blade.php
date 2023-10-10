
<!DOCTYPE html>
<html lang="en">

    
<!-- Mirrored from coderthemes.com/moltran/layouts/blue-vertical/ui-cards.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Jun 2020 04:30:20 GMT -->
<head>
        <meta charset="utf-8" />
        <title>{{ $title }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Responsive bootstrap 4 admin template" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="/assets/images/favicon.ico">

        <!-- App css -->
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />
        @stack('css')
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            
            <!-- Topbar Start -->
            <div class="navbar-custom">
                <ul class="list-unstyled topnav-menu float-right mb-0">

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="/assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-face-profile"></i>
                                <span>Profile</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- item-->
                            <a href="#" class="dropdown-item notify-item" data-toggle="modal" data-target=".modalKeluar">
                                <i class="mdi mdi-power-settings"></i>
                                <span>Keluar</span>
                            </a>

                        </div>
                    </li>

                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                        <a href="{{ url('/') }}" class="logo text-center logo-dark">
                            <span class="logo-lg">
                                {{-- <img src="/assets/images/logo-dark.png" alt="" height="16"> --}}
                                <span class="logo-lg-text-dark">Analisis</span>
                            </span>
                            <span class="logo-sm">
                                <span class="logo-lg-text-dark">AN</span>
                                {{-- <img src="/assets/images/logo-sm.png" alt="" height="25"> --}}
                            </span>
                        </a>

                        <a href="{{ url('/') }}" class="logo text-center logo-light">
                            <span class="logo-lg">
                                {{-- <img src="/assets/images/logo-light.png" alt="" height="16"> --}}
                                <span class="logo-lg-text-dark">Analisis</span>
                            </span>
                            <span class="logo-sm">
                                <span class="logo-lg-text-dark">AN</span>
                                {{-- <img src="/assets/images/logo-sm.png" alt="" height="25"> --}}
                            </span>
                        </a>
                    </div>

                <!-- LOGO -->
  

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile waves-effect waves-light">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </li>
                </ul>
            </div>
            <!-- end Topbar --> 
            
            @include('layout.sidebar')

            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    @yield('container')
                    <!--  Modal content for the above example -->
                    <div class="modal fade modalKeluar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title text-white" id="myLargeModalLabel">Modal Keluar</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    anda yakin ingin keluar ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Batal</button>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Keluar</button>
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
                <!-- end content -->


                

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                {{ date('Y') }} &copy; Analisis penjualan
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <!-- Vendor js -->
        <script src="/assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="/assets/js/app.min.js"></script>
        @stack('js')
    </body>


<!-- Mirrored from coderthemes.com/moltran/layouts/blue-vertical/ui-cards.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Jun 2020 04:30:20 GMT -->
</html>

<!DOCTYPE html>
<html lang="en">

    
<!-- Mirrored from coderthemes.com/moltran/layouts/blue-vertical/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Jun 2020 04:31:41 GMT -->
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

    </head>

    <body class="authentication-page">

        <div class="account-pages my-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-header bg-primary p-5 position-relative">
                                <div class="bg-overlay"></div>
                                <h4 class="text-white text-center mb-0">Toko Kedelai Lil Luk Ma</h4>
                            </div>
                            <div class="card-body p-4 mt-2">
                                @if (session()->has('loginError'))
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        {{ session('loginError') }}
                                    </div>
                                @endif
                                <form action="{{ url('auth') }}" method="post" class="p-3">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <input class="form-control" type="text" name="username" id="username" required="" placeholder="Username" value="{{ old('username') }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <input class="form-control" type="password" name="password" id="password" required="" placeholder="Password">
                                    </div>

                                    <div class="form-group text-center mt-5 mb-4">
                                        <button class="btn btn-lg btn-primary waves-effect width-md waves-light" type="submit"> Masuk </button>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-sm-12 text-center">
                                            Analisis penjualan
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <!-- end row -->

                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

            </div>
        </div>

        <!-- Vendor js -->
        <script src="/assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="/assets/js/app.min.js"></script>

    </body>


<!-- Mirrored from coderthemes.com/moltran/layouts/blue-vertical/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Jun 2020 04:31:41 GMT -->
</html>
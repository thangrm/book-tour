<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admins/assets/images/favicon.png') }} ">
    <title>Forgot Password Admin | Ngao Du</title>
    <!-- Custom CSS -->
    <link href="{{ asset('admins/dist/css/style.min.css') }}  " rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="main-wrapper">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
         style="background:url({{ asset('admins/assets/images/big/auth-bg.jpg') }}) no-repeat center center;">
        <div class="auth-box">
            <div id="recoverform" style="display: block">
                <div class="logo">
                    <span class="db"><img src="{{ asset('admins/assets/images/logo-icon.png') }}" alt="logo"/></span>
                    <h5 class="font-medium m-b-20">Recover Password</h5>
                    @if(Session::has('status'))
                        <span class="text-success">{{ Session::get('status')}}</span>
                    @else
                        <span>Enter your Email and instructions will be sent to you!</span>
                    @endif
                </div>
                @if(!Session::has('status'))
                    <div class="row m-t-20">
                        <!-- Form -->
                        <form class="col-12" method="POST" action="{{ route('admin.password.email') }}">
                        @csrf
                        <!-- email -->
                            <div class="form-group row">
                                @if(Session::has('status'))
                                    <div class="col-12">
                                        <p class="text-success">  {{ Session::get('status')}}</p>
                                    </div>
                                @endif
                                <div class="col-12">
                                    <input class="form-control form-control-lg" type="email" name="email"
                                           placeholder="Email" value="{{ old('email')  }}">
                                </div>
                                @error('email')
                                <div class="col-12">
                                    <span class="text-danger"> {{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                            <!-- pwd -->
                            <div class="row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-block btn-lg btn-danger" type="submit" name="action">Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper scss in scafholding.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper scss in scafholding.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- All Required js -->
<!-- ============================================================== -->
<script src="{{ asset('admins/assets/libs/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('admins/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('admins/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- ============================================================== -->
<!-- This page plugin js -->
<!-- ============================================================== -->
<script>
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function () {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
</script>
</body>

</html>

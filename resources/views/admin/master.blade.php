<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admins/assets/images/favicon.png') }}">
    <title>Dashboard</title>
    <!-- Datatable -->
    <link href="{{ asset('admins/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <!--Bootstrap switch -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admins/assets/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }} ">
    <!-- Custom CSS -->
    <link href="{{ asset('admins/assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admins/assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('admins/assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admins/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .ck-editor__editable {
            min-height: 200px;
        }
    </style>
    @yield('style')
</head>

<body>
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
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar">
        @include('admin.layouts.nav');
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
    @include('admin.layouts.sidebar')
    <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">

    @yield('admin')
    <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
    @include('admin.layouts.footer')
    <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('admins/assets/libs/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('admins/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('admins/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- apps -->
<script src="{{ asset('admins/dist/js/app.min.js') }}"></script>
<script src="{{ asset('admins/dist/js/app.init.js') }}"></script>
<script src="{{ asset('admins/dist/js/app-style-switcher.js') }}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('admins/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('admins/assets/extra-libs/sparkline/sparkline.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('admins/dist/js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('admins/dist/js/sidebarmenu.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('admins/dist/js/custom.min.js') }}"></script>
<!--This page JavaScript -->
<script src=" {{ asset('admins/assets/libs/toastr/build/toastr.min.js') }} "></script>
<script src=" {{ asset('admins/assets/extra-libs/toastr/toastr-init.js') }} "></script>
<!-- sweetalert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--datatable -->
<script src="{{ asset('admins/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
<!--CK editor-->
{{--<script src="{{ asset('/admins/assets/libs/ckeditor/ckeditor.js') }}"></script>--}}
<script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function toastrMessage(type, message) {
        switch (type) {
            case 'info':
                toastr.info(message);
                break;
            case 'success':
                toastr.success(message);
                break;
            case 'warning':
                toastr.warning(message);
                break;
            case 'error':
                toastr.error(message);
                break;
        }
    }

    function disableSubmitButton(idForm) {
        $(idForm).submit(function () {
            $(this).find("button[type='submit']").prop('disabled', true);
        });
    }

    function enableSubmitButton(idForm, delay = 0) {
        setTimeout(function () {
            $(idForm).find("button[type='submit']").prop('disabled', false);
        }, delay);
    }

    @if(Session::has('message'))
    let type = "{{ Session::get('alert-type','info') }}";
    let message = "{{ Session::get('message') }}";
    toastrMessage(type, message);
    @endif

</script>
@yield('js')
</body>

</html>

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

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/assets/images/favicon.png') }}">
    <title>Dashboard</title>
    <!-- Datatable -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <!--Bootstrap switch -->
    <link rel="stylesheet" type="text/css"
          href=" {{ asset('admin/assets/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }} ">
    <!-- Custom CSS -->
    <link href="{{ asset('admin/assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href=" {{ asset('admin/assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('admin/dist/css/style.min.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
<script src="{{ asset('admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('admin/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- apps -->
<script src="{{ asset('admin/dist/js/app.min.js') }}"></script>
<script src="{{ asset('admin/dist/js/app.init.js') }}"></script>
<script src="{{ asset('admin/dist/js/app-style-switcher.js') }}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/extra-libs/sparkline/sparkline.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('admin/dist/js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('admin/dist/js/sidebarmenu.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('admin/dist/js/custom.min.js') }}"></script>
<!--Bootstrap switch -->
<script src="{{asset('admin/assets/libs/bootstrap-switch/dist/js/bootstrap-switch.min.js')}}"></script>
<!--This page JavaScript -->
<!--chartis chart-->
{{--<script src="{{ asset('admin/assets/libs/chartist/dist/chartist.min.js') }}"></script>--}}
<!--c3 charts -->
{{--<script src="{{ asset('admin/assets/extra-libs/c3/d3.min.js') }}"></script>--}}
{{--<script src="{{ asset('admin/assets/extra-libs/c3/c3.min.js') }}"></script>--}}
<!--chartjs -->
{{--<script src="{{ asset('admin/assets/libs/chart.js/dist/Chart.min.js') }}"></script>--}}
{{--<script src="{{ asset('admin/dist/js/pages/dashboards/dashboard1.js') }}"></script>--}}
<!-- toastr -->
<script src=" {{ asset('admin/assets/libs/toastr/build/toastr.min.js') }} "></script>
<script src=" {{ asset('admin/assets/extra-libs/toastr/toastr-init.js') }} "></script>
<!-- sweetalert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--datatable -->
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    @if(Session::has('message'))
    let type = "{{ Session::get('alert-type','info') }}"
    switch (type) {
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;
        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;
        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;
        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function disableSubmitButton(idForm) {
        $(idForm).submit(function () {
            $(this).find("button[type='submit']").prop('disabled', true);
        });
    }

</script>
@yield('js')
</body>

</html>

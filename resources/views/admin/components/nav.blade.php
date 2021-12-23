<nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <div class="navbar-header">
        <!-- This is for the sidebar toggle which is visible on mobile only -->
        <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                class="ti-menu ti-close"></i></a>
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <!-- Logo icon -->
            <b class="logo-icon">
                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                <!-- Dark Logo icon -->
                <img src="{{ asset('admin/assets/images/logo-icon.png') }}" alt="homepage" class="dark-logo"/>
                <!-- Light Logo icon -->
                <img src="{{ asset('admin/assets/images/logo-light-icon.png') }}" alt="homepage"
                     class="light-logo"/>
            </b>
            <!--End Logo icon -->
            <!-- Logo text -->
            <span class="logo-text">
                 <!-- dark Logo text -->
                 <img src="{{ asset('admin/assets/images/logo-text.png') }}" alt="homepage"
                      class="dark-logo"/>
                <!-- Light Logo text -->
                 <img src="{{ asset('admin/assets/images/logo-light-text.png') }}" class="light-logo"
                      alt="homepage"/>
            </span>
        </a>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Toggle which is visible on mobile only -->
        <!-- ============================================================== -->
        <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
           data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
           aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
    </div>
    <!-- ============================================================== -->
    <!-- End Logo -->
    <!-- ============================================================== -->
    <div class="navbar-collapse collapse" id="navbarSupportedContent">
        <!-- ============================================================== -->
        <!-- toggle and nav items -->
        <!-- ============================================================== -->
        <ul class="navbar-nav float-left mr-auto">
            <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light"
                                                      href="javascript:void(0)" data-sidebartype="mini-sidebar"><i
                        class="mdi mdi-menu font-24"></i></a></li>

            <!-- ============================================================== -->
            <!-- Search -->
            <!-- ============================================================== -->
            {{--            <li class="nav-item search-box"><a class="nav-link waves-effect waves-dark"--}}
            {{--                                               href="javascript:void(0)"><i class="ti-search"></i></a>--}}
            {{--                <form class="app-search position-absolute">--}}
            {{--                    <input type="text" class="form-control" placeholder="Search &amp; enter"> <a--}}
            {{--                        class="srh-btn"><i class="ti-close"></i></a>--}}
            {{--                </form>--}}
            {{--            </li>--}}
        </ul>
        <!-- ============================================================== -->
        <!-- Right side toggle and nav items -->
        <!-- ============================================================== -->
    </div>
</nav>

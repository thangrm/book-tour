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
                <img src="{{ asset('admins/assets/images/logo-icon.png') }}" alt="homepage" class="dark-logo"/>
                <!-- Light Logo icon -->
                <img src="{{ asset('admins/assets/images/logo-light-icon.png') }}" alt="homepage"
                     class="light-logo"/>
            </b>
            <!--End Logo icon -->
            <!-- Logo text -->
            <span class="logo-text">
                 <!-- dark Logo text -->
                 <img src="{{ asset('admins/assets/images/logo-text.png') }}" alt="homepage"
                      class="dark-logo"/>
                <!-- Light Logo text -->
                 <img src="{{ asset('admins/assets/images/logo-light-text.png') }}" class="light-logo"
                      alt="homepage"/>
            </span>
        </a>
        <hr>
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
        <ul class="navbar-nav float-right">
            <!-- ============================================================== -->
            <!-- create new -->
            <!-- ============================================================== -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="flag-icon flag-icon-us"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right  animated bounceInDown" aria-labelledby="navbarDropdown2">
                    <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-us"></i> English</a>
                    <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a>
                    <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-es"></i> Spanish</a>
                    <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> German</a>
                </div>
            </li>
            <!-- ============================================================== -->
            <!-- Comment -->
            <!-- ============================================================== -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell font-24"></i>

                </a>
                <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                    <span class="with-arrow"><span class="bg-primary"></span></span>
                    <ul class="list-style-none">
                        <li>
                            <div class="drop-title bg-primary text-white">
                                <h4 class="mb-0 mt-1">4 New</h4>
                                <span class="font-light">Notifications</span>
                            </div>
                        </li>
                        <li>
                            <div class="message-center notifications ps-container ps-theme-default"
                                 data-ps-id="4318897e-9852-0141-ae5e-28026d0231cb">
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item">
                                    <span class="btn btn-danger btn-circle"><i class="fa fa-link"></i></span>
                                    <div class="mail-contnet">
                                        <h5 class="message-title">Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span>
                                        <span class="time">9:30 AM</span></div>
                                </a>
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item">
                                    <span class="btn btn-success btn-circle"><i class="ti-calendar"></i></span>
                                    <div class="mail-contnet">
                                        <h5 class="message-title">Event today</h5> <span class="mail-desc">Just a reminder that you have event</span>
                                        <span class="time">9:10 AM</span></div>
                                </a>
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item">
                                    <span class="btn btn-info btn-circle"><i class="ti-settings"></i></span>
                                    <div class="mail-contnet">
                                        <h5 class="message-title">Settings</h5> <span class="mail-desc">You can customize this template as you want</span>
                                        <span class="time">9:08 AM</span></div>
                                </a>
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item">
                                    <span class="btn btn-primary btn-circle"><i class="ti-user"></i></span>
                                    <div class="mail-contnet">
                                        <h5 class="message-title">Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span>
                                        <span class="time">9:02 AM</span></div>
                                </a>
                                <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                                    <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;">
                                    <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link text-center mb-1 text-dark" href="javascript:void(0);"> <strong>Check all
                                    notifications</strong> <i class="fa fa-angle-right"></i> </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- ============================================================== -->
            <!-- End Comment -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Messages -->
            <!-- ============================================================== -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false"> <i class="font-24 mdi mdi-comment-processing"></i>

                </a>
                <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" aria-labelledby="2">
                    <span class="with-arrow"><span class="bg-danger"></span></span>
                    <ul class="list-style-none">
                        <li>
                            <div class="drop-title text-white bg-danger">
                                <h4 class="mb-0 mt-1">5 New</h4>
                                <span class="font-light">Messages</span>
                            </div>
                        </li>
                        <li>
                            <div class="message-center message-body ps-container ps-theme-default"
                                 data-ps-id="b8d9d225-bb12-a4ce-200a-5991cbd7125b">
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item">
                                    <span class="user-img"> <img src="{{ asset('/admins/assets/images/users/1.jpg') }}"
                                                                 alt="user"
                                                                 class="rounded-circle"> <span
                                            class="profile-status online pull-right"></span> </span>
                                    <div class="mail-contnet">
                                        <h5 class="message-title">Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span>
                                        <span class="time">9:30 AM</span></div>
                                </a>
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item">
                                    <span class="user-img"> <img
                                            src=" {{ asset('/admins/assets/images/users/2.jpg') }} " alt="user"
                                            class="rounded-circle"> <span
                                            class="profile-status busy pull-right"></span> </span>
                                    <div class="mail-contnet">
                                        <h5 class="message-title">Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span>
                                        <span class="time">9:10 AM</span></div>
                                </a>
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item">
                                    <span class="user-img"> <img
                                            src="{{ asset('/admins/assets/images/users/3.jpg') }}" alt="user"
                                            class="rounded-circle"> <span
                                            class="profile-status away pull-right"></span> </span>
                                    <div class="mail-contnet">
                                        <h5 class="message-title">Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span>
                                        <span class="time">9:08 AM</span></div>
                                </a>
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item">
                                    <span class="user-img"> <img src="{{ asset('/admins/assets/images/users/4.jpg') }}"
                                                                 alt="user"
                                                                 class="rounded-circle"> <span
                                            class="profile-status offline pull-right"></span> </span>
                                    <div class="mail-contnet">
                                        <h5 class="message-title">Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span>
                                        <span class="time">9:02 AM</span></div>
                                </a>
                                <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                                    <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;">
                                    <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link text-center link text-dark" href="javascript:void(0);"> <b>See all
                                    e-Mails</b> <i class="fa fa-angle-right"></i> </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- ============================================================== -->
            <!-- End Messages -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                        src="{{ asset('admins/assets/images/users/1.jpg') }}" alt="user" class="rounded-circle"
                        width="31"></a>
                <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                    <span class="with-arrow"><span class="bg-primary"></span></span>
                    <div class="d-flex no-block align-items-center p-15 bg-primary text-white mb-2">
                        <div class="ml-2">
                            <h4 class="mb-0">{{ \Illuminate\Support\Facades\Auth::user()->name }}</h4>
                            <p class=" mb-0">{{ \Illuminate\Support\Facades\Auth::user()->email }}</p>
                        </div>
                    </div>
                    <a class="dropdown-item" href="{{ route('admin.password.change') }}">
                        <i class="ti-user mr-1 ml-1"></i> Change Password
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}">
                        <i class="fa fa-power-off mr-1 ml-1"></i> Logout
                    </a>
                </div>
            </li>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
        </ul>
    </div>
</nav>

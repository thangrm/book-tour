<div class="scroll-sidebar">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
        <ul id="sidebarnav">
            <!-- User Profile-->
            <li>
                <!-- User Profile-->
                <div class="user-profile d-flex no-block dropdown mt-3">
                    <div class="user-pic"><img src="{{ asset('admin/assets/images/users/1.jpg') }}" alt="users"
                                               class="rounded-circle" width="40"/></div>
                    <div class="user-content hide-menu ml-2">
                        <a href="javascript:void(0)" class="" id="Userdd" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <h5 class="mb-0 user-name font-medium">
                                {{ \Illuminate\Support\Facades\Auth::user()->name }}
                                <i class="fa fa-angle-down"></i>
                            </h5>
                            <span class="op-5 user-email">{{ \Illuminate\Support\Facades\Auth::user()->email }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="User">
                            <a class="dropdown-item" href="{{ route('admin.password.change') }}">
                                <i class="ti-user mr-1 ml-1"></i>Change Password
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                <i class="fa fa-power-off mr-1 ml-1"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End User Profile-->
            </li>
            <!-- User Profile-->
            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark"
                   href="{{ route('admin.dashboard') }}" aria-expanded="false">
                    <i class="mdi mdi-view-dashboard"></i>
                    <span class="hide-menu">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark"
                   href="{{ route('destinations.index') }}" aria-expanded="false">
                    <i class="mdi mdi-map-marker"></i>
                    <span class="hide-menu">Destinations</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark"
                   href="{{ route('types.index') }}" aria-expanded="false">
                    <i class="mdi mdi-format-list-bulleted-type"></i>
                    <span class="hide-menu">Type of tours</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark"
                   href="{{ route('tours.index') }}" aria-expanded="false">
                    <i class="mdi mdi-wallet-travel"></i>
                    <span class="hide-menu">Tours</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark"
                   href="javascript:void(0)" aria-expanded="false">
                    <i class="mdi mdi-calendar"></i>
                    <span class="hide-menu">Bookings</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark"
                   href="javascript:void(0)" aria-expanded="false">
                    <i class="mdi mdi-account-box"></i>
                    <span class="hide-menu">Contacts</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>

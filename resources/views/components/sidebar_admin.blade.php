<div class="scroll-sidebar">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
        <ul id="sidebarnav">
            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark"
                   href="{{ route('admin.dashboard') }}" aria-expanded="false">
                    <i class="mdi mdi-view-dashboard"></i>
                    <span class="hide-menu">Tổng quan</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark"
                   href="{{ route('destinations.index') }}" aria-expanded="false">
                    <i class="mdi mdi-map-marker"></i>
                    <span class="hide-menu">Điếm đến</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark"
                   href="{{ route('types.index') }}" aria-expanded="false">
                    <i class="mdi mdi-format-list-bulleted-type"></i>
                    <span class="hide-menu">Thể loại tour</span>
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
                   href="{{ route('coupons.index') }}" aria-expanded="false">
                    <i class="mdi mdi-gift"></i>
                    <span class="hide-menu">Mã giảm giá</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark"
                   href="{{ route('bookings.index') }}" aria-expanded="false">
                    <i class="mdi mdi-calendar"></i>
                    <span class="hide-menu">Đặt tours</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark"
                   href="{{ route('contacts.index') }}" aria-expanded="false">
                    <i class="mdi mdi-account-box"></i>
                    <span class="hide-menu">Liên hệ</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>

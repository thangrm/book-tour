<div class="header" id="travelHeader">
    <div class="container mb-2">
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo-brand">
                <a href="{{ route('index') }}">
                    <img src="{{ asset('images/logo-black.png') }}" width="100" alt="logo-brand">
                </a>
            </div>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="navbar-toggler border-0">
                    <div id="nav-icon1">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav justify-content-center" id="navHeader">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('index') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('client.destination.index') }}">Destinations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('client.search.index') }}">Tours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('client.contact.index') }}">Contact</a>
                        </li>

                        <div class="navigator-bar" id="navigatorBar"></div>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>

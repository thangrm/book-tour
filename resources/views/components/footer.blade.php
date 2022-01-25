<footer class="footer">
    <div class="footer-info pt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-xxl-5">
                    <div class="footer-logo">
                        <img class="pb-5" src="{{ asset('images/logo.png') }}" alt="ngaodu">
                        <div class="footer-social">
                            <img src="{{ asset('images/icon/facebook.svg') }}" alt="facebook">
                            <img src="{{ asset('images/icon/instagram.svg') }}" alt="instagram">
                            <img src="{{ asset('images/icon/twitter.svg') }}" alt="twitter">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-xxl-4">
                    <div class="footer-nav row">
                        <div class="col-6 col-sm-5 col-md-4 col-lg-6 p-0">
                            <nav class="nav flex-column">
                                <a class="nav-link" href="{{ route('index') }}">Home</a>
                                <a class="nav-link" href="#">About</a>
                                <a class="nav-link" href="#">Tours</a>
                                <a class="nav-link" href="#">Hotels</a>
                                <a class="nav-link" href="{{ route('client.contact.index') }}">Contact</a>
                            </nav>
                        </div>
                        <div class="col-6 col-sm-7 col-md-8 col-lg-6 p-0">
                            <nav class="nav flex-column">
                                <a class="nav-link" href="#">Partner with us </a>
                                <a class="nav-link" href="#">Terms & Conditions</a>
                                <a class="nav-link" href="#">Privacy Policy</a>
                                <a class="nav-link" href="#">Guest Policy</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-xl-3">
                    <div class="footer-contact">
                        <div class="contact-item d-flex align-items-start">
                            <div class="icon-contact">
                                <img class="fill-white" src="{{ asset('images/icon/location.svg') }}" alt="address">
                            </div>
                            <p style="margin-left: 5px;">
                                <a href="#">Lilama 10 Tower, 56 To Huu, Trung Van, Nam Tu Liem, Ha Noi</a>
                            </p>
                        </div>
                        <div class="contact-item">
                            <div class="icon-contact">
                                <img class="fill-white" src="{{ asset('images/icon/mail.svg') }}" alt="email">
                            </div>
                            <p><a href="mailto:hello@adamotravel.com">hello@adamotravel.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <span>Copyright © We.travel.  All rights reserved</span>
    </div>
</footer>

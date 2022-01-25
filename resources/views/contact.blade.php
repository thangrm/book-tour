@extends('layouts.client')
@section('content')
    <!-------------------- Header -------------------->
    <div class="header header-contact">
        <!--Logo and Nav -->
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('index') }}">
                    <img class="logo" src="{{ asset('images/logo.png') }}" alt="logo">
                </a>
                <nav class="navbar navbar-expand-sm navbar-dark">
                    <button class="navbar-toggler" id="navbarBtn" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false"
                            aria-label="Toggle navigation">
                        <span class="navbar-icon-close">X</span>
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarToggler">
                        <ul class="nav navbar-header flex-column flex-sm-row">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('index') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Tours</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Hotels</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Contact</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Login</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--End Logo and Nav -->

        <!-- Text Header -->
        <div class="container box-content-header">
            <div class="row">
                <div class="col-12 col-xxl-8 col-lg-7 p-0">
                    <div class="text-header">
                        <p class="text-slogan">Contact Us</p>
                    </div>
                </div>
            </div>
        </div>
        <!--End Text Header -->
    </div>
    <!-------------------- End Header -------------------->

    <!-------------------- Breadcrumb -------------------->
    <div class="breadcrumb-wrap">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: ''" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                    <li class="breadcrumb-item">Contact Us</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-------------------- End Breadcrumb -------------------->

    <!-------------------- Contact -------------------->
    <div class="box-contact">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <p class="contact-title">We'd love to hear from you</p>
                    <p class="contact-text">Send us a message and we'll respond as soon as possible</p>
                    <form action="{{ route('client.contact.store') }}" class="form-contact" id="formContact"
                          method="post">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" placeholder="Your Name" name="name"
                                   value="{{ old('name') }}">
                            <span class="text-danger" id="errorName"></span>
                            @error('name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="email" placeholder="Your Email" name="email"
                                   value="{{ old('email') }}">
                            <span class="texet-danger" id="errorEmail"></span>
                            @error('email')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="phone" placeholder="Your Phone" name="phone"
                                   value="{{ old('phone') }}">
                            <span class="text-danger" id="errorPhone"></span>
                            @error('phone')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea type="text" class="form-control" id="message" rows="5"
                                      placeholder="Messager" name="message">{{ old('message') }}</textarea>
                            <span class="text-danger" id="errorMessage"></span>
                            @error('message')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-100 d-flex justify-content-end">
                            <button type="submit">Send Message</button>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="office">
                        <img class="office-background" src="images/introduce1.png" alt="introduce">
                        <div class="info-office">
                            <p class="office-title">Our Office</p>
                            <div class="info-office-item">
                                <img src="images/icon/home.svg" alt="address">
                                <div class="text-item">
                                    <p class="text-title">Address</p>
                                    <p class="text-content">27 Old Gloucester Street, London, WC1N 3AX</p>
                                </div>
                            </div>
                            <div class="info-office-item">
                                <img src="images/icon/phone.svg" alt="phone">
                                <div class="text-item">
                                    <p class="text-title">Phone Number</p>
                                    <p class="text-content">+84 (0)20 33998400 </p>
                                </div>
                            </div>
                            <div class="info-office-item">
                                <img src="images/icon/email.svg" alt="email">
                                <div class="text-item">
                                    <p class="text-title">Email Us</p>
                                    <p class="text-content">info@ngaoduvietnam.com </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map -->
    <div class="box-map-contact">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.870471877026!2d105.79155841446575!3d20.997828686015115!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab1167edbae7%3A0xa0790fee2a2a9c1b!2sAdamo%20Software%20-%20Leading%20Vietnam%20Software%20Outsourcing%20Company!5e0!3m2!1svi!2s!4v1639630813755!5m2!1svi!2s"
            style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
    <!-------------------- End Contact -------------------->

    <!-------------------- List Tours -------------------->
    <div class="box-contact">
        <div class="container">

        </div>
    </div>
    <!-------------------- End List Tours-------------------->
@endsection

@extends('layouts.client')
@section('content')
    <!-------------------- Header -------------------->
    <div class="header">
        <!--Logo and Nav -->
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <img class="logo" src="images/logo.png" alt="logo">
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
                                <a class="nav-link active" href="#">Home</a>
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
                                <a class="nav-link" href="#">Contact</a>
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

        <!-- Info feature and Search -->
        <div class="container box-content-header">
            <div class="row">
                <div class="col-12 col-xxl-8 col-lg-7 p-0">
                    <div class="text-header">
                        <p class="text-welcome">Welcome to NgaoduVietnam</p>
                        <p class="text-slogan">Perfect place for your stories</p>
                    </div>
                    <div class="box-feature">
                        <div>
                            <span class="dot"></span>
                            <span>Featured</span>
                        </div>
                        <div class="info-feature d-flex justify-content-between w-75">
                            <p>200+ <span>tours</span></p>
                            <p>100+ <span>destination</span></p>
                            <p>8+ <span>type of tour</span></p>
                        </div>
                    </div>

                </div>

                <div class="col-12 col-xxl-4 col-lg-5 form-search">
                    <p class="title-search">Discover beautiful Vietnam</p>
                    <form action="">
                        <div class="input-search input-inner-icon">
                            <img src="images/icon/search.svg">
                            <input class="form-control" type="text" placeholder="Tour name">
                        </div>
                        <div class="input-search input-inner-icon">
                            <img src="images/icon/location.svg">
                            <input class="form-control" type="text" placeholder="Quatlam Beach, Giaothuy, Namdinh">
                        </div>
                        <div class="input-search input-inner-icon">
                            <img src="images/icon/flag.svg">
                            <select class="form-control" required>
                                <option value="" disabled selected hidden>Type of tour</option>
                                <option value="1">City-Break</option>
                                <option value="2">Wildlife</option>
                                <option value="3">Cultural</option>
                                <option value="4">Ecotourism</option>
                                <option value="5">Sun and Beaches</option>
                            </select>
                        </div>
                        <div class="input-search input-inner-icon">
                            <img src="images/icon/schedule.svg">
                            <input class="form-control" type="text" placeholder="Departure time">
                        </div>

                        <div class="input-search">
                            <button
                                class="form-control btn-search-submit d-flex justify-content-center align-items-center"
                                type="submit">
                                <img class="fill-white me-2" src="images/icon/search.svg"> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--End Info feature and Search -->

    </div>
    <!-------------------- End Header -------------------->

    <!-------------------- Introduce -------------------->
    <div class="introduce">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="box-introduce-image mx-auto">
                        <img class="img-introduce-top" src="images/introduce1.png" alt="introduce">
                        <img class="img-introduce-bottom" src="images/introduce2.png" alt="introduce">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="box-text-introduce">
                        <p class="introduce-title">
                            With <span>NgaoduVietnam,</span> immerses you in majestic space and unique cultural features
                        </p>

                        <div class="content-introduce">
                            <div class="icon-droplet-introduce">
                                <img src="images/icon/droplets.svg" alt="introduce">
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Purus viverra nuQlla eget sed
                                odio.
                                Vulputate risus faucibus sem non, feugiat nec consequat, montes. Elementum scelerisque
                                phasellus donec lectus ullamcorper faucibus.
                                Malesuada et adipiscing molestie egestas leo ut.
                            </p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Purus viverra nuQlla eget sed
                                odio.
                                Vulputate risus faucibus sem non, feugiat nec consequat, montes.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-------------------- End Introduce -------------------->

    <!-------------------- Slide Destinations -------------------->
    <div class="box-slide slide-destinations">
        <div class="container">
            <div class="header-slide">
                <p class="title-slide">Discover fascinating destinations</p>
                <button class="btn-view-all">View all</button>
            </div>
            <div class="body-slide">
                <div class="owl-carousel" id="slideDestinations">
                    <div class="card card-destination">
                        <img src="images/sapa.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><a href=""> Sapa, Laocai </a></h5>
                            <p class="card-text">24 experiences</p>
                        </div>
                    </div>

                    <div class="card card-destination">
                        <img src="images/hoian.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><a href=""> Hoian, Quangnam </a></h5>
                            <p class="card-text">12 experiences</p>
                        </div>
                    </div>

                    <div class="card card-destination">
                        <img src="images/banahill.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><a href="">Ba Na Hill, Danang</a></h5>
                            <p class="card-text">28 experiences</p>
                        </div>
                    </div>

                    <div class="card card-destination">
                        <img src="images/muine.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><a href="">Muine, Binhthuan</a></h5>
                            <p class="card-text">11 experiences</p>
                        </div>
                    </div>

                    <div class="card card-destination">
                        <img src="images/cultural1.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><a href="">Hoian, Quangnam</a></h5>
                            <p class="card-text">52 experiences</p>
                        </div>
                    </div>

                    <div class="card card-destination">
                        <img src="images/cultural2.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><a href="">Ba Na Hill, Danang</a></h5>
                            <p class="card-text">36 experiences</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-------------------- End Slide Destinations-------------------->

    <!-------------------- Slide Tours -------------------->
    <div class="box-slide slide-tour">
        <div class="container">
            <div class="header-slide">
                <p class="title-slide">Attractive tour and interesting experiences</p>
                <button class="btn-view-all">View all</button>
            </div>
            <div class="body-slide">
                <div class="owl-carousel" id="slideTours">
                    <div class="card card-tour">
                        <div class="card-image">
                            <img class="ribbon fill-white" src="images/icon/ribbon.svg" alt="bookmark">
                            <div class="rate">
                                <img src="images/icon/star.svg" alt="star">
                                <span class="text-rate">4.5</span>
                            </div>
                            <img src="images/sapa-tour.png" class="card-img-top" alt="tour-image">
                        </div>

                        <div class="card-body">
                            <p class="card-text">
                                <img src="images/icon/location.svg" alt="location">
                                <span>Sapa, Laocai</span>
                            </p>
                            <h5 class="card-title"><a href="">Discover interesting things in the romantic coastal city
                                    of
                                    Vungtau</a></h5>
                            <div class="d-inline-flex justify-content-between align-items-center w-100">
                                <p class="card-text">
                                    <img src="images/icon/schedule.svg" alt="location">
                                    <span>3 days - 2 night</span>
                                </p>
                                <p class="card-text">from <span class="card-title">$146.00</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="card card-tour">
                        <div class="card-image">
                            <img class="ribbon" src="images/icon/ribbon.svg" alt="bookmark">
                            <div class="rate">
                                <img src="images/icon/star.svg" alt="star">
                                <span class="text-rate">4.5</span>
                            </div>
                            <img src="images/tour2.png" class="card-img-top" alt="tour-image">
                        </div>

                        <div class="card-body">
                            <p class="card-text">
                                <img src="images/icon/location.svg" alt="location">
                                <span>Sapa, Laocai</span>
                            </p>
                            <h5 class="card-title"><a href="">Discover the most majestic Fansipan peak in Vietnam - the
                                    roof
                                    of Indochina</a></h5>
                            <div class="d-inline-flex justify-content-between align-items-center w-100">
                                <p class="card-text">
                                    <img src="images/icon/schedule.svg" alt="location">
                                    <span>3 days - 2 night</span>
                                </p>
                                <p class="card-text">from <span class="card-title">$234.00</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="card card-tour">
                        <div class="card-image">
                            <img class="ribbon fill-white" src="images/icon/ribbon.svg" alt="bookmark">
                            <div class="rate">
                                <img src="images/icon/star.svg" alt="star">
                                <span class="text-rate">4.5</span>
                            </div>
                            <img src="images/tour3.png" class="card-img-top" alt="tour-image">
                        </div>

                        <div class="card-body">
                            <p class="card-text">
                                <img src="images/icon/location.svg" alt="location">
                                <span>Sapa, Laocai</span>
                            </p>
                            <h5 class="card-title"><a href="">Experience sea tourism on Phuquoc golden pearl</a></h5>
                            <div class="d-inline-flex justify-content-between align-items-center w-100">
                                <p class="card-text">
                                    <img src="images/icon/schedule.svg" alt="location">
                                    <span>3 days - 2 night</span>
                                </p>
                                <p class="card-text">from <span class="card-title">$334.00</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="card card-tour">
                        <div class="card-image">
                            <img class="ribbon fill-white" src="images/icon/ribbon.svg" alt="bookmark">
                            <div class="rate">
                                <img src="images/icon/star.svg" alt="star">
                                <span class="text-rate">4.5</span>
                            </div>
                            <img src="images/tour3.png" class="card-img-top" alt="tour-image">
                        </div>

                        <div class="card-body">
                            <p class="card-text">
                                <img src="images/icon/location.svg" alt="location">
                                <span>Sapa, Laocai</span>
                            </p>
                            <h5 class="card-title"><a href="">Experience sea tourism on Phuquoc golden pearl</a></h5>
                            <div class="d-inline-flex justify-content-between align-items-center w-100">
                                <p class="card-text">
                                    <img src="images/icon/schedule.svg" alt="location">
                                    <span>3 days - 2 night</span>
                                </p>
                                <p class="card-text">from <span class="card-title">$334.00</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="card card-tour">
                        <div class="card-image">
                            <img class="ribbon fill-white" src="images/icon/ribbon.svg" alt="bookmark">
                            <div class="rate">
                                <img src="images/icon/star.svg" alt="star">
                                <span class="text-rate">4.5</span>
                            </div>
                            <img src="images/tour3.png" class="card-img-top" alt="tour-image">
                        </div>

                        <div class="card-body">
                            <p class="card-text">
                                <img src="images/icon/location.svg" alt="location">
                                <span>Sapa, Laocai</span>
                            </p>
                            <h5 class="card-title"><a href="">Experience sea tourism on Phuquoc golden pearl</a></h5>
                            <div class="d-inline-flex justify-content-between align-items-center w-100">
                                <p class="card-text">
                                    <img src="images/icon/schedule.svg" alt="location">
                                    <span>3 days - 2 night</span>
                                </p>
                                <p class="card-text">from <span class="card-title">$334.00</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-------------------- End Slide Tours-------------------->

    <!-------------------- Slide Traditional Cultural -------------------->
    <div class="box-slide slide-tour slide-cultural">
        <div class="container">
            <div class="header-slide">
                <p class="title-slide">Experience the traditional cultural beauties of Vietnam</p>
                <button class="btn-view-all">View all</button>
            </div>
            <div class="body-slide">
                <div class="owl-carousel" id="slideCultural">
                    <div class="card card-tour">
                        <div class="card-image">
                            <img class="ribbon" src="images/icon/ribbon.svg" alt="bookmark">
                            <div class="rate">
                                <img src="images/icon/star.svg" alt="star">
                                <span class="text-rate">4.5</span>
                            </div>
                            <img src="images/cultural1.png" class="card-img-top" alt="tour-image">
                        </div>

                        <div class="card-body">
                            <p class="card-text">
                                <img src="images/icon/location.svg" alt="location">
                                <span>Lang Vong, Hanoi</span>
                            </p>
                            <h5 class="card-title"><a href="">“ Com lang Vong “ - Traditional culinary features of the
                                    old
                                    Hanoi people</a>
                            </h5>
                            <div class="d-inline-flex justify-content-between align-items-center w-100">
                                <p class="card-text">
                                    <img src="images/icon/schedule.svg" alt="location">
                                    <span>6 hours</span>
                                </p>
                                <p class="card-text">from <span class="card-title">$146.00</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="card card-tour">
                        <div class="card-image">
                            <img class="ribbon" src="images/icon/ribbon.svg" alt="bookmark">
                            <div class="rate">
                                <img src="images/icon/star.svg" alt="star">
                                <span class="text-rate">4.5</span>
                            </div>
                            <img src="images/cultural2.png" class="card-img-top" alt="tour-image">
                        </div>

                        <div class="card-body">
                            <p class="card-text">
                                <img src="images/icon/location.svg" alt="location">
                                <span>Hue City, Thuathienhue</span>
                            </p>
                            <h5 class="card-title"><a href="">“ Bun bo Hue “ - culinary specialties in the ancient
                                    capital
                                    of Hue</a>

                            </h5>
                            <div class="d-inline-flex justify-content-between align-items-center w-100">
                                <p class="card-text">
                                    <img src="images/icon/schedule.svg" alt="location">
                                    <span>6 hours</span>
                                </p>
                                <p class="card-text">from <span class="card-title">$234.00</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="card card-tour">
                        <div class="card-image">
                            <img class="ribbon" src="images/icon/ribbon.svg" alt="bookmark">
                            <div class="rate">
                                <img src="images/icon/star.svg" alt="star">
                                <span class="text-rate">4.5</span>
                            </div>
                            <img src="images/cultural3.png" class="card-img-top" alt="tour-image">
                        </div>

                        <div class="card-body">
                            <p class="card-text">
                                <img src="images/icon/location.svg" alt="location">
                                <span>Tiendu, Bacninh</span>
                            </p>
                            <h5 class="card-title"><a href="">Heritage of Quan Ho Bac Ninh - Singing passionate
                                    hearts</a>
                            </h5>
                            <div class="d-inline-flex justify-content-between align-items-center w-100">
                                <p class="card-text">
                                    <img src="images/icon/schedule.svg" alt="location">
                                    <span>6 hours</span>
                                </p>
                                <p class="card-text">from <span class="card-title">$334.00</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="card card-tour">
                        <div class="card-image">
                            <img class="ribbon" src="images/icon/ribbon.svg" alt="bookmark">
                            <div class="rate">
                                <img src="images/icon/star.svg" alt="star">
                                <span class="text-rate">4.5</span>
                            </div>
                            <img src="images/cultural3.png" class="card-img-top" alt="tour-image">
                        </div>

                        <div class="card-body">
                            <p class="card-text">
                                <img src="images/icon/location.svg" alt="location">
                                <span>Tiendu, Bacninh</span>
                            </p>
                            <h5 class="card-title"><a href="">Heritage of Quan Ho Bac Ninh - Singing passionate
                                    hearts</a>
                            </h5>
                            <div class="d-inline-flex justify-content-between align-items-center w-100">
                                <p class="card-text">
                                    <img src="images/icon/schedule.svg" alt="location">
                                    <span>6 hours</span>
                                </p>
                                <p class="card-text">from <span class="card-title">$334.00</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="card card-tour">
                        <div class="card-image">
                            <img class="ribbon" src="images/icon/ribbon.svg" alt="bookmark">
                            <div class="rate">
                                <img src="images/icon/star.svg" alt="star">
                                <span class="text-rate">4.5</span>
                            </div>
                            <img src="images/cultural3.png" class="card-img-top" alt="tour-image">
                        </div>

                        <div class="card-body">
                            <p class="card-text">
                                <img src="images/icon/location.svg" alt="location">
                                <span>Tiendu, Bacninh</span>
                            </p>
                            <h5 class="card-title"><a href="">Heritage of Quan Ho Bac Ninh - Singing passionate
                                    hearts </a>
                            </h5>
                            <div class="d-inline-flex justify-content-between align-items-center w-100">
                                <p class="card-text">
                                    <img src="images/icon/schedule.svg" alt="location">
                                    <span>6 hours</span>
                                </p>
                                <p class="card-text">from <span class="card-title">$334.00</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-------------------- End Slide Tours-------------------->

    <!-------------------- Email Deals -------------------->
    <div class="mail-deals">
        <div class="container">
            <div class="row d-flex justify-content-around align-items-center">
                <div class="col-12 col-lg-7">
                    <div class="title-mail">
                        <p>Leave us an email, </p>
                        <p> to get <span>the latest deals</span></p>
                    </div>

                </div>
                <div class="col-12 col-lg-5">
                    <div class="form-input-mail mt-2 mt-md-5 m-lg-0 d-flex justify-content-between align-items-center">
                        <div class="input-mail input-inner-icon flex-grow-1 flex-shrink-1">
                            <img src="images/icon/location.svg">
                            <input class="form-control" type="text" placeholder="example@gmail.com">
                        </div>
                        <button class="flex-grow-0 flex-shrink-0 btn-send-mail">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-------------------- End Email Deals-------------------->
@endsection



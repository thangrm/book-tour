@extends('layouts.client')
@section('content')
    <!-------------------- Header -------------------->
    <div class="header header-list-tours">
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
                                <a class="nav-link" href="{{ route('index') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Tours</a>
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

        <!-- Text Header -->
        <div class="container box-content-header">
            <div class="row">
                <div class="col-12 col-xxl-8 col-lg-7 p-0">
                    <div class="text-header">
                        <p class="text-welcome">Search hundreds of tours and more</p>
                        <p class="text-slogan">Attractive tour and interesting experiences</p>
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
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item"><a href="">Tours</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-------------------- End Breadcrumb -------------------->

    <!-------------------- List Tours -------------------->
    <div class="box-slide slide-tour list-tours">
        <div class="container">
            <div class="header-slide d-flex align-items-end">
                <p class="title-slide">Attractive tour and interesting experiences</p>
                <div class="btn-filter-wrap">
                    <button class="btn btn-outline btn-filter d-flex align-items-center justify-content-between"
                            id="btnFilterTours" data-bs-toggle="collapse" data-bs-target="#filterCollapse"
                            aria-expanded="false" aria-controls="filterCollapse">
                        <span>Filter</span>
                        <i class="bi bi-x d-none iconBtnFilter"></i>
                        <i class="bi bi-chevron-down iconBtnFilter"></i>
                    </button>
                    <!-- Collapse Filter -->
                    <div class="collapse collapse-fillter" id="filterCollapse">
                        <div class="card card-body">
                            <div class="filter-header d-flex justify-content-between align-items-center">
                                <p>filter by</p>
                                <span class="text-clear" id="clearFormFilter">clear</span>
                            </div>
                            <div class="budget-bar">
                                <h5>Budget:</h5>
                                <div id="sliderRangePrice">
                                    <div slider id="slider-distance">
                                        <div>
                                            <div inverse-left style="width:70%;"></div>
                                            <div inverse-right style="width:70%;"></div>
                                            <div range style="left:30%;right:40%;"></div>
                                            <span thumb style="left:30%;"></span>
                                            <span thumb style="left:60%;"></span>
                                            <div sign style="left:30%;">
                                                $<span>360</span>
                                            </div>
                                            <div sign style="left:60%;">
                                                $<span>720</span>
                                            </div>
                                        </div>
                                        <input type="range" tabindex="0" value="360" max="1200" min="0" step="1"
                                               oninput="leftRange(this)"/>

                                        <input type="range" tabindex="0" value="720" max="1200" min="0" step="1"
                                               oninput="rightRange(this)"/>
                                    </div>
                                </div>
                            </div>
                            <form class="form-select-filter" id="formSelectFilter">
                                <div class="form-group">
                                    <hr>
                                    <h5>Duration</h5>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="duration1">
                                        <label class="form-check-label" for="duration1">
                                            0-3 days
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="duration2">
                                        <label class="form-check-label" for="duration2">
                                            3-5 days
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="duration3">
                                        <label class="form-check-label" for="duration3">
                                            5-7 days
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="duration4">
                                        <label class="form-check-label" for="duration4">
                                            over 1 week
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <hr>
                                    <h5>Type of Tours</h5>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="type1">
                                        <label class="form-check-label" for="type1">
                                            City-Break
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="type2">
                                        <label class="form-check-label" for="type2">
                                            Wildlife
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="type3">
                                        <label class="form-check-label" for="type3">
                                            Cultural
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="type4">
                                        <label class="form-check-label" for="type4">
                                            Ecotourism
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="type5">
                                        <label class="form-check-label" for="type5">
                                            Sun and Beaches
                                        </label>
                                    </div>
                                </div>

                                <button class="btn btn-primary w-100 btn-submit-filter">
                                    Apply Filter
                                </button>
                            </form>

                        </div>
                    </div>
                    <!-- End Collapse Filter -->
                </div>
            </div>
            <div class="body-slide">
                <div class="row">
                    <div class="col-6 col-lg-4">
                        <div class="card card-tour">
                            <div class="card-image">
                                <img class="ribbon fill-white" src="images/icon/ribbon.svg" alt="bookmark">
                                <div class="rate">
                                    <img src="images/icon/star.svg" alt="star">
                                    <span class="text-rate">4.5</span>
                                </div>
                                <img src="images/muine.png" class="card-img-top" alt="tour-image">
                            </div>

                            <div class="card-body">
                                <p class="card-text">
                                    <img src="images/icon/location.svg" alt="location">
                                    <span>Sapa, Laocai</span>
                                </p>
                                <h5 class="card-title"><a href="">Discover interesting things in the romantic coastal
                                        city
                                        of Vungtau</a></h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="images/icon/schedule.svg" alt="location">
                                        <span>3 days - 2 night</span>
                                    </p>
                                    <p class="card-text">from <span class="card-title">$146.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
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
                                <h5 class="card-title"><a href="">Discover the most majestic Fansipan peak in Vietnam -
                                        the
                                        roof of Indochina </a></h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="images/icon/schedule.svg" alt="location">
                                        <span>3 days - 2 night</span>
                                    </p>
                                    <p class="card-text">from <span class="card-title">$234.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
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
                                <h5 class="card-title"><a href="">Experience sea tourism on Phuquoc golden pearl</a>
                                </h5>
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
                    <div class="col-6 col-lg-4">
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
                                <h5 class="card-title"><a href="">Discover interesting things in the romantic coastal
                                        city
                                        of Vungtau</a></h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="images/icon/schedule.svg" alt="location">
                                        <span>3 days - 2 night</span>
                                    </p>
                                    <p class="card-text">from <span class="card-title">$146.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
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
                                    <span>Sapa, Laocai</span>
                                </p>
                                <h5 class="card-title"><a href="">Discover the most majestic Fansipan peak in Vietnam -
                                        the
                                        roof of Indochina </a></h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="images/icon/schedule.svg" alt="location">
                                        <span>3 days - 2 night</span>
                                    </p>
                                    <p class="card-text">from <span class="card-title">$234.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="card card-tour">
                            <div class="card-image">
                                <img class="ribbon fill-white" src="images/icon/ribbon.svg" alt="bookmark">
                                <div class="rate">
                                    <img src="images/icon/star.svg" alt="star">
                                    <span class="text-rate">4.5</span>
                                </div>
                                <img src="images/cultural3.png" class="card-img-top" alt="tour-image">
                            </div>

                            <div class="card-body">
                                <p class="card-text">
                                    <img src="images/icon/location.svg" alt="location">
                                    <span>Sapa, Laocai</span>
                                </p>
                                <h5 class="card-title"><a href="">Experience sea tourism on Phuquoc golden pearl </a>
                                </h5>
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
                    <div class="col-6 col-lg-4">
                        <div class="card card-tour">
                            <div class="card-image">
                                <img class="ribbon fill-white" src="images/icon/ribbon.svg" alt="bookmark">
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
                                <h5 class="card-title"><a href="">Discover interesting things in the romantic coastal
                                        city
                                        of Vungtau</a></h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="images/icon/schedule.svg" alt="location">
                                        <span>3 days - 2 night</span>
                                    </p>
                                    <p class="card-text">from <span class="card-title">$146.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
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
                                    <span>Sapa, Laocai</span>
                                </p>
                                <h5 class="card-title"><a href="">Discover the most majestic Fansipan peak in Vietnam -
                                        the
                                        roof of Indochina </a></h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="images/icon/schedule.svg" alt="location">
                                        <span>3 days - 2 night</span>
                                    </p>
                                    <p class="card-text">from <span class="card-title">$234.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="card card-tour">
                            <div class="card-image">
                                <img class="ribbon fill-white" src="images/icon/ribbon.svg" alt="bookmark">
                                <div class="rate">
                                    <img src="images/icon/star.svg" alt="star">
                                    <span class="text-rate">4.5</span>
                                </div>
                                <img src="images/cultural1.png" class="card-img-top" alt="tour-image">
                            </div>

                            <div class="card-body">
                                <p class="card-text">
                                    <img src="images/icon/location.svg" alt="location">
                                    <span>Sapa, Laocai</span>
                                </p>
                                <h5 class="card-title"><a href="">Experience sea tourism on Phuquoc golden pearl </a>
                                </h5>
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
                    <div class="col-6 col-lg-4">
                        <div class="card card-tour">
                            <div class="card-image">
                                <img class="ribbon fill-white" src="images/icon/ribbon.svg" alt="bookmark">
                                <div class="rate">
                                    <img src="images/icon/star.svg" alt="star">
                                    <span class="text-rate">4.5</span>
                                </div>
                                <img src="images/cultural2.png" class="card-img-top" alt="tour-image">
                            </div>

                            <div class="card-body">
                                <p class="card-text">
                                    <img src="images/icon/location.svg" alt="location">
                                    <span>Sapa, Laocai</span>
                                </p>
                                <h5 class="card-title"><a href="">Discover interesting things in the romantic coastal
                                        city
                                        of Vungtau</a></h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="images/icon/schedule.svg" alt="location">
                                        <span>3 days - 2 night</span>
                                    </p>
                                    <p class="card-text">from <span class="card-title">$146.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
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
                                <h5 class="card-title"><a href="">Discover the most majestic Fansipan peak in Vietnam -
                                        the
                                        roof of Indochina </a></h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="images/icon/schedule.svg" alt="location">
                                        <span>3 days - 2 night</span>
                                    </p>
                                    <p class="card-text">from <span class="card-title">$234.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
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
                                <h5 class="card-title"><a href="">Experience sea tourism on Phuquoc golden pearl </a>
                                </h5>
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
                    <div class="col-6 col-lg-4">
                        <div class="card card-tour">
                            <div class="card-image">
                                <img class="ribbon fill-white" src="images/icon/ribbon.svg" alt="bookmark">
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
                                <h5 class="card-title"><a href="">Discover interesting things in the romantic coastal
                                        city
                                        of Vungtau</a></h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="images/icon/schedule.svg" alt="location">
                                        <span>3 days - 2 night</span>
                                    </p>
                                    <p class="card-text">from <span class="card-title">$146.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
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
                                    <span>Sapa, Laocai</span>
                                </p>
                                <h5 class="card-title"><a href="">Discover the most majestic Fansipan peak in Vietnam -
                                        the
                                        roof of Indochina </a></h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="images/icon/schedule.svg" alt="location">
                                        <span>3 days - 2 night</span>
                                    </p>
                                    <p class="card-text">from <span class="card-title">$234.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="card card-tour">
                            <div class="card-image">
                                <img class="ribbon fill-white" src="images/icon/ribbon.svg" alt="bookmark">
                                <div class="rate">
                                    <img src="images/icon/star.svg" alt="star">
                                    <span class="text-rate">4.5</span>
                                </div>
                                <img src="images/cultural1.png" class="card-img-top" alt="tour-image">
                            </div>

                            <div class="card-body">
                                <p class="card-text">
                                    <img src="images/icon/location.svg" alt="location">
                                    <span>Sapa, Laocai</span>
                                </p>
                                <h5 class="card-title"><a href="">Experience sea tourism on Phuquoc golden pearl</a>
                                </h5>
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
                    <div class="col-6 col-lg-4">
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
                                <h5 class="card-title"><a href="">Discover interesting things in the romantic coastal
                                        city
                                        of Vungtau</a></h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="images/icon/schedule.svg" alt="location">
                                        <span>3 days - 2 night</span>
                                    </p>
                                    <p class="card-text">from <span class="card-title">$146.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
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
                                    <span>Sapa, Laocai</span>
                                </p>
                                <h5 class="card-title"><a href="">Discover the most majestic Fansipan peak in Vietnam -
                                        the
                                        roof of Indochina </a></h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="images/icon/schedule.svg" alt="location">
                                        <span>3 days - 2 night</span>
                                    </p>
                                    <p class="card-text">from <span class="card-title">$234.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
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
                                <h5 class="card-title"><a href="">Experience sea tourism on Phuquoc golden pearl </a>
                                </h5>
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
                    <div class="col-6 col-lg-4">
                        <div class="card card-tour">
                            <div class="card-image">
                                <img class="ribbon fill-white" src="images/icon/ribbon.svg" alt="bookmark">
                                <div class="rate">
                                    <img src="images/icon/star.svg" alt="star">
                                    <span class="text-rate">4.5</span>
                                </div>
                                <img src="images/cultural1.png" class="card-img-top" alt="tour-image">
                            </div>

                            <div class="card-body">
                                <p class="card-text">
                                    <img src="images/icon/location.svg" alt="location">
                                    <span>Sapa, Laocai</span>
                                </p>
                                <h5 class="card-title"><a href="">Discover interesting things in the romantic coastal
                                        city
                                        of Vungtau</a></h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="images/icon/schedule.svg" alt="location">
                                        <span>3 days - 2 night</span>
                                    </p>
                                    <p class="card-text">from <span class="card-title">$146.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
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
                                <h5 class="card-title"><a href="">Discover the most majestic Fansipan peak in Vietnam -
                                        the
                                        roof of Indochina </a></h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="images/icon/schedule.svg" alt="location">
                                        <span>3 days - 2 night</span>
                                    </p>
                                    <p class="card-text">from <span class="card-title">$234.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
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
                                <h5 class="card-title"><a href="">Experience sea tourism on Phuquoc golden pearl </a>
                                </h5>
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
            <div class="pagination-tours d-flex justify-content-end align-items-baseline w-100">
                <div class="pagination-text">Showing 1 / 2</div>
                <nav class="page-navigation " aria-label="page navigation">
                    <ul class="pagination justify-content-end">
                        <li class="page-item ms-0">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                <img src="images/icon/arrow-pagination-left.svg" alt="page-prev">
                            </a>
                        </li>
                        <li class="page-item page-number active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item page-number"><a class="page-link" href="#">2</a></li>
                        <li class="page-item me-0">
                            <a class="page-link" href="#">
                                <img src="images/icon/arrow-pagination-right.svg" alt="page-next">
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-------------------- End List Tours-------------------->

@endsection



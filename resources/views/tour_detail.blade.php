@extends('layouts.client')
@section('content')
    <!-------------------- Header -------------------->
    <div class="header header-tour-detail">
        <!--Logo and Nav -->
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <img class="logo" src="{{ asset('images/logo.png') }}" alt="logo">
                <nav class="navbar navbar-expand-sm navbar-light">
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
    </div>
    <!-------------------- End Header -------------------->
    <hr>

    <!-------------------- Breadcrumb -------------------->
    <div class="breadcrumb-wrap">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: ''" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Tours</a></li>
                    <li class="breadcrumb-item"><a href="#">Detail tour</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-------------------- End Breadcrumb -------------------->

    <!-------------------- Body Tour Deatil -------------------->
    <div class="box-detail-tour">
        <div class="container">
            <div class="header-detail row">
                <div class="col-12 col-lg-7 col-xl-8">
                    <p class="title-tour">{{ $tour->name }}</p>
                    <p class="text-content">
                        <img src="{{ asset('images/icon/location.svg') }}" alt="location">
                        <span>{{ $tour->destination->name }}</span>
                    </p>
                    <div class="rate">
                        <img src="{{ asset('images/icon/star.svg') }}" alt="star">
                        <span class="text-rate">4.5</span>
                    </div>
                    <span class="text-content">{{ $tour->reviews->count() }} reviews</span>
                </div>
            </div>
            <div class="row box-detail-content">
                <div class="col-12 col-lg-7 col-xl-8">
                    <div class="box-body-detail">
                        <!-------------------- Image Slider -------------------->
                        <div class="body-tour-slide">
                            <div class="main-image-tour">
                                <img class="ribbon" src="{{ asset('images/icon/ribbon.svg') }}" alt="bookmark">
                                <div class="main-image">
                                    <img src="{{ asset('images/vungtau.png') }}" alt="" id="mainImageTour">
                                </div>
                                <div class="list-image-thumbnail">
                                    <div class="owl-carousel" id="slideImageThumnail">
                                        @foreach($tour->galleries as $gallery)
                                            @if ($loop->first)
                                                <img class="thumbnailItem target"
                                                     src="{{ asset('storage/images/galleries/'.$gallery->image) }}">
                                            @else
                                                <img class="thumbnailItem"
                                                     src="{{ asset('storage/images/galleries/'.$gallery->image) }}">
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-------------------- End Image Slider -------------------->

                        <!-------------------- Info Tour -------------------->
                        <div class="box-info">
                            <!-- tab -->
                            <ul class="nav nav-pills d-flex justify-content-between mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-desc-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-desc" type="button" role="tab"
                                            aria-controls="pills-desc" aria-selected="true">Descriptions
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-info-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-info" type="button" role="tab"
                                            aria-controls="pills-info" aria-selected="false">Additional Info
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" href="#" id="pills-review-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-review" type="button" role="tab"
                                            aria-controls="pills-review" aria-selected="false">Reviews(54)
                                    </button>
                                </li>
                            </ul>
                            <hr>
                            <!-- panel -->
                            <div class="tab-content" id="pills-tabContent">
                                <!-- panel descriptions -->
                                <div class="tab-pane panel-desc fade show active" id="pills-desc" role="tabpanel"
                                     aria-labelledby="pills-desc-tab">
                                    <div class="box-text">
                                        <p class="panel-title">
                                            Overview
                                        </p>
                                        <p class="panel-text">
                                            {!! $tour->overview !!}
                                        </p>
                                        {{--                                        <ul>--}}
                                        {{--                                            <li>Full-day tour of Capri island from Naples or Sorrento Admire views along--}}
                                        {{--                                                the coast as you cruise to the island by jetfoil--}}
                                        {{--                                            </li>--}}
                                        {{--                                            <li> Visit the lively island towns of Anacapri and Capri Ride</li>--}}
                                        {{--                                            <li>The funicular from La Piazzetta to Marina Grande Marvel at natural--}}
                                        {{--                                                wonders like the Blue Grotto Small-group tour ensures a personalized--}}
                                        {{--                                                experience--}}
                                        {{--                                            </li>--}}
                                        {{--                                        </ul>--}}
                                    </div>
                                    <hr>
                                    <div class="box-text">
                                        <p class="panel-title">
                                            What's Included
                                        </p>
                                        {!! $tour->included !!}
                                        {{--                                        <ul class="tick-vert">--}}
                                        {{--                                            <li>Port pickup and drop-off</li>--}}
                                        {{--                                            <li>Local guide</li>--}}
                                        {{--                                            <li>Round-trip shared transfer</li>--}}
                                        {{--                                            <li>Transport by minibus</li>--}}
                                        {{--                                            <li>Blue Grotto admission tickets</li>--}}
                                        {{--                                            <li>Shared boat ride tour around the island ( if Blue grotto is closed)</li>--}}
                                        {{--                                        </ul>--}}
                                    </div>
                                    <hr>
                                    <div class="box-text">
                                        <p class="panel-title">
                                            Departure & Return
                                        </p>
                                        {!! $tour->departure !!}
                                    </div>
                                    <hr>
                                    <div class="box-text">
                                        <p class="panel-title">
                                            Tour Itinerary
                                        </p>
                                        <!-- Accordion Itinerary -->
                                        <div class="accordion" id="accordionItinerary">
                                            @foreach($tour->itineraries as $itinerary)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header"
                                                        id="panelsItineraryHeading{{$loop->index}}">
                                                        <button
                                                            class="accordion-button {{ $loop->first ?: 'collapsed'  }}"
                                                            type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#panelsItineraryCollapse{{$loop->index}}"
                                                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                            aria-controls="panelsItineraryCollapse{{$loop->index}}">
                                                            Day {{ $loop->index + 1}}: {{ $itinerary->name }}
                                                            ({{ $itinerary->places->count() }} stops)
                                                        </button>
                                                    </h2>
                                                    <div id="panelsItineraryCollapse{{$loop->index}}"
                                                         class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                         aria-labelledby="panelsItineraryHeading{{$loop->index}}">
                                                        <div class="accordion-body">
                                                            <ul class="list-accordion">
                                                                @foreach($itinerary->places as $place)
                                                                    <li class="list-accordion-item">
                                                                        <p class="title-item"> {{ $place->name }}</p>
                                                                        {!! $place->description !!}
                                                                        {{--                                                                        <p class="text-item"> We start our trip from the--}}
                                                                        {{--                                                                            famouse--}}
                                                                        {{--                                                                            place Jemaa Lefna in center of Marrakech,--}}
                                                                        {{--                                                                            Crossed--}}
                                                                        {{--                                                                            the highest Atlas Through pass (Tizi N--}}
                                                                        {{--                                                                            Tichka)</p>--}}
                                                                        {{--                                                                        <p class="duration-item">Duration:--}}
                                                                        {{--                                                                            <span>5 minutes</span></p>--}}
                                                                        {{--                                                                        <p class="text-item">Admission Ticket Free</p>--}}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="box-text">
                                        <p class="panel-title">
                                            Maps
                                        </p>
                                        <div class="box-maps">
                                            {!! $tour->map !!}
                                        </div>
                                    </div>
                                    <div class="box-text">
                                        <p class="panel-title">
                                            360° Panoramic Images and Videos
                                        </p>
                                        {{--                                        <div class="box-images-panoramic" id="imagePanoramic">--}}
                                        {{--                                            <div class="wrap-panoramic">--}}
                                        {{--                                                <img src="images/icon/360.svg" alt="">--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        @isset($tour->panoramic_image)
                                            <iframe class="w-100 m-t-10" height="400" src="{{$tour->panoramic_image}}"
                                                    frameborder="0">
                                            </iframe>
                                        @endisset
                                        <div class="box-video">
                                            @isset($tour->video)
                                                <iframe class="w-100 m-t-10" height="400"
                                                        src="https://www.youtube.com/embed/{{ $tour->video }}"
                                                        title="YouTube video player" frameborder="0"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                        allowfullscreen></iframe>
                                            @endisset
                                        </div>

                                    </div>
                                </div>

                                <!-- panel additional info -->
                                <div class="tab-pane panel-info fade" id="pills-info" role="tabpanel"
                                     aria-labelledby="pills-info-tab">
                                    <div class="box-text">
                                        <ul>
                                            <li>Confirmation will be received at time of booking</li>
                                            <li>Not recommended for travelers with back problems</li>
                                            <li>Not recommended for pregnant travelers Infant seats available</li>
                                            <li>Not wheelchair accessible</li>
                                            <li>Children must be accompanied by an adult</li>
                                            <li>Vegetarian option is available, please advise at time of booking if
                                                required
                                            </li>
                                            <li>Minimum numbers apply.</li>
                                            <li>There is a possibility of cancellation after confirmation if the
                                                meteorological
                                            </li>
                                            <li>conditions do not allow it</li>
                                            <li>Stroller accessible</li>
                                            <li>Service animals allowed</li>
                                            <li>Near public transportation</li>
                                            <li>Most travelers can participate</li>
                                            <li>This tour/activity will have a maximum of 17 travelers</li>
                                        </ul>
                                    </div>

                                    <div class="box-text">
                                        <p class="panel-title">FAQs</p>
                                        <!-- Accordion FAQs -->
                                        <div class="accordion" id="accordionFAQs">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="panelsFAQsHeadingOne">
                                                    <button class="accordion-button d-flex align-items-start"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#panelsFAQsCollapseOne" aria-expanded="true"
                                                            aria-controls="panelsFAQsCollapseOne">
                                                        <img src="images/icon/help-circle.svg" alt="help">
                                                        <p>What is the maximum group size during 2 Days 1 Night To
                                                            Zagora Desert From Marrakech?
                                                        </p>
                                                    </button>
                                                </h2>
                                                <div id="panelsFAQsCollapseOne" class="accordion-collapse collapse show"
                                                     aria-labelledby="panelsFAQsHeadingOne">
                                                    <div class="accordion-body">
                                                        <p class="text-item">
                                                            This activity will have a maximum of 17 travelers.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="panelsFAQsHeadingTwo">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#panelsFAQsCollapseTwo"
                                                            aria-expanded="false" aria-controls="panelsFAQsCollapseTwo">
                                                        <img src="images/icon/help-circle.svg" alt="help">
                                                        When and where does the tour start?
                                                    </button>
                                                </h2>
                                                <div id="panelsFAQsCollapseTwo" class="accordion-collapse collapse"
                                                     aria-labelledby="panelsFAQsHeadingTwo">
                                                    <div class="accordion-body">
                                                        <p class="text-item">
                                                            Tour will start at 8:00 AM in Hanoi.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="panelsFAQsHeadingThree">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#panelsFAQsCollapseThree"
                                                            aria-expanded="false"
                                                            aria-controls="panelsFAQsCollapseThree">
                                                        <img src="images/icon/help-circle.svg" alt="help">
                                                        Do you arrange airport transfers?
                                                    </button>
                                                </h2>
                                                <div id="panelsFAQsCollapseThree" class="accordion-collapse collapse"
                                                     aria-labelledby="panelsFAQsHeadingThree">
                                                    <div class="accordion-body">
                                                        <p class="text-item">
                                                            Yes, we will arrange for you.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- panel reviews -->
                                <div class="tab-pane panel-review fade" id="pills-review" role="tabpanel"
                                     aria-labelledby="pills-review-tab">
                                    <div class="box-rate-review">
                                        <div class="row">
                                            <div class="col-12 col-md-5">
                                                <div class="box-rate d-flex flex-column align-items-center">
                                                    <p class="rate-title">4/5</p>
                                                    <div class="list-rate-star">
                                                        <i class="bi bi-star-fill fill-yellow"></i>
                                                        <i class="bi bi-star-fill fill-yellow"></i>
                                                        <i class="bi bi-star-fill fill-yellow"></i>
                                                        <i class="bi bi-star-fill fill-yellow"></i>
                                                        <i class="bi bi-star fill-yellow"></i>
                                                    </div>
                                                    <p class="rate-text">Based on <span>150 reviews</span></p>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <div class="box-list-rate d-flex flex-column align-items-center">
                                                    <div
                                                        class="rate-item d-flex justify-content-center align-items-center">
                                                        <p class="number-star d-flex justify-content-end align-items-center">
                                                            <span class="pe-1">5</span>
                                                            <i class="bi bi-star-fill fill-gray"></i>
                                                        </p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" style="width: 75%;"
                                                                 role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="text-review">42 reviews</span>
                                                    </div>

                                                    <div
                                                        class="rate-item d-flex justify-content-center align-items-center">
                                                        <p class="number-star d-flex justify-content-end align-items-center">
                                                            <span class="pe-1">4</span>
                                                            <i class="bi bi-star-fill fill-gray"></i>
                                                        </p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" style="width: 30%;"
                                                                 role="progressbar" aria-valuenow="30" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="text-review">21 reviews</span>
                                                    </div>

                                                    <div
                                                        class="rate-item d-flex justify-content-center align-items-center">
                                                        <p class="number-star d-flex justify-content-end align-items-center">
                                                            <span class="pe-1">3</span>
                                                            <i class="bi bi-star-fill fill-gray"></i>
                                                        </p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" style="width: 60%;"
                                                                 role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="text-review">36 reviews</span>
                                                    </div>

                                                    <div
                                                        class="rate-item d-flex justify-content-center align-items-center">
                                                        <p class="number-star d-flex justify-content-end align-items-center">
                                                            <span class="pe-1">2</span>
                                                            <i class="bi bi-star-fill fill-gray"></i>
                                                        </p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" style="width: 0%;"
                                                                 role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="text-review">0 reviews</span>
                                                    </div>

                                                    <div
                                                        class="rate-item d-flex justify-content-center align-items-center">
                                                        <p class="number-star d-flex justify-content-end align-items-center">
                                                            <span class="pe-1">1</span>
                                                            <i class="bi bi-star-fill fill-gray"></i>
                                                        </p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" style="width: 0;"
                                                                 role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="text-review">43 reviews</span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="box-review d-flex align-items-start">
                                        <img src="images/icon/user.svg" alt="" width="56">
                                        <form class="form-review w-100">
                                            <textarea class="form-control" rows="5"
                                                      placeholder="Type anything"></textarea>
                                            <input type="hidden" id="inputRateReview" value="4">
                                            <div class="d-flex justify-content-between mt-4">
                                                <div class="rate-review" id="rateReview1">
                                                    <i class="rate-star bi bi-star-fill fill-yellow" data-rate="1"></i>
                                                    <i class="rate-star bi bi-star-fill fill-yellow" data-rate="2"></i>
                                                    <i class="rate-star bi bi-star-fill fill-yellow" data-rate="3"></i>
                                                    <i class="rate-star bi bi-star-fill fill-yellow" data-rate="4"></i>
                                                    <i class="rate-star bi bi-star fill-yellow" data-rate="5"></i>
                                                </div>
                                                <button class="btn" type="submit">Upload review</button>
                                            </div>
                                        </form>
                                    </div>
                                    <hr>
                                    <div class="box-list-review">
                                        <div class="review-item">
                                            <div class="title-review d-flex justify-content-start w-100">
                                                <img src="images/user-avatar.png" alt="">
                                                <div class="info-review">
                                                    <div class="rate-review" id="rateReview2">
                                                        <i class="rate-star bi bi-star-fill fill-yellow"
                                                           data-rate="1"></i>
                                                        <i class="rate-star bi bi-star-fill fill-yellow"
                                                           data-rate="2"></i>
                                                        <i class="rate-star bi bi-star-fill fill-yellow"
                                                           data-rate="3"></i>
                                                        <i class="rate-star bi bi-star-fill fill-yellow"
                                                           data-rate="4"></i>
                                                        <i class="rate-star bi bi-star fill-yellow" data-rate="5"></i>
                                                    </div>
                                                    <p class="text-title">The best experience ever! </p>
                                                    <span>Nevermind</span>
                                                    <i class="bi bi-dot"></i>
                                                    <span>Sep 2020</span>
                                                </div>

                                            </div>
                                            <p class="review-text">
                                                It was excellent! The trip is long but the vans are comfortable and have
                                                wi-fi. The driver very friendly as well as Ahmed our guide to the
                                                dromedaries. The camp was beautiful, comfortable beds, clean bathroom
                                                and delicious food!
                                            </p>
                                        </div>
                                        <hr>
                                        <div class="review-item">
                                            <div class="title-review d-flex justify-content-start w-100">
                                                <img src="images/user-avatar.png" alt="">
                                                <div class="info-review">
                                                    <div class="rate-review" id="rateReview3">
                                                        <i class="rate-star bi bi-star-fill fill-yellow"
                                                           data-rate="1"></i>
                                                        <i class="rate-star bi bi-star-fill fill-yellow"
                                                           data-rate="2"></i>
                                                        <i class="rate-star bi bi-star-fill fill-yellow"
                                                           data-rate="3"></i>
                                                        <i class="rate-star bi bi-star-fill fill-yellow"
                                                           data-rate="4"></i>
                                                        <i class="rate-star bi bi-star fill-yellow" data-rate="5"></i>
                                                    </div>
                                                    <p class="text-title">The best experience ever! </p>
                                                    <span>Nevermind</span>
                                                    <i class="bi bi-dot"></i>
                                                    <span>Sep 2020</span>
                                                </div>

                                            </div>
                                            <p class="review-text">
                                                It was excellent! The trip is long but the vans are comfortable and have
                                                wi-fi. The driver very friendly as well as Ahmed our guide to the
                                                dromedaries. The camp was beautiful, comfortable beds, clean bathroom
                                                and delicious food!
                                            </p>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="pagination-tours d-flex justify-content-start align-items-baseline">
                                        <nav class="page-navigation " aria-label="page navigation">
                                            <ul class="pagination justify-content-start">
                                                <li class="page-item ms-0">
                                                    <a class="page-link ms-0" href="#" tabindex="-1"
                                                       aria-disabled="true">
                                                        <img src="images/icon/arrow-pagination-left.svg"
                                                             alt="page-prev">
                                                    </a>
                                                </li>
                                                <li class="page-item page-number active"><a class="page-link"
                                                                                            href="#">1</a></li>
                                                <li class="page-item page-number"><a class="page-link" href="#">2</a>
                                                </li>
                                                <li class="page-item me-0">
                                                    <a class="page-link me-0" href="#">
                                                        <img src="images/icon/arrow-pagination-right.svg"
                                                             alt="page-next">
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-------------------- End Info Tour -------------------->
                    </div>
                </div>


                <!-------------------- Form Book Now -------------------->
                <div class="col-12 col-lg-5 col-xl-4">
                    <div class="box-book-now">
                        <input type="hidden" value="{{ $tour->price }}" id="price">
                        <p class="card-text">from <span class="card-title">${{ number_format($tour->price, 2) }}</span>
                        </p>
                        <hr>
                        <div class="info-tour d-flex justify-content-between">
                            <span class="card-text w-50">
                                Duration: <p
                                    class="card-title">{{ \App\Libraries\Utilities::durationToString($tour->duration) }}</p>
                            </span>
                            <span class="card-text w-50">
                                Tour type: <p class="card-title">{{ $tour->type->name }}</p>
                            </span>
                        </div>
                        <form action="">
                            <div class="input-inner-icon">
                                <img src="{{ asset('images/icon/schedule.svg') }}">
                                <input class="form-control" type="text" name="daterange" placeholder="Departure time">
                            </div>
                            <div class="input-inner-icon">
                                <img src="{{ asset('images/icon/people.svg') }}">
                                <select class="form-control" id="selectNumberPeople" required>
                                    <option value="1" class="">1 People</option>
                                    <option value="2" class="">2 People</option>
                                    <option value="3" class="">3 People</option>
                                    <option value="4" class="">4 People</option>
                                    <option value="5" class="">5 People</option>
                                    <option value="6" class="">6 People</option>
                                    <option value="7" class="">7 People</option>
                                    <option value="8" class="">8 People</option>
                                    <option value="9" class="">9 People</option>
                                    <option value="10" class="">10 People</option>
                                    <option value="11" class="">11 People</option>
                                    <option value="12" class="">12 People</option>
                                    <option value="13" class="">13 People</option>
                                    <option value="14" class="">14 People</option>
                                    <option value="15" class="">15 People</option>
                                    <option value="16" class="">16 People</option>
                                    <option value="17" class="">17 People</option>
                                    <option value="18" class="">18 People</option>
                                    <option value="19" class="">19 People</option>
                                    <option value="20" class="">20 People</option>
                                </select>
                            </div>
                            <div class="total-price d-flex justify-content-between">
                                <span class="card-text">
                                    Total
                                </span>
                                <span class="card-title" id="totalPrice">$</span>
                            </div>
                            <div class="input-search">
                                <button class="form-control btn-search-submit" type="submit">
                                    Book now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-------------------- End Form Book Now -------------------->
            </div>
        </div>
    </div>
    <!-------------------- End Body Tour Deatil -------------------->

    <!-------------------- Related Tours -------------------->
    <div class="box-slide slide-tour list-tours mt-5">
        <div class="container">
            <div class="header-slide d-flex align-items-end">
                <p class="title-slide">Related tours</p>
            </div>
            <div class="body-slide">
                <div class="row">
                    @foreach($relateTours as $tour)
                        <div class="col-6 col-lg-4">
                            <div class="card card-tour">
                                <div class="card-image">
                                    <img class="ribbon" src="{{ asset('/images/icon/ribbon.svg') }}"
                                         alt="bookmark">
                                    <div class="rate">
                                        <img src="{{ asset('images/icon/star.svg') }}" alt="star">
                                        <span class="text-rate">4.5</span>
                                    </div>
                                    <img src="{{ asset('storage/images/tours/'.$tour->image) }}" class="card-img-top"
                                         alt="tour-image">
                                </div>

                                <div class="card-body">
                                    <p class="card-text">
                                        <img src="{{ asset('images/icon/location.svg') }}" alt="location">
                                        <span>{{ $tour->type->name }}</span>
                                    </p>
                                    <h5 class="card-title"><a
                                            href="{{ route('client.tours.detail', $tour->slug) }}">{{ $tour->name }}</a>
                                    </h5>
                                    <div class="d-inline-flex justify-content-between align-items-center w-100">
                                        <p class="card-text">
                                            <img src="{{ asset('images/icon/schedule.svg') }}" alt="location">
                                            <span>{{ \App\Libraries\Utilities::durationToString($tour->duration) }}</span>
                                        </p>
                                        <p class="card-text">from <span class="card-title">${{ $tour->price }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-------------------- End Related Tours -------------------->
@endsection

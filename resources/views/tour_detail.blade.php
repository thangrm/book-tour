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
                    <div class="d-flex align-items-center">
                        <div class="rate">
                            <img src="{{ asset('images/icon/star.svg') }}" alt="star">
                            <span class="text-rate">{{ $rateReview['total'] }}</span>
                        </div>

                        <span class="text-content">{{ $tour->reviews->count() }} reviews</span>
                    </div>
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
                                    <img src="{{ asset('storage/images/tours/'.$tour->image) }}" alt="{{ $tour->name }}"
                                         id="mainImageTour">
                                </div>
                                <div class="list-image-thumbnail">
                                    <div class="owl-carousel" id="slideImageThumnail">
                                        <img class="thumbnailItem target"
                                             src="{{ asset('storage/images/tours/'.$tour->image) }}">
                                        @foreach($tour->galleries as $gallery)
                                            <img class="thumbnailItem"
                                                 src="{{ asset('storage/images/galleries/'.$gallery->image) }}">
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
                                            aria-controls="pills-review" aria-selected="false">
                                        Reviews({{ $tour->reviews->count()  }})
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
                                    </div>
                                    <hr>
                                    <div class="box-text">
                                        <p class="panel-title">
                                            What's Included
                                        </p>
                                        {!! $tour->included !!}
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
                                        {!! $tour->additional !!}
                                    </div>

                                    <div class="box-text">
                                        <p class="panel-title">FAQs</p>
                                        <!-- Accordion FAQs -->
                                        <div class="accordion" id="accordionFAQs">
                                            @foreach($tour->faqs as $faq)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header"
                                                        id="panelsFAQsHeading{{ $loop->index }}">
                                                        <button
                                                            class="accordion-button d-flex align-items-start {{ $loop->first ?: 'collapsed'  }}"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#panelsFAQsCollapse{{ $loop->index }}"
                                                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                            aria-controls="panelsFAQsCollapse{{ $loop->index }}">
                                                            <img src="{{ asset('images/icon/help-circle.svg') }}"
                                                                 alt="help">
                                                            <p class="m-0">{{ $faq->question }}</p>
                                                        </button>
                                                    </h2>
                                                    <div id="panelsFAQsCollapse{{ $loop->index }}"
                                                         class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                         aria-labelledby="panelsFAQsHeading{{ $loop->index }}">
                                                        <div class="accordion-body">
                                                            <p class="text-item">
                                                                {{ $faq->answer }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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
                                                    <p class="rate-title">{{ $rateReview['total'] }}/5</p>
                                                    <div class="list-rate-star">
                                                        @include('components.rate_review', ['rate'=>$rateReview['total']])
                                                    </div>
                                                    <p class="rate-text">Based on
                                                        <span>{{ $tour->reviews->count() }} reviews</span>
                                                    </p>
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
                                                            <div class="progress-bar bg-warning"
                                                                 style="width: {{ $rateReview['fiveStar'] / $tour->reviews->count() * 100 }}%;"
                                                                 role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span
                                                            class="text-review">{{ $rateReview['fiveStar'] }} reviews</span>
                                                    </div>

                                                    <div
                                                        class="rate-item d-flex justify-content-center align-items-center">
                                                        <p class="number-star d-flex justify-content-end align-items-center">
                                                            <span class="pe-1">4</span>
                                                            <i class="bi bi-star-fill fill-gray"></i>
                                                        </p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning"
                                                                 style="width: {{ $rateReview['fourStar'] / $tour->reviews->count() * 100 }}%;"
                                                                 role="progressbar" aria-valuenow="30" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span
                                                            class="text-review">{{ $rateReview['fourStar'] }} reviews</span>
                                                    </div>

                                                    <div
                                                        class="rate-item d-flex justify-content-center align-items-center">
                                                        <p class="number-star d-flex justify-content-end align-items-center">
                                                            <span class="pe-1">3</span>
                                                            <i class="bi bi-star-fill fill-gray"></i>
                                                        </p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning"
                                                                 style="width: {{ $rateReview['threeStar'] / $tour->reviews->count() * 100 }}%;"
                                                                 role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span
                                                            class="text-review">{{ $rateReview['threeStar'] }} reviews</span>
                                                    </div>

                                                    <div
                                                        class="rate-item d-flex justify-content-center align-items-center">
                                                        <p class="number-star d-flex justify-content-end align-items-center">
                                                            <span class="pe-1">2</span>
                                                            <i class="bi bi-star-fill fill-gray"></i>
                                                        </p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning"
                                                                 style="width: {{ $rateReview['twoStar'] / $tour->reviews->count() * 100 }}%;"
                                                                 role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span
                                                            class="text-review">{{ $rateReview['twoStar'] }} reviews</span>
                                                    </div>

                                                    <div
                                                        class="rate-item d-flex justify-content-center align-items-center">
                                                        <p class="number-star d-flex justify-content-end align-items-center">
                                                            <span class="pe-1">1</span>
                                                            <i class="bi bi-star-fill fill-gray"></i>
                                                        </p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning"
                                                                 style="width: {{ $rateReview['oneStar'] / $tour->reviews->count() * 100 }}%;"
                                                                 role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span
                                                            class="text-review">{{ $rateReview['oneStar'] }} reviews</span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="box-review d-flex align-items-start">
                                        <img src="{{ asset('images/icon/user.svg') }}" alt="" width="56">
                                        <form class="form-review w-100">
                                            <textarea class="form-control" rows="5"
                                                      placeholder="Type anything"></textarea>
                                            <input type="hidden" id="inputRateReview" value="4">
                                            <div class="d-flex justify-content-between mt-4">
                                                <div class="rate-review" id="rateReview">
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

                                        @foreach($reviews as $review)
                                            <div class="review-item">
                                                <div class="title-review d-flex justify-content-start w-100">
                                                    <img src="{{ asset('images/user-avatar.png') }}" alt="review">
                                                    <div class="info-review">
                                                        <div class="rate-review" id="rateReview{{ $loop->index }}">
                                                            @include('components.rate_review', ['rate'=>$review->rate])
                                                        </div>
                                                        <p class="text-title">The best experience ever! </p>
                                                        <span>Nevermind</span>
                                                        <i class="bi bi-dot"></i>
                                                        <span>{{ (new DateTime($review->created_at))->format("M Y") }}</span>
                                                    </div>

                                                </div>
                                                <p class="review-text">
                                                    {{ $review->comment }}
                                                </p>
                                            </div>
                                            <hr>
                                        @endforeach

                                    </div>

                                    <div class="pagination-tours d-flex justify-content-start align-items-baseline">
                                        {!! $reviews->links('components.pagination', ['isReviewPage' => true]) !!}
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

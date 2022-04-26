@extends('layouts.client')
@section('content')
    <!-------------------- Header -------------------->
    <div class="header">
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
                                <a class="nav-link active" href="#">{{ __('client.home') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">{{ __('client.about') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route('client.tours.list', 'all') }}">{{ __('client.tours') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">{{ __('client.hotels') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route('client.contact.index') }}">{{ __('client.contact') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pe-0" href="#">{{ __('client.login') }}</a>
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
                        <p class="text-welcome">{{ __('client.index.welcome_to_viet_nam') }}</p>
                        <p class="text-slogan">{{ __('client.index.perfect_place_for_your_stories') }}</p>
                    </div>
                    <div class="box-feature">
                        <div>
                            <span class="dot"></span>
                            <span>{{ __('client.index.feature') }}</span>
                        </div>
                        <div class="info-feature d-flex justify-content-between w-75">
                            <p>200+ <span>{{  __('client.tours') }}</span></p>
                            <p>100+ <span>{{  __('client.destinations') }}</span></p>
                            <p>8+ <span>{{  __('client.type_of_tour') }}</span></p>
                        </div>
                    </div>

                </div>

                <div class="col-12 col-xxl-4 col-lg-5 form-search">
                    <p class="title-search">{{ __('client.index.discover_beautiful_vietnam') }}</p>
                    <form action="{{ route('client.search.index') }}">
                        <div class="input-search input-inner-icon">
                            <img src="{{ asset('images/icon/search.svg') }}" alt="name tour">
                            <input class="form-control" type="text" name="tour_name"
                                   placeholder="{{ __('client.index.tour_name') }}">
                        </div>
                        <div class="input-search input-inner-icon">
                            <img src="{{ asset('images/icon/location.svg') }}" alt="location">
                            <input class="form-control" type="text" name="destination_name"
                                   placeholder="{{ __('client.index.location') }}">
                        </div>
                        <div class="input-search input-inner-icon">
                            <img src="{{ asset('images/icon/flag.svg') }}" alt="type_of_tour">
                            <select class="form-control" name="filter_type[]">
                                <option value="" disabled selected hidden>{{ __('client.type_of_tour') }}</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-search input-inner-icon">
                            <img src="{{ asset('images/icon/schedule.svg') }}" alt="duration">
                            <input class="form-control" type="text" name="duration"
                                   placeholder="{{ __('client.index.duration') }}">
                        </div>

                        <div class="input-search">
                            <button
                                class="form-control btn-search-submit d-flex justify-content-center align-items-center"
                                type="submit">
                                <img class="fill-white me-2" src="{{ asset('images/icon/search.svg') }}"
                                     alt="{{ __('client.search') }}">
                                {{ __('client.search') }}
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
                        <img class="img-introduce-top" src="{{ asset('images/introduce1.png') }}" alt="introduce">
                        <img class="img-introduce-bottom" src="{{ asset('images/introduce2.png') }}" alt="introduce">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="box-text-introduce">
                        <p class="introduce-title">
                            {{ __('client.index.with') }}
                            <span>{{ __('client.index.thang_loi_travel') }},</span> {{ __('client.index.immerses_you_in_majestic_space_and_unique_cultural_features') }}
                        </p>

                        <div class="content-introduce">
                            <div class="icon-droplet-introduce">
                                <img src="{{ asset('images/icon/droplets.svg') }}" alt="introduce">
                            </div>
                            <p>
                                {{ __('client.index.introduce_one') }}
                            </p>
                            <p>
                                {{ __('client.index.introduce_two') }}
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
                <p class="title-slide">  {{ __('client.index.discover_fascinating_destinations') }}</p>
                <a href="{{ route('client.destination.index') }}"
                   class="btn btn-view-all">  {{ __('client.index.view_all') }}</a>
            </div>
            <div class="body-slide">
                <div class="owl-carousel" id="slideDestinations">
                    @foreach ($destinations as $destination)
                        <div class="card card-destination">
                            <img src="{{ asset('storage/images/destinations/' . $destination->image) }}"
                                 class="card-img-top" alt="{{ $destination->name }}">
                            <div class="card-body">
                                <h5 class="card-title"><a
                                        href="{{ route('client.tours.list', $destination->slug) }}">
                                        {{ $destination->name }} </a>
                                </h5>
                                <p class="card-text">{{ $destination->tours()->count() }} {{ strtolower(__('tours')) }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>
    <!-------------------- End Slide Destinations-------------------->

    <!-------------------- Slide Tours -------------------->
    <div class="box-slide slide-tour">
        <div class="container">
            <div class="header-slide">
                <p class="title-slide">{{ __('client.index.attractive_tour_and_interesting_experiences') }}</p>
                <a href="{{ route('client.tours.list', 'trending') }}"
                   class="btn btn-view-all">{{ __('client.index.view_all') }}</a>
            </div>
            <div class="body-slide">
                <div class="owl-carousel" id="slideTours">
                    @foreach ($trendingTours as $tour)
                        <div class="card card-tour">
                            <div class="card-image">
                                <img class="ribbon" src="{{ asset('/images/icon/ribbon.svg') }}" alt="bookmark">
                                <div class="rate">
                                    <img src="{{ asset('images/icon/star.svg') }}" alt="star">
                                    <span
                                        class="text-rate">{{ \App\Libraries\Utilities::calculatorRateReView($tour->reviews)['total'] }}
                                    </span>
                                </div>
                                <img src="{{ asset('storage/images/tours/' . $tour->image) }}" class="card-img-top"
                                     alt="{{ $tour->name }}">
                            </div>

                            <div class="card-body">
                                <p class="card-text">
                                    <img src="{{ asset('images/icon/location.svg') }}" alt="location">
                                    <span>{{ $tour->destination->name }}</span>
                                </p>
                                <h5 class="card-title"><a
                                        href="{{ route('client.tours.detail', $tour->slug) }}">{{ $tour->name }}</a>
                                </h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="{{ asset('images/icon/schedule.svg') }}" alt="duration">
                                        <span>{{ \App\Libraries\Utilities::durationToString($tour->duration) }}</span>
                                    </p>
                                    <p class="card-text">{{ __('client.from') }} <span
                                            class="card-title">{{ number_format($tour->price * 20000) }} VNĐ</span></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
    <!-------------------- End Slide Tours-------------------->

    <!-------------------- Slide Traditional Cultural -------------------->
    <div class="box-slide slide-tour slide-cultural">
        <div class="container">
            <div class="header-slide">
                <p class="title-slide">{{ __('client.index.experience_the_traditional_cultural_beauties_of_Vietnam') }}</p>
                <a href="{{ route('client.tours.list', 'new') }}"
                   class="btn btn-view-all"> {{ __('client.index.view_all') }}</a>
            </div>
            <div class="body-slide">
                <div class="owl-carousel" id="slideCultural">
                    @foreach ($tours as $tour)
                        <div class="card card-tour">
                            <div class="card-image">
                                <img class="ribbon" src="{{ asset('/images/icon/ribbon.svg') }}" alt="bookmark">
                                <div class="rate">
                                    <img src="{{ asset('images/icon/star.svg') }}" alt="star">
                                    <span
                                        class="text-rate">{{ \App\Libraries\Utilities::calculatorRateReView($tour->reviews)['total'] }}
                                    </span>
                                </div>
                                <img src="{{ asset('storage/images/tours/' . $tour->image) }}" class="card-img-top"
                                     alt="{{ $tour->name }}">
                            </div>

                            <div class="card-body">
                                <p class="card-text">
                                    <img src="{{ asset('images/icon/location.svg') }}" alt="location">
                                    <span>{{ $tour->destination->name }}</span>
                                </p>
                                <h5 class="card-title"><a
                                        href="{{ route('client.tours.detail', $tour->slug) }}">{{ $tour->name }}</a>
                                </h5>
                                <div class="d-inline-flex justify-content-between align-items-center w-100">
                                    <p class="card-text">
                                        <img src="{{ asset('images/icon/schedule.svg') }}" alt="location">
                                        <span>{{ \App\Libraries\Utilities::durationToString($tour->duration) }}</span>
                                    </p>
                                    <p class="card-text">{{ __('client.from') }} <span
                                            class="card-title">{{ number_format($tour->price * 20000) }} VNĐ</span></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                        <p>{{ __('client.index.leave_us_an_email') }}, </p>
                        <p><span>{{ __('client.index.to_get_the_latest_deals') }}</span></p>
                    </div>

                </div>
                <div class="col-12 col-lg-5">
                    <div class="form-input-mail mt-2 mt-md-5 m-lg-0 d-flex justify-content-between align-items-center">
                        <div class="input-mail input-inner-icon flex-grow-1 flex-shrink-1">
                            <img src="{{ asset('images/icon/location.svg') }}" alt="support">
                            <input class="form-control" type="text" placeholder="example@gmail.com">
                        </div>
                        <button class="flex-grow-0 flex-shrink-0 btn-send-mail">{{ __('client.index.send') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-------------------- End Email Deals-------------------->
@endsection

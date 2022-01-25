@extends('layouts.client')
@section('content')
    <!-------------------- Header -------------------->
    <div class="header header-list-tours">
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
                                <a class="nav-link" href="{{ route('client.contact.index') }}">Contact</a>
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
                        <h1 class="text-slogan">Destination</h1>
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
                    <li class="breadcrumb-item"><a href="#">Tours</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-------------------- End Breadcrumb -------------------->

    <!-------------------- List Tours -------------------->
    <div class="box-slide slide-tour list-tours">
        <div class="container">
            <div class="header-slide d-flex align-items-end">
                <p class="title-slide">List Destination</p>
            </div>
            <div class="body-slide">
                <div class="row">
                    @foreach($destinations as $destination)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="card card-destination">
                                <img src="{{ asset('storage/images/destinations/'.$destination->image) }}"
                                     class="card-img-top"
                                     alt="{{ $destination->name }}">
                                <div class="card-body">
                                    <h5 class="card-title"><a
                                            href="{{ route('client.tours.list', $destination->slug) }}"> {{ $destination->name }} </a>
                                    </h5>
                                    <p class="card-text">{{ $destination->tours()->count() }} experiences</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="pagination-tours d-flex justify-content-end align-items-baseline w-100">
                {!! $destinations->links('components.pagination') !!}
            </div>
        </div>
    </div>
    <!-------------------- End List Tours-------------------->

@endsection



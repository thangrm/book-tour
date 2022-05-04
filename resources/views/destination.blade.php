@extends('layouts.client')
@section('css')
    <style>
        @media screen and (max-width: 767.98px) {
            .card-destination .card-img-top {
                height: 280px !important;
            }
        }

        @media screen and (max-width: 575.98px) {
            .card-destination .card-img-top {
                height: 180px !important;
            }
        }
    </style>
@endsection
@section('content')
    <!-------------------- Breadcrumb -------------------->
    <div class="breadcrumb-wrap">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: ''" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Destinations</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-------------------- End Breadcrumb -------------------->

    <!-------------------- List Destinations -------------------->
    <div class="box-slide slide-tour list-tours">
        <div class="container">
            <div class="header-slide d-flex align-items-end">
                <p class="title-slide">Danh sách các điểm đến</p>
            </div>
            <div class="body-slide">
                <div class="row">
                    @foreach($destinations as $destination)
                        <div class="col-6 col-lg-4 col-xl-3">
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



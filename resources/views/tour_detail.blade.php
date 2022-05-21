@extends('layouts.client')
@section('title')
    {{ $tour->meta_title == null ? $tour->name : $tour->meta_title }}
@endsection

@section('description')
    {{ $tour->meta_description == null ? $tour->name : $tour->meta_description }}
@endsection

@section('image_seo')
    {{  asset('storage/images/tours/'. ($tour->image_seo == null ? $tour->image : $tour->image_seo))  }}
@endsection

@section('url')
    {{ route('client.tours.detail', $tour->slug) }}
@endsection

@section('content')
    <link href="{{ asset('css/bootstrap-v5.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
    <!-------------------- Breadcrumb -------------------->
    <div class="breadcrumb-wrap">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: ''" aria-label="breadcrumb">
                <ol class="breadcrumb p-3">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('client.home') }}</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('client.search.index') }}">{{ __('client.tours') }}</a></li>
                    <li class="breadcrumb-item"><a href="#">{{ __('client.detail_tour') }}</a></li>
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

                        <span
                            class="text-content">{{ $rateReview['countReviews'][0] }} {{ __('client.reviews') }}</span>
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
                                             src="{{ asset('storage/images/tours/'.$tour->image) }}"
                                             alt="{{ $tour->name }}">
                                        @foreach($tour->galleries as $gallery)
                                            <img class="thumbnailItem"
                                                 src="{{ asset('storage/images/galleries/'.$gallery->image) }}"
                                                 alt="{{ $tour->name .'-gallery-'. $loop->index}}">
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
                                            aria-controls="pills-desc"
                                            aria-selected="true">{{ __('client.detail.description') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-info-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-info" type="button" role="tab"
                                            aria-controls="pills-info"
                                            aria-selected="false">{{ __('client.detail.addtional_info') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" href="#" id="pills-review-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-review" type="button" role="tab"
                                            aria-controls="pills-review" aria-selected="false">
                                        {{ __('client.detail.reviews') }}({{ $rateReview['countReviews'][0]  }})
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
                                            {{ __('client.detail.overview') }}
                                        </p>
                                        <p class="panel-text">
                                            {!! $tour->overview !!}
                                        </p>
                                    </div>
                                    <hr>
                                    <div class="box-text">
                                        <p class="panel-title">
                                            {{ __('client.detail.included') }}
                                        </p>
                                        {!! $tour->included !!}
                                    </div>
                                    <hr>
                                    <div class="box-text">
                                        <p class="panel-title">
                                            {{ __('client.detail.departure_return') }}
                                        </p>
                                        {!! $tour->departure !!}
                                    </div>
                                    <hr>
                                    <div class="box-text">
                                        <p class="panel-title">
                                            {{ __('client.itinerary') }}
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
                                                            {{ __('client.detail.day') . ' ' . $loop->index + 1}}
                                                            : {{ $itinerary->name }}
                                                            ({{ $itinerary->places->count() . ' ' . __('client.detail.stops')}}
                                                            )
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
                                                    <p class="rate-text"> {{__('client.detail.based_on')}}
                                                        <span>{{ $rateReview['countReviews'][0] }} {{ __('client.detail.reviews') }}</span>
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
                                                                 style="width: {{ $rateReview['fiveStar'] }}%;"
                                                                 role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span
                                                            class="text-review">{{ $rateReview['countReviews'][5] }} {{ __('client.reviews') }}</span>
                                                    </div>

                                                    <div
                                                        class="rate-item d-flex justify-content-center align-items-center">
                                                        <p class="number-star d-flex justify-content-end align-items-center">
                                                            <span class="pe-1">4</span>
                                                            <i class="bi bi-star-fill fill-gray"></i>
                                                        </p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning"
                                                                 style="width: {{ $rateReview['fourStar'] }}%;"
                                                                 role="progressbar" aria-valuenow="30" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span
                                                            class="text-review">{{ $rateReview['countReviews'][4] }} {{ __('client.reviews') }}</span>
                                                    </div>

                                                    <div
                                                        class="rate-item d-flex justify-content-center align-items-center">
                                                        <p class="number-star d-flex justify-content-end align-items-center">
                                                            <span class="pe-1">3</span>
                                                            <i class="bi bi-star-fill fill-gray"></i>
                                                        </p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning"
                                                                 style="width: {{ $rateReview['threeStar']}}%;"
                                                                 role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span
                                                            class="text-review">{{ $rateReview['countReviews'][3] }} {{ __('client.reviews') }}</span>
                                                    </div>

                                                    <div
                                                        class="rate-item d-flex justify-content-center align-items-center">
                                                        <p class="number-star d-flex justify-content-end align-items-center">
                                                            <span class="pe-1">2</span>
                                                            <i class="bi bi-star-fill fill-gray"></i>
                                                        </p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning"
                                                                 style="width: {{ $rateReview['twoStar']}}%;"
                                                                 role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span
                                                            class="text-review">{{ $rateReview['countReviews'][2] }} {{ __('client.reviews') }}</span>
                                                    </div>

                                                    <div
                                                        class="rate-item d-flex justify-content-center align-items-center">
                                                        <p class="number-star d-flex justify-content-end align-items-center">
                                                            <span class="pe-1">1</span>
                                                            <i class="bi bi-star-fill fill-gray"></i>
                                                        </p>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning"
                                                                 style="width: {{ $rateReview['oneStar']}}%;"
                                                                 role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                        <span
                                                            class="text-review">{{ $rateReview['countReviews'][1] }} {{ __('client.reviews') }}</span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="box-review d-flex align-items-start">
                                        <img src="{{ asset('images/icon/user.svg') }}" alt="user" width="56">
                                        <form action="{{ route('client.review.store', $tour->slug) }}"
                                              class="form-review w-100" method="post">
                                            @csrf
                                            <input type="hidden" id="discountCoupon" value="0">

                                            <textarea class="form-control" rows="5"
                                                      placeholder="{{ __('client.detail.type_anything') }}"
                                                      name="comment">{{ old('comment') }}</textarea>
                                            @error('comment')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <input type="hidden" id="inputRateReview" name="rate" value="4">
                                            <div class="d-flex flex-column flex-sm-row justify-content-between mt-4">
                                                <div class="rate-review" id="rateReview">
                                                    <i class="rate-star bi bi-star-fill fill-yellow" data-rate="1"></i>
                                                    <i class="rate-star bi bi-star-fill fill-yellow" data-rate="2"></i>
                                                    <i class="rate-star bi bi-star-fill fill-yellow" data-rate="3"></i>
                                                    <i class="rate-star bi bi-star-fill fill-yellow" data-rate="4"></i>
                                                    <i class="rate-star bi bi-star fill-yellow" data-rate="5"></i>
                                                </div>
                                                <button class="btn"
                                                        type="submit">{{ __('client.detail.upload_review') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                    <hr>

                                    <div class="box-list-review" id="boxListReview">

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
                        <input type="hidden" value="{{ $tour->duration }}" id="duration">
                        <p class="card-text">{{ __('client.from') }} <span
                                class="card-title">{{ number_format($tour->price) }} VNĐ</span>
                        </p>
                        <hr>
                        <div class="info-tour d-flex justify-content-between">
                            <span class="card-text w-50">
                                {{ __('client.index.duration') }} : <p
                                    class="card-title">{{ \App\Libraries\Utilities::durationToString($tour->duration) }}</p>
                            </span>
                            <span class="card-text w-50">
                                {{ __('client.type_of_tour') }} : <p class="card-title">{{ $tour->type->name }}</p>
                            </span>
                        </div>
                        <form action="{{ route('client.booking.index', $tour->slug) }}" id="formBookNow">
                            <div class="input-inner-icon">
                                <img src="{{ asset('images/icon/schedule.svg') }}" alt="departure">
                                <div id="departureTimePicker">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="departure_time"
                                           id="inputDepartureTime">
                                    <div id="departureTimePicker">
                                        <input class="form-control" type="text" id="departureTime">
                                        @error('departure_time')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="input-inner-icon">
                                <img src="{{ asset('images/icon/people.svg') }}" alt="people">
                                <select class="form-control" id="selectNumberPeople" name="people">
                                    @for($i = 1; $i <= 20; $i++)
                                        <option value="{{ $i }}">{{ $i }} Người</option>
                                    @endfor
                                </select>
                            </div>


                            <!--- PHÒNG -->
                            <h5>Loại phòng</h5>
                            <div class="input-inner-icon">
                                @foreach($tour->rooms as $room)
                                    <h6>{{ $room->name . ' - ' . number_format($room->price) . 'đ' }}</h6>
                                    <h7 style="color: grey">Còn
                                        <span id="roomAvailable{{ $room->id }}"></span> phòng
                                    </h7>
                                    <input type="hidden" min="0" class="selectRoom"
                                           name="room[{{ $loop->index }}][id]" value="{{ $room->id }}">
                                    <div class="input-inner-icon">
                                        <img src="{{ asset('images/icon/number.svg') }}" alt="people">
                                        <input type="number" class="form-control numberRoom"
                                               name="room[{{ $loop->index }}][number]" data-price="{{ $room->price }}"
                                               id="numberRoom{{ $room->id }}" placeholder="Số lượng phòng" min="0"
                                               value="0">
                                    </div>

                                @endforeach
                            </div>


                            <!--- KẾT THÚC THÊM MỚI -->
                            <div class="total-price d-flex justify-content-between">
                                <span class="card-text">
                                    {{ __('client.total') }}
                                </span>
                                <span class="card-title" id="totalPrice">VNĐ</span>
                            </div>
                            <div class="input-search">
                                <button class="form-control btn-search-submit" type="submit">
                                    {{ __('client.detail.book_now') }}
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
                <p class="title-related">{{ __('client.related_tour') }}</p>
            </div>
            <div class="body-slide">
                <div class="row">
                    @foreach($relateTours as $tourItem)
                        <div class="col-6 col-lg-4">
                            <div class="card card-tour">
                                <div class="card-image">
                                    <img class="ribbon" src="{{ asset('/images/icon/ribbon.svg') }}"
                                         alt="bookmark">
                                    <div class="rate">
                                        <img src="{{ asset('images/icon/star.svg') }}" alt="star">
                                        <span
                                            class="text-rate">{{ \App\Libraries\Utilities::calculatorRateReView($tourItem->reviews)['total'] }}
                                        </span>
                                    </div>
                                    <img src="{{ asset('storage/images/tours/'.$tourItem->image) }}"
                                         class="card-img-top"
                                         alt="{{ $tourItem->name }}">
                                </div>

                                <div class="card-body">
                                    <p class="card-text">
                                        <img src="{{ asset('images/icon/location.svg') }}" alt="location">
                                        <span>{{ $tourItem->destination->name }}</span>
                                    </p>
                                    <h5 class="card-title"><a
                                            href="{{ route('client.tours.detail', $tourItem->slug) }}">{{ $tourItem->name }}</a>
                                    </h5>
                                    <div class="d-inline-flex justify-content-between align-items-center w-100">
                                        <p class="card-text">
                                            <img src="{{ asset('images/icon/schedule.svg') }}" alt="location">
                                            <span>{{ \App\Libraries\Utilities::durationToString($tourItem->duration) }}</span>
                                        </p>
                                        <p class="card-text">{{ __('client.from') }} <span
                                                class="card-title">{{ number_format($tourItem->price) }}đ</span>
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

    <!-------------------- Other Data -------------------->
    <input type="hidden" value="{{ route('client.booking.check-room', $tour->slug) }}" id="linkCheckRoom">
@endsection
@section('js')
    <script>
        disableSubmitButton('#formBookNow');
        $('#formBookNow').submit(function (e) {
            e.preventDefault();
            $('.numberRoom').each(function () {
                if ($(this).val() == "") {
                    $(this).val(0);
                }
            })
            this.submit();
        })
    </script>
@endsection

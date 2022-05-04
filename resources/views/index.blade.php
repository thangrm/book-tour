@extends('layouts.client')
@section('content')
    <div class="box-banner-header" id="boxBanner">
        <div class="banner-header">
            <p class="title-header">Điểm du lịch tiếp theo</p>
            <p class="desc-header">Khám phá những địa điểm tuyệt vời với các ưu đãi độc quyền</p>

            <form action="{{ route('client.search.index') }}">
                <div class="box-find-tour">
                    <div class="row">
                        <div class="col-12 col-lg-3 col-find-tour search">
                            <input type="text" class="form-control form-find-tour" name="tour_name" placeholder="Từ khóa">
                        </div>
                        <div class="col-12 col-lg-3 col-find-tour">
                            <input class="form-control form-find-tour" name="destination_name" placeholder="Tên địa điểm">
                        </div>
                        <div class="col-12 col-lg-3 col-find-tour">
                            <select class="form-control form-find-tour" name="duration">
                                <option value="">Thời gian</option>
                                <option value="">1 ngày</option>
                                <option value="">2-4 ngày</option>
                                <option value="">5-7 ngày</option>
                                <option value="">7+ ngày</option>
                            </select>
                        </div>
                        <div class="col-12 col-lg-3 col-find-tour">
                            <button class="btn btn-find-tour">Tìm kiếm</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="box-statistical">
            <div class="statistical">
                <div class="row">
                    <div class="col-12 col-lg-4 statistical-item">
                        <img src="{{ asset('images/icon/tvicon1.png') }}" alt="number destinations">
                        <div class="statistical-content">
                            <p class="title">700+ ĐỊA ĐIỂM HẤP DẪN</p>
                            <p class="content">Nhóm chuyên gia của chúng tôi đã lựa chọn cẩn thận tất cả các điểm
                                đến</p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 statistical-item">
                        <img src="{{ asset('images/icon/tvicon2.png') }}" alt="best price guarantee">
                        <div class="statistical-content">
                            <p class="title">ĐẢM BẢO GIÁ TỐT NHẤT</p>
                            <p class="content">Liên hệ thỏa thuận giá cả trong vòng 48 giờ sau khi xác nhận đơn hàng</p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 statistical-item">
                        <img src="{{ asset('images/icon/tvicon3.png') }}" alt="top notch support">
                        <div class="statistical-content">
                            <p class="title">HỖ TRỢ NHANH CHÓNG</p>
                            <p class="content">Chúng tôi sẵn sàng trợ trước và ngay cả sau chuyến đi của bạn.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Destiantion -->
    <div class="popular-destination container">
        <div class="box-title">
            <p class="title">Các địa điểm nổi tiếng</p>
            <a href="{{ route('client.destination.index') }}">
                <span>Xem tất cả địa điểm</span>
                <i class="fa fa-long-arrow-right"></i>
            </a>
        </div>

        <div class="destinations">
            <div class="row">
                @foreach($destinations as $destination)
                    <div
                        class="col-12 @if ($loop->first) col-lg-8 @else col-lg-4 @endif destination-item">
                        <img src="{{ asset('storage/images/destinations/' . $destination->image) }}"
                             alt="{{ $destination->name }}">
                        <div class="info-destination">
                            <p class="name-destination">{{ $destination->name }}</p>
                            <p class="description">{{ $destination->description}}</p>
                            <a class="btn-view" href="{{ route('client.tours.list', $destination->slug) }}">
                                Xem tất cả tour
                            </a>
                        </div>
                        <div class="total-tours">5 tours</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- List tour -->
    <div class="popular-tour container">
        <div class="box-title">
            <p class="title">Các tour thường đến</p>
            <a href="#">
                <span>Xem tất cả tour</span>
                <i class="fa fa-long-arrow-right"></i>
            </a>
        </div>

        <div class="tours">
            <div class="row">
                @foreach ($trendingTours as $tour)
                    <div class="col-12 col-lg-4 mb-5">
                        <div class="card">
                            <a href="{{ route('client.tours.detail', $tour->slug) }}" class="tour-image">
                                <img class="card-img-top" src="{{ asset('storage/images/tours/' . $tour->image) }}"
                                     alt="{{ $tour->name }}">
                                <div class="best-seller {{ ($tour->trending) ? '' : 'd-none'  }}">
                                    <span>Nổi bật</span>
                                </div>
                            </a>
                            <div class="card-body">
                                <a href="{{ route('client.tours.detail', $tour->slug) }}" class="tour-title">
                                    <h5 class="card-title">{{ $tour->name }}</h5>
                                </a>
                                <div class="d-flex justify-content-between pt-3">
                                    <span><i
                                            class="fa-regular fa-clock tour-duration"></i> <span>{{ \App\Libraries\Utilities::durationToString($tour->duration) }}</span></span>
                                    <span class="price-discount">{{ number_format($tour->price * 1.2) }}đ</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>
                                        <i class="fa-solid fa-star star"></i>
                                        <i class="fa-solid fa-star star"></i>
                                        <i class="fa-solid fa-star star"></i>
                                        <i class="fa-solid fa-star star"></i>
                                        <i class="fa-solid fa-star star"></i>
                                    </p>
                                    <p class="price">{{ number_format($tour->price) }}đ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="ads container">
        <div class="row">
            <div class="col-6 ads-left">
                <p>Trải nghiểm kỳ nghỉ hè 2022 với chúng tôi</p>
                <span>Ưu đãi lên tới 40%</span>
            </div>
            <div class="col-6 ads-right">
                <img src="{{ asset('images/ads.jpg') }}" alt="ads tour">
            </div>
        </div>
    </div>

    <!-- Recomended tour -->
    <div class="recommended-tour container">
        <div class="box-title">
            <p class="title">Gợi ý của chúng tôi</p>
            <a href="#">
                <span>Xem tất cả tour</span>
                <i class="fa fa-long-arrow-right"></i>
            </a>
        </div>

        <div class="tours">
            <div class="row">
                @foreach ($tours as $tour)
                    <div class="col-12 col-lg-4 mb-5">
                        <div class="card">
                            <a href="{{ route('client.tours.detail', $tour->slug) }}" class="tour-image">
                                <img class="card-img-top" src="{{ asset('storage/images/tours/' . $tour->image) }}"
                                     alt="{{ $tour->name }}">
                                <div class="best-seller {{ ($tour->trending) ? '' : 'd-none'  }}">
                                    <span>Nổi bật</span>
                                </div>
                            </a>
                            <div class="card-body">
                                <a href="{{ route('client.tours.detail', $tour->slug) }}" class="tour-title">
                                    <h5 class="card-title">{{ $tour->name }}</h5>
                                </a>
                                <div class="d-flex justify-content-between pt-3">
                                    <span><i
                                            class="fa-regular fa-clock tour-duration"></i> <span>{{ \App\Libraries\Utilities::durationToString($tour->duration) }}</span></span>
                                    <span class="price-discount">{{ number_format($tour->price * 1.2) }}đ</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>
                                        <i class="fa-solid fa-star star"></i>
                                        <i class="fa-solid fa-star star"></i>
                                        <i class="fa-solid fa-star star"></i>
                                        <i class="fa-solid fa-star star"></i>
                                        <i class="fa-solid fa-star star"></i>
                                    </p>
                                    <p class="price">{{ number_format($tour->price) }}đ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

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
@section('js')
    <script>
        $(document).ready(function () {
            // Get screen size
            let windowsize = $(window).width();

            function checkWidth() {
                windowsize = $(window).width();
            }

            checkWidth();
            $(window).resize(checkWidth);

            // Event nav icon
            $('#nav-icon1,#overlay').click(function () {
                $('#body').toggleClass("nav-margin-right");
                $('#nav-icon1').toggleClass('open');
                $('#navbarNav').toggleClass("show");
                $('#overlay').toggleClass("show");
            });

            // Event hover menu
            $('#navHeader').on("mouseenter", ".nav-link", function () {
                navigatorBar($(this));
            });
            $('#navHeader').on("mouseleave", ".nav-link", function () {
                navigatorBar($('#navHeader .active'));
            });

            function navigatorBar(tab) {
                if (windowsize < 992) {
                    return;
                }
                let left = tab.offset().left - $('#navHeader').offset().left + 36;
                let top = tab.offset().top - $('#navHeader').offset().top + 35;
                let width = tab.width();

                $('#navigatorBar').css('left', left);
                $('#navigatorBar').css('top', top);
                $('#navigatorBar').css('width', width);
            }

            navigatorBar($('#navHeader .active'));
        });
    </script>
@endsection

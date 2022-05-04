@extends('layouts.client')
@section('content')
    <div class="banner-title mb-5">
        <img src="{{ asset('images/page-title.jpg') }}" alt="banner title">
        <p class="title">Liên hệ với chúng tôi</p>
    </div>

    <!-------------------- Breadcrumb -------------------->
{{--    <div class="breadcrumb-wrap">--}}
{{--        <div class="container">--}}
{{--            <nav style="--bs-breadcrumb-divider: ''" aria-label="breadcrumb">--}}
{{--                <ol class="breadcrumb">--}}
{{--                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>--}}
{{--                    <li class="breadcrumb-item">Contact Us</li>--}}
{{--                </ol>--}}
{{--            </nav>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-------------------- End Breadcrumb -------------------->

    <!-------------------- Contact -------------------->
    <div class="box-contact">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <p class="contact-title">Chúng tôi luôn lắng nghe những góp ý của bạn</p>
                    <p class="contact-text">Gửi cho chúng tôi một tin nhắn, chúng tôi sẽ phản hồi bạn sớm nhất có thể</p>
                    <form action="{{ route('client.contact.store') }}" class="form-contact" id="formContact"
                          method="post">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" placeholder="Tên của bạn" name="name"
                                   value="{{ old('name') }}">
                            <span class="text-danger" id="errorName"></span>
                            @error('name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="email" placeholder="Email của bản" name="email"
                                   value="{{ old('email') }}">
                            <span class="texet-danger" id="errorEmail"></span>
                            @error('email')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="phone" placeholder="Số điện thoại của bản" name="phone"
                                   value="{{ old('phone') }}">
                            <span class="text-danger" id="errorPhone"></span>
                            @error('phone')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea type="text" class="form-control" id="message" rows="5"
                                      placeholder="Nội dụng" name="message">{{ old('message') }}</textarea>
                            <span class="text-danger" id="errorMessage"></span>
                            @error('message')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-100 d-flex justify-content-end">
                            <button type="submit">Gửi lời nhắn</button>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="office">
                        <img class="office-background" src="{{ asset('images/introduce1.png') }}" alt="introduce">
                        <div class="info-office">
                            <p class="office-title">Địa chỉ</p>
                            <div class="info-office-item">
                                <img src="{{ asset('images/icon/home.svg') }}" alt="address">
                                <div class="text-item">
                                    <p class="text-title">Địa chỉ</p>
                                    <p class="text-content">Số 298 Đ. Cầu Diễn, Minh Khai, Bắc Từ Liêm, Hà Nội</p>
                                </div>
                            </div>
                            <div class="info-office-item">
                                <img src="{{ asset('images/icon/phone.svg') }}" alt="phone">
                                <div class="text-item">
                                    <p class="text-title">Số điện thoại</p>
                                    <p class="text-content">+84 123 456 789 </p>
                                </div>
                            </div>
                            <div class="info-office-item">
                                <img src="{{ asset('images/icon/email.svg') }}" alt="email">
                                <div class="text-item">
                                    <p class="text-title">Email</p>
                                    <p class="text-content">hoangthang@haui.com </p>
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
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.4736630801613!2d105.73291275019966!3d21.053735992233012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31345457e292d5bf%3A0x20ac91c94d74439a!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2hp4buHcCBIw6AgTuG7mWk!5e0!3m2!1svi!2s!4v1651668418745!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <!-------------------- End Contact -------------------->

    <!-------------------- List Tours -------------------->
    <div class="box-contact">
        <div class="container">

        </div>
    </div>
    <!-------------------- End List Tours-------------------->
@endsection
@section('js')
    <script>
        @if($errors->any())
        document.getElementById("formContact").scrollIntoView();
        @endif
    </script>
@endsection

@extends('layouts.client')
@section('content')
    <link href="{{ asset('css/bootstrap-v5.min.css') }}" rel="stylesheet" >

    <!-------------------- Checkout -------------------->
    <div class="box-checkout box-detail-tour" style="margin-top: 100px">
        <div class="container">
            <form id="formCheckout" action="{{ route('client.booking.store', $tour->slug) }}" method="post">
                <input type="hidden" value="{{ $tour->price }}" id="price">
                <input type="hidden" value="{{ $tour->duration }}" id="duration">
                @csrf
                <p class="title-checkout">Thông tin đặt tour</p>
                <div class="row box-detail-content box-checkout-content">
                    <div class="col-12 col-lg-7 col-xl-8">
                        <div class="box-body-checkout">

                            <hr>
                            <!-- checkout detail -->
                            <div class="box-checkout-item">
                                <p class="header-checkout">Thông tin khách hàng</p>
                                <p class="header-desc">Chúng tôi cần một số thông tin để xác nhận chuyến tham của bạn</p>
                                <div class="sub-checkout-item">
                                    <p class="sub-header">Người đặt </p>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="firstName" class="form-label title">Tên <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="firstName"
                                                   placeholder="Tên" name="first_name"
                                                   value="{{ old('first_name') }}">
                                            <p class="text-danger" id="errorFirstName"></p>
                                            @error('first_name')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="lastName" class="form-label title">Họ<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="lastName"
                                                   placeholder="Họ" name="last_name"
                                                   value="{{ old('last_name') }}">
                                            <p class="text-danger" id="errorLastName"></p>
                                            @error('last_name')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="email" class="form-label title">Email <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="email"
                                                   placeholder="email@domain.com" name="email"
                                                   value="{{ old('email') }}">
                                            <p class="text-danger" id="errorEmail"></p>
                                            @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="phone" class="form-label title">Số điện thoại<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="phone" placeholder="Số điện thoại"
                                                   name="phone" value="{{ old('phone') }}">
                                            <p class="text-danger" id="errorPhone"></p>
                                            @error('phone')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>

                                </div>

                                <div class="sub-checkout-item">
                                    <p class="sub-header">Địa chỉ </p>
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="address" class="form-label title">Địa chỉ của bạn</label>
                                            <input type="text" class="form-control" id="address"
                                                   placeholder="Địa chỉ của bạn" name="address"
                                                   value="{{ old('address') }}">
                                            <p class="text-danger" id="errorAddress"></p>
                                            @error('address')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="city" class="form-label title">Thành phố </label>
                                            <input type="text" class="form-control" id="city" placeholder="Thành phố của bạn"
                                                   name="city" value="{{ old('city') }}">
                                            <p class="text-danger" id="errorCity"></p>
                                            @error('city')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="province"
                                                   class="form-label title">Huyện </label>
                                            <input type="text" class="form-control" id="province"
                                                   placeholder="Your State/Province/Region" name="Huyện"
                                                   value="{{ old('province') }}">
                                            <p class="text-danger" id="errorProvince"></p>
                                            @error('province')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="zipCode" class="form-label title">Mã Zipcode</label>
                                            <input type="text" class="form-control" id="zipCode"
                                                   placeholder="Mã Zipcode" name="zipcode"
                                                   value="{{ old('zipcode') }}">
                                            <p class="text-danger" id="errorZipCode"></p>
                                            @error('zipcode')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="country" class="form-label title">Quốc gia</label>
                                            <input type="text" class="form-control" id="country"
                                                   placeholder="Quốc gia" name="country"
                                                   value="{{ old('country', 'Việt Nam') }}">
                                            <p class="text-danger" id="errorContry"></p>
                                            @error('country')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sub-checkout-item">
                                        <p class="sub-header">
                                            <label for="requirement" class="form-label">Yêu cầu của khách hàng</label>
                                        <p class="text-danger" id="errorRequirement"></p>
                                        <div class="row">
                                            <div class="col-12">
                                                <textarea type="text" class="form-control" id="requirement"
                                                          placeholder="Yêu cầu" rows="5"
                                                          name="requirement"
                                                          value="{{ old('requirement') }}"></textarea>
                                            </div>
                                        </div>
                                        @error('requirement')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <!-- Payment method -->
                            <div class="box-checkout-item">
                                <hr>
                                <p class="header-checkout">Phương thức thanh toán</p>
                                <p class="header-desc">STK: 88889999,</br>
                                    ACB - Chi nhánh Thường Tín</p>

                                <input class="form-check-input d-none" type="radio" name="payment_method" id="cash"
                                       value="1" checked>


{{--                                <div class="sub-checkout-item">--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="radio" name="payment_method"--}}
{{--                                               id="creditCard" value="2">--}}
{{--                                        <label class="form-check-label" for="creditCard">--}}
{{--                                            <span class="payment-title">Credit Card</span>--}}
{{--                                            <img class="payment-image" src="{{ asset('images/credit-card.png') }}"--}}
{{--                                                 alt="credit card">--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="radio" name="payment_method" id="paypal"--}}
{{--                                               value="3">--}}
{{--                                        <label class="form-check-label" for="paypal">--}}
{{--                                            <span class="payment-title">Paypal</span>--}}
{{--                                            <img class="payment-image" src="{{ asset('images/paypal.png') }}"--}}
{{--                                                 alt="paypal">--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="radio" name="payment_method" id="cash"--}}
{{--                                               value="1" checked>--}}
{{--                                        <label class="form-check-label" for="cash">--}}
{{--                                            <span class="payment-title">Pay in cash</span>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                @error('payment_method')--}}
{{--                                <p class="text-danger">{{ $message }}</p>--}}
{{--                                @enderror--}}
{{--                                <div class="sub-checkout-item">--}}
{{--                                    <ul class="list-policy">--}}
{{--                                        <li>You will be charged the total amount once your order is confirmed.</li>--}}
{{--                                        <li>If confirmation isn't received instantly, an authorization for the total--}}
{{--                                            amount will be held until your booking is confirmed.--}}
{{--                                        </li>--}}
{{--                                        <li>You can cancel for free up to 24 hours before the day of the experience,--}}
{{--                                            local time. By clicking 'Pay with PayPal,' you are acknowledging that you--}}
{{--                                            have read and are bound by Ojimah's--}}
{{--                                        </li>--}}
{{--                                        <li>Customer Terms of Use, Privacy Policy, plus the tour operator's rules &--}}
{{--                                            regulations (see the listing for more details).--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

                                <div class="sub-checkout-item">
                                    <button type="submit" class="btn-submit-checkout" id="btnSubmitCheckout">
                                        Đặt tour
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-------------------- Form Coupon -------------------->
                    <div class="col-12 col-lg-5 col-xl-4">
                        <div class="box-book-now box-coupon">
                            <div class="wrap-content-coupon">
                                <span class="card-title">{{ $tour->name }}</span>
                                <p class="text-content mt-2">
                                    <img src="{{ asset('images/icon/location.svg') }}" alt="location">
                                    <span>{{ $tour->destination->name   }}</span>
                                </p>
                                <div class="info-tour d-flex justify-content-between">
                                    <span class="card-text w-50">
                                    Duration:
                                        <p
                                            class="card-title">{{ \App\Libraries\Utilities::durationToString($tour->duration) }}
                                        </p>
                                    </span>
                                    <span class="card-text w-50">
                                    Tour type: <p class="card-title">{{ $tour->type->name }}</p>
                                </span>
                                </div>

                                <div class="input-inner-icon">
                                    <img src="{{ asset('images/icon/schedule.svg') }}" alt="departure">
                                    <input type="hidden"
                                           value="{{ old('departure_time', $departureTime) }}"
                                           name="departure_time"
                                           id="inputDepartureTime">
                                    <div id="departureTimePicker">
                                        <input class="form-control" type="text" id="departureTime">
                                        @error('departure_time')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-inner-icon">
                                    <img src="{{ asset('images/icon/people.svg') }}" alt="people">
                                    <select class="form-control" id="selectNumberPeople" name="people">
                                        @for($i = 1; $i <= 20; $i++)
                                            <option
                                                value="{{ $i }}" {{ (old('people', $people) == $i) ? 'selected' : '' }}>{{ $i }}
                                                People
                                            </option>
                                        @endfor
                                    </select>
                                    @error('people')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-inner-icon">
                                    <div class="row">
                                        <div class="col-7">
                                            <input class="form-control" style="padding-left: 30px" type="text" placeholder="Code">
                                        </div>
                                        <div class="col-5">
                                            <button type="button" class="btn-apply-coupon">Apply</button>
                                        </div>
                                    </div>
                                </div>

                                <!--- THÊM MỚI -->
                                <h5>Loại phòng</h5>
                                <div class="input-inner-icon">
                                    <img src="{{ asset('images/icon/home_icon.svg') }}" alt="people">
                                    <select class="form-control" id="selectRoom" name="room">
                                        <option value="2500000">Phòng hạng sang (1 giường) - 2.5tr</option>
                                        <option value="2000000">Phòng VIP (2 giường) - 2tr</option>
                                        <option value="1500000">Phòng thường (2 giường) - 1.5tr</option>
                                        <option value="1000000">Phòng thường (1 giường) - 1tr</option>
                                        <option value="800000">Phòng bình dân (1 giường) - 800k</option>
                                    </select>
                                </div>
                                <div class="input-inner-icon">
                                    <img src="{{ asset('images/icon/number.svg') }}" alt="people">
                                    <input type="number" class="form-control" id="numberRoom" name="number_room"
                                           placeholder="Số lượng phòng" min="1" value="1">
                                </div>

                                <h5>Dịch vụ kèm thêm</h5>
                                - Miễn phí bữa sáng</br>
                                - Miễn phí vé vào cửa</br></br>

                                <!--- KẾT THÚC THÊM MỚI -->

                            </div>
                            <div class="total-price-coupon d-flex justify-content-between">
                                <span class="card-text">
                                    Total
                                </span>
                                <span class="card-title" id="totalPrice">
                                    VNĐ
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-------------------- End Form Coupon -------------------->
                </div>

            </form>
        </div>
    </div>
    <!-------------------- End Checkout -------------------->

    <!-------------------- Thanks -------------------->
    <div class="modal fade thank-modal" id="thanksModal" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="panel-thank modal-content d-flex justify-content-center align-items-center flex-column">
                <p class="thank-title">Cảm ơn!</p>
                <p class="thank-text">Bạn đã đặt tour thành công.</p>
                <p class="thank-text">Thông tin chi tiết về giá cả và đặt xe,</p>
                <p class="thank-text"> sẽ được nhân viên liên hệ với bạn vào thời gian sớm nhất.</p>
                <button class="btn-back-home"><a class="d-flex align-items-center justify-content-center"
                                                 href="{{ route('index') }}">Quay lại trang chủ</a></button>
            </div>
        </div>
    </div>
    <!-------------------- End Thanks -------------------->
@endsection
@section('js')
    <script>
        disableSubmitButton('#formCheckout');

        $('#formCheckout').on('submit', function (e) {
            e.preventDefault();
            let link = $(this).attr('action');
            let formData = new FormData(document.getElementById('formCheckout'));

            $.ajax({
                url: link,
                type: 'post',
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    let type = response['alert-type'];
                    let message = response['message'];

                    if (type === 'success') {
                        $('#thanksModal').modal('show');
                        return;
                    }

                    toastrMessage(type, message);
                },
                error: function (jqXHR) {
                    let response = jqXHR.responseJSON;

                    if (response?.errors?.first_name !== undefined) {
                        $('#errorFirstName').text(response.errors.first_name[0]);
                    }

                    if (response?.errors?.last_name !== undefined) {
                        $('#errorLastName').text(response.errors.last_name[0]);
                    }

                    if (response?.errors?.email !== undefined) {
                        $('#errorEmail').text(response.errors.email[0]);
                    }

                    if (response?.errors?.phone !== undefined) {
                        $('#errorPhone').text(response.errors.phone[0]);
                    }

                    if (response?.errors?.address !== undefined) {
                        $('#errorAddress').text(response.errors.address[0]);
                    }

                    if (response?.errors?.city !== undefined) {
                        $('#errorCity').text(response.errors.city[0]);
                    }

                    if (response?.errors?.province !== undefined) {
                        $('#errorProvince').text(response.errors.province[0]);
                    }

                    if (response?.errors?.zipcode !== undefined) {
                        $('#errorZipCode').text(response.errors.zipcode[0]);
                    }

                    if (response?.errors?.country !== undefined) {
                        $('#errorContry').text(response.errors.country[0]);
                    }

                    if (response?.errors?.requirement !== undefined) {
                        $('#errorRequirement').text(response.errors.requirement[0]);
                    }

                    document.getElementById("formCheckout").scrollIntoView();
                },
                complete: function () {
                    enableSubmitButton('#formCheckout', 300);
                }
            });
        });

    </script>
@endsection

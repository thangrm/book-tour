@extends('layouts.client')
@section('content')
    <link href="{{ asset('css/bootstrap-v5.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">

    <!-------------------- Checkout -------------------->
    <div class="box-checkout box-detail-tour" style="margin-top: 100px">
        <div class="container">
            <form id="formCheckout" action="{{ route('client.booking.store', $tour->slug) }}" method="post">
                <input type="hidden" value="{{ $booking ? $booking->id : '' }}" id="bookingId" name="booking_id">
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
                                <p class="header-desc">Chúng tôi cần một số thông tin để xác nhận chuyến tham của
                                    bạn</p>
                                <div class="sub-checkout-item">
                                    <p class="sub-header">Người đặt </p>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="firstName" class="form-label title">Tên <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="firstName"
                                                   placeholder="Tên" name="first_name"
                                                   value="{{ old('first_name', $booking ? $booking->customer->first_name : '') }}">
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
                                                   value="{{ old('last_name', $booking ? $booking->customer->last_name : '') }}">
                                            <p class="text-danger" id="errorLastName"></p>
                                            @error('last_name')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="email" class="form-label title">Email</label>
                                            <input type="text" class="form-control" id="email"
                                                   placeholder="email@domain.com" name="email"
                                                   value="{{ old('email', $booking ? $booking->customer->email : '') }}">
                                            <p class="text-danger" id="errorEmail"></p>
                                            @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="phone" class="form-label title">Số điện thoại<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="phone"
                                                   placeholder="Số điện thoại"
                                                   name="phone"
                                                   value="{{ old('phone', $booking ? $booking->customer->phone : '') }}">
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
                                                   value="{{ old('address', $booking ? $booking->customer->address : '') }}">
                                            <p class="text-danger" id="errorAddress"></p>
                                            @error('address')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="city" class="form-label title">Thành phố </label>
                                            <input type="text" class="form-control" id="city"
                                                   placeholder="Thành phố của bạn"
                                                   name="city"
                                                   value="{{ old('city', $booking ? $booking->customer->city : '') }}">
                                            <p class="text-danger" id="errorCity"></p>
                                            @error('city')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="province"
                                                   class="form-label title">Huyện </label>
                                            <input type="text" class="form-control" id="province"
                                                   placeholder="Huyện" name="province"
                                                   value="{{ old('province', $booking ? $booking->customer->province : '') }}">
                                            <p class="text-danger" id="errorProvince"></p>
                                            @error('province')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="zipCode" class="form-label title">Mã Zipcode</label>
                                            <input type="text" class="form-control" id="zipCode"
                                                   placeholder="Mã Zipcode" name="zipcode"
                                                   value="{{ old('zipcode', $booking ? $booking->customer->zipcode : '') }}">
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
                                                          name="requirement">{{ old('requirement', $booking ? $booking->requirement : '') }}</textarea>
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

                                <div class="sub-checkout-item">
                                    {{--                                    <div class="form-check">--}}
                                    {{--                                        <input class="form-check-input" type="radio" name="payment_method"--}}
                                    {{--                                               id="creditCard" value="3">--}}
                                    {{--                                        <label class="form-check-label" for="creditCard">--}}
                                    {{--                                            <span class="payment-title">Credit Card</span>--}}
                                    {{--                                            <img class="payment-image" src="{{ asset('images/credit-card.png') }}"--}}
                                    {{--                                                 alt="credit card">--}}
                                    {{--                                        </label>--}}
                                    {{--                                    </div>--}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="paypal"
                                               value="2">
                                        <label class="form-check-label" for="paypal">
                                            <span class="payment-title">Ví Momo</span>
                                            <img class="payment-image"
                                                 src="{{ asset('images/icon/logo-momo.png') }}"
                                                 alt="momo">
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cash"
                                               value="1" checked>
                                        <label class="form-check-label" for="cash">
                                            <span class="payment-title">Bằng tiền mặt</span>
                                            <img class="payment-image"
                                                 src="{{ asset('images/icon/cash.png') }}"
                                                 alt="momo">
                                        </label>
                                    </div>
                                    <p class="header-desc"><b>STK: </b> 88889999,</br>
                                        Ngân hàng ACB - Chi nhánh Thường Tín</p>
                                </div>
                                @error('payment_method')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="sub-checkout-item">
                                    <ul class="list-policy">
                                        <li> Bạn sẽ bị tính tổng số tiền sau khi đơn đặt hàng của bạn được xác nhận.
                                        </li>
                                        <li> Nếu xác nhận không nhận được ngay lập tức, chúng tôi sẽ liên hệ vợi bạn sớm
                                            nhất có thể. Chậm nhất là 1 ngày làm việc kể cả thứ 7, chủ nhật và
                                            ngày lễ
                                        </li>
                                        <li> Bạn có thể hủy miễn phí đơn hàng trước 3 ngày trước khi chuyến hành trình
                                            được bắt đầu. Nếu còn ít hơn 3 ngày bạn sẽ bị mất 20% tiền cọc.
                                        </li>
                                        <li>
                                            Khi bạn thành toán với Momo, bạn xác nhận rằng bạn đã đọc về các ràng buộc
                                            thanh toán của Momo
                                        </li>
                                        <li> Điều khoản Sử dụng, Chính sách Bảo mật của Khách hàng, cùng với các quy tắc
                                            của nhà điều hành tour & quy định (xem danh sách để biết thêm chi tiết).
                                        </li>
                                    </ul>
                                </div>

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
                                <span
                                    class="card-title">{{ $tour->name . ' - ' . number_format($tour->price) . 'đ'}} </span>
                                <p class="text-content mt-2">
                                    <img src="{{ asset('images/icon/location.svg') }}" alt="location">
                                    <span>{{ $tour->destination->name   }}</span>
                                </p>
                                <div class="info-tour d-flex justify-content-between">
                                    <span class="card-text w-50">
                                    Thời gian:
                                        <p
                                            class="card-title">{{ \App\Libraries\Utilities::durationToString($tour->duration) }}
                                        </p>
                                    </span>
                                    <span class="card-text w-50">
                                    Thể loại: <p class="card-title">{{ $tour->type->name }}</p>
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
                                                Người
                                            </option>
                                        @endfor
                                    </select>
                                    @error('people')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-inner-icon">
                                    <div class="row">
                                        <input type="hidden" id="linkCheckCoupon" value="{{ route('coupons.check') }}">
                                        <input type="hidden" name="codeCoupon" id="codeCoupon"
                                               value="">
                                        <div class="col-7">
                                            <input class="form-control" style="padding-left: 30px" type="text"
                                                   placeholder="Code" id="coupon">
                                            <input type="hidden" id="discountCoupon" value="0">
                                        </div>
                                        <div class="col-5">
                                            <button type="button" id="btnCouponSubmit" class="btn-apply-coupon">Xác
                                                nhận
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!--- PHÒNG -->
                                <h5>Loại phòng</h5>
                                <div class="input-inner-icon">
                                    @foreach($tour->rooms as $room)
                                        @php
                                            $numberRoom = 0;
                                        @endphp
                                        @foreach($listRooms as $roomItem)
                                            @if($roomItem['id'] == $room->id)
                                                @php
                                                    $numberRoom = $roomItem['number'];
                                                @endphp
                                            @endif
                                        @endforeach
                                        <h6>{{ $room->name . ' - ' . number_format($room->price) . 'đ' }}</h6>
                                        <h7 style="color: grey">Còn 10 phòng</h7>
                                        <input type="hidden" min="0" class="selectRoom"
                                               name="room[{{ $loop->index }}][id]" value="{{ $room->id }}">
                                        <div class="input-inner-icon">
                                            <img src="{{ asset('images/icon/number.svg') }}" alt="people">
                                            <input type="number" class="form-control numberRoom"
                                                   name="room[{{ $loop->index }}][number]"
                                                   data-price="{{ $room->price }}"
                                                   value="{{ $numberRoom }}"
                                                   placeholder="Số lượng phòng" min="0">
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                            <div class="total-price-coupon d-flex justify-content-between align-items-center">
                                <span class="card-text">
                                    Tổng
                                </span>
                                <span class="card-title">
                                        <p class="d-none" id="priceAfterDiscount"
                                           style="text-decoration: line-through; color: grey"></p>
                                    <span id="totalPrice"></span>
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
        @isset($errorMomo)
        toastr.error('{{ $errorMomo }}');
        @endisset
    </script>
    <script>
        disableSubmitButton('#formCheckout');

        $('#formCheckout').on('submit', function (e) {
            e.preventDefault();
            let link = $(this).attr('action');
            let formData = new FormData(document.getElementById('formCheckout'));
            $('#errorFirstName').text('');
            $('#errorLastName').text('');
            $('#errorEmail').text('');
            $('#errorPhone').text('');
            $('#errorAddress').text('');
            $('#errorCity').text('');
            $('#errorProvince').text('');
            $('#errorZipCode').text('');
            $('#errorContry').text('');
            $('#errorRequirement').text('');

            $.ajax({
                url: link,
                type: 'post',
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    enableSubmitButton('#formCheckout', 300);
                    let type = response['alert-type'];
                    let message = response['message'];
                    let url = response['url'];

                    if (type === 'success') {
                        $('#thanksModal').modal('show');
                        return;
                    }

                    if (url) {
                        window.location.href = url;
                        return;
                    }

                    toastrMessage(type, message);
                },
                error: function (jqXHR) {
                    enableSubmitButton('#formCheckout', 300);
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
                }
            });
        });
    </script>
@endsection

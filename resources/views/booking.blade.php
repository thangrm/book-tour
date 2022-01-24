@extends('layouts.client')
@section('content')
    <!-------------------- Checkout -------------------->
    <div class="box-checkout box-detail-tour mt-5">
        <div class="container">
            <form id="formCheckout" action="{{ route('client.booking.store', $tour->slug) }}" method="post">
                <input type="hidden" value="{{ $tour->price }}" id="price">
                <input type="hidden" value="{{ $tour->duration }}" id="duration">
                @csrf
                <p class="title-checkout">Booking Submission</p>
                <div class="row box-detail-content box-checkout-content">
                    <div class="col-12 col-lg-7 col-xl-8">
                        <div class="box-body-checkout">

                            <hr>
                            <!-- checkout detail -->
                            <div class="box-checkout-item">
                                <p class="header-checkout">Traveler Details</p>
                                <p class="header-desc">Information we need to confirm your tour or activity</p>
                                <div class="sub-checkout-item">
                                    <p class="sub-header">Lead Traveler (Adult) </p>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="firstName" class="form-label title">First Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="firstName"
                                                   placeholder="First Name" name="first_name"
                                                   value="{{ old('first_name') }}">
                                            <p class="text-danger" id="errorFirstName"></p>
                                            @error('first_name')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="lastName" class="form-label title">Last Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="lastName"
                                                   placeholder="Last Name" name="last_name"
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
                                            <label for="phone" class="form-label title">Phone Number<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="phone" placeholder="Your Phone"
                                                   name="phone" value="{{ old('phone') }}">
                                            <p class="text-danger" id="errorPhone"></p>
                                            @error('phone')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>

                                </div>

                                <div class="sub-checkout-item">
                                    <p class="sub-header">Address </p>
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="address" class="form-label title">Your Address</label>
                                            <input type="text" class="form-control" id="address"
                                                   placeholder="Your Address" name="address"
                                                   value="{{ old('address') }}">
                                            <p class="text-danger" id="errorAddress"></p>
                                            @error('address')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="city" class="form-label title">City </label>
                                            <input type="text" class="form-control" id="city" placeholder="Your City"
                                                   name="city" value="{{ old('city') }}">
                                            <p class="text-danger" id="errorCity"></p>
                                            @error('city')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="province"
                                                   class="form-label title">State/Province/Region </label>
                                            <input type="text" class="form-control" id="province"
                                                   placeholder="Your State/Province/Region" name="province"
                                                   value="{{ old('province') }}">
                                            <p class="text-danger" id="errorProvince"></p>
                                            @error('province')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="zipCode" class="form-label title">Zip Code/ Postal Code</label>
                                            <input type="text" class="form-control" id="zipCode"
                                                   placeholder="Zip Code/ Postal Code" name="zipcode"
                                                   value="{{ old('zipcode') }}">
                                            <p class="text-danger" id="errorZipCode"></p>
                                            @error('zipcode')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="country" class="form-label title">Country</label>
                                            <input type="text" class="form-control" id="country"
                                                   placeholder="Your Country" name="country"
                                                   value="{{ old('country') }}">
                                            <p class="text-danger" id="errorContry"></p>
                                            @error('country')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sub-checkout-item">
                                        <p class="sub-header">
                                            <label for="requirement" class="form-label">Special Requirement</label>
                                        <p class="text-danger" id="errorRequirement"></p>
                                        <div class="row">
                                            <div class="col-12">
                                                <textarea type="text" class="form-control" id="requirement"
                                                          placeholder="Special Requirement" rows="5"
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
                                <p class="header-checkout">Payment Menthod</p>
                                <p class="header-desc">Pay securely—we use SSL encryption to keep your data safe</p>
                                <div class="sub-checkout-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                               id="creditCard" value="2">
                                        <label class="form-check-label" for="creditCard">
                                            <span class="payment-title">Credit Card</span>
                                            <img class="payment-image" src="{{ asset('images/credit-card.png') }}"
                                                 alt="credit card">
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="paypal"
                                               value="3">
                                        <label class="form-check-label" for="paypal">
                                            <span class="payment-title">Paypal</span>
                                            <img class="payment-image" src="{{ asset('images/paypal.png') }}"
                                                 alt="paypal">
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cash"
                                               value="1" checked>
                                        <label class="form-check-label" for="cash">
                                            <span class="payment-title">Pay in cash</span>
                                        </label>
                                    </div>
                                </div>
                                @error('payment_method')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="sub-checkout-item">
                                    <ul class="list-policy">
                                        <li>You will be charged the total amount once your order is confirmed.</li>
                                        <li>If confirmation isn't received instantly, an authorization for the total
                                            amount will be held until your booking is confirmed.
                                        </li>
                                        <li>You can cancel for free up to 24 hours before the day of the experience,
                                            local time. By clicking 'Pay with PayPal,' you are acknowledging that you
                                            have read and are bound by Ojimah's
                                        </li>
                                        <li>Customer Terms of Use, Privacy Policy, plus the tour operator's rules &
                                            regulations (see the listing for more details).
                                        </li>
                                    </ul>
                                </div>

                                <div class="sub-checkout-item">
                                    <button type="submit" class="btn-submit-checkout" id="btnSubmitCheckout">
                                        Complete Booking
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
                                    <img src="{{ asset('images/icon/schedule.svg') }}">
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
                                    <img src="{{ asset('images/icon/people.svg') }}">
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
                                            <input class="form-control ps-3" type="text" placeholder="Promo Code">
                                        </div>
                                        <div class="col-5">
                                            <button type="button" class="btn-apply-coupon">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="total-price-coupon d-flex justify-content-between">
                                <span class="card-text">
                                    Total
                                </span>
                                <span class="card-title" id="totalPrice">
                                    $
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
                <p class="thank-title">Thank You!</p>
                <p class="thank-text">Your order has been successfully ordered.</p>
                <p class="thank-text"> Order information has been emailed to you. Thank you!</p>
                <button class="btn-back-home"><a class="d-flex align-items-center justify-content-center" href="/">Back
                        to our home</a></button>
            </div>
        </div>
    </div>
    <!-------------------- End Thanks -------------------->
@endsection
@section('js')
    <script>
        disableSubmitButton('#formCheckout');
    </script>
@endsection

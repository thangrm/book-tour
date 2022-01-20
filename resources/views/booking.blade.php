@extends('layouts.client')
@section('content')
    <!-------------------- Checkout -------------------->
    <div class="box-checkout box-detail-tour mt-5">
        <div class="container">
            <p class="title-checkout">Booking Submission</p>
            <div class="row box-detail-content box-checkout-content">
                <div class="col-12 col-lg-7 col-xl-8">
                    <div class="box-body-checkout">
                        <form id="formCheckout">
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
                                                   placeholder="First Name" maxlength="50">
                                            <span class="text-danger" id="errorFirstName"></span>
                                        </div>
                                        <div class="col-6">
                                            <label for="lastName" class="form-label title">Last Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="lastName"
                                                   placeholder="Last Name" maxlength="50">
                                            <span class="text-danger" id="errorLastName"></span>
                                        </div>
                                        <div class="col-6">
                                            <label for="email" class="form-label title">Email <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="email"
                                                   placeholder="email@domain.com" maxlength="100">
                                            <span class="text-danger" id="errorEmail"></span>
                                        </div>
                                        <div class="col-6">
                                            <label for="phone" class="form-label title">Phone Number<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="phone" placeholder="Your Phone"
                                                   maxlength="15">
                                            <span class="text-danger" id="errorPhone"></span>
                                        </div>

                                    </div>

                                </div>

                                <div class="sub-checkout-item">
                                    <p class="sub-header">Address </p>
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="address" class="form-label title">Your Address</label>
                                            <input type="text" class="form-control" id="address"
                                                   placeholder="Your Address" maxlength="200">
                                            <span class="text-danger" id="errorAddress"></span>
                                        </div>
                                        <div class="col-6">
                                            <label for="city" class="form-label title">City </label>
                                            <input type="text" class="form-control" id="city" placeholder="Your City"
                                                   maxlength="100">
                                            <span class="text-danger" id="errorCity"></span>
                                        </div>
                                        <div class="col-6">
                                            <label for="province"
                                                   class="form-label title">State/Province/Region </label>
                                            <input type="text" class="form-control" id="province"
                                                   placeholder="Your State/Province/Region" maxlength="50">
                                            <span class="text-danger" id="errorProvince"></span>
                                        </div>
                                        <div class="col-6">
                                            <label for="zipCode" class="form-label title">Zip Code/ Postal Code</label>
                                            <input type="text" class="form-control" id="zipCode"
                                                   placeholder="Zip Code/ Postal Code" maxlength="10">
                                            <span class="text-danger" id="errorZipCode"></span>
                                        </div>
                                        <div class="col-6">
                                            <label for="country" class="form-label title">Country</label>
                                            <input type="text" class="form-control" id="country"
                                                   placeholder="Your Country" maxlength="50">
                                            <span class="text-danger" id="errorContry"></span>
                                        </div>
                                    </div>

                                    <div class="sub-checkout-item">
                                        <p class="sub-header">
                                            <label for="requirement" class="form-label">Special Requirement</label>
                                            <span class="text-danger" id="errorRequirement"></span>
                                        </p>
                                        <div class="row">
                                            <div class="col-12">
                                                <textarea type="text" class="form-control" id="requirement"
                                                          placeholder="Special Requirement" rows="5"></textarea>
                                            </div>
                                        </div>
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
                                        <input class="form-check-input" type="radio" name="paymentMethod"
                                               id="creditCard" value="creditCard">
                                        <label class="form-check-label" for="creditCard">
                                            <span class="payment-title">Credit Card</span>
                                            <img class="payment-image" src="images/credit-card.png" alt="credit card">
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="paypal"
                                               value="paypal">
                                        <label class="form-check-label" for="paypal">
                                            <span class="payment-title">Paypal</span>
                                            <img class="payment-image" src="images/paypal.png" alt="paypal">
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="cash"
                                               value="cash" checked>
                                        <label class="form-check-label" for="cash">
                                            <span class="payment-title">Pay in cash</span>
                                        </label>
                                    </div>
                                </div>
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
                        </form>
                    </div>
                </div>


                <!-------------------- Form Coupon -------------------->
                <div class="col-12 col-lg-5 col-xl-4">
                    <div class="box-book-now box-coupon">
                        <form action="">
                            <div class="wrap-content-coupon">
                                <span class="card-title">Discover interesting things in the romantic coastal city of Vungtau</span>
                                <p class="text-content mt-2">
                                    <img src="images/icon/location.svg" alt="location">
                                    <span>Vungtau City, Baria-Vungtau</span>
                                </p>
                                <div class="info-tour d-flex justify-content-between">
                                    <span class="card-text w-50">
                                    Duration: <p class="card-title">3 days - 2 nights</p>
                                </span>
                                    <span class="card-text w-50">
                                    Tour type: <p class="card-title">Sun - Beach</p>
                                </span>
                                </div>

                                <div class="input-inner-icon">
                                    <img src="images/icon/schedule.svg">
                                    <input class="form-control" type="text" name="daterange"
                                           placeholder="Departure time">
                                </div>
                                <div class="input-inner-icon">
                                    <img src="images/icon/people.svg">
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
                                <div class="input-inner-icon">
                                    <div class="row">
                                        <div class="col-7">
                                            <input class="form-control ps-3" type="text" placeholder="Promo Code">
                                        </div>
                                        <div class="col-5">
                                            <button class="btn-apply-coupon">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="total-price-coupon d-flex justify-content-between">
                                <span class="card-text">
                                    Total
                                </span>
                                <span class="card-title" id="totalPrice">
                                    $450.00
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <!-------------------- End Form Coupon -------------------->
            </div>
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
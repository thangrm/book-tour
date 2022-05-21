$(document).ready(function () {
    $("#slideDestinations").owlCarousel({
        loop: false,
        margin: 30,
        responsiveClass: true,
        dots: false,
        nav: true,
        navText: [`<img src="images/icon/arrow-right.svg" alt="prev">`,
            `<img src="images/icon/arrow-right.svg" alt="next">`
        ],
        responsive: {
            0: {
                items: 2,
            },
            768: {
                items: 2,
            },
            992: {
                items: 3,
            },
            1200: {
                items: 4,
            },
        }
    });

    $("#slideTours").owlCarousel({
        loop: false,
        margin: 30,
        responsiveClass: true,
        dots: false,
        nav: true,
        navText: [`<img src="images/icon/arrow-right.svg" alt="prev">`,
            `<img src="images/icon/arrow-right.svg" alt="next">`
        ],
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1200: {
                items: 3,
            },
        }
    });


    $("#slideCultural").owlCarousel({
        loop: false,
        margin: 30,
        responsiveClass: true,
        dots: false,
        nav: true,
        navText: [`<img src="images/icon/arrow-right.svg" alt="prev">`,
            `<img src="images/icon/arrow-right.svg" alt="next">`
        ],
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1200: {
                items: 3,
            },
        }
    });

    $("#slideImageThumnail").owlCarousel({
        loop: false,
        margin: 30,
        dots: false,
        responsive: {
            0: {
                items: 3,
            },
            1200: {
                items: 4,
            },
        }
    });

    $('.next-slide').click(function (event) {
        let slideID = event.target.getAttribute('data-target');
        $(slideID).trigger('next.owl.carousel');
    })

    // Change icon nav-header

    // left: 37, up: 38, right: 39, down: 40,
    // spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
    var keys = {37: 1, 38: 1, 39: 1, 40: 1};

    function preventDefault(e) {
        e.preventDefault();
    }

    function preventDefaultForScrollKeys(e) {
        if (keys[e.keyCode]) {
            preventDefault(e);
            return false;
        }
    }

    // modern Chrome requires { passive: false } when adding event
    var supportsPassive = false;
    try {
        window.addEventListener("test", null, Object.defineProperty({}, 'passive', {
            get: function () {
                supportsPassive = true;
            }
        }));
    } catch (e) {
    }

    var wheelOpt = supportsPassive ? {passive: false} : false;
    var wheelEvent = 'onwheel' in document.createElement('div') ? 'wheel' : 'mousewheel';

    // call this to Disable
    function disableScroll() {
        window.addEventListener('DOMMouseScroll', preventDefault, false); // older FF
        window.addEventListener(wheelEvent, preventDefault, wheelOpt); // modern desktop
        window.addEventListener('touchmove', preventDefault, wheelOpt); // mobile
        window.addEventListener('keydown', preventDefaultForScrollKeys, false);
    }

    // call this to Enable
    function enableScroll() {
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
        window.removeEventListener(wheelEvent, preventDefault, wheelOpt);
        window.removeEventListener('touchmove', preventDefault, wheelOpt);
        window.removeEventListener('keydown', preventDefaultForScrollKeys, false);
    }

    $('#navbarBtn').on('click', function () {
        $('#navbarBtn').toggleClass('navbar-active-btn');
        if ($('#navbarBtn').hasClass('navbar-active-btn')) {
            disableScroll();
        } else {
            enableScroll();
        }
    });

    // Chang icon Filter - List Tour Page
    $('#btnFilterTours').on('click', function () {
        $('.iconBtnFilter').toggleClass('d-none');
    });

    // Clear form filter
    $('#clearFormFilter').on('click', function () {
        $('#formSelectFilter')[0].reset();
    })

    // Choose thumbnail image
    $('.thumbnailItem').on('click', function (e) {
        $('.thumbnailItem').removeClass("target");
        e.target.classList.add("target");
        linkSrc = e.target.getAttribute('src');
        $('#mainImageTour').attr('src', linkSrc);
    });

    // Rate review{
    $('.rate-star').hover(function (e) {
        let currentRate = e.target.dataset.rate;
        $('#inputRateReview').val(currentRate);
        $('#rateReview').children().each(function () {
            if (this.dataset.rate <= currentRate) {
                this.classList.remove('bi-star');
                this.classList.add('bi-star-fill');
            } else {
                this.classList.remove('bi-star-fill');
                this.classList.add('bi-star');
            }
        });
    }, function () {
        // out
    });

    // Check has page review
    let url = new URL(window.location.href);
    if (url.searchParams.get('page')) {
        $('#pills-review-tab').trigger('click');
        if ($('#pills-review-tab').length) {
            document.getElementById("pills-review-tab").scrollIntoView();
        }
    }

    //Panorama
    if ($('#imagePanoramic').length > 0) {
        pannellum.viewer('imagePanoramic', {
            "type": "equirectangular",
            "panorama": "./images/travel-360.jpg",
            "autoLoad": true,
        });
    }

    $('#imagePanoramic').on('click', function () {
        $('.wrap-panoramic').hide();
    });

    //Video
    $('#videoTour, .wrap-video').on('click', function () {
        let video = $('#videoTour').get(0);
        if (video.paused) {
            video.play();
            $('#iconPlayVideo').hide();
            $('#iconPauseVideo').show();
            $('.wrap-video').hide();
        }
    });

    // Departure time picker
    $('#departureTime').on('target', function () {
        $('#departureTimePicker').trigger('click');
    });

    let durationDay = $('#duration').val();
    let timeDeparutre = Date.parse($('#inputDepartureTime').val());
    if (isNaN(timeDeparutre)) {
        timeDeparutre = Date.now();
    }

    let startDepartureDate = new Date(timeDeparutre);
    let endDepartureDate = new Date(timeDeparutre + durationDay * 24 * 60 * 60 * 1000);
    $('#departureTime').val(startDepartureDate.toLocaleDateString("en-US") + ' - ' + endDepartureDate.toLocaleDateString("en-US"));

    $('#departureTimePicker').daterangepicker({
        singleDatePicker: true,
        startDate: startDepartureDate,
        locale: {
            format: 'MM/DD/YYYY',
        },
        minDate: moment(),
    }, function (start, end) {
        $('#inputDepartureTime').val(start.format("YYYY-MM-DD"));

        end.add(durationDay - 1, 'days');
        $('#departureTime').val(start.format("M/D/YYYY") + ' - ' + end.format("M/D/YYYY"));
        checkRoom(start.format("YYYY-MM-DD"));
    });

    checkRoom($('#departureTimePicker').data('daterangepicker').startDate.format("YYYY-MM-DD"));

    // Check room
    function checkRoom(date) {
        let linkCheckRoom = $('#linkCheckRoom').val();
        $.ajax({
            url: linkCheckRoom,
            method: "GET",
            data: {date: date},
            success: function (response) {
                for (const [key, value] of Object.entries(response.room_available)) {
                    $('#roomAvailable' + key).text(value);
                    $('#numberRoom' + key).prop('max', value);
                }
            }
        });
    }

    // Calculate Price
    let PRICE_DEFAULT = $('#price').val();
    $('#selectNumberPeople').on('change', function () {
        caculatePrice();
    });

    $('.numberRoom').on('keyup', function () {
        if ($(this).val() < 0) {
            $(this).val(0);
        }
        caculatePrice();
    });

    function caculatePrice() {
        let numberPeople = $('#selectNumberPeople').val();
        let discount = $('#discountCoupon').val();
        let price = numberPeople * PRICE_DEFAULT;
        if (isNaN(price)) {
            $('#totalPrice').text('VNĐ');

            return;
        }
        let priceRoom = 0;
        $('.numberRoom').each(function (index) {
            if ($(this).val() > 0) {
                priceRoom += $(this).data('price') * $(this).val();
            }
        });

        price = price + priceRoom;
        let total = price - price * discount / 100;
        $('#totalPrice').text(total.toLocaleString() + ' VNĐ');

        $('#priceAfterDiscount').text(price.toLocaleString() + ' VNĐ - ' + discount + '%');
        if (discount > 0) {
            $('#priceAfterDiscount').removeClass('d-none');
        }
    }

    caculatePrice();

    //Apply coupon
    $('#btnCouponSubmit').on('click', function (e) {
        $(this).prop('disabled', true);
        let code = $('#coupon').val();
        if (code === "") {
            toastr.error("Không được để trống mã giảm giá");
            $('#btnCouponSubmit').prop('disabled', false);
            return;
        }

        $.ajax({
            url: $('#linkCheckCoupon').val(),
            type: 'get',
            data: {code: code},
            success: function (response) {
                $('#discountCoupon').val(response.discount);
                $('#codeCoupon').val(response.code);
                caculatePrice();
                toastr.success("Áp dụng mã giảm giá thành công");
            },
            error: function (jqXHR) {
                let response = jqXHR.responseJSON;
                toastr.error(response.message);
            },
            complete: function () {
                $('#btnCouponSubmit').prop('disabled', false);
            }
        });
    });

    // Function validate
//     function stringContainsNumber(_string) {
//         return /\d/.test(_string);
//     }
//
//     function stringOnlyNumber(_string) {
//         return /^\d+$/.test(_string);
//     }
//
//     function checkMail(_string) {
//         return /^[a-z][a-z0-9_\.]{2,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}/.test(_string);
//     }
//
//     function removeAllWhiteSpace(_string) {
//         return _string.replace(/\s+/g, '')
//     }
//
//     function checkPhone(_string) {
//         _string = _string.replace(/\s+/g, '');
//         // Mobile
//         if (/^(0|\+84)[35789]([0-9]{8})$/.test(_string)) {
//             return true;
//         }
//
//         return /^(0|\+84)2([0-9]{9})$/.test(_string)
//     }
//
//     function escapeHTML(str) {
//         return str
//             .replace(/&/g, "&amp;")
//             .replace(/</g, "&lt;")
//             .replace(/>/g, "&gt;")
//             .replace(/"/g, "&quot;")
//             .replace(/'/g, "&#039;");
//     }
//
//     function getValue(_selector) {
//         return escapeHTML(($.trim($(_selector).val())));
//     }
//
//     // Form checkout
//     $("#btnSubmitCheckout").click(function (e) {
//         e.preventDefault();
//         let firstName = getValue('#firstName');
//         let lastName = getValue('#lastName');
//         let email = getValue('#email');
//         let phone = getValue('#phone ');
//         let address = getValue('#address');
//         let city = getValue('#city');
//         let province = getValue('#province');
//         let zipCode = getValue('#zipCode ');
//         let country = getValue('#country');
//         let requirement = getValue('#requirement');
//         let payment = $('input[name=paymentMethod]:checked', '#formCheckout').val()
//
//         $('#errorFirstName').text('');
//         $('#errorLastName').text('');
//         $('#errorEmail').text('');
//         $('#errorPhone').text('');
//         $('#errorAddress').text('');
//         $('#errorCity').text('');
//         $('#errorProvince').text('');
//         $('#errorZipCode').text('');
//         $('#errorCountry').text('');
//         $('#errorRequirement').text('');
//
//         let flag = true;
//
//         // validate first name
//         if (firstName == '') {
//             $('#errorFirstName').text('The first name field is required.');
//             flag = false;
//         } else if (stringContainsNumber(firstName)) {
//             $('#errorFirstName').text('The first name format is invalid.');
//             flag = false;
//         }
//
//         // validate last name
//         if (lastName == '') {
//             $('#errorLastName').text('The last name field is required.');
//             flag = false;
//         } else if (stringContainsNumber(lastName)) {
//             $('#errorLastName').text('The last name format is invalid.');
//             flag = false;
//         }
//
//         // validate email
//         if (email == '') {
//             $('#errorEmail').text('The email field is required.');
//             flag = false;
//         } else if (!checkMail(email)) {
//             $('#errorEmail').text('The email format is invalid.');
//             flag = false;
//         }
//
//         // validate phone
//         if (phone == '') {
//             $('#errorPhone').text('The phone field is required.');
//             flag = false;
//         } else if (!checkPhone(phone)) {
//             $('#errorPhone').text('The phone format is invalid.');
//             flag = false;
//         }
//
//         // validate zipcode
//         if (zipCode != '') {
//             if (!stringOnlyNumber(zipCode)) {
//                 $('#errorZipCode').text('The zipcode format is invalid.');
//                 flag = false;
//             }
//         }
//
//         if (flag) {
//             //$('#formCheckout').submit();
//             $('#thanksModal').modal('show');
//         } else {
//             document.getElementById("formCheckout").scrollIntoView();
//         }
//     });
//
//     // Form contact
//     $("#formContact").submit(function (e) {
//         e.preventDefault();
//         let name = getValue('#name');
//         let email = getValue('#email');
//         let phone = getValue('#phone ');
//         let message = getValue('#message');
//         $('#errorName').text('');
//         $('#errorEmail').text('');
//         $('#errorPhone').text('');
//         $('#errorMessage').text('');
//
//         // validate name
//         if (name == '') {
//             $('#errorName').text('The name field is required.');
//         } else if (stringContainsNumber(name)) {
//             $('#errorName').text('The name format is invalid.');
//         }
//
//         // validate email
//         if (email == '') {
//             $('#errorEmail').text('The email field is required.');
//         } else if (!checkMail(email)) {
//             $('#errorEmail').text('The email format is invalid.');
//         }
//
//         // validate phone
//         if (phone == '') {
//             $('#errorPhone').text('The phone field is required.');
//         } else if (!checkPhone(phone)) {
//             $('#errorPhone').text('The phone format is invalid.');
//         }
//
//         // validate message
//         if (message == '') {
//             $('#errorMessage').text('The message field is required.');
//         }
//
//     });
});

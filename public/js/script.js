$(document).ready(function () {
    $("#slideDestinations").owlCarousel({
        loop: false,
        margin: 30,
        responsiveClass: true,
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
        dotsContainer: '.owl-dots-container',
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
    })

    // Rate review{
    $('.rate-star').hover(function (e) {
        let currentRate = e.target.dataset.rate;
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
        ;
        let video = $('#videoTour').get(0);
        if (video.paused) {
            video.play();
            $('#iconPlayVideo').hide();
            $('#iconPauseVideo').show();
            $('.wrap-video').hide();
        }
    });

    //Date Range Picker
    $(function () {
        $('input[name="daterange"]').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
            },
            opens: 'left'
        }, function (start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });

    // Calculate Price
    let PRICE_DEFAULT = $('#price').val();
    $('#selectNumberPeople').on('change', function () {
        caculatePrice();
    });

    function caculatePrice() {
        let numberPeople = $('#selectNumberPeople').val();
        let price = (numberPeople * PRICE_DEFAULT).toFixed(2);
        if (isNaN(price)) {
            $('#totalPrice').text('$');

            return;
        }

        $('#totalPrice').text('$' + price);
    }

    caculatePrice();

    // Function validate
    function stringContainsNumber(_string) {
        return /\d/.test(_string);
    }

    function stringOnlyNumber(_string) {
        return /^\d+$/.test(_string);
    }

    function checkMail(_string) {
        return /^[a-z][a-z0-9_\.]{2,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}/.test(_string);
    }

    function removeAllWhiteSpace(_string) {
        return _string.replace(/\s+/g, '')
    }

    function checkPhone(_string) {
        _string = _string.replace(/\s+/g, '');
        // di động
        if (/^(0|\+84)[35789]([0-9]{8})$/.test(_string)) {
            return true;
        }

        return /^(0|\+84)2([0-9]{9})$/.test(_string)
    }

    function escapeHTML(str) {
        return str
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function getValue(_selector) {
        return escapeHTML(($.trim($(_selector).val())));
    }

    // Form checkout
    $("#btnSubmitCheckout").click(function (e) {
        e.preventDefault();
        let firstName = getValue('#firstName');
        let lastName = getValue('#lastName');
        let email = getValue('#email');
        let phone = getValue('#phone ');
        let address = getValue('#address');
        let city = getValue('#city');
        let province = getValue('#province');
        let zipCode = getValue('#zipCode ');
        let country = getValue('#country');
        let requirement = getValue('#requirement');
        let payment = $('input[name=paymentMethod]:checked', '#formCheckout').val()

        $('#errorFirstName').text('');
        $('#errorLastName').text('');
        $('#errorEmail').text('');
        $('#errorPhone').text('');
        $('#errorAddress').text('');
        $('#errorCity').text('');
        $('#errorProvince').text('');
        $('#errorZipCode').text('');
        $('#errorCountry').text('');
        $('#errorRequirement').text('');

        let flag = true;

        // validate first name
        if (firstName == '') {
            $('#errorFirstName').text('The first name field is required.');
            flag = false;
        } else if (stringContainsNumber(firstName)) {
            $('#errorFirstName').text('The first name format is invalid.');
            flag = false;
        }

        // validate last name
        if (lastName == '') {
            $('#errorLastName').text('The last name field is required.');
            flag = false;
        } else if (stringContainsNumber(lastName)) {
            $('#errorLastName').text('The last name format is invalid.');
            flag = false;
        }

        // validate email
        if (email == '') {
            $('#errorEmail').text('The email field is required.');
            flag = false;
        } else if (!checkMail(email)) {
            $('#errorEmail').text('The email format is invalid.');
            flag = false;
        }

        // validate phone
        if (phone == '') {
            $('#errorPhone').text('The phone field is required.');
            flag = false;
        } else if (!checkPhone(phone)) {
            $('#errorPhone').text('The phone format is invalid.');
            flag = false;
        }

        // validate zipcode
        if (zipCode != '') {
            if (!stringOnlyNumber(zipCode)) {
                $('#errorZipCode').text('The zipcode format is invalid.');
                flag = false;
            }
        }

        if (flag) {
            //$('#formCheckout').submit();
            $('#thanksModal').modal('show');
        } else {
            document.getElementById("formCheckout").scrollIntoView();
        }
    });

    // Form contact
    $("#formContact").submit(function (e) {
        e.preventDefault();
        let name = getValue('#name');
        let email = getValue('#email');
        let phone = getValue('#phone ');
        let message = getValue('#message');
        $('#errorName').text('');
        $('#errorEmail').text('');
        $('#errorPhone').text('');
        $('#errorMessage').text('');

        // validate name
        if (name == '') {
            $('#errorName').text('The name field is required.');
        } else if (stringContainsNumber(name)) {
            $('#errorName').text('The name format is invalid.');
        }

        // validate email
        if (email == '') {
            $('#errorEmail').text('The email field is required.');
        } else if (!checkMail(email)) {
            $('#errorEmail').text('The email format is invalid.');
        }

        // validate phone
        if (phone == '') {
            $('#errorPhone').text('The phone field is required.');
        } else if (!checkPhone(phone)) {
            $('#errorPhone').text('The phone format is invalid.');
        }

        // validate message
        if (message == '') {
            $('#errorMessage').text('The message field is required.');
        }

    });
});

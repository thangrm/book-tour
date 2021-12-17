$(document).ready(function() {
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

    $('.next-slide').click(function(event) {
        let slideID = event.target.getAttribute('data-target');
        $(slideID).trigger('next.owl.carousel');
    })

    // Change icon nav-header
    $('#navbarBtn').on('click', function() {
        $('#navbarBtn').toggleClass('navbar-active-btn');
    });

    // Chang icon Filter - List Tour Page
    $('#btnFilterTours').on('click', function() {
        $('.iconBtnFilter').toggleClass('d-none');
    });

    // Clear form filter
    $('#clearFormFilter').on('click', function() {
        $('#formSelectFilter')[0].reset();
    })

    // Choose thumbnail image
    $('.thumbnailItem').on('click', function(e) {
        $('.thumbnailItem').removeClass("target");
        e.target.classList.add("target");
        linkSrc = e.target.getAttribute('src');
        $('#mainImageTour').attr('src', linkSrc);
    })

    // Rate review{
    $('.rate-star').hover(function(e) {
        let currentRate = e.target.dataset.rate;
        $('#rateReview').children().each(function() {
            if (this.dataset.rate <= currentRate) {
                this.classList.remove('bi-star');
                this.classList.add('bi-star-fill');
            } else {
                this.classList.remove('bi-star-fill');
                this.classList.add('bi-star');
            }
        });
    }, function() {
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

    $('#imagePanoramic').on('click', function() {
        $('.wrap-panoramic').hide();
    });

    //Video
    $('#videoTour, .wrap-video').on('click', function() {;
        let video = $('#videoTour').get(0);
        if (video.paused) {
            video.play();
            $('#iconPlayVideo').hide();
            $('#iconPauseVideo').show();
            $('.wrap-video').hide();
        }
    });

    //Date Range Picker
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
            },
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });

    // Calculate Price
    var PRICE_DEFAULT = 146;
    $('#selectNumberPeople').on('change', function() {
        caculatePrice();
    });

    function caculatePrice() {
        let numberPeople = $('#selectNumberPeople').val();
        let price = (numberPeople * PRICE_DEFAULT).toFixed(2);
        $('#totalPrice').text('$' + price);
    }
    caculatePrice();

    // Function validate
    function stringContainsNumber(_string) {
        return /\d/.test(_string);
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

    // Form checkout
    $("#formCheckout").submit(function(e) {
        e.preventDefault();
    });

    // Form contact
    $("#formContact").submit(function(e) {
        e.preventDefault();
        let name = $.trim($('#name').val());
        let email = $.trim($('#email').val());
        let phone = $.trim($('#phone ').val());
        let message = $.trim($('#message').val());
        $('#errorName').text('');
        $('#errorEmail').text('');
        $('#errorPhone').text('');
        $('#errorMessage').text('');

        // validate name
        if (name == '') {
            $('#errorName').text('Tên không được để trống');
        } else if (stringContainsNumber(name)) {
            $('#errorName').text('Tên không được chứa số');
        }

        // validate email
        if (email == '') {
            $('#errorEmail').text('Email không được để trống');
        } else if (!checkMail(email)) {
            $('#errorEmail').text('Email không đúng định dạng');
        }

        // validate phone
        if (phone == '') {
            $('#errorPhone').text('Số  điện thoại không được để trống');
        } else if (!checkPhone(phone)) {
            $('#errorPhone').text('Số  điện thoại hợp lệ');
        }

        // validate message
        if (message == '') {
            $('#errorMessage').text('Lời nhắn không được để trống');
        }

    });
});
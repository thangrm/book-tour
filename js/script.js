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

    //Panorama
    pannellum.viewer('imagePanoramic', {
        "type": "equirectangular",
        "panorama": "./images/travel-360.jpg",
        "autoLoad": true,
    });

    //Video
    $('#videoTour, .wrap-video').on('click', function() {;
        let video = $('#videoTour').get(0);
        if (video.paused) {
            video.play();
            $('#iconPlayVideo').hide();
            $('#iconPauseVideo').show();
            $('.wrap-video').hide();
        } else {
            video.pause();
            $('#iconPlayVideo').show();
            $('#iconPauseVideo').hide();
        }
    });

    $('#imagePanoramic').on('click', function() {
        $('.wrap-panoramic').hide();
    });
});
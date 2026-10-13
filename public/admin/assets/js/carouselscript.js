$(".carousel").carousel({
    interval: 5000,

    pause: "false",
});

$(".navbar-toggler").click(function () {
    $(".navbar-toggler").toggleClass("showtoggle");
});

$(document).ready(function () {
    var owl = $(".meet_tutors_slid .owl-carousel");
    if (owl.length > 0) {
        owl.owlCarousel({
            margin: 0,

            nav: true,

            autoplay: true,

            loop: true,

            responsive: {
                0: {
                    items: 1,
                },

                991: {
                    items: 2,
                },

                1000: {
                    items: 3,
                },
            },
        });
    }
});

$(document).ready(function () {
    var owl1 = $(".how_did_inr_lid .owl-carousel");
    if (owl1.length > 0) {
        owl1.owlCarousel({
            margin: 0,

            nav: true,

            autoplay: true,

            center: true,

            loop: true,

            responsive: {
                0: {
                    items: 1,
                },

                991: {
                    items: 2,
                },

                1000: {
                    items: 3,
                },
            },
        });
    }
});

// ===== Scroll to Top ====

$(window).scroll(function () {
    if ($(this).scrollTop() >= 50) {
        // If page is scrolled more than 50px

        $("#return-to-top").fadeIn(200); // Fade in the arrow
    } else {
        $("#return-to-top").fadeOut(200); // Else fade out the arrow
    }
});

$("#return-to-top").click(function () {
    // When arrow is clicked

    $("body,html").animate(
        {
            scrollTop: 0, // Scroll to top of body
        },
        500
    );
});

$(window).scroll(function () {
    var scroll = $(window).scrollTop();

    if (scroll >= 300) {
        $(".foot_arw").addClass("fixed");
    } else {
        $(".foot_arw").removeClass("fixed");
    }
});

$(document).ready(function () {
    $(".dropdown-submenu").click(function () {
        $(".dropdown").addClass("show");
    });
});

$(document).ready(function () {
    var owl2 = $("#fav_id .owl-carousel");
    if (owl2.length > 0) {
        owl2.owlCarousel({
            margin: 0,

            nav: true,

            autoplay: true,

            loop: true,

            responsive: {
                0: {
                    items: 1,
                },
                575: {
                    items: 2,
                },

                991: {
                    items: 2,
                },
                1199: {
                    items: 3,
                },

                1200: {
                    items: 4,
                },
            },
        });
    }
});

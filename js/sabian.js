$(function () {

    var banner = $("#section_banner");

    var navbar = $("#sabian_nav");

    var mobile_navbar = $("#sabian_nav_collapse");

    var full_banner = $("#section_full_banner");

    var top_header = $(".navbar-top");

    var hide_top_header_on_scroll = top_header.hasClass("hide_on_scroll");

    /*Scroll*/
    var $window = $(window);

    $window.scroll(function (e) {

        if (navbar.hasClass("shop"))
            return;

        var top = $(window).scrollTop();

        if (top > 0 && navbar.length) {

            if (navbar.hasClass("nav_transparent")) {
                
                navbar.addClass("theme");

                if (hide_top_header_on_scroll) {
                    top_header.addClass("hide");
                } else {
                    top_header.removeClass("transparent");
                }

            } else {
                navbar.addClass("navbar-fixed-top");
                mobile_navbar.addClass("navbar-fixed-top");
            }
        } else {
            if (navbar.hasClass("nav_transparent")) {

                if (hide_top_header_on_scroll) {
                    top_header.removeClass("hide");
                } else {
                    top_header.addClass("transparent");
                }

                if (navbar.hasClass("theme"))
                    navbar.removeClass("theme");
            } else {

                if (navbar.hasClass("navbar-fixed-top"))
                    navbar.removeClass("navbar-fixed-top");

                if (mobile_navbar.hasClass("navbar-fixed-top"))
                    mobile_navbar.removeClass("navbar-fixed-top");
            }
        }
    });

    /*Slider*/
    if (banner != undefined && banner.length > 0) {

        var slideImgString = banner.data("slide-images");

        var slideImgs = slideImgString.split(",");

        banner.backstretch(
                slideImgs,
                {duration: 4000, fade: 1000}
        );

        banner.backstretch('pause'); //Pause backstretch to only respond to carousel events

        //Carousel
        var slideCarousel = $("#banner_carousel");

        slideCarousel.carousel({
            interval: 10000
        });

        //Navigate backstretch
        slideCarousel.on('slid.bs.carousel', function (e) {

            var slideIndex = $(e.relatedTarget).index();
            // Slide backstretch carousel
            banner.backstretch('show', slideIndex);
        });

        //Register controls
        $("#slider_next").click(function (e) {
            e.preventDefault();
            slideCarousel.carousel("next");
        });

        $("#slider_prev").click(function (e) {

            e.preventDefault();

            slideCarousel.carousel("prev");
        });

        //Disable carousel when not in viewport
        slideCarousel.waypoint(function (direction) {

            if (direction == "down") {
                slideCarousel.carousel('pause');
            } else {
                //slideCarousel.carousel('cycle');
            }
        }, {
            offset: function () {
                return -(slideCarousel.outerHeight());
            }
        });

    }

    /*Full banner*/
    if (full_banner !== undefined && full_banner.length > 0) {

        /*Section Banner Stretch*/
        full_banner_stretch();

        $(window).resize(function (e) {

            full_banner_stretch();

        });

        function full_banner_stretch() {

            var winHeight = $(window).innerHeight();

            full_banner.css("height", winHeight);
        }

        /*Slider*/
        var $vegas_banner = full_banner;

        if ($vegas_banner.length > 0) {

            var v_banner_str = $vegas_banner.attr("data-images");

            if (v_banner_str != undefined) {

                var v_banner_imgs = v_banner_str.split(',');

                var v_data = [];

                for (var i = 0; i < v_banner_imgs.length; i++) {

                    v_data[i] = {src: v_banner_imgs[i]};
                }

                $vegas_banner.vegas({

                    overlay: false,

                    delay: 10000,

                    slides: v_data,

                    walk: function (index, settings) {
                    }

                });

                $("#vegas_next").click(function (e) {

                    $vegas_banner.vegas("next");

                });

                $("#vegas_prev").click(function (e) {
                    $vegas_banner.vegas("previous");
                });
            }
        }
    }


    /*Animations*/
    $("[data-animate]").each(function (index, element) {

    });



    /*Portfolio*/
    var portfolio = $("#the_portfolio");

    if (portfolio.length > 0) {

        portfolio.mixItUp({

            animation: {
                effects: 'fade rotateZ(-180deg)',
                duration: 700
            },

            classNames: {
                elementFilter: 'filter-btn'
            },

            selectors: {
                target: '.mix'
            }

        });
    }

    $("#portfolio_controls li").click(function (e) {

        e.preventDefault();

        var _this = $(this);

        var filter = _this.attr("data-filter");

        $("#portfolio_controls li.active").removeClass("active");

        _this.addClass("active");

    });


    /*Carousel*/
    $(".owl-single").each(function (index, element) {

        var owl_single = $(this);

        if (owl_single.length > 0) {

            owl_single.owlCarousel({
                items: 1,
                lazyLoad: true,
                pagination: false,
                autoPlay: 10000,
                stopOnHover: true,
                rewind: false,
                dots: false
            });
        }

    });


    $(".owl-items").each(function (index, element) {

        var owl_items = $(this);

        if (owl_items.length > 0) {

            var items = owl_items.attr("data-items");

            var displayDots = owl_items.attr("data-dots") != undefined;

            displayDots = (displayDots) ? owl_items.attr("data-dots") != "false" : false;

            owl_items.owlCarousel({
                lazyLoad: true,
                pagination: displayDots, /*Version 3+*/
                dots: displayDots, /*Version 2*/
                nav: false,
                autoPlay: 10000,
                stopOnHover: true,
                margin: 10,
                rewind: false,
                responsiveClass: true,

                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    768: {
                        items: items
                    }
                }
            });
        }

    });


    $(".owl_carousel_nav").each(function (index, element) {

        var owlTarget = $($(this).attr("data-target"));

        var slideTo = $(this).attr("data-slide-to");

        var _ocn_this = $(this);

        if (owlTarget.length > 0) {

            owlTarget.on('changed.owl.carousel', function (oe) {

                var index = oe.item.index;

                if (slideTo == index) {

                    $(".owl_carousel_nav.active").removeClass("active");

                    _ocn_this.addClass("active");
                }

            });
        }
        _ocn_this.click(function (e) {

            if (owlTarget.length > 0) {

                if (slideTo == "next") {

                    owlTarget.trigger('next.owl.carousel');

                    return;
                }

                if (slideTo == "prev") {

                    owlTarget.trigger('prev.owl.carousel');

                    return;
                }

                owlTarget.trigger('to.owl.carousel', slideTo);
            }

        });
    });


    /*Dropdown*/
    $("li.mega-menu a").on("click", function (ev) {

        if (!$(this).parent().hasClass("open")) {
            $("li.mega-menu.open").removeClass("open");
        }

        $(this).parent().toggleClass("open");

    });

    $('body').on('click', function (e) {

        if (!$("li.mega-menu").is(e.target) && $("li.mega-menu").has(e.target).length === 0 && $('.open').has(e.target).length === 0) {

            $("li.mega-menu").removeClass("open");
        }

    });

});
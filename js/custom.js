(function($) {

    

    // Index Page
    var home = {

        init: function() {

            home.slider();
        },

        slider: function() {

            $(".index-slider").owlCarousel({

                loop: true,
                margin: 0,
                nav: false,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsive:{
                    0:{
                        items: 1
                    },
                    600:{
                        items: 1
                    },
                    1000:{
                        items: 1
                    }
                }
            })
        },
    };

    if($(".index-page").length > 0) {

        home.init();
    }

    // Common Function
    var common = {

        scrollToTop: function() {

            $(".btn-scroll-to-top").click(function() {

                $("html, body").animate({ scrollTop: 0 }, "slow");
                return false;
            });
        },
    }

    if($(".btn-scroll-to-top").length > 0) {

        common.scrollToTop();
    }

})(jQuery);
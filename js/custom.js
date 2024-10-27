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

    // Member 
    var member = {

        init: function() {

            member.registerForm();
        },

        registerForm: function() {

            const forms = document.querySelectorAll('.needs-validation');

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                form.classList.add('was-validated')
                    }, false)
                }
            )
        },
    }

    if($(".register-page").length > 0 || $(".login-page").length > 0) {

        member.init();
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
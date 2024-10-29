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

        _registerForm: $("#register-form"),

        _loginForm: $("#login-form"),

        init: function() {

            member.validation();
        },

        validation: function() {

            var process = false;

            const forms = document.querySelectorAll('.needs-validation');

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) 
                    {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    else
                    {
                        // register form handler
                        if(member._registerForm.length > 0) {
                            member.register();
                        }

                        // login form handler
                        if(member._loginForm.length > 0) {
                            member.login();
                        }
                    }

                form.classList.add('was-validated')
                    }, false)
                }
            )
        },

        register: function() {

            const formMsg = document.getElementById('form-msg');
            var formAlert = new bootstrap.Toast(formMsg);

            var data = {
                first_name : member._registerForm.find("#first_name").val(),
                last_name : member._registerForm.find("#last_name").val(),
                mailing_address : member._registerForm.find("#mailing_address").val(),
                phone_number : member._registerForm.find("#phone_number").val(),
                email_address : member._registerForm.find("#email_address").val(),
                password : member._registerForm.find("#password").val(),
            };

            // use ajax http request
            $.ajax({

                url: member._registerForm.attr("action"),
                type: "POST",
                data: data,
                dataType: 'json',
                beforeSend: function(responses) {

                    common.spinnerLoader(true, member._registerForm);
                },
                success: function(responses) {

                    member._registerForm.find("#form-msg").find(".toast-body").text(responses.message);
                    formAlert.show();
                },
                error: function() {

                    // error handling
                    member._registerForm.find("#form-msg").find(".toast-body").text("Register Fail: Something wrong.");
                    formAlert.show();
                },
                complete: function() {

                    common.spinnerLoader(false, member._registerForm);
                }
            });
        },

        login: function() {
            
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

        spinnerLoader: function(showLoader, element) {

            if(showLoader) {

                element.find(".spinner-border").show();
                element.find(".btn").hide();
            }
            else {

                element.find(".spinner-border").hide();
                element.find(".btn").show();
            }
        },
    }

    if($(".btn-scroll-to-top").length > 0) {

        common.scrollToTop();
    }

})(jQuery);
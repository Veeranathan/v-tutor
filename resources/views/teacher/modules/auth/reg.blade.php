@if (@Auth::user()->id)

    <script>
        window.location = "{{ url('/') }}/tutor/home";
    </script>
@else
    @extends('layouts.app')



    @section('title')
        <title>V-Tutor | Tutor | Sign up</title>
    @endsection

    @section('left_part')
        @include('include.header_menu_part')
        {{-- @include('include.tutor_left_part') --}}
    @endsection

    <style>
        .login-details {
            width: 50% !important;
            margin: 6% 6% !important;
        }

        .login-from {
            margin: 0px !important
        }

        .login-info:after,
        .login-info:before {
            display: none;
        }

        .upper-login {
            padding-bottom: 20px;
            border-bottom: solid #ebebeb 1px;
        }

        .bottom-content {
            border-top: solid #ebebeb 1px;
            padding: 20px 0px;
            margin-top: 20px;
        }

        .submit-login {
            background-color: #D7263D !important;
            color: white !important
        }

        .footer-sec-subdiv {
            padding-top: 50px;
        }

        @media only screen and (max-width: 1600px) {}

        @media only screen and (max-width: 1281px) {

            .login-details {
                width: 60% !important;
                margin: 6% 6% !important;
            }

            .bottom-account-div {
                margin: 0px !important;
            }
        }

        @media only screen and (max-width: 768px) {
            .login-from {
                padding-top: 20px;
            }

            .upper-login {

                h2 {
                    padding-bottom: 10px;
                }
            }

            .login-details {
                width: 100% !important;
                margin: 0% !important;
            }

            .bottom-content {
                padding: 10px 0px;
                margin-top: 20px;
            }

            .bottom-account-div {
                margin: 10px 0 20px 0 !important;
            }
        }
    </style>


    @section('content')

    <section class="login-body tutor-body">
        <div class="login-info">
            <div class="login-details">
                    <div class="upper-login">

                        {{-- <h2>Tutor Sign Up:</h2> --}}
                        <h2>Join our team</h2>
                        <p>Be part of our team of highly skilled tutors and discover the opportunities of freelance
                            tutoring.</p>
                    </div>
                    @include('include.errors')
                    <div class="login-from">
                        <form method="POST" action="{{ route('teacher.custom.register') }}" id="frm">
                            @csrf
                            <div class="double-from">
                                <div class="form_area">
                                    <input type="text" class="texxt_box" placeholder="First Name" name="f_name"
                                        onfocus="this.removeAttribute('readonly');" readonly=""
                                        onclick="this.removeAttribute('readonly');"
                                        onblur="this.removeAttribute('readonly');">
                                </div>
                                <div class="form_area">
                                    <input type="text" class="texxt_box" placeholder="Last Name" name="l_name"
                                        onfocus="this.removeAttribute('readonly');" readonly=""
                                        onclick="this.removeAttribute('readonly');"
                                        onblur="this.removeAttribute('readonly');">
                                </div>
                            </div>
                            <div class="form_area" autocomplete="off">
                                <input type="email" class="texxt_box" placeholder="Email address" name="email"
                                    id="email" autocomplete="off" onfocus="this.removeAttribute('readonly');"
                                    readonly="" onclick="this.removeAttribute('readonly');"
                                    onblur="this.removeAttribute('readonly');">
                            </div>
                            <div class="double-from">
                                <div class="form_area">
                                    <div class="password-in">
                                        <input id="password-field" type="password" class="texxt_box" name="password"
                                            placeholder="Password" readonly=""
                                            onfocus="this.removeAttribute('readonly');"
                                            onclick="this.removeAttribute('readonly');"
                                            onblur="this.removeAttribute('readonly');">
                                        <div class="clearfix"></div>
                                        <span toggle="#password-field"
                                            class="field-icon fa fa-fw fa-eye toggle-password"></span>
                                    </div>
                                    <label id="password-field-error" class="error" for="password-field"></label>
                                </div>
                                <div class="form_area">
                                    <div class="password-in">
                                        <input id="password-field2" type="password" class="texxt_box" name="con_password"
                                            placeholder="Confirm Password" onfocus="this.removeAttribute('readonly');"
                                            readonly="" onclick="this.removeAttribute('readonly');"
                                            onblur="this.removeAttribute('readonly');">
                                        <div class="clearfix"></div>
                                        <span toggle="#password-field2"
                                            class="field-icon fa fa-fw fa-eye toggle-password"></span>
                                    </div>
                                    <label id="password-field2-error" class="error" for="password-field2"></label>
                                </div>
                            </div>

                            <input type="hidden" name="checkbox1" value="all">

                            <div class="check-box">
                                <input type="checkbox" id="checkbox2" name="checkbox2" value="all">
                                <label for="checkbox2" class="checklabeel">Sign me up for regular updates and periodical
                                    promotional material from V-Tutor</label>
                            </div>

                            <input type="hidden" name="recaptcha_token" id="recaptcha_token">


                            <input type="submit" name="" value="Sign me up" class="submit-login">
                        </form>
                                {{-- <div class="or-area">
                                <span>or continue with</span>
                            </div> --}}

                                {{-- <div class="socials-btns">
                                <a href="{{route('login.social',['user_type'=>'teacher','provider_type'=>'google'])}}" class="common-btns  google-btn ">
                                <img src="{{ public_asset('assets/images/login-google.png')}}" alt=""> Google
                                </a>

                            </div> --}}

                                {{-- <a href="{{route('login.social',['user_type'=>'teacher','provider_type'=>'facebook'])}}" class="common-btns facebook-btn ">
                                <img src="{{ public_asset('assets/images/login-facebook.png')}}" alt=""> Facebook
                            </a> --}}

                                {{--   <div class="fort-pass">
                                <a href="#">Forgot password?</a>
                            </div> --}}
                        <div class="bottom-content">
                            <div class="bottom-account-div pb-2 pb-sm-4">
                                <p>Already have an account? <a href="{{ route('login') }}">Log in</a></p>
                            </div>

                            <div class="bottom-account-div gj_recapcha_tcdiv">
                                <p>Secure login with reCAPTCHA subject to GOOGLE <a
                                        href="https://policies.google.com/terms?hl=en" target="_blank">Terms</a> & <a
                                        href="https://policies.google.com/privacy?hl=en" target="_blank">Privacy</a></p>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

    </section>
    @endsection
    @section('footer')
        @include('include.footer')
    @endsection

    {{-- @section('footer')
    @include('include.tutor_footer')
@endsection --}}


    @section('script')
        @include('include.script')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
            integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
            crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                jQuery.validator.addMethod("emailonly", function(value, element) {
                    return this.optional(element) || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(
                        value.toLowerCase());
                }, "Enter a valid email address");

                $('#frm').validate({

                    rules: {
                        f_name: {
                            required: true,
                            minlength: 3,
                        },
                        l_name: {
                            required: true,
                            minlength: 3,
                        },
                        email: {
                            required: true,
                            emailonly: true,
                            remote: {
                                url: '{{ route('check.email') }}',
                                type: "get",
                                data: {
                                    email: function() {
                                        return $("#email").val();
                                    }
                                }
                            }
                        },
                        password: {
                            required: true,
                            minlength: 8
                        },
                        con_password: {
                            required: true,
                            minlength: 8,
                            equalTo: '[name="password"]'
                        },

                    },
                    messages: {
                        email: {
                            remote: "Email address is in use. Login or use a different one",
                        },
                        con_password: {
                            equalTo: "Passwords do not match"
                        },
                    },
                    submitHandler: function(form) {
                        var password = $("#password-field").val();
                        var conf_password = $("#password-field2").val();
                        if (password == conf_password && password != "" && conf_password != "") {
                            if (password != "") {
                                var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                                if (pattern.test(password)) {
                                    $('#password-field-error').html('');
                                    form.submit();
                                } else {
                                    $('#password-field2-error').html(
                                        'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                    );
                                    $('#password-field2-error').css('display', 'block');
                                    $("#password-field2").val('');
                                    $('#password-field-error').html(
                                        'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                    );
                                    $('#password-field-error').css('display', 'block');
                                    $("#password-field").val('');
                                    return false;
                                }
                            } else if (conf_password != "") {
                                var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                                if (pattern.test(conf_password)) {
                                    $('#password-field2-error').html('');
                                    form.submit();
                                } else {
                                    $('#password-field2-error').html(
                                        'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                    );
                                    $('#password-field2-error').css('display', 'block');
                                    $("#password-field2").val('');
                                    $('#password-field-error').html(
                                        'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                    );
                                    $('#password-field-error').css('display', 'block');
                                    $("#password-field").val('');
                                    return false;
                                }
                            } else {
                                form.submit();
                            }
                        } else if (password != conf_password && password != "" && conf_password != "") {
                            $('#password-field-error').html('Passwords do not match');
                            $('#password-field-error').css('display', 'block');
                            $("#password-field2").val('');
                            return false;
                        } else if (password == "") {

                            $('#password-field-error').html('This field is required');
                            $('#password-field-error').css('display', 'block');
                            $("#password-field").val('');
                            return false;

                        } else if (conf_password == "") {

                            $('#password-field2-error').html('This field is required');
                            $('#password-field2-error').css('display', 'block');
                            $("#password-field2").val('');
                            return false;

                        }


                    }
                });
                $(document).on("blur", "#password-field", function() {
                    var password = $("#password-field").val();
                    var conf_password = $("#password-field2").val();
                    if (password != "") {
                        var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                        if (pattern.test(password)) {
                            $('#password-field-error').html('');

                        } else {
                            $('#password-field2-error').html(
                                'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                            );
                            $('#password-field2-error').css('display', 'block');
                            $("#password-field2").val('');
                            $('#password-field-error').html(
                                'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                            );
                            $('#password-field-error').css('display', 'block');
                            $("#password-field").val('');

                        }
                    }
                    if (conf_password != "") {
                        var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                        if (pattern.test(conf_password)) {
                            $('#password-field2-error').html('');

                        } else {
                            $('#password-field2-error').html(
                                'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                            );
                            $('#password-field2-error').css('display', 'block');
                            $("#password-field2").val('');
                            $('#password-field-error').html(
                                'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                            );
                            $('#password-field-error').css('display', 'block');
                            $("#password-field").val('');

                        }
                    }
                    if (password == conf_password && password != "" && conf_password != "") {
                        if (password != "") {
                            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                            if (pattern.test(password)) {
                                $('#password-field-error').html('');

                            } else {
                                $('#password-field2-error').html(
                                    'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                );
                                $('#password-field2-error').css('display', 'block');
                                $("#password-field2").val('');
                                $('#password-field-error').html(
                                    'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                );
                                $('#password-field-error').css('display', 'block');
                                $("#password-field").val('');
                                return false;
                            }
                        } else if (conf_password != "") {
                            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                            if (pattern.test(conf_password)) {
                                $('#password-field2-error').html('');

                            } else {
                                $('#password-field2-error').html(
                                    'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                );
                                $('#password-field2-error').css('display', 'block');
                                $("#password-field2").val('');
                                $('#password-field-error').html(
                                    'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                );
                                $('#password-field-error').css('display', 'block');
                                $("#password-field").val('');
                                return false;
                            }
                        }
                    } else if (password != conf_password && password != "" && conf_password != "") {
                        $('#password-field-error').html('Passwords do not match');
                        $('#password-field-error').css('display', 'block');
                        $("#password-field2").val('');
                        return false;
                    } else if (password == "") {

                        $('#password-field-error').html('This field is required');
                        $('#password-field-error').css('display', 'block');
                        $("#password-field").val('');
                        return false;

                    } else if (conf_password == "") {

                        $('#password-field2-error').html('This field is required');
                        $('#password-field2-error').css('display', 'block');
                        $("#password-field2").val('');
                        return false;

                    } else if (password != "") {
                        // $('#password-field2-error').html('This field is required');
                        // $('#password-field2-error').css('display','block');
                        // $("#password-field2").val('');
                        // return false;
                        if (password != "") {
                            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                            if (pattern.test(password)) {
                                $('#password-field-error').html('');

                            } else {
                                $('#password-field2-error').html(
                                    'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                );
                                $('#password-field2-error').css('display', 'block');
                                $("#password-field2").val('');
                                $('#password-field-error').html(
                                    'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                );
                                $('#password-field-error').css('display', 'block');
                                $("#password-field").val('');
                                return false;
                            }
                        }
                    } else if (conf_password != "") {
                        if (conf_password != "") {
                            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                            if (pattern.test(conf_password)) {
                                $('#password-field2-error').html('');

                            } else {
                                $('#password-field2-error').html(
                                    'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                );
                                $('#password-field2-error').css('display', 'block');
                                $("#password-field2").val('');
                                $('#password-field-error').html(
                                    'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                );
                                $('#password-field-error').css('display', 'block');
                                $("#password-field").val('');
                                return false;
                            }
                        }

                    }
                });
                $(document).on("blur", "#password-field2", function() {
                    var password = $("#password-field").val();
                    var conf_password = $("#password-field2").val();
                    if (password != "") {
                        var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                        if (pattern.test(password)) {
                            $('#password-field-error').html('');

                        } else {
                            $('#password-field2-error').html(
                                'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                            );
                            $('#password-field2-error').css('display', 'block');
                            $("#password-field2").val('');
                            $('#password-field-error').html(
                                'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                            );
                            $('#password-field-error').css('display', 'block');
                            $("#password-field").val('');

                        }
                    }
                    if (conf_password != "") {
                        var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                        if (pattern.test(conf_password)) {
                            $('#password-field2-error').html('');

                        } else {
                            $('#password-field2-error').html(
                                'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                            );
                            $('#password-field2-error').css('display', 'block');
                            $("#password-field2").val('');
                            $('#password-field-error').html(
                                'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                            );
                            $('#password-field-error').css('display', 'block');
                            $("#password-field").val('');

                        }
                    }
                    if (password == conf_password && password != "" && conf_password != "") {
                        if (password != "") {
                            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                            if (pattern.test(password)) {
                                $('#password-field-error').html('');
                                form.submit();
                            } else {
                                $('#password-field2-error').html(
                                    'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                );
                                $('#password-field2-error').css('display', 'block');
                                $("#password-field2").val('');
                                $('#password-field-error').html(
                                    'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                );
                                $('#password-field-error').css('display', 'block');
                                $("#password-field").val('');
                                return false;
                            }
                        } else if (conf_password != "") {
                            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                            if (pattern.test(conf_password)) {
                                $('#password-field2-error').html('');
                                form.submit();
                            } else {
                                $('#password-field2-error').html(
                                    'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                );
                                $('#password-field2-error').css('display', 'block');
                                $("#password-field2").val('');
                                $('#password-field-error').html(
                                    'Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !'
                                );
                                $('#password-field-error').css('display', 'block');
                                $("#password-field").val('');
                                return false;
                            }
                        } else {
                            form.submit();
                        }
                    } else if (password != conf_password && password != "" && conf_password != "") {
                        $('#password-field-error').html('Passwords do not match');
                        $('#password-field-error').css('display', 'block');
                        $("#password-field2").val('');
                        return false;
                    } else if (password == "") {

                        $('#password-field-error').html('This field is required');
                        $('#password-field-error').css('display', 'block');
                        $("#password-field").val('');
                        return false;

                    } else if (conf_password == "") {

                        $('#password-field2-error').html('This field is required');
                        $('#password-field2-error').css('display', 'block');
                        $("#password-field2").val('');
                        return false;

                    }
                });
            });
        </script>
        <script>
            $('#checkbox1').change(function() {
                if ($(this).prop('checked') == true) {
                    $('.disable-input').prop("disabled", false);
                    $('.submit-login').removeClass('disable-input');
                    $('.submit-social').removeClass('disable-input');
                } else {
                    // $('.disable-input').Attr('disabled');
                    // $('.submit-login').addClass('disable-input');
                    $('.submit-login').addClass('disable-input');
                    $('.disable-input').prop("disabled", true);
                    $('.submit-social').addClass('disable-input');
                }
            });
        </script>

        <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', {
                    action: 'submit'
                }).then(function(token) {
                    document.getElementById('recaptcha_token').value = token;
                });
            });
        </script>
    @endsection

@endif

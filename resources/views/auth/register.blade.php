@extends('layouts.app')



@section('title')
    <title>V-Tutor | User | Sign up</title>
@endsection

@section('left_part')
    {{-- @include('include.left_part') --}}
    @include('include.header_menu_part')
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

    {{-- <div class="top_mar"></div><section class="about-banner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Forgot Password</li>
                        </ol>
                    </nav>
                    <div class="inner-banner-title">
                        <h1 class="title">
                           Register
                        </h1>

                    </div>
                </div>
            </div>
        </div>
    </section> --}}

   <section class="login-body studant-body">
        <div class="login-info">
            <div class="login-details">
                <div class="upper-login">
                        @include('include.errors')
                        <h3>Sign Up</h3>
                        {{-- <h3>Student Sign Up</h3> --}}
                        <p>Please fill in the below fields to continue</p>
                </div>


                        <div class="login-from mx-3">
                            <form method="post" action="{{ route('user.reg') }}" id="frm">
                                @csrf
                                <!-- <input type="hidden" name="assessment_id" value="{{ request('assessment_id') }}"> -->
                                <div class="im-sec">
                                    <h5 class="mb-2 mx-2">I'm a </h5>
                                    <ul>
                                        <li>
                                            <input type="radio" id="radio1" name="radios" value="P" checked="">
                                            <label for="radio1" class="pb-2">Parent </label>
                                        </li>
                                        <li>
                                            <input type="radio" id="radio2" name="radios" value="G">
                                            <label for="radio2" class="pb-2">Guardian</label>
                                        </li>
                                        {{--  <li>
                                        <input type="radio" id="radio3" name="radios" value="S" checked="">
                                        <label for="radio3">Student</label>
                                    </li> --}}
                                    </ul>
                                </div>
                                <div class="double-from">
                                    <div class="form_area">
                                        <input type="text" class="texxt_box" placeholder="First Name" name="f_name"
                                            onfocus="this.removeAttribute('readonly');" readonly=""
                                            onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                    </div>
                                    <div class="form_area">
                                        <input type="text" class="texxt_box" placeholder="Last Name" name="l_name"
                                            onfocus="this.removeAttribute('readonly');" readonly=""
                                            onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                    </div>
                                </div>

                                <div class="double-from">
                                    @php
                                        $ago_18_yrs = date('Y-m-d', strtotime('-18 years'));
                                    @endphp
                                    <div class="form_area">
                                        <input type="date" required class="texxt_box" placeholder="DOB" name="parent_dob"
                                            onfocus="this.removeAttribute('readonly');" readonly=""
                                            onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" max="{{ date('Y-m-d', strtotime($ago_18_yrs)) }}"
                                            id="parent_dob">
                                    </div>

                                    <div class="form_area">
                                        @php
                                            $states = \App\Models\State::orderBy('id', 'asc')->get();
                                        @endphp

                                        <select name="parent_state" class="texxt_box" id="parent_state">
                                            <option value="">Select State</option>
                                            @foreach ($states as $st)
                                                <option value="{{ $st->id }}" data-timezone="{{ $st->time_zone }}"
                                                    @if (@$user->state == $st->id) selected @endif>{{ @$st->state_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <input type="hidden" value="" name="timezone_id" id="timezone_id">
                                    </div>
                                </div>

                                <div class="form_area">
                                    <input type="email" class="texxt_box" placeholder="Email address" name="email"
                                        id="email" onfocus="this.removeAttribute('readonly');" readonly=""
                                        onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                </div>
                                <div class="form_area">
                                    <input type="tel" class="texxt_box" placeholder="Mobile Number " name="ph"
                                        id="ph" onfocus="this.removeAttribute('readonly');" readonly=""
                                        onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                </div>
                                <div class="double-from">
                                    <div class="form_area">
                                        <div class="password-in">
                                            <input id="password-field" type="password" class="texxt_box" name="password"
                                                placeholder="Password" autocomplete="off"
                                                onfocus="this.removeAttribute('readonly');" readonly=""
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

                                {{-- Student details Start --}}
                                <h3 class="mt-2 mb-4">Student Details</h3>
                                <div class="double-from">
                                    <div class="form_area">
                                        <input type="text" required class="texxt_box" placeholder="Student First Name"
                                            name="student_f_name" onfocus="this.removeAttribute('readonly');" readonly=""
                                            onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');"
                                            id="student_f_name">
                                    </div>

                                    <div class="form_area">
                                        <input type="text" required class="texxt_box" placeholder="Student Last Name"
                                            name="student_l_name" onfocus="this.removeAttribute('readonly');" readonly=""
                                            onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');"
                                            id="student_l_name">
                                    </div>
                                </div>

                                <div class="double-from">
                                    <div class="form_area">
                                        <input type="date" required class="texxt_box" placeholder="DOB" name="student_dob"
                                            onfocus="this.removeAttribute('readonly');" readonly=""
                                            onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" max="{{ date('Y-m-d') }}"
                                            id="student_dob">
                                    </div>

                                    <div class="form_area">
                                        @php
                                            $grade = DB::table('grades')->where('status', 'A')->get();
                                        @endphp

                                        <select name="student_grade" class="texxt_box" id="student_grade">
                                            <option value="">Select Grade</option>
                                            @foreach ($grade as $val)
                                                <option value="{{ $val->id }}"
                                                    @if (@$user->grade == $val->id) selected @endif>{{ @$val->grade_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="check-box">
                                    <input type="checkbox" id="checkbox1" name="checkbox1" value="all">
                                    <label for="checkbox1" class="checklabeel">I have read and agree to V-Tutor <a
                                            href="{{ url('privacy-policy') }}" target="_blank"> Privacy Policy </a> and <a
                                            href="{{ url('terms-conditions') }}" target="_blank"> Terms & Conditions </a></label>
                                </div>
                                <div class="check-box">
                                    <input type="checkbox" id="checkbox2" name="checkbox2" value="all">
                                    <label for="checkbox2" class="checklabeel">I confirm that I’m over 18 years of age. I’m a
                                        parent / guardian for the student and consent to operate this account legally on behalf of
                                        my ward</label>
                                </div>

                                <input type="hidden" value="2" name="operate_accept_val" id="operate_accept_val">
                                <input type="hidden" value="2" name="collect_data_accept_val"
                                    id="collect_data_accept_val">
                                <input type="hidden" value="2" name="rules_accept_val" id="rules_accept_val">
                                <input type="hidden" value="" name="signature_full_name_val"
                                    id="signature_full_name_val">
                                <input type="hidden" value="" name="signature_date_val" id="signature_date_val">

                                <input type="submit" name="" value="Sign me up" class="submit-login disable-input"
                                    disabled="">
                            </form>
                            {{-- <div class="or-area">
                                <span>or continue with</span>
                            </div>
                            <div class="socials-btns">
                                <a href="{{route('login.social',['user_type'=>'student','provider_type'=>'google'])}}" class="common-btns  google-btn ">
                                <img src="{{ public_asset('assets/images/login-google.png')}}" alt=""> Google
                                </a>
                            </div> --}}
                            <div class="bottom-account-div">
                                <p>Already have an account? <a href="{{ route('login') }}">Log in</a></p>
                            </div>
                        </div>
            </div>

        </div>
    </section>

    <div class="modal " id="parentConsentModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title bb_disabled_booking_u" id="parentConsentModalLabel">Parental Consent & Authority to Operate Form</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body parentConsentModalbody">
                    <div class="">
                        <div class=" ">
                            <div class="meass-popup parentConsentModalDiv">
                                <h3>Authority & Consent</h3>

                                <div class="check-box">
                                    <input type="checkbox" id="operate_accept" name="operate_accept" value="all">
                                    <label for="operate_accept" class="checklabeel mb-0">I am the parent/legal guardian
                                        and
                                        authorise myself to operate and manage the student’s V‑Tutor account (including
                                        bookings, payments, and communications) until revoked in writing.</label>
                                </div>

                                <span class="error operate_accept_error"></span>

                                <div class="check-box">
                                    <input type="checkbox" id="collect_data_accept" name="collect_data_accept"
                                        value="all">
                                    <label for="collect_data_accept" class="checklabeel mb-0">I consent to V‑Tutor
                                        collecting
                                        and handling personal information under the Privacy Act 1988 (Cth) and the V‑Tutor
                                        Privacy Policy, and understand I can request access/correction.</label>
                                </div>

                                <span class="error collect_data_accept_error"></span>

                                <div class="check-box">
                                    <input type="checkbox" id="rules_accept" name="rules_accept" value="all">
                                    <label for="rules_accept" class="checklabeel mb-0">I have read and agree to the <a href="{{ url('terms-conditions') }}" target="_blank" class="color_link">Terms & Conditions</a>, and <a href="{{ url('terms-service') }}" target="_blank">Terms of Service</a> for using the V-Tutor platform</label>
                                    {{-- <label for="rules_accept" class="checklabeel mb-0">I have read and agree to the Terms & Conditions, including session etiquette and platform rules.</label> --}}
                                </div>

                                <span class="error rules_accept_error"></span>

                                <h3 class="mt-3">Signature</h3>
                                <p>Type your full legal name as a digital signature.</p>
                                <div class="mb-1">
                                    <div class="parentConsentModal_fn_div">
                                        {{-- <label>Full name *</label>
                                    <input type="text" name="signature_full_name" id="signature_full_name"> --}}
                                        <div class="form_box_area d-flex  flex-row align-items-start gap-2 mb-0">
                                            <label class="col-3 col-form-label px-0">Full name *</label>
                                            <input type="text" class="form-control"
                                                name="signature_full_name" id="signature_full_name">
                                        </div>
                                    </div>

                                    <span class="error signature_full_name_error"></span>
                                </div>

                                <div class="parentConsentModal_fn_div">
                                    <div class="form_box_area d-flex flex-row align-items-start gap-2 mb-0">
                                        <label class="col-3 col-form-label px-0">Date *</label>
                                        <input type="text" readonly value="{{ date('d M Y h:i A') }}"
                                            name="signature_date_hdn" id="signature_date_hdn">
                                        <input type="hidden" readonly value="{{ date('y-m-d H:i') }}"
                                            name="signature_date" id="signature_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer parentConsentModalFooter">
                    <a href="{{ route('landing.page') }}" class="decline_redirect"><button type="button" class="pg_btn"
                            id="cancelButton">I Decline</button></a>

                    <button type="button" class="pg_btn" id="confirmProceed">I Consent </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('include.footer')
@endsection

@section('script')
    @include('include.script')

    <script>
        document.getElementById('parent_state').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById('timezone_id').value = selectedOption.getAttribute('data-timezone');
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            jQuery.validator.addMethod("emailonly", function(value, element) {
                return this.optional(element) || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(
                    value.toLowerCase());
            }, "Enter a valid email address");

            jQuery.validator.addMethod("mobileonly", function(value, element) {
                return this.optional(element) || /^[+]?\d+$/.test(value.toLowerCase());
            }, "Enter a valid 10 digit mobile number");

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
                    student_f_name: {
                        required: true,
                        minlength: 3,
                    },
                    student_l_name: {
                        required: true,
                        minlength: 3,
                    },
                    parent_state: {
                        required: true,
                    },
                    student_grade: {
                        required: true,
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
                    ph: {
                        required: true,
                        mobileonly: true,
                        minlength: 10,
                        maxlength: 10,
                        remote: {
                            url: '{{ route('check.mobile') }}',
                            type: "get",
                            data: {
                                ph: function() {
                                    return $("#ph").val();
                                }
                            }
                        }
                    },
                },
                messages: {
                    ph: {
                        required: 'Please enter a valid 10 digit mobile number',
                        minlength: 'Mobile number can have minimum 10 digits',
                        maxlength: 'Mobile number can have maximum 10 digits',
                        mobileonly: 'Enter a valid 10 digit mobile number',
                        remote: "This mobile number already exists.!",
                    },
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
                // var password = $("#password-field").val();
                // var conf_password = $("#password-field2").val();
                // if(password == conf_password){
                //     if(password != ""){
                //         var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                //         if(pattern.test(password)){
                //             $('#password-field-error').html('');

                //         }else{
                //             $('#password-field-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                //             $('#password-field-error').css('display','block');
                //             $("#password-field").val('');

                //         }
                //     }
                //     if(conf_password != ""){
                //         var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/;
                //         if(pattern.test(conf_password)){
                //             $('#password-field2-error').html('');

                //         }else{
                //             $('#password-field2-error').html('Password must be at least 8 characters long and include at least 1 uppercase letter, 1 number, and 1 special character from the following: @, #, $, %, &, ? or !');
                //             $('#password-field2-error').css('display','block');
                //             $("#password-field2").val('');

                //         }
                //     }else{

                //     }
                // }else{

                // }

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
            if ($(this).prop('checked') == true && $('#checkbox2').prop('checked') == true) {
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

        var modal = new bootstrap.Modal(document.getElementById('parentConsentModal'), {
            backdrop: 'static', // ⛔ disable closing when clicking outside
            keyboard: false // ⛔ disable ESC key closing
        });

        $('#checkbox2').change(function() {
            if ($(this).prop('checked') == true) {
                // $('#parentConsentModal').modal('show');
                modal.show();
            }

            if ($(this).prop('checked') == true && $('#checkbox1').prop('checked') == true) {
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

        $(document).on("click", "#confirmProceed", function() {
            var oa_err = 2;
            var cd_err = 2;
            var ra_err = 2;
            var sf_err = 2;

            if ($('#operate_accept').prop('checked') == true) {
                $('.operate_accept_error').text('');
                oa_err = 1;
            } else {
                $('.operate_accept_error').text('This field is required.');
            }

            if ($('#collect_data_accept').prop('checked') == true) {
                cd_err = 1;
                $('.collect_data_accept_error').text('');
            } else {
                $('.collect_data_accept_error').text('This field is required.');
            }

            if ($('#rules_accept').prop('checked') == true) {
                ra_err = 1;
                $('.rules_accept_error').text('');
            } else {
                $('.rules_accept_error').text('This field is required.');
            }

            if ($('#signature_full_name').val()) {
                sf_err = 1;
                $('.signature_full_name_error').text('');
            } else {
                $('.signature_full_name_error').text('This field is required.');
            }

            if (oa_err == 1 && cd_err == 1 && ra_err == 1 && sf_err == 1) {
                $('#operate_accept_val').val(1);
                $('#collect_data_accept_val').val(1);
                $('#rules_accept_val').val(1);
                $('#signature_full_name_val').val($('#signature_full_name').val());
                $('#signature_date_val').val($('#signature_date').val());

                modal.hide();
            }
        });
    </script>

    <script>
        const now = new Date();

        // Pad function
        const pad = n => n < 10 ? '0' + n : n;

        // Month short names
        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        // Components
        const day = pad(now.getDate());
        const month = months[now.getMonth()];
        const year = now.getFullYear();

        const hours24 = pad(now.getHours());
        const minutes = pad(now.getMinutes());

        // 12-hour format
        let hours12 = now.getHours() % 12 || 12;
        hours12 = pad(hours12);
        const ampm = now.getHours() >= 12 ? 'PM' : 'AM';

        // Format 1: d M Y h:i A  →  23 Oct 2025 04:15 PM
        const format1 = `${day} ${month} ${year} ${hours12}:${minutes} ${ampm}`;

        // Format 2: Y-m-d H:i  →  2025-10-23 16:15
        const format2 = `${year}-${pad(now.getMonth()+1)}-${day} ${hours24}:${minutes}`;

        $('#signature_date_hdn').val(format1);
        $('#signature_date').val(format2);
        // Show output
        //document.write(`Format1: ${format1}<br>Format2: ${format2}`);
    </script>


    {{--  <script>
             $(document).ready(function(){
                $("#email").val('');
             });
        </script> --}}
@endsection

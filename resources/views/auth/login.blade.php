@extends('layouts.app')
@section('title')
    <title>V-Tutor | Login</title>
@endsection
@section('left_part')
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
    {{--
    <div class="top_mar"></div>
    <section class="about-banner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Login</li>
                        </ol>
                    </nav>
                    <div class="inner-banner-title">
                        <h1 class="title">
                            Login
                        </h1>

                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="login-body">
        <div class="login-info">
            <div class="login-details">
                <div class="upper-login">
                    {{-- <h2>Tutor Sign Up:</h2> --}}
                    <h3>Great to see you again!</h3>
                    <p>Sign in to access and manage your sessions and profile</p>
                </div>


                @include('include.errors')




                <div class="login-from">
                    <form method="post" action="{{ route('login') }}" id="frm">
                        @csrf
                        <div class="form_area">
                            <input type="Email" class="texxt_box" placeholder="Email address" name="email"
                                onfocus="this.removeAttribute('readonly');" readonly=""
                                onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                        </div>
                        <div class="form_area">
                            <div class="password-in">
                                <input id="password-field" type="password" class="texxt_box" name="password"
                                    placeholder="Password" onfocus="this.removeAttribute('readonly');" readonly=""
                                    onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                <div class="clearfix"></div>
                                <span toggle="#password-field" class="field-icon fa fa-fw fa-eye toggle-password"></span>

                            </div>
                            <label id="password-field-error" class="error" for="password-field"></label>
                        </div>
                        <input type="submit" name="" value="Log in" class="submit-login">
                    </form>
                    {{-- <div class="or-area">
                                        <span>or continue with</span>
                                    </div> --}}

                    {{-- <div class="socials-btns">
                                        <a href="{{route('login.social',['user_type'=>'student','provider_type'=>'google'])}}" class="common-btns  google-btn">
                                        <img src="{{ public_asset('assets/images/login-google.png')}}" alt=""> Google
                                        </a>

                                        <a href="{{route('login.social',['user_type'=>'student','provider_type'=>'microsoft'])}}" class="common-btns facebook-btn ">
                                        <img src="{{ public_asset('assets/images/login-facebook.png')}}" alt=""> Microsoft
                                        </a>

                                    </div> --}}

                    {{-- <a href="{{route('login.social',['user_type'=>'user','provider_type'=>'facebook'])}}" class="common-btns facebook-btn">
                                        <img src="{{ public_asset('assets/images/login-facebook.png')}}" alt=""> Facebook
                                    </a> --}}
                    <div class="fort-pass">
                        <a href="{{ route('fgp.view') }}">Forgot password?</a>
                    </div>
                    <div class="bottom-account-div">
                        <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
                        {{-- <p>Don't have an account? <a href="{{ route('reg.home') }}">Sign up</a></p> --}}
                    </div>
                </div>



            </div>
    </section>
@endsection
@section('footer')
    @include('include.footer')
@endsection
@section('script')
    @include('include.script')
@endsection

{{-- @section('script')
    @include('include.script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
         <script>
            $(document).ready(function(){
                @if (session()->has('success') || session()->has('error') || $errors->any())
                // $("#popupModal").show();
                $("#popupModal").modal('show');
                @endif
                jQuery.validator.addMethod("emailonly", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(value.toLowerCase());
    }, "Enter valid email");



                $('#frm').validate({

                    rules:{

                        email:{
                            required:true,
                            emailonly: true,
                        },
                         password:{
                            required:true,
                            minlength:6,

                        },



                    },



                });

            });
        </script>
@endsection --}}

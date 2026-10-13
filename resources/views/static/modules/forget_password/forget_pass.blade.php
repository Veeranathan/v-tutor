@extends('layouts.app')



@section('title')
    <title>V-Tutor | Forgot Password</title>
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
    {{--  <div class="top_mar"></div><section class="about-banner">
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
                            Get in touch
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


                    @include('include.errors')
                    <h3>Forgot Password</h3>
                    <p>Please enter your email address for a link to reset password</p>
                </div>
                <div class="login-from">
                        <form action="{{ route('user.forget.password') }}" method="post" id="frm">
                            @csrf
                            <div class="form_area">
                                <input type="Email" class="texxt_box" placeholder="Email address" name="email">
                            </div>
                            <input type="submit" name="" value="Submit" class="submit-login">
                        </form>


                        {{ @$msg->msg }}
                        @if (Session::has('msg'))
                            <div class="bottom-account-div">
                                <p>Never had an account? <a href="{{ route('register') }}">Sign up now</a></p>
                            </div>
                        @endif
                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            jQuery.validator.addMethod("emailonly", function(value, element) {
                return this.optional(element) || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(
                    value.toLowerCase());
            }, "Enter valid email");



            $('#frm').validate({

                rules: {

                    email: {
                        required: true,
                        emailonly: true,
                    },
                    //  password:{
                    //     required:true,
                    //    // minlength:6

                    // },



                },



            });

        });
    </script>
@endsection

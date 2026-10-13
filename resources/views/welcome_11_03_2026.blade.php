@extends('layouts.app')
@section('title')
    <title>V-Tutor </title>
@endsection

@section('left_part')
    {{-- @include('include.left_part') --}}
    @include('include.header_menu_part')
    <link href="{{ public_asset('assets/faro_font/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ public_asset('assets/css/landing_animation.css') }}" rel="stylesheet" type="text/css">
    <style type="text/css">
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span,
        button,
        ul,
        li {
            font-family: Faro !important;
        }

        body {
            background-color: white !important;
        }

        .banner_main_div {
            .main_div {
                background-image: url({{ public_asset('assets/images/landing_tutor/landing_banner.png') }});
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
        }

        a.bk_btn_link button:hover {
            background: #fff;
        }

        .gj_hdr_sec {
            position: relative !important;
        }

        .flexibility-content {
            .card {
                background-image: url({{ public_asset('assets/images/landing_tutor/card-overlay.png') }});
            }

            .card:hover {
                background-image: none;
            }

            .card-body {
                padding: 15px 10px;
            }
        }

        .advantage-section .center-div {
            background-image: url({{ public_asset('assets/images/landing_tutor/adventure_overlay.png') }});
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
        }

        .final-cta-section {
            .main-div {
                background-image: url({{ public_asset('assets/images/landing_tutor/footer_overlay.png') }});
                background-size: 100% 100%;
            }
        }

        .textLimit {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        #offerModal {
            height: 100vh;
            margin: auto;
            padding: 10vh;
            overflow: auto
        }



        .modal-main-div {
            border-radius: 20px;

        }

        .content-sub-div {
            border-radius: 20px;
        }

        .modal-submain-div {
            border-radius: 20px;
            width: 80%;
            margin: auto;
        }



        .modal-body-main-div {
            margin-top: 6.5rem
        }

        @media (min-width: 1000px) {
            .gift_img {
                left: 22%
            }

        }


        @media (max-width: 1000px) {
            .gift_img {
                left: 12vw
            }

        }

        @media (max-width: 576px) {
            #offerModal {
                height: auto;
                padding: 8vh 2vh 8vh 2vh;

                margin: 0;
                overflow: auto;
            }

            .gift_img {
                left: 11vw;
            }

        }



        .gift_fixed {
            position: fixed;
            bottom: 100px;
            left: 5%;
            z-index: 99;
            border-radius: 50%;
            padding: 3px;
            background-color: #efefef;
            cursor: pointer;
        }

        .gift_fixed img {
            transform-origin: bottom center;
            animation: giftshake 3s ease-in-out infinite;
        }

        @keyframes giftshake {
            0% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(10deg);
            }

            50% {
                transform: rotate(-10deg);
            }

            75% {
                transform: rotate(10deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        /* Center the modal vertically & horizontally */
        .modal-dialog.modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100vh - 1rem);
        }

        /* Optional fallback centering if Bootstrap doesn’t handle it */
        .log_modal_bx .modal {
            position: fixed;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
        }

        /* Modal content styling */
        .log_modal_bx .modal-content {
            border-radius: 8px;
            overflow: hidden;
            max-width: 500px;
            /* adjust width as needed */
            width: 90%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        /* Modal header */
        .log_modal_bx .modal-header {
            background-color: #fff;
            border-bottom: 1px solid #e5e5e5;
            padding: 1rem 1.5rem;
        }

        .log_modal_bx .modal-header .modal-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin: 0;
            color: #000;
        }

        .log_modal_bx .modal-header .btn-close {
            background: none;
            border: none;
            font-size: 1.25rem;
        }

        /* Modal body */
        .log_modal_bx .modal-body {
            padding: 1.5rem;
            text-align: center;
        }

        .log_modal_bx .modal-body p {
            font-size: 1rem;
            margin: 0 0 1rem 0;
            color: #333;
        }

        /* Button group: centered and spaced */
        .log_modal_bx .button-group {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        /* Button styles */
        .log_modal_bx .btn-login,
        .log_modal_bx .btn-signup {
            min-width: 140px;
            padding: 0.65rem 1.2rem;
            font-size: 1rem;
            font-weight: 600;
            /* Removed uppercase transform */
            text-transform: none;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        /* Red buttons */
        .log_modal_bx .btn-login {
            background-color: #c00;
            /* your brand red */
        }

        .log_modal_bx .btn-login:hover {
            background-color: #a00;
        }

        /* If both should have same color */
        .log_modal_bx .btn-signup {
            background-color: #c00;
        }

        .log_modal_bx .btn-signup:hover {
            background-color: #a00;
        }

        a.site_link {
            color: #dc3545;
        }

        /* Responsive: stack buttons on very small screens */
        @media (max-width: 400px) {
            .log_modal_bx .button-group {
                flex-direction: column;
                gap: 0.75rem;
            }

            .log_modal_bx .btn-login,
            .log_modal_bx .btn-signup {
                width: 100%;
                min-width: auto;
            }
        }
        ul.benefit-list li {
            margin-bottom: 2px !important;
        }
        .profile-card .img-container {
            width: 100%;
            height: 269px;
            overflow: hidden;
            border-radius: 10px;
        }

        .profile-card .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-name {
            text-align: center !important;
            margin-bottom: 4px !important;
        }

        .tickImg.hero-banner {
            min-width: 20px !important;
        }
        @media only screen and (max-width: 1600px) {
        .banner_main_div {
        & h1 {
            font-size: 43px !important;
            line-height: 70px !important;
            }
         }
        }
        @media only screen and (max-width: 1600px) {
            .tag-img {
                height: 67px !important;
            }
        }
    </style>
@endsection
@section('content')
    <!-- bannersec -->
    {{-- <div class="top_mar"></div> --}}
    <div class="banner_main_div">
        <div class=" container  main_div">
            <div class="">
                <section class="text-white rounded-3 position-relative overflow-hidden  ">
                    <div class="container-fluid container-lg ">
                        <!-- Tag image positioned at top right -->
                        <img src="{{ public_asset('assets/images/landing_tutor/tag.png') }}" alt="Online tutoring Australia"
                            class="position-absolute top-0 end-0 mt-3 me-3 tag-img" />

                        <div class="row align-items-center">
                            <div class="col-lg-7 p-2 py-4 p-sm-2 py-sm-2 py-md-5 px-md-0 mb-4">
                                <h1 class="mb-2">Expert Online Tutoring in Australia</h1>
                                <!-- <h1 class=""> Smarter Learning Starts Here </h1> -->

                                <p class="pt-1 para-text showForLap mb-2">
                                    Book Australia-wide online tutors for Maths, English & Science — no waitlists, no hidden fees.
                                </p>
                                <p class="pt-1 para-text showForMbl pb-2">
                                    Book Australia-wide online tutors for Maths, English & Science — no waitlists, no hidden fees.
                                </p>
                                <a href="{{ url('tutor-search-result') }}" class="bk_btn_hdr_link"><button class="primary-button mr-3 mt-4  d-md-block">Find Tutors</button></a> 

                                <!-- @if (!@Auth::check())
                                    @if (@$disable_booking_details->disable_booking == 'Y')
                                        <a data-toggle="modal" data-target="#admin_disabled_bookings_popup"
                                            class="bk_btn_link">
                                            <button class="primary-button mb-5">Book a Session 1</button>
                                        </a>
                                    @else
                                        <a
                                            @if (!@Auth::check()) href="javascript:void(0);" data-id="{{ @$tutor->id }}" data-toggle="modal" data-target="#log_modal" class="bk_btn_link" data-type="B"   @else href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . @$tutor->slug . '&search_tutor_id_studentclass=' . @$tutor->id) }}" @endif>
                                            <button class="primary-button mb-5">Book a Session 2</button>
                                        </a>
                                    @endif
                                @else
                                    @if (@Auth::user()->user_type == 'U')
                                        @php
                                            $myGrade = \App\Models\Grade::where([
                                                'id' => @Auth::user()->grade,
                                                'status' => 'A',
                                            ])
                                                ->select('id', 'slug', 'status')
                                                ->first();
                                            $myState = \App\Models\State::where([
                                                'id' => @Auth::user()->state,
                                            ])->first();
                                        @endphp

                                        <a href="{{ url('tutor-search-result?grade=' . @$myGrade->slug) }}"
                                            class="bk_btn_link"><button class="primary-button mb-5">Book </button></a>
                                    @endif
                                @endif -->
<!-- 
                                {{-- <button class="primary-button mb-5">
                                Book Now
                            </button> --}} -->

                                <div class="row mx-0 pt-4 pt-sm-1 mt-4">
                                    <div class="col-12 col-lg-8">
                                        <ul class="list-unstyled d-flex flex-wrap row g-1 benefit-list">
                                            <li class="col-sm-6 d-flex align-items-center margin-bot p-0">
                                                <span class="mr-2">
                                                    <img src="{{ public_asset('assets/images/banner_tick.png') }}"
                                                        alt="Online tutoring Australia - Tailored Lessons" class="tickImg hero-banner" />
                                                </span>
                                                <span>On-demand Tutors</span>
                                            </li>
                                            <li class="col-sm-6 d-flex align-items-center margin-bot  p-0">
                                                <span class="mr-2">
                                                    <img src="{{ public_asset('assets/images/banner_tick.png') }}"
                                                        alt="Online tutors Australia - On-demand Tutors" class="tickImg hero-banner" />
                                                </span>
                                                <span>Flexible Sessions</span>
                                            </li>
                                            <li class="col-sm-6 d-flex align-items-center  mb-md-0 sm-margin-bot p-0">
                                                <span class="mr-2">
                                                    <img src="{{ public_asset('assets/images/banner_tick.png') }}"
                                                        alt="Qualified tutors Australia - Flexible Schedules" class="tickImg hero-banner" />
                                                </span>
                                                <span>Personalised Programs</span>
                                            </li>
                                            <li class="col-sm-6 d-flex align-items-center mb-0 mb-md-0 p-0">
                                                <span class="mr-2">
                                                    <img src="{{ public_asset('assets/images/banner_tick.png') }}"
                                                        alt="Online tutoring platform Australia - Reliable Support" class="tickImg hero-banner" />
                                                </span>
                                                <span>One-to-One Learning</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class=" container banner_main_div">
        <div class="">
            <section class="feature-block">
                <div class="row g-0 row-cols-3 row-cols-md-3 row-cols-lg-6 justify-content-center">

                    <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                        <div class="feature-item text-center ">
                            <div class="feature-img d-flex justify-content-center align-items-center">
                                <img src="{{ public_asset('assets/images/landing_tutor/wide.png') }}" alt="Tailored lessons by expert Australian maths tutors, science tutors and English tutors" />
                            </div>
                            <p class="mb-3 mb-md-0 text-dark showForLap"> English, Maths</p>
                            <p class="mb-3 mb-md-0 text-dark showForLap"> Science Tutors</p>
                            <p class="mb-3 mb-md-0 text-dark showForMbl">English, Maths, Science Tutors</p> 
                        </div>
                    </div>

                    <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                        <div class="feature-item text-center remove-b-mbl">
                            <div class="feature-img d-flex justify-content-center align-items-center">
                                <img src="{{ public_asset('assets/images/landing_tutor/demand.png') }}" alt="On-demand Australia tutors including online maths, science and English tutors" />
                            </div>

                            <p class="mb-3 mb-md-0 text-dark showForLap">Year 1-12</p>
                            <p class="mb-3 mb-md-0 text-dark showForLap">Programs</p>
                            <p class="mb-3 mb-md-0 text-dark showForMbl">Year 1-12 Programs</p>
                        </div>
                    </div>

                    <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                        <div class="feature-item text-center">
                            <div class="feature-img d-flex justify-content-center align-items-center">
                                <img src="{{ public_asset('assets/images/landing_tutor/one-to-one.png') }}"
                                    alt="Flexible learning schedules with qualified Australian maths tutors, science tutors and English tutors" />
                            </div>
                            <p class="mb-3 mb-md-0 text-dark showForLap">1-to-1 Online</p>
                            <p class="mb-3 mb-md-0 text-dark showForLap">Sessions</p>
                            <p class="mb-3 mb-md-0 text-dark showForMbl">1-to-1 Online Sessions</p>

                        </div>
                    </div>

                    <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                        <div class="feature-item text-center remove-b-mbl">
                            <div class="feature-img d-flex justify-content-center align-items-center">
                                <img src="{{ public_asset('assets/images/landing_tutor/flexible.png') }}" alt="Reliable support from experienced Australia tutors including maths, science and English specialists" />
                            </div>
                            <p class="mb-3 mb-md-0 text-dark showForLap">OC, HSC, NAPLAN</p>
                            <p class="mb-3 mb-md-0 text-dark showForLap"> Support</p>
                            <p class="mb-3 mb-md-0 text-dark showForMbl">OC, HSC, NAPLAN Support</p>

                        </div>
                    </div>

                    <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                        <div class="feature-item text-center">
                            <div class="feature-img d-flex justify-content-center align-items-center">
                                <img src="{{ public_asset('assets/images/landing_tutor/transparent.png') }}"
                                    alt="Transparent pricing for online tutoring in Australia with qualified tutors" />
                            </div>
                            <p class="mb-3 mb-md-0 text-dark showForLap">Affordable</p>
                            <p class="mb-3 mb-md-0 text-dark showForLap">Tutoring</p>
                            <p class="mb-3 mb-md-0 text-dark showForMbl">Affordable Tutoring</p>


                        </div>
                    </div>

                    <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                        <div class="feature-item text-center border-0">
                            <div class="feature-img d-flex justify-content-center align-items-center">
                                <img src="{{ public_asset('assets/images/landing_tutor/booking.png') }}" alt="One-touch booking for Australian online tutors including maths, science and English tutors" />
                            </div>
                            <p class="mb-3 mb-md-0 text-dark showForLap">Easy online</p>
                            <p class="mb-3 mb-md-0 text-dark showForLap">booking</p>
                            <p class="mb-3 mb-md-0 text-dark showForMbl">Easy online booking</p>

                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>
    <div class="container flexibility-content">

        <div class="text-center mb-3 mb-md-5">
            <h2 class="main-heading mb-0">Where <span class="section-heading">Flexible Online Learning</span> Meets Aussie Expertise</h2>
        </div>

        <div class="row g-4 justify-content-center m-0">

            <div class="col-6 col-lg-3 col-md-6 p-1 p-sm-3 pb-sm-3 pb-md-4 pb-lg-0">
                <div class="card  h-100 p-0 p-md-3">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-2 mb-sm-3">
                            <div class=" mr-2 image-div ">
                                <img src="{{ public_asset('assets/images/landing_tutor/flex_1.svg') }}" alt="Australia-wide online tutors for English, maths and science" />
                            </div>
                            <div>

                                <h5 class=" mb-0 showForLap">Australia-Wide Tutors,</h5>
                                <h5 class=" mb-0 showForLap">For Every Child</h5>
                                <h5 class=" mb-0 showForMbl">Australia-Wide Tutors, For Every Child</h5>
                            </div>
                        </div>
                        <p class="card-text ">
                            {{-- From Darwin to Hobart, Brisbane to Perth – the right tutor, at the right time. --}}
                            Trusted online tutors across Australia - Sydney to Perth, Darwin to Hobart.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3 col-md-6 p-1 p-sm-3 pb-sm-3 pb-md-4 pb-lg-0">
                <div class="card h-100 p-0 p-md-3 ">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-2 mb-sm-3">
                            <div class="mr-2 image-div">
                                <img src="{{ public_asset('assets/images/landing_tutor/flex_2.svg') }}" alt="On-demand Australia online tutors available instantly for online learning" />
                            </div>
                            <div>
                                <h5 class=" mb-0 showForLap">Tutors Ready When You</h5>
                                <h5 class=" mb-0 showForLap">Are</h5>
                                <h5 class=" mb-0 showForMbl">Tutors Ready When You Are</h5>

                            </div>
                        </div>
                        <p class="card-text ">
                            {{-- Tutors available most of the day – learning without delays or hassles --}}
                            On-demand tutors available to learn instantly with no delays or waitlists.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3 col-md-6 p-1 p-sm-3 pb-sm-3 pb-md-4 pb-lg-0">
                <div class="card  h-100 p-0 p-md-3">
                    <div class="card-body ">
                        <div class="d-flex align-items-start mb-2 mb-sm-3">
                            <div class="mr-2 image-div">
                                <img src="{{ public_asset('assets/images/landing_tutor/flex_3.svg') }}" alt="Flexible online learning with online Australian tutors across maths tutors, science tutors and English tutors" />
                            </div>
                            <div>
                                <h5 class=" mb-0 showForLap">Learning on Your Terms</h5>
                                <h5 class=" mb-0 showForMbl">Learning on Your Terms</h5>

                            </div>
                        </div>
                        <p class="card-text ">
                            Choose your own tutor for Maths, English, Science & others from Y1–Y12.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3 col-md-6 p-1 p-sm-3 pb-sm-3 pb-md-4 pb-lg-0">
                <div class="card h-100 p-0 p-md-3">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-2 mb-sm-3">
                            <div class=" mr-2 image-div">
                                <img src="{{ public_asset('assets/images/landing_tutor/flex_4.svg') }}" alt="Pay-as-you-learn online tutoring in Australia with qualified tutors" />
                            </div>
                            <div>
                                <h5 class=" mb-0 showForLap">Pay As You Learn</h5>
                                <h5 class=" mb-0 showForMbl">Pay as You Learn</h5>

                            </div>
                        </div>
                        <p class="card-text ">
                            {{-- Hassle-free tutoring: book when you need, pay per session – no contracts. --}}
                            Simply book online tutoring sessions – no contracts or commitments.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <section class="container">
        <div class="video-section">
            <video id="learningVideo" muted loop playsinline>
                <source src="{{ public_asset('assets/images/landing_tutor/v_tutor_learning_video.mp4') }}"
                    type="video/mp4" />
                {{-- <source src="{{ public_asset('assets/images/landing_tutor/learning_video.mp4') }}" type="video/mp4" /> --}}
            </video>
            <div class="video-overlay"></div>

            <!-- Play button -->
            <div class="play-button" id="playButton"></div>

            <!-- Feature icons -->
            <div class="feature-icons d-flex align-items-center">
                <div class="d-flex align-items-center ">
                    <div class="feature-item  ml-0">
                        <img src="{{ public_asset('assets/images/landing_tutor/video_1.svg') }}" alt="Online tutoring Australia – student support from WWCC verified tutors" />
                    </div>
                    <h3 class="mt-0"> Outcome based learning</h3>
                </div>
                <div class="d-flex align-items-center">
                    <div class="feature-item">
                        <img src="{{ public_asset('assets/images/landing_tutor/video_2.svg') }}" alt="Personalised attention by qualified online tutors in Australia for English, Maths and Science" />

                    </div>
                    <h3 class="mt-0"> Personalised Academic Support</h3>
                </div>
                <div class="d-flex align-items-center">
                    <div class="feature-item">
                        <img src="{{ public_asset('assets/images/landing_tutor/video_3.svg') }}" alt="Results from ACARA-aligned online tutors Australia for Maths, Science and English" />

                    </div>
                    <h3 class="mt-0">OC, HSC, NAPLAN Programs</h3>
                </div>
            </div>
        </div>
        {{-- <div class="video-section-mbl d-flex d-md-none flex-wrap align-items-center">
            <div class="d-flex align-items-center mt-2 w-100 ">
                <div class="feature-item  ml-0">
                    <img src="{{ public_asset('assets/images/landing_tutor/video_support.png') }}" alt="support" />
                </div>
                <h3 class="mt-0"> Support When They Need It</h3>
            </div>
            <div class="d-flex align-items-center mt-2 w-100">
                <div class="feature-item">
                    <img src="{{ public_asset('assets/images/landing_tutor/video_attention.png') }}" alt="Attention" />

                </div>
                <h3 class="mt-0">Attention That Truly Matters</h3>
            </div>
            <div class="d-flex align-items-center mt-2 w-100">
                <div class="feature-item">
                    <img src="{{ public_asset('assets/images/landing_tutor/video_result.png') }}" alt="Result" />

                </div>
                <h3 class="mt-0">Results You Can See</h3>
            </div>
        </div> --}}
    </section>
    <section class="advantage-section">
        <div class="container">
            <div class="d-flex align-items-center gap-3 main-div flex-wrap flex-md-nowrap">
                <div class="order-2 order-md-1">
                    <div class="card card-with-bottom">
                        <div class="d-flex align-items-center card-title">
                            <div class="number">01.</div>
                            <h3>Expert Guidance</h3>
                        </div>
                        <p>Work with highly experienced, Australia-wide online tutors to strengthen your child’s learning journey.</p>
                    </div>

                    <div class="card">
                        <div class="d-flex align-items-center card-title">
                            <div class="number">02.</div>
                            <h3>Focused Learning</h3>

                        </div>
                        <p>Personalised one-to-one online tutoring designed to build confidence, fill learning gaps, and lift results.</p>
                    </div>
                </div>
                <div class="center-div  order-1 order-md-2">
                    <h1 class="title">Why <span>V-Tutor?</span> Australia’s <span>Trusted</span> Online <span>Tutoring</span> for Y1–Y12</h1>
                    <p class="subtitle">Find out why V-Tutor is the smarter choice for personalised, results-driven
                        learning</p>
                </div>
                <div class="right-div order-3">
                    <div class="card card-with-bottom">
                        <div class="d-flex align-items-center card-title">
                            <div class="number">03.</div>
                            <h3>Progress Supported</h3>
                        </div>
                        <p>Your child’s progress is supported through recorded sessions - helping maintain continuity and quality.</p>
                    </div>

                    <div class="card">
                        <div class="d-flex align-items-center card-title">
                            <div class="number">04.</div>
                            <h3>Safe & Seamless</h3>
                        </div>
                        <p>Our Australian online tutoring platform ensures safe, secure and easy learning for all year levels.</p>
                    </div>
                </div>
            </div>


        </div>
    </section>

    <section class="container safty-learning text-white  ">
        <div class=" text-center">

            <h2 class="mb-4 mb-md-5"><span class="text-v-tutor-yellow">Safe</span>, ACARA-Aligned Online Learning with V-Tutor </h2>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

                <div class="col">
                    <div class="p-1 p-md-3">
                        <div class="d-flex justify-content-center align-items-center">
                            <img class="feature-icon "
                                src="{{ public_asset('assets/images/landing_tutor/safe_icon1.svg') }}" alt="WWCC verified online tutors Australia ensuring safe learning for Maths, Science and English" />
                        </div>
                        <p class="feature-title">Tutor Selection</p>
                        <p class="feature-content">
                             Hand-picked, verified, and WWCC-cleared Australian tutors for trusted online learning.
                        </p>
                    </div>
                </div>

                <div class="col">
                    <div class="p-1 p-md-3">
                        <div class="d-flex justify-content-center align-items-center">
                            <img class="feature-icon"
                                src="{{ public_asset('assets/images/landing_tutor/safe_icon2.svg') }}" alt="Secure online tutoring Australia with monitored and recorded sessions for student safety" />
                        </div>
                        <p class="feature-title">Session Monitoring</p>
                        <p class="feature-content">
                             Every session is recorded to ensure quality, safety and consistent learning outcomes.
                        </p>
                    </div>
                </div>

                <div class="col">
                    <div class="p-1 p-md-3">
                        <div class="d-flex justify-content-center align-items-center">
                            <img class="feature-icon"
                                src="{{ public_asset('assets/images/landing_tutor/safe_icon3.svg') }}" alt="ACARA-aligned online tutors Australia for consistent Maths, Science and English learning" />
                        </div>
                        <p class="feature-title">Curriculum Aligned</p>
                        <p class="feature-content ">
                             All lessons follow the Australian Curriculum (ACARA) - tailored for states - primary & high school.
                        </p>
                    </div>
                </div>

                <div class="col">
                    <div class="p-1 p-md-3">
                        <div class="d-flex justify-content-center align-items-center">
                            <img class="feature-icon"
                                src="{{ public_asset('assets/images/landing_tutor/safe_icon4.svg') }}" alt="Reliable support for students using V-Tutor’s online tutoring Australia platform" />
                        </div>
                        <p class="feature-title">Support When Needed</p>
                        <p class="feature-content">
                             Access real help anytime with on-demand tutoring support and guidance throughout.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @if (count($featuredtutors) != 0)
    <section class="container profile-section">
        <div class="">

            <div class="text-center mb-3 mb-md-5">
                <h2 class="section-heading"><span class="text-v-tutor-red">Meet the Minds</span> Behind the Learning</h2>
            </div>

            <div class="row g-4 justify-content-center m-0 ">

                <div class="row">
                    @foreach ($featuredtutors as $index => $tutor)
                        @php
                            // Odd index → pink, Even index → yellow
                            $bgClass = $index % 2 == 0 ? 'card-pink-bg' : 'card-yellow-bg';

                            $image = $tutor->profile_pic
                                ? asset('storage/teacher_profile_pic/' . $tutor->profile_pic)
                                : public_asset('assets/images/blank1.png');

                            $branches = $tutor->getTutorShipPlan
                                ->flatMap(fn($plan) => $plan->getBranches->pluck('branch_name'))
                                ->unique()
                                ->implode(', ');
                        @endphp

                        <div class="col-6 col-lg-3 col-md-6 col-sm-6 mb-0 mb-md-4 mb-lg-0 p-1 p-sm-3">
                            <div class="card profile-card {{ $bgClass }} h-100">
                                <div class="img-container">
                                    <img src="{{ $image }}" alt="{{ $tutor->f_name }}" class="profile-img" />
                                </div>
                                <div class="profile-content">
                                    <p class="profile-name">{{ $tutor->f_name }}</p>
                                    <p class="profile-bio">
                                         {{ Str::limit($tutor->about_me ?? 'Experienced tutor', 80) }}
                                        {{-- {{ $tutor->total_experience }} years of experience in {{ $branches ?: 'various subjects' }} coaching --}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- <div class="col-6  col-lg-3 col-md-6 col-sm-6 mb-0  mb-md-4 mb-lg-0 p-1 p-sm-3">
                    <div class="card profile-card card-yellow-bg h-100">
                        <div class="img-container">
                            <img src="{{ public_asset('assets/images/landing_tutor/person_2.png') }}" alt="Jhon"
                                class="profile-img" />

                        </div>
                        <div class="profile-content">
                            <p class="profile-name">Jhon</p>
                            <p class="profile-bio">15+ years of experience in Business English coaching</p>
                        </div>
                    </div>
                </div>

                <div class="col-6  col-lg-3 col-md-6 col-sm-6 mb-0  mb-md-4 mb-lg-0 p-1 p-sm-3">
                    <div class="card profile-card card-pink-bg h-100">
                        <div class="img-container">
                            <img src="{{ public_asset('assets/images/landing_tutor/person_4.png') }}" alt="Jhon"
                                class="profile-img" />

                        </div>
                        <div class="profile-content">
                            <p class="profile-name">Ria Sharma</p>
                            <p class="profile-bio">15+ years of experience in Business English coaching</p>
                        </div>
                    </div>
                </div>

                <div class="col-6  col-lg-3 col-md-6 col-sm-6 mb-0  mb-md-4 mb-lg-0 p-1 p-sm-3">
                    <div class="card profile-card card-yellow-bg h-100">
                        <div class="img-container">
                            <img src="{{ public_asset('assets/images/landing_tutor/person_3.png') }}" alt="Jhon"
                                class="profile-img" />

                        </div>
                        <div class="profile-content">
                            <p class="profile-name">Ria Sharma</p>
                            <p class="profile-bio">15+ years of experience in Business English coaching</p>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
    </section>
    @endif

    <!-- faqsec -->
    <section class="mt-10">
        <div class="container">
            <div class="row align">
                <div class="col-md-4 col-xl-5">
                    <div class="about-wrapper">
                        <div class="profile-section text-center">
                            <h2 class="section-heading"><span class="text-v-tutor-red">Frequently</span> Asked Questions?</h2>
                            <a href="{{ url('faq') }}">
                            <button class="primary-button mt-2 d-inline-block">More FAQs</button>      
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-xl-7">
                    <div class="">
                        <div class="makes_faq_bx newfaq">
                            <div class="accordion" id="homePageFaqAccordion">
                                @if(@$StudentFaqModel)
                                @foreach($StudentFaqModel as $key => $faq)
                                    @if($key == 3)
                                        @continue
                                    @endif
                                    <div class="card">
                                        <div class="card-header" id="faqHeading{{ $key }}">
                                            <h2 class="mb-0">
                                                <a class="btn-link btn-block text-left {{ $key != 0 ? 'collapsed' : '' }}" 
                                                   data-toggle="collapse" 
                                                   data-target="#collapseFaq{{ $key }}" 
                                                   aria-expanded="{{ $key == 0 ? 'true' : 'false' }}" 
                                                   aria-controls="collapseFaq{{ $key }}">
                                                    {{ $faq->question }}
                                                </a>
                                            </h2>
                                        </div>
                                        <div id="collapseFaq{{ $key }}" 
                                             class="collapse {{ $key == 0 ? 'show' : '' }}" 
                                             aria-labelledby="faqHeading{{ $key }}" 
                                             data-parent="#homePageFaqAccordion">
                                            <div class="card-body">
                                                <p>{!! strip_tags($faq->answer) !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @endif
                            </div> <!-- end accordion -->
                        </div> <!-- end makes_faq_bx -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container final-cta-section">
        <div class=" text-white text-center  rounded-4 position-relative overflow-hidden main-div">
            <div class="cta-swirl-graphic"></div>
            <h2 class="display-5 fw-bold mb-4 z-2 position-relative">
                Empower Your Child's <span class="text-v-tutor-yellow">Learning Journey</span> With V-Tutor
            </h2>

            @if (!@Auth::check())
                @if (@$disable_booking_details->disable_booking == 'Y')
                    <a data-toggle="modal" data-target="#admin_disabled_bookings_popup" class="bk_btn_link">
                        <button class="primary-button">Book a Session</button>
                    </a>
                @else
                    <a
                        @if (!@Auth::check()) href="javascript:void(0);" data-id="{{ @$tutor->id }}" data-toggle="modal" data-target="#log_modal" class="bk_btn_link" data-type="B"   @else href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . @$tutor->slug . '&search_tutor_id_studentclass=' . @$tutor->id) }}" @endif>
                        <button class="primary-button">Book a Session</button>
                    </a>
                @endif
            @else
                @if (@Auth::user()->user_type == 'U')
                    @php
                        $myGrade = \App\Models\Grade::where(['id' => @Auth::user()->grade, 'status' => 'A'])
                            ->select('id', 'slug', 'status')
                            ->first();
                        $myState = \App\Models\State::where(['id' => @Auth::user()->state])->first();
                    @endphp

                    <a href="{{ url('tutor-search-result?grade=' . @$myGrade->slug) }}" class="bk_btn_link"><button
                            class="primary-button">Book a Session</button></a>
                @endif
            @endif
        </div>
    </section>

    @if (isset($promotion) && $promotion && $promotion->discount && $promotion->discount_code)
        <section class="gift_fixed">
            <img src="{{ public_asset('assets/images/gift_img.png') }}" alt="Gift icon highlighting special offers for Australian school students seeking tutors" class=""
                style="width: 5rem; height: 5rem;">
        </section>
    @endif

    <section>
        <div class="modal fade" id="offerModal" tabindex="-1" aria-labelledby="offerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered bg-danger p-2 p-sm-3 p-md-4 p-lg-5 modal-main-div">
                <div class="modal-content border-0 text-center modal-submain-div">
                    <div class=" bg-white position-relative content-sub-div">
                        <img src="{{ public_asset('assets/images/gift_img.png') }}" alt="Gift icon highlighting special offers for face-to-face online school tutoring in Australia"
                            class="position-absolute  gift_img" style="top: -73px; width: 13rem; height: 13rem;">
                        <div class="modal-body bg-white modal-body-main-div">
                            <p class="mb-1 text-secondary " style=" font-size:1.2rem;">Save a flat</p>
                            <h2 class="fw-bold my-0" style="color:#ff4d4d; font-size:3.5rem;">{{ @$promotion->discount }}%</h2>
                            <p class="text-secondary mb-4 mt-1">on all bookings</p>
                            <button class="btn w-100 rounded-pill fw-semibold text-black border mb-2 "
                                style=" border-radius:20px font-size:1.2rem;">{{ @$promotion->discount_code }}</button>

                            @if(!@Auth::check())
                                @if(@$disable_booking_details->disable_booking == 'Y')
                                    <a href="javascript:void(0);" class="gj_pro_bs_link" data-toggle="modal" data-target="#admin_disabled_bookings_popup">
                                        <button class="btn w-100 rounded-pill fw-semibold text-white "
                                        style="background-color:#ff4d4d; border-radius:20px font-size:1.2rem;">Book a Session</button>
                                    </a>
                                @else
                                    <a href="javascript:void(0);" @if(!@Auth::check()) href="javascript:void(0);" data-id="{{ @$tutor->id }}" data-toggle="modal" data-target="#log_modal" data-type="B" class="gj_pro_bs_link" @else href="{{ url('studentbook-class?search_tutor_slug_studentclass='.@$tutor->slug.'&search_tutor_id_studentclass='.@$tutor->id) }}" class="gj_pro_bks_link" @endif>
                                        <button class="btn w-100 rounded-pill fw-semibold text-white "
                                        style="background-color:#ff4d4d; border-radius:20px font-size:1.2rem;">Book a Session</button>
                                    </a>
                                @endif
                            @else
                                @if(@Auth::user()->user_type == 'U')
                                    @php
                                        $myGrade = \App\Models\Grade::where(['id'=>@Auth::user()->grade,'status'=>'A'])->select('id','slug','status')->first();
                                        $myState = \App\Models\State::where(['id'=>@Auth::user()->state])->first();
                                    @endphp
                                    <a href="{{ url('tutor-search-result?grade='.@$myGrade->slug) }}" class="gj_pro_bks_link">
                                        <button class="btn w-100 rounded-pill fw-semibold text-white "
                                        style="background-color:#ff4d4d; border-radius:20px font-size:1.2rem;">Book a Session</button>
                                    </a>
                                @else
                                    <a href="javascript:void(0);" class="gj_pro_bs_link">
                                        <button class="btn w-100 rounded-pill fw-semibold text-white "
                                        style="background-color:#ff4d4d; border-radius:20px font-size:1.2rem;">Book a Session</button>
                                    </a>
                                @endif
                            @endif
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
    @include('include.footer')
   <div class="modal fade log_modal_bx" id="log_modal{{ @$tutor->id }}">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Login / Sign up</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p>Click on Login or Sign up to continue</p>
        <div class="button-group">
          <a href="{{ route('login') }}" class="btn btn-login">Login</a>
          <a href="{{ route('register') }}" class="btn btn-signup">Sign up</a>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection --}}

@section('script')
    <script>
        const video = document.getElementById("learningVideo");
        const playButton = document.getElementById("playButton");

        // Click handler
        playButton.addEventListener("click", () => {
            if (video.paused) {
                video.play();
                playButton.classList.add("playing");
            } else {
                video.pause();
                playButton.classList.remove("playing");
            }
        });

        // Progress tracking
        video.addEventListener("timeupdate", () => {
            const progress = (video.currentTime / video.duration) * 100;
            playButton.style.background = `conic-gradient(
      rgba(255, 255, 255, 0.7) ${progress}%,
      rgba(255, 255, 255, 0.3) ${progress}%
    )`;
        });
    </script>
    {{-- <script src="{{ public_asset('assets/js/jquerymin.js') }}"></script>
    <script src="{{ public_asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ public_asset('assets/js/carouselscript.js')}}"></script>
    <script src="{{ public_asset('assets/js/owl.carousel.js')}}"></script>
    <script src="{{ public_asset('assets/js/moment.js')}}"></script>
    <script src="{{ public_asset('assets/js/jquery-ui.js')}}"></script>
    <script src="{{ public_asset('assets/js/semantic.min.js')}}"></script>
    <script src="{{ public_asset('assets/js/custom.js')}}"></script>     --}}
    @include('include.script')
    <script>
        const offerModalEl = document.getElementById('offerModal');
        const offerModal = new bootstrap.Modal(offerModalEl);
        document.addEventListener("DOMContentLoaded", () => {
            // Get all elements with .gift_fixed class
            const giftButtons = document.querySelectorAll('.gift_fixed');

            // Add click event to each
            giftButtons.forEach(button => {
                button.addEventListener('click', () => {
                    offerModal.show();
                });
            });
        });
    </script>
    <script type="text/javascript">
        // $(".bannersec").click(function(){
        //     var obj = $("#carouselExampleControls .carousel-inner .active").data("link");
        //     location.href=obj;

        // });
        $(".save_input_data_on_click").click(function() {
            //type for which page if b booking if pp public profile if pr post review page
            var save_on_click_value_type = $(this).data("type"),
                save_search_on_click_tutor_id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: '{{ route('save.search.on.click.value') }}',
                data: {
                    save_on_click_value: save_on_click_value_type,
                    save_search_on_click_tutor_id: save_search_on_click_tutor_id
                },
                success: function(resp) {
                    // $("#log_modal").modal("show");
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.gj_pro_bs_link', function(e) {
            e.preventDefault();

            // Get target modal id
            const targetModal = $(this).data('target');

            // Close all currently open modals
            offerModal.hide();
            $('.modal.show').modal('hide');
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '');

            // Wait a bit to ensure others are closed, then open the new one
            setTimeout(() => {
                $(targetModal).modal('show');
            }, 200); // 0.5s delay avoids animation overlap
        });
    </script>
@endsection

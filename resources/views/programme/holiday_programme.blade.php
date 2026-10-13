@extends('layouts.app')

@section('title')
    <title>V-Tutor Tutor Home</title>
@endsection

@section('left_part')
    @include('include.tutor_head')
    @include('include.header_menu_part')

    <style>
        body {
            font-family: Faro !important;
        }

        .banner_description {
    color: #fff !important;
    font-size: 20px;
    line-height: 1.6;
    margin-bottom: 25px;
}

/* Bigger Enroll Now button */
.start_now_button {
    display: inline-block;
    padding: 14px 32px; /* bigger padding */
    font-size: 24px;    /* bigger text */
    font-weight: 700;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.2s ease;
}

    </style>
@endsection

@section('content')

<div class="gj_land_alert_sec">
    @include('include.errors')
</div>

{{-- Banner Section Start --}}
<section class="gj_tut_lan_banner_sec mb-0">
    <div class="banner_text_wrapper  mb-0">
        <div class="row m-0  mb-0">

            {{-- LEFT SIDE — IMAGE --}}
            <div class="col-lg-6 col-md-12 col-sm-12 col-12 banner_right_col1 p-0">
                <div class="banner_right_div">
                  <a href="{{ route('programme.signup') }}">
                    <img src="{{ public_asset('assets/tutor_landing/summer_holiday_program_2025_hero.svg') }}" alt="banner_image">
                  </a>
                </div>
            </div>

            {{-- RIGHT SIDE — TEXT --}}
            <div class="col-lg-6 col-md-12 col-sm-12 col-12 banner_left_col1 p-0">
                <div class="banner_left_div">
                    <div class="container">
                        <div class="row m-0">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 banner_left_col2 p-0">
                                <h1 class="banner_hd text-white mb-3">
                                    <span class="banner_hd_split">V-Tutor</span>
                                   Summer Holiday Camp 2025
                                </h1>
                                <h3 class="mb-4 banner_description">Join V-Tutor's Free Summer Holiday Program - fun, educational online workshop for, students in Years 1 - 12 across Australia.
                                  Help your child build confidence, improve skills and enjoy engaging, sessions in English, Maths, Science and more. Open
                                  nationwide and completely free to join.
                                </h3>
                                <a href="{{ route('programme.signup') }}" class="start_now_button">Enroll Now</a>
                            </div>
                        </div>
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

@section('script')
    @include('include.script')
    <script src="{{ public_asset('assets/js/swiper-bundle.min.js')}}"></script>
@endsection

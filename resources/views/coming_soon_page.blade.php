@extends('layouts.app')
@section('title')
    <title>V-Tutor | Flexible Online Tutoring Across Australia</title>
@endsection

@section('head')
    {{-- @include('include.tutor_head') --}}
    <link href="{{ public_asset('assets/css/comming_soon_styles.css')}}" rel="stylesheet">
@endsection

@section('left_part')    
    <style>
        
    </style>
@endsection

@section('content')
    <div class="gj_land_alert_sec">
        @include('include.errors')
    </div>
    
    <div class="gj_cs_main_div">
        {{-- Comming Soon Section Start --}}
        {{-- <section class="gj_cs_sec">
            <div class="gj_cs_div">
                <img src="{{ public_asset('assets/comming_soon/v_tutor_cs_1.png') }}" alt="v_tutor_cs_1" usemap="#v_tutor_cs_1"/>

                <map name="v_tutor_cs_1">
                <!-- coords: left-x, top-y, right-x, bottom-y -->
                <area shape="rect" coords="180,580,370,670" href="http://127.0.0.1:9000/tutor/sign-up" alt="Start here" />
                </map>
            </div>
        </section> --}}
        {{-- Comming Soon Section End --}}

        {{-- Teach & Learning Section Start --}}
        <section class="gj_cs_teach_learning_sec">
            <div class="container-fluid">            
                <div class="row gj_cs_teach_learning_row1">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 gj_cs_teach_learning_col_1">
                        <div class="row gj_cs_teach_learning_row_11">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 gj_cs_teach_learning_col_11">
                                <div class="cs_teach_img_div">
                                    <img src="{{ public_asset('assets/comming_soon/cs_1.jpg') }}" alt="passion_to_teach_image">
                                </div>
                            </div>
                        </div>

                        <div class="row gj_cs_teach_learning_row_12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 gj_cs_teach_learning_col_12">
                                <div class="cs_teach_hd_div">
                                    <h3 class="cs_teach_hd">Teach with Us</h3>

                                    <div class="cs_teach_start_button_div">
                                        @if(!@Auth::check())
                                            <a href="{{route('tutor_application_form')}}" class="cs_teach_start_button">Start here</a>
                                            {{-- <a href="{{route('reg.home')}}" class="cs_teach_start_button">Start here</a> --}}
                                        @else
                                            <a href="{{route('tutor_application_form')}}" class="cs_teach_start_button">Start here</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 gj_cs_teach_learning_col_2">
                        <div class="row gj_cs_teach_learning_row_11">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 gj_cs_teach_learning_col_21">
                                <div class="cs_learning_hd_div">
                                    <h2 class="cs_learning_hd">We make <span class="cs_learning_hd_split"> learning</span> flexible & fun </h2>

                                    <p class="cs_learning_content">Because learning flows better without walls</p>
                                </div>
                            </div>
                        </div>

                        <div class="row gj_cs_teach_learning_row_12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 gj_cs_teach_learning_col_22">
                                <div class="cs_learning_img_div">
                                    <img src="{{ public_asset('assets/comming_soon/cs_2.jpg') }}" alt="passion_to_teach_image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- Teach & Learning Section End --}}
        
        {{-- At a Glance Section Start --}}
        <section class="gj_cs_glance_sec">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-5 col-12">
                        <div class="cs_glance_div">
                            <h2 class="cs_glance_hd">At a glance </h2>
                        </div>
                    </div>
                    
                    <div class="col-lg-8 col-md-8 col-sm-7 col-12">
                        <div class="cs_glance_content_div">
                            <p class="cs_glance_content cs_glance_content1">Learning today is no longer confined by walls or rigid schedules. With the freedom to choose the right guide and the flexibility to learn at times that truly fit, education becomes a seamless part of life.</p>

                            <p class="cs_glance_content cs_glance_content2">It’s about opening doors to knowledge without boundaries — creating a space where curiosity leads, growth follows, and learning feels natural and enjoyable.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- At a Glance Section End --}}
        
        {{-- Glance Image Section Start --}}
        <section class="gj_cs_glance_img_sec">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="cs_glance_img_div cs_glance_img_div1">
                            <img src="{{ public_asset('assets/comming_soon/cs_3.jpg') }}" />
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="cs_glance_img_div cs_glance_img_div2">
                            <img src="{{ public_asset('assets/comming_soon/cs_4.jpg') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- Glance Image Section End --}}
        
        {{-- About Us Section Start --}}
        <section class="gj_cs_about_us_sec">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 gj_col1_au">
                        <div class="cs_about_us_img_div">
                            <img src="{{ public_asset('assets/comming_soon/cs_about.jpg') }}" alt="about us"/>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 gj_col2_au">
                        <div class="cs_about_us_content_div">
                            <h2 class="cs_about_us_hd">About us </h2>

                            <p class="cs_about_us_content">V-Tutor brings together Australia-wide tutors on a secure platform designed for personalised, one-to-one learning. With unified session planning, seamless booking and management, and built-in feedback tracking, families gain access to an integrated and interactive tutoring experience that is both unique and effective.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- About Us Section End --}}
        
        {{-- Teach V-Tutor Section Start --}}
        <section class="gj_cs_teach_vtutor_sec">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 gj_col1_tv">
                        <div class="cs_tvtutor_img_div">
                            <img src="{{ public_asset('assets/comming_soon/cs_teach.jpg') }}" alt="teach"/>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 gj_col2_tv">
                        <div class="cs_tvtutor_content_div">
                            <h2 class="cs_tvtutor_hd">Teach with V-Tutor </h2>

                            <p class="cs_tvtutor_content">Reach students across Australia, set your own schedule, and manage everything in one place. With transparent payments, flexible session windows, and dedicated support, V-Tutor gives you the freedom to focus on what matters most—teaching.</p>

                            <div class="cs_tvtutor_smh_button_div">
                                @if(!@Auth::check())
                                    <a href="{{route('tutor_application_form')}}" class="cs_tvtutor_smh_button">Show me how</a>
                                    {{-- <a href="{{route('reg.home')}}" class="cs_tvtutor_smh_button">Show me how</a> --}}
                                @else
                                    <a href="{{route('tutor_application_form')}}" class="cs_tvtutor_smh_button">Show me how</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- Teach V-Tutor Section End --}}
    </div>

    @include('include.common_modal')
@endsection

@section('script')
    @include('include.script')
@endsection


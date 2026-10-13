@extends('layouts.app')
@section('title')
    <title>V-Tutor | Student | Profile</title>
@endsection
@section('left_part')
    {{-- @include('include.student_top_common') --}}
    @include('include.header_menu_part')
    <style>
        .center-button {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .user-right-top .d-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .autocomplete {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }

        #fav_ids {
            position: relative;
        }

        /* Hide overflow so slides don’t bleed into the left menu */
        #fav_ids,
        #fav_ids .owl-stage-outer {
            overflow: hidden !important;
        }

        /* Make sure the carousel uses full width of its column */
        #fav_ids .owl-carousel {
            width: 100%;
        }

        /* Do NOT center the whole carousel with flex on any parent */
        .user-right-top-new,
        .account-area-tutor {
            display: block;
        }

        /* Slide item spacing (optional) */
        #fav_ids .owl-item {
            padding: 0 8px;
            box-sizing: border-box;
        }

        /* Arrows */
        #fav_ids .owl-nav {
            position: absolute;
            top: 45%;
            left: 10px;
            right: 10px;
            pointer-events: none;
        }

        #fav_ids .owl-nav button {
            pointer-events: all;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 50%;
            width: 34px;
            height: 34px;
            line-height: 30px;
            font-size: 18px;
        }

        #fav_ids .owl-nav button.owl-prev,
        #fav_ids .owl-nav button.owl-next {
            position: absolute;
            color: red !important;
            /* force arrow ❮ ❯ to be red */
            font-size: 18px !important;
            /* make arrows bigger if you want */
            background: transparent !important;
            /* remove gray background */
            border: none !important;
            /* remove borders */
            cursor: pointer;
        }

        #fav_ids .owl-nav button.owl-prev {
            left: -18px;
        }

        #fav_ids .owl-nav button.owl-next {
            right: -18px;
        }
    </style>
@endsection
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/@mountainpass/addressr-frontend@1.0.1/dist/index.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@section('content')
    <section class="makes_special_sec faq-sec">
        <div class="makes_special_inr">
            <div class="top_mar"></div>
            <section class="user-account">
                <div class="container">

                    <div class="row">

                        <div class="zin">
                            @include('include.student_left_common')
                            <div class="user-right-panel">
                                <div class="user-right-top">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <h2 class="profile-heading m-0">
                                            Profile

                                        </h2>

                                        <a @if (@Auth::user()->platform_type != null) href="{{ route('student.close.account') }}"
                        onclick="return confirm('We find that you have decided to close the account and we are sorry to see you go! ...')"
                    @else
                        href="#" data-toggle="modal" data-target="#myModalnes" @endif
                                            id="fixed-close-account-link" class="close-account-link text-danger">
                                            Close my Account
                                        </a>
                                    </div>



                                    <a href="#" style="display:none;" id="messageShow" data-toggle="modal"
                                        data-target="#popupModalStudentM1">Message</a>
                                    <a href="#" style="display:none;" id="messageShowUpd" data-toggle="modal"
                                        data-target="#popupModal1Upd">Message</a>
                                    <a href="#" style="display:none;" id="pictureUpdShow" data-toggle="modal"
                                        data-target="#showModalPicShow">Message</a>




                                    {{-- @include('include.errors') --}}
                                    <form method="post" action="{{ route('update.profile') }}" id="frm"
                                        enctype="multipart/form-data">
                                        {{-- Show this fixed link in the top-right corner of the webpage --}}

                                        @csrf


                                        <div class="user-account-info">
                                            <h3>Student Profile</h3>
                                            <div class="row new_rows no-gutters">
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="row new_rows no-gutters">

                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>First Name*</label>
                                                        <input type="text" placeholder="First Name " name="f_name"
                                                            value="{{ @$user->f_name }}" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>Last Name*</label>
                                                        <input type="text" placeholder="Last Name " name="l_name"
                                                            value="{{ @$user->l_name }}" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>Grade*</label>
                                                        @php
                                                            $grade = DB::table('grades')->where('status', 'A')->get();
                                                        @endphp
                                                        <select required name="grade">
                                                            <option value="">Select Grade</option>
                                                            @foreach ($grade as $val)
                                                                <option value="{{ $val->id }}"
                                                                    @if (@$user->grade == $val->id) selected @endif>
                                                                    {{ @$val->grade_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                {{--
                                            <div class="col-md-5 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>School</label>
                                                    <input type="text" placeholder="Where you currently study" name="school" value="{{@$user->school}}" >
                                                </div>
                                            </div>
                                            --}}
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>School<span
                                                                tooltip="If your school is not in the list, choose the closest school address.">*<i
                                                                    class="qus-cir far fa-question-circle"></i></span></label>
                                                        <div class="autocomplete">
                                                            {{-- ,{{ @$user->getSchool}},{{ @$user->getSchool->getState->state_name }},{{ @$user->getSchool->getSuburb->name }},{{ @$user->getSchool->postcode }} --}}
                                                            <input id="school" name="school" type="text"
                                                                placeholder="Type school name" autocomplete="off"
                                                                onfocus="this.removeAttribute('readonly');" readonly=""
                                                                onclick="this.removeAttribute('readonly');"
                                                                onblur="this.removeAttribute('readonly');" autocomplete="off"
                                                                value="@if (@Auth::user()->school) {{ @$user->getSchool->school_name }} @endif">
                                                            <input type="hidden" name="school_id" id="school_id"
                                                                value="{{ @$user->school }}">
                                                            <input type="hidden" name="school_name" id="school_name"
                                                                value="{{ @$user->getSchool->school_name }}">
                                                            <input type="hidden" name="state_name" id="state_name"
                                                                value="{{ @$user->getSchool->getState->state_name }}">
                                                            {{-- <input type="hidden" name="search_tutor_slug_studentclass"  id="search_tutor_slug_studentclass" value="{{ @$vtutor->slug }}"> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 showSchoolInfo">
                                                    <div class="form_box_area">
                                                        <label>State</label>
                                                        <select name="show_school_state" id="show_school_state"
                                                            class="showhiderSchl">
                                                            <option value=""
                                                                @if (@$user->getSchool->state_id == 0) selected @endif>Select State
                                                            </option>
                                                            @if (@$state)
                                                                @foreach ($state as $key => $val)
                                                                    <option value="{{ @$val->id }}"
                                                                        @if (@$user->getSchool->state_id == @$val->id) selected @endif>
                                                                        {{ @$val->state_name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 showSchoolInfo">
                                                    <div class="form_box_area">
                                                        <label>Suburb</label>
                                                        <input type="text" id="show_school_suburb" name="show_school_suburb"
                                                            value="{{ @$user->getSchool->suburb_id }}" class="showhiderSchl">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 showSchoolInfo">
                                                    <div class="form_box_area">
                                                        <label>Postcode</label>
                                                        <input type="text" id="show_school_postcode"
                                                            name="show_school_postcode" value="{{ @$user->getSchool->postcode }}"
                                                            class="showhiderSchl">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 otherschoolnamediv" style="display: none;">
                                                    <div class="form_box_area">
                                                        <label>Other school name*</label>
                                                        <div class="autocomplete">
                                                            <input type="text" name="other_school_name" id="other_school_name"
                                                                value="" class="showhiderSchl">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>Date of Birth*</label>
                                                        <!--<div class="dash-d">
                                                            <input type="text" placeholder="Select Date" id="datepicker"required="">



                                                            <span class="over_llp1"><img src="{{ public_asset('assets/images/cal.png') }}" alt=""></span>



                                                            </div>-->
                                                        <div class="ui calendar">
                                                            <div class="ui input left icon">
                                                                <input type="text" id="dob" name="dob"
                                                                    class="form-control" placeholder="Select date of birth"
                                                                    value="{{ isset($user->dob) && $user->dob ? date('d-m-Y', strtotime($user->dob)) : '' }}"
                                                                    readonly required autocomplete="off">

                                                            </div>
                                                            <label id="dob-error" class="error" for="dob">
                                                                @error('dob')
                                                                    {{ $message }}
                                                                @enderror
                                                            </label>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>Gender*</label>
                                                        <select name="gender" id="gender">
                                                            <option value="">Select Gender</option>
                                                            <option value="M"
                                                                @if (@$user->gender == 'M') selected @endif>Male</option>
                                                            <option value="F"
                                                                @if (@$user->gender == 'F') selected @endif>Female</option>
                                                            <option value="O"
                                                                @if (@$user->gender == 'O') selected @endif>Neither</option>
                                                            <option value="P"
                                                                @if (@$user->gender == 'P') selected @endif>Prefer not to say
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-6 col-sm-6" >
                                                <div class="checkBox new-cus">
                                                    <span>Are you a full-time student?</span>
                                                    <ul style="margin-left: 10px">
                                                        <li class="one_li_check">
                                                            <input type="radio" id="radio1" name="full_time_student" value="Y" @if (@$user->is_full_time == 'Y') checked @endif>
                                                            <label for="radio1" onclick="yes()">Yes</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="radio2" name="full_time_student" value="N"  @if (@$user->is_full_time == 'N') checked @endif>
                                                            <label for="radio2"  onclick="no()">No</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div> --}}
                                                <div class="col-md-12 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>About the student</label>
                                                        <textarea placeholder="Write briefly on what they like, interests, hobbies etc. in about 100 words" name="about_me"
                                                            id="about_me" class="textarea_box ml-0" maxlength="2000">{{ @$user->about_me }}</textarea>
                                                        <div class="error_textarea error"></div>
                                                        <span id="about_err" style="color: red"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="uplodimg text_sm_c">
                                                        <div class="uplodimgfil">
                                                            {{-- <b>Profile Picture</b> --}}
                                                            @php
                                                                $image_path =
                                                                    'assets/images/all_avatars/' . @Auth::user()->profile_pic;
                                                            @endphp
                                                            @if (file_exists(@$image_path))
                                                                <input type="hidden" name="imgSelect" id="imgSelect"
                                                                    value="{{ @Auth::user()->profile_pic }}">
                                                            @else
                                                                <input type="hidden" name="imgSelect" id="imgSelect"
                                                                    value="">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="user-right-top-new ">
                                                        <div class="account-area-tutor mt-0">
                                                            <div class="fav_id" id="fav_ids">
                                                                <div class="owl-carousel">
                                                                    @if (@Auth::user()->profile_pic)
                                                                        @php
                                                                            $image_path =
                                                                                'assets/images/all_avatars/' .
                                                                                @Auth::user()->profile_pic;
                                                                        @endphp
                                                                        @if (file_exists(@$image_path))
                                                                            <div class="item on_select_u  selectedImage "
                                                                                data-picname="{{ @Auth::user()->profile_pic }}"
                                                                                data-src="{{ public_asset('assets/images/all_avatars/' . @Auth::user()->profile_pic) }}">
                                                                                <div class="meet_tutors_items">
                                                                                    <div class="meet_tutors_img">
                                                                                        <span>
                                                                                            <img class="on_select_u_pic"
                                                                                                src="{{ public_asset('assets/images/all_avatars/' . @Auth::user()->profile_pic) }}"
                                                                                                alt=""
                                                                                                data-picname="{{ @Auth::user()->profile_pic }}">
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                    @for ($i = 1; $i <= 43; $i++)
                                                                        @php

                                                                            $image_path =
                                                                                'assets/images/all_avatars/avatar' .
                                                                                $i .
                                                                                '.png';

                                                                        @endphp

                                                                        @if (@Auth::user()->profile_pic != 'avatar' . $i . '.png')
                                                                            <div class="item on_select_u @if (@Auth::user()->profile_pic == 'avatar' . $i . '.png') selectedImage @endif"
                                                                                data-picname="avatar{{ $i }}.png"
                                                                                data-src="{{ public_asset('assets/images/all_avatars/avatar' . $i . '.png') }}">
                                                                                <div class="meet_tutors_items">
                                                                                    <div class="meet_tutors_img">
                                                                                        <span>
                                                                                            <img class="on_select_u_pic"
                                                                                                src="{{ public_asset('assets/images/all_avatars/avatar' . $i . '.png') }}"
                                                                                                alt=""
                                                                                                data-picname="avatar{{ $i }}.png">
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="select_profile_pic">
                                                        <input type="button" name="" value="Update Profile Picture"
                                                            class="sub_btn select_profile_pic_btn sub_btn new-subbtn"
                                                            id="select_profile_pic_btn">
                                                    </div>
                                                    <p class="note error_image selected_image_error"></p>
                                                </div>
                                                <div class="col-md-8 col-sm-6 new-diif"
                                                    @if ($user->is_full_time == 'Y') style="display: none !important;" @endif>
                                                    <div class="checkBox new-cus" id="private_or_homee"
                                                        @if ($user->is_full_time == 'Y') style="display: none !important;" @endif>
                                                        <span>Do you private school or home school?</span>
                                                        <ul>
                                                            <li class="one_li_check">
                                                                <input type="radio" id="radio3" name="private_or_home"
                                                                    value="Y"
                                                                    @if (@$user->private_or_home == 'Y') checked @endif>
                                                                <label for="radio3">Yes</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" id="radio4" name="private_or_home"
                                                                    value="N"
                                                                    @if (@$user->private_or_home == 'Y') checked @endif>
                                                                <label for="radio4">No</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="user-account-info">
                                            <h3>Parent Details</h3>
                                            <div class="row new_rows no-gutters">
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label for="salutation">Salutation*</label>
                                                        <select class="required " name="salutation" id="salutation">
                                                            <option value="">Select Salutation</option>
                                                            <option value="1"
                                                                @if (@$user->salutation == '1') selected="" @endif>Mr.</option>
                                                            <option value="2"
                                                                @if (@$user->salutation == '2') selected="" @endif>Mrs.</option>
                                                            <option value="3"
                                                                @if (@$user->salutation == '3') selected="" @endif>Ms.</option>
                                                            <option value="4"
                                                                @if (@$user->salutation == '4') selected="" @endif>Dr.</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>First Name*</label>
                                                        <input type="text" placeholder="First Name" name="parent_f_name"
                                                            value="{{ @$user->parent_f_name }}" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>Last Name*</label>
                                                        <input type="text" placeholder="Last Name" name="parent_l_name"
                                                            value="{{ @$user->parent_l_name }}" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>Email Address<span
                                                                tooltip="To change or modify email address, kindly message us.">*<i
                                                                    class="qus-cir far fa-question-circle"></i></span></label>
                                                        <input type="email" placeholder="myemailaddress@xyz.com" name="email"
                                                            value="{{ @$user->email }}" disabled
                                                            class="addDisablePhone PointerEventsNone">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>Mobile Number <span
                                                                tooltip="This number may be used to authenticate access requests"><i
                                                                    class="qus-cir far fa-question-circle"></i></span></label>
                                                        <input type="tel" placeholder="" name="ph"
                                                            value="{{ @$user->phone }}" id="ph" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>Date of Birth*</label>
                                                        <div class="ui calendar">
                                                            <div class="ui input left icon">
                                                                <input type="text" id="parent_dob" name="parent_dob"
                                                                    class="form-control" placeholder="Select date of birth"
                                                                    value="{{ isset($user->parent_dob) && $user->parent_dob ? date('d-m-Y', strtotime($user->parent_dob)) : '' }}"
                                                                    readonly required autocomplete="off">

                                                            </div>
                                                            <label id="parent_dob-error" class="error" for="parent_dobdob">
                                                                @error('dob')
                                                                    {{ $message }}
                                                                @enderror
                                                            </label>



                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label for="qualification">Qualification*</label>
                                                        <select class="required " name="qualification" id="qualification">
                                                            <option value="">Select Qualification</option>
                                                            <option value="1"
                                                                @if (@$user->qualification == '1') selected="" @endif>Doctoral
                                                                Degree</option>
                                                            <option value="2"
                                                                @if (@$user->qualification == '2') selected="" @endif>Postgraduate
                                                            </option>
                                                            <option value="3"
                                                                @if (@$user->qualification == '3') selected="" @endif>Master's
                                                                Degree (Research)</option>
                                                            <option value="4"
                                                                @if (@$user->qualification == '4') selected="" @endif>Master's
                                                                Degree</option>
                                                            <option value="5"
                                                                @if (@$user->qualification == '5') selected="" @endif>Bachelor
                                                                Honours Degree</option>
                                                            <option value="6"
                                                                @if (@$user->qualification == '6') selected="" @endif>Bachelor’s
                                                                Degree</option>
                                                            <option value="7"
                                                                @if (@$user->qualification == '7') selected="" @endif>Associate
                                                                Degree</option>
                                                            <option value="8"
                                                                @if (@$user->qualification == '8') selected="" @endif>Advanced
                                                                Diploma</option>
                                                            <option value="9"
                                                                @if (@$user->qualification == '9') selected="" @endif>Diploma
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>Annual Household Income <span
                                                                tooltip="Optional choice for demographic analysis only."><i
                                                                    class="qus-cir far fa-question-circle"></i></span></label>
                                                        <select name="income">
                                                            <option value="A"
                                                                @if (@$user->annual_income == 'A') selected @endif>
                                                                < 100,000</option>
                                                            <option value="B"
                                                                @if (@$user->annual_income == 'B') selected @endif>100,000 –
                                                                150,000</option>
                                                            <option value="C"
                                                                @if (@$user->annual_income == 'C') selected @endif>150,000 –200,000
                                                            </option>
                                                            <option value="D"
                                                                @if (@$user->annual_income == 'D') selected @endif> 200,000 >
                                                            </option>
                                                            <option value="P"
                                                                @if (@$user->annual_income == 'P') selected @endif>Prefer not to
                                                                say</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <h3 class="mb-3">Residential Address</h3>
                                                </div>

                                                @if (isset($bookingDataInformation) && $bookingDataInformation)
                                                    <p class="gj_res_addr_dis_note">*Note: Changing your residential address may impact your current bookings and is therefore restricted. If you need to update your address for valid reasons, please <a href="{{ route('contact.us') }}">Message Us</a> or contact <a href="https://mail.google.com/mail/?view=cm&fs=1&to=support@v-tutor.com.au&cc=academics.admin@v-tutor.com.au" target="_blank"> support@v-tutor.com.au</a> for assistance.</p>
                                                @endif

                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label for="state">State / Territory*</label>
                                                        <select name="state" id="state" style="{{ (isset($bookingDataInformation) && $bookingDataInformation) ? 'pointer-events:none;' : '' }}">
                                                            <option value="">Select State</option>
                                                            @foreach ($state as $st)
                                                                <option value="{{ $st->id }}"
                                                                    data-timezone="{{ $st->time_zone }}"
                                                                    {{ $user->state == $st->id || $user->state_id == $st->id ? 'selected' : '' }}>
                                                                    {{ $st->state_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">

                                                        <label for="suburb_input">Suburb*</label>
                                                        <input type="text"  id="city" name ="city" class="form-control" {{ (isset($bookingDataInformation) && $bookingDataInformation) ? 'readOnly' : '' }}
                                                            placeholder="Type to search for a suburb" autocomplete="off"
                                                            value="{{ @Auth::user()->city }}">
                                                        <input type="hidden" name="suburb_select" id="suburb_select_hidden">
                                                        <div class="error_suburb_select"></div>
                                                    </div>
                                                </div>
                                                {{-- Hidden City Input: This will store the selected suburb name --}}

                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label for="street">Street* </label>
                                                        {{-- <--- NEW: Street field --}}
                                                        <input type="text"  placeholder="e.g., Main Street" name="street" {{ (isset($bookingDataInformation) && $bookingDataInformation) ? 'readOnly' : '' }}
                                                            id="street" value="{{ @Auth::user()->street }}">
                                                        <div class="error_street"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label for="zip">Postcode*</label>
                                                        <input type="text"  minlength="4" maxlength="4" pattern="\d{4}" {{ (isset($bookingDataInformation) && $bookingDataInformation) ? 'readOnly' : '' }}
                                                            placeholder="1234" name="zip" id="zip"
                                                            value="{{ @Auth::user()->zip }}">
                                                        <div class="error_zip"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label>Country*</label>
                                                        <input type="text" name="country" id="country" value="Australia"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form_box_area">
                                                        <label for="time_zone">Time Zone</label>
                                                        <input type="text" id="timezone_id" name="timezone_id"
                                                            class="form-control" value="{{ $user->timezone_id ?? '' }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--div class="btn_3_cc"-->

                                            <div style="display: flex; justify-content: center; align-items: center; width: 100%;">
                                                <input type="submit" value="Save & Update" class="sub_btn new-subbtn">
                                            </div>

                                        </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                </div>
                </div>
            </section>
            <div class="modal res-modal newqusmo" id="myModalnes">
                <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Warning</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body ">
                            <div class="testPro">
                                <div class=" proDiv" id="warningTextDi">
                                    <span class="proclosespan">We are sorry to see you go</span>😔
                                    <h6></h6>
                                    <p>We notice that you have decided to close your account. If there are any issues / concerns
                                        that you would like to share or discuss, kindly <a
                                            href="{{ route('contact.us') }}">message us</a>. Our backend team will review and
                                        respond over email or give you a call, if needed.</p>
                                    <p>We require your account password to validate closure! Please be aware that this process is
                                        not reversible. Any data on this user account will be retained as per our policies and
                                        purged after a certain date. For more details, review our <a
                                            href="{{ url('privacy-policy') }}" target="_blank" class="link_color">Privacy
                                            Policy</a></p>
                                    <p class="tutoracademiccor academic_team_bold">Academics Team</p>
                                    <div class="next-btn1 newst_btn-pop">
                                        <button type="button" class="btn btn-new btn-danger float-left change-new-link"
                                            id="nextValueShow">Yes, please close</button>
                                        <button type="button" class="btn btn-new btn-danger " data-dismiss="modal">No, don’t
                                            close </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="appome_input form_box_area cls2 " id="passwordForm" style="display:none;">
                                    <form action="{{ route('student.close.account') }}" id="checkPassword" method="post">
                                        @csrf
                                        <span class="form_box_area mt-2" id="abcd">
                                            <label>Enter Password </label>
                                            <span class="autocomplete">
                                                <input id="mypassword" type="password" name="mypassword"
                                                    placeholder="Enter your password" autocomplete="off" required=""
                                                    class="required">
                                            </span>
                                        </span>
                                        <div class="next-btn1 newst_btn-pop">
                                            <button type="submit" class="btn btn-new btn-danger change-new-link">Submit</button>
                                        </div>
                                    </form>
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
    <div class="modal res-modal newqusmo studentUpdatePopupModal" id="showModalPicShow">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="dvpro">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Profile Pic</h4>
                        <button type="button" class="close" id="popupModalcloseSh" data-dismiss="modal"
                            onclick="modalHideSh()">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body ">
                        <div class="testPro">
                            <div class="proDiv">
                                <h6>Your profile pic is now set</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- pro update --}}

    {{--
<div class="modal res-modal newqusmo" id="showModalPicShow">
    <div class="modal-dialog modal-dialog-centered divPoMW">
        <div class="modal-content">
            <div class="dvpro">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Profile Pic</h4>
                    <button type="button" class="close" id="popupModalcloseSh" data-dismiss="modal" onclick="modalHideSh()">&times;</button>
                </div>
                <div class="modal-body ">
                    <div class="testPro">
                        <div class="proDiv">
                            <p>Your profile pic is now set. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div> --}}
    {{-- feedback 21-12-2021 --}}
    <div class="modal res-modal newqusmo" id="popupModalStudentM1">
        <div class="modal-dialog modal-dialog-centered divPoMW">
            <div class="modal-content">
                <div class="dvpro">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Welcome to V-Tutor!</h4>
                        <button type="button" class="close" id="popupModalcloseM1" data-dismiss="modal"
                            onclick="modalHideM1()">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body ">
                        <div class="testPro">
                            <div class="proDiv">
                                <h6><strong>Congrats on your first login!</strong></h6>
                                <p>Please fill in your profile details to access other sections. </p>
                                <p>Wishing you all the best! </p>
                                {{--
                            <p class="student_pro_p">Regards,</p>
                            --}}
                                <p class="academic_team_bold">Academics Team.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- when update --}}
    <div class="modal res-modal newqusmo" id="popupModal1Upd">
        <div class="modal-dialog modal-dialog-centered divPoMW">
            <div class="modal-content">
                <div class="dvpro">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Welcome to V-Tutor!</h4>
                        <button type="button" class="close" id="popupModalclose1Upd" data-dismiss="modal"
                            onclick="modalHide1Upd()">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body ">
                        <div class="testPro">
                            <div class="proDiv">
                                {{--
                            <h6>Welcome to V-Tutor! Congrats on your login!</h6>
                            --}}
                                @php
                                    $myGrade = \App\Models\Grade::where(['id' => @Auth::user()->grade, 'status' => 'A'])
                                        ->select('id', 'slug', 'status')
                                        ->first();
                                    $myState = \App\Models\State::where(['id' => @Auth::user()->state])->first();
                                @endphp

                                <p>Your profile is complete — you’re all set to begin. </p>

                                <p>Use <a href="{{ url('tutor-search-result?grade=' . @$myGrade->slug) }}"
                                        class="red_link">Book a Session</a> to find tutors for your child’s subjects, and tap View Profile to learn more about each tutor before you book.</p>

                                <p>We’d love your feedback after each session to help us improve your experience. </p>

                                <p>If you need anything, just reach out via <a href="{{ route('contact.us') }}" class="red_link">Message Us</a></p>

                                <p>Wishing your child a great learning journey ahead!  </p>

                                {{-- <p>Congratulations on completing your profile — you’re all set to explore the Student
                                    module!</p>
                                <p>Start by clicking <a href="{{ url('tutor-search-result?grade=' . @$myGrade->slug) }}"
                                        class="red_link">'Book my Class'</a> to find tutors for your grade and subjects.
                                </p>
                                <p>Click “View Profile” to learn more about each tutor before booking. </p>
                                <p>After every session, please share your feedback — it helps us improve and support you
                                    better.</p>
                                <p>Need help? Visit<a href="{{ route('contact.us') }}" class="red_link">Support → Message
                                        Us</a> section.
                                </p>
                                <p>We’re excited to have you onboard and wish you the very best in your learning journey !
                                </p> --}}
                                {{--
                            <p class="student_pro_p">Regards,</p>
                            --}}
                                <p class="academic_team_bold">Academics Team</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    @include('include.script')
    <script>
        document.getElementById('state').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById('timezone_id').value = selectedOption.getAttribute('data-timezone');
        });
    </script>
    <script>
        flatpickr("#dob", {
            dateFormat: "d-m-Y",
            maxDate: "today",
        });
    </script>
    <script>
        flatpickr("#parent_dob", {
            dateFormat: "d-m-Y",
            maxDate: "today",
        });
    </script>

    <script>
        function modalHideSh() {
          //  $("#showModalPicShow").hide();
        }
        $('#exampledate').calendar({
            type: 'date',
            maxDate: new Date({{ strtotime(date('Y-m-d H:i:s')) }} * 1000),
        });
        $('#exampledate_parent_dob').calendar({
            type: 'date',
            maxDate: new Date({{ strtotime(date('Y-m-d H:i:s')) }} * 1000),
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {



            var stateSelect = document.getElementById('state');

            const suburbInput = document.getElementById('suburb_input');

            const suburbHidden = document.getElementById('suburb_select_hidden');

            const pincodeInput = document.getElementById('zip');

            const cityInput = document.getElementById('city');

            const timezoneInput = document.getElementById('timezone_id');

            // Make sure jQuery UI is loaded

            if (typeof $.fn.autocomplete === 'undefined') {

                console.error('jQuery UI Autocomplete is not loaded. Please include the library.');

                return;

            }

            const updateStudentProfileButton = document.getElementById('updateStudentProfile');

            const passwordModalBtn = document.getElementById('modal_pass_btn');

            const form = document.getElementById('frm');

            $('#suburb-input').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: API_SUBURB_URL,
                        method: 'GET',
                        dataType: 'json',
                        xhrFields: {
                            withCredentials: true
                        },
                        success: function(data) {
                            if (data && data.success && data.data.length) {
                                console.log('✅ Suburbs loaded:', data.data);
                                response(data.data); // <-- send data back to autocomplete
                            } else {
                                console.log('ℹ️ No suburbs available.');
                                response([]); // empty list for autocomplete
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('❌ Error fetching suburbs:', status, error);
                            console.log('Response text:', xhr.responseText.slice(0, 200));
                            response([]); // fail gracefully
                        }
                    });
                },
                select: function(event, ui) {

                    // This function is called when a user selects an item

                    suburbInput.value = ui.item.value;

                    suburbHidden.value = ui.item.value; // Set the hidden suburb field

                    zip.value = ui.item.pincode; // Set the hidden postcode field

                    cityInput.value = ui.item.value; // Update the city field



                    // Prevent the input from being filled with the label

                    event.preventDefault();

                }

            });


            // Handle state change event
            $(stateSelect).on('change', function() {

                const selectedOption = this.options[this.selectedIndex];

                const timezone = selectedOption.getAttribute('data-timezone');

                timezoneInput.value = timezone || '';



                // Clear the suburb fields when the state changes

                suburbInput.value = '';

                suburbHidden.value = '';

                zip.value = '';

                cityInput.value = '';

            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $('#fav_ids .owl-carousel').owlCarousel({

                rtl: true, // ← right-to-left movement

                loop: true,

                margin: 0,

                nav: true,

                dots: false,

                navText: ['&#10095;', '&#10094;'], // left / right arrows

                smartSpeed: 450,

                autoWidth: false,

                stagePadding: 0,

                // responsiveBaseElement: '#fav_ids',

                responsive: {

                    0: {
                        items: 1
                    },

                    350: {
                        items: 2
                    },

                    490: {
                        items: 3
                    },

                    992: {
                        items: 6
                    },

                    1200: {
                        items: 6
                    }

                }

            });



            @if (@Auth::user()->is_login == '0')
                $("#messageShow").trigger("click");
                // $("#popupModalStudentM1").show();
            @else
                @if (session()->has('success') || session()->has('error') || $errors->any())
                    @if (@Auth::user()->grade != 0)
                        @if (@session('update_first') == 0)
                            $("#messageShowUpd").trigger("click");
                        @else
                            $("#popupModal").modal('show');
                        @endif

                        // $("#popupModal1Upd").show();
                    @endif
                @endif
            @endif



            jQuery.validator.addMethod("emailonly", function(value, element) {
                return this.optional(element) || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(
                    value.toLowerCase());
            }, "Enter valid email");
            jQuery.validator.addMethod("mobileonly", function(value, element) {
                return this.optional(element) || /^[+]?\d+$/.test(value.toLowerCase());
            }, "Enter valid number");

            // select avatar
            // $(document).on("click","#myProfileCloseSubmitBtn",function(){
            $(document).on("click", ".on_select_u", function() {
                $(".selectedImage").removeClass("selectedImage");
                $("#img2").attr('src', $(this).attr("data-src"));
                $("#imgSelect").val($(this).attr("data-picname"));
                $(".selectedImage").removeClass("selectedImage");
                $(this).addClass("selectedImage");
            });

            // update avatar
            $(document).on("click", "#select_profile_pic_btn", function() {
                var profile_pic_val = $("#imgSelect").val();
                // var profile_pic = $("#imgSelect").attr("data-picname");
                if (profile_pic_val != "") {
                    uploadAvatar(profile_pic_val);

                } else {
                    $(".selected_image_error").html("Please select avatar");
                }
            });

            function uploadAvatar(profile_pic_val) {
                var reqData = {
                    'jsonrpc': '2.0',
                    '_token': '{{ csrf_token() }}',
                    'data': {
                        'profile_pic': profile_pic_val
                    }
                };

                $.ajax({
                    url: "{{ route('student.avatar.update') }}",
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success: function(resp) {
                        if (resp.s == 1) {
                            // var imgP = "{{ url('/assets/images/all_avatars') }}/" + profile_pic_val;
                            var imgP = "{{ public_asset('assets/images/all_avatars/') }}/" + profile_pic_val;
                            $(".selected_avatar_upd").attr("src", imgP);
                            $(".user-left .user-left-top em img").attr("src", imgP);

                            $("#pictureUpdShow").trigger("click");
                            /* setTimeout(function() {
                                window.location.reload();
                            }, 400); */
                        }
                        // $(".selected_image_error").html(resp.message);

                        // location.reload();
                    }
                });

            }
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
                    grade: {
                        required: true,
                    },
                    suburb: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    state: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    zip: {
                        required: true,
                        number: true,
                        minlength: 4,
                        maxlength: 4
                    },
                    show_school_postcode: {
                        number: true,
                        minlength: 4,
                        maxlength: 4
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



                    // ph:{



                    //      required:true,



                    //      mobileonly:true,



                    //      minlength:10,



                    //      maxlength:10,



                    //      remote: {



                    //   url:  '{{ route('check.mobile.two') }}',



                    //   type: "get",



                    //   data: {



                    //     ph: function() {



                    //       return $( "#ph" ).val();



                    //     }



                    //   }



                    // }



                    // },



                    dob: {



                        required: true,







                    },



                    //  school:{



                    //     required:true,



                    //     minlength:5,







                    // },



                    gender: {



                        required: true,







                    },










                    parent_f_name: {



                        required: true,



                        minlength: 3,



                    },



                    parent_l_name: {



                        required: true,



                        minlength: 3,







                    },



                    //  income:{



                    //     required:true,







                    // },



                },



                messages: {



                    // ph:{



                    //     required:'Please a valid 10 digit mobile number',



                    //     minlength:'Mobile number can have minimum 10 digits',



                    //     maxlength:'Mobile number can have maximum 10 digits',



                    //     mobileonly:'Enter a valid 10 digit mobile number',



                    //     remote:"This mobile number already exists.!",



                    // },



                    // email:{



                    //     remote:'Email address is in use. Login or use a different one'



                    // }



                },



                submitHandler: function(form) {
                    var badWords = [];
                    @php
                        $badwords = \DB::table('bad_words')->pluck('words')->toArray();
                    @endphp
                    @foreach (@$badwords as $value)
                        badWords.push('{{ $value }}');
                    @endforeach
                    // console.log(badWords);
                    var wordInput = textarea.val();
                    wordInput = wordInput.toLowerCase();
                    var arr = wordInput.split(" ");
                    var foundBadWords = arr.filter(el => badWords.includes(el));

                    if (foundBadWords.length > 0) {
                        $(".error_textarea").html(
                            'Kindly refrain from using email, phone or flagged words on the description!'
                            );
                        textarea.val("");
                        return false;

                    }

                    // email & phone word
                    var flaggedWord = ['email', 'phone'];
                    var wordInput = textarea.val();
                    wordInput = wordInput.toLowerCase();
                    var arr = wordInput.split(" ");
                    var foundFlaggedWords = arr.filter(el => flaggedWord.includes(el));

                    if (foundFlaggedWords.length > 0) {
                        textarea.val("");
                        $(".error_textarea").html(
                            'Kindly refrain from using email, phone or flagged words on the description!'
                            );
                        return false;
                    } else {
                        var v = textarea.val();
                        if (v != "") {
                            $(".error_textarea").html('');
                        }

                    }


                    var textareas = $('#about_me').val();
                    var words = $.trim(textareas).length ? textareas.match(/\S+/g).length : 0;
                    if (words == 0) {
                        form.submit();
                    } else if (words > 200) {
                        $("#about_err").html('Please enter maximum 200 words');
                        return false;
                    } else {
                        form.submit();
                    }
                },



            });

            $('#gradeform').on('keyup keypress keydown', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
            // $("#myProfileCloseSubmitBtn").click(function(){


            // });

            $(document).on("keyup", "#school", function() {
                if ($.trim($(this).val()) == "") {
                    $(".otherschoolnamediv").hide();
                    $("#other_school_name").removeClass("required");
                    $("#show_school_state").val("");
                    $("#show_school_postcode").val("");
                    $("#show_school_suburb").val("");
                    $(".showhiderSchl").attr("disabled", true);
                    $(".showhiderSchl").attr("readonly", true);
                    $(".showhiderSchl").removeClass("required");
                }
                // var school = $.trim($("#school").val());
                // if(school_id == 0){
                //     $(".otherschoolnamediv").show();
                // }else{
                //     $(".otherschoolnamediv").hide();
                // }

            });
            $(document).on("blur", "#school", function() {
                if ($.trim($("#school_name").val()) != $.trim($(this).val())) {
                    $(this).val("");
                }
                var school = $.trim($("#school").val());
                var school_id = $.trim($("#school_id").val());

                if (school_id == 0) {
                    $(".otherschoolnamediv").show();
                    $("#other_school_name").addClass("required");
                    $("#show_school_state").val("");
                    $("#show_school_postcode").val("");
                    $("#show_school_suburb").val("");
                    $(".showhiderSchl").attr("disabled", false);
                    $(".showhiderSchl").attr("readonly", false);
                    $(".showhiderSchl").addClass("required");

                } else {
                    $(".otherschoolnamediv").hide();
                    $("#other_school_name").removeClass("required");
                    $(".showhiderSchl").attr("disabled", true);
                    $(".showhiderSchl").attr("readonly", true);
                    $(".showhiderSchl").removeClass("required");

                }
            });
            // Check if the required elements exist

            // $(document).on("change","#school",function(){
            //     var school_id = $.trim($("#school_id").val());
            //     var school = $.trim($("#school").val());
            //     if(school_id == 0){
            //         $(".otherschoolnamediv").show();
            //     }else{
            //         $(".otherschoolnamediv").hide();
            //     }
            // });


        });
    </script>

    <!--script>
        $('#address').on('input', function () {
            let query = $(this).val();

            if (query.length < 3) return;

            $.ajax({
                url: "{{ route('fetch.address') }}",
                method: 'GET',
                data: { q: query },
               success: function (data) {
        $('#address-suggestions').remove();

        if (!Array.isArray(data)) {
            console.error("Expected array, got:", data);
            return;
        }

        let list = $('<ul id="address-suggestions" class="list-group position-absolute w-100" style="z-index:999;"></ul>');
        data.forEach(function (item) {
            list.append(`<li class="list-group-item list-group-item-action" data-sla="${item.sla}">${item.sla}</li>`);
        });

        $('#address').after(list);
    }
            });
        });

     $(document).on('click', '#address-suggestions li', function () {
        const selected = $(this).data('sla');
        $('#address').val(selected);

        // Example selected: "4 HAYMAN AV, SEAFORD VIC 3198"
        const addressRegex = /^(.*?),\s*(.*?)\s+([A-Z]{2,3})\s+(\d{4})$/;
        const match = selected.match(addressRegex);

        if (match) {
            const street = match[1];          // "4 HAYMAN AV"
            const city = match[2];            // "SEAFORD"
            const stateAbbr = match[3];       // "VIC"
            const postcode = match[4];        // "3198"

            // Set form fields
            $('#street').val(street);
            $('#city').val(city);
            $('#zip').val(postcode);

            const stateMap = {
                'NSW': 1,
                'VIC': 2,
                'QLD': 3,
                'WA': 4,
                'SA': 5,
                'TAS': 6,
                'NT': 7,
                'ACT': 8,
            };

            $('#state').val(stateMap[stateAbbr] || '');
        } else {
            console.error('Address format not recognized:', selected);
        }

        $('#address-suggestions').remove();
    });



        $(document).on('click', function (e) {
            if (!$(e.target).closest('#address, #address-suggestions').length) {
                $('#address-suggestions').remove();
            }
        });
    </script-->

    <script>
        function yes() {



            //$(".new-diif").slideDown();();



            $("#private_or_home").hide(3);



            //alert('k');



        }







        function no() {



            $("#private_or_homee").show();



            //alert('k2');



        }



        function fun() {



            var i = document.getElementById('file-1').files[0];



            console.log(i);



            var b = URL.createObjectURL(i);



            $(".review_img").show();



            $("#img2").attr("src", b);



        }
    </script>
    <script type="text/javascript">
        function check() {
            // $(".error_textarea").html('');
            var badWords = [];
            @php
                $badwords = \DB::table('bad_words')->pluck('words')->toArray();
            @endphp
            @foreach (@$badwords as $value)
                badWords.push('{{ $value }}');
            @endforeach
            // console.log(badWords);
            badWords.push('email');
            badWords.push('phone');
            badWords.push('reach');
            badWords.push('call');
            badWords.push('gmail');
            badWords.push('.net');
            badWords.push('.com');
            var wordInput = textarea.val();
            wordInput = wordInput.toLowerCase();
            var arr = wordInput.split(" ");
            var foundBadWords = arr.filter(el => badWords.includes(el));

            if (foundBadWords.length > 0) {
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");
                return false;
            }
            var wordInput = textarea.val();
            wordInput = wordInput.toLowerCase();
            var arr = wordInput.split(" ");

            $.each(arr, function(_, t) {
                if (/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(t.toLowerCase())) {
                    $(".error_textarea").html(
                        'Kindly refrain from using email, phone or flagged words on the description!');
                    textarea.val("");
                }

                if (/^[+]?\d+$/.test(t.toLowerCase()) && t.length == 10) {
                    $(".error_textarea").html(
                        'Kindly refrain from using email, phone or flagged words on the description!');
                    textarea.val("");
                }

                // if(t.match("\d{10}")){
                //     $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                //     textarea.val("");
                // }
            });
            // var wordInput = textarea.val();
            // wordInput = wordInput.toLowerCase();
            // var arr = wordInput.split(" ");
            // var foundBadWords = arr.filter(el => badWords.includes(el));

            // if(foundBadWords.length>0){
            //     $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
            //     textarea.val("");

            // }

            // email & phone word
            // var flaggedWord = ['email','phone'];
            // var wordInput = textarea.val();
            // wordInput = wordInput.toLowerCase();
            // var arr = wordInput.split(" ");
            // var foundFlaggedWords = arr.filter(el => flaggedWord.includes(el));

            // if(foundFlaggedWords.length>0){
            //     textarea.val("");
            //     $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
            // }else{
            //     var v = textarea.val();
            //     if(v != ""){
            //         $(".error_textarea").html('');
            //     }

            // }

        }
        var textarea = $('.textarea_box');
        textarea.on({
            keyup: function(e) {

                if (e.which === 188) check();
                if (e.which === 32) check();

                var words = 0;
                if ((this.value.match(/\S+/g)) != null) {
                    words = this.value.match(/\S+/g).length;
                }
                if (words > 100) {
                    var trimmed = $(this).val().split(/\s+/, 100).join(" ");
                    $(this).val(trimmed + " ");
                }
            },
            blur: check
        });
        $("#checkPassword").validate();
        $("#checkPro").click(function() {
            if (confirm(
                    'We find that you have decided to close the account and we are sorry to see you go! We may need your account password to validate closure! If you have any issues / concerns that you would like to share, kindly use the Complaints link . Please be aware that this process is irreversible. Any data on this account will be retained as per our privacy policy and purged after a certain time'
                    )) {
                $("#checkPassword").submit();
            }
        });

        function validate(evt) {
            var theEvent = evt || window.event;
            // Handle paste
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]/;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    </script>
    <script type="text/javascript">
        function datastudentautocomplete(inp, arr) {
            var currentFocus;

            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                closeaAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                this.parentNode.appendChild(a);

                $.ajax({
                    url: "{{ route('get.all.schools') }}",
                    dataType: 'json',
                    data: {
                        "search_school_name": val
                    },
                    type: 'GET',
                    success: function(resp) {
                        for (i = 0; i < resp.schools.length; i++) {
                            if ((resp.schools[i].school_name + " , " + resp.schools[i].get_state
                                    .state_name + " , " + resp.schools[i].suburb_id + "," + resp
                                    .schools[i].postcode).substr(0, val.length).toUpperCase() == val
                                .toUpperCase()) {
                                b = document.createElement("DIV");
                                /* b.innerHTML = "<strong>" + (resp.schools[i].school_name + "," + resp
                                    .schools[i].get_state.state_name + " , " + resp.schools[i]
                                    .suburb_id + "," + resp.schools[i].postcode).substr(0, val
                                    .length) + "</strong>"; */
                                b.innerHTML = "<strong>" + resp.schools[i].school_name + "</strong>";
                                /* b.innerHTML += (resp.schools[i].school_name + "," + resp.schools[i]
                                    .get_state.state_name + " , " + resp.schools[i].suburb_id +
                                    "," + resp.schools[i].postcode).substr(val.length); */
                                b.innerHTML += "<input type='hidden' data-sid='" + resp.schools[i].id +
                                    "' id='" + resp.schools[i].id + "' value='" + resp.schools[i]
                                    .school_name + ' ' + resp.schools[i].get_state.state_name + ' ' +
                                    resp.schools[i].suburb_id + ' ' + resp.schools[i].postcode +
                                    "' data-state_name='" + resp.schools[i].get_state.state_name +
                                    "' data-postcode='" + resp.schools[i].postcode + "' data-suburb='" +
                                    resp.schools[i].suburb_id + "' data-state_id='" + resp.schools[i]
                                    .state_id + "'>";
                                b.addEventListener("click", function(e) {
                                    inp.value = this.getElementsByTagName("input")[0].value;
                                    $("#school_id").val(this.getElementsByTagName("input")[0]
                                        .id);
                                    $("#school_name").val(this.getElementsByTagName("input")[0]
                                        .value);
                                    var schl_state_name = $("#" + this.getElementsByTagName(
                                        "input")[0].id).attr("data-state_name");
                                    var schl_state_id = $("#" + this.getElementsByTagName(
                                        "input")[0].id).attr("data-state_id");
                                    var schl_postcode = $("#" + this.getElementsByTagName(
                                        "input")[0].id).attr("data-postcode");
                                    var schl_suburb = $("#" + this.getElementsByTagName(
                                        "input")[0].id).attr("data-suburb");

                                    // Populate the fields
                                    $("#show_school_state").val(schl_state_id);
                                    $("#show_school_suburb").val(schl_suburb);
                                    $("#show_school_postcode").val(schl_postcode);

                                    var school_id = $.trim($("#school_id").val());
                                    if (school_id == 0) {
                                        $(".otherschoolnamediv").show();
                                        $("#show_school_state").val("");
                                        $("#show_school_postcode").val("");
                                        $("#show_school_suburb").val("");
                                        $(".showhiderSchl").attr("disabled", false);
                                        $(".showhiderSchl").attr("readonly", false);
                                        $(".showhiderSchl").addClass("required");
                                    } else {
                                        $(".otherschoolnamediv").hide();
                                        $(".showhiderSchl").attr("disabled", true);
                                        $(".showhiderSchl").attr("readonly", true);
                                        $(".showhiderSchl").removeClass("required");
                                    }
                                    closeaAllLists();
                                });
                                a.appendChild(b);
                            }
                        }
                        b = document.createElement("DIV");
                        b.innerHTML = "<strong>" + ("Other") + "</strong>";
                        b.innerHTML += "<input type='hidden' data-sid='" + 0 + "' id='" + 0 +
                            "' value='" + 'Other' + "'>";
                        b.addEventListener("click", function(e) {
                            inp.value = this.getElementsByTagName("input")[0].value;
                            $("#school_id").val(0);
                            $("#school_name").val("Other");
                            $("#other_school_name").addClass("required");
                            var school_id = $.trim($("#school_id").val());
                            if (school_id == 0) {
                                $(".otherschoolnamediv").show();
                                $("#show_school_state").val("");
                                $("#show_school_postcode").val("");
                                $("#show_school_suburb").val("");
                                $(".showhiderSchl").attr("disabled", false);
                                $(".showhiderSchl").attr("readonly", false);
                                $(".showhiderSchl").addClass("required");
                            } else {
                                $(".otherschoolnamediv").hide();
                                $("#show_school_state").val("");
                                $("#show_school_postcode").val("");
                                $("#show_school_suburb").val("");
                                $(".showhiderSchl").attr("disabled", true);
                                $(".showhiderSchl").attr("readonly", true);
                                $(".showhiderSchl").removeClass("required");
                            }
                            closeaAllLists();
                        });
                        a.appendChild(b);
                    },
                    error: function() {}
                });
            });

            function closeaAllLists(elmnt) {
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            document.addEventListener("click", function(e) {
                closeaAllLists(e.target);
            });
        }
        datastudentautocomplete(document.getElementById("school"), []);
    </script>
    <script type="text/javascript">
        function modalHideM1() {
            $("#popupModalStudentM1").hide();
        }

        function modalHide1Upd() {
            $("#popupModal1Upd").hide();
        }
        $(document).on("click", "#nextValueShow", function() {
            $("#myModalnes").addClass("studentUpdatePopupModal");
        });
    </script>
@endsection

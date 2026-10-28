@php
    $QualificationAr = [
        '1' => 'Certificate I',
        '2' => 'Certificate II',
        '3' => 'Certificate III',
        '4' => 'Certificate IV',
        '5' => 'Diploma',
        '6' => 'Advanced Diploma',
        '7' => 'Vocational Graduate Certificate',
        '8' => 'Vocational Graduate Diploma',
        '9' => 'Associate Degree',
        '10' => 'Bachelor’s Degree',
        '11' => 'Bachelor Honours Degree',
        '12' => 'Graduate Certificate',
        '13' => 'Graduate Diploma',
        '14' => 'Master’s Degree',
        '15' => 'Doctoral Degree / PhD',
    ];
@endphp

@extends('layouts.app')

@section('page_title', 'V-Tutor | Online Tutors Search Results Australia')
@section('meta_description', 'Find qualified online tutors in Australia for Maths, Science, and English. Browse V-Tutor’s online tutoring platform for verified tutors and flexible learning options.')
@section('meta_keywords', 'online tutoring Australia, search tutors, online tutors, qualified tutors, Maths tutors, Science tutors, English tutors, tutoring platform Australia')

@section('og_title', 'V-Tutor | Online Tutors Search Results Australia')
@section('og_description', 'Browse search results on V-Tutor for online tutors in Australia. Find verified Maths, Science, and English tutors for personalised online tutoring.')
@section('og_image', asset('images/vtutor-og-image.jpg'))

@section('twitter_title', 'V-Tutor | Online Tutors Search Results Australia')
@section('twitter_description', 'Find verified online tutors in Australia for Maths, Science, and English through V-Tutor’s online tutoring platform.')
@section('twitter_image', asset('images/vtutor-og-image.jpg'))

@section('canonical', url()->current())
@section('language', 'en-au')

@section('left_part')
    @include('include.header_menu_part')
@endsection
@section('content')
    <section class="makes_special_sec faq-sec">
        <div>
            <div class="makes_special_inr">
                <div class="top_mar"></div>
                <div class="user-account">
                    <div class="container">
                        <div class="zin">
                            <div class="user-left sticky_left w-25">
                                <div class="mobile_filter_as"> <i class="fa fa-bars" aria-hidden="true"></i>
                                    <span>Show Filter</span>
                                </div>
                                <div class="dasbordLeft">
                                    <div class="user-left-info">
                                        <div class="user-left-top d-flex justify-content-between align-items-center py-3">
                                            <h5 class="m-0">Grade </h5>
                                            <a href="{{ route('search.result.j') }}">
                                                <span class="d-flex align-items-center">
                                                    <img src="{{ public_asset('assets/images/filtar.png') }}" alt=""
                                                        class="px-2">
                                                    Re-adjust
                                                </span>
                                            </a>
                                        </div>


                                        <div class="user-left-bottom px-3">
                                            <form action="{{ route('search.result.j') }}" method="get"
                                                id="searchVtutorForm">
                                                <div class="search_le_selt">

                                                    <select name="grade" id="grade" class="change_apply">
                                                        <option value="">Select Grade</option>
                                                        @foreach ($grades as $grade)
                                                            <option value="{{ $grade->slug }}"
                                                                {{ request('grade') == $grade->slug ? 'selected' : '' }}>
                                                                {{ $grade->grade_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="search_le_check_bx">
                                                    <div class="search_le_selt">
                                                        <h5>Subjects</h5>

                                                        <select id="branch_id" name="branch_id[]" class="change_apply">
                                                            <option value="">Select Subject</option>

                                                            @if (!empty($branches) && is_iterable($branches))
                                                                @foreach ($branches as $branch)
                                                                    <option value="{{ $branch->slug }}"
                                                                        @if (!empty($branch_slugs) && in_array($branch->slug, $branch_slugs)) selected @endif>
                                                                        {{ $branch->branch_name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- <div class="search_le_check_bx search_le_redio_bx">
                                                    <h5>Tutor experience</h5>
                                                    <ul>
                                                        <li><input id="exp_0-1" name="experience" type="radio"
                                                                class="click_apply" onclick="searchResults();"> <label
                                                                for="exp_0-1">0–1 years</label></li>
                                                        <li><input id="exp_1-3" name="experience" type="radio"
                                                                class="click_apply" onclick="searchResults();"> <label
                                                                for="exp_1-3">1–3 years</label></li>

                                                    </ul>
                                                    <ul class="moretext5" style="display:none;">
                                                        <li><input id="exp_3-5" name="experience" type="radio"
                                                                class="click_apply" onclick="searchResults();"> <label
                                                                for="exp_3-5">3–5 years</label></li>
                                                        <li><input id="exp_5" name="experience" type="radio"
                                                                class="click_apply" onclick="searchResults();"> <label
                                                                for="exp_5">5 years and above</label></li>
                                                    </ul>
                                                    <a class="moreless-button5" href="javascript:void(0)">More+</a>
                                                </div> --}}

                                                <div class="search_le_check_bx search_le_redio_bx">
                                                    <h5>Availability</h5>
                                                    @php
                                                        $w_days = ['1' => 'Mon', '2' => 'Tue', '3' => 'Wed', '4' => 'Thu', '5' => 'Fri', '6' => 'Sat', '7' => 'Sun'];
                                                        // dd($request['availability']);
                                                    @endphp
                                                    <ul>
                                                        @foreach ($w_days as $dk => $dv)
                                                            <li>
                                                                <input id="exp_0-{{ $dk }}" name="availability[]" type="checkbox"
                                                                    value="{{ $dk }}" class="click_apply"
                                                                    onclick="searchResults();"
                                                                    {{ !empty($request['availability']) && in_array($dk, $request['availability']) ? 'checked' : '' }}>
                                                                <label for="exp_0-{{ $dk }}">{{ $dv }}</label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                
                                                {{-- 13-11-25 --}}
                                                {{-- <div class="search_le_check_bx search_le_redio_bx">
                                                    <h5>Tutor experience</h5>
                                                    <ul>
                                                        <li>
                                                            <input id="exp_0-1" name="experience" type="radio"
                                                                value="0-1" class="click_apply"
                                                                onclick="searchResults();"
                                                                {{ request('experience') == '0-1' ? 'checked' : '' }}>
                                                            <label for="exp_0-1">0–1 years</label>
                                                        </li>
                                                        <li>
                                                            <input id="exp_1-3" name="experience" type="radio"
                                                                value="1-3" class="click_apply"
                                                                onclick="searchResults();"
                                                                {{ request('experience') == '1-3' ? 'checked' : '' }}>
                                                            <label for="exp_1-3">1–3 years</label>
                                                        </li>
                                                    </ul>

                                                    <ul class="moretext5"
                                                        style="{{ in_array(request('experience'), ['3-5', '5']) ? '' : 'display:none;' }}">
                                                        <li>
                                                            <input id="exp_3-5" name="experience" type="radio"
                                                                value="3-5" class="click_apply"
                                                                onclick="searchResults();"
                                                                {{ request('experience') == '3-5' ? 'checked' : '' }}>
                                                            <label for="exp_3-5">3–5 years</label>
                                                        </li>
                                                        <li>
                                                            <input id="exp_5" name="experience" type="radio"
                                                                value="5" class="click_apply"
                                                                onclick="searchResults();"
                                                                {{ request('experience') == '5' ? 'checked' : '' }}>
                                                            <label for="exp_5">5 years and above</label>
                                                        </li>
                                                    </ul>

                                                    <a class="moreless-button5" href="javascript:void(0)">More+</a>
                                                </div> --}}



                                                <div class="search_le_check_bx search_le_redio_bx">
                                                    <h5>Ratings</h5>
                                                    <ul>
                                                        <li>
                                                            <input id="radios4" type="radio" value="4"
                                                                name="review"
                                                                @if (@$review_value == 4) checked="" @endif
                                                                class="click_apply" onclick="searchResults();">
                                                            <label for="radios4">
                                                                <span>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                </span>
                                                                <strong>(4 and Above)</strong>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <input id="radios5" type="radio" value="3"
                                                                name="review"
                                                                @if (@$review_value == 3) checked="" @endif
                                                                class="click_apply">
                                                            <label for="radios5">
                                                                <span>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                </span>
                                                                <strong>(3 and Above)</strong>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <input id="radios6" type="radio" value="2"
                                                                name="review"
                                                                @if (@$review_value == 2) checked="" @endif
                                                                class="click_apply">
                                                            <label for="radios6">
                                                                <span>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                </span>
                                                                <strong>(2 and Above)</strong>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <input id="radios7" type="radio" value="1"
                                                                name="review"
                                                                @if (@$review_value == 1) checked="" @endif
                                                                class="click_apply">
                                                            <label for="radios7">
                                                                <span>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                </span>
                                                                <strong>(1 and Above)</strong>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <input id="radios8" type="radio" value="0"
                                                                name="review"
                                                                @if (@$review_value == 0) checked="" @endif
                                                                class="click_apply">
                                                            <label for="radios8">
                                                                <span>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                    <i class="fa fa-star rre_star"></i>
                                                                </span>
                                                                <strong>(0 and Above){{ @$review_value }}</strong>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="search_le_check_bx">
                                                    <h5>Session Rates</h5>
                                                    <div class="ratea_slid">
                                                        <div class="slider_rnge">
                                                            <div id="slider-range"
                                                                class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                                                <div class="ui-slider-range ui-widget-header ui-corner-all"
                                                                    style="left: 0%; width: 100%;"></div>
                                                                <span tabindex="0"
                                                                    class="ui-slider-handle ui-state-default ui-corner-all"
                                                                    style="left: 0%;"></span> <span tabindex="0"
                                                                    class="ui-slider-handle ui-state-default ui-corner-all"
                                                                    style="left: 100%;"></span>
                                                            </div>
                                                            <span class="range-text">


                                                                @php
                                                                    if (isset($request_min_hourly_rate)) {
                                                                        $min = $request_min_hourly_rate;
                                                                    } else {
                                                                        $min = 0;
                                                                    }

                                                                    if (isset($request_max_hourly_rate)) {
                                                                        $max = $request_max_hourly_rate;
                                                                    } else {
                                                                        $max = $max_hourly_rate_fetch;
                                                                    }

                                                                @endphp

                                                                {{-- {{ $min }} - {{ $max }} --}}
                                                                $0 - $200

                                                                <input type="hidden" class="price_numb hourly_rate"
                                                                    readonly id="amount" value="0">
                                                                <input type="hidden"
                                                                    class="price_numb hourly_rate click_apply" readonly
                                                                    id="min_hourly_rate_value" name="min_hourly_rate"
                                                                    value="{{ @$min }}">
                                                                <input type="hidden" class="" readonly
                                                                    id="max_hourly_rate_value" name="max_hourly_rate"
                                                                    value="{{ @$max }}">
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="apply_fil_sec">
                                                    <ul>
                                                        <li>
                                                            <input type="submit" class="pg_btn" value="Apply filter">
                                                            {{-- <a href="#url" class="pg_btn">Apply filter</a> --}}
                                                        </li>
                                                        <li><a href="{{ route('search.result.j') }}"
                                                                class="pg_btn">Clear</a></li>
                                                    </ul>
                                                </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="user-right-panel">
                                <div class="search_right_result_inr">
                                    <div class="search_right_top">
                                    @if (count($tutors) >= 0)
                                        @php
                                            $gradeName   = trim($grade_obj->grade_name ?? '');
                                            $subjects    = array_filter(array_map('trim', $subjectNames ?? [])); // remove empty subjects
                                            $branches    = array_filter(array_map('trim', $branchNames ?? [])); // remove empty branches
                                            $stateName   = trim($state_value->state_name ?? '');
                                            $timezone    = $timezoneValue ?? null;
                                            $showAustraliaWide = !$stateName && !$gradeName && count($subjects) == 0 && count($branches) == 0;
                                        @endphp
                                        <h1 class="m-0">
                                            Showing Tutors
                                            {{-- GRADE + SUBJECT --}}
                                         @if ($gradeName || count($subjects) > 0)
                                            for
                                            {{-- Grade --}}
                                                @if ($gradeName)
                                                    <span>{{ $gradeName }}</span>
                                                @endif
                                                {{-- & only when BOTH exist --}}
                                        @if ($gradeName && count($branches) > 0)
                                            <span>&amp;</span>
                                         @endif

                                        {{-- Subjects --}}
                                        @if (count($subjects) > 0)
                                            <span>{{ implode(', ', $subjects) }}</span>
                                        @endif
                                        @endif
                                        {{-- Branches --}}
                                        @if (count($branches) > 0)
                                            @if (!$gradeName && count($subjects) == 0)
                                            for
                                            @endif
                                            <span>{{ implode(', ', $branches) }}</span>
                                        @endif
                                        {{-- Australia-wide ONLY when no filters --}}
                                        @if ($showAustraliaWide)
                                            <span>in Australia-wide</span>
                                        @endif
                                        {{-- State --}}
                                        @if ($stateName)
                                            <span>in {{ $stateName }}</span>
                                        @endif
                                        {{-- Timezone --}}
                                        @if ($timezone)
                                        <span>
                                        {{ $timezone->time_zone_abbreviation }},
                                        {{ $timezone->time_zone_name }},
                                        ({{ $timezone->utc_offset }})
                                        </span>
                                    @endif
                                        </h1>
                                    @else
                                        <h1>No results found</h1>
                                    @endif
                                        <div class="stor_by">
                                            <strong>
                                                Sort by :
                                                <select name="sort_type_value" id="sort_type_id" form="searchVtutorForm">
                                                    <option value="R"
                                                        @if (old('sort_type_value', $sort_type_value ?? request('sort_type_value', 'R')) == 'R') selected @endif>Ratings
                                                    </option>
                                                    <option value="H"
                                                        @if (old('sort_type_value', $sort_type_value ?? request('sort_type_value')) == 'H') selected @endif>$ High
                                                        to Low</option>
                                                    <option value="L"
                                                        @if (old('sort_type_value', $sort_type_value ?? request('sort_type_value')) == 'L') selected @endif>$ Low to
                                                        High</option>
                                                    <!--option value="D" @if (old('sort_type_value', $sort_type_value ?? request('sort_type_value')) == 'D')
    selected
    @endif>Date
                                                            </option-->
                                                    <option value="E"
                                                        @if (old('sort_type_value', $sort_type_value ?? request('sort_type_value')) == 'E') selected @endif>
                                                        Experience</option>
                                                </select>
                                            </strong>
                                        </div>
                                    </div>
                                    @if (count(@$tutors) > 0)
                                        <div class="search_right_body">
                                            @if (@$tutors)
                                                @foreach (@$tutors as $tutor)
                                                    <div
                                                        class="search_lop d-flex flex-column flex-md-row  @if ($tutor->status == 'AA') orangeBackGroundNew @endif @if ($tutor->status == 'A') paleGreen @endif">
                                                        <a @if (@Auth::check()) href="javascript:void(0)" @else href="{{ route('login') }}" @endif
                                                            class=" heart_cc @if (@$tutor->getuserToFavourite) heart_cc_act @endif  saveUsertoFavourite"
                                                            data-saveUsertoFavourite="{{ @$tutor->id }}">
                                                            <i class="fas fa-heart"></i>
                                                        </a>
                                                        <div
                                                            class="search_lop_left d-flex d-md-block justify-content-start pl-3 pl-md-0 align-items-center">
                                                            <em>
                                                                @if (@$tutor->profile_pic)
                                                                    @php
                                                                        $image_path = $tutor->profile_pic ? asset('storage/teacher_profile_pic/'.$tutor->profile_pic) : public_asset('assets/images/blank1.png');
                                                                    @endphp

                                                                        <img src="{{ $image_path }}"
                                                                            alt="{{ $tutor->f_name }}" alt="">


                                                                @else
                                                                    @if (@$tutor->avatar)
                                                                        <img src="{{ @$tutor->avatar }}" alt="">
                                                                    @else
                                                                        <img src="{{ public_asset('assets/images/blank1.png') }}"
                                                                            alt="" />
                                                                    @endif
                                                                @endif
                                                            </em>
                                                            <div>
                                                                <div class="gj_mob_vw_tut_name_div" style="display:none;">
                                                                    <h4>
                                                                        <a
                                                                            @if (!@Auth::check()) class="save_input_data_on_click" data-type="PP" data-id="{{ @$tutor->id }}" data-toggle="modal" data-target="#log_modal{{ @$tutor->id }}"  href="javascript:void(0);" @else href="{{ url('tutor-public-profile') }}/{{ @$tutor->slug }}" target="_blank" @endif>{{ @$tutor->f_name . ' ' . @$tutor->l_name }}
                                                                        </a>
                                                                    </h4>

                                                                </div>
                                                                @if (@Auth::check())
                                                                    <h5 class="mb-0">Sessions from
                                                                        ${{ @$tutor->min_hourly_rate }}
                                                                    </h5>
                                                                @else
                                                                    {{-- <h5 class="mb-0">Sessions from $$</h5> --}}
                                                                @endif
                                                                <ul class="sh_lis_star">
                                                                    @if ($tutor->avg_review >= 0 && $tutor->avg_review <= 0.24)
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 0.25 && $tutor->avg_review <= 0.74)
                                                                        <li><i class="fas fa-star-half-alt"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 0.75 && $tutor->avg_review <= 1.24)
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 1.25 && $tutor->avg_review <= 1.74)
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fas fa-star-half-alt"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 1.75 && $tutor->avg_review <= 2.24)
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 2.25 && $tutor->avg_review <= 2.74)
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fas fa-star-half-alt"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 2.75 && $tutor->avg_review <= 3.24)
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 3.25 && $tutor->avg_review <= 3.74)
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fas fa-star-half-alt"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 3.75 && $tutor->avg_review <= 4.24)
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star rre_star"
                                                                                style="color:#b6b6b6 !important;"></i></li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 4.25 && $tutor->avg_review <= 4.74)
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fas fa-star-half-alt"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                    @endif
                                                                    @if ($tutor->avg_review >= 4.75 && $tutor->avg_review <= 5)
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                        <li><i class="fa fa-star"
                                                                                style="color:#ef9a0c!important;"></i></li>
                                                                    @endif

                                                                    <li>{{ @$tutor->avg_review }}
                                                                        <b>({{ @$tutor->total_no_of_reviews }})</b>
                                                                    </li>
                                                                </ul>

                                                                @if (isset($tutor->getTutorAcademic) && count($tutor->getTutorAcademic) != 0)
                                                                    <ul class="gj_qual_sec">
                                                                        @php
                                                                            $aca_fs = [];

                                                                            foreach ($tutor->getTutorAcademic ?? [] as $taqv) {
                                                                                $fld_sty = $taqv->getFieldStudy->field_of_study ?? null;
                                                                                if ($fld_sty) {
                                                                                    $aca_fs[] = $fld_sty;
                                                                                }
                                                                                /* $qual = $QualificationAr[$taqv->qualification] ?? null;
                                                                                if ($qual) {
                                                                                    $aca_fs[] = $qual;
                                                                                } */
                                                                            }

                                                                            $aca_fs = array_unique($aca_fs);
                                                                        @endphp

                                                                        @if (!empty($aca_fs))
                                                                            <li>{{ implode(', ', $aca_fs) }}</li>
                                                                        @endif
                                                                    </ul>
                                                                @endif
                                                                {{-- <h5>{{ @$tutor->total_experience }} yrs. </h5> --}}

                                                            </div>
                                                        </div>
                                                        <div class="search_lop_right float-none">
                                                            <div class="lop_name_box d-flex flex-column flex-md-row">
                                                                <div
                                                                    class="search_lop_name @if (!Auth::check()) border-0 @endif">
                                                                    <div class="gj_dk_vw_tut_name_div">
                                                                        <h4 class="d-inline-flex align-items-center">
                                                                            {{--  data-target="#log_modal{{ @$tutor->id }}"  --}}
                                                                            <a
                                                                                 class="save_input_data_on_click" data-type="PP" href="{{ url('tutor-public-profile') }}/{{ @$tutor->slug }}" target="_blank">{{ @$tutor->f_name . ' ' . @$tutor->l_name }}</a>
                                                                            @if(@$tutor->free_trial == 1)
                                                                                <img src="{{ public_asset('assets/images/free_trial_icon.png') }}" width="75" height="75" class="ml-1 d-inline-block" alt="">
                                                                            @endif
                                                                        </h4>
                                                                    </div>
                                                                    <ul class="search_sibj d-flex flex-wrap gap-1">
                                                                        <li class="d-flex flex-wrap align-items-center">
                                                                            <img
                                                                                src="{{ public_asset('assets/images/map.png') }}" class="me-1">

                                                                            @if ($tutor->unique_wwcc_states->isNotEmpty())
                                                                                @foreach ($tutor->unique_wwcc_states as $state)
                                                                                    <span class="badge badge-info mb-2">
                                                                                        @if ($state->state_name == 'New South Wales')
                                                                                            NSW
                                                                                        @elseif($state->state_name == 'Victoria')
                                                                                            VIC
                                                                                        @elseif($state->state_name == 'Queensland')
                                                                                            QLD
                                                                                        @elseif($state->state_name == 'South Australia')
                                                                                            SA
                                                                                        @elseif($state->state_name == 'Western Australia')
                                                                                            WA
                                                                                        @elseif($state->state_name == 'Tasmania')
                                                                                            TAS
                                                                                        @elseif($state->state_name == 'Northern Territory')
                                                                                            NT
                                                                                        @elseif(@$state->state_name == 'Australian Capital Territory')
                                                                                            ACT
                                                                                        @endif
                                                                                    </span>
                                                                                @endforeach
                                                                            @else
                                                                                <span>Not available</span>
                                                                            @endif
                                                                        </li>
                                                                    </ul>

                                                                    <ul class="sub_list">
                                                                        @php
                                                                            // Get unique branch plans by branch_id
                                                                            $plans = $tutor->getTutorShipPlan->unique(
                                                                                'branch_id',
                                                                            );
                                                                        @endphp

                                                                        @if ($plans->isNotEmpty())
                                                                            @foreach ($plans as $tutorshipplan)
                                                                                <li>{{ $tutorshipplan->getbranch->branch_name ?? '' }}
                                                                                </li>
                                                                            @endforeach
                                                                        @endif
                                                                    </ul>
                                                                    <ul class="sub_list">
                                                                        @if (@$tutor->getMyAvailability)
                                                                            @foreach (@$tutor->getMyAvailability->unique('day') as $av)
                                                                                <li>
                                                                                    @if (@$av->day == 1)
                                                                                        Mon
                                                                                    @elseif(@$av->day == 2)
                                                                                        Tue
                                                                                    @elseif(@$av->day == 3)
                                                                                        Wed
                                                                                    @elseif(@$av->day == 4)
                                                                                        Thur
                                                                                    @elseif(@$av->day == 5)
                                                                                        Fri
                                                                                    @elseif(@$av->day == 6)
                                                                                        Sat
                                                                                    @elseif(@$av->day == 7)
                                                                                        Sun
                                                                                    @endif

                                                                                </li>
                                                                            @endforeach
                                                                        @endif

                                                                    </ul>

                                                                    {{-- <ul class="sub_list gj_acad_sub_list">
                                                                        @if (isset($tutor->getTutorAcademic) && count($tutor->getTutorAcademic) != 0)
                                                                            @foreach (@$tutor->getTutorAcademic as $tak => $tav)
                                                                                @php
                                                                                    $a_qualification = $QualificationAr[$tav->qualification] ?? null;
                                                                                    $a_field = $tav->getFieldStudy->field_of_study ?? null;
                                                                                @endphp
                                                                                
                                                                                @if ($a_qualification && $a_field)
                                                                                    <li>
                                                                                        {{ $a_qualification }} - {{ $a_field }}
                                                                                    </li>
                                                                                @elseif ($a_qualification)
                                                                                    <li>
                                                                                        {{ $a_qualification }}
                                                                                    </li>
                                                                                @elseif ($a_field)
                                                                                    <li>
                                                                                        {{ $a_field }}
                                                                                    </li>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif

                                                                    </ul> --}}
                                                                </div>
                                                                {{-- @if (@Auth::check()) --}}
                                                                    <div class="search_lop_name_list float-none my-auto"> 
                                                                        <div class="gj_wwcc_verf_divimg">
                                                                            <img src="{{ public_asset('assets/images/wwcc_verified.png') }}" class="gj_wwcc_verf_img">
                                                                        </div>

                                                                        <ul class="d-flex flex-column flex-sm-row flex-wrap gap-2">
                                                                              @if(Auth::check())
                                                                            <li>
                                                                                <img src="{{ public_asset('assets/images/list_ico1.png') }}"
                                                                                    alt="">
                                                                                <a  class="save_input_data_on_clic text-nowrap ms-1" data-type="PP" data-id="{{ @$tutor->id }}" href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . optional($tutor)->slug . '&search_tutor_id_studentclass=' . optional($tutor)->id) }}" >Book a session</a>

                                                                                    @endif
                                                                            </li>



                                                                            <li>
                                                                                {{--  data-target="#log_modal{{ @$tutor->id }}"  --}}
                                                                                <img src="{{ public_asset('assets/images/list_ico3.png') }}"
                                                                                    alt=""><a
                                                                                     class="save_input_data_on_click text-nowrap ms-1" data-type="PP" data-id="{{ @$tutor->id }}" href="{{ url('tutor-public-profile') }}/{{ @$tutor->slug }}" target="_blank">Visit
                                                                                    my profile</a>
                                                                            </li>
                                                                             @if (Auth::check())
                                                                            <li>
                                                                                <img src="{{ public_asset('assets/images/list_ico4.png') }}"
                                                                                    alt="">
                                                                                <a  class="save_input_data_on_click text-nowrap ms-1" data-type="PP" data-id="{{ @$tutor->id }}"  href="{{ route('student.my.review', @$tutor->slug) }}">Post a review </a>
                                                                            </li>
                                                                            @endif

                                                                        </ul>
                                                                    </div>
                                                                {{-- @endif --}}
                                                            </div>
                                                            @if (strlen(@$tutor->about_me))
                                                                <div class="lop_name_para">
                                                                    <p>
                                                                        @if (strlen(@$tutor->about_me) > 120)
                                                                            @php
                                                                                $len = strpos(
                                                                                    wordwrap(@$tutor->about_me, 120),
                                                                                    "\n",
                                                                                );
                                                                            @endphp
                                                                            {!! nl2br(substr(@$tutor->about_me, 0, $len)) !!}

                                                                            <span
                                                                                class=" text_c_more_less text_c_more_less{{ @$tutor->id }}"
                                                                                style="display: none;">
                                                                                {!! strip_tags(@$tutor->about_me) !!}
                                                                            </span>
                                                                            <a class=" button_red_cc c_c_moreless c_c_moreless{{ @$tutor->id }}"
                                                                                data-id="{{ @$tutor->id }}">Read
                                                                                more</a>
                                                                        @else
                                                                            {!! strip_tags(@$tutor->about_me) !!}
                                                                        @endif

                                                                    </p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="pagi_cc">
                                                <nav aria-label="...">
                                                    <ul class="pagination">

                                                        {{ $tutors->links() }}
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    @else
                                        <div class="search_right_body">
                                            <div class="empty_box search_emt_bx">
                                                <img src="{{ public_asset('assets/images/empty_img.png') }}">
                                                <h2 class="filter_no_data">No tutors match your current filters.</h2>
                                                <p class="filter_no_data_para"> Adjust your selections to explore more available tutors.</p>
                                                {{-- <p>Try changing filters to search again</p> --}}
                                                <p class="filter_note">Note: “Tutor availability depends on state authorisation and subject preferences. We’re onboarding new tutors regularly—adjust your filters or check back soon to see more options</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal " id="notapproved">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title ">Message</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="">
                                    <div class=" ">
                                        <div class="meass-popup">
                                            <ul class="">
                                                <li class="">
                                                    We are working to bring this awesome V-Tutor onboard. Please try another
                                                    tutor.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
                <div class="modal " id="not_b_popup">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title ">Message</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="">
                                    <div class=" ">
                                        <div class="meass-popup">
                                            <ul class="">
                                                <li class="">
                                                    You cannot book a session outside your grade
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal " id="not_p_popup">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title ">Message</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="">
                                    <div class=" ">
                                        <div class="meass-popup">
                                            <ul class="">
                                                <li class="">
                                                    You cannot post a review outside your grade
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal " id="not_b_popupState">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title ">Message</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="">
                                    <div class=" ">
                                        <div class="meass-popup">
                                            <ul class="">
                                                <li class="">
                                                    You cannot book a session outside your state
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal " id="not_p_popupState">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title ">Message</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="">
                                    <div class=" ">
                                        <div class="meass-popup">
                                            <ul class="">
                                                <li class="">
                                                    You cannot post a review outside your state
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal " id="not_b_popupTimeZone">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title ">Message</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="">
                                    <div class=" ">
                                        <div class="meass-popup">
                                            <ul class="">
                                                <li class="">
                                                    You cannot book this tutor since they are outside your State / Timezone.
                                                    Try to
                                                    book
                                                    tutors within your State / Timezone.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal " id="not_p_popupTimeZone">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title ">Message</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->

                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal " id="admin_disabled_bookings_popup">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title bb_disabled_booking_u">Message</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="">
                                    <div class=" ">
                                        <div class="meass-popup">
                                            <ul class="">
                                                <li class="">
                                                    You cannot make bookings at this time. Please contact support
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="alreadyRev" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content revmodal">
                            <!-- Modal Header -->


                            <!-- Modal body -->
                            <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                <div class="modal_button">
                                    <img src="{{ public_asset('assets/images/review_given.png') }}" width="100px">
                                    <center>
                                        <h2>You have already reviewed this tutor.</h2>
                                    </center>
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
    <script src="{{ public_asset('assets/toastr/build/toastr.min.js') }}"></script>
    <script src="https://kit.fontawesome.com/446e463225.js" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {



            $(".moreless-button5").click(function() {
                $(".moretext5").slideToggle("fast");
                if ($(".moreless-button5").text() == "More+") {
                    $(".moreless-button5").text("Less-");
                } else {
                    $(".moreless-button5").text("More+");
                }
            });

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

            $(document).on("change", ".change_apply", function(e) {



                $("#searchVtutorForm").submit();



            });



            $(document).on("click", ".click_apply", function(e) {

                //  alert("s")

                $("#searchVtutorForm").submit();



            });

            $('.checkbox_ck_u').on('click', function() {

                if ($(this).is(":checked")) {

                    $("#searchVtutorForm").submit();

                } else {

                    $(this).val("");

                    $("#searchVtutorForm").submit();

                }

            });



            $(document).on("click", ".saveUsertoFavourite", function(e) {







                var favourite_user_id = $(this).attr("data-saveUsertoFavourite"),



                    obj = $(this),



                    reqData = {



                        'jsonrpc': '2.0',



                        '_token': '{{ csrf_token() }}',



                        'data': {



                            'favourite_user_id': favourite_user_id



                        }



                    };















                $.ajax({



                    url: "{{ route('save.user.to.favourite') }}",



                    dataType: 'json',



                    data: reqData,



                    type: 'post',



                    success: function(resp) {



                        if (resp.result.status == 'Added') {



                            obj.addClass("heart_cc_act");



                        } else {



                            obj.removeClass("heart_cc_act");



                        }



                        toastr.success(resp.result.message);



                    },



                    error: function() {



                        toastr.error("Please refresh the page!");



                    }



                });







            });



        });







        $("#slider-range").slider({



            range: true,



            min: 0,



            max: 200,
            // max: {{ @$max_hourly_rate_fetch }},



            values: [{{ @$request_min_hourly_rate ? @$request_min_hourly_rate : 0 }},
                {{ @$request_max_hourly_rate ? @$request_max_hourly_rate : @$max_hourly_rate_fetch }}
            ],



            slide: function(event, ui) {







                $("#amount").val("$ " + ui.values[0] + " - $ " + ui.values[1]);



                $("#min_hourly_rate_value").val(ui.values[0]);



                $("#max_hourly_rate_value").val(ui.values[1]);



                $("#searchVtutorForm").submit();







            },



        });



        // @if (@$request_max_hourly_rate || @$request_min_hourly_rate)



        //     $("#amount").val("$ " + {{ @$request_min_hourly_rate }} + " - $ " + {{ @$request_max_hourly_rate }});



        //     $("#min_hourly_rate_value").val({{ @$request_min_hourly_rate }});



        //     $("#max_hourly_rate_value").val({{ @$request_max_hourly_rate }});
        // @else



        //     $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", ));



        //     $("#min_hourly_rate_value").val($("#slider-range").slider("values", 0));



        //     $("#max_hourly_rate_value").val($("#slider-range").slider("values", 2));
        // @endif



        $(document).ready(function() {



            $(document).on("change", "#sort_type_id", function() {



                $("#sort_type").val($.trim($("#sort_type_id").val()));



                $("#searchVtutorForm").submit();



            });



        });
    </script>
    <script>
        $(document).on("click", ".c_c_moreless", function() {



            var id = $(this).data("id");



            // text_c_more_less



            $('.text_c_more_less' + id).slideToggle();



            if ($(this).text().trim().replace(/\s+/g, ' ') === "Read more") {


                $(this).text("Read Less")



            } else {


                $(this).text("Read more")



            }



        });
    </script>

    <script>
        $(".mobile_filter_as").click(function() {



            $(".search_left_inr").slideToggle();



        });
    </script>

    {{-- branch_id get  --}}
    <script type="text/javascript">
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                currentFocus++;
                addaActive(x);
            } else if (e.keyCode == 38) {
                currentFocus--;
                addaActive(x);
            } else if (e.keyCode == 13) {
                e.preventDefault();
                if (currentFocus > -1) {
                    if (x) x[currentFocus].click();
                }
            }
        });


        function addaActive(x) {
            if (!x) return false;
            removeaActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            x[currentFocus].classList.add("autocomplete-active");
        }


        function removeaActive(x) {
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }


        function closeaAllLists(elmnt) {
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    if (x[i].parentNode) x[i].parentNode.removeChild(x[i]);
                }
            }
        }


        document.addEventListener("click", function(e) {
            closeaAllLists(e.target);
        });


        document.addEventListener('change', function(e) {
            if (e.target && e.target.id === 'sort_type_id') {
                var f = document.getElementById('searchVtutorForm');
                if (f) f.submit();
            }
        });
    </script>

    <script>
        // ✅ Safe call after DOM ready
        document.addEventListener("DOMContentLoaded", function() {
            var searchInput = document.getElementById("search_subjects");
            if (searchInput) {
                datastudentautocomplete(searchInput, []);
            }
        });
    </script>
    <script>
    $(document).ready(function () {
        $('.mobile_filter_as').click(function () {
            $('.dasbordLeft').slideToggle();
        });
    });
    </script>
    <style>
    /* Fix filter width issue in mobile */
    @media (max-width: 992px) {
    .user-left,
    .dasbordLeft {
        width: 100% !important;
        max-width: 100% !important;
    }

    .user-left.sticky_left {
        position: static !important;
    }
    }
    @media (max-width: 767px) {
        .gj_wwcc_verf_divimg {
            display: block !important;
            justify-content: flex-start !important;
            align-items: flex-start !important;
            padding-right: 0 !important;
            width: auto !important;
        }
    }

</style>
@endsection

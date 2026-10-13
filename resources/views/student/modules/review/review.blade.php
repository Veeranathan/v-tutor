@extends('layouts.app')
@section('title')
    <title>V-Tutor | Student | My review </title>
@endsection
@section('left_part')
    {{-- @include('include.student_top_common') --}}
@include('include.header_menu_part')
    {{-- for datatable --}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <!-- bannersec -->
    <div class="top_mar"></div>
    <!--- profile --->
    <section class="user-account">
        <div class="container">
            <div class="row">
                <div class="zin">
                    @include('include.student_left_common'){{-- left common part --}}
                    <div class="user-right-panel">
                        <div class="user-right-top-new ">
                            @include('include.errors')
                            <h2 class="profile-heading">Post Review</h2>
                            <p class="gj_sub_hd">You can post reviews of your tutors in this section</p>

                        </div>

                        <div class="class-feild">
                            <div class="row">
                                <div class="col-12">
                                    <div class="tuto-rating">
                                        <em>
                                            {{-- <img src="{{ public_asset('assets/images/user11.png')}}" alt="profile_img"> --}}
                                            @if (@$UserDetails->profile_pic)
                                                @php
                                                    $image_path =
                                                        'assets/images/all_avatars/' . @$UserDetails->profile_pic;
                                                @endphp
                                                @if (file_exists(@$image_path))
                                                    <img src="{{ public_asset('assets/images/all_avatars/' . @UserDetails->profile_pic) }}"
                                                        alt="profile_img">
                                                @else
                                                    <img src="{{ env('STORAGE_URL') . '/teacher_profile_pic/' . @$UserDetails->profile_pic }}"
                                                        alt="">
                                                @endif
                                                {{-- <img src="{{url('/')}}/storage/teacher_profile_pic/{{@$UserDetails->profile_pic}}" alt="profile_img" style="width: 100%;height: 100%"> --}}
                                            @elseif(!@$UserDetails->profile_pic && @$UserDetails->avatar)
                                                <img src="{{ @$UserDetails->avatar }}" alt="profile_img"
                                                    style="width: 100%">
                                            @else
                                                <img src="{{ public_asset('assets/images/user-pro.png') }}" alt="profile_img">
                                                {{-- <img src="{{ public_asset('assets/images/blank1.png') }}" alt="profile_img"
                                                    style="width: 100%"> --}}
                                            @endif
                                        </em>
                                        <div class="tu-info">
                                            <h2>{{ $UserDetails->f_name }} {{ $UserDetails->l_name }}</h2>
                                            <div class="sed">
                                                {{-- <span><b>Location: </b>
                                                    {{ @$UserDetails->getState->state_name }},{{ @$UserDetails->city }}</span> --}}
                                                <span><img src="{{ public_asset('assets/images/map.png') }}">
                                                    @if (@$UserDetails->getState->state_name)
                                                    @if (@$UserDetails->getState->state_name == 'New South Wales')
                                                    NSW
                                                    @elseif(@$UserDetails->getState->state_name == 'Victoria')
                                                    VIC
                                                    @elseif(@$UserDetails->getState->state_name == 'Queensland')
                                                    QLD
                                                    @elseif(@$UserDetails->getState->state_name == 'South Australia')
                                                    SA
                                                    @elseif(@$UserDetails->getState->state_name == 'Western Australia')
                                                    WA
                                                    @elseif(@$UserDetails->getState->state_name == 'Tasmania')
                                                    TAS
                                                    @elseif(@$UserDetails->getState->state_name == 'Northern Territory')
                                                    NT
                                                    @elseif(
                                                    @$UserDetails->getState->state_name ==
                                                    'Australian Capital
                                                    Territory')
                                                    ACT
                                                    @endif
                                                    @endif
                                                </span>

                                                <ul class="profile-rating m-0">
                                                    @if (@$UserDetails->avg_review >= 0 && @$UserDetails->avg_review <= 0.24) <li><a
                                                            href="#"><img
                                                                src="{{ public_asset('assets/images/star1.png') }}"
                                                                alt=""></a></li>
                                                        <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                        <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                        <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                        <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                        @endif
                                                        @if (@$UserDetails->avg_review >= 0.25 && @$UserDetails->avg_review <= 0.74)
                                                            <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                    alt=""></a></li>
                                                            <li><a href="#"><img
                                                                        src="{{ public_asset('assets/images/star1.png') }}"
                                                                        alt=""></a></li>
                                                            <li><a href="#"><img
                                                                        src="{{ public_asset('assets/images/star1.png') }}"
                                                                        alt=""></a></li>
                                                            <li><a href="#"><img
                                                                        src="{{ public_asset('assets/images/star1.png') }}"
                                                                        alt=""></a></li>
                                                            <li><a href="#"><img
                                                                        src="{{ public_asset('assets/images/star1.png') }}"
                                                                        alt=""></a></li>
                                                            @endif
                                                            @if (@$UserDetails->avg_review >= 0.75 && @$UserDetails->avg_review <= 1.24)
                                                                <li><a href="#"><img
                                                                        src="{{ public_asset('assets/images/star.png') }}"
                                                                        alt=""></a></li>
                                                                <li><a href="#"><img
                                                                            src="{{ public_asset('assets/images/star1.png') }}"
                                                                            alt=""></a></li>
                                                                <li><a href="#"><img
                                                                            src="{{ public_asset('assets/images/star1.png') }}"
                                                                            alt=""></a></li>
                                                                <li><a href="#"><img
                                                                            src="{{ public_asset('assets/images/star1.png') }}"
                                                                            alt=""></a></li>
                                                                <li><a href="#"><img
                                                                            src="{{ public_asset('assets/images/star1.png') }}"
                                                                            alt=""></a></li>
                                                                @endif
                                                                @if (@$UserDetails->avg_review >= 1.25 && @$UserDetails->avg_review <=
                                                                    1.74) <li><a href="#"><img
                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                            alt=""></a></li>
                                                                    <li><a href="#"><img
                                                                                src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                                alt=""></a></li>
                                                                    <li><a href="#"><img
                                                                                src="{{ public_asset('assets/images/star1.png') }}"
                                                                                alt=""></a></li>
                                                                    <li><a href="#"><img
                                                                                src="{{ public_asset('assets/images/star1.png') }}"
                                                                                alt=""></a></li>
                                                                    <li><a href="#"><img
                                                                                src="{{ public_asset('assets/images/star1.png') }}"
                                                                                alt=""></a></li>
                                                                    @endif
                                                                    @if (@$UserDetails->avg_review >= 1.75 && @$UserDetails->avg_review
                                                                    <= 2.24) <li><a href="#"><img
                                                                                src="{{ public_asset('assets/images/star.png') }}"
                                                                                alt=""></a></li>
                                                                        <li><a href="#"><img
                                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                                    alt=""></a></li>
                                                                        <li><a href="#"><img
                                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                                    alt=""></a></li>
                                                                        <li><a href="#"><img
                                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                                    alt=""></a></li>
                                                                        <li><a href="#"><img
                                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                                    alt=""></a></li>
                                                                        @endif
                                                                        @if (@$UserDetails->avg_review >= 2.25 &&
                                                                        @$UserDetails->avg_review <= 2.74) <li><a href="#"><img
                                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                                    alt=""></a></li>
                                                                            <li><a href="#"><img
                                                                                        src="{{ public_asset('assets/images/star.png') }}"
                                                                                        alt=""></a></li>
                                                                            <li><a href="#"><img
                                                                                        src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                                        alt=""></a></li>
                                                                            <li><a href="#"><img
                                                                                        src="{{ public_asset('assets/images/star1.png') }}"
                                                                                        alt=""></a></li>
                                                                            <li><a href="#"><img
                                                                                        src="{{ public_asset('assets/images/star1.png') }}"
                                                                                        alt=""></a></li>
                                                                            @endif
                                                                            @if (@$UserDetails->avg_review >= 2.75 &&
                                                                            @$UserDetails->avg_review <= 3.24) <li><a
                                                                                    href="#"><img
                                                                                        src="{{ public_asset('assets/images/star.png') }}"
                                                                                        alt=""></a></li>
                                                                                <li><a href="#"><img
                                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                                            alt=""></a></li>
                                                                                <li><a href="#"><img
                                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                                            alt=""></a></li>
                                                                                <li><a href="#"><img
                                                                                            src="{{ public_asset('assets/images/star1.png') }}"
                                                                                            alt=""></a></li>
                                                                                <li><a href="#"><img
                                                                                            src="{{ public_asset('assets/images/star1.png') }}"
                                                                                            alt=""></a></li>
                                                                                @endif
                                                                                @if (@$UserDetails->avg_review >= 3.25 &&
                                                                                @$UserDetails->avg_review <= 3.74) <li><a
                                                                                        href="#"><img
                                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                                            alt=""></a></li>
                                                                                    <li><a href="#"><img
                                                                                                src="{{ public_asset('assets/images/star.png') }}"
                                                                                                alt=""></a></li>
                                                                                    <li><a href="#"><img
                                                                                                src="{{ public_asset('assets/images/star.png') }}"
                                                                                                alt=""></a></li>
                                                                                    <li><a href="#"><img
                                                                                                src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                                                alt=""></a></li>
                                                                                    <li><a href="#"><img
                                                                                                src="{{ public_asset('assets/images/star1.png') }}"
                                                                                                alt=""></a></li>
                                                                                    @endif
                                                                                    @if (@$UserDetails->avg_review >= 3.75 &&
                                                                                    @$UserDetails->avg_review <= 4.24) <li><a
                                                                                            href="#"><img
                                                                                                src="{{ public_asset('assets/images/star.png') }}"
                                                                                                alt=""></a></li>
                                                                                        <li><a href="#"><img
                                                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                                                    alt=""></a></li>
                                                                                        <li><a href="#"><img
                                                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                                                    alt=""></a></li>
                                                                                        <li><a href="#"><img
                                                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                                                    alt=""></a></li>
                                                                                        <li><a href="#"><img
                                                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                                                    alt=""></a></li>
                                                                                        @endif
                                                                                        @if (@$UserDetails->avg_review >= 4.25 &&
                                                                                        @$UserDetails->avg_review <= 4.74) <li><a
                                                                                                href="#"><img
                                                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                                                    alt=""></a></li>
                                                                                            <li><a href="#"><img
                                                                                                        src="{{ public_asset('assets/images/star.png') }}"
                                                                                                        alt=""></a></li>
                                                                                            <li><a href="#"><img
                                                                                                        src="{{ public_asset('assets/images/star.png') }}"
                                                                                                        alt=""></a></li>
                                                                                            <li><a href="#"><img
                                                                                                        src="{{ public_asset('assets/images/star.png') }}"
                                                                                                        alt=""></a></li>
                                                                                            <li><a href="#"><img
                                                                                                        src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                                                        alt=""></a></li>
                                                                                            @endif
                                                                                            @if (@$UserDetails->avg_review >= 4.75
                                                                                            && @$UserDetails->avg_review <= 5)
                                                                                                <li><a href="#"><img
                                                                                                        src="{{ public_asset('assets/images/star.png') }}"
                                                                                                        alt=""></a></li>
                                                                                                <li><a href="#"><img
                                                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                                                            alt=""></a></li>
                                                                                                <li><a href="#"><img
                                                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                                                            alt=""></a></li>
                                                                                                <li><a href="#"><img
                                                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                                                            alt=""></a></li>
                                                                                                <li><a href="#"><img
                                                                                                            src="{{ public_asset('assets/images/star.png') }}"
                                                                                                            alt=""></a></li>
                                                                                                @endif
                                                                                                <li>
                                                                                                    <p>{{
                                                                                                        @$UserDetails->avg_review
                                                                                                        }}
                                                                                                        ({{
                                                                                                        @$UserDetails->total_no_of_reviews
                                                                                                        }})</p>
                                                                                                </li>
                                                </ul>
                                            </div>
                                            {{-- <div class="sed reviewClsDiv">

                                                @php
                                                    $grea = [];
                                                    foreach (@$UserDetails->getTutorShipPlan as $val) {
                                                        if (!in_array($val->getGrade->grade_name, $grea)) {
                                                            array_push($grea, $val->getGrade->grade_name);
                                                        }
                                                    }
                                                    $greads = implode(',', $grea);
                                                @endphp
                                                <span><b>Grade: </b> {{ @$greads }}</span>

                                            </div> --}}
                                            {{-- <div class="sed reviewClsDiv">

                                                <span><b>Experience: </b> {{ @$UserDetails->total_experience }} years</span>

                                            </div>
                                            <div class="sed reviewClsDiv">

                                                <span><b>Subjects: </b> {{ @$subjects }}</span>

                                            </div> --}}

                                            <div class="sed reviewClsDiv">
                                                {{-- <span><b>Rating:

                                                        @if ($UserDetails->avg_review >= 0 && $UserDetails->avg_review <= 0.24)
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                        @endif

                                                        @if ($UserDetails->avg_review >= 0.25 && $UserDetails->avg_review <= 0.74)
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                        @endif


                                                        @if ($UserDetails->avg_review >= 0.75 && $UserDetails->avg_review <= 1.24)
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                        @endif



                                                        @if ($UserDetails->avg_review >= 1.25 && $UserDetails->avg_review <= 1.74)
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                        @endif



                                                        @if ($UserDetails->avg_review >= 1.75 && $UserDetails->avg_review <= 2.24)
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                        @endif




                                                        @if ($UserDetails->avg_review >= 2.25 && $UserDetails->avg_review <= 2.74)
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                        @endif




                                                        @if ($UserDetails->avg_review >= 2.75 && $UserDetails->avg_review <= 3.24)
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                        @endif




                                                        @if ($UserDetails->avg_review >= 3.25 && $UserDetails->avg_review <= 3.74)
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                        @endif




                                                        @if ($UserDetails->avg_review >= 3.75 && $UserDetails->avg_review <= 4.24)
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a>
                                                        @endif





                                                        @if ($UserDetails->avg_review >= 4.25 && $UserDetails->avg_review <= 4.74)
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                    alt=""></a>
                                                        @endif



                                                        @if ($UserDetails->avg_review >= 4.75 && $UserDetails->avg_review <= 5)
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                            <a href="#"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"
                                                                    alt=""></a>
                                                        @endif


                                                </span> --}}

                                                {{-- <span>
                                                    @php
                                                        $lastClass = DB::table('student_class_bookings')
                                                            ->where(
                                                                'tutor_id',
                                                                @$UserDetails->id,
                                                            ) /*->where('booking_date','<',date('y-m-d'))*/
                                                            ->first();
                                                    @endphp
                                                    @if (@$lastClass->booking_date)
                                                        <img src="{{ public_asset('assets/images/cal.png') }}">Last class
                                                        attended on: {{ $lastClass->booking_date }}
                                                    @endif
                                                </span> --}}
                                                {{-- <span><img src="{{ public_asset('assets/images/cal.png')}}"> 24.08.2021</span>
												<span><img src="{{ public_asset('assets/images/clock.png')}}">  06:30 pm - 07:00 pm</span> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php

                            $find = DB::table('reviews')
                                ->where('tutor_id', @$UserDetails->id)
                                ->where('student_id', @Auth()->user()->id)
                                ->count();

                        @endphp
                        @if (@$find > 0)
                            {{-- <p style="text-align: center;"><b>Already review given</b></p> --}}
                            <center>
                                <h2>Tutor already reviewed.</h2>
                            </center>
                            <center style="margin-top: 10px"> <button class="btn btn-danger"
                                    style="background-color: #dc3545; "><a href="{{ route('list.of.favourite') }}"
                                        style="color: white;"> Back</a></button></center>
                        @else
                            <div class="user-right-top">
                                <form method="post" action="{{ route('student.my.review.ins') }}" id="frm">
                                    @csrf
                                    <div class="form_box_area newmar">
                                        <label>Rating</label>
                                        <div>

                                            <div id="half-stars-example">


                                                <li class="d-flex"><a href="javascript:void(0)" onclick="fair(1)"><img id="f1"
                                                            src="{{ public_asset('assets/images/rating/rating2.png') }}"></a>
                                                    <a href="javascript:void(0)" onclick="fair(2)"><img id="f2"
                                                            src="{{ public_asset('assets/images/rating/rating2.png') }}"></a>
                                                    <a href="javascript:void(0)" onclick="fair(3)"><img id="f3"
                                                            src="{{ public_asset('assets/images/rating/rating2.png') }}"></a>
                                                    <a href="javascript:void(0)" onclick="fair(4)"><img id="f4"
                                                            src="{{ public_asset('assets/images/rating/rating2.png') }}"></a>
                                                    <a href="javascript:void(0)" onclick="fair(5)"><img id="f5"
                                                            src="{{ public_asset('assets/images/rating/rating2.png') }}"></a>
                                                </li>
                                                <br>
                                                <input type="hidden" id="ratting" name="ratting" required>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form_box_area">
                                        <label>Post Review </label>
                                        <textarea
                                            placeholder="Post review based on your experience with the tutor  in about 100 words. Positive reviews will help boost the morale of the tutors. Avoid harsh or profane comments. Reviews are moderated and will be taken down if inappropriate"
                                            name="message"id="txt" class="textarea_box nocopypaste" maxlength="1000"></textarea>
                                        <span id="bad" class="error_textarea"
                                            style="margin-top: 5px; color: red"></span>
                                    </div>
                                    <input type="hidden" name="tutor_id" value="{{ @$UserDetails->id }}">
                                    <div class="">
                                        <hr class="das-hr">
                                        <div class="footdashSec">
                                            <input type="submit" name="" value="Submit Review"
                                                class="sub_btn new-subbtn">
                                        </div>
                                    </div>
                                </form>

                            </div>
                        @endif


                        <div class="user-right-top">
                            <div class="tab-rii mb-4">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#today">Review History</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="main-tabels">
                                <!-- Nav tabs -->

                                <!-- Tab panes -->

                                <div class="custom-table">
                                    {{-- start --}}
                                    <table id="example" class="cell-border table table-responsive">
                                        <thead>
                                            <tr>

                                                <th> <span class="d-flex align-items-center justify-content-start gap-2">
                                                        Tutor <div class="sort_img"> <img
                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                        </div>
                                                    </span> </th>
                                                <th>
                                                    <span class="d-flex align-items-center justify-content-start gap-2">
                                                        Review Date <div class="sort_img"> <img
                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                        </div>
                                                    </span>

                                                </th>
                                                <th style="white-space: nowrap;">
                                                    <span class="d-flex align-items-center justify-content-start gap-2">
                                                        Rating <div class="sort_img"> <img
                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                        </div>
                                                    </span>
                                                </th>
                                                <th>
                                                    <span class="d-flex align-items-center justify-content-start gap-2">
                                                        Comments <div class="sort_img"> <img
                                                                src="{{ public_asset('assets/images/sort.png') }}">
                                                        </div>
                                                    </span>
                                                </th>

                                                <th> </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reviews as $key => $val)
                                                <tr>

                                                    <td data-label="Name">
                                                        {{ @$val->tutor->f_name }} {{ @$val->tutor->l_name }}
                                                    </td>

                                                    <td data-label="Name">
                                                        {{ date('d.m.Y', strtotime(@$val->created_at)) }} </td>

                                                    <td data-label="Name"  >
                                                        <div class="d-flex h-100 text-center">
                                                        {{-- for gold star --}}
                                                        @for ($i = 0; $i <= @$val->ratting - 1; $i++)
                                                            <a href="#url"><img
                                                                    src="{{ public_asset('assets/images/star.png') }}"></a>
                                                        @endfor
                                                        {{-- blank --}}
                                                        @for ($i = 0; $i < 5 - @$val->ratting; $i++)
                                                            <a href="#url"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"></a>
                                                        @endfor
                                                            </div>

                                                    </td>
                                                    <td data-label="Name">
                                                        <p class="add_ttrr desi">{{ substr(@$val->message, 0, 120) }}</p>
                                                        <a class="{{-- moreless-button2 --}}  allread"
                                                            onclick="readmore({{ $val->id }})"
                                                            id="rr{{ $val->id }}">Read More +</a>
                                                        <p class="moretext2 desi" style="display: none;"
                                                            id="desc{{ $val->id }}">
                                                            {{ substr(@$val->message, 120) }}
                                                            <a class="{{-- moreless-button2 --}}  allread"
                                                                style="display: none;"
                                                                onclick="readless({{ $val->id }})"
                                                                id="rrr{{ $val->id }}">Read less -</a>
                                                        </p>
                                                    </td>


                                                    <td>
                                                        <div class="add_ttrr actions-main">
                                                            <a href="javascript:void(0);" class="action-dots"
                                                                id="action{{ $val->id }}"><img
                                                                    src="{{ public_asset('assets/images/action-dots.png') }}"
                                                                    alt=""
                                                                    onclick="fun({{ $val->id }})"></a>
                                                            <div class="show-actions" id="show-action{{ $val->id }}"
                                                                style="display: none;"> <span class="angle"><img
                                                                        src="{{ public_asset('assets/images/angle.png') }}"
                                                                        alt=""></span>
                                                                <ul>
                                                                    <li><a onclick="return confirm('Are you sure you want to delete?')"
                                                                            href="{{ route('student.del.review', $val->id) }}">Delete</a>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                            {{-- <div class="add_ttrr actions-main"> --}}
                                                            {{-- <a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
													<div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
													<ul> --}}
                                                            {{--  <li><a href="{{route('aced.edit.page',$val->id)}}">Edit</a></li>
														<li><a onclick="return confirm('Are you sure want to delete this?')" href="{{route('aced.dlt',$val->id)}}">Delete</a></li> --}}
                                                            {{-- </ul>
													--}}

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>

                                </div>



                            </div>
                            <div class="clearfix"></div>
                            {{-- start --}}

                            {{-- <div class="account-area-tutor">
                                <div class="row ">
                                    @foreach ($tutors as $val)
                                        <div class="col-md-3 col-sm-4 col-6">
                                            <div class="meet_tutors_items">
                                                <a href="#" class="tutor-cross"><img
                                                        src="{{ public_asset('assets/images/cross.png') }}"></a>
                                                <div class="meet_tutors_img">
                                                    <span>
                                                        @if (@$val->profile_pic)
                                                            <em>
                                                                <img src="{{ url('/') }}/storage/teacher_profile_pic/{{ @$val->profile_pic }}"
                                                                    alt="profile_img" style="width: 100%;height: 100%">
                                                            </em>
                                                        @elseif(!@$val->profile_pic && @$val->avatar)
                                                            <em>
                                                                <img src="{{ @$val->avatar }}" alt="profile_img"
                                                                    style="width: 100%">
                                                            </em>
                                                        @else
                                                            <em>
                                                                <img src="{{ public_asset('assets/images/blank1.png') }}"
                                                                    alt="profile_img" style="width: 100%">
                                                            </em>
                                                        @endif

                                                    </span>
                                                </div>
                                                <div class="meet_tutors_text">
                                                    <h4> <a href="#url"> {{ @$val->f_name }} {{ @$val->l_name }}</a>
                                                    </h4>

                                                </div>
                                                <a href="{{ route('student.my.review', @$val->slug) }}"
                                                    class="postr">Post a review?</a>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div> --}}
                            {{-- end --}}
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
    <script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>
    {{-- for datatable --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    {{-- for validation --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>
    <script>
        oTable = $('#example').DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No data available",
                "info": "",
                "infoEmpty": "",
                "infoFiltered": "" 
            },
            dom: '<"top"f>t<"bottom row"<"col-12 d-flex justify-content-end"p>>',
        });
        if (oTable.rows().data().length === 0) {
            $(oTable.table().container())
                .find('.dataTables_paginate')
                .hide();
        }
    </script>
    <script>
        function fun(id) {
            $('.show-actions').slideUp();
            $("#show-action" + id).show();
        }

        function Cancel(id) {
            $("#show-action" + id).hide();
        }
        $(document).mouseup(function(e) {
            var container = $(".show-actions");
            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.hide();
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_he.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#frm').validate({
                ignore: "",
                rules: {
                    ratting: {
                        required: true,
                        //minlength:3
                    },
                    message: {
                        required: true,
                    },
                },
                messages: {

                    ratting: {
                        required: "This field is required",
                        //minlength:3
                    },
                    message: {
                        required: "This field is required",
                    }
                },
                submitHandler: function(form) {
                    var words = 0;
                    if (($('#txt').value.match(/\S+/g)) != null) {
                        words = $('#txt').value.match(/\S+/g).length;
                    }
                    if (words > 100) {
                        var trimmed = $('#txt').val().split(/\s+/, 100).join(" ");
                        $('#txt').val(trimmed + " ");
                    }

                    // forbiddenWords.forEach(function(val, index) {
                    //   if (e.target.value.toUpperCase().indexOf(val.toUpperCase()) >= 0) {
                    //     e.target.value = e.target.value.replace(new RegExp( "(" + val + ")" , 'gi' ), '');
                    //   }
                    // });
                    var badWords = [];
                    @foreach (@$bad as $value)
                        badWords.push('{{ $value }}');
                    @endforeach
                    var isChec = 1;
                    badWords.push('email');
                    badWords.push('phone');
                    badWords.push('reach');
                    badWords.push('call');
                    badWords.push('gmail');
                    badWords.push('.net');
                    badWords.push('.com');
                    var wordInput = document.getElementById("txt").value;
                    wordInput = wordInput.toLowerCase();

                    // split the words by spaces (" ")
                    var arr = wordInput.split(" ");
                    // bad words to look for, keep this array in lowercase
                    //var badWords = ["legos", "cloud", "manifold"];

                    // .toLowerCase will do the case insensitive match!
                    var foundBadWords = arr.filter(el => badWords.includes(el));
                    // console.log(foundBadWords.length,foundBadWords.join(", "));
                    if (foundBadWords.length > 0) {
                        $('#bad').html('You can not use this word ' + foundBadWords.join(", ") +
                            ' to review section.!');
                        // alert('You can not use this word '+foundBadWords.join(", ")+ ' to review section.!');
                        return false;

                        // badWords.forEach(function(val, index) {
                        //    if (e.target.value.toUpperCase().indexOf(val.toUpperCase()) >= 0) {
                        //      e.target.value = e.target.value.replace(new RegExp( "(" + val + ")" , 'gi' ), '');
                        //    }
                        //  });
                    } else {
                        var wordInput = textarea.val();
                        wordInput = wordInput.toLowerCase();
                        var arr = wordInput.split(" ");

                        $.each(arr, function(_, t) {
                            if (/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(t
                                    .toLowerCase())) {
                                isChec = 0;
                                $(".error_textarea").html(
                                    'Kindly refrain from using email, phone or flagged words on the description!'
                                );
                                textarea.val("");
                                return false;

                            }

                            if (/^[+]?\d+$/.test(t.toLowerCase())) {
                                isChec = 0;
                                $(".error_textarea").html(
                                    'Kindly refrain from using email, phone or flagged words on the description!'
                                );
                                textarea.val("");
                                return false;
                            }
                            if (t.includes(".net")) {
                                isChec = 0;
                                $(".error_textarea").html(
                                    'Kindly refrain from using email, phone or flagged words on the description!'
                                );
                                textarea.val("");
                                return false;
                            }
                            if (t.includes(".com")) {
                                isChec = 0;
                                $(".error_textarea").html(
                                    'Kindly refrain from using email, phone or flagged words on the description!'
                                );
                                textarea.val("");
                                return false;
                            }
                            if (t.includes("gmail")) {
                                isChec = 0;
                                $(".error_textarea").html(
                                    'Kindly refrain from using email, phone or flagged words on the description!'
                                );
                                textarea.val("");
                                return false;
                            }
                            if (t.match("\d{10}")) {
                                isChec = 0;
                                $(".error_textarea").html(
                                    'Kindly refrain from using email, phone or flagged words on the description!'
                                );
                                textarea.val("");
                                return false;
                            }
                        });
                        if (isChec == 1) {
                            form.submit();
                        }

                    }




                },
                /////////
            });
        });
    </script>
    <script>
        //console.log(forbiddenWords);



        //var forbiddenWords = ['Phone', 'Home', 'Address'];
        //
    </script>
    <script type="text/javascript">
        function fair(id) {
            console.log(id);
            if (id == 1) {
                document.getElementById('f1').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f2').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                document.getElementById('f3').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                document.getElementById('f4').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                document.getElementById('f5').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                $('#ratting').val(id);
            }
            if (id == 2) {
                document.getElementById('f1').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f2').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f3').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                document.getElementById('f4').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                document.getElementById('f5').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                $('#ratting').val(id);
            }
            if (id == 3) {
                document.getElementById('f1').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f2').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f3').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f4').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                document.getElementById('f5').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                $('#ratting').val(id);
            }
            if (id == 4) {
                document.getElementById('f1').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f2').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f3').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f4').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f5').src = '{{ public_asset('assets/images/rating/rating2.png') }}';
                $('#ratting').val(id);
            }
            if (id == 5) {
                document.getElementById('f1').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f2').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f3').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f4').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                document.getElementById('f5').src = '{{ public_asset('assets/images/rating/rating1.png') }}';
                $('#ratting').val(id);
            }
        }
    </script>
    <script>
        function readmore(id) {
            //alert('j');
            $("#desc" + id).slideToggle("slow");
            $("#rr" + id).hide();
            $("#rrr" + id).show();

        }

        function readless(id) {
            //alert('j');
            $("#desc" + id).slideToggle("slow");
            $("#rr" + id).show();
            $("#rrr" + id).hide();

        }
    </script>
    <script type="text/javascript">
        function check() {
            var badWords = [];

            @foreach (@$bad as $value)
                badWords.push('{{ $value }}');
            @endforeach
            badWords.push('email');
            badWords.push('phone');
            badWords.push('reach');
            badWords.push('call');
            badWords.push('gmail');
            badWords.push('.net');
            badWords.push('.com');
            // console.log(badWords);
            var wordInput = $.trim(textarea.val());
            wordInput = wordInput.toLowerCase();
            var arr = wordInput.split(" ");
            var foundBadWords = arr.filter(el => badWords.includes(el));

            if (foundBadWords.length > 0) {
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");

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

                if (/^[+]?\d+$/.test(t.toLowerCase())) {
                    $(".error_textarea").html(
                        'Kindly refrain from using email, phone or flagged words on the description!');
                    textarea.val("");
                }
                if (t.includes(".net")) {
                    $(".error_textarea").html(
                        'Kindly refrain from using email, phone or flagged words on the description!');
                    textarea.val("");
                }
                if (t.includes(".com")) {
                    $(".error_textarea").html(
                        'Kindly refrain from using email, phone or flagged words on the description!');
                    textarea.val("");
                }
                if (t.includes("gmail")) {
                    $(".error_textarea").html(
                        'Kindly refrain from using email, phone or flagged words on the description!');
                    textarea.val("");
                }
                if (t.match("\d{10}")) {
                    $(".error_textarea").html(
                        'Kindly refrain from using email, phone or flagged words on the description!');
                    textarea.val("");
                }
            });

        }
        var textarea = $('#txt');
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
        $('.nocopypaste').bind('copy paste', function(e) {

            e.preventDefault();
            return false;

        });
    </script>
@endsection

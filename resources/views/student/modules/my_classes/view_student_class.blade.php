@extends('layouts.app')



@section('title')
    <title>V-Tutor  | Student | View Class Details | {{ @$bookingDataInformation->booking_no }}</title>
@endsection
@php
    use Carbon\Carbon;
    // Convert user time strings back to Carbon instances for accurate comparison
    $fromTime = Carbon::parse($bookingDataInformation->from_time_user);
    $toTime = Carbon::parse($bookingDataInformation->to_time_user);
    $bookingDate = Carbon::parse($bookingDataInformation->booking_date);
@endphp



@section('left_part')
    {{-- @include('include.student_top_common') --}}
@include('include.header_menu_part')

    <style type="text/css">
        .overflowtext {
            overflow-wrap: break-word;
        }

        .breaktext {
            word-break: break-all;
        }
    </style>
    <style type="text/css">
        .textLimit {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    </style>
@endsection



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
                            <div class="user-right-top-new ">
                                @include('include.errors')
                                <h2 class="profile-heading">Session Details <a href="{{ url()->previous() }}" class="pg_btn gj_back_div">Back</a></h2>



                                <p class="gj_sub_hd"> You can find details of the session in this section</p>



                            </div>



                            <div class="class-feild">
                                <div class="row">
                                    <div class="col-lg-9 col-md-8">
                                        <div class="tuto-rating">
                                            <em>
                                                @if (@$bookingDataInformation->getTutor->profile_pic)
                                                @php
                                                $image_path =
                                                'assets/images/all_avatars/' . @$bookingDataInformation->getTutor->profile_pic;
                                                @endphp
                                                @if (file_exists(@$image_path))
                                                <img src="{{ public_asset('assets/images/all_avatars/' . @$bookingDataInformation->getTutor->profile_pic) }}"
                                                    alt="profile_img">
                                                @else
                                               <img src="{{ asset('storage/teacher_profile_pic/' . @$bookingDataInformation->getTutor->profile_pic) }}" alt="">
                                                @endif
                                                @else
                                                @if (@$bookingDataInformation->getTutor->avatar)
                                                <img src="{{ @$bookingDataInformation->getTutor->avatar }}" alt="" id="img2">
                                                @else
                                                <img src="{{ public_asset('assets/images/user-pro.png') }}" alt="" id="img2">
                                                @endif
                                                @endif
                                            </em>
                                            <div class="tu-info">
                                                <h2>{{ @$bookingDataInformation->getTutor->f_name }} {{ @$bookingDataInformation->getTutor->l_name }}</h2>
                                                <div class="sed">
                                                    <input type="hidden" id="tutor_id" value="{{ @$bookingDataInformation->getTutor->id }}">
                                                    <span><img src="{{ public_asset('assets/images/map.png') }}">
                                                        @if (@$bookingDataInformation->getTutor->getState->state_name)
                                                        @if (@$bookingDataInformation->getTutor->getState->state_name == 'New South Wales')
                                                        NSW
                                                        @elseif(@$bookingDataInformation->getTutor->getState->state_name == 'Victoria')
                                                        VIC
                                                        @elseif(@$bookingDataInformation->getTutor->getState->state_name == 'Queensland')
                                                        QLD
                                                        @elseif(@$bookingDataInformation->getTutor->getState->state_name == 'South Australia')
                                                        SA
                                                        @elseif(@$bookingDataInformation->getTutor->getState->state_name == 'Western Australia')
                                                        WA
                                                        @elseif(@$bookingDataInformation->getTutor->getState->state_name == 'Tasmania')
                                                        TAS
                                                        @elseif(@$bookingDataInformation->getTutor->getState->state_name == 'Northern Territory')
                                                        NT
                                                        @elseif(
                                                        @$bookingDataInformation->getTutor->getState->state_name ==
                                                        'Australian Capital
                                                        Territory')
                                                        ACT
                                                        @endif
                                                        @endif
                                                    </span>

                                                    <ul class="profile-rating m-0">
                                                        @if (@$bookingDataInformation->getTutor->avg_review >= 0 && @$bookingDataInformation->getTutor->avg_review <= 0.24) <li><a
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
                                                            @if (@$bookingDataInformation->getTutor->avg_review >= 0.25 && @$bookingDataInformation->getTutor->avg_review <= 0.74)
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
                                                                @if (@$bookingDataInformation->getTutor->avg_review >= 0.75 && @$bookingDataInformation->getTutor->avg_review <= 1.24)
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
                                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 1.25 && @$bookingDataInformation->getTutor->avg_review <=
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
                                                                        @if (@$bookingDataInformation->getTutor->avg_review >= 1.75 && @$bookingDataInformation->getTutor->avg_review
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
                                                                            @if (@$bookingDataInformation->getTutor->avg_review >= 2.25 &&
                                                                            @$bookingDataInformation->getTutor->avg_review <= 2.74) <li><a href="#"><img
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
                                                                                @if (@$bookingDataInformation->getTutor->avg_review >= 2.75 &&
                                                                                @$bookingDataInformation->getTutor->avg_review <= 3.24) <li><a
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
                                                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 3.25 &&
                                                                                    @$bookingDataInformation->getTutor->avg_review <= 3.74) <li><a
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
                                                                                        @if (@$bookingDataInformation->getTutor->avg_review >= 3.75 &&
                                                                                        @$bookingDataInformation->getTutor->avg_review <= 4.24) <li><a
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
                                                                                            @if (@$bookingDataInformation->getTutor->avg_review >= 4.25 &&
                                                                                            @$bookingDataInformation->getTutor->avg_review <= 4.74) <li><a
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
                                                                                                @if (@$bookingDataInformation->getTutor->avg_review >= 4.75
                                                                                                && @$bookingDataInformation->getTutor->avg_review <= 5)
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
                                                                                                            @$bookingDataInformation->getTutor->avg_review
                                                                                                            }}
                                                                                                            ({{
                                                                                                            @$bookingDataInformation->getTutor->total_no_of_reviews
                                                                                                            }})</p>
                                                                                                    </li>
                                                    </ul>
                                                </div>
                                                <div class="sed ">
                                                </div>
                                                <div class="sed grade_sed">
                                                    <span><img src="{{ public_asset('assets/images/gra.png') }}">
                                                        {{ @$bookingDataInformation->getStudentGrade->grade_name }}</span>

                                                </div>
                                                <div class="sed">
                                                    @php
                                                    $todayDayIndex = @$todayDayIndex; // 1 (Mon) to 7 (Sun)
                                                    @endphp

                                                    <img src="{{ public_asset('assets/images/world.png') }}">
                                                    @if (@$t_my_av_show && count($t_my_av_show) > 0)
                                                    {{-- Nav Tabs --}}
                                                    <ul class="nav nav-tabs me-3 flex-wrap" id="availabilityTab" role="tablist">
                                                        @foreach ($t_my_av_show as $day => $slots)
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link {{ $day == $todayDayIndex ? 'active' : '' }}"
                                                                id="tab-{{ $day }}-tab" data-toggle="tab" href="#tab-{{ $day }}"
                                                                role="tab" aria-controls="tab-{{ $day }}"
                                                                aria-selected="{{ $day == $todayDayIndex ? 'true' : 'false' }}">
                                                                {{ $shortDayNames[$day] }}
                                                            </a>
                                                        </li>
                                                        @endforeach
                                                    </ul>

                                                    {{-- Tab Content --}}
                                                    @else
                                                    <h4>No Availability</h4>
                                                    @endif


                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        <div class="availability">
                                            @if (@$t_my_av_show)
                                            <div class="tab-content" id="availabilityTabContent">
                                                @foreach ($t_my_av_show as $day => $slots)
                                                <div class="tab-pane fade {{ $day == $todayDayIndex ? 'show active' : '' }}"
                                                    id="tab-{{ $day }}" role="tabpanel" aria-labelledby="tab-{{ $day }}-tab">

                                                    <h5>{{ $dayNames[$day] }} Availability</h5>
                                                    <ul class="list-group mt-2">
                                                        @if (count($slots) > 0)
                                                        @foreach ($slots as $slot)
                                                        <li class="list-group-item">
                                                            {{ \Carbon\Carbon::parse($slot->from_time_student)->format('g:i A')
                                                            }}
                                                            -
                                                            {{-- {{ \Carbon\Carbon::parse($slot->to_time_student)->format('g:i A') }} --}}
                                                            {{ \Carbon\Carbon::parse($slot->to_time_student)->greaterThan(\Carbon\Carbon::createFromFormat('H:i', config('sessionsettings.max_end_time')))
                                                                ? \Carbon\Carbon::createFromFormat('H:i', config('sessionsettings.max_end_time'))->format('g:i A')
                                                                : \Carbon\Carbon::parse($slot->to_time_student)->format('g:i A')
                                                                }}
                                                        </li>
                                                        @endforeach
                                                        @else
                                                        <li class="list-group-item">No Slots Available</li>
                                                        @endif
                                                    </ul>
                                                </div>
                                                @endforeach
                                            </div>
                                            @else
                                            <h4>No Availability</h4>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>





                            <div class="user-right-top-new marb90 text-center">



                                {{-- <img src="{{ public_asset('assets/images/confr.png') }}"> --}}



                                {{-- <h2 class="profile-headingnew">Session Details </h2> --}}



                                {{-- <p>Please find details of the session below</p> --}}

                                {{-- <div class="backBtnCls"><a href="{{ url()->previous() }}" class="pg_btn">Back</a></div> --}}

                                <div class="booking-stat table_book">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Booking ID </th>
                                                    <th>Academic Program</th>
                                                    <th>Grade</th>
                                                    <th>Subject</th>
                                                    <th class="view_details_date">Date</th>
                                                    <th class="view_details_time">Time</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th class="view_details_ses">Session</th>
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td>{{ @$bookingDataInformation->booking_no }}</td>
                                                <td>@if($bookingDataInformation->is_academic_program == 1 
                                                        && $bookingDataInformation->academicProgramPurchase 
                                                        && $bookingDataInformation->academicProgramPurchase->academicProgram)
                                                            {{ $bookingDataInformation->academicProgramPurchase->academicProgram->name }}
                                                    @else
                                                        No
                                                    @endif
                                                </td>
                                                {{-- <td>{{ @$bookingDataInformation->getTutor->f_name }} {{
                                                @$bookingDataInformation->getTutor->l_name }}</td> --}}
                                                <td>@if($bookingDataInformation->is_academic_program == 1 
                                                        && $bookingDataInformation->academicProgramPurchase 
                                                        && $bookingDataInformation->academicProgramPurchase->academicProgram)

                                                        {{ $bookingDataInformation->academicProgramPurchase->academicProgram->grade->grade_name ?? 'N/A' }}

                                                        @else
                                                            {{ @$bookingDataInformation->getStudentGrade->grade_name }}
                                                        @endif
                                                </td>
                                                <td>@if($bookingDataInformation->is_academic_program == 1 
                                                        && $bookingDataInformation->academicProgramPurchase 
                                                        && $bookingDataInformation->academicProgramPurchase->academicProgram)

                                                            {{ $bookingDataInformation->academicProgramPurchase->academicProgram->branch->branch_name ?? 'N/A' }}

                                                        @else
                                                            {{ @$bookingDataInformation->getSubject->subject }}
                                                    @endif
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime(@$bookingDataInformation->booking_date_user)) }}</td>
                                                <td>{{ date('h:i a', strtotime(@$bookingDataInformation->from_time_user)) }} to
                                                    {{ date('h:i a', strtotime(@$bookingDataInformation->to_time_user)) }}</td>
                                                <!-- <td>${{ number_format(@$bookingDataInformation->booking_amount + @$bookingDataInformation->stripe_charge,2)  }}</td> -->
                                                <td>@if($bookingDataInformation->is_academic_program == 1)
                                                        -
                                                    @else
                                                     {{   number_format(@$bookingDataInformation->booking_amount + @$bookingDataInformation->stripe_charge,2) }}
                                                    @endif
                                                </td>
                                                <td
                                                @if (@$bookingDataInformation->booking_status == 'B' || @$bookingDataInformation->booking_status == 'CM')   class="text-success" @else class="text-warning" @endif >                                            {{-- @elseif(@$bookingDataInformation->booking_status == 'C')
                                                cancelled_red_color
                                                @elseif()
                                                completed_green_color
                                                @else
                                                progress @endif"> --}}
                                                    @if (@$bookingDataInformation->booking_status == 'IC')
                                                        Incomplete
                                                    @elseif(@$bookingDataInformation->booking_status == 'B')
                                                        Booked
                                                    @elseif(@$bookingDataInformation->booking_status == 'CM')
                                                        @if (@$bookingDataInformation->booking_status == 'CM' && @$bookingDataInformation->class_assessment_student == 'N')
                                                            <a href="{{ route('student.class.end.assesment', $bookingDataInformation->booking_no) }}"
                                                                class="red_link">Review</a>
                                                        @else
                                                            Completed
                                                        @endif
                                                    @elseif(@$bookingDataInformation->booking_status == 'C')
                                                        Cancelled
                                                    @elseif(@$bookingDataInformation->booking_status == 'F')
                                                        Failed
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (@$bookingDataInformation->booking_status == 'C')
                                                            <li class="pointerEventsNone addDisablePhone">
                                                                <a target="_blank" href="#" class="">
                                                                    {{-- {{ route('class.session.link',@$val->id) }} --}}
                                                                    Click to join
                                                                </a>

                                                            </li>
                                                        @else
                                                            @if (date('Y-m-d', strtotime(@$bookingDataInformation->booking_date_user)) < date('Y-m-d'))
                                                                <li>Expired</li>
                                                            @else
                                                                <li>
                                                                    <a target="_blank"
                                                                        href="{{ route('tutor.class.session.link', ['userid' => Auth()->user()->unique_id, 'id' => @$bookingDataInformation->booking_no]) }}">
                                                                        {{-- {{ route('tutor.class.session.link',@$bookingDataInformation->id) }} --}}
                                                                        Click to join
                                                                    </a>

                                                                </li>
                                                            @endif
                                                        @endif
                                                    {{-- @if ($bookingDataInformation->booking_status === 'B' && $now->between(@$bookingDataInformation->from_time_user, @$bookingDataInformation->to_time_user))
                                                        <li>
                                                            <a target="_blank"
                                                                href="{{ route('class.session.link', ['userid' => Auth()->user()->unique_id, 'id' => $bookingDataInformation->booking_no]) }}">
                                                                Join
                                                            </a>
                                                        </li>
                                                    @elseif (
                                                        $bookingDataInformation->booking_status === 'B' &&
                                                            $now->greaterThanOrEqualTo(@$bookingDataInformation->to_time_user))
                                                        <li>
                                                        Expired
                                                        </li>
                                                    @elseif ($bookingDataInformation->booking_status === 'B' && $bookingDate->isToday() && $now->lessThanOrEqualTo($toTime))
                                                        <li>
                                                            <a target="_blank"
                                                                href="{{ route('class.session.link', ['userid' => Auth()->user()->unique_id, 'id' => $bookingDataInformation->booking_no]) }}">
                                                                Join
                                                            </a>
                                                        </li>
                                                    @elseif ($bookingDataInformation->booking_status === 'B' && $bookingDate->greaterThan(Carbon::today()))
                                                        <li>
                                                            <a target="_blank"
                                                                href="{{ route('class.session.link', ['userid' => Auth()->user()->unique_id, 'id' => $bookingDataInformation->booking_no]) }}">
                                                                Join
                                                            </a>
                                                        </li>
                                                    @endif --}}

                                                </td>

                                            </tr>
                                        </table>

                                        <div class="btn_3_cc gj_cl_ba_div">
                                            <div class="gj_cl_ba_div1">
                                                @if (@$bookingDataInformation->booking_date >= date('Y-m-d'))
                                                    @if (@$bookingDataInformation->booking_status == 'B')
                                                        @if (@$bookingDataInformation->booking_date == date('Y-m-d') && @$bookingDataInformation->to_time > date('H:i:s'))
                                                            <a data-toggle="modal" data-target="#cancelPopup" href="#"
                                                                class="sub_btn new-subbtn">Cancel Booking</a>
                                                        @else
                                                            <a data-toggle="modal" data-target="#cancelPopup" href="#"
                                                                class="sub_btn new-subbtn">Cancel Booking</a>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>

                                            <div class="gj_cl_ba_div2">
                                                <a class="sub_btn new-subbtn" href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . optional(@$bookingDataInformation->getTutor)->slug . '&search_tutor_id_studentclass=' . optional(@$bookingDataInformation->getTutor)->id) }}">Book Again</a>
                                            </div>

                                            {{-- @if (@$bookingDataInformation->booking_date >= date('Y-m-d'))
                                                @if (@$bookingDataInformation->booking_status == 'B')
                                                    @if (@$bookingDataInformation->booking_date == date('Y-m-d') && @$bookingDataInformation->to_time > date('H:i:s'))
                                                        <a data-toggle="modal" data-target="#cancelPopup" href="#"
                                                            class="sub_btn new-subbtn">Cancel Booking</a>
                                                    @else
                                                        <a data-toggle="modal" data-target="#cancelPopup" href="#"
                                                            class="sub_btn new-subbtn">Cancel Booking</a>
                                                    @endif
                                                @endif
                                            @endif
                                            @php
                                                $getTutorGrades = @$bookingDataInformation->getTutor->getTutorShipPlan
                                                    ->pluck('grade_id')
                                                    ->toArray();
                                                $mGrade = @Auth::user()->grade;

                                            @endphp

                                            @if (@$bookingDataInformation->getTutor->status == 'A')
                                                @if (@$admin_disable_bookings_values->disable_booking == 'Y')
                                                    <li><a class="open_popup_g sub_btn new-subbtn" data-toggle="modal"
                                                            data-target="#admin_disabled_bookings_popup"
                                                            href="javascript:void(0);">Book
                                                            again</a></li>
                                                @elseif(in_array(date('Y-m-d'), $all_disabled_booking_dates))
                                                    <li><a class="open_popup_g sub_btn new-subbtn" data-toggle="modal"
                                                            data-target="#admin_disabled_bookings_popup"
                                                            href="javascript:void(0);">Book
                                                            again</a></li>
                                                @elseif(!in_array($mGrade, $getTutorGrades))
                                                    <li><a class="open_popup_g sub_btn new-subbtn" data-toggle="modal"
                                                            data-target="#not_b_popup" href="javascript:void(0);">Book Again </a>
                                                    </li>
                                                @endif
                                            @endif --}}
                                        </div>

                                        <div class="session-info"
                                            style="margin-top: 30px; padding: 20px; background-color: #f9f9f9; border-radius: 8px;">
                                            <h4>Session Plan</h4>
                                            <p><strong>1. Grade:</strong>
                                               @if($bookingDataInformation->is_academic_program == 1 
                                                    && $bookingDataInformation->academicProgramPurchase 
                                                    && $bookingDataInformation->academicProgramPurchase->academicProgram)
                                                        {{ $bookingDataInformation->academicProgramPurchase->academicProgram->grade->grade_name ?? 'N/A' }}
                                                @else
                                                    {{ $bookingDataInformation->getStudentGrade->grade_name ?? 'N/A' }}
                                                @endif
                                            <p><strong>2. Subject:</strong>
                                                @if($bookingDataInformation->is_academic_program == 1 
                                                    && $bookingDataInformation->academicProgramPurchase 
                                                    && $bookingDataInformation->academicProgramPurchase->academicProgram)
                                                        {{ $bookingDataInformation->academicProgramPurchase->academicProgram->branch->branch_name ?? 'N/A' }}
                                                @else
                                                    {{ $bookingDataInformation->getSubject->subject ?? 'N/A' }}
                                                @endif
                                            </p>
                                            {{-- <p><strong>1. Subject Area (ID):</strong> --}}
                                            <p><strong>3. Session Topic:</strong>
                                                {{ $bookingDataInformation->getSubjectTopics->topics ?? 'N/A' }}</p>
                                            <p><strong>4. Session Focus:</strong>
                                                @if (isset($bookingDataInformation->getTopicDetails->topic_det_code) && $bookingDataInformation->getTopicDetails->topic_det_code)
                                                    @if (isset($bookingDataInformation->getTopicDetails->session_focus) && $bookingDataInformation->getTopicDetails->session_focus)
                                                        {{ $bookingDataInformation->getTopicDetails->topic_det_code ?? '' }} - {{ $bookingDataInformation->getTopicDetails->session_focus ?? '' }}
                                                    @else
                                                        {{ $bookingDataInformation->getTopicDetails->topic_det_code ?? 'N/A' }}
                                                    @endif
                                                @else
                                                    {{ $bookingDataInformation->getTopicDetails->session_focus ?? 'N/A' }}
                                                @endif
                                            </p>
                                            <p><strong>5. Session Outcome:</strong>
                                                {{ $bookingDataInformation->getTopicDetails->learning_outcome ?? 'N/A' }}</p>

                                            <p><strong>6. Description & Problems Faced:</strong>
                                                {{ $bookingDataInformation->problem_areas ?? 'N/A' }}</p>

                                        </div>
                                    </div>
                                </div>
                        <!-- Student feedback details -->
                                @if($bookingDataInformation->session_summary && $bookingDataInformation->session_recommendations && $bookingDataInformation->permission_grade)
                                <div class="session-info"
                                    style="margin-top: 10px; padding: 20px; width:100%; background-color: #f9f9f9; border-radius: 8px;">

                                    <h4>Session Feedback - Details</h4>

                                    <p><strong>Performance Grade:</strong>
                                       @if (isset($bookingDataInformation->permission_grade) && $bookingDataInformation->permission_grade == 1)
                                                    1 - Beginning
                                                @elseif (isset($bookingDataInformation->permission_grade) && $bookingDataInformation->permission_grade == 2)
                                                    2 - Developing
                                                @elseif (isset($bookingDataInformation->permission_grade) && $bookingDataInformation->permission_grade == 3)
                                                    3 - Proficient
                                                @elseif (isset($bookingDataInformation->permission_grade) && $bookingDataInformation->permission_grade == 4)
                                                    4 - Strong
                                                @elseif (isset($bookingDataInformation->permission_grade) && $bookingDataInformation->permission_grade == 5)
                                                    5 - Mastery
                                                @else
                                                    N/A
                                                @endif
                                    </p>

                                    <p><strong>Session Feedback:</strong></p>
                                    <div>
                                    <p>{!! nl2br(e($bookingDataInformation->session_summary ?? 'N/A')) !!}</p>
                                    </div>

                                    <p><strong>Session Recommendations:</strong></p>
                                    <div><p>
                                        {!! nl2br(e($bookingDataInformation->session_recommendations ?? 'N/A')) !!}</p>
                                    </div>


                                </div>
                            @endif
                           <!-- Student feedback details End -->
                                <div class="booking-stat table_book">
                                    <div class="table-responsive">
                                        @if (@$bookingDataInformation->booking_status == 'C')
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Refund Id</th>
                                                        <th>Refund Amount</th>
                                                        <th>Cancelled By</th>
                                                        <th>Cancelled On</th>
                                                        <th>Refund Status</th>

                                                        {{-- <th class="">Transaction Id</th> --}}
                                                        {{-- <th class="">Paid Via</th> --}}
                                                        {{-- <th>Status</th> --}}
                                                    </tr>
                                                </thead>
                                                <tr>
                                                    <td>
                                                        @if (@$bookingDataInformation->getPaymentsInfo->refund_id)
                                                            {{ @$bookingDataInformation->getPaymentsInfo->refund_id }}
                                                        @else
                                                            No refund
                                                        @endif
                                                    </td>
                                                    <td>${{ number_format(@$bookingDataInformation->getPaymentsInfo->refund_amount ?? 0, 2) }}</td>
                                                    <td>
                                                        @if (@$bookingDataInformation->cancelled_by == 'S')
                                                            {{ @$bookingDataInformation->getStudent->parent_f_name }}
                                                            {{ @$bookingDataInformation->getStudent->parent_l_name }}
                                                        @elseif(@$bookingDataInformation->cancelled_by == 'T')
                                                            {{ @$bookingDataInformation->getTutor->f_name }}
                                                            {{ @$bookingDataInformation->getTutor->l_name }}
                                                        @elseif(@$bookingDataInformation->cancelled_by == 'A')
                                                            Admin
                                                        @endif
                                                    </td>
                                                    <td>{{ @$bookingDataInformation->cancelled_on }}</td>
                                                    <td>
                                                        {{-- @if (@$bookingDataInformation->getPaymentsInfo->refund_id)
                                                @php
                                                $paidVia =
                                                json_decode(@$bookingDataInformation->getPaymentsInfo->refund_response);
                                                @endphp
                                                {{strtoupper(@$paidVia->status)}}
                                                @else
                                                No refund
                                                @endif --}}
                                                        @if (@$bookingDataInformation->getPaymentsInfo->refund_amount <= 0)
                                                            No Refund
                                                        @elseif(@$bookingDataInformation->getPaymentsInfo->refund_amount == @$bookingDataInformation->booking_amount)
                                                            Full Refund
                                                        @elseif(
                                                            @$bookingDataInformation->getPaymentsInfo->refund_amount != @$bookingDataInformation->booking_amount &&
                                                                @$bookingDataInformation->getPaymentsInfo->refund_amount > 0)
                                                            Partial Refund
                                                        @endif
                                                    </td>


                                                </tr>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection
@section('footer')
    @include('include.footer')
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
                                        You cannot book this tutor since they are outside your State / Timezone. Try to book
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
    <div class="modal res-modal newqusmo" id="cancelPopup">
        <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Booking Cancellation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class=" proDiv" id="warningTextDiCancel">
                            <span class="proclosespan">Cancel Booking</span>
                            <h6></h6>
                            <p>You have chosen to cancel your booking. If yes, please confirm. If this is by accident,
                                kindly ignore.</p>
                            <p><em>Cancellation of sessions is subject to’ V-Tutor cancellation policy. V-Tutor cancellation
                                    policy. Refunds are subject to conditions. Refer to the policy from the Help section for
                                    more details.</em></p>

                            <div class="next-btn1 newst_btn-pop">
                                {{-- {{ route('student.cancel.class.booking',@$val->booking_no) }} --}}
                                <a href="{{ route('student.cancel.class.booking', @$bookingDataInformation->booking_no) }}"
                                    class="btn btn-new btn-danger float-left change-new-link">Yes, please cancel</a>

                                <button type="button" class="btn btn-new btn-danger " data-dismiss="modal">No, don’t
                                    cancel
                                </button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal res-modal newqusmo earlyUpdCls" id="sessionLink">
        <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">You are early!</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class=" proDiv" id="warningTextDiCancel">

                            <h6></h6>
                            <p>Meeting link will be active only 5 minutes before the session</p>
                            <p> Session booked for {{ date('d-m-Y', strtotime(@$bookingDataInformation->booking_date)) }}
                                between
                                {{ date('h:i a', strtotime(@$bookingDataInformation->from_time_user)) }}-{{ date('h:i a', strtotime(@$bookingDataInformation->to_time_user)) }}
                                <timezone>.
                            </p>


                            <div class="next-btn1 newst_btn-pop">

                                <a href="{{ route('student.my.classes') }}" id="cancel_session_link"
                                    class="btn btn-new btn-danger float-left change-new-link"></a>


                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@section('script')
    @include('include.script')
@endsection

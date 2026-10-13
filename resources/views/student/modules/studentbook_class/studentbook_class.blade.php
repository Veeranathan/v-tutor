@extends('layouts.app')


@section('title')
<title>V-Tutor  | Student | Book Session</title>
@endsection
@section('left_part')
{{-- @include('include.student_top_common') --}}
@include('include.header_menu_part')
<style>
    .tooltip-inner {
    font-style: italic !important;
}
    .text-danger {
        font-size: 0.875rem;
        color: red;
        margin-top: 4px;
        display: block;

    }

    .autocomplete-suggestions {
        border: 1px solid #ccc;
        background: white;
        max-height: 200px;
        overflow-y: auto;
        position: absolute;
        z-index: 9999;
        width: 30%;
    }

    .autocomplete-suggestion {
        padding: 8px;
        cursor: pointer;
    }

    .autocomplete-suggestion:hover {
        background: #eee;
    }
</style>
@endsection
@section('content')
<!-- bannersec -->
<!-- bannersec -->
<div class="top_mar pb-5"></div>
<!--- profile --->
<section class="user-account">
    <div class="container">
        <div class="row">
            <div class="zin">
                @include('include.student_left_common')
                <div class="user-right-panel ">
                    <div class="user-right-top-new tranhis">
                        <h2 class="profile-heading fw-400">Book a Session</h2>
                        <!--h4 class="mt-2 mb-0 fw-400 w-100">Stutent Time : {{ @$studentz }}</h4>

                        <h4 class="mt-2 mb-0 fw-400 w-100">Tutor Time : {{ @$tutorz }}</h4-->
                        @php
                        $myGrade = \App\Models\Grade::where(['id' => Auth::user()->grade, 'status' => 'A'])
                        ->select('id', 'slug', 'status')
                        ->first();

                        @endphp
                        <div class="float-right" style="margin-right: 10px;">
                            <a class="deen" href="{{ url('tutor-search-result?grade=' . @$myGrade->slug) }}"
                                style="color: white;">Back</a>
                        </div>
                        <p class="gj_sub_hd mt-2">You can book your sessions in this section</p>

                        @include('include.errors')
                    </div>
                    @if (@$vtutor)
                    <div class="class-feild">
                        <div class="row">
                            <div class="col-lg-9 col-md-8">
                                <div class="tuto-rating">
                                    <em>
                                        @if (@$vtutor->profile_pic)
                                        @php
                                        $image_path =
                                        'assets/images/all_avatars/' . @$vtutor->profile_pic;
                                        @endphp
                                        @if (file_exists(@$image_path))
                                        <img src="{{ public_asset('assets/images/all_avatars/' . @$vtutor->profile_pic) }}"
                                            alt="profile_img">
                                        @else
                                        <img src="{{ env('STORAGE_URL') . '/teacher_profile_pic/' . @$vtutor->profile_pic }}"
                                            alt="">
                                        @endif
                                        @else
                                        @if (@$vtutor->avatar)
                                        <img src="{{ @$vtutor->avatar }}" alt="" id="img2">
                                        @else
                                        <img src="{{ public_asset('assets/images/user-pro.png') }}" alt="" id="img2">
                                        @endif
                                        @endif
                                    </em>
                                    <div class="tu-info">
                                        <h2>{{ @$vtutor->f_name }} {{ @$vtutor->l_name }}</h2>
                                        <div class="sed">
                                            <input type="hidden" id="tutor_id" value="{{ @$vtutor->id }}">
                                            <span><img src="{{ public_asset('assets/images/map.png') }}">
                                                @if (@$vtutor->getState->state_name)
                                                @if (@$vtutor->getState->state_name == 'New South Wales')
                                                NSW
                                                @elseif(@$vtutor->getState->state_name == 'Victoria')
                                                VIC
                                                @elseif(@$vtutor->getState->state_name == 'Queensland')
                                                QLD
                                                @elseif(@$vtutor->getState->state_name == 'South Australia')
                                                SA
                                                @elseif(@$vtutor->getState->state_name == 'Western Australia')
                                                WA
                                                @elseif(@$vtutor->getState->state_name == 'Tasmania')
                                                TAS
                                                @elseif(@$vtutor->getState->state_name == 'Northern Territory')
                                                NT
                                                @elseif(
                                                @$vtutor->getState->state_name ==
                                                'Australian Capital
                                                Territory')
                                                ACT
                                                @endif
                                                @endif
                                            </span>

                                            <ul class="profile-rating m-0">
                                                @if ($vtutor->avg_review >= 0 && $vtutor->avg_review <= 0.24) <li><a
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
                                                    @if ($vtutor->avg_review >= 0.25 && $vtutor->avg_review <= 0.74)
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
                                                        @if ($vtutor->avg_review >= 0.75 && $vtutor->avg_review <= 1.24)
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
                                                            @if ($vtutor->avg_review >= 1.25 && $vtutor->avg_review <=
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
                                                                @if ($vtutor->avg_review >= 1.75 && $vtutor->avg_review
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
                                                                    @if ($vtutor->avg_review >= 2.25 &&
                                                                    $vtutor->avg_review <= 2.74) <li><a href="#"><img
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
                                                                        @if ($vtutor->avg_review >= 2.75 &&
                                                                        $vtutor->avg_review <= 3.24) <li><a
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
                                                                            @if ($vtutor->avg_review >= 3.25 &&
                                                                            $vtutor->avg_review <= 3.74) <li><a
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
                                                                                @if ($vtutor->avg_review >= 3.75 &&
                                                                                $vtutor->avg_review <= 4.24) <li><a
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
                                                                                    @if ($vtutor->avg_review >= 4.25 &&
                                                                                    $vtutor->avg_review <= 4.74) <li><a
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
                                                                                        @if ($vtutor->avg_review >= 4.75
                                                                                        && $vtutor->avg_review <= 5)
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
                                                                                                    @$vtutor->avg_review
                                                                                                    }}
                                                                                                    ({{
                                                                                                    @$vtutor->total_no_of_reviews
                                                                                                    }})</p>
                                                                                            </li>
                                            </ul>
                                        </div>
                                        <div class="sed ">
                                        </div>
                                        <div class="sed grade_sed">
                                            <span><img src="{{ public_asset('assets/images/gra.png') }}">
                                                {{ @$grade->grade_name }}</span>

                                        </div>
                                        <div class="sed">
                                            @php
                                            $todayDayIndex = @$todayDayIndex; // 1 (Mon) to 7 (Sun)
                                            @endphp

                                            <img src="{{ public_asset('assets/images/world.png') }}">
                                            @if (@$t_my_av_show && count($t_my_av_show) > 0)
                                            {{-- Nav Tabs --}}
                                            <ul class="nav nav-tabs me-3 flex-wrap w-100" id="availabilityTab" role="tablist">
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
                                            <h4>No Schedule</h4>
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

                                            <h5>{{ $dayNames[$day] }} Schedule</h5>
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
                                    <h4>No Schedule</h4>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="booking-section">
                        <div class="user-right-top from_time_div">

                            <form action="{{ url('booking-class') }}/{{ @$vtutor->id }}/{{ @$vtutor->slug }}"
                                id="bookClass" method="get">
                                @csrf
                                <div class="row new_rows no-gutters">
                                    <div class="col-md-4 col-sm-6 from_time_value book_f_t_v form_box_area">
                                        <label>Date</label>
                                        <input id="selected_booked_date" name="selected_booked_date"
                                            class="flatpickr-date  form-control" required>
                                        <span id="error_selected_date_txt" class="text-danger"></span>
                                    </div>
                                    <div class="col-md-4 col-sm-6 from_time_value book_f_t_vs form_box_area">
                                        <label for="start1">From</label>
                                        <select name="from_time" id="start_time_dropdown"
                                            class="flatpickr-date  form-control fromTime" required></select>
                                            {{--
                                            class="fromTime form-control" --}}
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="col-md-4 col-sm-6 from_time_value book_f_t_vs form_box_area">
                                        <label for="end1">To</label>
                                        <select name="to_time" id="end_time_dropdown"
                                            class="toTime required form-control"></select>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="row new_rows no-gutters">
                                    <div class="col-md-4 col-sm-6 from_time_value book_f_t_vs form_box_area">
                                        <label for="subject">Subject </label>
                                        <select id="subject" name="subject_id" class="required form-control">
                                            <option value="">Select Subject </option>
                                            @if (@$subjects)
                                            @foreach (@$subjects as $subject)
                                            <option value="{{ @$subject->getSubject->id }}"
                                                @if (@$book_subject==@$subject->getSubject->slug) selected="" @endif
                                                data-amount="{{ @$subject->hourly_rate }}">
                                                {{ @$subject->getSubject->subject }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="col-md-4 col-sm-6 from_time_value book_f_t_vs form_box_area">
                                        <label for="topic">Session Topic<span
                                                                tooltip=" ACARA-aligned session plans. If your option isn't listed, select the closest match - tutors will tailor the session.">*<i class="qus-cir far fa-question-circle"></i></span></label>
                                        <select id="topic" name="subject_area" class="required form-control">
                                            <option value="">Select one</option>
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>

                                    <div class="col-md-4 col-sm-6 from_time_value book_f_t_vs form_box_area">
                                        <label for="session_focus">Session Focus<span
                                                                tooltip=" ACARA-aligned session plans. If your option isn't listed, select the closest match - tutors will tailor the session. ">*<i class="qus-cir far fa-question-circle"></i></span></label>
                                        <select id="session_focus" name="session_focus" class="required form-control">
                                            <option value="">Select one</option>
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>

                                    {{-- <div class="col-md-4 col-sm-6 from_time_value book_f_t_vs form_box_area gj_amt_div" style="display: none;">
                                        <label>Amount <span class="show_amount" id="show_amount"></span></label>

                                    </div> --}}

                                    <input type="hidden" name="tutor_id" value="{{ @$vtutor->id }}">

                                    <div class="col-md-12 col-sm-6 from_time_value book_f_t_vs form_box_area session_lo_div" style="display: block;">
                                   <label>
    Learning Outcome
    <span
                                                                tooltip="Planned outcome based on your choice. Progress may differ for each student. ">*
        <i class="qus-cir far fa-question-circle"></i>
    </span>
</label>
                                        <input type="text" readonly name="lo" value="" class="form-control" id="session_lo">
                                    </div>
                                </div>

                                {{-- <div class="row new_rows no-gutters">
                                    <div class="col-md-12 col-sm-12 from_select_subject_student_book">
                                        <div class="form_box_area">
                                            <label for="session_topic">Session Focus</label>
                                            <input type="text" name="session_topic" id="session_topics"
                                                class="required form-control" placeholder="Enter session topic here">
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="row new_rows no-gutters">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form_box_area">
                                            <label for="session_description">Areas to Improve</label>
                                            <textarea name="problem_areas" id="session_description"
                                                class="required form-control" rows="4"
                                                placeholder="Share the specific areas your child is finding challenging — for example, topics they struggle with, concepts that seem confusing, or skills that need more practice. This will help tutors prepare and plan sessions that focus on your child’s needs and build their confidence"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row new_rows no-gutters">
                                    <div class="col-md-12 col-sm-12">
                                        <p class="bk_disc"><b>Disclaimer:</b> V-Tutor acts solely as a facilitator and authorised payment agent between parents/students and tutors. All tutoring engagements are directly between the tutor and the parent/student. V-Tutor does not hold funds on trust and accepts no responsibility for tutoring outcomes once payment has been settled.</p>
                                    </div>
                                </div>

                                <div class="btn_3_cc">
                                    <a href="{{ route('student.my.classes') }}" class="sub_btn new-subbtn">My
                                        Sessions</a>
                                    <input type="button" name="" id="studentBookSubmitBtn" value="Book a session"
                                        class="sub_btn new-subbtn">

                                </div>




                            </form>
                        </div>
                        <div class="class-feild mt-3">

                            <div class="row new_rows no-gutters">
                                <div class="col-md-5 col-sm-6">
                                    <div class="form_box_area">
                                        <label>Find V-Tutor</label>
                                        <div class="autocomplete">
                                            <input id="search_tutor_nm_studentclass" class="required"
                                                name="search_tutor_nm_studentclass" type="text"
                                                placeholder="Type tutor name" autocomplete="off"
                                                onfocus="this.removeAttribute('readonly');" readonly=""
                                                onclick="this.removeAttribute('readonly');"
                                                onblur="this.removeAttribute('readonly');" autocomplete="off"
                                                @if (@$vtutor->f_name) value="{{ @$vtutor->f_name . ' ' . @$vtutor->l_name
                                            }}" @else value="" @endif>

                                            <input type="hidden" name="search_tutor_id_studentclass"
                                                id="search_tutor_id_studentclass"
                                                value="{{ $data['vtutor']->id ?? '' }}">
                                            <input type="hidden" name="search_tutor_selected_name_studentclass"
                                                id="search_tutor_selected_name_studentclass"
                                                value="{{ @$vtutor->f_name . ' ' . @$vtutor->l_name }} ">
                                            <input type="hidden" name="search_tutor_slug_studentclass"
                                                id="search_tutor_slug_studentclass" value="{{ @$vtutor->slug }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button id="searchBtn" type="button" class="dash-btn"
                                        style="height: 35px; width: 95px;">
                                        <img src="{{ public_asset('assets/images/ser.png') }}" alt="Search Icon"
                                            style="vertical-align: middle; margin-right: 5px;">
                                        Search
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="user-right-top-new gj_caro_div">
                        <div class="account-area-tutor mt-0">
                            @if (($favs && $favs->count() > 0))
                            <div class="fav_id" id="fav_id">
                                <div class="owl-carousel">

                                    {{-- Loop favourite tutors --}}
                                    @foreach ($favs as $favTutor)
                                    @if ($favTutor->getTutorInfo)
                                    {{-- Prevent null getTutorInfo --}}
                                    @php
                                    $tutorInfo = $favTutor->getTutorInfo;
                                    $tutorGrades =
                                    $tutorInfo->getTutorShipPlan
                                    ->pluck('grade_id')
                                    ->toArray() ?? [];
                                    $userGrade = Auth::user()->grade;
                                    @endphp

                                    @if (in_array($userGrade, $tutorGrades))
                                    <div class="item">
                                        <div class="meet_tutors_items">

                                            {{-- Tutor image --}}
                                            <div class="meet_tutors_img">
                                                <span>
                                                    @php
                                                    $profilePic = $tutorInfo->profile_pic ?? '';
                                                    $image_path = public_path(
                                                    'assets/images/all_avatars/' .
                                                    $profilePic,
                                                    );
                                                    @endphp

                                                    @if ($profilePic && file_exists($image_path))
                                                    <img src="{{ public_asset('assets/images/all_avatars/' . $profilePic) }}"
                                                        alt="profile_img">
                                                    @elseif ($profilePic)
                                                    <img src="{{ env('STORAGE_URL') . '/teacher_profile_pic/' . $profilePic }}"
                                                        alt="">
                                                    @else
                                                    <img src="{{ public_asset('assets/images/searchimg1.jpg') }}"
                                                        alt="">
                                                    @endif
                                                </span>
                                            </div>

                                            {{-- Tutor name --}}
                                            <div class="meet_tutors_text">
                                                <h4>
                                                    <a
                                                        href="{{ url('tutor-public-profile/' . $tutorInfo->slug) }}?search_tutor_id_studentclass={{ $tutorInfo->id }}" target="_blank">
                                                        {{ $tutorInfo->f_name . ' ' . $tutorInfo->l_name }}
                                                    </a>
                                                </h4>
                                            </div>

                                            {{-- Booking logic --}}
                                            {{-- @if ($admin_disable_bookings_values->disable_booking === 'Y')
                                            <a data-toggle="modal" data-target="#admin_disabled_bookings_popup"
                                                href="javascript:void(0);" class="postr">Book my Class</a>
                                            @elseif (in_array(date('Y-m-d'), $all_disabled_booking_dates))
                                            <a data-toggle="modal" data-target="#admin_disabled_bookings_popup"
                                                href="javascript:void(0);" class="postr">Book my Class</a>
                                            @else --}}
                                            <a href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . $tutorInfo->slug . '&search_tutor_id_studentclass=' . $tutorInfo->id) }}"
                                                class="postr">Book a session</a>
                                            {{-- @endif --}}

                                        </div>
                                    </div>
                                    @endif
                                    @endif
                                    @endforeach

                                    {{-- Loop same-grade non-favourite tutors --}}
                                    {{-- @foreach ($gtutors as $tutor)
                                    @php
                                    $tutorGrades = $tutor->getTutorShipPlan->pluck('grade_id')->toArray();
                                    $userGrade = Auth::user()->grade;
                                    @endphp

                                    @if (in_array($userGrade, $tutorGrades))
                                    <div class="item">
                                        <div class="meet_tutors_items">

                                            <div class="meet_tutors_img">
                                                <span>
                                                    @php
                                                    $profilePic = $tutor->profile_pic ?? '';
                                                    $image_path = public_path('assets/images/all_avatars/' .
                                                    $profilePic);
                                                    @endphp

                                                    @if ($profilePic && file_exists($image_path))
                                                    <img src="{{ public_asset('assets/images/all_avatars/' . $profilePic) }}"
                                                        alt="profile_img">
                                                    @elseif($profilePic)
                                                    <img src="{{ env('STORAGE_URL') . '/teacher_profile_pic/' . $profilePic }}"
                                                        alt="">
                                                    @else
                                                    <img src="{{ public_asset('assets/images/searchimg1.jpg') }}"
                                                        alt="">
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="meet_tutors_text">
                                                <h4>
                                                    <a
                                                        href="{{ url('tutor-public-profile/' . $tutor->slug) }}?search_tutor_id_studentclass={{ $tutor->id }}">
                                                        {{ $tutor->f_name . ' ' . $tutor->l_name }}
                                                    </a>
                                                </h4>
                                            </div>


                                            <a href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . $tutor->slug . '&search_tutor_id_studentclass=' . $tutor->id) }}"
                                                class="postr">Book a session</a>


                                        </div>
                                    </div>
                                    @endif
                                    @endforeach --}}

                                </div>
                            </div>
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
                                    You cannot book a session outside your Grade
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
                                    Sorry, this tutor appear to be outside your time zone. You cannot book a class
                                    outside your time zone!
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

<div id="suggestion-box" class="autocomplete-suggestions"></div>
@endsection
@section('script')
@include('include.script')
<script>
    console.log("testing page")
        let originalEndTimes = [];
        const MAX_BOOKING_DURATION = {{ config('sessionsettings.max_booking_duration_minutes') }}; // e.g. 120

        const allAvailableDates = @json($get_available_dates ?? []);
        const disabledDates = @json($all_disabled_booking_dates ?? []);
        const finalDates = allAvailableDates.filter(dateStr => {
            const today = new Date().toISOString().split('T')[0];
            return !disabledDates.includes(dateStr) && dateStr >= today;
        });

        console.log("Today available dates:", finalDates);

        flatpickr("#selected_booked_date", {
            dateFormat: "Y-m-d",
            enable: finalDates,
            disable: [
                function(date) {
                    const ymd = date.toISOString().split('T')[0];
                    return !finalDates.includes(ymd);
                }
            ],
            onChange: function(selectedDates, dateStr, instance) {
                changeDatePickerFunction(dateStr);
            }
        });

        function parseTimeToMinutes(timeStr) {
            const [time, modifier] = timeStr.split(" ");
            let [hours, minutes] = time.split(":").map(Number);
            if (modifier === "PM" && hours !== 12) hours += 12;
            if (modifier === "AM" && hours === 12) hours = 0;
            return hours * 60 + minutes;
        }

        function getDayNumberFromDate(dateStr) {
            const date = new Date(dateStr);
            const jsDay = date.getDay(); // Sunday = 0
            return jsDay === 0 ? 7 : jsDay; // Convert to ISO 1-7 (Mon-Sun)
        }

        function formatDateVerbose(dateStr) {
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };
            return new Date(dateStr).toLocaleDateString('en-US', options);
        }

        function changeDatePickerFunction() {
            const $start = $("#start_time_dropdown");
            const $end = $("#end_time_dropdown");

            $start.val("").empty().append(`<option value="">-- Select --</option>`);
            $end.val("").empty().append(`<option value="">-- Select --</option>`);

            const selected_date = $.trim($("#selected_booked_date").val());

            if (selected_date !== "") {
                const bookingDate = selected_date;
                const tutorId = {{ $vtutor->id }};
                const selectedDay = getDayNumberFromDate(bookingDate);

                // 🔹 1. Fetch time slot dropdowns
                $.ajax({
                    url: "{{ route('ajax.checking.booking.slot') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        data: {
                            booking_date: bookingDate,
                            tutor_id: tutorId
                        }
                    },
                    success: function(resp) {
                        if (Array.isArray(resp.start_times)) {
                            resp.start_times.forEach(time => {
                                $start.append(`<option value="${time}">${time}</option>`);
                            });

                            $start.off('change').on('change', function() {
                                const selectedStart = $(this).val();
                                if (!selectedStart) return;

                                const startMinutes = parseTimeToMinutes(selectedStart);

                                const allEndOptions = $end.find('option').map(function() {
                                    const val = $(this).val();
                                    return {
                                        el: this,
                                        value: val,
                                        minutes: val ? parseTimeToMinutes(val) : null
                                    };
                                }).get();

                                const sortedEnd = allEndOptions.filter(opt => opt.value).sort((a, b) =>
                                    a.minutes - b.minutes
                                );

                                const validEndTimes = sortedEnd.filter(end => {
                                    const duration = end.minutes - startMinutes;
                                    return duration > 0 && duration <= MAX_BOOKING_DURATION;
                                });

                                $end.find('option').prop('disabled', true);
                                $end.find('option[value=""]').prop('disabled', false);
                                validEndTimes.forEach(opt => {
                                    $(opt.el).prop('disabled', false);
                                });

                                $end.val('');
                            });
                        }

                        if (Array.isArray(resp.end_times)) {
                            resp.end_times.forEach(time => {
                                $end.append(`<option value="${time}">${time}</option>`);
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error("Slot Fetch Error:", xhr.responseText);
                    }
                });

                // 🔹 2. Fetch and update the availability section
                const selectedDateRaw = $("#selected_booked_date").val();
                const selectedDate = new Date(selectedDateRaw)
                    .toISOString()
                    .split('T')[0];
                // alert("Formatted Date Sent: " + selected_date);
                $.ajax({
                    url: "{{ route('ajax.get.day.slots') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        tutor_id: tutorId,
                        selected_day: selectedDate
                    },
                    success: function(resp) {
                        if (resp.output === 'true') {
                            $("#availability-container").html(resp.html);
                        } else {
                            $("#availability-container").html("<div>No available time slots found.</div>");
                        }
                    },
                    error: function(xhr) {
                        console.error("Availability Fetch Error:", xhr.responseText);
                    }
                });
            }
        }

        $('#subject').change(function() {
            var subjectId = $(this).val();

            if (subjectId !== '') {
                $.ajax({
                    url: '{{ url('get-subject-topics') }}/' + subjectId,
                    type: 'GET',
                    success: function(response) {
                        $('#topic').empty().append(
                            '<option value="">Select Topic</option>');
                        $.each(response, function(index, topic) {
                            $('#topic').append('<option value="' + topic.id + '">' +
                                topic.topics + '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $('#topic').empty().append(
                            '<option value="">Select Topic</option>');
                    }
                });
            } else {
                $('#topic').empty().append('<option value="">Select Topic</option>');
            }
        });

        $('#topic').change(function() {
            var topic_id = $(this).val();
            console.log("Topic changed");
            var booking_date = $.trim($("#selected_booked_date").val()),
                from_time = $.trim($("#start_time_dropdown").val()),
                to_time = $.trim($("#end_time_dropdown").val()),
                subject = $.trim($("#subject option:selected").val()),
                reqData = {
                    'jsonrpc': '2.0',
                    '_token': '{{ csrf_token() }}',
                    'data': {
                        'tutor_id': @if (@$vtutor->id)
                            {{ @$vtutor->id }}
                        @else
                            0
                        @endif ,
                        'booking_date': booking_date,
                        'subject': subject,
                        'topic_id': topic_id,
                        'from_time': from_time,
                        'to_time': to_time
                    }
                };
            $.ajax({
                url: "{{ route('ajax.get.date.time.subject.amount') }}",
                dataType: 'json',
                data: reqData,
                type: 'post',
                success: function(resp) {

                    $("#show_amount").html(' - $' + resp.payable_amount);
                    $('.gj_amt_div').show();

                    $('#session_focus').empty();
                    if (resp.topic_details && resp.topic_details.length > 0) {
                        $('#session_focus').append('<option value="">Select Topic</option>');
                        $.each(resp.topic_details, function(index, focus) {
                            $('#session_focus').append(
                                '<option value="' + focus.id + '" ' +
                                    'data-lo="' + focus.learning_outcome + '" ' +
                                    'data-id="' + focus.id + '">' +
                                    focus.topic_det_code + ' - ' + focus.session_focus +
                                '</option>'
                            );
                        });
                    } else {
                        $('#session_focus').append('<option value="">Select Session Focus</option>');
                    }
                },
                error: function() {
                    $('#session_focus').empty().append('<option value="">Select Session Focus</option>');
                }
            });
        });

        $('#session_focus').on('change', function () {
            if($(this).val()) {
                let lo = $(this).find(':selected').data('lo');
                $('#session_lo').val(lo);
                $('.session_lo_div').show();
            } else {
                $('#session_lo').val('');
                $('.session_lo_div').hide();
            }
        });

        function parseTimeToMinutes(timeStr) {
    // Example: "12:00 PM"
    const [time, modifier] = timeStr.split(" ");
    let [hours, minutes] = time.split(":").map(Number);

    if (modifier === "PM" && hours !== 12) {
        hours += 12;
    }
    if (modifier === "AM" && hours === 12) {
        hours = 0;
    }

    return hours * 60 + minutes; // total minutes since midnight
}

        $(document).on("click", "#studentBookSubmitBtn", function() {
            // Clear previous error messages
            $(".text-danger").text("");

            let booking_d = $("#selected_booked_date").val();
            let start1 = parseTimeToMinutes($("#start_time_dropdown").val());
            let end1 = parseTimeToMinutes($("#end_time_dropdown").val());
            let subject = $("#subject").val();
            let topic = $("#topic").val();
            let session_focus = $("#session_focus").val();
            let session_topic = $("#session_topics").val();
            let problem_areas = $("#session_description").val();


            let valid = true;

            if (!booking_d) {
                $("#error_selected_date_txt").text("This field is required!");
                valid = false;
            }

            if (!start1) {
                $("#start_time_dropdown").next(".text-danger").remove();
                $("#start_time_dropdown").after("<span class='text-danger'>This field is required!</span>");
                valid = false;
            }

            if (!end1) {
                $("#end_time_dropdown").next(".text-danger").remove();
                $("#end_time_dropdown").after("<span class='text-danger'>This field is required!</span>");
                valid = false;
            }

            if (start1 && end1 && start1 >= end1) {
                console.log("Start TIme:",start1);
                console.log("End TIme:",end1);
                $("#end_time_dropdown").next(".text-danger").remove();
                $("#end_time_dropdown").after(
                    "<span class='text-danger'>End time must be after start time.</span>");
                valid = false;
            }

            if (!subject) {
                $("#subject").next(".text-danger").remove();
                $("#subject").after("<span class='text-danger'>Please select a subject.</span>");
                valid = false;
            }

            if (!topic) {
                $("#topic").next(".text-danger").remove();
                $("#topic").after("<span class='text-danger'>Please select a topic.</span>");
                valid = false;
            }

            if (!session_focus) {
                $("#session_focus").next(".text-danger").remove();
                $("#session_focus").after("<span class='text-danger'>Please select a session focus.</span>");
                valid = false;
            }

            /* if (!session_topic) {
                $("#session_topics").next(".text-danger").remove();
                $("#session_topics").after("<span class='text-danger'>Please enter session topic.</span>");
                valid = false;
            } */

            if (!problem_areas) {
                $("#session_description").next(".text-danger").remove();
                $("#session_description").after(
                    "<span class='text-danger'>Please describe the problem areas.</span>");
                valid = false;
            }

            if (valid) {
                // Perform AJAX check before submission
                var get_booking_date = $.trim($("#selected_booked_date").val());
                var from_time = $.trim($("#start_time_dropdown").val());
                var to_time = $.trim($("#end_time_dropdown").val());
                var tutor_id = $("input[name='tutor_id']").val();

                var reqData = {
                    'jsonrpc': '2.0',
                    '_token': '{{ csrf_token() }}',
                    'data': {
                        'tutor_id': tutor_id ? tutor_id : 0,
                        'get_booking_date': get_booking_date,
                        'from_time': from_time,
                        'to_time': to_time
                    }
                };

                $.ajax({
                    url: "{{ route('ajax.check.booking.date') }}",
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success: function(resp) {
                        if (resp.output == '') {
                            $("#start_time_dropdown").val("");
                            $("#end_time_dropdown").val("");
                            $("#show_amount").html("");
                            $(".error_start_end_time").html("Choose an available time slot.");
                        } else {
                            $(".error_start_end_time").html("");
                            $("#bookClass")[0].submit();
                        }
                    }
                });
            }
        });
      
</script>

<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip({
        html: true,
        sanitize: false   // ← allow raw HTML (includes <i>, <em>, <span style="...">)
    });
});
</script>

<script>
    $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                items: 3,
                margin: 10,
                loop: false,
                nav: true,
                dots: true
            });

            $('#search_tutor_nm_studentclass').on('keyup', function() {
                let query = $(this).val();

                if (query.length >= 1) {
                    $.ajax({
                        url: "{{ route('ajax.search.tutors') }}",
                        type: 'GET',
                        data: {
                            query: query
                        },
                        success: function(data) {
                            let html = '';
                            if (data.length > 0) {
                                data.forEach(function(tutor) {
                                    let fullName = tutor.f_name + ' ' + tutor.l_name;
                                    html += `<div class="autocomplete-suggestion"
                                         data-id="${tutor.id}"
                                         data-name="${fullName}"
                                         data-slug="${tutor.slug}">
                                         ${fullName}
                                     </div>`;
                                });
                            } else {
                                html =
                                    '<div class="autocomplete-suggestion">No tutors found</div>';
                            }
                            console.log("Search results:", html);
                            $('#suggestion-box').html(html).show();
                            let offset = $('#search_tutor_nm_studentclass').offset();
                            $('#suggestion-box').css({
                                top: offset.top + 40,
                                left: offset.left
                            });
                        }
                    });
                } else {
                    $('#suggestion-box').hide();
                }
            });

            // On suggestion click
            $(document).on('click', '.autocomplete-suggestion', function() {
                let name = $(this).data('name');
                let id = $(this).data('id');
                let slug = $(this).data('slug');

                $('#search_tutor_nm_studentclass').val(name);
                $('#search_tutor_id_studentclass').val(id);
                $('#search_tutor_selected_name_studentclass').val(name);
                $('#search_tutor_slug_studentclass').val(slug);

                $('#suggestion-box').hide();
            });

            // Hide box if clicking outside
            $(document).click(function(e) {
                if (!$(e.target).closest('#search_tutor_nm_studentclass, #suggestion-box').length) {
                    $('#suggestion-box').hide();
                }
            });
            $('#searchBtn').on('click', function(e) {
                e.preventDefault();

                const slug = $('#search_tutor_slug_studentclass').val();
                const id = $('#search_tutor_id_studentclass').val();

                if (slug && id) {
                    const url = `/tutor-public-profile/${slug}?search_tutor_id_studentclass=${id}`;
                    window.location.href = url;
                } else {
                    alert("Please select a tutor from the suggestions.");
                }
            });
        });
</script>
@endsection

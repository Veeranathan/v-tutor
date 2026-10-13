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
                    @if (@$tutor)
                    <div class="class-feild">
                        <div class="row">
                            <div class="col-lg-9 col-md-8">
                                <div class="tuto-rating">
                                    <em>
                                        @if (@$tutor->profile_pic)
                                        @php
                                        $image_path =
                                        'assets/images/all_avatars/' . @$tutor->profile_pic;
                                        @endphp
                                        @if (file_exists(@$image_path))
                                        <img src="{{ public_asset('assets/images/all_avatars/' . @$tutor->profile_pic) }}"
                                            alt="profile_img">
                                        @else
                                        <img src="{{ env('STORAGE_URL') . '/teacher_profile_pic/' . @$tutor->profile_pic }}"
                                            alt="">
                                        @endif
                                        @else
                                        @if (@$tutor->avatar)
                                        <img src="{{ @$tutor->avatar }}" alt="" id="img2">
                                        @else
                                        <img src="{{ public_asset('assets/images/user-pro.png') }}" alt="" id="img2">
                                        @endif
                                        @endif
                                    </em>
                                    <div class="tu-info">
                                        <h2>{{ @$tutor->f_name }} {{ @$tutor->l_name }}</h2>
                                        <div class="sed">
                                            <input type="hidden" id="tutor_id" value="{{ @$tutor->id }}">
                                            <span><img src="{{ public_asset('assets/images/map.png') }}">
                                                @if (@$tutor->getState->state_name)
                                                @if (@$tutor->getState->state_name == 'New South Wales')
                                                NSW
                                                @elseif(@$tutor->getState->state_name == 'Victoria')
                                                VIC
                                                @elseif(@$tutor->getState->state_name == 'Queensland')
                                                QLD
                                                @elseif(@$tutor->getState->state_name == 'South Australia')
                                                SA
                                                @elseif(@$tutor->getState->state_name == 'Western Australia')
                                                WA
                                                @elseif(@$tutor->getState->state_name == 'Tasmania')
                                                TAS
                                                @elseif(@$tutor->getState->state_name == 'Northern Territory')
                                                NT
                                                @elseif(
                                                @$tutor->getState->state_name ==
                                                'Australian Capital
                                                Territory')
                                                ACT
                                                @endif
                                                @endif
                                            </span>

                                            <ul class="profile-rating m-0">
                                                @if ($tutor->avg_review >= 0 && $tutor->avg_review <= 0.24) <li><a
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
                                                    @if ($tutor->avg_review >= 0.25 && $tutor->avg_review <= 0.74)
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
                                                        @if ($tutor->avg_review >= 0.75 && $tutor->avg_review <= 1.24)
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
                                                            @if ($tutor->avg_review >= 1.25 && $tutor->avg_review <=
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
                                                                @if ($tutor->avg_review >= 1.75 && $tutor->avg_review
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
                                                                    @if ($tutor->avg_review >= 2.25 &&
                                                                    $tutor->avg_review <= 2.74) <li><a href="#"><img
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
                                                                        @if ($tutor->avg_review >= 2.75 &&
                                                                        $tutor->avg_review <= 3.24) <li><a
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
                                                                            @if ($tutor->avg_review >= 3.25 &&
                                                                            $tutor->avg_review <= 3.74) <li><a
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
                                                                                @if ($tutor->avg_review >= 3.75 &&
                                                                                $tutor->avg_review <= 4.24) <li><a
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
                                                                                    @if ($tutor->avg_review >= 4.25 &&
                                                                                    $tutor->avg_review <= 4.74) <li><a
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
                                                                                        @if ($tutor->avg_review >= 4.75
                                                                                        && $tutor->avg_review <= 5)
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
                                                                                                    @$tutor->avg_review
                                                                                                    }}
                                                                                                    ({{
                                                                                                    @$tutor->total_no_of_reviews
                                                                                                    }})</p>
                                                                                            </li>
                                            </ul>
                                        </div>
                                        <!-- <div class="sed ">
                                        </div> -->
                                        <!-- <div class="sed grade_sed">
                                            <span><img src="{{ public_asset('assets/images/gra.png') }}">
                                                {{ @$grade->grade_name }}</span>

                                        </div> -->
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

                            <form action="{{ url('booking-academic-session') }}/{{ @$tutor->id }}/{{ @$tutor->slug }}"
                                id="bookClass" method="get">
                                @csrf
                                <input type="hidden" name="tutor_id" value="{{ $tutor->id }}">
                                <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                                <input type="hidden" name="subject_id" value="{{ $purchase->academicProgram->branch_id ?? '' }}">
                                <input type="hidden" name="grade_id" value="{{ $purchase->academicProgram->grade_id ?? '' }}">
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
                                    <div class="col-md-12 col-sm-12">
                                        <!-- <p class="bk_disc"><b>Disclaimer:</b> V-Tutor acts solely as a facilitator and authorised payment agent between parents/students and tutors. All tutoring engagements are directly between the tutor and the parent/student. V-Tutor does not hold funds on trust and accepts no responsibility for tutoring outcomes once payment has been settled.</p> -->
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
                      

                </div>
            </div>
        </div>
</section>
@endsection
@section('footer')
@include('include.footer')
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

        const allAvailableDates = @json($available_dates ?? []);
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
                const tutorId = {{ $tutor->id }};
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
$(document).on("click", "#studentBookSubmitBtn", function(e) {
    e.preventDefault(); // prevent default form submit

    $(".text-danger").text(""); // clear previous errors

    let bookingDate = $("#selected_booked_date").val();
    let startTimeStr = $("#start_time_dropdown").val();
    let endTimeStr = $("#end_time_dropdown").val();
    let valid = true;

    if (!bookingDate) {
        $("#error_selected_date_txt").text("This field is required!");
        valid = false;
    }

    if (!startTimeStr) {
        $("#start_time_dropdown").after("<span class='text-danger'>This field is required!</span>");
        valid = false;
    }

    if (!endTimeStr) {
        $("#end_time_dropdown").after("<span class='text-danger'>This field is required!</span>");
        valid = false;
    }

    if (startTimeStr && endTimeStr) {
        let startMinutes = parseTimeToMinutes(startTimeStr);
        let endMinutes = parseTimeToMinutes(endTimeStr);
        if (startMinutes >= endMinutes) {
            $("#end_time_dropdown").after("<span class='text-danger'>End time must be after start time.</span>");
            valid = false;
        }
    }

    if (valid) {
        // Submit form directly or via AJAX check if required
        $("#bookClass")[0].submit();
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
@endsection

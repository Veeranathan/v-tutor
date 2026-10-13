@extends('layouts.app')
@section('title')
    <title>V-Tutor | Tutor | My session | Upcoming</title>
@endsection
@section('left_part')
    {{-- @include('include.student_top_common') --}}
    @include('include.header_menu_part')
    {{-- for datatable --}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <style type="text/css">
        .addDisablePhone {
            opacity: 0.5 !important;
        }

        .pointerEventsNone {
            pointer-events: none !important;
        }


        .th-content {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            /* prevents wrapping to next line */
        }


        .th-content img {
            width: 14px;
            height: 14px;
            display: inline-block;
            flex: 0 0 auto;
        }
    </style>
@endsection

@section('content')
<section class="makes_special_sec faq-sec">
    <div class="makes_special_inr">
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
                                <h2 class="profile-heading">Sessions </h2>
                                <p class="gj_sub_hd">You can find information about your sessions in this section</p>
                            </div>
                            <div class="class-feild">
                                <form method="post" action="{{ route('student.my.classes.upcoming') }}" id="frm">
                                    @csrf
                                    <div class="row new_rows ">
                                        <div class="col-sm-12">
                                            <div
                                                class="row new_rows1">
                                                {{-- <div class="col-sm-5"> --}}
                                                {{-- <div class="form_box_area upCls">
                                                        <div class="dash-d1">
                                                            <label>From Date</label>
                                                            <div class="ui calendar" id="from">
                                                                <div class="ui input left icon">
                                                                    <input type="text" placeholder="Select date"  name="from_date" id="from_date" value="{{request('from_date')}}">
                                                                    <span class="over_llp1"><img src="{{ public_asset('assets/images/cal.png')}}" alt=""></span>
                                                                </div>
                                                                <label id="from_date-error" class="error" for="from_date"></label>
                                                            </div>
                                                        </div>
                                                        <div class="dash-d1 toDCls">
                                                            <label>To Date</label>
                                                            <div class="ui calendar" id="to">
                                                                <div class="ui input left icon">
                                                                    <input type="text" placeholder="Select date" name="to_date" id="to_date" value="{{request('to_date')}}">
                                                                    <span class="over_llp1"><img src="{{ public_asset('assets/images/cal.png')}}" alt=""></span>
                                                                </div>
                                                                <label id="to_date-error" class="error" for="to_date"></label>
                                                            </div>
                                                        </div>

                                                    </div> --}}
                                                {{-- </div> --}}
                                                <div class="col-sm-3">
                                                    <div class="form_box_area">
                                                        <label>Status</label>
                                                        <select name="status">
                                                            <option value="">Select Status</option>
                                                            <option value="B"
                                                                @if (request('status') == 'B') selected @endif>Booked
                                                            </option>
                                                            <option value="CM"
                                                                @if (request('status') == 'CM') selected @endif>Completed
                                                            </option>
                                                            {{-- <option value="I" @if (request('status') == 'I') selected @endif >In progress</option> --}}
                                                            <option value="C"
                                                                @if (request('status') == 'C') selected @endif>Cancelled
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <div class="form_box_area">
                                                        <button class="dash-btn "> <img
                                                                src="{{ public_asset('assets/images/ser.png') }}"> Search
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <div class="form_box_area">
                                                        <a href="{{ route('student.my.classes.upcoming') }}"
                                                            class="dash-btn ">Reset</a>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-sm-2 col-6">
                                                    <a id="click_download" href="javascript:void(0);"
                                                        class="dash-btn">Download</a>

                                                </div> --}}
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-2">
                                            <button class="dash-btn @if (count(@$classes) <= 0) addDisablePhone pointerEventsNone @endif"> <img src="{{ public_asset('assets/images/ser.png')}}"> Search </button>
                                        </div> --}}
                                    </div>
                                </form>
                            </div>
                            <div class="user-right-top-new">
                                <div class="main-tabels">
                                    <!-- Nav tabs -->
                                    <div class="tab-rii mb-4">
                                        <ul class="nav nav-tabs flex-wrap">
                                            <li class="nav-item">
                                                <a class="nav-link " {{-- data-toggle="tab" --}}
                                                    href="{{ route('student.my.classes') }}">Today's Sessions </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" {{-- data-toggle="tab" --}}
                                                    href="{{ route('student.my.classes.upcoming') }}">Upcoming Sessions </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " {{-- data-toggle="tab" --}}
                                                    href="{{ route('student.my.classes.past') }}"> Past Sessions</a>
                                            </li>
                                        </ul>
                                        <div class="">
                                            <form method="post" action="{{ route('student.class.export') }}">
                                                @csrf
                                                <input type="hidden" name="session" value="future">
                                                <input type="hidden" name="status" value="{{ request('status') }}">
                                                <input type="hidden" name="from_date" value="{{ request('from_date') }}">
                                                <input type="hidden" name="to_date" value="{{ request('to_date') }}">
                                                <button style="display:none;" id="download_cls"
                                                    class="deen @if (count(@$classes) <= 0) addDisablePhone pointerEventsNone @endif"
                                                    type="submit">Download</button>
                                            </form>
                                            {{--  <a href="#" class="deen">Download</a> --}}
                                        </div>
                                    </div>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="today">
                                            <div class="custom-table">
                                                {{-- Student time: {{ $currentStudentTime }} --}}
                                                <table id="example" class="cell-border table table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <div class="th-content">Booking ID <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort"></div>
                                                            </th>
                                                            <th>
                                                                <div class="th-content">Tutor <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort"></div>
                                                            </th>
                                                            <th>
                                                                <div class="th-content">Date <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort"></div>
                                                            </th>
                                                            <th>
                                                                <div class="th-content">Time <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort"></div>
                                                            </th>
                                                            <th>
                                                                <div class="th-content">Academic Program <img src="{{ public_asset('assets/images/sort.png') }}" 
                                                                alt="sort"></div>
                                                            </th>
                                                            <th>
                                                                <div class="th-content">Grade <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort"></div>
                                                            </th>
                                                            <th>
                                                                <div class="th-content">Subject <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort"></div>
                                                            </th>
                                                            <th>
                                                                <div class="th-content">Status <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort"></div>
                                                            </th>
                                                            <th>Session</th>


                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($classes as $key => $val)
                                                            <tr class="">
                                                                <td data-label="Name">
                                                                   <a
                                                                                        href="{{ route('student.view.details.class.booking', $val->booking_no) }}"> {{ @$val->booking_no }}</a>
                                                                </td>
                                                                <td data-label="Name">{{ @$val->getTutor->f_name }}
                                                                    {{ @$val->getTutor->l_name }}</td>
                                                                <td
                                                                    data-order="{{ date('Y-m-d', strtotime($val->booking_date_user)) }}">
                                                                    {{ date('d-m-Y', strtotime($val->booking_date_user)) }}
                                                                </td>

                                                                <!-- Time -->
                                                                <td
                                                                    data-order="{{ date('H:i', strtotime($val->from_time_user)) }}">
                                                                    {{ date('h:i A', strtotime($val->from_time_user)) }} -
                                                                    {{ date('h:i A', strtotime($val->to_time_user)) }}
                                                                </td>

                                                                {{-- Academic Program Column --}}
                                                                <td data-label="Academic Program">
                                                                    @if($val->is_academic_program == 1 && $val->academicProgramPurchase && $val->academicProgramPurchase->academicProgram)
                                                                        {{ $val->academicProgramPurchase->academicProgram->name }}
                                                                    @else
                                                                        No
                                                                    @endif
                                                                </td>

                                                                <!-- <td data-label="Name">{{ @$val->getStudentGrade->grade_name }}
                                                                </td> -->
                                                                <td data-label="Grade">
                                                                    @if($val->is_academic_program == 1 && $val->academicProgramPurchase && $val->academicProgramPurchase->academicProgram)
                                                                        {{ $val->academicProgramPurchase->academicProgram->grade->grade_name ?? '-' }}
                                                                    @else
                                                                        {{ @$val->getStudentGrade->grade_name }}
                                                                     @endif
                                                                </td>
                                                                <!-- <td data-label="Name">{{ @$val->getSubject->subject }}</td> -->
                                                                 <td data-label="Subject">
                                                                    @if($val->is_academic_program == 1 && $val->academicProgramPurchase && $val->academicProgramPurchase->academicProgram)
                                                                        {{ $val->academicProgramPurchase->academicProgram->branch->branch_name ?? '-' }}
                                                                    @else
                                                                        {{ @$val->getSubject->subject }}
                                                                    @endif
                                                                </td>
                                                                <td data-label="Name"
                                                                    class="@if (@$val->booking_status == 'B') Booked
                                                            @elseif(@$val->booking_status == 'C')
                                                            cancelled_red_color
                                                            @elseif(@$val->booking_status == 'CM')
                                                            completed_green_color
                                                            @else
                                                            In progress @endif">
                                                                    @if (@$val->booking_status == 'B')
                                                                        Booked
                                                                    @elseif(@$val->booking_status == 'C')
                                                                        Cancelled
                                                                    @elseif(@$val->booking_status == 'CM')
                                                                        @if (@$val->booking_status == 'CM' && @$val->class_assessment_student == 'N')
                                                                            <a class="red_link"
                                                                                href="{{ route('student.class.end.assesment', $val->booking_no) }}">Review</a>
                                                                        @else
                                                                            Completed
                                                                        @endif
                                                                    @else
                                                                        In progress
                                                                    @endif
                                                                </td>
                                                                <td data-label="Name" class="">


                                                                    @if ($val->booking_status == 'C')
                                                                        <li class="pointerEventsNone addDisablePhone">
                                                                            <a target="_blank" href="#" class="">

                                                                                Click to join
                                                                            </a>

                                                                        </li>
                                                                    @else
                                                                        <li>
                                                                            <a target="_blank"
                                                                                href="{{ route('class.session.link', ['userid' => Auth()->user()->unique_id, 'id' => $val->booking_no]) }}">Click
                                                                                to join</a>
                                                                        </li>
                                                                    @endif


                                                                </td>
                                                                {{-- <td data-label="Name">
                                                                @if (@$val->booking_status == 'B' && @$val->from_time <= date('H:i:s') && @$val->to_time >= date('H:i:s'))
                                                                    <li>
                                                                        <a target="_blank" class="" href="{{ route('class.session.link',@$val->id) }}">

                                                                            Click to join
                                                                        </a>

                                                                    </li>
                                                                @elseif(@$val->booking_status == 'B' && @$val->from_time <= date("H:i:s", strtotime('+5 minutes')) && @$val->to_time >= date('H:i:s') )
                                                                    <li>
                                                                        <a target="_blank" href="{{ route('class.session.link',@$val->id) }}" class="">

                                                                            Click to join
                                                                        </a>

                                                                    </li>
                                                                @elseif(@$val->booking_status == 'B')
                                                                    <li>
                                                                        @php
                                                                            $date=explode("-",@$val->booking_date);
                                                                            $from=explode(":",@$val->from_time);
                                                                            $val['year']=$date[0];
                                                                            $val['month']=$date[1];           
                                                                            $val['day']=$date[2];

                                                                            $val['from_hour']=$from[0];
                                                                            $val['from_min']=$from[1];
                                                                        @endphp
                                                                        <a  id="show_upcoming_session_link{{ @$val->id }}" data-toggle="modal" data-target="#sessionLink" href="javascript:void(0);" class="" style="display: none;">{{ route('class.session.link',@$val->id) }}</a>
                                                                        <a data-year="{{ $date[0] }}" data-month="{{ $date[1] }}" data-day="{{ $date[2] }}" data-from_hour="{{ $val['from_hour'] }}" data-from_min="{{ $val['from_min'] }}" class="show_upcoming_session_link " data-id="{{ @$val->id }}" href="javascript:void(0);" data-msg="Session booked for {{date('d-m-Y', strtotime(@$val->booking_date))}} between {{date('h:i A', strtotime(@$val->from_time_user))}} - {{date('h:i A', strtotime(@$val->to_time_user))}} @if (@$val->getTimezone->time_zone_abbreviation) {{ @$val->getTimezone->time_zone_abbreviation }} @endif." class="">

                                                                            Click to join
                                                                        </a>
                                                                    </li>
                                                                @elseif(@$val->booking_status == 'C')
                                                                    <li class="pointerEventsNone addDisablePhone">
                                                                        <a target="_blank" href="#" class="">

                                                                            Click to join
                                                                        </a>

                                                                    </li>
                                                                @endif


                                                            </td> --}}
                                                                <td>
                                                                    <div class="add_ttrr actions-main">
                                                                        <a href="javascript:void(0);" class="action-dots"
                                                                            id="action{{ $val->id }}"><img
                                                                                src="{{ public_asset('assets/images/action-dots.png') }}"
                                                                                alt=""
                                                                                onclick="fun({{ $val->id }})"></a>
                                                                        <div class="show-actions"
                                                                            id="show-action{{ $val->id }}"
                                                                            style="display: none;">
                                                                            <span class="angle"><img
                                                                                    src="{{ public_asset('assets/images/angle.png') }}"
                                                                                    alt=""></span>
                                                                            <ul>
                                                                                <li><a
                                                                                        href="{{ route('student.view.details.class.booking', $val->booking_no) }}">View
                                                                                        Details</a></li>
                                                                                @if (@$val->class_assessment_student == 'N' && @$val->booking_status == 'CM')
                                                                                    <li><a
                                                                                            href="{{ route('student.class.end.assesment', $val->booking_no) }}">Review
                                                                                            Session</a></li>
                                                                                @endif
                                                                                @if (@$val->booking_status == 'B')
                                                                                    @if (@$val->booking_date_user == date('Y-m-d') && @$val->from_time < date('H:i:s'))
                                                                                        <li>
                                                                                            <a id="session_open_popup_link{{ $val->id }}"
                                                                                                data-toggle="modal"
                                                                                                data-target="#cancelPopup"
                                                                                                style="display:none;">Cancel
                                                                                                Session</a>
                                                                                            <a class="session_open_popup_link"
                                                                                                data-id="{{ $val->id }}"
                                                                                                data-link="{{ route('student.cancel.class.booking', @$val->booking_no) }}">Cancel
                                                                                                Session</a>


                                                                                            {{-- <a data-toggle="modal" data-target="#cancelPopup" href="javascript::void(0);">Cancel Session</a> --}}
                                                                                        </li>
                                                                                    @elseif(@$val->booking_date_user != date('Y-m-d'))
                                                                                        <li>
                                                                                            <a id="session_open_popup_link{{ $val->id }}"
                                                                                                data-toggle="modal"
                                                                                                data-target="#cancelPopup"
                                                                                                style="display:none;">Cancel
                                                                                                Session</a>
                                                                                            <a class="session_open_popup_link"
                                                                                                data-id="{{ $val->id }}"
                                                                                                data-link="{{ route('student.cancel.class.booking', @$val->booking_no) }}">Cancel
                                                                                                Session</a>
                                                                                            {{-- <a data-toggle="modal" data-target="#cancelPopup{{ $val->id }}" class="session_cancel_open_popup" href="javascript::void(0);">Cancel Session</a> --}}
                                                                                        </li>
                                                                                    @endif
                                                                                @endif
                                                                            </ul>

                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- end --}}
                                        <div class="testPro">
                                            <div class="proDiv">
                                                <h6>Please note:</h6>
                                                <p>1. You can join the session at your scheduled time. The tutor or meeting link may not be active if you join too early. </p>
                                                <p>2. You’ll need an active <a href="https://zoom.us" class="red_link">Zoom account</a> to join. If you don’t have one, please create an account and stay logged in before your session. </p>
                                                <p>3. If you fail to join within 15 minutes of the scheduled start time, it will be marked as a ‘no show’, and session charges may be forfeited. </p>
                                                <p>4. Session durations are fixed and cannot be extended under any circumstances. If a session is interrupted due to technical issues from the tutor’s end or the platform, it will be treated as ‘cancelled’, and charges will be refunded. </p>
                                                <p>5. Please ensure a stable internet connection, test your audio/video, and join from a quiet, well-lit space for the best learning experience. </p>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- table panel end --}}
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
                            <p>You have chosen to cancel the booking. If this is by mistake, kindly ignore</p>
                            <p><em>Cancellation of sessions is subject to’ V-Tutor cancellation policy. V-Tutor <a
                                        href="{{ route('help') }}" class="red_link">cancellation policy</a>. Refunds are
                                    subject to conditions. Refer to the policy from the <a href="{{ route('help') }}"
                                        class="red_link">Help section</a> for more details.</em></p>

                            <div class="next-btn1 newst_btn-pop">
                                {{-- {{ route('student.cancel.class.booking',@$val->booking_no) }} --}}
                                <a href="javascript:void(0);" id="cancel_session_link"
                                    class="btn btn-new btn-danger float-left change-new-link">Yes, please cancel</a>

                                <button type="button" class="btn btn-new btn-danger " data-dismiss="modal">No, don’t
                                    cancel </button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal res-modal newqusmo earlyUpdCls" id="sessionLink">
        <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class=" proDiv" id="warningTextDiCancel">
                            <h6></h6>
                            <p>Meeting link will be active only 5 minutes before the session</p>
                            <p class="msg_text_show"></p>
                            <p id="{{-- demo --}}"></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            order: [
                [2, 'asc'], // Booking Date column
                [3, 'asc'] // Time column
            ],
            pageLength: 10,
            "language": {
                "emptyTable": "No data available",
                "info": "",
                "infoEmpty": "",
                "infoFiltered": "" 
            },
            dom: '<"top"f>t<"bottom row"<"col-12 d-flex justify-content-end"p>>',
            columnDefs: [{
                    targets: [2],
                    type: 'date'
                }, // Optional: tells DataTable date column
                {
                    targets: [3],
                    type: 'time'
                } // Optional: for time column if needed
            ]
        });
        if (oTable.rows().data().length === 0) {
            $(oTable.table().container())
                .find('.dataTables_paginate')
                .hide();
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#click_download').on("click", function() {
                $("#download_cls").trigger("click");
            });
            $(document).on("click", ".session_open_popup_link", function() {
                var id = $(this).attr("data-id");
                var link = $(this).attr("data-link");
                $("#cancel_session_link").attr("href", link);
                $("#session_open_popup_link" + id).trigger("click");
            });
            $(document).on("click", ".show_upcoming_session_link", function() {
                // var x = setInterval(function() {}, 1000);
                // clearInterval(x);
                $("#demo").html("");
                var id = $(this).attr("data-id");
                var link = $(this).attr("data-link");
                var msg = $(this).attr("data-msg");
                var year = parseInt($(this).attr("data-year"));
                var month = parseInt($(this).attr("data-month"));
                var day = parseInt($(this).attr("data-day"));
                var from_hour = parseInt($(this).attr("data-from_hour"));
                var from_min = parseInt($(this).attr("data-from_min"));

                var countDownDate = new Date(year, month, day, from_hour, from_min, 0).getTime();
                // Update the count down every 1 second
                // var x = setInterval(function() {

                //   // Get today's date and time
                //   var now = new Date().getTime();

                //   // Find the distance between now and the count down date
                //   var distance = countDownDate - now;

                //   // Time calculations for days, hours, minutes and seconds
                //   var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                //   var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                //   var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                //   var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                //   // Output the result in an element with id="demo"
                //   document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                //   + minutes + "m " + seconds + "s ";

                //   // If the count down is over, write some text
                //   if (distance < 0) {
                //     clearInterval(x);
                //     document.getElementById("demo").innerHTML = "EXPIRED";
                //   }
                // }, 1000);

                $(".msg_text_show").html(msg);
                $("#show_upcoming_session_link" + id).trigger("click");
            });
            $('#frm').validate({
                rules: {
                    qualification: {
                        required: true,
                    },
                    field_of_study: {
                        required: true,
                    },
                    university: {
                        required: true,
                    },
                    qualification_status: {
                        required: true,
                    },
                    effective_date: {
                        required: true,
                    }
                },
                // messages:{
                //      qualification:{
                //         required:" Category name is mandatory",
                //     }
                // }
            });
        });
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
    <script>
        //var d = new Date();
        $('#frm').validate({
            submitHandler: function(form) {
                // var val1 = new Date($('#from_date').val());
                // var val2 = new Date($('#to_date').val());


                // console.log($('#from').val());
                // console.log(val2);
                //return false;

                //    if(val1 == "Invalid Date" && val2 == "Invalid Date") {
                //     alert("select both dates");
                //   return false;

                // }
                //  else if(val1 == "Invalid Date" && val2 != "Invalid Date" ) {
                //    alert("select from date");
                //      return false;
                // }
                //  else if(val1 != "Invalid Date" && val2 == "Invalid Date" ) {
                //     alert("select to date");
                //      return false;
                // }
                //  else if(val1 > val2) {
                //   console.log('max');
                //   console.log(val1);
                //   console.log(val2);

                //   alert('From date cannot be greater than to date');
                // }
                //  else{
                form.submit();
                // }

            }
        });
    </script>
    <script>
        $('#from').calendar({
            type: 'date',
            // minDate:new Date({{ strtotime(date('Y-m-d H:i:s') . '+1 days') }}*1000),
        });
    </script>
    <script>
        $('#to').calendar({
            type: 'date',
            // minDate:new Date({{ strtotime(date('Y-m-d H:i:s') . '+1 days') }}*1000),
        });
    </script>
@endsection

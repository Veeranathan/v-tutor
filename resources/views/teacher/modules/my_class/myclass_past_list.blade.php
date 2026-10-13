@extends('layouts.app')
@section('title')
    <title>
        V-Tutor | Tutor | My session | Past</title>
@endsection
@section('left_part')
    @include('include.header_menu_part')
    {{-- for datatable --}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style type="text/css">
        .addDisablePhone {
            opacity: 0.5 !important;
        }

        .pointerEventsNone {
            pointer-events: none !important;
        }

        .flatpickr-calendar {
            z-index: 9999 !important;
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
                        @include('include.teacher_left_common'){{-- left common part --}}
                        <div
                            class="user-right-panel @if (@Auth::user()->status == 'AA') addDisablePhone pointerEventsNone @endif">
                            <div class="user-right-top-new ">
                                @include('include.errors')
                                <h2 class="profile-heading">Sessions </h2>
                                <p class="gj_sub_hd">You can find information about your sessions in this section</p>
                            </div>
                            <div class="class-feild">
                                <form method="post" action="{{ route('tutor.myclass.past') }}" id="frm">
                                    @csrf
                                    <div class="row new_rows1">
                                        <div class="col-sm-12">
                                            {{--  @if (@$count_classes <= 0) addDisablePhone pointerEventsNone @endif --}}
                                            <div class="row new_rows1">
                                                <div class="col-sm-4">
                                                    <div class="form_box_area upCls">
                                                        <div class="dash-d1">
                                                            <label>From Date</label>
                                                            <input type="text" placeholder="Select date" required
                                                                name="from_date" id="from_date"
                                                                value="{{ request('from_date') }}">
                                                        </div>
                                                        <div class="dash-d1 toDCls">
                                                            <label>To Date</label>
                                                            <input type="text" placeholder="Select date" required
                                                                name="to_date" id="to_date" value="{{ request('to_date') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
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
                                                            {{--  <option value="I" @if (request('status') == 'I') selected @endif >In progress</option> --}}
                                                            <option value="C"
                                                                @if (request('status') == 'C') selected @endif>Cancelled
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <div class="form_box_area">
                                                        <label>Students</label>
                                                        <select name="student_id">
                                                            <option value="">Select Student</option>

                                                            @if (isset($booked_students) && count($booked_students) != 0)
                                                                @foreach ($booked_students as $bs_k => $bs_v)
                                                                    <option value="{{ $bs_v->id }}"
                                                                        @if (request('student_id') == $bs_v->id) selected @endif>
                                                                        {{ @$bs_v->f_name }} {{ @$bs_v->l_name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <div class="form_box_area">
                                                        <label>Grades</label>
                                                        <select name="student_grade_id">
                                                            <option value="">Select Grade</option>

                                                            @if (isset($booked_grade) && count($booked_grade) != 0)
                                                                @foreach ($booked_grade as $bg_k => $bg_v)
                                                                    <option value="{{ $bg_v->id }}"
                                                                        @if (request('student_grade_id') == $bg_v->id) selected @endif>
                                                                        {{ @$bg_v->grade_name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <div class="form_box_area">
                                                        <label>Subjects</label>
                                                        <select name="subject_id">
                                                            <option value="">Select Subject</option>

                                                            @if (isset($booked_subjects) && count($booked_subjects) != 0)
                                                                @foreach ($booked_subjects as $bsu_k => $bsu_v)
                                                                    <option value="{{ $bsu_v->id }}"
                                                                        @if (request('subject_id') == $bsu_v->id) selected @endif>
                                                                        {{ @$bsu_v->subject }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--  @if (@$count_classes <= 0) addDisablePhone pointerEventsNone @endif --}}
                                            <div class="row new_rows1 gj_actions_frm_buts">
                                                <div class="col-sm-2 col-6">
                                                    <div class="form_box_area">
                                                        <button class="dash-btn "> <img
                                                                src="{{ public_asset('assets/images/ser.png') }}"> Search
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2 col-6">
                                                    <div class="form_box_area">
                                                        <a href="{{ route('tutor.myclass.past') }}" class="dash-btn ">Reset</a>
                                                        {{-- <button class="dash-btn @if (count(@$classes) <= 0) addDisablePhone pointerEventsNone @endif"> <img src="{{ public_asset('assets/images/ser.png')}}"> Reset </button> --}}
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-sm-2 col-6 @if (@$count_classes <= 0) addDisablePhone pointerEventsNone @endif">
                                                    {{-- <input type="submit" name="" class="dash-btn " value="Download" id="dwnload"> --}}
                                                    {{-- <a id="click_download" href="javascript:void(0);"
                                                        class="dash-btn ">Download</a> --}}
                                                </div>
                                                {{-- <div class="col-sm-2">
                                                    <div class="form_box_area">
                                                        <button class="dash-btn @if (count(@$classes) <= 0) addDisablePhone pointerEventsNone @endif"> <img src="{{ public_asset('assets/images/ser.png')}}"> Search </button>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">

                                                        <a href="{{route('tutor.myclass.past')}}" class="dash-btn @if (count(@$classes) <= 0) addDisablePhone pointerEventsNone @endif">Reset</a>

                                                </div> --}}
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-2">
                                        <button class="dash-btn @if (count(@$classes) <= 0) addDisablePhone pointerEventsNone @endif"> <img src="{{ public_asset('assets/images/ser.png')}}"> Search </button></div> --}}
                                    </div>
                                </form>
                            </div>
                            <div class="user-right-top-new gj_tut_sess_tbl_sec">
                                <div class="main-tabels">
                                    <!-- Nav tabs -->
                                    <div class="tab-rii mb-4">
                                        <ul class="nav nav-tabs flex-wrap">
                                            <li class="nav-item">
                                                <a class="nav-link" {{-- data-toggle="tab" --}}
                                                    href="{{ route('tutor.myclass') }}">Today's Sessions </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " {{-- data-toggle="tab" --}}
                                                    href="{{ route('tutor.myclass.upcoming') }}">Upcoming Sessions </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" {{-- data-toggle="tab" --}}
                                                    href="{{ route('tutor.myclass.past') }}"> Past Sessions</a>
                                            </li>
                                        </ul>
                                        <div class="">
                                            <form method="post" action="{{ route('tutor.class.export') }}">
                                                @csrf
                                                <input type="hidden" name="session" value="past">
                                                <input type="hidden" name="status" value="{{ request('status') }}">
                                                <input type="hidden" name="from_date" value="{{ request('from_date') }}">
                                                <input type="hidden" name="to_date" value="{{ request('to_date') }}">
                                                <button id="download_cls" style="display:none;"
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

                                                {{-- start --}}
                                                <table id="example" class="cell-border table table-responsive">
                                                    <thead>
                                                        <tr>

                                                            <th><span class="d-flex align-items-center ">Booking ID <img
                                                                    src="{{ public_asset('assets/images/sort.png') }}"></span></th>
                                                            <th><span class="d-flex align-items-center ">Student <img
                                                                    src="{{ public_asset('assets/images/sort.png') }}"></span></th>

                                                            <th><span class="d-flex align-items-center ">Date <img src="{{ public_asset('assets/images/sort.png') }}">
                                                            </span></th>
                                                            <th><span class="d-flex align-items-center ">Time <img src="{{ public_asset('assets/images/sort.png') }}">
                                                            </span></th>
                                                            <th><span class="d-flex align-items-center ">Academic Program <img src="{{ public_asset('assets/images/sort.png') }}">
                                                            </span></th>
                                                            <th><span class="d-flex align-items-center ">Grade <img src="{{ public_asset('assets/images/sort.png') }}">
                                                            </span></th>
                                                            <th><span class="d-flex align-items-center ">Subject <img
                                                                    src="{{ public_asset('assets/images/sort.png') }}"></span></th>
                                                            <th><span class="d-flex align-items-center ">Status <img
                                                                    src="{{ public_asset('assets/images/sort.png') }}">
                                                            </span></th>
                                                            <th><span class="d-flex align-items-center "> </span></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (@$classes)
                                                            @foreach (@$classes as $key => $val)
                                                                <tr>

                                                                    <td data-label="Name">
                                                                        <a href="{{ route('teacher.view.details.class.booking', $val->booking_no) }}" target="blank">{{ @$val->booking_no }}</a>
                                                                    </td>
                                                                    <td data-label="Name">{{ @$val->getStudent->f_name }}
                                                                        {{ @$val->getStudent->l_name }}</td>

                                                                    <td data-label="Date"
                                                                        data-order="{{ date('Y-m-d', strtotime(@$val->booking_date_user)) }}">
                                                                        {{ date('d-m-Y', strtotime(@$val->booking_date_user)) }}
                                                                    </td>
                                                                    <td data-label="Time"
                                                                        data-order="{{ date('H:i', strtotime(@$val->from_time_user)) }}">
                                                                        {{ date('h:i A', strtotime(@$val->from_time_user)) }} -
                                                                        {{ date('h:i A', strtotime(@$val->to_time_user)) }}
                                                                    </td>
                                                                    <td data-label="Academic Program">
                                                                        @if($val->is_academic_program == 1 && $val->academicProgramPurchase && $val->academicProgramPurchase->academicProgram)
                                                                            {{ $val->academicProgramPurchase->academicProgram->name }}
                                                                        @else
                                                                            No
                                                                        @endif
                                                                    </td>
                                                                    <td data-label="Grade">
                                                                        @if($val->is_academic_program == 1 && $val->academicProgramPurchase && $val->academicProgramPurchase->academicProgram)
                                                                            {{ $val->academicProgramPurchase->academicProgram->grade->grade_name ?? '-' }}
                                                                        @else
                                                                            {{ @$val->getStudentGrade->grade_name }}
                                                                        @endif
                                                                    </td>
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
                                                            In progress @endif ">
                                                                        @if (@$val->booking_status == 'B')
                                                                            Booked
                                                                        @elseif(@$val->booking_status == 'C')
                                                                            Cancelled
                                                                        @elseif(@$val->booking_status == 'CM')
                                                                            @if (@$val->booking_status == 'CM' && @$val->class_assessment_student == 'N')
                                                                                <a class="red_link"
                                                                                    href="{{ route('tutor.class.end.assesment', $val->booking_no) }}">Review</a>
                                                                            @else
                                                                                Completed
                                                                            @endif
                                                                        @else
                                                                            In progress
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <div class="add_ttrr actions-main">
                                                                            <a href="javascript:void(0);" class="action-dots"
                                                                                id="action{{ $val->id }}"><img
                                                                                    src="{{ public_asset('assets/images/action-dots.png') }}"
                                                                                    alt=""
                                                                                    onclick="fun({{ $val->id }})"></a>
                                                                            <div class="show-actions"
                                                                                id="show-action{{ $val->id }}"
                                                                                style="display: none;"> <span
                                                                                    class="angle"><img
                                                                                        src="{{ public_asset('assets/images/angle.png') }}"
                                                                                        alt=""></span>
                                                                                <ul>
                                                                                    <li><a
                                                                                            href="{{ route('teacher.view.details.class.booking', $val->booking_no) }}">View
                                                                                            Details</a></li>

                                                                                    <li><a
                                                                                            href="{{ route('tutor_view_feedback_history', $val->booking_no) }}">Feedback
                                                                                            History</a></li>

                                                                                    @if (@$val->class_assessment_tutor == 'N' && @$val->booking_status == 'CM')
                                                                                        <li><a
                                                                                                href="{{ route('tutor.class.end.assesment', @$val->booking_no) }}">Review
                                                                                                Session</a></li>
                                                                                    @endif
                                                                                </ul>
                                                                            </div>
                                                                            {{-- <div class="add_ttrr actions-main">
                                                                <a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
                                                                <div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span> --}}
                                                                            {{-- <ul> --}}
                                                                            {{--  <li><a href="{{route('aced.edit.page',$val->id)}}">Edit</a></li>
                                                                    <li><a onclick="return confirm('Are you sure want to delete this?')" href="{{route('aced.dlt',$val->id)}}">Delete</a></li> --}}
                                                                            {{-- </ul> --}}
                                                                            {{-- </div> --}}
                                                                            {{-- </div> --}}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif

                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        {{-- end --}}
                                        <div class="testPro">
                                            {{-- <div class="proDiv">
                                            <h6>Please note:</h6>
                                            <p>1.       The meeting link will be available only 5 minutes prior to the start of the session. Please ensure you have a stable internet connection and be seated at a quiet place.</p>
                                            <p>2.       Kindly ensure to start the session at the scheduled time. Delay of more than 5 minutes would lead to cancellation with session charges forfeited</p>
                                            <p>3.       Managing time between multiple sessions is your responsibility. Please start and end meetings promptly. Follow structured approach and a defined agenda for the session</p>
                                            <p>4.        You need an active <a href="https://zoom.us" class="red_link">Zoom</a> account to join classes. If you don’t have one already, kindly create one and stay logged in.</p>
                                            <p>5.       To cancel the booking, go to ‘Sessions’ menu. Terms and Conditions apply for refunds. For details, go through <a href="{{ route('help') }}" class="red_link">‘Our Policies’</a> from <a href="{{ route('help') }}" class="red_link">help section</a> on the site.</p>
                                            <p>6.       Session timings are fixed and must not be extended for any reasons, though legitimate. Kindly advise the student / parent gently and request them to book another session.</p>
                                            <p>7.       If the session is interrupted due to unavailability of the learning platform or other technical reasons, the session would be considered cancelled and you will not lose session charges. However, if it is due to technical reasons from your end, you will be considered ‘no show’ and will stand to lose session charges.</p>
                                        </div> --}}
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
@endsection
@section('script')
    @include('include.script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>
    {{-- for datatable --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>


    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable with booking date (column 2) DESC and time (column 3) DESC
            $('#example').DataTable({
                order: [
                    [2, 'desc'],
                    [3, 'desc']
                ], // Sort by Date DESC, then Time DESC
                pageLength: 10,
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

            // Flatpickr for date fields with past date restriction
            flatpickr("#from_date", {
                dateFormat: "Y-m-d",
                maxDate: new Date().fp_incr(-1)
            });

            flatpickr("#to_date", {
                dateFormat: "Y-m-d",
                maxDate: new Date().fp_incr(-1)
            });

            // Form validation before search
            $('#frm').validate({
                submitHandler: function(form) {
                    let from = $('#from_date').val();
                    let to = $('#to_date').val();

                    if (!from && !to) {
                        alert("Please select both From and To dates.");
                        return false;
                    }
                    if (!from) {
                        alert("Please select a From date.");
                        return false;
                    }
                    if (!to) {
                        alert("Please select a To date.");
                        return false;
                    }
                    if (new Date(from) > new Date(to)) {
                        alert("From date cannot be later than To date.");
                        return false;
                    }
                    form.submit();
                }
            });

            // Trigger hidden download button when "Download" is clicked
            $('#click_download').on('click', function() {
                $('#download_cls').click();
            });
        });

        // Show action dots menu
        function fun(id) {
            $('.show-actions').slideUp(); // Hide all
            $("#show-action" + id).show(); // Show selected
        }

        // Cancel action menu
        function Cancel(id) {
            $("#show-action" + id).hide();
        }

        // Close action menu when clicking outside
        $(document).mouseup(function(e) {
            var container = $(".show-actions");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.hide();
            }
        });
    </script>
@endsection

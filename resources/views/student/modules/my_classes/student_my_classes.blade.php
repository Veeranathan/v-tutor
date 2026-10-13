@extends('layouts.app')
@section('title')
    <title>V-Tutor | Student | My session </title>
    {{-- <link rel="icon" href="{{ public_asset('admin/assets/images/favicon.ico') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ public_asset('admin/assets/images/favicon.ico') }}" type="image/x-icon" /> --}}
    <link rel="icon" href="{{ public_asset('assets/images/favicon.ico')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ public_asset('assets/images/favicon.ico')}}" type="image/x-icon" />
    <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="32x32">
    <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="96x96">
    <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="192x192">
    <link rel="apple-touch-icon" href="{{ public_asset('assets/images/favicon.png') }}">
    <meta name="msapplication-TileImage" content="{{ public_asset('assets/images/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ public_asset('assets/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ public_asset('assets/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ public_asset('assets/images/favicon-16x16.png') }}">
@endsection
@section('left_part')
    {{-- @include('include.student_top_common') --}}
    @include('include.header_menu_part')
    {{-- for datatable --}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <style>
        /* Table general style */
        .table-sortable {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            background-color: #fff;
        }

        .table-sortable th,
        .table-sortable td {
            padding: 10px 12px;
            border: 1px solid #ddd;
        }

        /* Header with text + icon inline */
        .header-with-icon {
            display: inline-flex;
            /* keep text and image inline */
            align-items: center;
            /* vertical align center */
            gap: 6px;
            /* spacing between text and icon */
            white-space: nowrap;
            /* prevent wrapping */
            font-weight: 600;
        }

        .header-with-icon img {
            width: 14px;
            /* adjust size of sort icon */
            height: 14px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }

        .header-with-icon img:hover {
            opacity: 1;
        }

        /* Zebra striping for better readability */
        .table-sortable tbody tr:nth-child(even) {
            background-color: #f9f9f9;
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
                        @include('include.student_left_common')
                        <div class="user-right-panel">
                            <div class="user-right-top-new ">
                                @include('include.errors')
                                <h2 class="profile-heading">Sessions </h2>
                                <p class="gj_sub_hd">You can find information about your sessions in this section</p>
                            </div>
                            <div class="class-feild">
                                <form method="post" action="{{ route('student.my.classes') }}" id="frm">
                                    @csrf
                                    <div class="row new_rows1">
                                        <div class="col-sm-12">
                                            {{--  @if (@$count_classes <= 0) addDisablePhone pointerEventsNone @endif --}}
                                            <div class="row new_rows1">
                                                <div class="col-sm-3">
                                                    <div class="form_box_area">
                                                        <label>Status</label>
                                                        <select name="status">
                                                            <option value="">Select Status</option>
                                                            <option value="B"
                                                                @if (request('status') == 'B') selected @endif>
                                                                Booked</option>
                                                            <option value="CM"
                                                                @if (request('status') == 'CM') selected @endif>
                                                                Completed</option>
                                                            {{-- <option value="I" @if (request('status') == 'I') selected @endif>
                                                            In progress</option> --}}
                                                            <option value="C"
                                                                @if (request('status') == 'C') selected @endif>
                                                                Cancelled</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <div class="form_box_area">
                                                        <button class="dash-btn"> <img
                                                                src="{{ public_asset('assets/images/ser.png') }}"> Search
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <div class="form_box_area">
                                                        <a href="{{ route('student.my.classes') }}"
                                                            class="dash-btn">Reset</a>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-sm-2">
                                                    <a id="click_download" href="javascript:void(0);"
                                                        class="dash-btn">Download</a>

                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="user-right-top-new">
                                <div class="main-tabels">
                                    <!-- Nav tabs -->
                                    <div class="tab-rii mb-4 ">
                                        <ul class="nav nav-tabs d-flex flex-wrap">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="{{ route('student.my.classes') }}">Today's
                                                    Sessions </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " href="{{ route('student.my.classes.upcoming') }}">Upcoming
                                                    Sessions </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " href="{{ route('student.my.classes.past') }}"> Past
                                                    Sessions</a>
                                            </li>
                                        </ul>
                                        <div class="">

                                            <form method="post" action="{{ route('student.class.export') }}">
                                                @csrf
                                                <input type="hidden" name="session" value="present">
                                                <input type="hidden" name="status" value="{{ request('status') }}">
                                                {{-- <button
                                                class="deen @if (count(@$classes) <= 0) addDisablePhone pointerEventsNone @endif"
                                                type="submit">Download</button> --}}
                                                <button style="display:none;" id="download_cls"
                                                    class="deen @if (count(@$classes) <= 0) addDisablePhone pointerEventsNone @endif"
                                                    type="submit">Download</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="today">
                                            <div class="custom-table">
                                                {{-- Student time: {{ $currentStudentTime}} --}}
                                                <table id="example" class="cell-border table table-responsive table-sortable">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <span class="header-with-icon">
                                                                    Booking ID
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span>
                                                            </th>
                                                            <th>
                                                                <span class="header-with-icon">
                                                                    Tutor
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span>
                                                            </th>
                                                            {{-- If needed later:
                <th>
                    <span class="header-with-icon">
                        Date
                        <img src="{{ public_asset('assets/images/sort.png') }}" alt="sort">
                    </span>
                </th>
                --}}
                                                            <th>
                                                                <span class="header-with-icon">
                                                                    Time
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span>
                                                            </th>
                                                            <th>
                                                                <div class="th-content">Academic Program <img
                                                                src="{{ public_asset('assets/images/sort.png') }}"
                                                                alt="sort"></div>
                                                            </th>
                                                            <th>
                                                                <span class="header-with-icon">
                                                                    Grade
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span>
                                                            </th>
                                                            <th>
                                                                <span class="header-with-icon">
                                                                    Subject
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span>
                                                            </th>
                                                            <th>
                                                                <span class="header-with-icon">
                                                                    Status
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span>
                                                            </th>
                                                            <th>
                                                                <span class="header-with-icon">
                                                                    Session
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span>
                                                            </th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($classes as $key => $val)
                                                            <tr>
                                                                <td data-label="Name">
                                                                   <a href="{{ route('student.view.details.class.booking', $val->booking_no) }}"> {{ @$val->booking_no }}</a>
                                                                </td>
                                                                <td data-label="Name">{{ @$val->getTutor->f_name }}
                                                                    {{ @$val->getTutor->l_name }}</td>
                                                                <td
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
                                                                    class="@if (@$val->booking_status == ' B') Booked
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
                                                                            <a href="{{ route('student.class.end.assesment', $val->booking_no) }}"
                                                                                class="red_link">Review</a>
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

                                                                                {{-- @if (@$val->booking_status == 'B' && @$val->to_time >= date('H:i:s'))
                                                                                    <li><a href="{{ route('class.session.link', ['userid' => Auth()->user()->unique_id, 'id' => @$val->booking_no]) }}"
                                                                                            target="_blank">Join the Session
                                                                                            <img
                                                                                                src="{{ public_asset('assets/images/camera.png') }}"></a>
                                                                                    </li>
                                                                                @endif --}}

                                                                                @if (@$val->booking_status == 'B')
                                                                                    @if (@$val->booking_date_user == date('Y-m-d') && @$val->from_time > date('H:i:s'))
                                                                                        <li>
                                                                                            <a id="session_open_popup_link{{ $val->id }}"
                                                                                                data-toggle="modal"
                                                                                                data-target="#cancelPopup"
                                                                                                style="display:none;">Cancel
                                                                                                Booking</a>
                                                                                            <a class="session_open_popup_link"
                                                                                                data-id="{{ $val->id }}"
                                                                                                data-link="{{ route('student.cancel.class.booking', @$val->booking_no) }}">Cancel
                                                                                                Session </a>
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
                                        <div class="testPro px-2">
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
    <div class="modal res-modal newqusmo earlyUpdCls" id="sessionLink">
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
                            <p>Meeting link will be active only before 5 minutes of the session</p>


                            <div class="next-btn1 newst_btn-pop">
                                {{-- {{ route('student.cancel.class.booking',@$val->booking_no) }} --}}
                                <a href="{{ route('student.my.classes') }}" id="cancel_session_link"
                                    class="btn btn-new btn-danger float-left change-new-link"></a>


                                <div class="clearfix"></div>
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
    <script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    {{-- for validation --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>
    <script>
        oTable = $('#example').DataTable({
            order: [
                [2, 'asc'], // Booking Date

            ],
            pageLength: 10,
            "language": {
                "emptyTable": "No data available",
                "info": "",
                "infoEmpty": "",
                "infoFiltered": "" 
            },
            dom: '<"top"f>t<"bottom row"<"col-12 d-flex justify-content-end"p>>',
            columnDefs: [

                {
                    targets: [2],
                    type: 'string'
                } // or 'time' if using a plugin
            ]
        });

        if (oTable.rows().data().length === 0) {
            $(oTable.table().container())
                .find('.dataTables_paginate')
                .hide();
        }
        
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
        $('#from').calendar({
            type: 'date',
            maxDate: new Date({{ strtotime(date('Y-m-d H:i:s') . '-1 days') }} * 1000),
        });
    </script>
    <script>
        $('#to').calendar({
            type: 'date',
            maxDate: new Date({{ strtotime(date('Y-m-d H:i:s') . '-1 days') }} * 1000),
        });
    </script>
@endsection

@extends('layouts.app')
@section('title')
    <title>
        V-Tutor | Tutor | My session</title>
@endsection
@section('left_part')
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
                                <h2 class="profile-heading">Sessions</h2>
                                <p class="gj_sub_hd">You can find information about your sessions in this section</p>
                            </div>
                            <div class="class-feild">
                                <form method="post" action="{{ route('tutor.myclass') }}" id="frm">
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
                                                        <a href="{{ route('tutor.myclass') }}" class="dash-btn ">Reset</a>
                                                        {{-- <button class="dash-btn @if (count(@$classes) <= 0) addDisablePhone pointerEventsNone @endif"> <img src="{{ public_asset('assets/images/ser.png')}}"> Reset </button> --}}
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-sm-2 @if (@$count_classes <= 0) addDisablePhone pointerEventsNone @endif">
                                                    <a id="click_download" href="javascript:void(0);"
                                                        class="dash-btn">Download</a>

                                                </div>
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
                                                <a class="nav-link active" {{-- data-toggle="tab" --}}
                                                    href="{{ route('tutor.myclass') }}">Today's Sessions </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " {{-- data-toggle="tab" --}}
                                                    href="{{ route('tutor.myclass.upcoming') }}">Upcoming Sessions </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" {{-- data-toggle="tab" --}}
                                                    href="{{ route('tutor.myclass.past') }}"> Past Sessions</a>
                                            </li>
                                        </ul>
                                        <div class="">
                                            <form method="post" action="{{ route('tutor.class.export') }}">
                                                @csrf
                                                <input type="hidden" name="session" value="present">
                                                <input type="hidden" name="status" value="{{ request('status') }}">

                                                {{-- <button style="display:none;" id="download_cls"
                                                    class="deen @if (count(@$classes) <= 0) addDisablePhone pointerEventsNone @endif"
                                                    type="submit">Download</button> --}}
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
                                                            <th><span class="d-flex align-items-center ">Student <img src="{{ public_asset('assets/images/sort.png') }}"></span>
                                                            </th>
                                                            <th><span class="d-flex align-items-center ">Date <img src="{{ public_asset('assets/images/sort.png') }}"></span>
                                                            </th>
                                                            <th class=""><span class="d-flex align-items-center ">Time <img
                                                                    src="{{ public_asset('assets/images/sort.png') }}"></span></th>
                                                            <th><span class="d-flex align-items-center ">Academic Program <img src="{{ public_asset('assets/images/sort.png') }}"></span>
                                                            </th>
                                                            <th><span class="d-flex align-items-center ">Grade <img src="{{ public_asset('assets/images/sort.png') }}"></span>
                                                            </th>
                                                            <th><span class="d-flex align-items-center">Subject <img
                                                                    src="{{ public_asset('assets/images/sort.png') }}"></span></th>
                                                            <th><span class="d-flex align-items-center">Status <img src="{{ public_asset('assets/images/sort.png') }}"></span>
                                                            </th>
                                                            <th class="view_details_ses"><span class="d-flex align-items-center">Session <img
                                                                    src="{{ public_asset('assets/images/sort.png') }}"></span></th>
                                                            <th> </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($classes as $key => $val)
                                                            <tr>

                                                                <td data-label="Name">
                                                                   <a href="{{ route('teacher.view.details.class.booking', $val->booking_no) }}" target="blank" > {{ @$val->booking_no }}</a>
                                                                </td>
                                                                <td data-label="Name">{{ @$val->getStudent->f_name }}
                                                                    {{ @$val->getStudent->l_name }}</td>
                                                                <td data-label="Date"
                                                                    data-order="{{ date('Y-m-d', strtotime(@$val->booking_date_user)) }}">
                                                                    {{ date('d-m-Y', strtotime(@$val->booking_date_user)) }}
                                                                </td>
                                                                <!-- From - To Time -->
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
                                                                 <td data-label="Name">
                                                                    @if (@$val->booking_status == 'B' && @$val->from_time_user <= date('H:i:s') && @$val->to_time_user >= date('H:i:s'))
                                                                        <li>
                                                                            <a target="_blank" class=""
                                                                                href="{{ route('tutor.class.session.link', ['userid' => Auth()->user()->unique_id, 'id' => @$val->booking_no]) }}">
                                                                                {{-- {{ route('class.session.link',@$val->id) }} --}}
                                                                                Click to join
                                                                            </a>

                                                                        </li>
                                                                    @elseif(
                                                                        @$val->booking_status == 'B' &&
                                                                            @$val->from_time_user <= date('H:i:s', strtotime('+5 minutes')) &&
                                                                            @$val->to_time_user >= date('H:i:s'))
                                                                        <li>
                                                                            <a target="_blank"
                                                                                href="{{ route('tutor.class.session.link', ['userid' => Auth()->user()->unique_id, 'id' => @$val->booking_no]) }}"
                                                                                class="">
                                                                                {{-- {{ route('class.session.link',@$val->id) }} --}}
                                                                                Click to join
                                                                            </a>

                                                                        </li>
                                                                    @elseif(@$val->booking_status == 'B')
                                                                        <li>
                                                                            <a class="show_upcoming_session_link "
                                                                                target="_blank"
                                                                                href="{{ route('tutor.class.session.link', ['userid' => Auth()->user()->unique_id, 'id' => @$val->booking_no]) }}"
                                                                                class="">
                                                                                Click to join
                                                                            </a>
                                                                        </li>
                                                                    @elseif(@$val->booking_status == 'C')
                                                                        <li class="pointerEventsNone addDisablePhone">
                                                                            <a target="_blank" href="{{ route('tutor.class.session.link', ['userid' => Auth()->user()->unique_id, 'id' => @$val->booking_no]) }}" class="">

                                                                                Click to join
                                                                            </a>

                                                                        </li>
                                                                    @endif

                                                                    {{-- <a target="_blank" href="{{ route('class.session.link',@$val->id) }}"></a> --}}
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
                                                                            style="display: none;"> <span class="angle"><img
                                                                                    src="{{ public_asset('assets/images/angle.png') }}"
                                                                                    alt=""></span>
                                                                            <ul>
                                                                                <li><a
                                                                                        href="{{ route('teacher.view.details.class.booking', $val->booking_no) }}">View
                                                                                        Details</a></li>
                                                                                @if (@$val->class_assessment_student == 'N' && @$val->booking_status == 'CM')
                                                                                    <li><a
                                                                                            href="{{ route('tutor.class.end.assesment', $val->booking_no) }}">Review
                                                                                            Session</a></li>
                                                                                @endif
                                                                                {{-- @if (@$val->booking_status == 'B' && @$val->from_time_user <= date('H:i:s') && @$val->to_time_user >= date('H:i:s'))
                                                                        <li><a href="{{@$val->start_url}}" target="_blank">Join the class <img src="{{ public_asset('assets/images/camera.png')}}"></a></li>
                                                                        @elseif(@$val->booking_status == 'B' && @$val->from_time_user <= date('H:i:s',strtotime(date('H:i:s'))+(60*5)) && @$val->to_time_user >= date('H:i:s') )
                                                                            <li><a href="{{@$val->start_url}}" target="_blank">Join the class <img src="{{ public_asset('assets/images/camera.png')}}"></a></li>
                                                                        @endif --}}
                                                                                {{-- @if (@$val->booking_status == 'B' && @$val->booking_date == date('Y-m-d') && @$val->from_time_user <= date(strtotime('H:i:s  + 5 minute')) && @$val->to_time_user <= date(strtotime('H:i:s  + 5 minute'))) --}}
                                                                                {{-- @if (@$val->booking_status == 'B' && @$val->to_time_user >= date('H:i:s'))
                                                                                    <li><a href="{{ route('tutor.class.session.link', ['userid' => Auth()->user()->unique_id, 'id' => @$val->booking_no]) }}"
                                                                                            target="_blank">Join the session
                                                                                            <img
                                                                                                src="{{ public_asset('assets/images/camera.png') }}"></a>
                                                                                    </li>
                                                                                @endif --}}

                                                                                @if (@$val->booking_status == 'B')
                                                                                    @if (@$val->booking_date_user == date('Y-m-d') && @$val->from_time_user > date('H:i:s'))
                                                                                        <li>
                                                                                            <a id="session_open_popup_link{{ $val->id }}"
                                                                                                data-toggle="modal"
                                                                                                data-target="#cancelPopup"
                                                                                                style="display:none;">Cancel
                                                                                                Session</a>
                                                                                            <a class="session_open_popup_link"
                                                                                                data-id="{{ $val->id }}"
                                                                                                data-link="{{ route('teacher.cancel.class.booking', @$val->booking_no) }}">Cancel
                                                                                                Session</a>
                                                                                            {{-- <a onclick="return confirm('Are you sure want to cancel this?')" href="{{ route('teacher.cancel.class.booking',@$val->booking_no) }}">Cancel Session</a> --}}
                                                                                        </li>
                                                                                        {{-- @else --}}
                                                                                        {{-- <li>
                                                                                <a onclick="return confirm('Are you sure want to cancel this?')" href="{{ route('teacher.cancel.class.booking',@$val->booking_no) }}">Cancel Session</a>
                                                                            </li> --}}
                                                                                    @endif
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                        {{-- <div class="add_ttrr actions-main">
                                                                <a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
                                                                <div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
                                                                <ul> --}}
                                                                        {{--  <li><a href="{{route('aced.edit.page',$val->id)}}">Edit</a></li>
                                                                    <li><a onclick="return confirm('Are you sure want to delete this?')" href="{{route('aced.dlt',$val->id)}}">Delete</a></li> --}}
                                                                        {{-- </ul> --}}
                                                                        {{-- </div> --}}
                                                                        {{-- </div> --}}
                                                                </td>
                                                            </tr>
                                                        @endforeach

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
                                            <p>4.        You need an active <a href="https://zoom.us" class="red_link">Zoom</a> account to join sessions. If you don’t have one already, kindly create one and stay logged in.</p>
                                            <p>5.       To cancel the booking, go to ‘Sessions’ menu. Terms and Conditions apply for refunds. For details, go through <a href="{{ route('help') }}" class="red_link">‘Our Policies’</a> from help section on the site.</p>
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


                        <div class="next-btn1 newst_btn-pop">

                            <a href="{{route('tutor.myclass')}}" id="cancel_session_link" class="btn btn-new btn-danger float-left change-new-link"></a>


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
@endsection

@extends('layouts.app')
@section('title')
    <title>V-Tutor | Tutor | My session | Past</title>
@endsection
@section('left_part')
    {{-- @include('include.student_top_common') --}}
    @include('include.header_menu_part')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
        <div class="top_mar"></div>
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
                                <form method="post" action="{{ route('student.my.classes.past') }}" id="frm">
                                    @csrf
                                    <div class="row new_rows1">
                                        <div class="col-sm-12">
                                            <div
                                                class="row new_rows1">
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
                                                            <option value="C"
                                                                @if (request('status') == 'C') selected @endif>Cancelled
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-6">
                                                    <div class="form_box_area">
                                                        <button class="dash-btn"> <img
                                                                src="{{ public_asset('assets/images/ser.png') }}"> Search
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-6">
                                                    <div class="form_box_area">
                                                        <a href="{{ route('student.my.classes.past') }}"
                                                            class="dash-btn">Reset</a>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-sm-2 col-6">
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
                                    <div class="tab-rii mb-4">
                                        <ul class="nav nav-tabs flex-wrap">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('student.my.classes') }}">Today's
                                                    Sessions</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('student.my.classes.upcoming') }}">Upcoming
                                                    Sessions</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="{{ route('student.my.classes.past') }}">Past
                                                    Sessions</a>
                                            </li>
                                        </ul>
                                        <div class="">
                                            <form method="post" action="{{ route('student.class.export') }}">
                                                @csrf
                                                <input type="hidden" name="session" value="past">
                                                <input type="hidden" name="status" value="{{ request('status') }}">
                                                <input type="hidden" name="from_date" value="{{ request('from_date') }}">
                                                <input type="hidden" name="to_date" value="{{ request('to_date') }}">
                                                <button style="display:none;" id="download_cls" class="deen"
                                                    type="submit">Download</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="today">
                                            <div class="custom-table">
                                                <table id="example" class="cell-border table table-responsive table-sortable">
                                                    <thead>
                                                        <tr>
                                                            <th><span class="header-with-icon">
                                                                    Booking ID
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span></th>
                                                            <th><span class="header-with-icon">
                                                                    Tutor
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span></th>
                                                            <th><span class="header-with-icon">
                                                                    Date
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span></th>
                                                            <th><span class="header-with-icon">
                                                                    Time
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span></th>
                                                            <th><span class="header-with-icon">
                                                                    Academic Program
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                            </span></th>
                                                            <th><span class="header-with-icon">
                                                                    Grade
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span></th>
                                                            <th><span class="header-with-icon">
                                                                    Subject
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span></th>
                                                            <th><span class="header-with-icon">
                                                                    Status
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span></th>
                                                            <th><span class="header-with-icon">
                                                                    Actions
                                                                    <img src="{{ public_asset('assets/images/sort.png') }}"
                                                                        alt="sort">
                                                                </span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($classes as $val)
                                                            <tr>
                                                                <td><a   href="{{ route('student.view.details.class.booking', $val->booking_no) }}">{{ @$val->booking_no }}</a></td>
                                                                <td>{{ @$val->getTutor->f_name }}
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
                                                                <td data-label="Academic Program">
                                                                    @if($val->is_academic_program == 1 && $val->academicProgramPurchase && $val->academicProgramPurchase->academicProgram)
                                                                        {{ $val->academicProgramPurchase->academicProgram->name }}
                                                                    @else
                                                                        No
                                                                    @endif
                                                                </td>
                                                                <!-- <td>{{ @$val->getStudentGrade->grade_name }}</td> -->
                                                                <td data-label="Grade">
                                                                    @if($val->is_academic_program == 1 && $val->academicProgramPurchase && $val->academicProgramPurchase->academicProgram)
                                                                        {{ $val->academicProgramPurchase->academicProgram->grade->grade_name ?? '-' }}
                                                                    @else
                                                                        {{ @$val->getStudentGrade->grade_name }}
                                                                    @endif
                                                                </td>
                                                                <!-- <td>{{ @$val->getSubject->subject }}</td> -->
                                                                 <td data-label="Subject">
                                                                    @if($val->is_academic_program == 1 && $val->academicProgramPurchase && $val->academicProgramPurchase->academicProgram)
                                                                        {{ $val->academicProgramPurchase->academicProgram->branch->branch_name ?? '-' }}
                                                                     @else
                                                                         {{ @$val->getSubject->subject }}
                                                                     @endif
                                                                </td>
                                                                <td>
                                                                    @if ($val->booking_status == 'B')
                                                                        Booked
                                                                    @elseif($val->booking_status == 'C')
                                                                        Cancelled
                                                                    @elseif($val->booking_status == 'CM')
                                                                        @if ($val->class_assessment_student == 'N')
                                                                            <a class="red_link"
                                                                                href="{{ route('student.class.end.assesment', $val->booking_no) }}">Review</a>
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
                                                                            id="action{{ $val->id }}"
                                                                            onclick="fun({{ $val->id }})"><img
                                                                                src="{{ public_asset('assets/images/action-dots.png') }}"
                                                                                alt=""></a>
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
                                                                                @if ($val->class_assessment_student == 'N' && $val->booking_status == 'CM')
                                                                                    <li><a
                                                                                            href="{{ route('student.class.end.assesment', $val->booking_no) }}">Review
                                                                                            Session</a></li>
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
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            oTable = $('#example').DataTable({
                order: [
                    [2, 'desc'], // Booking Date column
                    [3, 'desc'] // Time column
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
            flatpickr("#from_date", {
                dateFormat: "Y-m-d",
                maxDate: new Date().fp_incr(-1)
            });

            flatpickr("#to_date", {
                dateFormat: "Y-m-d",
                maxDate: new Date().fp_incr(-1)
            });

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

            $('#click_download').on('click', function() {
                $('#download_cls').click();
            });
        });

        function fun(id) {
            $('.show-actions').slideUp();
            $('#show-action' + id).show();
        }

        $(document).mouseup(function(e) {
            var container = $(".show-actions");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.hide();
            }
        });
    </script>
@endsection

@extends('layouts.app')

@section('title')
<title>V-Tutor | Student | Session Booking Confirmation | {{ @$booking->booking_no }}</title>
@endsection

@section('left_part')
@include('include.header_menu_part')
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

                            <div class="user-right-top-new tranhis">
                                <h2 class="profile-heading">
                                    Session Booking Confirmation
                                </h2>

                                @include('include.errors')
                            </div>

                            <div class="user-right-top-new marb90 text-center">

                                <h2 class="profile-headingnew" style="font-size: 1.4rem !important;">
                                    Congrats! Your session booking is confirmed
                                </h2>

                                <p style="font-style: italic;">
                                    Refer to the confirmation email for booking link and other details
                                </p>

                                @php
                                    $program = optional($booking->academicProgramPurchase)->academicProgram;
                                @endphp

                                <div class="booking-stat table_book gj_book_af_cfm_inf">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped text-left">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Booking Order Confirmation</th>
                                                    <th width="200">Booking Details</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                <tr>
                                                    <td>Booking Order #</td>
                                                    <td>{{ @$booking->booking_no }}</td>
                                                </tr>

                                                <tr>
                                                    <td>Booking Date</td>
                                                    <td>
                                                        {{ isset($booking->booking_date_user) 
                                                            ? date('d-m-Y', strtotime($booking->booking_date_user)) 
                                                            : '-' }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Academic Program</td>
                                                    <td>{{ optional($program)->name ?? '-' }}</td>
                                                </tr>

                                                <tr>
                                                    <td>Subject</td>
                                                    <td>{{ optional(optional($program)->branch)->branch_name ?? '-' }}</td>
                                                </tr>

                                                <tr>
                                                    <td>Year</td>
                                                    <td>{{ optional(optional($program)->grade)->grade_name ?? '-' }}</td>
                                                </tr>

                                                <tr>
                                                    <td>Session Timing</td>
                                                    <td>
                                                        {{ date('h:i a', strtotime($booking->from_time_user)) }}
                                                        to
                                                        {{ date('h:i a', strtotime($booking->to_time_user)) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Session for (Student)</td>
                                                    <td>
                                                        {{ optional($booking->getStudent)->f_name }}
                                                        {{ optional($booking->getStudent)->l_name }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Session with (Tutor)</td>
                                                    <td>
                                                        {{ optional($booking->getTutor)->f_name }}
                                                        {{ optional($booking->getTutor)->l_name }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Booking Status</td>
                                                    <td><b>Confirmed</b></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="gj_disc_div">
                                        <p class="bk_disc">
                                            <b>Disclaimer:</b> V-Tutor acts solely as a facilitator and authorised payment agent between parents/students and tutors. All tutoring engagements are directly between the tutor and the parent/student. V-Tutor does not hold funds on trust and accepts no responsibility for tutoring outcomes once payment has been settled.
                                        </p>
                                    </div>

                                </div>

                                <div class="backBtnCls">
                                    <a href="{{ route('student.my.classes') }}" class="pg_btn">Sessions</a>
                                    <a href="{{ route('student.my.academic.program') }}" class="pg_btn">My Learning Programs</a>
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
@endsection
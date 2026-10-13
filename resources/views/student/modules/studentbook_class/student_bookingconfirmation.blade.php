@extends('layouts.app')
@section('title')
<title>V-Tutor  | Student | Booking Confirmaton | {{ @$bookingDataInformation->booking_no }}</title>
@endsection
@section('left_part')
{{-- @include('include.student_top_common') --}}
@include('include.header_menu_part')
@endsection
@section('content')
<section class="makes_special_sec faq-sec">
    <div class="makes_special_inr">
        <div class="top_mar"></div>
        <!--- profile --->
        <section class="user-account">
            <div class="container">
                <div class="row">
                    <div class="zin">
                        @include('include.student_left_common')
                        <div class="user-right-panel">
                            <div class="user-right-top-new tranhis ">
                                <h2 class="profile-heading">Booking @if(@$bookingDataInformation->booking_status == 'C') Cancelled @else Confirmation @endif</h2>
                                @php
                                    $myGrade = \App\Models\Grade::where(['id'=>@Auth::user()->grade,'status'=>'A'])->select('id','slug','status')->first();
                                    $myState = \App\Models\State::where(['id'=>@Auth::user()->state])->first();
                                @endphp




                                @include('include.errors')

                            </div>










                            <div class="user-right-top-new marb90 text-center">


                                {{-- @if(@$bookingDataInformation->booking_status == 'IC')
                                <img src="{{ public_asset('assets/images/confr.png') }}">



                                <h2 class="profile-headingnew">s </h2>



                                <p class="" style="font-style: italic;">An email with booking details will be sent once confirmed</p>
                                <p class="bold_black_text">Kindly pay to confirm booking</p>
                                @else --}}
                                {{-- <img src="{{ public_asset('assets/images/confr.png') }}"> --}}



                                <h2 class="profile-headingnew">Congrats! Your booking is @if(@$bookingDataInformation->booking_status == 'C') cancelled @else confirmed @endif</h2>

                                @php
                                    $myGrade = \App\Models\Grade::where(['id'=>@Auth::user()->grade,'status'=>'A'])->select('id','slug','status')->first();
                                    $myState = \App\Models\State::where(['id'=>@Auth::user()->state])->first();
                                @endphp

                                {{-- <div class="float-right" style="margin-right: 10px;">
                                    <a class="deen" href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . optional(@$bookingDataInformation)->tutor_id . '&search_tutor_id_studentclass=' . optional(@$bookingDataInformation)->tutor_id) }}" style="color: white;">Book Again</a>
                                </div> --}}


                                <p class="" style="font-style: italic;">Refer to the confirmation email for booking link and other details</p>

                                <p class="bold_black_text"></p>

                                {{-- @endif --}}





                                <!-- <div class="booking-stat">



                                    <span>Booking Number: <p> {{ @$bookingDataInformation->booking_no }} </p></span>



                                    <span>Subject: <p> {{ @$bookingDataInformation->getSubject->subject }} </p></span>



                                    <span>Date: <p> {{date('d-m-Y', strtotime(@$bookingDataInformation->booking_date_user))}} </p></span>



                                    <span>Time: <p> {{ date("h:i a", strtotime(@$bookingDataInformation->from_time_user)) }} to {{ date("h:i a", strtotime(@$bookingDataInformation->to_time_user)) }} </p></span>



                                </div> -->

                                {{-- 24-10-25 --}}
                                {{-- <div class="booking-stat table_book">

                                    <div class="table-responsive">

                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Booking Number </th>
                                                    <th>Subject</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    //<th>Rate per session (30 mins)</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                        <tr>
                                            <td>{{ @$bookingDataInformation->booking_no }}</td>
                                            <td>{{ @$bookingDataInformation->getSubject->subject }} </td>
                                            <td>{{date('d-m-Y', strtotime(@$bookingDataInformation->booking_date_user))}}</td>
                                            <td>{{ date("h:i a", strtotime(@$bookingDataInformation->from_time_user)) }} to {{ date("h:i a", strtotime(@$bookingDataInformation->to_time_user)) }}</td>
                                            //<td>${{ @$bookingDataInformation->hourly_rate }}</td>
                                            <td>${{ number_format(@$bookingDataInformation->booking_amount+@$bookingDataInformation->stripe_charge,2) }}</td>
                                            <td class="@if(@$bookingDataInformation->booking_status=="B")
                                                            Booked
                                                            @elseif(@$bookingDataInformation->booking_status=="C")
                                                            cancelled_red_color
                                                            @elseif(@$bookingDataInformation->booking_status=="CM")
                                                            completed_green_color
                                                            @else
                                                            In progress
                                                            @endif">
                                                @if(@$bookingDataInformation->booking_status == 'IC')
                                                Incomplete
                                                @elseif(@$bookingDataInformation->booking_status == 'B')
                                                Booked
                                                @elseif(@$bookingDataInformation->booking_status == 'CM')
                                                Completed
                                                @elseif(@$bookingDataInformation->booking_status == 'C')
                                                Cancelled
                                                @elseif(@$bookingDataInformation->booking_status == 'F')
                                                Failed
                                                @endif
                                            </td>


                                        </tr>

                                        </table>
                                    </div>
                                </div> --}}

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
                                                    <td>Booking Order # </td>
                                                    <td>{{ @$bookingDataInformation->booking_no }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Booking Date</td>
                                                    <td>{{ (isset($bookingDataInformation->booking_date_user) && $bookingDataInformation->booking_date_user) ? date('d-m-Y', strtotime($bookingDataInformation->booking_date_user)) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Session for ‘Subject’</td>
                                                    <td>{{ @$bookingDataInformation->getSubject->subject }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Session for ‘Grade’</td>
                                                    <td>{{ @$bookingDataInformation->getStudentGrade->grade_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Session Timing</td>
                                                    <td>{{ date('h:i a', strtotime(@$bookingDataInformation->from_time_user)) }} to
                                                    {{ date('h:i a', strtotime(@$bookingDataInformation->to_time_user)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Session for (Student)</td>
                                                    <td>{{ @$bookingDataInformation->getStudent->f_name }} {{ @$bookingDataInformation->getStudent->l_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Session with (Tutor)</td>
                                                    <td>{{ @$bookingDataInformation->getTutor->f_name }} {{ @$bookingDataInformation->getTutor->l_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Session Rate</td>
                                                    <td>${{ @$bookingDataInformation->hourly_rate }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Added GST of 10%</td>
                                                    <td>
                                                        @php
                                                            $from_time = @$bookingDataInformation->from_time;

                                                            $to_time = @$bookingDataInformation->to_time;

                                                            $currentDiff = (strtotime($to_time) - strtotime($from_time)) / 60;
                                                            $tot = @$bookingDataInformation->booking_amount + @$bookingDataInformation->booking_amount * config('sessionsettings.GST');
                                                        @endphp
                                                        
                                                        @if (isset($bookingDataInformation->net_total) && $bookingDataInformation->net_total)
                                                            <span class="bf_prm" style="text-decoration: line-through;">${{ number_format($tot,2) }}</span>
                                                            <span class="af_prm">${{ number_format($bookingDataInformation->net_total, 2) }}</span>
                                                        @else
                                                            <span class="bf_prm">${{ number_format($tot,2) }}</span>
                                                            <span class="af_prm"></span>
                                                        @endif

                                                        <input type="hidden" value="{{ @$bookingDataInformation->hourly_rate }}" name="bk_hourly_rate" id="bk_hourly_rate">
                                                        <input type="hidden" value="{{ @$tot }}" name="bk_tot_rate" id="bk_tot_rate">

                                                        <input type="hidden" value="" name="discount_val" id="discount_val">
                                                        <input type="hidden" value="" name="discount_code" id="discount_code">
                                                        <input type="hidden" value="" name="net_total" id="net_total">
                                                        <input type="hidden" name="booking_id" value="{{ @$bookingDataInformation->id }}" id="booking_id">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Booking Status </td>
                                                    <td><b>Confirmed</b></td>
                                                </tr>
                                                @if (isset($bookingDataInformation->discount_code) && $bookingDataInformation->discount_code)
                                                    <tr class="text-right promo_tr">
                                                        <td>
                                                            Applied Promo Code
                                                            <p class="error prm_err"></p>
                                                        </td>
                                                        <td class="text-center">
                                                            {{$bookingDataInformation->discount_code}}
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="gj_disc_div">
                                        <p class="bk_disc"><b>Disclaimer:</b> V-Tutor acts solely as a facilitator and authorised payment agent between parents/students and tutors. All tutoring engagements are directly between the tutor and the parent/student. V-Tutor does not hold funds on trust and accepts no responsibility for tutoring outcomes once payment has been settled.</p>
                                    </div>
                                </div>

                                @if(@$bookingDataInformation->booking_status == 'C')
                                    <div class="booking-stat table_book">
                                        <div class="table-responsive">
                                            
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
                                                        <td>@if(@$bookingDataInformation->getPaymentsInfo->refund_id)
                                                            {{ @$bookingDataInformation->getPaymentsInfo->refund_id }}
                                                            @else
                                                            No refund
                                                            @endif</td>
                                                        <td>${{ @$bookingDataInformation->getPaymentsInfo->refund_amount }}</td>
                                                        <td>
                                                            @if(@$bookingDataInformation->cancelled_by == 'S')
                                                                {{ @$bookingDataInformation->getStudent->parent_f_name }} {{ @$bookingDataInformation->getStudent->parent_l_name }}
                                                            @elseif(@$bookingDataInformation->cancelled_by == 'T')
                                                                {{ @$bookingDataInformation->getTutor->f_name }} {{ @$bookingDataInformation->getTutor->l_name }}
                                                            @elseif(@$bookingDataInformation->cancelled_by == 'A')
                                                                Admin
                                                            @endif
                                                        </td>
                                                        <td>{{ @$bookingDataInformation->cancelled_on }}</td>
                                                        <td>
                                                            @if(@$bookingDataInformation->getPaymentsInfo->refund_id)
                                                            @php
                                                            $paidVia = json_decode(@$bookingDataInformation->getPaymentsInfo->refund_response);
                                                            @endphp
                                                            {{strtoupper(@$paidVia->status)}}
                                                            @else
                                                            No refund
                                                            @endif

                                                        </td>


                                                    </tr>
                                            </table>
                                            
                                        </div>
                                        <div class="btn_3_cc">
                                                @if($bookingDataInformation->booking_status != 'C')
                                                    {{-- @if(@$bookingDataInformation->booking_date ==date('Y-m-d') && @$bookingDataInformation->to_time > date('H:i:s'))
                                                        <a data-toggle="modal" data-target="#cancelPopup" href="#" class="sub_btn new-subbtn">Cancel Booking</a>
                                                    @else
                                                        <a data-toggle="modal" data-target="#cancelPopup" href="#" class="sub_btn new-subbtn">Cancel Booking</a>
                                                    @endif --}}
                                                @endif
                                                @php
                                                $getTutorGrades = @$bookingDataInformation->getTutor->getTutorShipPlan->pluck('grade_id')->toArray();
                                                $mGrade = @Auth::user()->grade;
                                                @endphp
                                                @if(@$admin_disable_bookings_values->disable_booking == 'Y')
                                                <li><a class="open_popup_g" data-toggle="modal" data-target="#admin_disabled_bookings_popup" href="javascript:void(0);">Book again</a></li>
                                                @elseif(in_array(date('Y-m-d'),$all_disabled_booking_dates))
                                                <li><img src="{{ public_asset('assets/images/list_ico1.png') }}" alt=""><a class="open_popup_g" data-toggle="modal" data-target="#admin_disabled_bookings_popup" href="javascript:void(0);">Book again</a></li>

                                                @elseif(!in_array($mGrade,$getTutorGrades))
                                                <li><a class="open_popup_g sub_btn new-subbtn" data-toggle="modal" data-target="#not_b_popup" href="javascript:void(0);">Book Again </a></li>

                                                @endif
                                            </div>
                                    </div>
                                @endif

                                <div class="backBtnCls">
                                    <a href="{{ route('student.my.classes') }}" class="pg_btn">Sessions</a>

                                    <a href="{{ url('studentbook-class?search_tutor_slug_studentclass=' . optional(@$bookingDataInformation)->tutor_id . '&search_tutor_id_studentclass=' . optional(@$bookingDataInformation)->tutor_id) }}" class="pg_btn">Book Again</a>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>



            </div>



        </section>


        <div class="modal fade log_modal_bx" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">You are about to leave the site to complete booking process</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal_button">
                        <ul>
                            <li><a href="#" class=" pg_btn">Leave</a></li>
                            <li><a href="#" class="pg_btn">Stay</a></li>
                        </ul>
                    </div>
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
                                        You cannot book this tutor since they are outside your State / Timezone. Try to book tutors within your State / Timezone.
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
                        <p>You have chosen to cancel the booking. If this is by mistake, kindly ignore</p>
                        <p>Cancellation of sessions will be treated in accordance with the V-Tutor cancellation policy. Refunds are subject to conditions. Refer to the policy from the Help section for more details.</p>

                        <div class="next-btn1 newst_btn-pop">
                            {{-- {{ route('student.cancel.class.booking',@$val->booking_no) }} --}}
                            <a href="{{ route('student.cancel.class.booking',@$bookingDataInformation->booking_no) }}" class="btn btn-new btn-danger float-left change-new-link">Yes, please cancel</a>

                            <button type="button" class="btn btn-new btn-danger " data-dismiss="modal">No, don’t cancel </button>
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







@endsection

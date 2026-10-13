@extends('layouts.app')



@section('title')



<title>V-Tutor  | tutor | View Details | {{ @$bookingDataInformation->booking_no }}</title>



@endsection



@section('left_part')



@include('include.header_menu_part')

<style type="text/css">
    .overflowtext{
        overflow-wrap: break-word;
    }
    .breaktext{
        word-break: break-all;
    }
</style>

@endsection



@section('content')



<!-- bannersec -->



<!-- bannersec -->



   <div class="top_mar"></div>



    <!--- profile --->



    <section class="user-account">



        <div class="container">



            <div class="row">



                <div class="zin">



                    @include('include.teacher_left_common'){{-- left common part --}}



                    <div class="user-right-panel addDisablePhone pointerEventsNone">



                        <div class="user-right-top-new ">

                                @include('include.errors')

                            <h2 class="profile-heading">Session Details</h2>



                            <p>You can find details of the session in this section</p>



                        </div>



                        <div class="class-feild mt-4">



                            <div class="row">
                                <div class="col-12">
                                    <div class="tuto-rating">
                                        <em>
                                            @if(@$bookingDataInformation->getStudent->profile_pic)
                                                @php
                                                $image_path = 'assets/images/all_avatars/'.@$bookingDataInformation->getStudent->profile_pic;
                                                @endphp
                                                @if(file_exists(@$image_path))
                                                    <img src="{{ public_asset('assets/images/all_avatars/' . @$bookingDataInformation->getStudent->profile_pic) }}" alt="profile_img">
                                                @else
                                                    <img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$bookingDataInformation->getStudent->profile_pic}}" alt="">
                                                @endif
                                                {{-- <img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$bookingDataInformation->getStudent->profile_pic}}" alt="" id="img2"> --}}
                                            @else
                                                @if(@$bookingDataInformation->getStudent->avatar)
                                                    <img src="{{@$bookingDataInformation->getStudent->avatar}}" alt="" id="img2">
                                                @else
                                                    <img src="{{ public_asset('assets/images/user-pro.png') }}" alt="" id="img2">
                                                @endif
                                            @endif
                                        </em>
                                        <div class="tu-info">
                                            <h2>{{ @$bookingDataInformation->getStudent->f_name }} {{ @$bookingDataInformation->getStudent->l_name }}</h2>
                                            <div class="sed">
                                                 <span><img src="{{ public_asset('assets/images/map.png') }}">  {{ @$bookingDataInformation->getStudent->city }},{{ @$bookingDataInformation->getStudent->getState->state_name }}</span>
                                                 <ul class="profile-rating m-0">










                                                </ul>



                                            </div>



                                            <div class="sed ">







                                            </div>



                                            <div class="sed grade_sed">



                                                <span><img src="{{ public_asset('assets/images/gra.png') }}"> {{ @$bookingDataInformation->getStudentGrade->grade_name }}</span>



                                                <span>



                                                        <img src="{{ public_asset('assets/images/world.png') }}">
                                                        {{ @$bookingDataInformation->getStudent->getSchool->school_name }},{{ @$bookingDataInformation->getStudent->getSchool->getState->state_name }},{{ @$bookingDataInformation->getStudent->getSchool->getSuburb->name }},{{ @$bookingDataInformation->getStudent->getSchool->postcode }}









                                                    </span>



                                            </div>







                                        </div>



                                    </div>



                                </div>



                            </div>



                        </div>







                        <div class="user-right-top-new marb90 text-center">



                            <img src="{{ public_asset('assets/images/confr.png') }}">



                            <h2 class="profile-headingnew">Session Details </h2>



                            <p> Please find details of the session below</p>
                            <div class="backBtnCls"><a href="{{ route('tutor.myclass') }}" class="pg_btn">Back</a></div>






                            <!-- <div class="booking-stat">



                                <span>Booking Number: <p> {{ @$bookingDataInformation->booking_no }} </p></span>



                                <span>Subject: <p> {{ @$bookingDataInformation->getSubject->subject }} </p></span>



                                <span>Date: <p> {{date('d-m-Y', strtotime(@$bookingDataInformation->booking_date))}} </p></span>



                                <span>Time: <p> {{ date("h:i a", strtotime(@$bookingDataInformation->from_time)) }} to {{ date("h:i a", strtotime(@$bookingDataInformation->to_time)) }} </p></span>



                            </div> -->

                            <div class="booking-stat table_book">

                                <div class="table-responsive">

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Booking Number</th>
                                                <th>Subject</th>
                                                <th class="view_details_date">Date</th>
                                                <th class="view_details_time">Time</th>
                                                <th>Rate per session <br/>(30 mins)</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th class="view_details_ses">Session</th>
                                                @if(@$bookingDataInformation->status != 'C')
                                                {{-- <th>Start Class</th> --}}
                                                @endif
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td>{{ @$bookingDataInformation->booking_no }}</td>
                                            <td>{{ @$bookingDataInformation->getSubject->subject }} </td>
                                            <td>{{date('d-m-Y', strtotime(@$bookingDataInformation->booking_date))}}</td>
                                            <td>{{ date("h:i a", strtotime(@$bookingDataInformation->from_time)) }} to {{ date("h:i a", strtotime(@$bookingDataInformation->to_time)) }}</td>
                                            <td>${{ @$bookingDataInformation->hourly_rate }}</td>
                                            <td>${{ @$bookingDataInformation->tutor_earnings }}</td>
                                            <td>
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
                                            <td>
                                                @if(@$bookingDataInformation->booking_status == 'B' && @$bookingDataInformation->from_time <= date('H:i:s') && @$bookingDataInformation->to_time >= date('H:i:s') )
                                                        <li>
                                                            <a target="_blank" href="{{ route('tutor.class.session.link',['userid' => Auth()->user()->unique_id, 'id' => @$bookingDataInformation->booking_no]) }}">
                                                                {{-- {{ route('tutor.class.session.link',@$val->id) }} --}}
                                                                {{ url('/') }}..
                                                            </a>

                                                        </li>
                                                    @elseif(@$bookingDataInformation->booking_status == 'B' && @$bookingDataInformation->from_time <= date("H:i:s", strtotime('+5 minutes')) && @$bookingDataInformation->to_time >= date('H:i:s') )
                                                        <li>
                                                            <a target="_blank" href="{{ route('tutor.class.session.link',['userid' => Auth()->user()->unique_id, 'id' => @$bookingDataInformation->booking_no]) }}">
                                                             {{-- {{ route('tutor.class.session.link',@$bookingDataInformation->id) }} --}}
                                                             {{ url('/') }}..
                                                         </a>

                                                        </li>
                                                    @elseif(@$bookingDataInformation->booking_status == 'B')
                                                        <li>
                                                            <a data-toggle="modal" data-target="#sessionLink" href="javascript:void(0);">
                                                                {{-- {{ route('tutor.class.session.link',@$bookingDataInformation->id) }} --}}
                                                                {{ url('/') }}..
                                                            </a>

                                                        </li>
                                                    @endif
                                                {{-- <a href="{{ route('tutor.class.session.link',@$bookingDataInformation->id) }}">{{ route('tutor.class.session.link',@$bookingDataInformation->id) }}</a> --}}
                                            </td>
                                            @if(@$bookingDataInformation->status != 'C')
                                            {{-- <td class="overflowtext breaktext">{{ @$bookingDataInformation->start_url }}</td> --}}
                                            @endif
                                        </tr>
                                    </table>

                                </div>
                                <div class="table-responsive">
                                    <div class="table-responsive">
                                    @if(@$bookingDataInformation->booking_status == 'C')
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
                                                    @if(@$bookingDataInformation->getPaymentsInfo->refund_type == '100')
                                                      Full Refund
                                                      @elseif(@$bookingDataInformation->getPaymentsInfo->refund_type == '75')
                                                      75% amount refunded
                                                      @elseif(@$bookingDataInformation->getPaymentsInfo->refund_type == '50')
                                                      50% amount refunded
                                                      @elseif(@$bookingDataInformation->getPaymentsInfo->refund_type == '25')
                                                      25% amount refunded
                                                      @elseif(@$bookingDataInformation->getPaymentsInfo->refund_type == 'N')
                                                      No refund
                                                      @endif
                                                    {{-- @if(@$bookingDataInformation->getPaymentsInfo->refund_id)
                                                    @php
                                                      $paidVia = json_decode(@$bookingDataInformation->getPaymentsInfo->refund_response);
                                                      @endphp
                                                      {{strtoupper(@$paidVia->status)}}
                                                    @else
                                                    No refund
                                                    @endif --}}
                                                    {{-- @if(@$bookingDataInformation->getPaymentsInfo->refund_amount <= 0)
                                                    No Refund
                                                    @elseif(@$bookingDataInformation->getPaymentsInfo->refund_amount == @$bookingDataInformation->booking_amount)
                                                    Full Refund
                                                    @elseif(@$bookingDataInformation->getPaymentsInfo->refund_amount != @$bookingDataInformation->booking_amount && @$bookingDataInformation->getPaymentsInfo->refund_amount > 0)
                                                    Partial Refund
                                                    @endif --}}
                                                </td>


                                            </tr>
                                    </table>
                                    @endif
                                </div>
                                <div class="btn_3_cc">
                                    @if(@$bookingDataInformation->booking_status == 'B')
                                        @if(@$bookingDataInformation->booking_date ==date('Y-m-d') && @$bookingDataInformation->from_time < date('H:i:s'))
                                        {{-- sus_bg --}}
                                        {{-- <a class="sub_btn new-subbtn " data-toggle="modal" data-target="#exampleModal">Proceed to pay</a> --}}
                                            <a onclick="return confirm('Are you sure want to cancel ?')" href="{{ route('student.cancel.class.booking',@$bookingDataInformation->booking_no) }}" class="sub_btn new-subbtn">Cancel Booking</a>
                                        @else
                                            <a onclick="return confirm('Are you sure want to cancel ?')" href="{{ route('student.cancel.class.booking',@$bookingDataInformation->booking_no) }}" class="sub_btn new-subbtn">Cancel Booking</a>
                                        @endif
                                    @endif
                                </div>

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
                        {{-- <span class="proclosespan">Cancel Booking</span> --}}
                        <h6></h6>
                        <p>Meeting link will be active only 5 minutes before the session</p>


                        <div class="next-btn1 newst_btn-pop">
                            {{-- {{ route('student.cancel.class.booking',@$val->booking_no) }} --}}
                            <a href="{{route('student.my.classes')}}" id="cancel_session_link" class="btn btn-new btn-danger float-left change-new-link"></a>


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

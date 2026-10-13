@extends('layouts.app')

@section('title')
    <title>V-Tutor  | Student | Payment | {{ @$bookingDataInformation->booking_no }}</title>
@endsection

@section('left_part')
    {{-- @include('include.student_top_common') --}}
@include('include.header_menu_part')

    <style type="text/css">
        .selectBox {

            height: 44px;

        }
    </style>
@endsection

@section('content')
<section class="makes_special_sec faq-sec">
    <div class="makes_special_inr">
    <!-- bannersec -->

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

                            <h2 class="profile-heading">Booking Order</h2>

                            {{-- <p> {{ @$bookingDataInformation->booking_no }} </p> --}}

                            @include('include.errors')

                        </div>



                        {{-- <div class="class-feild mt-4">

                            <div class="row">

                                <div class="col-12">

                                    <div class="tuto-rating">

                                        <em>

                                            @if (@$bookingDataInformation->getTutor->profile_pic)
                                                @php

                                                    $image_path =
                                                        'assets/images/all_avatars/' .
                                                        @$bookingDataInformation->getTutor->profile_pic;

                                                @endphp

                                                @if (file_exists(@$image_path))
                                                    <img src="{{ public_asset('assets/images/all_avatars/' . @$bookingDataInformation->getTutor->profile_pic) }}"
                                                        alt="profile_img">
                                                @else
                                                    <img src="{{ env('STORAGE_URL') . '/teacher_profile_pic/' . @$bookingDataInformation->getTutor->profile_pic }}"
                                                        alt="">
                                                @endif


                                            @else
                                                @if (@$bookingDataInformation->getTutor->avatar)
                                                    <img src="{{ @$bookingDataInformation->getTutor->avatar }}"
                                                        alt="" id="img2">
                                                @else
                                                    <img src="{{ public_asset('assets/images/user-pro.png') }}"
                                                        alt="" id="img2">
                                                @endif
                                            @endif

                                        </em>

                                        <div class="tu-info">

                                            <h2>{{ @$bookingDataInformation->getTutor->f_name }}
                                                {{ @$bookingDataInformation->getTutor->l_name }}</h2>

                                            <div class="sed">

                                                <span><img
                                                        src="{{ public_asset('assets/images/map.png') }}">{{ @$bookingDataInformation->getTutor->city }}, {{ @$bookingDataInformation->getTutor->getState->state_name }}</span>

                                                <ul class="profile-rating m-0">

                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 0 && @$bookingDataInformation->getTutor->avg_review <= 0.24)
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
                                                        <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                    @endif

                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 0.25 && @$bookingDataInformation->getTutor->avg_review <= 0.74)
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


                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 0.75 && @$bookingDataInformation->getTutor->avg_review <= 1.24)
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



                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 1.25 && @$bookingDataInformation->getTutor->avg_review <= 1.74)
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
                                                        <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                    @endif



                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 1.75 && @$bookingDataInformation->getTutor->avg_review <= 2.24)
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
                                                        <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                    @endif




                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 2.25 && @$bookingDataInformation->getTutor->avg_review <= 2.74)
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
                                                        <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                    @endif




                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 2.75 && @$bookingDataInformation->getTutor->avg_review <= 3.24)
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
                                                        <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                    @endif




                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 3.25 && @$bookingDataInformation->getTutor->avg_review <= 3.74)
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
                                                        <li><a href="#"><img
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                    @endif




                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 3.75 && @$bookingDataInformation->getTutor->avg_review <= 4.24)
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
                                                                    src="{{ public_asset('assets/images/star1.png') }}"
                                                                    alt=""></a></li>
                                                    @endif





                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 4.25 && @$bookingDataInformation->getTutor->avg_review <= 4.74)
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
                                                                    src="{{ public_asset('assets/images/halfstar.png') }}"
                                                                    alt=""></a></li>
                                                    @endif



                                                    @if (@$bookingDataInformation->getTutor->avg_review >= 4.75 && @$bookingDataInformation->getTutor->avg_review <= 5)
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

                                                        <p>{{ @$bookingDataInformation->getTutor->avg_review }}
                                                            ({{ @$bookingDataInformation->getTutor->total_no_of_reviews }})
                                                        </p>

                                                    </li>

                                                </ul>

                                            </div>

                                            <div class="sed ">

                                            </div>

                                            <div class="sed grade_sed">

                                                <span><img src="{{ public_asset('assets/images/gra.png') }}">
                                                    {{ @$bookingDataInformation->getStudentGrade->grade_name }}</span>

                                                <span>

                                                    <img src="{{ public_asset('assets/images/world.png') }}">
                                                    <?php // print_r($t_my_av_show);
                                                    ?>
                                                    @if (@$t_my_av_show)
                                                        @foreach (@$t_my_av_show as $key => $t)
                                                            @if (@$key != 0)
                                                                ,
                                                            @endif

                                                            @if (@$t->day == 1)
                                                                Monday
                                                            @elseif(@$t->day == 2)
                                                                Tuesday
                                                            @elseif(@$t->day == 3)
                                                                Wednesday
                                                            @elseif(@$t->day == 4)
                                                                Thursday
                                                            @elseif(@$t->day == 5)
                                                                Friday
                                                            @elseif(@$t->day == 6)
                                                                Saturday
                                                            @elseif(@$t->day == 7)
                                                                Sunday
                                                            @endif

                                                            {{ date('h:i a', strtotime(@$t->from_time_student)) }}-{{ date('h:i a', strtotime(@$t->to_time_student)) }}
                                                        @endforeach
                                                    @endif

                                                </span>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div> --}}

                        {{-- table --}}





                        <div class="user-right-top-new marb90 text-center">

                            {{-- <img src="{{ public_asset('assets/images/exclaim_confr.png') }}"> --}}

                            {{-- <i class="fas fa-exclamation"></i> --}}





                            <h2 class="profile-headingnew">Your booking order is received. </h2>







                            <p class="" style="font-style: italic;">An email with booking details will be sent once
                                confirmed</p>

                            {{-- <p class="bold_black_text">Kindly pay to confirm booking</p> --}}
                            <p class="bold_black_text">Complete payment to confirm booking</p>

                            <div class="booking-stat table_book gj_book_cfm_inf">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped text-left">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Booking Invoice</th>
                                                <th width="150">Booking Details</th>
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

                                                    <span class="bf_prm">${{ number_format($tot,2) }}</span>
                                                    <span class="af_prm"></span>

                                                    <input type="hidden" value="{{ @$bookingDataInformation->hourly_rate }}" name="bk_hourly_rate" id="bk_hourly_rate">
                                                    <input type="hidden" value="{{ @$tot }}" name="bk_tot_rate" id="bk_tot_rate">

                                                    <input type="hidden" value="" name="discount_val" id="discount_val">
                                                    <input type="hidden" value="" name="discount_code" id="discount_code">
                                                    <input type="hidden" value="" name="net_total" id="net_total">
                                                    <input type="hidden" name="booking_id" value="{{ @$bookingDataInformation->id }}" id="booking_id">
                                                </td>
                                            </tr>
                                            <tr class="text-right promo_tr">
                                                <td>
                                                    Enter Promo Code
                                                    <p class="error prm_err"></p>
                                                </td>
                                                <td>
                                                    <div class="frm_promo">
                                                        <input type="text" name="promo_code" id="promo_code" class="form-control">
                                                        <button id="apply_promo_code" class="dash-btn">Apply Promo</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="gj_disc_div">
                                    <p class="bk_disc"><b>Disclaimer:</b> V-Tutor acts solely as a facilitator and authorised payment agent between parents/students and tutors. All tutoring engagements are directly between the tutor and the parent/student. V-Tutor does not hold funds on trust and accepts no responsibility for tutoring outcomes once payment has been settled.</p>
                                </div>
                            </div>

                            {{-- <div class="booking-stat table_book">

                                <div class="table-responsive">
                                    <?php // print_r($bookingDataInformation);
                                    ?>
                                    <table class="table table-bordered">

                                        <thead>

                                            <tr>

                                                <th>Booking Number </th>

                                                <th>Subject</th>

                                                <th>Date</th>

                                                <th>Time</th>

                                                <th>Session Rate (60 mins)</th>



                                                <th>Total Amount</th>

                                            </tr>

                                        </thead>

                                        <tr>

                                            <td>{{ @$bookingDataInformation->booking_no }}</td>

                                            <td>{{ @$bookingDataInformation->getSubject->subject }} </td>

                                            <td>{{ @$bookingDataInformation->booking_date_user }}</td>

                                            <td>{{ date('h:i a', strtotime(@$bookingDataInformation->from_time_user)) }} to
                                                {{ date('h:i a', strtotime(@$bookingDataInformation->to_time_user)) }}</td>

                                            <td>${{ @$bookingDataInformation->hourly_rate }}</td>

                                            @php

                                                $from_time = @$bookingDataInformation->from_time;

                                                $to_time = @$bookingDataInformation->to_time;

                                                $currentDiff = (strtotime($to_time) - strtotime($from_time)) / 60;
                                                $tot = @$bookingDataInformation->booking_amount + @$bookingDataInformation->booking_amount * config('sessionsettings.GST');
                                            @endphp



                                            <td>${{ number_format($tot,2) }}
                                            </td>

                                        </tr>

                                    </table>
                                    <p class="note right_side_service_charge"><i>All prices are inclusive of GST({{ config('sessionsettings.GST')*100 }} %)</i></p>

                                </div>



                            </div> --}}

                            <div class="user-account-info gj_cmf_inf_user_account_info">
                                <button id="openPaymentModal" data-toggle="modal" data-target="#beforeconfirmPayment" class="dash-btn">Complete Booking</button>
                               
<!-- <button id="payNowBtn" class="dash-btn" style="display:none;">Complete Booking</button> -->

                                <!-- <script src="https://js.stripe.com/v3/"></script> -->
                                <!-- <script>
                                    const stripe = Stripe("{{ config('services.stripe.stripe-publishable') }}");

                                    document.getElementById('payNowBtn').addEventListener('click', function() {
                                        var amt = '{{ (int) round(@$tot * 100) }}';
                                        if($('#net_total').val() && $('#net_total').val() > 0) {
                                            amt = $('#net_total').val() * 100;
                                        }
                                        amt = parseInt(amt);

                                        console.log("Button clicked, initiating payment...");
                                        fetch("{{ route('stripe.create.session') }}", {
                                                method: "POST",
                                                headers: {
                                                    "Content-Type": "application/json",
                                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                                },
                                                body: JSON.stringify({
                                                    email: "{{ @$bookingDataInformation->getStudent->email }}",
                                                    orderId: "{{ @$bookingDataInformation->id }}",
                                                    order_no: "{{ @$bookingDataInformation->booking_no }}",
                                                    // amount: {{ (int) round(@$tot * 100) }},
                                                    amount: amt,
                                                    currency: "aud",
                                                    metadata: {
                                                        order_id: "{{ @$bookingDataInformation->id }}",
                                                        order_no: "{{ @$bookingDataInformation->booking_no }}"
                                                    }
                                                })
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                stripe.redirectToCheckout({
                                                    sessionId: data.id
                                                });
                                            })
                                            .catch(err => console.error("Checkout redirect error:", err));
                                    });
                                </script> -->


                                {{-- <h3 class="payment_card_info_txt">Payment Card Info</h3> --}}

                                {{-- <form action="{{ route('pay') }}" method="post"
                                    class="chcoutt_rm_07 require-validation" data-cc-on-file="false"
                                    data-stripe-publishable-key="pk_test_51K1iCCBtFpXOdYZkFki14RCY45ER10RFgTftk4GRuzIzGbuyHqLPLloWQaSQOm1ZbvTwqxbqo70qFVx1vuwyKy6900XLNUXUs2"
                                    id="payment-form">

                                    <input type="hidden" name="email"
                                        value="{{ @$bookingDataInformation->getStudent->email }}">

                                    <input type="hidden" name="orderId" value="{{ @$bookingDataInformation->id }}">

                                    <input type="hidden" name="order_no"
                                        value="{{ @$bookingDataInformation->booking_no }}">
                                    @php
                                        $tot =
                                            @$bookingDataInformation->booking_amount +
                                            @$bookingDataInformation->stripe_charge;
                                    @endphp
                                    <input type="hidden" name="amount"
                                        value="{{ number_format(@$tot, 2, '.', '') * 100 }}">

                                    <input type="hidden" name="currency" value="aud">

                                    <input type="hidden" name="metadata"
                                        value="{{ json_encode($array = ['order_id' => @$bookingDataInformation->id, 'order_no' => @$bookingDataInformation->booking_no]) }}">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                    <div class="row new_rows no-gutters forr_btnn001">

                                        <div class="btn_3_cc forr_btnn002">
                                            <a id="openPopup" data-toggle="modal" data-target="#confirmPayment"
                                                class="sub_btn new-subbtn mt-0" style="display:none;">Complete Booking</a>
                                            <a id="openWait" data-toggle="modal" data-target="#waitFor"
                                                class="sub_btn new-subbtn mt-0" style="display:none;">Complete Booking</a>
                                            <a onclick="fun();" id="checkV" class="sub_btn new-subbtn mt-0">Complete Booking</a>
                                            <input type="submit" id="payBtn" value="Complete Booking"
                                                class="sub_btn new-subbtn mt-0" style="display:none;">



                                        </div>
                                        <div class="btn_3_cc forr_btnn66">

                                            <a class="sub_btn new-subbtn"
                                                onclick="return confirm('Are you sure want to cancel ?')"
                                                id="cancelBookingL"
                                                href="{{ route('cancel.booking.incomplete', $bookingDataInformation->id) }}">Cancel
                                                Booking</a>



                                        </div>

                                    </div>

                                </form> --}}

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
    <div class="modal res-modal newqusmo paymentpopupSize" id="beforeconfirmPayment">
        <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Redirecting to Secure Payment</h4>
                    <button type="button" class="close" id="closeThis" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class=" proDiv" id="warningTextDi">
                            {{-- <span class="proclosespan">Confirm Booking</span> --}}
                            <h6></h6>
                            <p>You will now be redirected to our trusted external payment gateway to complete your booking. Your session details are saved, and you’ll be returned here automatically after payment. Please don’t close this window during checkout.</p>
                            {{-- <p class="tutoracademiccor academic_team_bold">Academics Team</p> --}}
                            <div class="next-btn1 newst_btn-pop gj_beforeconfirmPayment_but">
                                <button type="button" class="btn btn-new btn-danger " id="payNowBtnConfirm">Continue to Payment </button>
                                 
                                <button type="button" data-dismiss="modal"
                                    class="btn btn-new btn-danger float-left change-new-link"
                                    id="nextValueShow">Cancel</button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal res-modal newqusmo paymentpopupSize" id="confirmPayment">
        <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Payment Confirmation</h4>
                    <button type="button" class="close" id="closeThis" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class=" proDiv" id="warningTextDi">
                            <span class="proclosespan">Confirm Booking</span>
                            <h6></h6>
                            <p>You will be charged
                                ${{ @$bookingDataInformation->booking_amount + @$bookingDataInformation->stripe_charge }}
                                towards the booking. Please click Confirm to complete the transaction.</p>
                            {{--
                  <p class="tutoracademiccor academic_team_bold">Academics Team</p>
                  --}}
                            <div class="next-btn1 newst_btn-pop">
                                <button type="button" data-dismiss="modal"
                                    class="btn btn-new btn-danger float-left change-new-link"
                                    id="nextValueShow">Cancel</button>
                                <button type="button" class="btn btn-new btn-danger " id="confirmPaymentClick"
                                    onclick="paySubmit();">Confirm </button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal res-modal newqusmo studentUpdatePopupModal" id="waitFor">
        <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Please wait</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class=" proDiv" id="warningTextDi">
                            <span class="proclosespan">Please wait for the page to load</span>
                            <h6></h6>
                            <div class="next-btn1 newst_btn-pop">

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

   

    <script type="text/javascript">
        function fun() {

            var name_of_card = $.trim($("#name_of_card").val()),
                cardnumber = $.trim($("#card-number").val()),
                cvvNumber = $.trim($("#cvvNumber").val());
            if (name_of_card != "" && cardnumber != "" && cvvNumber != "" && cardnumber.length == 16) {
                $('.error_name_of_card').html("");
                $('.error_card_no').html("");
                $('.error_cvvNumber').html("");
                $("#openPopup").trigger("click");
            } else {

                if (name_of_card == "") {
                    $('.error_name_of_card').html("Please provide name on card!");
                }
                if (cardnumber == "" || cardnumber.length != 16) {
                    $('.error_card_no').html("Please provide valid card number!");
                }
                if (cvvNumber == "") {
                    $('.error_cvvNumber').html("Please provide 3 digit cvv number!");
                }
            }
        }

        function paySubmit() {

            $("#payment-form").submit();
        }

        function validate(evt)

        {

            var theEvent = evt || window.event;

            // Handle key press

            var key = theEvent.keyCode || theEvent.which;

            key = String.fromCharCode(key);

            var regex = /[0-9]/;

            if (!regex.test(key)) {

                theEvent.returnValue = false;

                if (theEvent.preventDefault) theEvent.preventDefault();

            }

        }

        $(function() {

            var $form = $(".require-validation");



            $('form.require-validation').bind('submit', function(e) {

                var $form = $(".require-validation"),

                    inputSelector = ['input[type=email]', 'input[type=number]',

                        'input[type=text]', 'input[type=file]', 'select',

                        'textarea'
                    ].join(', '),

                    $inputs = $form.find('.required').find(inputSelector),

                    $errorMessage = $form.find('.error'),

                    valid = true;

                $errorMessage.html('');

                // $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');

                $inputs.each(function(i, el) {

                    var $input = $(el);

                    console.log($input.val());

                    if ($input.val() === '') {



                        $input.parent().addClass('has-error');

                        // $errorMessage.removeClass('hide');



                        e.preventDefault();

                    }
                    $("#closeThis").trigger("click");
                    $("#openWait").trigger("click");


                });

                // alert($('.card-number').val().length);
                if ($.trim($('#name_of_card').val()) == "") {
                    $('.error_name_of_card').text('Please provide name on card!');
                }
                if ($.trim($('#cvvNumber').val()) == "") {
                    $('.error_cvvNumber').text('Please provide cvv!');
                }
                if ($('.card-number').val().length == 16) {

                    if (!$form.data('cc-on-file')) {

                        e.preventDefault();

                        Stripe.setPublishableKey($form.data('stripe-publishable-key'));

                        Stripe.createToken({

                            number: $('.card-number').val(),

                            cvc: $('.card-cvc').val(),

                            exp_month: $('.card-expiry-month').val(),

                            exp_year: $('.card-expiry-year').val()

                        }, stripeResponseHandler);

                    }

                } else {
                    if ($.trim($('.card-number').val()) == "") {
                        $('.error_card_no').text('Please provide card number!');
                    } else {
                        $('.error_card_no').text('Your card number is incorrect.');

                    }
                    $("#closeThis").trigger("click");
                    // $("#confirmPayment").modal('hide');
                    $('.error').removeClass('hide').find('.alert').text('Your card number is incorrect.');

                    return false;

                }

            });



            function stripeResponseHandler(status, response) {

                if (response.error) {

                    $(".a_error_text").text(response.error.message);
                    // $("#confirmPayment").hide();
                    $("#closeThis").trigger("click");

                } else {

                    // token contains id, last4, and card type

                    var token = response['id'];

                    // insert the token into the form so it gets submitted to the server

                    $form.find('input[type=text]').empty();

                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $("#cancelBookingL").hide();
                    $("#payBtn").hide();
                    $("#confirmPaymentClick").hide();
                    $("#nextValueShow").hide();
                    // $("#confirmPayment").modal('hide');
                    $("#closeThis").trigger("click");
                    $("#openWait").trigger("click");
                    $form.get(0).submit();

                }



                $('.nocopypaste').bind('copy paste', function(e) {

                    e.preventDefault();
                    return false;

                });

                // $("#confirmPaymentClick").on("click",function(){
                //  alert("safkj");
                //  $("#payment-form").submit();
                // });





            }



        });
    </script>

    <script>

// ----------------------------
// APPLY PROMO CODE
// ----------------------------
$(document).on('click', '#apply_promo_code', function () {

    if(!$('#promo_code').val()) {
        $('.prm_err').text('Promo code is required');
        return;
    }

    $('.prm_err').text('');

    var tot = parseFloat($('#bk_tot_rate').val());
    var booking_id = $('#booking_id').val();

    $.ajax({
        type: "POST",
        url: '{{ route('check_promo') }}',
        dataType: 'json',
        data: {
            promo_code: $('#promo_code').val(),
            tot: tot,
            booking_id: booking_id,
            _token: "{{ csrf_token() }}"
        },
        success: function(resp) {

            console.log("Promo Response:", resp);

           if (resp.status == 1) {

    var discountPercent = parseFloat(resp.discount);
    var originalTotal = parseFloat($('#bk_tot_rate').val());

    // --------------------
    // CASE 1: 100% FREE
    // --------------------
    if (discountPercent === 100) {

        $('#discount_val').val(discountPercent);
        $('#discount_code').val($('#promo_code').val());
        $('#net_total').val(0);

        $('.af_prm').text('$0.00');
        $('.bf_prm').css({'text-decoration':'line-through'});
        $('.promo_tr').hide();

       // $('#before_Payment_button').show();   // FREE BOOKING
    //    $('#openPaymentModal').show();
        handleFreeBooking();
        return;
        $('#payNowBtn').hide();

        return;
    }

    // ----------------------------
    // CASE 2: NORMAL DISCOUNT
    // ----------------------------
    if (discountPercent > 0) {

        var discountAmount = originalTotal * (discountPercent / 100);
        var finalAmount = originalTotal - discountAmount;

        $('#discount_val').val(discountPercent);
        $('#discount_code').val($('#promo_code').val());
        $('#net_total').val(finalAmount);

        $('.af_prm').text('$' + finalAmount.toFixed(2));
        $('.bf_prm').css({'text-decoration':'line-through'});
        $('.promo_tr').hide();

        // *** FIXED: show modal for normal payments ***
        //$('#before_Payment_button').show();
        $('#openPaymentModal').show();
        $('#payNowBtn').hide();

        return;
    }
}
            // ERROR CODES
            let msg = '';
            switch(resp.msg_code){
                case 2: msg = 'Promo code is expired'; break;
                case 3: msg = 'Promo code is invalid'; break;
                case 4: msg = 'Promo code is required'; break;
                case 5: msg = 'Error occurred, something went wrong'; break;
                case 6: msg = 'Something went wrong, please try again'; break;
                case 7: msg = 'Promo code already used with this tutor'; break;
                case 8: msg = 'This tutor is not eligible for promo code'; break;
                default: msg = 'Promo code is invalid';
            }

            $('.prm_err').text(msg);
           // $('#openPaymentModal').show();
            $('#payNowBtn').show();
            //$('#before_Payment_button').hide();
        }
    });
});


// ----------------------------
// CONTINUE TO PAYMENT
// ----------------------------
// $(document).on('click', '#payNowBtnConfirm', function () {
//     $('#payNowBtn').trigger('click');
// });

// ----------------------------
// FREE BOOKING (100% PROMO)
// ----------------------------
// $(document).on('click', '#before_Payment_button', function () {

//     var bookingId = $('#booking_id').val();
//     var promo = $('#discount_code').val();

//     $.post("{{ route('free.booking') }}", {
//         booking_id: bookingId,
//         promo_code: promo,
//         _token: "{{ csrf_token() }}"
//     }, function(resp){
//         if(resp.redirect){
//             window.location.href = resp.redirect;
//         }
//     });
// });
$(document).ready(function () {

    function handleFreeBooking() {
    var bookingId = $('#booking_id').val();
    var promo = $('#discount_code').val();

    $.post("{{ route('free.booking') }}", {
        booking_id: bookingId,
        promo_code: promo,
        _token: "{{ csrf_token() }}"
    }, function(resp){
        if(resp.redirect){
            window.location.href = resp.redirect;
        }
    });
}
});
</script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ config('services.stripe.stripe-publishable') }}");

$(document).on('click', '#payNowBtnConfirm', function () {

    $('#payNowBtnConfirm').prop('disabled', true).text('Processing...');

    $('#paymentLoader').show();


    var amt = '{{ (int) round(@$tot * 100) }}';

    if($('#net_total').val() && $('#net_total').val() > 0) {
        amt = $('#net_total').val() * 100;
    }

    amt = parseInt(amt);

    fetch("{{ route('stripe.create.session') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            email: "{{ @$bookingDataInformation->getStudent->email }}",
            orderId: "{{ @$bookingDataInformation->id }}",
            order_no: "{{ @$bookingDataInformation->booking_no }}",
            amount: amt,
            currency: "aud",
            metadata: {
                order_id: "{{ @$bookingDataInformation->id }}",
                order_no: "{{ @$bookingDataInformation->booking_no }}"
            }
        })
    })
    .then(res => res.json())
    .then(data => {
        stripe.redirectToCheckout({
            sessionId: data.id
        });
    })
    .catch(err => {
        console.error("Checkout redirect error:", err);

        $('#payNowBtnConfirm').prop('disabled', false).text('Continue to Payment');
        $('#paymentLoader').hide();
    });
});
</script>
@endsection

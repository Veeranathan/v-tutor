@extends('layouts.app')



@section('title')
    <title>V-Tutor | tutor | View Details | {{ @$bookingDataInformation->booking_no }}</title>
@endsection



@section('left_part')
    @include('include.header_menu_part')

    <style type="text/css">
        .overflowtext {
            overflow-wrap: break-word;
        }

        .breaktext {
            word-break: break-all;
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



                            @include('include.teacher_left_common'){{-- left common part --}}



                            <div class="user-right-panel ">



                                <div class="user-right-top-new ">

                                    @include('include.errors')

                                    <h2 class="profile-heading">Session Details <a href="{{ url()->previous() }}"
                                            {{-- <h2 class="profile-heading">Session Details <a href="{{ route('tutor.myclass') }}" --}} class="pg_btn gj_back_div">Back</a></h2>



                                    <p class="gj_sub_hd">You can find details of the session in this section</p>



                                </div>



                                <div class="class-feild mt-4">



                                    <div class="row">
                                        <div class="col-12">
                                            <div class="tuto-rating">
                                                <em>
                                                    @if (@$bookingDataInformation->getStudent->profile_pic)
                                                        @php
                                                            $localImagePath = public_path(
                                                                'assets/images/all_avatars/' .
                                                                    @$bookingDataInformation->getStudent->profile_pic,
                                                            );
                                                            $imageExists = file_exists($localImagePath);
                                                        @endphp
                                                        @if ($imageExists)
                                                            <img src="{{ public_asset('assets/images/all_avatars/' . @$bookingDataInformation->getStudent->profile_pic) }}"
                                                                alt="profile_img">
                                                        @else
                                                            <img src="{{ env('STORAGE_URL') . '/teacher_profile_pic/' . @$bookingDataInformation->getStudent->profile_pic }}"
                                                                alt="">
                                                        @endif
                                                        {{-- <img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$bookingDataInformation->getStudent->profile_pic}}" alt="" id="img2"> --}}
                                                    @else
                                                        @if (@$bookingDataInformation->getStudent->avatar)
                                                            <img src="{{ @$bookingDataInformation->getStudent->avatar }}"
                                                                alt="" id="img2">
                                                        @else
                                                            <img src="{{ public_asset('assets/images/user-pro.png') }}"
                                                                alt="" id="img2">
                                                        @endif
                                                    @endif
                                                </em>
                                                <div class="tu-info">
                                                    <h2>{{ @$bookingDataInformation->getStudent->f_name }}
                                                        {{ @$bookingDataInformation->getStudent->l_name }}</h2>
                                                    <div class="sed">
                                                        <span><img src="{{ public_asset('assets/images/map.png') }}">
                                                           
                                                            {{ @$bookingDataInformation->getStudent->getState->state_name }}</span>
                                                        <ul class="profile-rating m-0">










                                                        </ul>



                                                    </div>



                                                    <div class="sed ">







                                                    </div>



                                                    <div class="sed grade_sed">



                                                        <span><img src="{{ public_asset('assets/images/gra.png') }}">
                                                            {{ @$bookingDataInformation->getStudentGrade->grade_name }}</span>



                                                        <span>



                                                            <img src="{{ public_asset('assets/images/world.png') }}">
                                                          
                                                            {{ @$bookingDataInformation->getStudent->getSchool->getState->state_name }}
                                                           
                                                            









                                                        </span>



                                                    </div>







                                                </div>



                                            </div>



                                        </div>



                                    </div>



                                </div>







                                <div class="user-right-top-new marb90 text-center">



                                    {{-- <img src="{{ public_asset('assets/images/confr.png') }}"> --}}



                                    {{-- <h2 class="profile-headingnew">Session Details </h2> --}}



                                    {{-- <p> Please find details of the session below</p> --}}
                                    {{-- <div class="backBtnCls"><a href="{{url()->previous()}}" class="pg_btn">Back</a></div> --}}
                                    {{-- <div class="backBtnCls"><a href="{{ route('tutor.myclass') }}" class="pg_btn">Back</a></div> --}}






                                    <!-- <div class="booking-stat">



                                                    <span>Booking Number: <p> {{ @$bookingDataInformation->booking_no }} </p></span>



                                                    <span>Subject: <p> {{ @$bookingDataInformation->getSubject->subject }} </p></span>



                                                    <span>Date: <p> {{ date('d-m-Y', strtotime(@$bookingDataInformation->booking_date)) }} </p></span>



                                                    <span>Time: <p> {{ date('h:i a', strtotime(@$bookingDataInformation->from_time_user)) }} to {{ date('h:i a', strtotime(@$bookingDataInformation->to_time_user)) }} </p></span>



                                                </div> -->

                                    <div class="booking-stat table_book">

                                        <div class="table-responsive">

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Booking No</th>
                                                        <th>Academic Program</th>
                                                        <th>Subject</th>
                                                        <th class="view_details_date">Date</th>
                                                        <th class="view_details_time">Time</th>
                                                        <th class="widt-16">Session Rate </th>
                                                        {{-- <th>Amount</th> --}}
                                                        <th>Status</th>
                                                        <th class="view_details_ses">Session</th>
                                                        @if (@$bookingDataInformation->status != 'C')
                                                            {{-- <th>Start Class</th> --}}
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tr>
                                                    <td>{{ @$bookingDataInformation->booking_no }}</td>
                                                    <td>@if($bookingDataInformation->is_academic_program == 1 
                                                            && $bookingDataInformation->academicProgramPurchase 
                                                            && $bookingDataInformation->academicProgramPurchase->academicProgram)
                                                
                                                                {{ $bookingDataInformation->academicProgramPurchase->academicProgram->name }}
                                                            @else
                                                                No
                                                        @endif
                                                    </td>
                                                    <td>@if($bookingDataInformation->is_academic_program == 1 
                                                            && $bookingDataInformation->academicProgramPurchase 
                                                            && $bookingDataInformation->academicProgramPurchase->academicProgram)
                                                                {{ $bookingDataInformation->academicProgramPurchase->academicProgram->branch->branch_name ?? 'N/A' }}
                                                        @else
                                                            {{ @$bookingDataInformation->getSubject->subject }}
                                                        @endif
                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime(@$bookingDataInformation->booking_date_user)) }}
                                                    </td>
                                                    <td>{{ date('h:i a', strtotime(@$bookingDataInformation->from_time_user)) }}
                                                        to
                                                        {{ date('h:i a', strtotime(@$bookingDataInformation->to_time_user)) }}
                                                    </td>
                                                    <td class="widt-16">
                                                        @if($bookingDataInformation->is_academic_program == 1)
                                                            -
                                                        @else
                                                            ${{ @$bookingDataInformation->hourly_rate }}
                                                        @endif
                                                    </td>
                                                    {{-- <td>
                                                ${{ @$bookingDataInformation->tutor_earnings }}
                                                @if (@$bookingDataInformation->booking_status == 'C')
                                                    (Refunded
                                                    ${{ number_format(@$bookingDataInformation->getPaymentsInfo->refund_amount, 2) }})
                                                @endif
                                            </td> --}}
                                                    <td>
                                                        @if (@$bookingDataInformation->booking_status == 'IC')
                                                            Incomplete
                                                        @elseif(@$bookingDataInformation->booking_status == 'B')
                                                            Booked
                                                        @elseif(@$bookingDataInformation->booking_status == 'CM')
                                                            @if (@$bookingDataInformation->booking_status == 'CM' && @$bookingDataInformation->class_assessment_student == 'N')
                                                                <a class="red_link"
                                                                    href="{{ route('tutor.class.end.assesment', $bookingDataInformation->booking_no) }}">Review</a>
                                                            @else
                                                                Completed
                                                            @endif
                                                        @elseif(@$bookingDataInformation->booking_status == 'C')
                                                            Cancelled
                                                        @elseif(@$bookingDataInformation->booking_status == 'F')
                                                            Failed
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (@$bookingDataInformation->booking_status == 'C')
                                                            <li class="pointerEventsNone addDisablePhone">
                                                                <a target="_blank" href="#" class="">
                                                                    {{-- {{ route('class.session.link',@$val->id) }} --}}
                                                                    Click to join
                                                                </a>

                                                            </li>
                                                        @else
                                                            <li>
                                                                <a target="_blank"
                                                                    href="{{ route('tutor.class.session.link', ['userid' => Auth()->user()->unique_id, 'id' => @$bookingDataInformation->booking_no]) }}">
                                                                    {{-- {{ route('tutor.class.session.link',@$bookingDataInformation->id) }} --}}
                                                                    Click to join
                                                                </a>

                                                            </li>
                                                        @endif
                                                        {{-- @if (@$bookingDataInformation->booking_status == 'B' && @$bookingDataInformation->from_time <= date('H:i:s') && @$bookingDataInformation->to_time >= date('H:i:s'))
                                                    <li>
                                                        <a target="_blank"
                                                            href="{{ route('tutor.class.session.link', ['userid' => Auth()->user()->unique_id, 'id' => @$bookingDataInformation->booking_no]) }}">

                                                            Click to join
                                                        </a>

                                                    </li>
                                                @elseif(
                                                    @$bookingDataInformation->booking_status == 'B' &&
                                                        @$bookingDataInformation->from_time <= date('H:i:s', strtotime('+5 minutes')) &&
                                                        @$bookingDataInformation->to_time >= date('H:i:s'))
                                                    <li>
                                                        <a target="_blank"
                                                            href="{{ route('tutor.class.session.link', ['userid' => Auth()->user()->unique_id, 'id' => @$bookingDataInformation->booking_no]) }}">

                                                            Click to join
                                                        </a>

                                                    </li>
                                                @elseif(@$bookingDataInformation->booking_status == 'B' && @$bookingDataInformation->to_time >= date('H:i:s'))
                                                    <li>
                                                        <a data-toggle="modal" data-target="#sessionLink"
                                                            href="javascript:void(0);">

                                                            Click to join
                                                        </a>

                                                    </li>
                                                @endif --}}
                                                        {{-- <a href="{{ route('tutor.class.session.link',@$bookingDataInformation->id) }}">{{ route('tutor.class.session.link',@$bookingDataInformation->id) }}</a> --}}
                                                    </td>
                                                    @if (@$bookingDataInformation->status != 'C')
                                                        -
                                                        {{-- <td class="overflowtext breaktext">{{ @$bookingDataInformation->start_url }}</td> --}}
                                                    @endif
                                                </tr>
                                            </table>
                                            <div class="session-info"
                                                style="margin-top: 30px; padding: 20px; background-color: #f9f9f9; border-radius: 8px;">
                                                <h4>Session Plan</h4>

                                                <p><strong>1. Grade:</strong>
                                                    @if($bookingDataInformation->is_academic_program == 1 
                                                        && $bookingDataInformation->academicProgramPurchase 
                                                        && $bookingDataInformation->academicProgramPurchase->academicProgram)

                                                            {{ $bookingDataInformation->academicProgramPurchase->academicProgram->grade->grade_name ?? 'N/A' }}

                                                    @else
                                                            {{ $bookingDataInformation->getStudentGrade->grade_name ?? 'N/A' }}
                                                    @endif
                                                </p>
                                                <p><strong>2. Subject:</strong>
                                                    @if($bookingDataInformation->is_academic_program == 1 
                                                        && $bookingDataInformation->academicProgramPurchase 
                                                        && $bookingDataInformation->academicProgramPurchase->academicProgram)

                                                            {{ $bookingDataInformation->academicProgramPurchase->academicProgram->branch->branch_name ?? 'N/A' }}

                                                    @else
                                                        {{ $bookingDataInformation->getSubject->subject ?? 'N/A' }}
                                                    @endif
                                                </p>

                                                <p><strong>3. Session Topic:</strong>
                                                    {{ $bookingDataInformation->getSubjectTopics->topics ?? 'N/A' }}</p>

                                                <p><strong>4. Session Focus:</strong>
                                                    @if (isset($bookingDataInformation->getTopicDetails->topic_det_code) &&
                                                            $bookingDataInformation->getTopicDetails->topic_det_code)
                                                        @if (isset($bookingDataInformation->getTopicDetails->session_focus) &&
                                                                $bookingDataInformation->getTopicDetails->session_focus)
                                                            {{ $bookingDataInformation->getTopicDetails->topic_det_code ?? '' }}
                                                            -
                                                            {{ $bookingDataInformation->getTopicDetails->session_focus ?? '' }}
                                                        @else
                                                            {{ $bookingDataInformation->getTopicDetails->topic_det_code ?? 'N/A' }}
                                                        @endif
                                                    @else
                                                        {{ $bookingDataInformation->getTopicDetails->session_focus ?? 'N/A' }}
                                                    @endif
                                                </p>

                                                <p><strong>5. Session Outcome:</strong>
                                                    {{ $bookingDataInformation->getTopicDetails->learning_outcome ?? 'N/A' }}
                                                </p>

                                                <p><strong>6. Description & Problems Faced:</strong>
                                                    {{ $bookingDataInformation->problem_areas ?? 'N/A' }}</p>

                                                {{-- <p><strong>1. Subject Area (ID):</strong> {{ $bookingDataInformation->getSubjectTopics->topics ?? 'N/A' }}</p>
                                    <p><strong>2. Session Topic:</strong> {{ $bookingDataInformation->session_topic ?? 'N/A' }}</p>
                                    <p><strong>3. Description & Problems Faced:</strong> {{ $bookingDataInformation->problem_areas ?? 'N/A' }}</p> --}}

                                            </div>

                                            <div class="session-info gj_session_fb_sec text-center"
                                                style="margin-top: 30px; padding: 20px; background-color: #f9f9f9; border-radius: 8px;">
                                                <h4>Session Feedback</h4>

                                                @if (isset($bookingDataInformation->session_summary) && $bookingDataInformation->session_summary)
                                                    <p>
                                                        <strong>Performance Grade:</strong>
                                                        @if (isset($bookingDataInformation->permission_grade) && $bookingDataInformation->permission_grade == 1)
                                                            {{ '1 - Beginning' }}
                                                        @elseif (isset($bookingDataInformation->permission_grade) && $bookingDataInformation->permission_grade == 2)
                                                            {{ '2 - Developing' }}
                                                        @elseif (isset($bookingDataInformation->permission_grade) && $bookingDataInformation->permission_grade == 3)
                                                            {{ '3 - Proficient' }}
                                                        @elseif (isset($bookingDataInformation->permission_grade) && $bookingDataInformation->permission_grade == 4)
                                                            {{ '4 - Strong' }}
                                                        @elseif (isset($bookingDataInformation->permission_grade) && $bookingDataInformation->permission_grade == 5)
                                                            {{ '5 - Mastery' }}
                                                        @else
                                                            {{ 'N/A' }}
                                                        @endif
                                                    </p>

                                                    <p class="gj_ses_fb_p"><strong>Session Feedback:</strong></p>
                                                    <div class="gj_ses_fb_div">{!! nl2br($bookingDataInformation->session_summary) !!}</div>

                                                    <p class="gj_ses_fb_p"><strong>Session Recommendations:</strong></p>
                                                    <div class="gj_ses_fb_div">{!! nl2br($bookingDataInformation->session_recommendations) !!}</div>
                                                @else
                                                    <form action="{{ route('teacher_session_feedback_save') }}"
                                                        method="post" id="teacher_session_feedback_save">
                                                        @csrf

                                                        <div class="gj_per_gde_div">
                                                            <div class="gj_per_gde_div1">
                                                                <p><strong>Performance Grade:</strong></p>
                                                                <select name="permission_grade" id="permission_grade"
                                                                    class="form-control">
                                                                    <option value="">Select Grade</option>
                                                                    <option
                                                                        {{ old('permission_grade') == 1 ? 'selected' : '' }}
                                                                        data-def="Student struggles; requires constant support."
                                                                        value="1">1 - Beginning</option>
                                                                    <option
                                                                        {{ old('permission_grade') == 2 ? 'selected' : '' }}
                                                                        data-def="Student attempts but needs frequent help."
                                                                        value="2">2 - Developing</option>
                                                                    <option
                                                                        {{ old('permission_grade') == 3 ? 'selected' : '' }}
                                                                        data-def="Student demonstrates expected skill with some support."
                                                                        value="3">3 - Proficient</option>
                                                                    <option
                                                                        {{ old('permission_grade') == 4 ? 'selected' : '' }}
                                                                        data-def="Student works independently with few errors."
                                                                        value="4">4 - Strong</option>
                                                                    <option
                                                                        {{ old('permission_grade') == 5 ? 'selected' : '' }}
                                                                        data-def="Student consistently exceeds expectations."
                                                                        value="5">5 - Mastery</option>
                                                                </select>
                                                            </div>

                                                            <div class="gj_per_gde_div2">
                                                                <p><strong></strong></p>
                                                                <input type="text" readonly name="permission_grade_def"
                                                                    id="permission_grade_def" value=""
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        {{-- @error('permission_grade')
                                                <p class="text-danger gj_ses_fb_err permission_grade_err">{{ $message }}</p>
                                            @enderror --}}

                                                        <p><strong>Session Feedback:</strong></p>
                                                        <textarea name="session_summary" rows="5" id="session_summary" class="form-control" placeholder="Feedback">{{ old('session_summary') }}</textarea>

                                                        <p><strong>Session Recommendations:</strong></p>
                                                        <textarea name="session_recommendations" rows="5" id="session_recommendations" class="form-control"
                                                            placeholder="Recommendations">{{ old('session_recommendations') }}</textarea>
                                                        {{-- @error('session_recommendations')
                                                <p class="text-danger gj_ses_fb_err session_recommendations_err">{{ $message }}</p>
                                            @enderror --}}

                                                        <input type="hidden" name="booking_id"
                                                            value="{{ $bookingDataInformation->id ?? '' }}"
                                                            id="booking_id">
                                                        {{-- @error('booking_id')
                                                <p class="text-danger gj_ses_fb_err booking_id_err">{{ $message }}</p>
                                            @enderror --}}

                                                        <button type="submit" id="gj_ses_fb_sub_but"
                                                            class="btn gj_ses_fb_sub_but">Submit</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <div class="table-responsive">
                                                @if (@$bookingDataInformation->booking_status == 'C')
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
                                                            <td>
                                                                @if (@$bookingDataInformation->getPaymentsInfo->refund_id)
                                                                    {{ @$bookingDataInformation->getPaymentsInfo->refund_id }}
                                                                @else
                                                                    No refund
                                                                @endif
                                                            </td>
                                                            <td>${{ number_format(@$bookingDataInformation->getPaymentsInfo->refund_amount, 2) }}
                                                            </td>
                                                            <td>
                                                                @if (@$bookingDataInformation->cancelled_by == 'S')
                                                                    {{ @$bookingDataInformation->getStudent->parent_f_name }}
                                                                    {{ @$bookingDataInformation->getStudent->parent_l_name }}
                                                                @elseif(@$bookingDataInformation->cancelled_by == 'T')
                                                                    {{ @$bookingDataInformation->getTutor->f_name }}
                                                                    {{ @$bookingDataInformation->getTutor->l_name }}
                                                                @elseif(@$bookingDataInformation->cancelled_by == 'A')
                                                                    Admin
                                                                @endif
                                                            </td>
                                                            <td>{{ @$bookingDataInformation->cancelled_on }}</td>
                                                            <td>
                                                                @if (@$bookingDataInformation->getPaymentsInfo->refund_type == '100')
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
                                                                {{-- @if (@$bookingDataInformation->getPaymentsInfo->refund_id)
                                                    @php
                                                      $paidVia = json_decode(@$bookingDataInformation->getPaymentsInfo->refund_response);
                                                      @endphp
                                                      {{strtoupper(@$paidVia->status)}}
                                                    @else
                                                    No refund
                                                    @endif --}}
                                                                {{-- @if (@$bookingDataInformation->getPaymentsInfo->refund_amount <= 0)
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
                                            <a data-toggle="modal" data-target="#cancelPopup" href="#"
                                                class="sub_btn new-subbtn">Cancel Booking</a>
                                            @if (Auth()->user()->user_type != 'T')
                                                <div class="btn_3_cc">

                                                    @if (@$bookingDataInformation->booking_status == 'B')
                                                        @if (@$bookingDataInformation->booking_status == 'B')
                                                            @if (@$bookingDataInformation->booking_date == date('Y-m-d') && @$bookingDataInformation->to_time > date('H:i:s'))
                                                                <a data-toggle="modal" data-target="#cancelPopup"
                                                                    href="#" class="sub_btn new-subbtn">Cancel
                                                                    Booking</a>
                                                            @else
                                                                <a data-toggle="modal" data-target="#cancelPopup"
                                                                    href="#" class="sub_btn new-subbtn">Cancel
                                                                    Booking</a>
                                                            @endif
                                                        @endif
                                                        {{-- @if (@$bookingDataInformation->booking_date == date('Y-m-d') && @$bookingDataInformation->from_time < date('H:i:s')) --}}
                                                        {{-- sus_bg --}}
                                                        {{-- <a class="sub_btn new-subbtn " data-toggle="modal" data-target="#exampleModal">Proceed to pay</a> --}}
                                                        {{-- <a onclick="return confirm('Are you sure want to cancel ?')" href="{{ route('teacher.cancel.class.booking',@$bookingDataInformation->booking_no) }}" class="sub_btn new-subbtn">Cancel Booking</a> --}}
                                                        {{-- @else --}}
                                                        {{-- <a onclick="return confirm('Are you sure want to cancel ?')" href="{{ route('teacher.cancel.class.booking',@$bookingDataInformation->booking_no) }}" class="sub_btn new-subbtn">Cancel Booking</a> --}}
                                                        {{-- @endif --}}
                                                    @endif
                                                </div>
                                            @endif

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

                            <a href="{{ url()->previous() }}" id="cancel_session_link" class="btn btn-new btn-danger float-left change-new-link"></a>


                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
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
                                <a href="{{ route('teacher.cancel.class.booking', @$bookingDataInformation->booking_no) }}"
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
@endsection
@section('script')
    @include('include.script')

    <script>
        $(document).on('change', '#permission_grade', function(e) {
            e.preventDefault();

            var def = $('#permission_grade option:selected').data('def') || '';
            $('#permission_grade_def').val(def);
        });
    </script>
@endsection

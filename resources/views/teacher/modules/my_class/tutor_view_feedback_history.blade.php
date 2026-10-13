@extends('layouts.app')

@section('title')
    <title>V-Tutor | tutor | View Feedback History | {{ @$scb->booking_no }}</title>
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
    <div class="top_mar"></div>

    <section class="user-account">



        <div class="container">



            <div class="row">



                <div class="zin">



                    @include('include.teacher_left_common'){{-- left common part --}}



                    <div class="user-right-panel ">



                        <div class="user-right-top-new">
                            @include('include.errors')
<div class="row">
                            <h2 class="profile-heading">Student Feedback History</h2>
                            <p class="gj_sub_hd">You can review the student feedback history in this section.</p>
    </div>
                        </div>

                        <div class="class-feild mt-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="tuto-rating">
                                        <em>
                                            @if (@$scb->getStudent->profile_pic)
                                                @php
                                                    $image_path =
                                                        'assets/images/all_avatars/' .
                                                        @$scb->getStudent->profile_pic;
                                                @endphp
                                                @if (file_exists(@$image_path))
                                                    <img src="{{ public_asset('assets/images/all_avatars/' . @$scb->getStudent->profile_pic) }}"
                                                        alt="profile_img">
                                                @else
                                                    <img src="{{ env('STORAGE_URL') . '/teacher_profile_pic/' . @$scb->getStudent->profile_pic }}"
                                                        alt="">
                                                @endif
                                                {{-- <img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$scb->getStudent->profile_pic}}" alt="" id="img2"> --}}
                                            @else
                                                @if (@$scb->getStudent->avatar)
                                                    <img src="{{ @$scb->getStudent->avatar }}"
                                                        alt="" id="img2">
                                                @else
                                                    <img src="{{ public_asset('assets/images/user-pro.png') }}"
                                                        alt="" id="img2">
                                                @endif
                                            @endif
                                        </em>
                                        <div class="tu-info">
                                            <h2>{{ @$scb->getStudent->f_name }}
                                                {{ @$scb->getStudent->l_name }}</h2>
                                            <div class="sed">
                                                <span><img src="{{ public_asset('assets/images/map.png') }}">
                                                    {{ @$scb->getStudent->city }},
                                                    {{ @$scb->getStudent->getState->state_name }}</span>
                                                <ul class="profile-rating m-0">
                                                </ul>
                                            </div>



                                            <div class="sed ">

                                            </div>



                                            <div class="sed grade_sed">
                                                <span><img src="{{ public_asset('assets/images/gra.png') }}">
                                                    {{ @$scb->getStudentGrade->grade_name }}</span>

                                                <span><img src="{{ public_asset('assets/images/gra.png') }}">
                                                    {{ @$scb->getSubject->subject }}</span>

                                                <span>
                                                    <img src="{{ public_asset('assets/images/world.png') }}">
                                                    {{ @$scb->getStudent->getSchool->school_name }},
                                                    {{ @$scb->getStudent->getSchool->getState->state_name }},
                                                    {{ @$scb->getStudent->getSchool->getSuburb->name }},
                                                    {{ @$scb->getStudent->getSchool->postcode }}

                                                </span>
                                            </div>







                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row gj_vw_fb_his_row">
                                <div class="col-md-12 col-12">
                                    <div class="gj_vw_fb_his_resp table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <tbody>
                                                @if (isset($fb_history) && count($fb_history) != 0)
                                                    @foreach ($fb_history as $fbh_k => $fbh_v)
                                                        <tr>
                                                            <td>
                                                                <div class="gj_vw_fb_his_sec">
                                                                    <div class="gj_vw_fb_his_sec_sub">
                                                                        <p class="gj_vw_fb_his_p"><b>Tutor Name: </b> <span>{{ @$fbh_v->getTutor->f_name }} {{ @$fbh_v->getTutor->l_name }}</span></p>

                                                                        <p class="gj_vw_fb_his_p"><b>Session ID: </b> <span>{{ @$fbh_v->booking_no }}</span></p>

                                                                        <p class="gj_vw_fb_his_p"><b>Session Date & Time: </b> <span>{{ date('d-m-Y', strtotime(@$fbh_v->booking_date)) }} {{ date('h:i A', strtotime(@$fbh_v->from_time_user)) }} -
                                                                            {{ date('h:i A', strtotime(@$fbh_v->to_time_user)) }}</span></p>
                                                                    </div>

                                                                    <div class="gj_vw_fb_his_sec_sub">
                                                                    <p class="gj_vw_fb_his_p gj_vw_fb_his_detp"><b>Session Plan - Details: </b> </p>
                                                                        <div class="gj_vw_fb_his_det">
                                                                            <p><strong>1. Grade:</strong>
                                                                                {{ $fbh_v->getStudentGrade->grade_name ?? 'N/A' }}</p>

                                                                            <p><strong>2. Subject Area (ID):</strong>
                                                                                {{ $fbh_v->getSubject->subject ?? 'N/A' }}</p>

                                                                            <p><strong>3. Session Topic:</strong>
                                                                                {{ $fbh_v->getSubjectTopics->topics ?? 'N/A' }}</p>

                                                                            <p><strong>4. Session Focus:</strong>
                                                                                @if (isset($fbh_v->getTopicDetails->topic_det_code) && $fbh_v->getTopicDetails->topic_det_code)
                                                                                    @if (isset($fbh_v->getTopicDetails->session_focus) && $fbh_v->getTopicDetails->session_focus)
                                                                                        {{ $fbh_v->getTopicDetails->topic_det_code ?? '' }} - {{ $fbh_v->getTopicDetails->session_focus ?? '' }}
                                                                                    @else
                                                                                        {{ $fbh_v->getTopicDetails->topic_det_code ?? 'N/A' }}
                                                                                    @endif
                                                                                @else
                                                                                    {{ $fbh_v->getTopicDetails->session_focus ?? 'N/A' }}
                                                                                @endif
                                                                            </p>

                                                                            <p><strong>5. Session Outcome:</strong>
                                                                                {{ $fbh_v->getTopicDetails->learning_outcome ?? 'N/A' }}</p>

                                                                            <p><strong>6. Description & Problems Faced:</strong>
                                                                                {{ $fbh_v->problem_areas ?? 'N/A' }}</p>

                                                                            {{-- <p><strong>1. Subject Area (ID):</strong> {{ $fbh_v->getSubjectTopics->topics ?? 'N/A' }}</p>
                                                                            <p><strong>2. Session Topic:</strong> {{ $fbh_v->session_topic ?? 'N/A' }}</p>
                                                                            <p><strong>3. Description & Problems Faced:</strong> {{ $fbh_v->problem_areas ?? 'N/A' }}</p> --}}
                                                                        </div>
                                                                    </div>

                                                                    <div class="gj_vw_fb_his_sec_sub">
                                                                        <p class="gj_vw_fb_his_p gj_vw_fb_his_detp"><b>Session Feedback - Details: </b></p>
                                                                        <div class="gj_vw_fb_his_det">
                                                                            <p>
                                                                                <strong>Performance Grade:</strong>
                                                                                @if (isset($fbh_v->permission_grade) && $fbh_v->permission_grade == 1)
                                                                                    {{ '1 - Beginning' }}
                                                                                @elseif (isset($fbh_v->permission_grade) && $fbh_v->permission_grade == 2)
                                                                                    {{ '2 - Developing' }}
                                                                                @elseif (isset($fbh_v->permission_grade) && $fbh_v->permission_grade == 3)
                                                                                    {{ '3 - Proficient' }}
                                                                                @elseif (isset($fbh_v->permission_grade) && $fbh_v->permission_grade == 4)
                                                                                    {{ '4 - Strong' }}
                                                                                @elseif (isset($fbh_v->permission_grade) && $fbh_v->permission_grade == 5)
                                                                                    {{ '5 - Mastery' }}
                                                                                @else
                                                                                    {{ 'N/A' }}
                                                                                @endif
                                                                            </p>

                                                                            <p class="gj_ses_fb_p"><strong>Session Feedback:</strong> {{ $fbh_v->session_summary ? '' : 'N/A' }}</p>
                                                                            <div class="gj_ses_fb_div">{!! nl2br($fbh_v->session_summary ?? '') !!}</div>

                                                                            <p class="gj_ses_fb_p"><strong>Session  Recommendations:</strong> {{ $fbh_v->session_recommendations ? '' : 'N/A' }}</p>
                                                                            <div class="gj_ses_fb_div">{!! nl2br($fbh_v->session_recommendations ?? '') !!}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr><td>History not found</td></tr>
                                                @endif
                                            </tbody>
                                        </table>

                                        @if (isset($fb_history) && count($fb_history) != 0)
                                            <div class="d-flex justify-content-center">
                                                {{-- {{ $fb_history->links() }} --}}
                                                <div class="pagi_cc" style="margin-top: -20px;">
                                                    <nav aria-label="...">
                                                        <ul class="pagination">
                                                            @if ($fb_history->hasPages())
                                                                <nav class="flex items-center justify-center space-x-2 my-4 gj_paginate_nav">

                                                                    {{-- Previous Page Link --}}
                                                                    @if ($fb_history->onFirstPage())
                                                                        <span class="px-3 py-1 text-gray-400 border rounded gj_disable_paginate_link">Prev</span>
                                                                    @else
                                                                        <a href="{{ $fb_history->previousPageUrl() }}" 
                                                                        class="px-3 py-1 border rounded hover:bg-gray-200 gj_paginate_link">Prev</a>
                                                                    @endif

                                                                    @php
                                                                        $totalPages = $fb_history->lastPage();
                                                                        $currentPage = $fb_history->currentPage();
                                                                        $window = 1; // number of pages to show on each side of current page
                                                                    @endphp

                                                                    {{-- Next Page Link --}}
                                                                    @if ($fb_history->hasMorePages())
                                                                        <a href="{{ $fb_history->nextPageUrl() }}" 
                                                                        class="px-3 py-1 border rounded hover:bg-gray-200 gj_paginate_link">Next</a>
                                                                    @else
                                                                        <span class="px-3 py-1 text-gray-400 border rounded gj_disable_paginate_link">Next</span>
                                                                    @endif
                                                                </nav>
                                                            @endif
                                                            {{-- {{ $fb_history->links('vendor.pagination.custom_pagination') }} --}}
                                                        </ul>
                                                    </nav>
                                                </div>
                                            </div>
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
                                <a href="{{ url()->previous() }}" id="cancel_session_link"
                                    class="btn btn-new btn-danger float-left change-new-link"></a>


                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
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
                            <p><em>Cancellation of sessions is subject to’ V-Tutor cancellation policy. V-Tutor <a
                                        href="{{ route('help') }}" class="red_link">cancellation policy</a>. Refunds are
                                    subject to conditions. Refer to the policy from the <a href="{{ route('help') }}"
                                        class="red_link">Help section</a> for more details.</em></p>

                            <div class="next-btn1 newst_btn-pop">
                                {{-- {{ route('student.cancel.class.booking',@$val->booking_no) }} --}}
                                <a href="{{ route('teacher.cancel.class.booking', @$scb->booking_no) }}"
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
@endsection

@extends('layouts.app')
@section('title')
<title>V-Tutor  | Student | Book Session</title>
@endsection
@section('left_part')
{{-- @include('include.student_top_common') --}}
@include('include.header_menu_part')
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.914/styles/kendo.default-main.min.css" />
<script src="https://kendo.cdn.telerik.com/2021.3.914/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
<style>
    .jqx-scheduler-appointment-resize-indicator {
    display: none !important;
    }
    /*
    .jqx-scheduler-not-work-time-cell {
    background: #eee0 !important;
    }
    */
    .jqx-scheduler-work-time-cell {
    background: #EEEEEE !important;
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
                @include('include.student_left_common')
                <div class="user-right-panel ">
                    <div class="user-right-top-new ">
                        <h2 class="profile-heading">Book a Session</h2>
                        <p>You can book your session in this section</p>
                        <br>
                        @include('include.errors')
                    </div>
                    @if(@$vtutor)
                    <div class="class-feild">
                        <div class="row">
                            <div class="col-12">
                                <div class="tuto-rating">
                                    <em>
                                    @if(@$vtutor->profile_pic)
                                    @php
                                    $image_path = 'assets/images/all_avatars/'.@$vtutor->profile_pic;
                                    @endphp
                                    @if(file_exists(@$image_path))
                                    <img src="{{ public_asset('assets/images/all_avatars/' . @$vtutor->profile_pic) }}" alt="profile_img">
                                    @else
                                    <img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$vtutor->profile_pic}}" alt="">
                                    @endif
                                    {{-- <img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$vtutor->profile_pic}}" alt="" id="img2"> --}}
                                    @else
                                    @if(@$vtutor->avatar)
                                    <img src="{{@$vtutor->avatar}}" alt="" id="img2">
                                    @else
                                    <img src="{{ public_asset('assets/images/user-pro.png') }}" alt="" id="img2">
                                    @endif
                                    @endif
                                    </em>
                                    <div class="tu-info">
                                        <h2>{{ @$vtutor->f_name }} {{ @$vtutor->l_name }}</h2>
                                        <div class="sed">
                                            <span><img src="{{ public_asset('assets/images/map.png') }}">@if(@$vtutor->getState->state_name)

                                                @if(@$vtutor->getState->state_name == 'New South Wales')
                                                NSW
                                                @elseif(@$vtutor->getState->state_name == 'Victoria')
                                                VIC
                                                @elseif(@$vtutor->getState->state_name == 'Queensland')
                                                QLD
                                                @elseif(@$vtutor->getState->state_name == 'South Australia')
                                                SA
                                                @elseif(@$vtutor->getState->state_name == 'Western Australia')
                                                WA
                                                @elseif(@$vtutor->getState->state_name == 'Tasmania')
                                                TAS
                                                @elseif(@$vtutor->getState->state_name == 'Northern Territory')
                                                NT
                                                   @elseif(@$vtutor->getState->state_name == 'Australian Capital Territory')
                                                ACT
                                                @endif

                                                 </span>
                                            <ul class="profile-rating m-0">
                                                @if($vtutor->avg_review>=0 && $vtutor->avg_review<=0.24)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif

                                                @if($vtutor->avg_review>=0.25 && $vtutor->avg_review<=0.74)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif


                                                @if($vtutor->avg_review>=0.75 && $vtutor->avg_review<=1.24)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif



                                                @if($vtutor->avg_review>=1.25 && $vtutor->avg_review<=1.74)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif



                                                 @if($vtutor->avg_review>=1.75 && $vtutor->avg_review<=2.24)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif




                                                 @if($vtutor->avg_review>=2.25 && $vtutor->avg_review<=2.74)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif




                                                @if($vtutor->avg_review>=2.75 && $vtutor->avg_review<=3.24)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif




                                                @if($vtutor->avg_review>=3.25 && $vtutor->avg_review<=3.74)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif




                                                @if($vtutor->avg_review>=3.75 && $vtutor->avg_review<=4.24)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star1.png')}}" alt=""></a></li>
                                                @endif





                                                  @if($vtutor->avg_review>=4.25 && $vtutor->avg_review<=4.74)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/halfstar.png')}}" alt=""></a></li>
                                                @endif



                                                  @if($vtutor->avg_review>=4.75 && $vtutor->avg_review<=5)
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                <li><a href="#"><img src="{{ public_asset('assets/images/star.png')}}" alt=""></a></li>
                                                @endif
                                                <li>
                                                    <p>{{ @$vtutor->avg_review }} ({{ @$vtutor->total_no_of_reviews }})</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="sed ">
                                        </div>
                                        <div class="sed grade_sed">
                                            <span><img src="{{ public_asset('assets/images/gra.png') }}"> {{ @$grade->grade_name }}</span>
                                            <span>
                                            <img src="{{ public_asset('assets/images/world.png') }}">
                                            @if(@$t_my_av_show)
                                            @foreach(@$t_my_av_show as $key=>$t)
                                            @if(@$key != 0), @endif
                                            @if(@$t->day == 1)
                                            Mon
                                            @elseif(@$t->day == 2)
                                            Tues
                                            @elseif(@$t->day == 3)
                                            Wed
                                            @elseif(@$t->day == 4)
                                            Thur
                                            @elseif(@$t->day == 5)
                                            Fri
                                            @elseif(@$t->day == 6)
                                            Sat
                                            @elseif(@$t->day == 7)
                                            Sun
                                            @endif
                                            {{ date("h:i a", strtotime(@$t->from_time)) }}-{{ date("h:i a", strtotime(@$t->to_time)) }}
                                            @endforeach
                                            @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="user-right-top from_time_div">
                        {{-- student-bookingconfirmation.html --}}
                        <form action="{{ url('booking-class') }}/{{ @$vtutor->id }}/{{ @$vtutor->slug }}" id="bookClass" method="get">
                            @csrf
                            <div class="row new_rows no-gutters">
                                <input type="hidden" name="tutor_id" id="tutor_id" value="{{ @$vtutor->id }}">
                                <div class="col-md-3 col-sm-6 from_time_value book_f_t_v">
                                    <h6>Date</h6>
                                    <input type="hidden" name="selected_booked_from_time" id="selected_booked_from_time" value="">
                                    <input type="hidden" name="selected_booked_to_time" id="selected_booked_to_time" value="">
                                    <input type="hidden" name="selected_booked_date_from_time" id="selected_booked_date_from_time" value="">
                                    <input type="hidden" name="selected_booked_date_to_time" id="selected_booked_date_to_time" value="">
                                    <input id="selected_booked_date" name="selected_booked_date" class="required datepickeropen">
                                    <span id="error_selected_d" class="error_selected_d error" style="color: red"></span>
                                </div>
                                <div class="col-md-3 col-sm-6 from_time_value book_f_t_v">
                                    <h6>From</h6>
                                    <input id="start1" name="from_time" placeholder="Start time"  style="width: 150px;" class="from_time start_end_time timepickeropen required"  value="">
                                    <span id="error_f" class="error_start_end_time" style="color: red"></span>
                                </div>
                                <div class="col-md-3 col-sm-6 from_time_value book_f_t_v">
                                    <h6>To</h6>
                                    <input id="end1" name="to_time" placeholder="End time" style="width: 150px;" class="to_time start_end_time required timepickeropen" value="">
                                    <span id="to_f1" class="error_start_end_time" style="color: red"></span>
                                </div>
                                <div class="col-md-3 col-sm-6 from_select_subject_student_book">
                                    <div class="form_box_area">
                                        <label for="subject">Subject </label>
                                        <select id="subject" name="subject_id" class="required">
                                            <option value="">Select Subject </option>
                                            @if(@$subjects)
                                            @foreach(@$subjects as $subject)
                                            <option value="{{ @$subject->getSubject->id }}" @if(@$book_subject == @$subject->getSubject->slug) selected="" @endif>{{ @$subject->getSubject->subject }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <span id="error_subject" class="error_start_end_time" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_3_cc">
                                @php
                                $myGrade = \App\Models\Grade::where(['id'=>@Auth::user()->grade,'status'=>'A'])->select('id','slug','status')->first();
                                @endphp
                                <a href="{{ url('tutor-search-result?grade='.@$myGrade->slug) }}" class="sub_btn new-subbtn">Search Tutors</a>
                                <input type="button" name="" id="studentBookSubmitBtn" value="Book a Session" class="sub_btn new-subbtn">
                                <a href="{{route('student.my.classes')}}" class="sub_btn new-subbtn">Cancel Booking</a>
                            </div>
                            {{--
                            <div class="" >
                                <hr class="das-hr">
                                <div class="footdashSec">
                                    <input type="submit" name="" value="Book a session " class="sub_btn new-subbtn">
                                </div>
                            </div>
                            --}}
                            <div class="row new_rows no-gutters tranhis">
                                <div class="col-xl-8 col-lg-9 col-md-9 col-sm-10  mx-auto">
                                    {{--
                                    <div class="book-avi float-right">
                                        <ul>
                                            <li>
                                                <p><img src="{{ public_asset('assets/images/avai.png') }}"> Available</p>
                                            </li>
                                            <li>
                                                <p><img src="{{ public_asset('assets/images/block.png') }}">Not Available</p>
                                            </li>
                                            <div class="clearfix"></div>
                                        </ul>
                                    </div>
                                    --}}
                                </div>
                            </div>
                            <div class="row new_rows no-gutters">
                                <div class="col-xl-8 col-lg-9 col-md-9 col-sm-10  mx-auto">
                                    <div class="calen_bx new-das-cale">
                                        <div class="bookdetailsleft">
                                            <div class="calendar">
                                                <div class="calendar__month">
                                                    <div class="cal-month__current float-left"></div>
                                                    <div class="clearfix"></div>
                                                    <div class="">
                                                        <div class="">
                                                            <div class="my-calander">
                                                                <p></p>
                                                                <div class="calander-box">
                                                                    <ul>
                                                                        <li>
                                                                            <em class="c1"></em>
                                                                            <span>Booked</span>
                                                                        </li>
                                                                        <li>
                                                                            <em class="c2"></em>
                                                                            <span>Available</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div id="scheduler">
                                                            </div>
                                                            {{-- <input type="hidden" name="selected_booked_date" id="selected_booked_date" value="">
                                                            <input type="hidden" name="selected_booked_from_time" id="selected_booked_from_time" value="">
                                                            <input type="hidden" name="selected_booked_to_time" id="selected_booked_to_time" value="">
                                                            <input type="hidden" name="selected_booked_date_from_time" id="selected_booked_date_from_time" value="">
                                                            <input type="hidden" name="selected_booked_date_to_time" id="selected_booked_date_to_time" value=""> --}}
                                                            <div class="error not_available_date"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--
                            <div class="" >
                                <hr class="das-hr">
                                <div class="footdashSec">
                                    <input type="submit" name="" value="Book a session " class="sub_btn new-subbtn">
                                </div>
                            </div>
                            --}}
                        </form>
                    </div>
                    <div class="class-feild mt-3">
                        <form action="{{ route('student.book.class') }}" method="get" id="searchtutor">
                            <div class="row new_rows no-gutters">
                                <div class="col-md-5 col-sm-6">
                                    <div class="form_box_area">
                                        <label>Find V-Tutor</label>
                                        <div class="autocomplete">
                                            <input id="search_tutor_nm_studentclass" class="required" name="search_tutor_nm_studentclass" type="text" placeholder="Type tutor name" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" autocomplete="off" @if(@$vtutor->f_name) value="{{@$vtutor->f_name." ".@$vtutor->l_name}}" @else value="" @endif>
                                            <input type="hidden" name="search_tutor_id_studentclass" id="search_tutor_id_studentclass" value="{{ @$vtutor->id }}">
                                            <input type="hidden" name="search_tutor_selected_name_studentclass"  id="search_tutor_selected_name_studentclass" value="{{ @$vtutor->f_name." ".@$vtutor->l_name }} ">
                                            <input type="hidden" name="search_tutor_slug_studentclass"  id="search_tutor_slug_studentclass" value="{{ @$vtutor->slug }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button class="dash-btn"> <img src="{{ public_asset('assets/images/ser.png') }}"> Search </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="user-right-top-new ">
                        <div class="account-area-tutor mt-0">
                            @if(@$favs->count() >0)
                            <div class="fav_id" id="fav_id">
                                <div class="owl-carousel">
                                    @if(@$favs)
                                    @foreach(@$favs as $favTutor)
                                    <div class="item">
                                        <div class="meet_tutors_items">
                                            <div class="meet_tutors_img">
                                                <span>
                                                @if(@$favTutor->getTutorInfo->profile_pic)
                                                @php
                                                $image_path = 'assets/images/all_avatars/'.@$favTutor->getTutorInfo->profile_pic;
                                                @endphp
                                                @if(file_exists(@$image_path))
                                                <img src="{{ public_asset('assets/images/all_avatars/' . @$favTutor->getTutorInfo->profile_pic) }}" alt="profile_img">
                                                @else
                                                <img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$favTutor->getTutorInfo->profile_pic}}" alt="">
                                                @endif
                                                {{-- <img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$favTutor->getTutorInfo->profile_pic}}" alt=""> --}}
                                                @else
                                                @if(@$favTutor->avatar)
                                                <img src="{{@$favTutor->getTutorInfo->avatar}}" alt="">
                                                @else
                                                <img src="{{ public_asset('assets/images/searchimg1.jpg') }}" alt="" />
                                                @endif
                                                @endif
                                                {{-- <img src="{{ public_asset('assets/images/meeting5.png') }}" alt="" /> --}}
                                                </span>
                                            </div>
                                            <div class="meet_tutors_text">
                                                <h4> <a href="{{ url('studentbook-class?search_tutor_slug_studentclass='.@$favTutor->getTutorInfo->slug.'&search_tutor_id_studentclass='.@$favTutor->getTutorInfo->id) }}">{{ @$favTutor->getTutorInfo->f_name." ".@$favTutor->getTutorInfo->l_name }}</a></h4>
                                            </div>
                                            <a href="{{ url('studentbook-class?search_tutor_slug_studentclass='.@$favTutor->getTutorInfo->slug.'&search_tutor_id_studentclass='.@$favTutor->getTutorInfo->id) }}" class="postr">Book a session</a>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            @endif
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
@endsection
@section('script')
@include('include.script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
<script src="{{ public_asset('assets/toastr/build/toastr.min.js') }}"></script>
<script src="https://kit.fontawesome.com/446e463225.js" crossorigin="anonymous"></script>
<script src="https://kendo.cdn.telerik.com/2021.3.914/js/kendo.all.min.js"></script>
<script type="text/javascript">
    function checkAvailableDateTime(){
        var get_booking_date = $.trim($("#selected_booked_date").val()),
            from_time = $.trim($("#start1").val()),
            to_time = $.trim($("#end1").val()),
            reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'tutor_id'    : @if(@$vtutor->id){{ @$vtutor->id }} @else 0 @endif,
                    'get_booking_date'    : get_booking_date,
                    'from_time'    : from_time,
                    'to_time'    : to_time
                }
            };
            if(get_booking_date != "" && from_time != "" && to_time != ""){
                $.ajax({
                    url:"{{ route('ajax.check.booking.date') }}",
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success:function(resp){

                        // console.log(resp);
                        if(resp.output == 'false'){

                            $("#start1").val("");
                            $("#end1").val("");
                            $(".error_start_end_time").html("Choose available time slot");
                        }else{
                            $(".error_start_end_time").html("");
                        }
                    }
                });
            }
    }


    function startChange1() {
        var start1 = $("#start1").data("kendoTimePicker");
                var end1 = $("#end1").data("kendoTimePicker");
        var startTime = start1.value();
        var from_time = start1.value();
        if (startTime) {
            startTime = new Date(startTime);
            end1.max(startTime);
            startTime.setMinutes(startTime.getMinutes() + 30);
            end1.min(startTime);
            end1.value(startTime);
            end1.max("8:30 PM");
            //to set the max to_time , min to_time and value after selecting from time
        }
                var booking_date = $.trim($("#selected_booked_date").val()),
                tutor_id = {{ @$vtutor->id?@$vtutor->id:0 }},
                from_time = from_time,
                reqData = {
                    'jsonrpc' : '2.0',
                    '_token'  : '{{csrf_token()}}',
                    'data'    :
                    {
                        'booking_date'    : booking_date,
                        'tutor_id'    : tutor_id,
                        'from_time'    : from_time,
                    }
                };
                var startArr = new Array();
                var endArr = new Array();
                var start1 = $("#start1").data("kendoTimePicker");
                var end1 = $("#end1").data("kendoTimePicker");
                $.ajax({
                    url:"{{ route('ajax.check.time.slot') }}",
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success:function(resp){

                        var startTime = start1.value();
        var from_time = start1.value();
        if (startTime) {
            startTime = new Date(startTime);
            end1.max(startTime);
            startTime.setMinutes(startTime.getMinutes() + 30);
            end1.min(startTime);
            end1.value(startTime);
            end1.max(resp.max_available_end_times);
            //to set the max to_time , min to_time and value after selecting from time
        }
                    }
                });

    }
    function endChange1() {
        var get_booking_date = $.trim($("#selected_booked_date").val()),
        from_time = $.trim($("#start1").val()),
        to_time = $.trim($("#end1").val()),
        reqData = {
            'jsonrpc' : '2.0',
            '_token'  : '{{csrf_token()}}',
            'data'    : {
                'tutor_id'    : @if(@$vtutor->id){{ @$vtutor->id }} @else 0 @endif,
                'get_booking_date'    : get_booking_date,
                'from_time'    : from_time,
                'to_time'    : to_time
            }
        };
        if(get_booking_date != "" && from_time != "" && to_time != ""){
            $.ajax({
                url:"{{ route('ajax.check.booking.date') }}",
                dataType: 'json',
                data: reqData,
                type: 'post',
                success:function(resp){

                    // console.log(resp);
                    if(resp.output == 'false'){

                        $("#start1").val("");
                        $("#end1").val("");
                        $(".error_start_end_time").html("Choose available time slot");
                    }else{
                        $(".error_start_end_time").html("");
                    }
                }
            });
        }
    }

    //init start timepicker

    var start1 = $("#start1").kendoTimePicker({
        change: startChange1,
        interval:30,
        min: new Date({{date('Y,m,d')}}, 6, 0, 0),
        max: new Date({{date('Y,m,d')}}, 20, 0, 0)
    }).data("kendoTimePicker");
    //init end timepicker

    var end1 = $("#end1").kendoTimePicker({
        change: endChange1,
        interval:30,
        min: new Date({{date('Y,m,d')}}, 6, 30, 0),
        max: new Date({{date('Y,m,d')}}, 20, 30, 0)
    }).data("kendoTimePicker");

    //define min/max range
    start1.min("6:00 AM");
    start1.max("8:00 PM");
    start1.readonly();
    end1.readonly();
    $(document).on("click",".k-select",function(){
       var obj = $(this).parent().find(".start_end_time");
       var hastimepickeropenClass = obj.hasClass("timepickeropen");

        if(hastimepickeropenClass){
            obj.data("kendoTimePicker").open();
        }else{
            $("#selected_booked_date").data("kendoDatePicker").open();
        }
    });
    $(document).on("click",".start_end_time",function(){

       var id = $(this).attr("id");

       $("#"+id).data("kendoTimePicker").open();

    });
    $(document).on("click","#selected_booked_date",function(){

       var id = $(this).attr("id");

       $("#"+id).data("kendoDatePicker").open();

    });
    $(document).on("click","#selected_booked_date",function(){
       var id = $(this).attr("id");
       $("#"+id).data("kendoDatePicker").open();
    });



    $(document).on("click",".k-select",function(){

       var obj = $(this).parent().find(".start_end_time");

       var id = obj.attr("id");

       $("#"+id).trigger("click");

    });

</script>
{{-- scheduler --}}
<script src="https://jqwidgets.com/public/jqwidgets/jqx-all.js"></script>
<link rel="stylesheet" type="text/css" href="https://jqwidgets.com/public/jqwidgets/styles/jqx.base.css">
<script type="text/javascript">
    $(document).ready(function () {


        $(document).on("change blur","#selected_booked_date",function(){
            $("#error_selected_d").html("");
            // $("#error_f").html("");
            // $("#to_f1").html("");
            // $("#error_subject").html("");
        });
        $(document).on("change","#start1",function(){
            // $("#error_selected_d").html("");
            $("#error_f").html("");
            $("#to_f1").html("");
            // $("#to_f1").html("");
            // $("#error_subject").html("");
        });
        $(document).on("change","#end1",function(){
            // $("#error_selected_d").html("");
            // $("#error_f").html("");
            $("#to_f1").html("");
            // $("#error_subject").html("");
        });
        $(document).on("change","#subject",function(){
            // $("#error_selected_d").html("");
            // $("#error_f").html("");
            // $("#to_f1").html("");
            $("#error_subject").html("");
        });
        $(document).on("click","#studentBookSubmitBtn",function(){


        // $("#studentBookSubmitBtn").click(function(){
            var booking_d = $("#selected_booked_date").val();
            var start1 = $("#start1").val();
            var end1 = $("#end1").val();
            var subject = $("#subject").val();
            if(booking_d == "" || start1 == "" || end1 == "" || subject == ""){
                // alert("inside");
                // $(".not_available_date").html("Please select available booking date!");
                if(booking_d == ""){
                    $("#error_selected_d").html("This field is required!");
                }
                if(start1 == ""){
                    $("#error_f").html("This field is required!");
                }
                if(end1 == ""){
                    $("#to_f1").html("This field is required!");
                }
                if(subject == ""){
                    $("#error_subject").html("This field is required!");
                }
                // $("#error_f").html("This field is required!");
                // $("#to_f1").html("This field is required!");
                // $("#error_subject").html("This field is required!");

                // return false;

            }else{
                // alert("before submit");
                $("#bookClass").submit();
            }
        });
        var d = new Date();

        var n = d.getDay();

        var appointments = new Array();

        /*booked days*/

        @if(@$booked)

        @foreach($booked as $key=> $val)



        var appointmentbooked{{$key}} = {

            id: "idb{{ $key }}",

            description: "",

            location: "",

            subject: " ",

            calendar: "Room 1",



             start: new Date({{(int)($val['year'])}}, {{(int)($val['month'])-1}},{{(int)($val['day'])}} , {{(int)($val['from_hour'])}}, {{(int)($val['from_min'])}}, 0),

            end: new Date({{(int)($val['year'])}}, {{(int)($val['month'])-1}},{{(int)($val['day'])}} , {{(int)($val['to_hour'])}}, {{(int)(@$val['to_min'])}}, 0),

            background:"#b8110b"

        }

        appointments.push(appointmentbooked{{$key}});

        @endforeach

        @endif

        /*available days*/
        @if(@$notbook)
        @foreach(@$notbook as $key=> $val)
        //console.log({{(int)($val['year'])}}, {{(int)($val['month'])}},{{(int)($val['day'])}} , {{(int)($val['from_hour'])}}, {{(int)($val['from_min'])}}, 0);
        var appointmentaval{{$key}} = {
            id: "ida{{ $key }}",
            description: "",
            location: "",
            subject: " ",
            calendar: "Room 1",
            start: new Date({{(int)($val['year'])}}, {{(int)($val['month'])-1}},{{(int)($val['day'])}} , {{(int)($val['from_hour'])}}, {{(int)($val['from_min'])}}, 0),

            end: new Date({{(int)($val['year'])}}, {{(int)($val['month'])-1}},{{(int)($val['day'])}} , {{(int)($val['to_hour'])}}, {{(int)(@$val['to_min'])}}, 0),

            background:"#7db343"
        }
        appointments.push(appointmentaval{{$key}});
        @endforeach
        @endif
        // prepare the data
        var source =
        {
            dataType: "array",
            dataFields: [
                { name: 'id', type: 'string' },
                { name: 'description', type: 'string' },
                { name: 'location', type: 'string' },
                { name: 'subject', type: 'string' },
                { name: 'calendar', type: 'string' },
                { name: 'start', type: 'date' },
                { name: 'end', type: 'date' },
                { name: 'background', type: 'string' }
            ],
            id: 'id',
            localData: appointments
        };
        var adapter = new $.jqx.dataAdapter(source);
        var sval = $("#scheduler").jqxScheduler({
             date: new $.jqx.date({{date('Y')}}, {{date('m')}}, {{date('d')}}),
            width: 650,
            height: 400,
            source: adapter,
            editDialog: false,
            view: 'weekView',
            showLegend: true,
            ready: function () {
                $("#scheduler").jqxScheduler('ensureAppointmentVisible', 'id1');

            },
            resources:
            {
                colorScheme: "scheme05",
                dataField: "calendar",
                //orientation: "vertical",
                source: new $.jqx.dataAdapter(source)
            },
            appointmentDataFields:
            {
                from: "start",
                to: "end",
                id: "id",
                description: "description",
                location: "place",
                subject: "subject",
                resourceId: "calendar",
                background: 'background'
            },
            appointmentsMinHeight: 20,
            views:
        [
            'weekView',
        ]
        });
        $('#scheduler').on('appointmentClick', function (event) {

            var args = event.args; var appointment = args.appointment;

            var selected_booked_date_from_time = (appointment.originalData.start);

            var selected_booked_date_to_time = (appointment.originalData.end);

            var selected_s_c = (appointment.originalData.subject);

            // var mo = parseInt(selected_booked_date_from_time.getMonth())+1;

            // if(mo >=10){

            //     var selected_booked_date = selected_booked_date_from_time.getFullYear()+"-"+mo+"-"+selected_booked_date_from_time.getDate();

            // }else{

            //     var selected_booked_date = selected_booked_date_from_time.getFullYear()+"-"+"0"+mo+"-"+selected_booked_date_from_time.getDate();

            // }
            var mo = parseInt(selected_booked_date_from_time.getMonth())+1;
            var dtt = parseInt(selected_booked_date_from_time.getDate());

            if(mo <10){
                mo = "0"+mo;
            }
            if(dtt <10){
                dtt = "0"+dtt;
            }
            var selected_booked_date = selected_booked_date_from_time.getFullYear()+"-"+mo+"-"+dtt;
            var from_time = selected_booked_date_from_time.getHours()+":"+selected_booked_date_from_time.getMinutes()+":"+selected_booked_date_from_time.getSeconds();

            var to_time = selected_booked_date_to_time.getHours()+":"+selected_booked_date_to_time.getMinutes()+":"+selected_booked_date_to_time.getSeconds();
            // alert(selected_booked_date);
            $("#selected_booked_date").val(selected_booked_date);
            $("#selected_booked_from_time").val(from_time);
            $("#selected_booked_to_time").val(to_time);
            $("#selected_booked_date_from_time").val(selected_booked_date_from_time);
            $("#selected_booked_date_to_time").val(selected_booked_date_to_time);

        });

        $("#bookClass").validate({
            submitHandler: function(form){
                var booking_d = $("#selected_booked_date").val();
                if(booking_d == ""){

                    // $(".not_available_date").html("Please select available booking date!");
                    $("#error_selected_d").html("Please select available booking date!");

                    return false;

                }else{
                    var get_booking_date = $.trim($("#selected_booked_date").val()),
            from_time = $.trim($("#start1").val()),
            to_time = $.trim($("#end1").val()),
            reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'tutor_id'    : @if(@$vtutor->id){{ @$vtutor->id }} @else 0 @endif,
                    'get_booking_date'    : get_booking_date,
                    'from_time'    : from_time,
                    'to_time'    : to_time
                }
            };

            if(get_booking_date != "" && from_time != "" && to_time != ""){
                $.ajax({
                    url:"{{ route('ajax.check.booking.date') }}",
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success:function(resp){

                        // console.log(resp);
                        if(resp.output == 'false'){

                            $("#start1").val("");
                            $("#end1").val("");
                            $(".error_start_end_time").html("Choose available time slot");
                        }else{

                            $(".error_start_end_time").html("");

                            form.submit();
                        }
                    }
                });
            }


                }
            }
        });
        $("#searchtutor").validate({
            submitHandler: function(form){
                if($.trim($("#search_tutor_selected_name_studentclass").val()) != $.trim($("#search_tutor_nm_studentclass").val())){
                    $(this).val("");
                    $("#search_tutor_id").val("");
                    $("#search_tutor_selected_name_studentclass").val("");
                    $("#search_tutor_nm_studentclass").val("");
                    return false;
                }else{
                    form.submit();
                }
            }
        });
        $(document).on("blur","#search_tutor_nm_studentclass",function(){
            if($.trim($("#search_tutor_selected_name_studentclass").val()) != $.trim($(this).val())){
                $(this).val("");
            }
        });
        $(document).on("blur","#start1 #end1 #subject",function(){
            // console.log("before ");
            var get_booking_date = $.trim($("#selected_booked_date").val()),
            from_time = $.trim($("#start1").val()),
            to_time = $.trim($("#end1").val()),
            reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'tutor_id'    : @if(@$vtutor->id){{ @$vtutor->id }} @else 0 @endif,
                    'get_booking_date'    : get_booking_date,
                    'from_time'    : from_time,
                    'to_time'    : to_time
                }
            };
            if(get_booking_date != "" && from_time != "" && to_time != ""){
                $.ajax({
                    url:"{{ route('ajax.check.booking.date') }}",
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success:function(resp){

                        // console.log(resp);
                        if(resp.output == 'false'){

                            $("#start1").val("");
                            $("#end1").val("");
                            $(".error_start_end_time").html("Choose available time slot");
                        }else{
                            $(".error_start_end_time").html("");
                        }
                    }
                });
            }

        });
        $(document).on("blur","#selected_booked_date",function(){
            // console.log("before ");
            var get_booking_date = $.trim($("#selected_booked_date").val()),
            from_time = $.trim($("#start1").val()),
            to_time = $.trim($("#end1").val()),
            reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'tutor_id'    : @if(@$vtutor->id){{ @$vtutor->id }} @else 0 @endif,
                    'get_booking_date'    : get_booking_date,
                    'from_time'    : from_time,
                    'to_time'    : to_time
                }
            };
            if(get_booking_date != "" && from_time != "" && to_time != ""){
                $.ajax({
                    url:"{{ route('ajax.check.booking.date') }}",
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success:function(resp){

                        // console.log(resp);
                        if(resp.output == 'false'){

                            $("#start1").val("");
                            $("#end1").val("");
                            $(".error_start_end_time").html("Choose available time slot");
                        }else{
                            $(".error_start_end_time").html("");
                        }
                    }
                });
            }

        });
        $(document).on("click",".saveUsertoFavourite",function(e){
            var favourite_user_id = $(this).attr("data-saveUsertoFavourite"),
            obj = $(this),
            reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'favourite_user_id'    : favourite_user_id
                }
            };
            $.ajax({
                url:"{{ route('save.user.to.favourite') }}",
                dataType: 'json',
                data: reqData,
                type: 'post',
                success:function(resp){
                    if(resp.result.status == 'Added'){
                        obj.addClass("heart_cc_act");
                    }else{
                        obj.removeClass("heart_cc_act");
                        obj.parent().hide();
                    }
                    toastr.success(resp.result.message);
                },
                error:function(){
                    toastr.error("Please refresh the page!");
                }
            });

        });

        function compareDates(date, dates) {
            for (var i = 0; i < dates.length; i++) {
                if (dates[i].getDate() == date.getDate() &&
                    dates[i].getMonth() == date.getMonth() &&
                    dates[i].getYear() == date.getYear()) {
                return true
                }
            }
        }
        function timeValuesChange() {

            var booking_date = $.trim($("#selected_booked_date").val()),
            tutor_id = {{ @$vtutor->id?@$vtutor->id:0 }},
            reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'booking_date'    : booking_date,
                    'tutor_id'    : tutor_id,
                }
            };
            var startArr = new Array();
            var endArr = new Array();
            var start1 = $("#start1").data("kendoTimePicker");
            var end1 = $("#end1").data("kendoTimePicker");
            $.ajax({
                url:"{{ route('ajax.checking.booking.slot') }}",
                dataType: 'json',
                data: reqData,
                type: 'post',
                success:function(resp){
                    $("#start1").val("");
                    $("#end1").val("");
                    start1.value("");
                    end1.value("");
                    start1.min(resp.minSTime);
                start1.max(resp.maxSTime);
                end1.min(resp.minTTime);
                end1.max(resp.maxTTime);
                var startArr = new Array();
                var endArr = new Array();
                for(var i=0;i<resp.get_available_start_times.length;i++){
                    var spl = resp.get_available_start_times[i].split(":");
                    startArr.push(new Date({{date('Y,m,d')}},spl[0],spl[1],spl[2]));
                }
                start1.setOptions({
                    dates: startArr
                });
                // start1.dates(startArr);
                // for(var i=0;i<resp.get_available_end_times.length;i++){
                //     var splend = resp.get_available_end_times[i].split(":");
                //     endArr.push(new Date({{date('Y,m,d')}},splend[0],splend[1],splend[2]));
                // }
                // end1.setOptions({
                //     dates: endArr
                // });
                    // for(var i=0;i<resp.get_available_start_times.length;i++){
                    //     var spl = resp.get_available_start_times[i].split(":");
                    //     startArr.push(new Date({{date('Y,m,d')}},spl[0],spl[1],spl[2]));
                    // }

                    // for(var i=0;i<resp.get_available_end_times.length;i++){
                    //     var splend = resp.get_available_end_times[i].split(":");
                    //     endArr.push(new Date({{date('Y,m,d')}},splend[0],splend[1],splend[2]));
                    // }

                    // start1.value(resp.min_available_start_times);
                    // start1.min(resp.min_available_start_times);
                    // start1.max(resp.max_available_start_times);
                    // start1.setOptions({
                    //     dates: startArr
                    // });
                    // start1.dates(startArr);

                    // end1.value("7:00 am");
                    // end1.value(resp.min_available_end_times);
                    // end1.min(resp.min_available_end_times);
                    // end1.max(resp.max_available_end_times);
                    // end1.setOptions({
                    //     dates: endArr
                    // });
                    // end1.dates(endArr);
                }
            });
        }
        var d = $("#selected_booked_date").kendoDatePicker({
            // value: new Date(),
            change: timeValuesChange,
            dates: [
                // new Date("10/12/2021"),
                @if(@$get_available_dates)
                    @foreach(@$get_available_dates as $key=> $val)
                        @if(!in_array($val, @$all_disabled_booking_dates))
                            @if(date('Y-m-d') <= $val)
                            @php
                            $gtymd=explode("-",$val);
                            @endphp
                            new Date("{{ $gtymd[1]."/".$gtymd[2]."/".$gtymd[0] }}"),
                            @endif
                        @endif
                    @endforeach
                @endif
            ],
            disableDates: function (date) {
                var dates = $("#selected_booked_date").data("kendoDatePicker").options.dates;
                if (date && compareDates(date, dates)) {
                    return false;
                } else {
                    return true;
                }
            },
            format: "yyyy-MM-dd",
            footer:false
        }).data("kendoDatePicker");
        d.readonly();
    });
</script>
<script type="text/javascript">
    function datastudentautocomplete(inp, arr) {

    /*the autocomplete function takes two arguments,

    the text field element and an array of possible autocompleted values:*/

    var currentFocus;

    /*execute a function when someone writes in the text field:*/

    inp.addEventListener("input", function(e) {

        var a, b, i, val = this.value;

        /*close any already open lists of autocompleted values*/

        closeaAllLists();

        if (!val) { return false;}

        currentFocus = -1;

        /*create a DIV element that will contain the items (values):*/

        a = document.createElement("DIV");

        a.setAttribute("id", this.id + "autocomplete-list");

        a.setAttribute("class", "autocomplete-items");

        /*append the DIV element as a child of the autocomplete container:*/

        this.parentNode.appendChild(a);

        $.ajax({

          url:"{{ route('student.search.grade.tutors.book') }}",

          dataType: 'json',

          data: {

            "book_grade":{{ @Auth::user()->grade }},
            "search_u_name":val

          },

          type: 'GET',

          success:function(resp){

              /*for each item in the array...*/

              if(resp.grade_id != 0){

                  for (i = 0; i < resp.grade_tutors.length; i++) {

                  /*check if the item starts with the same letters as the text field value:*/

                  if ((resp.grade_tutors[i].f_name+" "+resp.grade_tutors[i].l_name).substr(0, val.length).toUpperCase() == val.toUpperCase()) {

                    /*create a DIV element for each matching element:*/

                    b = document.createElement("DIV");

                    /*make the matching letters bold:*/

                    b.innerHTML = "<strong>" + (resp.grade_tutors[i].f_name+" "+resp.grade_tutors[i].l_name).substr(0, val.length) + "</strong>";

                    b.innerHTML += (resp.grade_tutors[i].f_name+" "+resp.grade_tutors[i].l_name).substr(val.length);

                    /*insert a input field that will hold the current array item's value:*/

                    b.innerHTML += "<input type='hidden' data-slug='"+resp.grade_tutors[i].slug+"' id='"+resp.grade_tutors[i].id+"' value='" + resp.grade_tutors[i].f_name+' '+resp.grade_tutors[i].l_name+ "'>";

                    // b.innerHTML += "<input type='hidden' name='ttuor_hidden' value='" + resp.grade_tutors[i].f_name + "'>";

                    /*execute a function when someone clicks on the item value (DIV element):*/

                    b.addEventListener("click", function(e) {

                        /*insert the value for the autocomplete text field:*/

                        inp.value = this.getElementsByTagName("input")[0].value;

                        $("#search_tutor_id_studentclass").val(this.getElementsByTagName("input")[0].id);

                        $("#search_tutor_selected_name_studentclass").val(this.getElementsByTagName("input")[0].value);

                        // console.log(this.getElementsByTagName("input")[0].data-slug);

                        var slug = $("#"+this.getElementsByTagName("input")[0].id).attr("data-slug");

                        $("#search_tutor_slug_studentclass").val(slug);

                        // inp.id = this.getElementsByTagName("input")[0].id;



                        /*close the list of autocompleted values,

                        (or any other open lists of autocompleted values:*/

                        closeaAllLists();

                    });

                    a.appendChild(b);

                  }

                  }

              }

              // console.log(resp);

          },

          error:function(){

          }

      });



    });

    /*execute a function presses a key on the keyboard:*/

    inp.addEventListener("keydown", function(e) {

        var x = document.getElementById(this.id + "autocomplete-list");

        if (x) x = x.getElementsByTagName("div");

        if (e.keyCode == 40) {

          /*If the arrow DOWN key is pressed,

          increase the currentFocus variable:*/

          currentFocus++;

          /*and and make the current item more visible:*/

          addaActive(x);

        } else if (e.keyCode == 38) { //up

          /*If the arrow UP key is pressed,

          decrease the currentFocus variable:*/

          currentFocus--;

          /*and and make the current item more visible:*/

          addaActive(x);

        } else if (e.keyCode == 13) {

          /*If the ENTER key is pressed, prevent the form from being submitted,*/

          e.preventDefault();

          if (currentFocus > -1) {

            /*and simulate a click on the "active" item:*/

            if (x) x[currentFocus].click();

          }

        }

    });

    function addaActive(x) {

      /*a function to classify an item as "active":*/

      if (!x) return false;

      /*start by removing the "active" class on all items:*/

      removeaActive(x);

      if (currentFocus >= x.length) currentFocus = 0;

      if (currentFocus < 0) currentFocus = (x.length - 1);

      /*add class "autocomplete-active":*/

      x[currentFocus].classList.add("autocomplete-active");

    }

    function removeaActive(x) {

      /*a function to remove the "active" class from all autocomplete items:*/

      for (var i = 0; i < x.length; i++) {

        x[i].classList.remove("autocomplete-active");

      }

    }

    function closeaAllLists(elmnt) {

      /*close all autocomplete lists in the document,

      except the one passed as an argument:*/

      var x = document.getElementsByClassName("autocomplete-items");

      for (var i = 0; i < x.length; i++) {

        if (elmnt != x[i] && elmnt != inp) {

          x[i].parentNode.removeChild(x[i]);

        }

      }

    }

    /*execute a function when someone clicks in the document:*/

    document.addEventListener("click", function (e) {

        closeaAllLists(e.target);

    });
    }
    datastudentautocomplete(document.getElementById("search_tutor_nm_studentclass"),[]);
</script>
@endsection

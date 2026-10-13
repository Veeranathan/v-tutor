@extends('layouts.app')
@section('title')
<title>V-Tutor  | Tutor | Reschedule Booking</title>
@endsection
@section('left_part')
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
                @include('include.teacher_left_common'){{-- left common part --}}
                <div class="user-right-panel ">
                    <div class="user-right-top-new ">
                        <h2 class="profile-heading">Reschedule Booking</h2>
                        <p>You can reschedule booking in this section</p>
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

                                                    <img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$vtutor->profile_pic}}" alt="" id="img2">

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

                                                 <span><img src="{{ public_asset('assets/images/map.png') }}">{{ @$vtutor->getState->state_name }} </span>

                                                <ul class="profile-rating m-0">

                                                    @if($vtutor->avg_review>=0 && $vtutor->avg_review<=0.24)

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                    @endif

                                                    @if($vtutor->avg_review>=0.25 && $vtutor->avg_review<=0.74)

                                                        <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                    @endif

                                                    @if($vtutor->avg_review>=0.75 && $vtutor->avg_review<=1.24)

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                    @endif

                                                    @if($vtutor->avg_review>=1.25 && $vtutor->avg_review<=1.74)

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                    @endif

                                                    @if($vtutor->avg_review>=1.75 && $vtutor->avg_review<=2.24)

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                    @endif

                                                    @if($vtutor->avg_review>=2.25 && $vtutor->avg_review<=2.74)

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                    @endif

                                                    @if($vtutor->avg_review>=2.75 && $vtutor->avg_review<=3.24)

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                    @endif

                                                    @if($vtutor->avg_review>=3.25 && $vtutor->avg_review<=3.74)

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>

                                                    @endif

                                                    @if($vtutor->avg_review>=3.75 && $vtutor->avg_review<=4.24)

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star rre_star" style="color:#b6b6b6 !important;"></i></li>



                                                    @endif



                                                    @if($vtutor->avg_review>=4.25 && $vtutor->avg_review<=4.74)

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fas fa-star-half-alt" style="color:#ef9a0c!important;"></i></li>

                                                    @endif

                                                    @if($vtutor->avg_review>=4.75 && $vtutor->avg_review<=5)

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                        <li><i class="fa fa-star" style="color:#ef9a0c!important;"></i></li>

                                                    @endif

                                                        <li><p>{{ @$vtutor->avg_review }} ({{ @$vtutor->total_no_of_reviews }})</p></li>

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
                                                            {{ date("h:i a", strtotime(@$t->from_time)) }}-{{ date("h:i a", strtotime(@$t->to_time)) }},

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
                        <div class="booking-stat table_book">

                                <div class="table-responsive">

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Booking Number </th>
                                                <th>Student Name </th>
                                                <th>Student Grade </th>
                                                <th>Subject</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Rate per session (30 mins)</th>
                                                <th>Amount</th>
                                            </tr>
                                          </thead>
                                      <tr>
                                        <td>{{ @$getBookingInfo->booking_no }}</td>
                                        <td>{{ @$getBookingInfo->getStudent->f_name }} {{ @$getBookingInfo->getStudent->l_name }}</td>
                                        <td>{{ @$getBookingInfo->getStudentGrade->grade_name }}</td>
                                        <td>{{ @$getBookingInfo->getSubject->subject }} </td>
                                        <td>{{ @$getBookingInfo->booking_date }}</td>
                                        @php
                                        $diff = (strtotime(@$getBookingInfo->to_time) - strtotime(@$getBookingInfo->from_time))/60;

                                        @endphp
                                        <td>{{ date("h:i a", strtotime(@$getBookingInfo->from_time)) }} to {{ date("h:i a", strtotime(@$getBookingInfo->to_time)) }}  ({{ ($diff) }} minute)</td>
                                        <td>${{ @$getBookingInfo->hourly_rate }}</td>
                                        <td>${{ @$getBookingInfo->booking_amount }}</td>
                                      </tr>

                                    </table>
                                </div>


                            </div>
                    <div class="user-right-top from_time_div">
                        <form action="{{ url('tutor/teacher-update-reschedule-booking') }}/{{ @$getBookingInfo->booking_no }}" id="reschduleClass" method="post">
                            @csrf
                            <div class="row new_rows no-gutters">
                                <input type="hidden" name="tutor_id" id="tutor_id" value="{{ @$vtutor->id }}">
                                <div class="col-md-3 col-sm-6 from_time_value book_f_t_v">
                                    <h6>Date</h6>
                                    <input type="hidden" name="selected_booked_from_time" id="selected_booked_from_time" value="">
                                    <input type="hidden" name="selected_booked_to_time" id="selected_booked_to_time" value="">
                                    <input type="hidden" name="selected_booked_date_from_time" id="selected_booked_date_from_time" value="">
                                    <input type="hidden" name="selected_booked_date_to_time" id="selected_booked_date_to_time" value="">
                                    <input id="selected_booked_date" name="selected_booked_date" class="required datepickeropen" value="{{ @$getBookingInfo->booking_date }}">
                                    <span id="error_selected_d" class="error" style="color: red"></span>
                                </div>
                                <div class="col-md-3 col-sm-6 from_time_value book_f_t_v hide_from_to_time">
                                    <h6>From</h6>


                                        <input id="start1" name="from_time" placeholder="Start time"  style="width: 150px;" class="from_time start_end_time timepickeropen "  value="{{ date('h:i a',strtotime(@$getBookingInfo->from_time)) }}" readonly="" >

                                    <span id="error_f" class="error_start_end_time error"></span>
                                </div>
                                <div class="col-md-3 col-sm-6 from_time_value book_f_t_v hide_from_to_time">
                                    <h6>To</h6>


                                    <input id="end1" name="to_time" placeholder="End time" style="width: 150px;" class="to_time start_end_time  timepickeropen" value="{{ date('h:i a',strtotime(@$getBookingInfo->to_time)) }}">

                                    <span id="to_f1" class="error_start_end_time error"></span>
                                </div>
                                <div class="col-md-3 col-sm-6 from_select_subject_student_book" style="display: none;">
                                    <div class="form_box_area">
                                        <label for="subject">Subject </label>
                                        <select id="subject" name="subject_id" class="required">

                                            @if(@$subjects)
                                            @foreach(@$subjects->unique('subject_id') as $subject)
                                            @if(@$getBookingInfo->subject_id == @$subject->getSubject->id)
                                            <option value="{{ @$subject->getSubject->id }}" @if(@$getBookingInfo->subject_id == @$subject->getSubject->id) selected="" @endif>{{ @$subject->getSubject->subject }}</option>
                                            @endif
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_3_cc">
                                <input type="submit" name="" value="Reschedule Booking " class="sub_btn new-subbtn">
                            </div>
                            <div class="row new_rows no-gutters">
                                <div class="col-xl-8 col-lg-9 col-md-9 col-sm-10  mx-auto">
                                    <div class="calen_bx new-das-cale">
                                        <div class="bookdetailsleft">
                                            <div class="calendar">
                                                <div class="calendar__month">
                                                    <div class="cal-month__current float-left"></div>
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
                                                    <div class="clearfix"></div>
                                                    <div class="">
                                                        <div class="">
                                                            <div id="scheduler">
                                                            </div>

                                                            <div class="error not_available_date"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
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
{{-- scheduler --}}
<script src="https://jqwidgets.com/public/jqwidgets/jqx-all.js"></script>
<link rel="stylesheet" type="text/css" href="https://jqwidgets.com/public/jqwidgets/styles/jqx.base.css">
<script type="text/javascript">
    $(document).ready(function(){

    function checkingRescheduleDateTimeDuration(){

            var get_booking_date = $.trim($("#selected_booked_date").val()),
            from_time = $.trim($("#start1").val()),
            to_time = $.trim($("#end1").val()),
            reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'booking_no'    : "{{ @$getBookingInfo->booking_no }}",
                    'tutor_id'    : {{ @$vtutor->id }},
                    'get_booking_date'    : get_booking_date,
                    'from_time'    : from_time,
                    'to_time'    : to_time
                }
            };
            if(get_booking_date != "" && from_time != "" && to_time != ""){
                $.ajax({
                    url:"{{ route('teacher.ajax.check.reschedule.booking') }}",
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success:function(resp){

                        // console.log(resp);
                        if(resp.output == 'false'){
                            $("#start1").val("");
                        $("#end1").val("");
                        $(".error_start_end_time").html(resp.show_message);
                        // $(".error_start_end_time").html("Choose available time slot!");

                        }else{
                            $(".error_start_end_time").html("");
                        }
                    }
                });
            }


    }
    function startChange1() {

        var startTime = start1.value();

        if (startTime) {

            startTime = new Date(startTime);
            end1.max(startTime);
            startTime.setMinutes(startTime.getMinutes() + 30);
            end1.min(startTime);
            end1.value(startTime);
            end1.max("8:30 PM");


        }

    }

    function endChange1() {
        checkingRescheduleDateTimeDuration();

    }



    var start1 = $("#start1").kendoTimePicker({
        change: startChange1,
        interval:30,
        min: new Date({{date('Y,m,d')}}, 6, 0, 0),
        max: new Date({{date('Y,m,d')}}, 20, 0, 0)
    }).data("kendoTimePicker");


    var end1 = $("#end1").kendoTimePicker({
        change: endChange1,
        interval:30,
        min: new Date({{date('Y,m,d')}}, 6, 30, 0),
        max: new Date({{date('Y,m,d')}}, 20, 30, 0)
    }).data("kendoTimePicker");


    start1.min("6:00 AM");
    start1.max("8:00 PM");

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

            $("#selected_booked_date").val(selected_booked_date);
            $("#selected_booked_from_time").val(from_time);
            $("#selected_booked_to_time").val(to_time);
            $("#selected_booked_date_from_time").val(selected_booked_date_from_time);
            $("#selected_booked_date_to_time").val(selected_booked_date_to_time);
            if(selected_s_c == "available"){

            }
        });
        $("#reschduleClass").validate({
            submitHandler: function(form){

                var booking_d = $("#selected_booked_date").val();
                if(booking_d == ""){


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
                            'booking_no'    : "{{ @$getBookingInfo->booking_no }}",
                            'tutor_id'    : {{ @$vtutor->id }},
                            'get_booking_date'    : get_booking_date,
                            'from_time'    : from_time,
                            'to_time'    : to_time
                        }
                    };
                    // 1second = 1000 ms
                    // 60 second = 1min
                    // diff in minutes
                    // var CurtimeStart = new Date(get_booking_date+" "+from_time),
                    // CurtimeEnd = new Date(get_booking_date+" "+to_time),
                    // curDiff = (CurtimeEnd - CurtimeStart)/(60*1000);

                    // 1second = 1000 ms
                    // 60 second = 1min
                    // diff in minutes
                    // var PrevBookingtimeStart = new Date("{{ @$getBookingInfo->booking_date }}"+" "+"{{ @$getBookingInfo->from_time }}"),
                    // PrevBookingtimeEnd = new Date("{{ @$getBookingInfo->booking_date }}"+" "+"{{ @$getBookingInfo->to_time }}"),
                    // PrevBookingDiff = (PrevBookingtimeEnd - PrevBookingtimeStart)/(60*1000);
                    // if(curDiff != PrevBookingDiff){
                    //     $("#start1").val("");
                    //     $("#end1").val("");
                    //     $(".error_start_end_time").html("Duration should be {{ @$currentDiff }} minutes!Choose available time slot!");
                    //     return false;
                    // }else{
                        if(get_booking_date != "" && from_time != "" && to_time != ""){
                            $.ajax({
                                url:"{{ route('teacher.ajax.check.reschedule.booking') }}",
                                dataType: 'json',
                                data: reqData,
                                type: 'post',
                                success:function(resp){
                                    if(resp.output == 'false'){
                                        $("#start1").val("");
                                        $("#end1").val("");
                                        $(".error_start_end_time").html("Choose available time slot!");
                                        return false;
                                    }else{
                                        $(".error_start_end_time").html("");
                                        form.submit();
                                    }
                                }
                            });
                        }else{
                            $(".error_start_end_time").html("This field is required!");
                            return false;
                        }
                    // }
                    // console.log("timeStart : "+timeStart+" timeEnd "+timeEnd+" diff "+curDiff+" PrevBookingDiff :"+PrevBookingDiff);

                }
            }
        });


        // $(document).on("blur","#start1 #end1 #subject",function(){

        //     var get_booking_date = $.trim($("#selected_booked_date").val()),
        //     from_time = $.trim($("#start1").val()),
        //     to_time = $.trim($("#end1").val()),
        //     reqData = {
        //         'jsonrpc' : '2.0',
        //         '_token'  : '{{csrf_token()}}',
        //         'data'    : {
        //             'booking_no'    : "{{ @$getBookingInfo->booking_no }}",
        //             'tutor_id'    : {{ @$vtutor->id }},
        //             'get_booking_date'    : get_booking_date,
        //             'from_time'    : from_time,
        //             'to_time'    : to_time
        //         }
        //     };
        //     // 1second = 1000 ms
        //     // 60 second = 1min
        //     // diff in minutes
        //     var CurtimeStart = new Date(get_booking_date+" "+from_time),
        //     CurtimeEnd = new Date(get_booking_date+" "+to_time),
        //     curDiff = (CurtimeEnd - CurtimeStart)/(60*1000);

        //     // 1second = 1000 ms
        //     // 60 second = 1min
        //     // diff in minutes
        //     var PrevBookingtimeStart = new Date("{{ @$getBookingInfo->booking_date }}"+" "+"{{ @$getBookingInfo->from_time }}"),
        //     PrevBookingtimeEnd = new Date("{{ @$getBookingInfo->booking_date }}"+" "+"{{ @$getBookingInfo->to_time }}"),
        //     PrevBookingDiff = (PrevBookingtimeEnd - PrevBookingtimeStart)/(60*1000);
        //     if(curDiff != PrevBookingDiff){
        //         $("#start1").val("");
        //         $("#end1").val("");
        //         $(".error_start_end_time").html("Duration should be same as previous booking!Choose available time slot!");
        //     }else{
        //         checkingRescheduleDateTimeDuration();
        //     }
        // });
        // $(document).on("blur","#selected_booked_date",function(){
        //     checkingRescheduleDateTimeDuration();
        // });
        // $(document).on("change","#selected_booked_date",function(){
        //     checkingRescheduleDateTimeDuration();
        // });
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
            tutor_id = {{ @$vtutor->id }},
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
            checkingRescheduleDateTimeDuration();
        }
        var d = $("#selected_booked_date").kendoDatePicker({
            change: timeValuesChange,
            dates: [
                @if(@$get_available_dates)
                    @foreach(@$get_available_dates as $key=> $val)
                        @if(date('Y-m-d') <= $val)
                        @php
                        $gtymd=explode("-",$val);
                        @endphp
                        new Date("{{ $gtymd[1]."/".$gtymd[2]."/".$gtymd[0] }}"),
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

@endsection

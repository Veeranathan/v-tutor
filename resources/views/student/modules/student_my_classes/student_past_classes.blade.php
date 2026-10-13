@extends('layouts.app')
@section('title')
<title>V-Tutor  | Tutor | My session | Past</title>
@endsection
@section('left_part')
{{-- @include('include.student_top_common') --}}
@include('include.header_menu_part')
{{-- for datatable --}}
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@endsection
{{-- <body class="after-user"> --}}
    @section('content')
    <!-- bannersec -->
    <div class="top_mar"></div>
    <!--- profile --->
    <section class="user-account">
        <div class="container">
            <div class="row">
                <div class="zin">
                    @include('include.student_left_common'){{-- left common part --}}
                    <div class="user-right-panel">
                        <div class="user-right-top-new ">
                            @include('include.errors')
                            <h2 class="profile-heading">Sessions </h2>
                            <p>You can find information about your sessions in this section</p>
                        </div>
                        <div class="class-feild">
                             <form method="post" action="{{route('student.my.classes.past')}}" id="frm">
                                @csrf
                                <div class="row new_rows1 ">
                                    <div class="col-sm-12">
                                        <div class="row new_rows1 @if(@$count_classes<= 0) addDisablePhone pointerEventsNone @endif">
                                            <div class="col-sm-4">
                                                <div class="form_box_area upCls">

                                                    <div class="dash-d1">
                                                        <label>From Date</label>
                                                        <div class="ui calendar" id="from">
                                                            <div class="ui input left icon">

                                                                <input type="text" placeholder="Select date" required="" name="from_date" id="from_date" value="{{request('from_date')}}">
                                                                <span class="over_llp1"><img src="{{ public_asset('assets/images/cal.png')}}" alt=""></span>
                                                            </div>
                                                            <label id="from_date-error" class="error" for="from_date"></label>
                                                        </div>
                                                    </div>
                                                    <div class="dash-d1 toDCls">
                                                        <label>To Date</label>
                                                        <div class="ui calendar" id="to">
                                                            <div class="ui input left icon">

                                                                <input type="text" placeholder="Select date" required="" name="to_date" id="to_date" value="{{request('to_date')}}">
                                                                <span class="over_llp1"><img src="{{ public_asset('assets/images/cal.png')}}" alt=""></span>
                                                            </div>
                                                            <label id="to_date-error" class="error" for="to_date"></label>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form_box_area">
                                                    <label>Status</label>
                                                    <select name="status">
                                                        <option value="">Select Status</option>
                                                        <option value="B" @if(request('status')=="B") selected @endif >Booked</option>
                                                        <option value="CM" @if(request('status')=="CM") selected @endif >Completed</option>
                                                        {{-- <option value="I" @if(request('status')=="I") selected @endif >In progress</option> --}}
                                                        <option value="C" @if(request('status')=="C") selected @endif >Cancelled</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-sm-2 col-6">
                                                <div class="form_box_area">
                                                    <button class="dash-btn "> <img src="{{ public_asset('assets/images/ser.png')}}"> Search </button>
                                                </div>
                                            </div>

                                            {{-- <div class="clearfix"></div> --}}
                                            <div class="col-sm-2 col-6">
                                                <div class="form_box_area">
                                                    <a href="{{route('student.my.classes.past')}}" class="dash-btn ">Reset</a>

                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-6">
                                                <a id="click_download" href="javascript:void(0);" class="dash-btn ">Download</a>

                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-2">
                                    <button class="dash-btn @if(count(@$classes) <= 0) addDisablePhone pointerEventsNone @endif"> <img src="{{ public_asset('assets/images/ser.png')}}"> Search </button></div> --}}
                                </div>
                            </form>
                        </div>
                        <div class="user-right-top-new">
                            <div class="main-tabels">
                                <!-- Nav tabs -->
                                <div class="tab-rii mb-4">
                                    <ul class="nav nav-tabs flex-wrap">
                                        <li class="nav-item">
                                            <a class="nav-link " {{-- data-toggle="tab" --}} href="{{route('student.my.classes')}}">Today's Sessions  </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " {{-- data-toggle="tab" --}} href="{{route('student.my.classes.upcoming')}}">Upcoming Sessions  </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" {{-- data-toggle="tab" --}} href="{{route('student.my.classes.past')}}"> Past Sessions</a>
                                        </li>
                                    </ul>
                                    <div class="">
                                        <form method="post" action="{{route('student.class.export')}}">
                                            @csrf
                                            <input type="hidden" name="session" value="past">
                                            <input type="hidden" name="status" value="{{request('status')}}">
                                            <input type="hidden" name="from_date" value="{{request('from_date')}}">
                                            <input type="hidden" name="to_date" value="{{request('to_date')}}">
                                            {{-- <button class="deen @if(count(@$classes) <= 0) addDisablePhone pointerEventsNone @endif" type="submit">Download</button> --}}
                                                <button style="display:none;" id="download_cls" class="deen @if(count(@$classes) <= 0) addDisablePhone pointerEventsNone @endif" type="submit">Download</button>
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

                                                        <th >Booking ID <img src="{{ public_asset('assets/images/sort.png')}}"></th>
                                                        <th >Tutor <img src="{{ public_asset('assets/images/sort.png')}}"></th>

                                                        <th >Date <img src="{{ public_asset('assets/images/sort.png')}}"></th>
                                                        <th >Time <img src="{{ public_asset('assets/images/sort.png')}}"></th>
                                                        <th >Grade<img src="{{ public_asset('assets/images/sort.png')}}"></th>
                                                        <th >Subject <img src="{{ public_asset('assets/images/sort.png')}}"></th>
                                                        <th >Status <img src="{{ public_asset('assets/images/sort.png')}}"></th>
                                                        <th> </th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($classes as $key=> $val)
                                                    <tr>

                                                        <td data-label="Name">
                                                            {{@$val->booking_no}}
                                                        </td>
                                                        <td data-label="Name">{{@$val->getTutor->f_name}}  {{@$val->getTutor->l_name}}</td>
                                                        <td data-label="Name"> {{date('d-m-Y', strtotime(@$val->booking_date))}}</td>
                                                        <td data-label="Name">{{date('h:i A', strtotime(@$val->from_time))}} - {{date('h:i A', strtotime(@$val->to_time))}}</td>

                                                        <td data-label="Name">{{@$val->getStudentGrade->grade_name}}</td>
                                                        <td data-label="Name">{{@$val->getSubject->subject}}</td>
                                                        <td data-label="Name" class="@if(@$val->booking_status=="B")
                                                        Booked
                                                        @elseif(@$val->booking_status=="C")
                                                        cancelled_red_color
                                                        @elseif(@$val->booking_status=="CM")
                                                        completed_green_color
                                                        @else
                                                        In progress
                                                        @endif">@if(@$val->booking_status=="B")
                                                            Booked
                                                            @elseif(@$val->booking_status=="C")
                                                            Cancelled
                                                             @elseif(@$val->booking_status=="CM")
                                                            @if(@$val->booking_status=="CM" && @$val->class_assessment_student == 'N')
                                                            <a class="red_link" href="{{route('student.class.end.assesment',$val->booking_no)}}">Review</a>
                                                            @else
                                                            Completed
                                                            @endif
                                                            @else
                                                            In progress
                                                        @endif</td>

                                                        <td >
                                                            <div class="add_ttrr actions-main">
                                                                <a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
                                                                <div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
                                                                <ul>
                                                                    <li><a href="{{route('student.view.details.class.booking',$val->booking_no)}}">View Details</a></li>
                                                                    @if(@$val->class_assessment_student == 'N' && @$val->booking_status == 'CM')
                                                                    <li><a href="{{route('student.class.end.assesment',$val->booking_no)}}">Class End Assesment</a></li>
                                                                    @endif

                                                                </ul>
                                                            </div>
                                                            {{-- <div class="add_ttrr actions-main"> --}}
                                                            {{-- <a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
                                                            <div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
                                                            <ul> --}}
                                                                {{--  <li><a href="{{route('aced.edit.page',$val->id)}}">Edit</a></li>
                                                                <li><a onclick="return confirm('Are you sure want to delete this?')" href="{{route('aced.dlt',$val->id)}}">Delete</a></li> --}}
                                                            {{-- </ul> --}}

                                                    </div></td>
                                                </tr>


                                                @endforeach

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                {{-- end --}}
                                <div class="testPro">
                                    <div class="proDiv">
                                        <h6>Please note:</h6>
                                        <p>1. You may click to join the session at your scheduled time. The tutor or meeting link may not be available in case you join early.</p>
                                        <p>2. You need an active <a href="https://zoom.us" class="red_link">Zoom account</a> to join sessions. If you don’t have one already, kindly create one and stay logged in.</p>
                                        <p>3. In case you fail to join the session within 10 minutes from the start time, it will be considered as ‘no show’ and you stand to forfeit charges for the session</p>
                                        <p>4. Session timings are fixed and cannot be extended for any reasons, though legitimate. If the session is interrupted due to technical reasons from tutor’s end or due to unavailability of the learning platform, the session will be considered as ‘cancelled’ and session charges would be refunded.</p>
                                    </div>
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
@endsection
@section('footer')
@include('include.footer')
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
<script>
    oTable = $('#example').DataTable({
        "order": [
            [0, "desc"]
        ],
        "pageLength":10,
        "language": {
            "emptyTable": "No data available",
            "info": "",
            "infoEmpty": "",
            "infoFiltered": "" 
        },
        dom: '<"top"f>t<"bottom row"<"col-12 d-flex justify-content-end"p>>',
        columnDefs: [ { targets: 0, type: 'natural' } ]
    });
    if (oTable.rows().data().length === 0) {
        $(oTable.table().container())
            .find('.dataTables_paginate')
            .hide();
    }
</script>
<script>
$(document).ready(function(){
    $('#click_download').on("click",function(){
        $("#download_cls").trigger("click");
    });
$('#frm').validate({
rules:{
qualification:{
required:true,
},
field_of_study:{
required:true,
},
university:{
required:true,
},
qualification_status:{
required:true,
},
effective_date:{
required:true,
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
function fun(id){
$('.show-actions').slideUp();
$("#show-action"+id).show();
}
function Cancel(id){
$("#show-action"+id).hide();
}
$(document).mouseup(function(e)
{
var container = $(".show-actions");
// if the target of the click isn't the container nor a descendant of the container
if (!container.is(e.target) && container.has(e.target).length === 0)
{
container.hide();
}
});
</script>


 <script>
//var d = new Date();
$('#frm').validate({
    submitHandler: function (form) {
      var val1 = new Date($('#from_date').val());
      var val2 = new Date($('#to_date').val());


console.log($('#from').val());
console.log(val2);
//return false;

         if(val1 == "Invalid Date" && val2 == "Invalid Date") {
          alert("select both dates");
        return false;

      }
       else if(val1 == "Invalid Date" && val2 != "Invalid Date" ) {
         alert("select from date");
           return false;
      }
       else if(val1 != "Invalid Date" && val2 == "Invalid Date" ) {
          alert("select to date");
           return false;
      }
       else if(val1 > val2) {
        console.log('max');
        console.log(val1);
        console.log(val2);

        alert('From date cannot be greater than to date');
      }
       else{
         form.submit();
      }

    }
  });
 </script>

 <script >
    $('#from').calendar({
  type: 'date',
   maxDate:new Date({{strtotime(date('Y-m-d H:i:s') . "-1 days")}}*1000),
});
</script>
<script >
    $('#to').calendar({
  type: 'date',
   maxDate:new Date({{strtotime(date('Y-m-d H:i:s') . "-1 days" )}}*1000),
});
</script>
@endsection

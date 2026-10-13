@extends('admin.layouts.app')

@section('title')

Block Booking

@endsection

@section('links')

    @include('admin.includes.links')

@endsection

@section('header')

    @include('admin.includes.header')

@endsection

@section('sidebar')

    @include('admin.includes.sidebar')

@endsection

@section('content')

            <!-- Start content -->

        <div class="content">



        <div class="wraper container-fluid">



        <div class="row">

          <div class="col-sm-12">

            <h1 class="pull-left page-title">Block Booking</h1>

            <ol class="breadcrumb pull-right">

                <li><a href="{{route('admin.dashboard')}}">Vtutor</a></li>
                <li> <a href="{{ route('manage.admin.disable.dates') }}"> Manage Disable Booking Dates</a></li>
              <li class="active">Disable Booking Date</li>

            </ol>

          </div>

        </div>
        <div class="row">

                        <div class="col-lg-12">

                    <div>

                                <!-- Personal-Information -->

                                <div class="panel panel-default panel-fill">

                                    <div class="panel-heading">

                                        <h3 class="panel-title">Block Booking</h3>



                                    </div>

                                    <div class="panel-body rm02 rm04">

                                    @include('admin.includes.message')

                                    <form class="form-horizontal" method="POST" action="{{route('admin.disable.bookings')}}" role="form" id="yes_no_admin_disable_bookings_settings">

                                        @csrf

                                        <div class="redio_div">
                                            <ul>
                                                <li class="redio_bx">
                                                    <input type="radio" id="radio1" name="disable_booking" @if(@$admin_disable_booking_settings->disable_booking == 'Y') checked="" @endif class="custom-control-input checkbox_ck_u" value="Y">
                                                    <label for="radio1">Yes</label>
                                                </li>
                                                <li class="redio_bx">
                                                    <input type="radio" id="radio2" name="disable_booking" @if(@$admin_disable_booking_settings->disable_booking == 'N') checked="" @endif class="custom-control-input checkbox_ck_u" value="N"><label for="radio2">No</label>
                                                </li>

                                            </ul>

                                        </div>

                                        <div class="clearfix"></div>



                                        <div class="clearfix"></div>

                                        <div class="clearfix"></div>

                                        <div class="col-lg-12">

                                            <button class="btn btn-primary waves-effect waves-light w-md c_save_admin_disable_setting" id="save_admin_disable_setting" type="button">Save</button>

                                        </div>

                                    </form>



                                    </div>

                                </div>

                                <!-- Personal-Information -->



                        </div>

                    </div>

                    </div>

                </div> <!-- container -->


                <div class="row">

                        <div class="col-lg-12">

                    <div>

                                <!-- Personal-Information -->

                                <div class="panel panel-default panel-fill">

                                    <div class="panel-heading">

                                        <h3 class="panel-title">Block Booking On This Date</h3>



                                    </div>

                                    <div class="panel-body rm02 rm04">

                                    {{-- @include('admin.includes.message')   --}}

                                    <form class="form-horizontal" method="POST" action="{{route('edit.disable.date',$gt_admin_disablse_booking_dates->id)}}" role="form" id="admin_disable_bookings_settings">

                                        @csrf



                                        <div class="clearfix"></div>

                                        <div class="form-group disable_booking_date_div">

                                            <div class="dash-d1">

                                            <label for="disable_booking_date">Block Booking On This Date</label>

                                                <div class="ui calendar calendardatepicker" id="from_date">

                                                    <div class="ui input left icon">

                                                      <input type="text" id="disable_booking_date" name="disable_booking_date" placeholder="" value="{{ @$gt_admin_disablse_booking_dates->disable_booking_date }}" class="form-control reset_val  required" autocomplete="off" readonly="" >

                                                      <span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>

                                                      <span class="error_from_date error"></span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="clearfix"></div>

                                        <div class="col-lg-12">

                                            <button class="btn btn-primary waves-effect waves-light w-md c_save_blocked_date" type="button" id="save_blocked_date">Save</button>

                                        </div>

                                    </form>



                                    </div>

                                </div>

                                <!-- Personal-Information -->



                        </div>

                    </div>

                    </div>

                </div> <!-- container -->



@endsection

@section('footer')

    @include('admin.includes.footer')

@endsection

@section('script')

@include('admin.includes.script')

<script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>



<script>

$(document).ready(function(){

    // $(".checkbox_ck_u").click(function(){

    //     var value = $(this).val();

    //     if(value == 'BD'){
    //         $("#disable_booking_date").val("");
    //         $(".disable_booking_date_div").show();
    //         $("#disable_booking_date").addClass("required");

    //     }

    //     if(value == 'N'){
    //         $("#disable_booking_date").val("");
    //         $(".disable_booking_date_div").hide();
    //         $("#disable_booking_date").removeClass("required");
    //     }

    //     if(value == 'BB'){
    //         $("#disable_booking_date").val("");
    //         $(".disable_booking_date_div").hide();
    //         $("#disable_booking_date").removeClass("required");
    //     }



    //     // if($(this).is(":checked")) {

    //     //     $("#searchVtutorForm").submit();

    //     // } else {

    //     //     $(this).val("");

    //     //     $("#searchVtutorForm").submit();

    //     // }

    // });

    // $('#admin_disable_bookings_settings').validate();
    // ajax.duplicate.ajax.blocked.date.check
    var isvalidator = $('#admin_disable_bookings_settings').validate({
        rules: {
            disable_booking_date: {
                required: true,
                remote:{
                    url:"{{route('ajax.duplicate.ajax.blocked.date.check')}}",
                    type:"POST",
                    data: {
                        disable_booking_date: function() {
                            return $("#disable_booking_date").val();
                        },
                        id: function() {
                            return {{ @$gt_admin_disablse_booking_dates->id?$gt_admin_disablse_booking_dates->id:0 }};
                        },
                        _token: '{{ csrf_token() }}'
                    }
                }
            },
        },
        messages: {
            disable_booking_date:{
               remote: 'This date has already been taken'
            } ,
        },
        submitHandler:function(form){
           form.submit();
        },
    });
    $('#yes_no_admin_disable_bookings_settings').on('keyup keypress keydown', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });
    var is1validator = $('#yes_no_admin_disable_bookings_settings').validate();
    $('#admin_disable_bookings_settings').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });
    $("#save_admin_disable_setting").click(function(){
        if(is1validator.form()){
        if(is1validator.valid()){
            var obj = $("#save_admin_disable_setting"),
            tId = obj.attr("id"),
            tName = "c_save_admin_disable_setting",
            tFrmId = "yes_no_admin_disable_bookings_settings";
            $("#type_popup_next").val("R");
            isAuthorizedByAdmin(tName,tId,tFrmId);
        }else{
            $('#instructionModal').modal('hide');
        }
        }
    });
    $(".calendardatepicker").calendar({

        type: 'date',

        min:new Date(),

        formatter: {

            date: function (date, settings) {

                if (!date) return '';

                var day = date.getDate() + '';

                if (day.length < 2) {

                    day = '0' + day;

                }

                var month = (date.getMonth() + 1) + '';

                if (month.length < 2) {

                    month = '0' + month;

                }

                var year = date.getFullYear();

                var date_value = year + '-' + month + '-' + day;



                return date_value;

            }

        }

    });
    // $("input").keydown(function(e){
    //     var key = e.keyCode || e.which;
    //     // alert(key);
    //     if(key == 13){
    //         $("#save_blocked_date").trigger("click");
    //     }

    // });
    $("#save_blocked_date").click(function(){
        if(isvalidator.form()){
        if(isvalidator.valid()){
            var obj = $("#save_blocked_date"),
            tId = obj.attr("id"),
            tName = "c_save_blocked_date",
            tFrmId = "admin_disable_bookings_settings";
            $("#type_popup_next").val("R");
            isAuthorizedByAdmin(tName,tId,tFrmId);
        }else{
            $('#instructionModal').modal('hide');
        }
        }
    });
    $(".calendardatepicker").calendar({

        type: 'date',

        minDate:new Date(),

        formatter: {

            date: function (date, settings) {

                if (!date) return '';

                var day = date.getDate() + '';

                if (day.length < 2) {

                    day = '0' + day;

                }

                var month = (date.getMonth() + 1) + '';

                if (month.length < 2) {

                    month = '0' + month;

                }

                var year = date.getFullYear();

                var date_value = year + '-' + month + '-' + day;



                return date_value;

            }

        }

    });

});

</script>

@endsection

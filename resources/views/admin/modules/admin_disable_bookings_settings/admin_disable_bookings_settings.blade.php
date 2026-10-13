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

              <li class="active">Block Booking</li>

            </ol>

          </div>

        </div>



                <div class="row">

                        <div class="col-lg-12">

                    <div>

                                <!-- Personal-Information -->

                                <div class="panel panel-default panel-fill">

                                    <div class="panel-heading">

                                        <h3 class="panel-title">Block Booking*</h3>



                                    </div>

                                    <div class="panel-body rm02 rm04">

                                    @include('admin.includes.message')

                                    <form class="form-horizontal" method="POST" action="{{route('admin.disable.bookings')}}" role="form" id="admin_disable_bookings_settings">

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

    var isvalidator = $('#admin_disable_bookings_settings').validate();
    $('#admin_disable_bookings_settings').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });
    $("#save_admin_disable_setting").click(function(){
        if(isvalidator.form()){
        if(isvalidator.valid()){
            var obj = $("#save_admin_disable_setting"),
            tId = obj.attr("id"),
            tName = "c_save_admin_disable_setting",
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

});

</script>

@endsection

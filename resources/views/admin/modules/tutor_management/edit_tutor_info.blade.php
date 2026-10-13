@extends('admin.layouts.app')
@section('title')
Edit Tutor Availability Information
@endsection
@section('links')
@include('admin.includes.links')
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.css" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.css" rel="stylesheet" type="text/css">
<style type="text/css">
    .disClass{
        pointer-events: none;
        opacity: 0.5;
    }
    .buttons-excel{
        display: none;
    }
    .dt-buttons{
        display: none;
    }
</style>
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.2.616/styles/kendo.common.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.2.616/styles/kendo.blueopal.min.css" />
@endsection
@section('header')
@include('admin.includes.header')
@endsection
@section('sidebar')
@include('admin.includes.sidebar')
@endsection
@section('content')
<div class="content">
    <div class="wraper container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left page-title">Edit Tutor Availability
                    <br/><p class="small_tag">You can find information or edit your profile in this section</p></h1>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.tutors') }}"><i class="fas fa-backward"></i> Back</a></li>
                    <li> <a href="{{ route('view.tutor',$user->id) }}"><i class="fas fa-eye"></i> View</a></li>

                    @if(@$previous_id)
                    <li> <a href="{{ route('edit.tutor.availablity',@$previous_id) }}"><i class="fas fa-angle-double-left"></i> Previous</a></li>
                    @endif
                    @if(@$next_id)
                    <li> <a href="{{ route('edit.tutor.availablity',@$next_id) }}"><i class="fas fa-angle-double-right"></i> Next</a></li>
                    @endif
                </ol>
            </div>
        </div>
        <div class="step_tab">
            <ul>
                <li class="">
                    <a href="{{ route('edit.tutor.personal.info.step.1',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/peri.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/perih.png') }}" class="accth"></span>
                    Personal Details
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('edit.tutor.tutorship.plans',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/gar.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/garh.png') }}" class="accth"></span>
                    Tutorship Plan
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.academics',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/aca.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/acah.png') }}" class="accth"></span>
                    Academics
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.experience',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/ex.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/exh.png') }}" class="accth"></span>
                    Experience </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.rec',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Recognitions
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('edit.tutor.availablity',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Availability
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.advance.page',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Advanced
                    </a>
                </li>
                <div class="clearfix"></div>
            </ul>
        </div>
        <!-- Personal-Information -->
        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')
                <div class="frm_admin">
                        @php
                        $days = array('Monday','Tuesday','Wedenesday','Thursday','Friday','Saturday','Sunday');
                        @endphp
                        @foreach(@$days as $key=>$d)
                        <div class="row">
                            <form class="availability_form" id="availability_form_{{ $key+1 }}" method="post" action="{{ url('admin/add-tutor-availability') }}/{{ @$user->id }}/{{ $key+1 }}">
                                @csrf
                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 from_time_div @if($key == 6) disClass disClass{{ $key+1 }} @endif">
                                    <div class="form-group check-box new-av-check">
                                        <input type="checkbox" id="checkbox{{ $key }}" name="day{{ $key }}" value="{{ $key+1 }}"  class="required" onclick="clk({{ $key }})" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" @if($key == 6) disabled="" @endif>
                                        <label for="checkbox{{ $key }}" class="checklabeel">{{ $d }} </label>
                                        <span class="error error_checkbox{{ $key }} new-thurcheck" style="color: #b80f0a;"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 disClass disClass{{ $key+1 }} timepicker_am_pm_from_ from_time_value" data-key="{{ $key+1 }}">
                                    <div class="form-group">
                                        <div class="dash-d">
                                            <label for="from_time">From Time</label>
                                            <input id="start{{ $key+1 }}" class="start_end_time required from_time " placeholder="From Time"  style="width: 150px;"  name="from_time{{ $key+1 }}" data-key="{{ $key+1 }}" autocomplete="off"  value="" autocomplete="off" />
                                            <span class="error_start_end_time error_start_time{{ $key+1 }}"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 from_time_value disClass disClass{{ $key+1 }}">
                                    <div class="form-group">
                                        <label for="to_time">To Time</label>
                                        <input id="end{{ $key+1 }}" class="required to_time start_end_time" placeholder="To Time"  style="width: 150px;" name="to_time{{ $key+1 }}" data-key="{{ $key+1 }}" autocomplete="off" value="" />
                                        <span class="error_start_end_time error_end_time{{ $key+1 }}"></span>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 disClass disClass{{ $key+1 }}">
                                    <div class="form-group ad_btn">
                                        <div class="dash-d">
                                            <label for="to_time">&nbsp;</label>
                                            <div class="dash-d new-das-in">
                                                <div class="ui calendar timepicker_am_pm_to_ timepicker_am_pm to_time " data-key="{{ $key+1 }}" id="calender_id_to_{{ $key+1 }}">
                                                    <div class="ui input left icon">
                                                        <button class="btn btn-primary waves-effect waves-light w-md availability_form_button c_button_availability_{{ $key+1 }}" id="button_availability_{{ $key+1 }}" data-key="{{ $key+1 }}" type="button">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10 col-md-offset-2 disClass disClass{{ $key+1 }}">
                                    <ul class="list-show">
                                        @php
                                        $list_my_availability = \App\Models\MyAvailability::where(['teacher_id'=>@$user->id,'day'=>$key+1])->get();
                                        @endphp
                                        @if(@$list_my_availability)
                                            @foreach(@$list_my_availability as $availablity)
                                            <li id="data{{ @$availablity->id }}">
                                                {{ date("h:i a", strtotime(@$availablity->from_time))  }} to  {{ date("h:i a", strtotime(@$availablity->to_time)) }}
                                                <span><a id="delete_tutor_availability{{ $availablity->id }}"  class="delete_tutor_availability" data-href="{{ route('delete.tutor.availability',$availablity->id) }}" data-onclick="Are you sure want to delete this schedule ?"><img src="{{ public_asset('assets/images/cross4.png') }}"></a></span>
                                            </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </form>
                        </div>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('admin.includes.footer')
@endsection
@section('script')
@include('admin.includes.script')
<script src="https://kendo.cdn.telerik.com/2021.2.616/js/kendo.all.min.js"></script>
<script type="text/javascript">
    // $(".error").addClass("error_start_end_time");
    function clk(i){
        if($('#checkbox'+i).prop("checked") == true){
            $('#error_d'+i).hide();
            var p = i+1;
            $(".disClass"+p).removeClass('disClass');
        }else{
            $('#error_d'+i).show();
            var p = i+1;
            $(".disClass"+p).addClass('disClass');
        }
    }
    $(document).ready(function() {
        $(document).on("click",".delete_tutor_availability",function(){
            var obj = $(this),
            tId = obj.attr("id"),
            tName = obj.attr("data-onclick"),
            ajax_url = $(this).attr("data-href");
            tFrmId = tId;
            $("#type_popup_next").val("H");
            $("#ajax_url").val(ajax_url);
            // alert("fbha");
            isAuthorizedByAdmin(tName,tId,tFrmId);
        });
        @foreach(@$days as $key=>$d)
        function startChange{{$key+1}}() {
            var startTime = start{{$key+1}}.value();
            if (startTime) {
                startTime = new Date(startTime);
                end{{$key+1}}.max(startTime);
                startTime.setMinutes(startTime.getMinutes() + 30);
                end{{$key+1}}.min(startTime);
                end{{$key+1}}.value(startTime);
                end{{$key+1}}.max("8:30 PM");
                //to set the max to_time , min to_time and value after selecting from time
            }
        }
        //init start timepicker
        var start{{$key+1}} = $("#start{{$key+1}}").kendoTimePicker({
            change: startChange{{$key+1}},
            interval:30,
        }).data("kendoTimePicker");
        //init end timepicker
        var end{{$key+1}} = $("#end{{$key+1}}").kendoTimePicker({
             interval:30,
              min: new Date({{date('Y,m,d')}}, 8,0, 0),
              max: new Date({{date('Y,m,d')}}, 19, 30, 0)
        }).data("kendoTimePicker");
        //define min/max range
        start{{$key+1}}.min("8:00 AM");
        start{{$key+1}}.max("7:00 PM");
        //define min/max range
        end{{$key+1}}.min("8:30 AM");
        end{{$key+1}}.max("7:30 PM");
        start{{ $key+1 }}.readonly();
        end{{ $key+1 }}.readonly();
        @endforeach
        $(document).on("click",".k-select",function(){
           var obj = $(this).parent().find(".start_end_time");
           obj.data("kendoTimePicker").open();
        });

        $(document).on("click",".start_end_time",function(){
           var id = $(this).attr("id");
           $("#"+id).data("kendoTimePicker").open();
        });

        $(document).on("click",".availability_form_button",function(){
            var key = $(this).data("key");
            var pkey = parseInt($(this).data("key"))-1;
            var from_time = $.trim($("#start"+key).val());
            var end_time = $.trim($("#end"+key).val());
            var checkbox = ($("#checkbox"+(key-1)).is(":checked"));
            $("#availability_form_"+key).validate();
            if(checkbox == false){
                $(".error_checkbox"+pkey).html("This field is required");
            }else{
                $(".error_checkbox"+pkey).html("");
            }
            if(from_time == ""){
                $(".error_start_time"+key).html("This field is required");
            }else{
                $(".error_start_time"+key).html("");
            }
            if(end_time == ""){
                $(".error_end_time"+key).html("This field is required");
            }else{
                $(".error_end_time"+key).html("");
            }
            if(from_time != "" && end_time != "" && checkbox != ""){
                var obj = $("#button_availability_"+key),
                tId = obj.attr("id"),
                tName = "c_button_availability_"+key,
                tFrmId = "availability_form_"+key;
                $("#type_popup_next").val("R");
                isAuthorizedByAdmin(tName,tId,tFrmId);
                // $("#availability_form_"+key).submit();
            }
        });
        $("#download").click(function(){
            $(".buttons-excel").trigger("click");
        });
        // $(".k-picker-wrap").append("<div class='clearfix'></div>");
        $("#example_wrapper div").eq(0).addClass("table-res");
        $("#example_info").remove();
        $("#example_length").remove();
    });
</script>

@endsection

@extends('admin.layouts.app')
@section('title')
Add Grade
@endsection
@section('links')
@include('admin.includes.links')
<link href="{{ public_asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ public_asset('admin/assets/css/core.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ public_asset('admin/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ public_asset('admin/assets/css/responsive.css') }}" rel="stylesheet" type="text/css">
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
                <h4 class="pull-left page-title">Add Grade</h4>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.grades') }}"><i class="fas fa-angle-double-left"></i> Back</a></li>
                </ol>
            </div>
        </div>
        <!-- Personal-Information -->
        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')
                <div class="frm_admin">
                        <form id="gradeform" method="post" action="{{ route('add.grade') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="grade_name">Grade*</label>
                                        <input type="text" placeholder="Grade" id="grade_name" name="grade_name" class="form-control required" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="capture_code">Grade Code*</label>
                                        <input type="text" placeholder="Grade Code" id="capture_code" name="capture_code" class="form-control required" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="ad_btn">
                                        <button class="btn btn-primary waves-effect waves-light w-md c_save_grade" id="save_grade" type="button">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
        <!-- Personal-Information -->
    </div>
</div>
@endsection
@section('footer')
@include('admin.includes.footer')
@endsection
@section('script')
@include('admin.includes.script')
<script src="{{ public_asset('admin/assets/js/jquery.min.js') }}"></script>
<script src="{{ public_asset('admin/assets/js/bootstrap.min.js') }}"></script>
<script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>
<script>
$(document).ready(function(){
    var isvalidator = $('#gradeform').validate({
        rules: {
            grade_name: {
                required: true,
                remote:{
                    url:"{{route('ajax.grade.duplicate.check')}}",
                    type:"POST",
                    data: {
                        grade_name: function() {
                            return $("#grade_name").val();
                        },
                        grade_id: function() {
                            return 0;
                        },
                        _token: '{{ csrf_token() }}'
                    }
                }
            },
            capture_code: {
                required: true,
                remote:{
                    url:"{{route('ajax.capture.code.grade.duplicate.check')}}",
                    type:"POST",
                    data: {
                        capture_code: function() {
                            return $("#capture_code").val();
                        },
                        grade_id: function() {
                            return 0;
                        },
                        _token: '{{ csrf_token() }}'
                    }
                }
            },
        },
        messages: {
            grade_name:{
               remote: 'This grade has already been taken'
            } ,
        },
        submitHandler:function(form){

           form.submit();

        },
    });
    $('#gradeform').on('keyup keypress keydown', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });
    $("#save_grade").click(function(){
        if(isvalidator.form()){
        if(isvalidator.valid()){
            var obj = $("#save_grade"),
            tId = obj.attr("id"),
            tName = "c_save_grade",
            tFrmId = "gradeform";
            $("#type_popup_next").val("R");
            isAuthorizedByAdmin(tName,tId,tFrmId);
        }else{
            $('#instructionModal').modal('hide');
        }
        }
    });
});
</script>
@endsection

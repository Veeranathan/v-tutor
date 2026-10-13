@extends('admin.layouts.app')
@section('title')
Edit Subject
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
                <h4 class="pull-left page-title">Edit Subject</h4>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.subjects') }}"><i class="fas fa-angle-double-left"></i> Back</a></li>
                </ol>
            </div>
        </div>
        <!-- Personal-Information -->
        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')
                <div class="frm_admin">
                        <form id="subjectform" method="post" action="{{ route('edit.subject',$subject->id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="branch_id">Branch</label>
                                        <select class="form-control required" id="branch_id" name="branch_id">
                                            <option value="">Select Branch</option>
                                            @if(@$branches)
                                            @foreach(@$branches as $b)
                                            <option value="{{ @$b->id }}" @if(@$subject->branch_id == $b->id) selected="" @endif>{{ @$b->branch_name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="display_order">Display order*</label>
                                        <input type="number" placeholder="Display Order" id="display_order" name="display_order" class="form-control required" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{ $subject->display_order }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="subject">Subject*</label>
                                        <input type="text" placeholder="Subject" id="subject" name="subject" class="form-control required" value="{{ @$subject->subject }}" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="capture_code">Subject Code*</label>
                                        <input type="text" placeholder="Subject Code" id="capture_code" name="capture_code" class="form-control required" value="{{ @$subject->capture_code }}" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="ad_btn">
                                        <button class="btn btn-primary waves-effect waves-light w-md c_save_subject" type="button" id="save_subject">Save</button>
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
    var isvalidator = $('#subjectform').validate({
        rules: {
            branch_id:{
                required:true
            },
            subject: {
                required: true,
                remote:{
                    url:"{{route('ajax.subject.duplicate.check')}}",
                    type:"POST",
                    data: {
                        subject: function() {
                            return $("#subject").val();
                        },
                        branch_id: function() {
                            return $("#branch_id").val();
                        },
                        subject_id: function() {
                            return {{ @$subject->id }};
                        },
                        _token: '{{ csrf_token() }}'
                    }
                }
            },
            capture_code: {
                required: true,
                remote:{
                    url:"{{route('ajax.subject.capture.duplicate.check')}}",
                    type:"POST",
                    data: {
                        capture_code: function() {
                            return $("#capture_code").val();
                        },
                        subject_id: function() {
                            return {{ @$subject->id }};
                        },
                        _token: '{{ csrf_token() }}'
                    }
                }
            },
        },
        messages: {
            subject:{
               remote: 'This subject has already been taken'
            } ,
        },
        submitHandler:function(form){

           form.submit();

        },
    });
    $('#subjectform').on('keyup keypress keydown', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });
    $("#save_subject").click(function(){
        if(isvalidator.form()){
        if(isvalidator.valid()){
            var obj = $("#save_subject"),
            tId = obj.attr("id"),
            tName = "c_save_subject",
            tFrmId = "subjectform";
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

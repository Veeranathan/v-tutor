@extends('admin.layouts.app')

@section('title')
Edit Topic Details
@endsection

@section('links')
@include('admin.includes.links')
<link href="{{ asset('public/admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('public/admin/assets/css/core.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('public/admin/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('public/admin/assets/css/responsive.css') }}" rel="stylesheet" type="text/css">
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
                <h4 class="pull-left page-title">Edit Topic Details</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="{{ route('manage.topics.details') }}"><i class="fas fa-angle-double-left"></i> Back</a></li>
                </ol>
            </div>
        </div>

        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')
                <div class="frm_admin">

<form method="POST" action="{{ route('edit.topic.details', $topic_details->id) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="branch_id">Branch</label>
       <select name="branch_id" class="form-control" id="branch_id">
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}" {{ $branch->id == $topic_details->branch_id ? 'selected' : '' }}>
    {{ $branch->branch_name ?? '' }}
</option>
        @endforeach
    </select>
    </div>

    <div class="form-group">
        <label for="grade_id">Grade</label>
       <select name="grade_id" class="form-control">
        @foreach($grades as $grade)
          <option value="{{ $grade->id }}" {{ $grade->id == $topic_details->grade_id ? 'selected' : '' }}>
    {{ $grade->grade_name ?? '' }}
</option>
        @endforeach
    </select>

    </div>

    <div class="form-group">
        <label for="subject_id">Subject</label>
        <select name="subject_id" class="form-control">
    @foreach($subjects as $subject)
      <option value="{{ $subject->id }}" {{ $subject->id == $topic_details->subject_id ? 'selected' : '' }}>
    {{ $subject->subject ?? '' }}
</option>
    @endforeach
</select>
    </div>

    <div class="form-group">
        <label for="topics_id">Topic</label>
        <select name="topic_id" class="form-control">
    @foreach($topics as $topic)
      <option value="{{ $topic->id }}" {{ $topic->id == $topic_details->topic_id ? 'selected' : '' }}>
    {{ $topic->topics ?? '' }}
</option>
    @endforeach
</select>
    </div>

    <div class="form-group">
        <label for="session_focus">Session Focus</label>
        <input type="text" name="session_focus" class="form-control" value="{{ $topic_details->session_focus }}">
    </div>
    
    <div class="form-group">
        <label for="learning_outcome">Learning Outcome</label>
        <input type="text" name="learning_outcome" class="form-control" value="{{ $topic_details->learning_outcome }}">
    </div>
    <div class="form-group">
        <label for="details_code">Details Code</label>
        <input type="text" name="topic_det_code" class="form-control" value="{{ $topic_details->topic_det_code }}">
    </div>


    <button type="submit" class="btn btn-primary">Update Topic</button>
</form>


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

<script src="{{asset('public/admin/assets/js/jquery.validate.js')}}"></script>

<script>
$(document).ready(function() {
    var isvalidator = $('#subjectform').validate({
        rules: {
            branch_id: { required: true },
            grade_id: { required: true },
            subject_id: { required: true },
            topic_id: { required: true },
            topic_det_code: { required: true },
            session_focus: { required: true },
            learning_outcome: { required: true }
        },
        messages: {
            branch_id: { required: 'Branch is required' },
            grade_id: { required: 'Grade is required' },
            subject_id: { required: 'Subject is required' },
            topic_id: { required: 'Topic name is required' },
            topic_det_code: { required: 'Topic code is required' }
            session_focus: { required: 'Session focus is required' },
            learning_outcome: { required: 'Learning outcome is required' }
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $('#subjectform').on('keyup keypress keydown', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $("#save_subject").click(function() {
        if(isvalidator.form()) {
            var obj = $("#save_subject"),
                tId = obj.attr("id"),
                tName = "c_save_subject",
                tFrmId = "subjectform";

            if (typeof isAuthorizedByAdmin === "function") {
                $("#type_popup_next").val("R");
                isAuthorizedByAdmin(tName, tId, tFrmId);
            }

            $("#subjectform").submit();
        }
    });
});
</script>
@endsection

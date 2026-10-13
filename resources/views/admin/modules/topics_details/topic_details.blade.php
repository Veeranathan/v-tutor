@extends('admin.layouts.app')

@section('title')
    Add Topic Details
@endsection

@section('links')
    @include('admin.includes.links')
    <link href="{{ asset('public/admin/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/admin/assets/css/core.css') }}" rel="stylesheet">
    <link href="{{ asset('public/admin/assets/css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('public/admin/assets/css/responsive.css') }}" rel="stylesheet">
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
                <h4 class="pull-left page-title">Add Topic Details </h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="{{ route('manage.topics.details') }}"><i class="fas fa-angle-double-left"></i> Back</a></li>
                </ol>
            </div>
        </div>

        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')
                <div class="frm_admin">
                    <form id="subjectform" method="post" action="{{ route('add.topics.details') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Grade*</label>
                                    <select name="grade_id" id="grade_id" class="form-control">
                                        <option value="">Select Grade</option>
                                        @foreach($grades as $grade)
                                            <option value="{{ $grade->id }}">{{ $grade->grade_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Branch</label>
                                    <select class="form-control" id="branch_id" name="branch_id">
                                        <option value="">Select Branch</option>
                                        @foreach($branches as $b)
                                            <option value="{{ $b->id }}">{{ $b->branch_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Subject*</label>
                                    <select class="form-control" id="subject_id" name="subject_id">
                                        <option value="">Select Subject</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Topic*</label>
                                    <select class="form-control" id="topic_id" name="topic_id">
                                        <option value="">Select Topic</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Details Code*</label>
                                    <input  id="topic_det_code" name="topic_det_code" class="form-control" placeholder="Details Code" onclick="this.removeAttribute('readonly');" onfocus="this.removeAttribute('readonly');">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Session Focus*</label>
                                    <input type="text" id="session_focus" name="session_focus" class="form-control" placeholder="Topic Code"  onclick="this.removeAttribute('readonly');" onfocus="this.removeAttribute('readonly');">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Learning Outcome*</label>
                                    <input type="text" id="learning_outcome" name="learning_outcome" class="form-control" placeholder="Learning Outcome"  onclick="this.removeAttribute('readonly');" onfocus="this.removeAttribute('readonly');">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="ad_btn">
                                    <button type="button" id="save_subject" class="btn btn-primary waves-effect waves-light w-md c_save_subject">Save</button>
                                </div>
                            </div>
                        </div>
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

    <script src="{{ asset('public/admin/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/jquery.validate.js') }}"></script>

    <script>
        // Prevent Enter key from submitting form
        $('#subjectform').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
            }
        });

        var isvalidator = $("#subjectform").validate();

        $("#save_subject").on('click', function () {
            if ($("#subjectform").valid()) {
                var obj = $("#save_subject"),
                    tId = obj.attr("id"),
                    tName = "c_save_subject",
                    tFrmId = "subjectform";
                $("#type_popup_next").val("R");
                isAuthorizedByAdmin(tName, tId, tFrmId);
            } else {
                $('#instructionModal').modal('hide');
            }
        });

        
    </script>
    <script>
    $(document).ready(function() {
        // Functionality to filter subjects based on branch and grade
        $('#branch_id, #grade_id').change(function() {
            var branchId = $('#branch_id').val();
            var gradeId = $('#grade_id').val();
            var $subjectDropdown = $('#subject_id');

            $subjectDropdown.empty().append('<option value="">Select Subject</option>');
            $('#topic_id').empty().append('<option value="">Select Topic</option>'); // Clear topics

            if (branchId && gradeId) {
                $.ajax({
                    url: 'get-subjects/' + branchId + '/' + gradeId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            $.each(data, function(index, subject) {
                                $subjectDropdown.append(
                                    '<option value="' + subject.id + '">' + subject.subject + '</option>'
                                );
                            });
                        } else {
                            $subjectDropdown.append('<option value="">No subjects found</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to fetch subjects. Error: ' + error);
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        // Functionality to filter topics based on grade and subject
        $('#grade_id, #subject_id').change(function() {
            var gradeId = $('#grade_id').val();
            var subjectId = $('#subject_id').val();
            var $topicDropdown = $('#topic_id');

            $topicDropdown.empty().append('<option value="">Select Topic</option>');

            if (gradeId && subjectId) {
                $.ajax({
                    url: 'get-topics/' + gradeId + '/' + subjectId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            $.each(data, function(index, topic) {
                                $topicDropdown.append(
                                    '<option value="' + topic.id + '">' + topic.topics + '</option>'
                                );
                            });
                        } else {
                            $topicDropdown.append('<option value="">No topics found</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to fetch topics. Error: ' + error);
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
    </script>

@endsection
@extends('admin.layouts.app')

@section('title')
    Add Topic
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
                <h4 class="pull-left page-title">Add Topic</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="{{ route('manage.topics') }}"><i class="fas fa-angle-double-left"></i> Back</a></li>
                </ol>
            </div>
        </div>

        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')
                <div class="frm_admin">
                    <form id="subjectform" method="post" action="{{ route('add.topics') }}">
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
                                    <input type="text" id="topic" name="topics" class="form-control" placeholder="Topic Title" readonly onclick="this.removeAttribute('readonly');" onfocus="this.removeAttribute('readonly');">
                                </div>
                            </div>

                        

                        <hr>
                        <h4>Session Details</h4>
                        <div id="details-container">
                            <div class="detail-row row mb-2">
                                <div class="col-md-3">
                                    <input type="text" name="details[0][topic_code]" class="form-control" placeholder="Detail Topic Code" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="details[0][session_focus]" class="form-control" placeholder="Session Focus">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="details[0][learning_outcome]" class="form-control" placeholder="Learning Outcome">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger remove-detail">X</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-detail" class="btn btn-success mt-2">+ Add Detail</button>

                        <div class="col-sm-12 mt-3">
                            <div class="ad_btn">
                                <button type="button" id="save_subject" class="btn btn-primary waves-effect waves-light w-md c_save_subject">Save</button>
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

        // Add/remove session detail rows
        let detailIndex = 1;
        $('#add-detail').on('click', function() {
            let newRow = `
            <div class="detail-row row mb-2">
                <div class="col-md-3">
                    <input type="text" name="details[${detailIndex}][topic_code]" class="form-control" placeholder="Detail Topic Code" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="details[${detailIndex}][session_focus]" class="form-control" placeholder="Session Focus">
                </div>
                <div class="col-md-4">
                    <input type="text" name="details[${detailIndex}][learning_outcome]" class="form-control" placeholder="Learning Outcome">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-detail">X</button>
                </div>
            </div>`;
            $('#details-container').append(newRow);
            detailIndex++;
        });

        $(document).on('click', '.remove-detail', function() {
            $(this).closest('.detail-row').remove();
        });
    </script>

    <script>
    $(document).ready(function() {
        $('#branch_id, #grade_id').change(function() {
            var branchId = $('#branch_id').val();
            var gradeId = $('#grade_id').val();
            var $subjectDropdown = $('#subject_id');

            $subjectDropdown.empty().append('<option value="">Select Subject</option>');

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
    });
    $(document).on('blur', '.topic-code', function() {
    var topicCode = $(this).val();
    var branchId = $('#branch_id').val();
    var gradeId = $('#grade_id').val();
    var subjectId = $('#subject_id').val();
    var detailId = $(this).closest('.detail-row').find('input[name$="[id]"]').val() || ""; 
    var inputField = $(this);
    var errorField = inputField.siblings('.error-message');
    var submitBtn = $('#submit-btn');

    if(topicCode) {
        $.ajax({
            url: "{{ route('check.topic.code') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                topic_code: topicCode,
                branch_id: branchId,
                grade_id: gradeId,
                subject_id: subjectId,
                detail_id: detailId // 👈 FIX HERE
            },
            success: function(res) {
                if(res.exists) {
                    errorField.text("Code '" + topicCode + "' already exists.").show();
                    inputField.addClass('is-invalid');
                    submitBtn.prop('disabled', true);
                } else {
                    errorField.hide();
                    inputField.removeClass('is-invalid');
                    if ($('.is-invalid').length === 0) {
                        submitBtn.prop('disabled', false);
                    }
                }
            }
        });
    }
});
    </script>
@endsection

@extends('admin.layouts.app')

@section('title')
    Edit Topics
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
                <h4 class="pull-left page-title">Edit Topics</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="{{ route('manage.topics') }}"><i class="fas fa-angle-double-left"></i> Back</a></li>
                </ol>
            </div>
        </div>

        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')
                <div class="frm_admin">

                    <form method="POST" action="{{ route('edit.topics', $topic->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- ================= MAIN TOPIC FIELDS ================= --}}
                        <div class="form-group">
                            <label for="branch_id">Branch</label>
                            <select name="branch_id" class="form-control" id="branch_id" required>
                                <option value="">Select Branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $branch->id == $topic->branch_id ? 'selected' : '' }}>
                                        {{ $branch->branch_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="grade_id">Grade</label>
                            <select name="grade_id" class="form-control" id="grade_id" required>
                                <option value="">Select Grade</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}" {{ $grade->id == $topic->grade_id ? 'selected' : '' }}>
                                        {{ $grade->grade_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="subject_id">Subject</label>
                            <select name="subject_id" class="form-control" id="subject_id" required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ $subject->id == $topic->subject_id ? 'selected' : '' }}>
                                        {{ $subject->subject }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="topics">Topic</label>
                            <input type="text" name="topics" class="form-control" value="{{ $topic->topics }}" required>
                        </div>

                        {{-- ================= TOPIC DETAILS ================= --}}
                        <h5 class="mt-4">Session Details</h5>
                        <div id="details-wrapper">
                            @foreach($topic->details as $i => $detail)
                                <div class="detail-row row mb-2">
                                    <input type="hidden" name="details[{{ $i }}][id]" value="{{ $detail->id }}">
                                    <div class="col-md-3">
                                        <input type="text"
                                               name="details[{{ $i }}][topic_det_code]"
                                               value="{{ $detail->topic_det_code }}"
                                               class="form-control topic-code"
                                               placeholder="Detail Code"
                                               required>
                                        <small class="text-danger error-message" style="display:none;"></small>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"
                                               name="details[{{ $i }}][session_focus]"
                                               value="{{ $detail->session_focus }}"
                                               class="form-control"
                                               placeholder="Session Focus">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"
                                               name="details[{{ $i }}][learning_outcome]"
                                               value="{{ $detail->learning_outcome }}"
                                               class="form-control"
                                               placeholder="Learning Outcome">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger remove-detail">X</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-sm btn-success" id="add-detail">+ Add Detail</button>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary" id="submit-btn">Update Topic</button>
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
    <script src="{{ asset('public/admin/assets/js/jquery.validate.js') }}"></script>

    <script>
        $(document).ready(function () {
            let detailIndex = {{ $topic->details->count() }};

            // Add new detail row
            $('#add-detail').click(function () {
                let html = `
                <div class="detail-row row mb-2">
                    <div class="col-md-3">
                        <input type="text" name="details[${detailIndex}][topic_det_code]" class="form-control topic-code" placeholder="Detail Code" required>
                        <small class="text-danger error-message" style="display:none;"></small>
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
                $('#details-wrapper').append(html);
                detailIndex++;
            });

            // Remove row
            $(document).on('click', '.remove-detail', function () {
                $(this).closest('.detail-row').remove();
            });

            // AJAX duplicate check
            $(document).on('blur', '.topic-code', function() {
                var topicCode = $(this).val();
                var branchId = $('#branch_id').val();
                var gradeId = $('#grade_id').val();
                var subjectId = $('#subject_id').val();
                var topicId = "{{ $topic->id }}";
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
                            topic_id: topicId
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
        });
    </script>
@endsection

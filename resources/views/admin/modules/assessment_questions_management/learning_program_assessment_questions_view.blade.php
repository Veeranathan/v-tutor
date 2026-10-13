@extends('admin.layouts.app')

@section('title')
Learning Program Assessment Questions
@endsection

@section('links')
@include('admin.includes.links')

<style>
label.error,
.backend-error {
    color: #e74c3c;
    font-size: 13px;
    margin-top: 4px;
    display: block;
}
.option-row { margin-bottom: 8px; }
.answer-options {
    display: flex;
    gap: 30px;
    align-items: center;
}
.answer-options label {
    cursor: pointer;
    font-weight: normal;
}
.blog-image-preview {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border: 1px solid #ddd;
    padding: 4px;
    border-radius: 4px;
}

.remove-image-btn {
    margin-top: 8px;
}
</style>
@endsection

@section('header')
@include('admin.includes.header')
@endsection

@section('sidebar')
@include('admin.includes.sidebar')
@endsection

@section('content')
<div class="content">
<div class="container">

<div class="row">
    <div class="col-sm-12">
        <h1 class="pull-left page-title">View / Edit Assessment Question</h1>
        <div class="pull-right">
            <a href="{{ route('learning.assessment.questions.list') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>

<div class="row">
<div class="col-md-12">
<div class="panel panel-default">

<form id="frm" enctype="multipart/form-data">
@csrf
<input type="hidden" name="question_id" value="{{ $question->id }}">

<div class="panel-heading rm02 rm04">

{{-- ROW 1 --}}
<div class="row">
    <div class="form-group col-md-4">
        <label>Assessment Form *</label>

        <select name="form_id" id="form_id" class="form-control">
            <option value="">Select Form</option>

            @foreach($forms as $form)
            <option
                value="{{ $form->id }}"
                data-type="{{ $form->assessment_type }}"
                data-sections='@json($form->sections)'
                data-passages='@json($form->passages)'
                {{ $question->form_id == $form->id ? 'selected' : '' }}>
                {{ $form->form_name }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4">
        <label>Question Type *</label>
        <select name="type" id="type" class="form-control">
            <option value="">Select</option>
            <!-- <option value="qualitative" {{ $question->type=='qualitative'?'selected':'' }}>Qualitative</option> -->
            <option value="quantitative" {{ $question->type=='quantitative'?'selected':'' }}>Quantitative</option>
        </select>
    </div>
    <div class="form-group col-md-4">
    <label>Diagnostic Assessment *</label>
    <select name="diagnostic_assessment"
            id="diagnostic_assessment"
            class="form-control">
        <option value="0"
            {{ !$question->diagnostic_assessment ? 'selected' : '' }}>
            No
        </option>

        <option value="1"
            {{ $question->diagnostic_assessment ? 'selected' : '' }}>
            Yes
        </option>
    </select>
    </div>

    <div class="form-group col-md-4" id="gradeWrapper">
    <label>Grade *</label>
    <select name="grade" id="grade" class="form-control">
        <option value="">Select Grade</option>
        @for ($i = 1; $i <= 12; $i++)
            <option value="Grade {{ $i }}"
                {{ (isset($question->grade) && $question->grade === 'Grade '.$i) ? 'selected' : '' }}>
                Grade {{ $i }}
            </option>

        @endfor
    </select>
</div>


    <div class="form-group col-md-4" id="subjectWrapper">
        <label>Subject *</label>
        <select name="subject" id="subject" class="form-control">
            <option value="">Select</option>
            <option value="english" {{ $question->subject=='english'?'selected':'' }}>English</option>
            <option value="maths" {{ $question->subject=='maths'?'selected':'' }}>Maths</option>
            <option value="science" {{ $question->subject=='science'?'selected':'' }}>Science</option>
            <option value="languages" {{ $question->subject=='languages'?'selected':'' }}>Languages</option>
            <option value="humanities and social sciences (hass)" {{ $question->subject=='humanities and social sciences (hass)'?'selected':'' }}>Humanities and Social Sciences (HASS)</option>
            <option value="technologies" {{ $question->subject=='technologies'?'selected':'' }}>Technologies</option>
        </select>
    </div>


</div>

{{-- ROW 2 --}}
<div class="row">
    <div class="form-group col-md-8">
        <label>Question *</label>
        <textarea name="question" class="form-control" rows="3">{{ $question->question }}</textarea>
    </div>

    {{-- SECTION --}}
    <div class="form-group col-md-4" id="sectionWrapper">
        <label>Section *</label>

        <select name="section" id="section" class="form-control">
            <option value="">Select Section</option>

            <option value="reading"
                {{ $question->section == 'reading' ? 'selected' : '' }}>
                Reading
            </option>

            <option value="writing"
                {{ $question->section == 'writing' ? 'selected' : '' }}>
                Writing
            </option>

            <option value="thinking"
                {{ $question->section == 'thinking' ? 'selected' : '' }}>
                Thinking
            </option>

            <option value="reasoning"
                {{ $question->section == 'reasoning' ? 'selected' : '' }}>
                Reasoning
            </option>
            <option value="logic"
                {{ $question->section == 'logic' ? 'selected' : '' }}>
                Logic
            </option>
        </select>
    </div>
    
    <div class="form-group col-md-4">
        <label>Status *</label>
        <select name="status" class="form-control">
            <option value="">Select</option>
            <option value="1" {{ $question->status ? 'selected':'' }}>Active</option>
            <option value="0" {{ !$question->status ? 'selected':'' }}>Inactive</option>
        </select>
    </div>

    <div class="form-group col-md-4">
        <label>Display Order</label>
        <input type="number" name="order" class="form-control" value="{{ $question->order }}">
    </div>
</div>

{{-- ROW 4 --}}
<div class="row">
    <div class="form-group col-md-4">
        <label>Answer Mode *</label>
        <select name="question_type" id="question_type" class="form-control">
            <option value="">Select</option>
            <option value="choose_best" {{ $question->question_type=='choose_best'?'selected':'' }}>
                Choose Best (MCQ)
            </option>
            <option value="text" {{ $question->question_type=='text'?'selected':'' }}>
                Text
            </option>
        </select>
    </div>
    {{-- PASSAGE NO --}}
    <!-- <div class="form-group col-md-4" id="passageWrapper" style="display:none;">
        <label>Passage No *</label>
        <input type="number"    name="passage_no"   id="passage_no" class="form-control"    min="1" value="{{ $question->passage_no }}">
    </div> -->
    <div class="form-group col-md-4" id="passageWrapper" style="display:none;">
    <label>Passage No *</label>

    <select name="passage_no" id="passage_no" class="form-control">
        <option value="">Select Passage</option>
    </select>
</div>
    </div>

@php $options = $question->options ?? []; @endphp

{{-- OPTIONS --}}
<div class="row" id="optionsWrapper" style="display:none;">
    <div class="col-md-8">
        <label>Options (Max 5)</label>
        @for ($i = 1; $i <= 5; $i++)
            <div class="option-row">
                <input type="text"
                       name="options[]"
                       class="form-control"
                       placeholder="Option {{ $i }}"
                       value="{{ $options[$i-1] ?? '' }}">
            </div>
        @endfor
    </div>
</div>
@php
    $options = $question->options ?? [];
    $correctIndex = null;

    if ($question->answer && is_array($options)) {
        $correctIndex = array_search($question->answer, $options, true);
        // array_search returns 0-based index
    }
@endphp

{{-- CORRECT ANSWER --}}
<div class="row" id="answerWrapper" style="display:none;">
    <div class="col-md-12">
        <label>Correct Answer *</label>
    </div>
    <div class="col-md-12">
        <div class="answer-options">
            @for ($i = 1; $i <= 5; $i++)
                <label>
                    <input type="radio"
                           name="correct_answer"
                           value="{{ $i }}"
                           {{ ($correctIndex !== null && $correctIndex === ($i - 1)) ? 'checked' : '' }}>
                    Option {{ $i }}
                </label>
            @endfor
        </div>
    </div>
</div>


{{-- MARKS --}}
<div class="row" id="marksWrapper" style="display:none; margin-top:15px;margin-bottom:30px;">
    <div class="col-md-4 mb-6">
        <label>Marks *</label>
        <input type="number"
               name="marks"
               class="form-control"
               min="0"
               value="{{ $question->question_mark }}">
    </div>
</div>

<div class="row">

    <div class="form-group col-md-4">
        <input type="hidden" name="remove_question_image" id="remove_question_image" value="0">

        <label>
            Question Image
            <span class="text-muted">(Optional)</span>
        </label>

        <input
            type="file"
            name="question_image"
            id="question_image"
            class="form-control"
            accept="image/*">

        <button
            type="button"
            class="btn btn-danger btn-sm remove-image-btn"
            id="removeImageBtn"
            onclick="removeQuestionImage()"
            {{ $question->question_image ? '' : 'style=display:none;' }}>
            Remove Image
        </button>

    </div>

    <div class="form-group col-md-4">

        <img
            id="question_preview"
            class="blog-image-preview"
            src="{{ $question->question_image ? asset('storage/assessment_question_images/'.$question->question_image) : '' }}"
            style="{{ $question->question_image ? '' : 'display:none;' }}">

    </div>

</div>

{{-- SUBMIT --}}
<div class="row">
    <div class="col-md-12 rm05">
        <button type="button" class="btn btn-primary" id="submitBtn">
            Update Question
        </button>
    </div>
</div>

</div>
</form>

<div id="successMessage" class="alert alert-success" style="display:none;"></div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script>
   function previewQuestionImage(input) {

        if (input.files && input.files[0]) {

            $('#remove_question_image').val(0);

            let reader = new FileReader();

            reader.onload = function(e){

                $('#question_preview')
                    .attr('src', e.target.result)
                    .show();

                $('#removeImageBtn').show();
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeQuestionImage() {

        $('#question_image').val('');

        $('#question_preview')
            .removeAttr('src')
            .hide();

        $('#removeImageBtn').hide();

        $('#remove_question_image').val(1);
    }
$(document).ready(function () {

    function loadPassages() {

    let passages =
        $('#form_id option:selected').data('passages');

    let dropdown =
        $('#passage_no');

    let selectedValue =
        "{{ $question->passage_no }}";

    dropdown.empty();

    dropdown.append(
        '<option value="">Select Passage</option>'
    );

    if (passages && passages.length > 0) {

        passages.forEach(function (passage) {

            let selected =
                passage.passage_no == selectedValue
                    ? 'selected'
                    : '';

            dropdown.append(
                `<option value="${passage.passage_no}" ${selected}>
                    Passage ${passage.passage_no}
                </option>`
            );
        });
    }
}

    $('#question_image').on('change', function () {
        previewQuestionImage(this);
    });

    function toggleSections() {

    let type = $('#type').val();
    let mode = $('#question_type').val();

    let isDiagnostic = $('#diagnostic_assessment').val() == '1';
    let selectedSection = $('#section').val();

    /* Grade */

    if (isDiagnostic) {

        $('#gradeWrapper').show();
        $('#subjectWrapper').hide();
        $('#sectionWrapper').show();

    } else {

        $('#gradeWrapper').hide();
        $('#grade').val('');

        $('#subjectWrapper').hide();
        $('#sectionWrapper').show();
    }

    /* Options */

    if (mode === 'choose_best') {

        $('#optionsWrapper').show();
        $('#answerWrapper').show();

    } else {

        $('#optionsWrapper').hide();
        $('#answerWrapper').hide();

        $('input[name="correct_answer"]').prop('checked', false);
    }

    /* Marks */

    if (type === 'quantitative') {

        $('#marksWrapper').show();

    } else {

        $('#marksWrapper').hide();

        $('input[name="marks"]').val('');
    }

    /* Passage */

    if (selectedSection === 'reading') {

        $('#passageWrapper').show();

    } else {

        $('#passageWrapper').hide();

        $('#passage_no').val('');
    }
    }

    // INITIAL LOAD
    toggleSections();
    loadPassages();

   $('#type, #question_type, #section').on('change', function () {
        toggleSections();
    });

    $('#form_id, #diagnostic_assessment').on('change', function () {
     toggleSections();
     loadPassages();
    });

    // VALIDATION
     $('#frm').validate({
        rules: {
            type: {
                required: true
            },

            question: {
                required: true
            },

            question_type: {
                required: true
            },

            status: {
                required: true
            },

            form_id: {
                required: true
            },

           grade: {
            required: function () {
                return $('#diagnostic_assessment').val() == '1';
            }
            },

           section: {
                required: true
            },

           subject: {
                required: false
            },

            passage_no: {
                required: function () {
                    return $('#section').val() === 'reading';
                },
            },

            correct_answer: {
                required: function () {
                    return $('#type').val() === 'quantitative' &&
                       $('#question_type').val() === 'choose_best';
                }
            },

            marks: {
                required: function () {
                    return $('#type').val() === 'quantitative';
                },
                number: true,
                min: 0
            }
        }
    });

    // SUBMIT
    $('#submitBtn').on('click', function () {

        if (!$('#frm').valid()) return;

        let btn = $(this);
        btn.prop("disabled", true).text("Updating...");

        fetch("{{ route('learning.assessment.questions.update') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: new FormData(document.getElementById('frm'))
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                $("#successMessage").text(data.message).fadeIn();
                setTimeout(() => $("#successMessage").fadeOut(), 3000);
            }
        })
        .finally(() => {
            btn.prop("disabled", false).text("Update Question");
        });
    });

});
</script>
@endsection

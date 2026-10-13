@extends('admin.layouts.app')

@section('title')
Add Assessment Question
@endsection

@section('links')
@include('admin.includes.links')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
label.error,
.backend-error {
    color: #e74c3c;
    font-size: 13px;
    margin-top: 4px;
    display: block;
}

.option-row {
    margin-bottom: 8px;
}

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
    display:none;
    width:120px;
    height:120px;
    object-fit:cover;
    border:1px solid #ddd;
    padding:4px;
    border-radius:4px;
}

.remove-image-btn{
    display:none;
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

    <!-- PAGE TITLE -->
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left page-title">Add Assessment Question</h1>
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

            <div class="panel-heading rm02 rm04">

                <!-- ROW 1 -->
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
                                data-passages='@json($form->passages)'>
                                {{ $form->form_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- QUESTION TYPE -->
                    <div class="form-group col-md-4">
                        <label>Question Type *</label>
                        <select name="type" id="type" class="form-control">
                            <option value="">Select</option>
                            <!-- <option value="qualitative">Qualitative</option> -->
                            <option value="quantitative">Quantitative</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Diagnostic Assessment *</label>
                            <select name="diagnostic_assessment" id="diagnostic_assessment" class="form-control">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>

                     <!-- GRADE -->
                    <div class="form-group col-md-4" id="gradeWrapper">
                        <label>Grade *</label>
                        <select name="grade" id="grade" class="form-control">
                        <option value="">Select Grade</option>
                        <option value="Grade 1">Grade 1</option>
                        <option value="Grade 2">Grade 2</option>
                        <option value="Grade 3">Grade 3</option>
                        <option value="Grade 4">Grade 4</option>
                        <option value="Grade 5">Grade 5</option>
                        <option value="Grade 6">Grade 6</option>
                        <option value="Grade 7">Grade 7</option>
                        <option value="Grade 8">Grade 8</option>
                        <option value="Grade 9">Grade 9</option>
                        <option value="Grade 10">Grade 10</option>
                        <option value="Grade 11">Grade 11</option>
                        <option value="Grade 12">Grade 12</option>
                        </select>
                    </div>

                    <!-- SUBJECT (conditional) -->
                    <div class="form-group col-md-4" id="subjectWrapper">
                        <label>Subject *</label>
                        <select name="subject" id="subject" class="form-control">
                            <option value="">Select</option>
                            <option value="english">English</option>
                            <option value="maths">Maths</option>
                            <option value="science">Science</option>
                            <option value="languages">Languages</option>
                            <option value="humanities and social sciences (hass)">Humanities and Social Sciences (HASS)</option>
                            <option value="technologies">Technologies</option>
                        </select>
                    </div>

                </div>

                <!-- ROW 2 -->
                <div class="row">
                    <div class="form-group col-md-8">
                        <label>Question *</label>
                        <textarea name="question" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- SECTION -->
                    <div class="form-group col-md-4" id="sectionWrapper">
                        <label>Section *</label>
                        <select name="section" id="section" class="form-control">
                            <option value="">Select Section</option>
                        </select>
                    </div>

                      <!-- STATUS  -->
                    <div class="form-group col-md-4">
                        <label>Status *</label>
                        <select name="status" class="form-control">
                            <option value="">Select</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Display Order</label>
                        <input type="number" name="order" class="form-control">
                    </div>
                </div>

                <!-- ROW 4 -->
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Answer Mode *</label>
                        <select name="question_type" id="question_type" class="form-control">
                            <option value="">Select</option>
                            <option value="choose_best">Choose Best (MCQ)</option>
                            <option value="text">Text</option>
                        </select>
                    </div>
                    <!-- PASSAGE NO -->
                <div class="form-group col-md-4" id="passageWrapper" style="display:none;">
                    <label>Passage No *</label>
                    <!-- <input  type="number"   name="passage_no"   id="passage_no" class="form-control"    min="1" placeholder="Enter Passage Number"> -->
                    <select name="passage_no" id="passage_no" class="form-control">
                        <option value="">Select Passage</option>
                    </select>
                </div>
                </div>

                <!-- OPTIONS -->
                <div class="row" id="optionsWrapper" style="display:none;">
                    <div class="col-md-8">
                        <label>Options (Max 5)</label>
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="option-row">
                                <input type="text"
                                       name="options[]"
                                       class="form-control"
                                       placeholder="Option {{ $i }}">
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- CORRECT ANSWER -->
                <div class="row" id="answerWrapper" style="display:none;">
                    <div class="col-md-12">
                        <label>Correct Answer *</label>
                    </div>
                    <div class="col-md-12">
                        <div class="answer-options">
                            @for ($i = 1; $i <= 5; $i++)
                                <label>
                                    <input type="radio" name="correct_answer" value="{{ $i }}">
                                    Option {{ $i }}
                                </label>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- MARKS -->
                <div class="row" id="marksWrapper" style="display:none; margin-top:15px;">
                    <div class="col-md-4">
                        <label>Marks *</label>
                        <input type="number" name="marks" class="form-control" min="0">
                    </div>
                </div>

                <!-- ROW 1 -->
                <div class="row">
                    <div class="form-group col-md-4 mt-2">
                    <label>Question Image   <span class="text-muted">(Optional)</span></label>

                    <input  type="file" name="question_image"   id="question_image" class="form-control"    accept="image/*"    onchange="previewQuestionImage(this)">
                    <button type="button"   class="btn btn-danger btn-sm remove-image-btn mt-1" onclick="removeQuestionImage()">Remove Image</button>
                </div>

                <div class="form-group col-md-4">
                <img    id="question_preview"   class="blog-image-preview">
                </div>
                </div>

                <!-- SUBMIT -->
                <div class="row">
                    <div class="col-md-12 rm05">
                        <button type="button" class="btn btn-primary" id="submitBtn">
                            Save Question
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
    function previewQuestionImage(input){

        if(input.files && input.files[0]){

            let reader = new FileReader();

            reader.onload = function(e){

            $('#question_preview')
                .attr('src',e.target.result)
                .show();

            $('.remove-image-btn').show();
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeQuestionImage(){

        $('#question_image').val('');

        $('#question_preview')
            .hide()
            .attr('src','');

        $('.remove-image-btn').hide();
    }
    
    $(document).ready(function () {

    function loadPassages() {

        let passages = $('#form_id option:selected').data('passages');

        let dropdown = $('#passage_no');

        dropdown.empty();

        dropdown.append(
            '<option value="">Select Passage</option>'
        );

        if (passages && passages.length) {

            passages.forEach(function(passage) {

                dropdown.append(
                    `<option value="${passage.passage_no}">
                        Passage ${passage.passage_no}
                    </option>`
                );

            });

        }

    }

    function toggleSections() {

        let type = $('#type').val();
        let mode = $('#question_type').val();

        let isDiagnostic = $('#diagnostic_assessment').val() == '1';
        let selectedSection = $('#section').val();

        /* GRADE / SUBJECT / SECTION */

        if (isDiagnostic) {

        // Diagnostic Assessment
        $('#gradeWrapper').show();
        $('#subjectWrapper').hide();
        $('#sectionWrapper').show();

    } else {

        // Normal Assessment
        $('#gradeWrapper').hide();
        $('#subjectWrapper').hide();
        $('#sectionWrapper').show();

        $('#grade').val('');

    }

    /* OPTIONS + ANSWERS */

    if (mode === 'choose_best') {

        $('#optionsWrapper').show();
        $('#answerWrapper').show();

    } else {

        $('#optionsWrapper').hide();
        $('#answerWrapper').hide();

        $('input[name="correct_answer"]').prop('checked', false);
    }

    /* MARKS */

    if (type === 'quantitative') {

        $('#marksWrapper').show();

    } else {

        $('#marksWrapper').hide();
        $('input[name="marks"]').val('');
    }

    /* PASSAGE NO */


    if (selectedSection === 'reading') {

        $('#passageWrapper').show();

    } else {

        $('#passageWrapper').hide();
        $('#passage_no').val('');

    }
}


    /* INITIAL */
    toggleSections();
    loadSections();
    loadPassages();

    /* CHANGE EVENTS */
    $('#type, #question_type, #section').on('change', function () {
        toggleSections();
    });
    $('#form_id, #diagnostic_assessment').on('change', function () {
        toggleSections();
        loadPassages();
        loadSections();
    });

    /* VALIDATION */
    $('#frm').validate({
        rules: {
            type: "required",
            status: "required",
            question: "required",
            question_type: "required",
            form_id: "required",
            grade: {
                required: function () {
                    return $('#diagnostic_assessment').val() == '1';
                }
            },
            section: {
                required: function () {
                    required: true
                }
            },
            passage_no: {
                required: function () {
                    return $('#section').val() === 'reading';
                },
            },
            subject: {
                required: false
            },
            correct_answer: {
                required: function () {
                    return $('#type').val() === 'quantitative'
                        && $('#question_type').val() === 'choose_best';
                }
            },
            marks: {
                required: function () {
                    return $('#type').val() === 'quantitative';
                },
                number: true,
                min: 0
            },
        }
    });

    $('#submitBtn').on('click', function () {

        if (!$('#frm').valid()) return;

        let btn = $(this);

        btn.prop("disabled", true).text("Saving...");

        fetch("{{ route('learning.assessment.questions.added') }}", {
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

                $('#frm')[0].reset();
                toggleSections();

                // Reset image preview
                $('#question_preview').attr('src', '').hide();
                $('.remove-image-btn').hide();
                $('#question_image').val('');

                //$('#optionsWrapper, #answerWrapper, #marksWrapper, #subjectWrapper').hide();

                setTimeout(() => {
                    $("#successMessage").fadeOut();
                }, 3000);
            }
        })
        .finally(() => {
            btn.prop("disabled", false).text("Save Question");
        });
    });

    function loadSections() {

        let sections =
            $('#form_id option:selected').data('sections');

        let sectionDropdown = $('#section');

        let selectedValue = sectionDropdown.val();

        sectionDropdown.empty();

        sectionDropdown.append(
            '<option value="">Select Section</option>'
        );

        if (sections && sections.length > 0) {

            sections.forEach(function(section) {

                let label =
                    section.charAt(0).toUpperCase() +
                    section.slice(1);

                let selected =
                    selectedValue === section
                        ? 'selected'
                        : '';

                sectionDropdown.append(
                    `<option value="${section}" ${selected}>
                        ${label}
                    </option>`
                );
            });
        }
    }
});
</script>
@endsection

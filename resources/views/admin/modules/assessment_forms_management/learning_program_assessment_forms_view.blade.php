@extends('admin.layouts.app')

@section('title')
Edit Assessment Form
@endsection

@section('links')
@include('admin.includes.links')

<style>

label.error,
label.backend-error{
    color:#e74c3c;
    font-size:13px;
    margin-top:4px;
    display:block;
}

.passage-box{
    border:1px solid #ddd;
    border-radius:6px;
    margin-bottom:20px;
    background:#fff;
    overflow:hidden;
}

.passage-header{
    padding:12px 15px;
    border-bottom:1px solid #eee;
    background:#f8f8f8;
}

.passage-body{
    padding:15px;
}

.section-checkbox label{
    margin-right:20px;
    font-weight:normal;
}

textarea{
    resize:vertical;
}

#addPassageBtn{
    margin-top:10px;
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

        <h1 class="pull-left page-title">
            Edit Assessment Form
        </h1>

        <div class="pull-right">
            <a href="{{ route('learning.assessment.forms.list') }}"
               class="btn btn-primary">
                Back
            </a>
        </div>

    </div>
</div>

<div class="row">
<div class="col-md-12">
<div class="panel panel-default">

<form id="frm">

@csrf

<input type="hidden"
       name="form_id"
       value="{{ $form->id }}">

<div class="panel-heading rm02 rm04">

    <div class="row">

        

        <div class="form-group col-md-4">

            <label>Assessment Form Type *</label>

            <select name="assessment_type"
                    class="form-control">

                <option value="">Select</option>

                @for($i = 1; $i <= 12; $i++)

                    <option value="year-{{ $i }}"
                        {{ $form->assessment_type == 'year-'.$i ? 'selected' : '' }}>
                        Year {{ $i }}
                    </option>

                @endfor

            </select>

        </div>

        <div class="form-group col-md-4">

            <label>Form Name *</label>

            <input type="text"
                   name="form_name"
                   class="form-control"
                   value="{{ $form->form_name }}">

        </div>

        <div class="form-group col-md-4">

            <label>Category *</label>

            <select name="category"
                    class="form-control">

                <option value="">Select</option>

                <option value="full_length"
                    {{ $form->category == 'full_length' ? 'selected' : '' }}>
                    Full Length
                </option>

                <option value="sectional"
                    {{ $form->category == 'sectional' ? 'selected' : '' }}>
                    Sectional
                </option>

            </select>

        </div>
        <div class="form-group col-md-4">

            <label>Diagnostic Assessment *</label>

            <select name="diagnostic_assessment" class="form-control">

            <option value="">Select</option>

            <option value="1"
                {{ $form->diagnostic_assessment == 1 ? 'selected' : '' }}>
                Yes
            </option>

            <option value="0"
                {{ $form->diagnostic_assessment == 0 ? 'selected' : '' }}>
                No
            </option>

            </select>

        </div>

    </div>

    <div class="row">

        <div class="form-group col-md-8">

            <label>Sections *</label>

            <div class="section-checkbox">

                @php
                    $sections = $form->sections ?? [];
                @endphp

                <label>
                    <input type="checkbox"
                           name="sections[]"
                           value="reading"
                           {{ in_array('reading', $sections) ? 'checked' : '' }}>
                    Reading
                </label>

                <label>
                    <input type="checkbox"
                           name="sections[]"
                           value="thinking"
                           {{ in_array('thinking', $sections) ? 'checked' : '' }}>
                    Thinking
                </label>

                <label>
                    <input type="checkbox"
                           name="sections[]"
                           value="reasoning"
                           {{ in_array('reasoning', $sections) ? 'checked' : '' }}>
                    Reasoning
                </label>

                <label>
                    <input type="checkbox"
                           name="sections[]"
                           value="writing"
                           {{ in_array('writing', $sections) ? 'checked' : '' }}>
                    Writing
                </label>

                <label>
                    <input type="checkbox"
                           name="sections[]"
                           value="logic"
                           {{ in_array('logic', $sections) ? 'checked' : '' }}>
                    Logic
                </label>

            </div>

        </div>

        <div class="form-group col-md-4">

            <label>Status *</label>

            <select name="status"
                    class="form-control">

                <option value="">Select</option>

                <option value="1"
                    {{ $form->status == 1 ? 'selected' : '' }}>
                    Active
                </option>

                <option value="0"
                    {{ $form->status == 0 ? 'selected' : '' }}>
                    Inactive
                </option>

            </select>

        </div>

        <div class="form-group col-md-12">

            <label>Description</label>

            <textarea name="description"
                      rows="3"
                      class="form-control">{{ $form->description }}</textarea>

        </div>

    </div>

    {{-- PASSAGES --}}
    <div id="passageWrapper"
         style="{{ in_array('reading', $sections) ? '' : 'display:none;' }}">

        <hr>

        <h4>Reading Passages</h4>

        <div id="passageContainer">

            @php
                $passages = $form->passages ?? [];
            @endphp

            @foreach($passages as $index => $passage)

            <div class="passage-box">

                <div class="passage-header clearfix">

                    <h4 class="pull-left">
                        Passage {{ $index + 1 }}
                    </h4>

                    <button type="button"
                            class="btn btn-danger btn-sm pull-right removePassage">
                        Remove
                    </button>

                </div>

                <div class="passage-body">

                    <div class="row">

                        <div class="form-group col-md-4">

                            <label>Passage No</label>

                            <input type="number"
                                   name="passages[{{ $index }}][passage_no]"
                                   class="form-control passage-no"
                                   value="{{ $passage['passage_no'] ?? '' }}"
                                   readonly>

                        </div>

                        <div class="form-group col-md-4">

                            <label>Question Count</label>

                            <input type="number"
                                   name="passages[{{ $index }}][question_count]"
                                   class="form-control"
                                   value="{{ $passage['question_count'] ?? '' }}">

                        </div>

                    </div>

                    <div class="form-group">

                        <label>Passage Text</label>

                        <textarea name="passages[{{ $index }}][passage_text]"
                                  rows="6"
                                  class="form-control">{{ $passage['passage_text'] ?? '' }}</textarea>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

        <button type="button"
                class="btn btn-primary"
                id="addPassageBtn">
            Add Passage
        </button>

    </div>

    <div class="row" style="margin-top:30px;">

        <div class="col-md-12 rm05">

            <button type="button"
                    class="btn btn-primary"
                    id="submitBtn">

                Update Form

            </button>

        </div>

    </div>

</div>
</form>

<div id="successMessage"
     class="alert alert-success"
     style="display:none; margin:15px;">
</div>

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

$(document).ready(function () {
    function renumberPassages() {

    $('#passageContainer .passage-box').each(function(index){

        $(this).find('.passage-header h4')
            .text('Passage ' + (index + 1));

        $(this).find('.passage-no')
            .val(index + 1)
            .attr('name', 'passages[' + index + '][passage_no]');

        $(this).find('[name$="[question_count]"]')
            .attr('name', 'passages[' + index + '][question_count]');

        $(this).find('[name$="[passage_text]"]')
            .attr('name', 'passages[' + index + '][passage_text]');
    });

    passageIndex = $('#passageContainer .passage-box').length;
    }
    function toggleAssessmentFields()
    {
        let type = $('select[name="assessment_type"]').val();

        if (type === 'general') {

            $('[name="category"]').closest('.form-group').hide();
            $('[name="sections[]"]').closest('.form-group').hide();

            $('[name="category"]').val('');

            $('[name="sections[]"]').prop('checked', false);

            $('#passageWrapper').hide();
            $('#passageContainer').html('');

        } else {

            $('[name="category"]').closest('.form-group').show();
            $('[name="sections[]"]').closest('.form-group').show();
        }
    }

    toggleAssessmentFields();

    $('select[name="assessment_type"]').change(function () {
        toggleAssessmentFields();
    });

    let passageIndex =
        {{ count($form->passages ?? []) }};

    function togglePassages()
    {
        let checked = $('input[name="sections[]"][value="reading"]').is(':checked');

        if (checked) {

            $('#passageWrapper').show();

        } else {

            $('#passageWrapper').hide();

            $('#passageContainer').html('');
        }
    }

    $('input[name="sections[]"]').change(function () {

        togglePassages();
    });

    $('#addPassageBtn').click(function () {
        passageIndex = $('#passageContainer .passage-box').length;
        let html = `

        <div class="passage-box">

            <div class="passage-header clearfix">

                <h4 class="pull-left">
                    Passage ${passageIndex + 1}
                </h4>

                <button type="button"
                        class="btn btn-danger btn-sm pull-right removePassage">
                    Remove
                </button>

            </div>

            <div class="passage-body">

                <div class="row">

                    <div class="form-group col-md-4">

                        <label>Passage No</label>

                        <input type="number"
                               name="passages[${passageIndex}][passage_no]"
                               value="${passageIndex + 1}"
                               class="form-control">

                    </div>

                    <div class="form-group col-md-4">

                        <label>Question Count</label>

                        <input type="number"
                               name="passages[${passageIndex}][question_count]"
                               class="form-control">

                    </div>

                </div>

                <div class="form-group">

                    <label>Passage Text</label>

                    <textarea
                        name="passages[${passageIndex}][passage_text]"
                        rows="6"
                        class="form-control"></textarea>

                </div>

            </div>

        </div>
        `;

        $('#passageContainer').append(html);

        passageIndex++;
    });

    $(document).on('click', '.removePassage', function () {

        $(this).closest('.passage-box').remove();
        renumberPassages();
    });

    $('#frm').validate({

    rules: {

        form_name: "required",
        assessment_type: "required",
        status: "required",
        diagnostic_assessment: "required",

        category: {
            required: function () {
                return $('select[name="assessment_type"]').val() !== 'general';
            }
        },

        'sections[]': {
            required: function () {
                return $('select[name="assessment_type"]').val() !== 'general';
            }
        }
    }
    });

    $('#submitBtn').click(function () {

        if (!$('#frm').valid()) {
            return;
        }

        $('.backend-error').remove();

        let btn = $(this);

        btn.prop('disabled', true)
           .text('Updating...');

        fetch(
            "{{ route('learning.assessment.forms.update') }}",
            {
                method: "POST",

                headers: {

                    "X-CSRF-TOKEN":
                        "{{ csrf_token() }}",

                    "Accept":
                        "application/json"
                },

                body: new FormData(
                    document.getElementById('frm')
                )
            }
        )

        .then(async res => {

            let data = await res.json();

            if (res.status === 422) {

                $.each(data.errors, function (key, value) {

                    let input =
                        $('[name="' + key + '"]');

                    if (!input.length) {

                        input =
                            $('[name="' + key + '[]"]');
                    }

                    input
                    .closest('.form-group')
                    .append(
                        '<label class="backend-error">' +
                        value[0] +
                        '</label>'
                    );
                });

                return;
            }

            if (data.success) {

                $('#successMessage')
                .text(data.message)
                .fadeIn();

                setTimeout(function () {

                    $('#successMessage').fadeOut();

                }, 3000);
            }
        })

        .finally(() => {

            btn.prop('disabled', false)
               .text('Update Form');
        });

    });

});
</script>

@endsection
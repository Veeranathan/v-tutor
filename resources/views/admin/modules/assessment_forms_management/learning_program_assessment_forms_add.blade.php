@extends('admin.layouts.app')

@section('title')
Add Assessment Form
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
            Add Assessment Form
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

<div class="panel-heading rm02 rm04">

    {{-- ROW 1 --}}
    <div class="row">

        <div class="form-group col-md-4">

            <label>Assessment Form Type *</label>

            <select name="assessment_type"
            class="form-control">

                <option value="">Select</option>
                <option value="year-1">Year 1</option>
                <option value="year-2">Year 2</option>
                <option value="year-3">Year 3</option>
                <option value="year-4">Year 4</option>
                <option value="year-5">Year 5</option>
                <option value="year-6">Year 6</option>
                <option value="year-7">Year 7</option>
                <option value="year-8">Year 8</option>
                <option value="year-9">Year 9</option>
                <option value="year-10">Year 10</option>
                <option value="year-11">Year 11</option>
                <option value="year-12">Year 12</option>

            </select>

        </div>

        <div class="form-group col-md-4">

            <label>Form Name *</label>

            <input type="text"
            name="form_name"
            class="form-control">

        </div>

        <div class="form-group col-md-4" id="categoryWrapper">

            <label>Category *</label>

            <select name="category"
            class="form-control">

                <option value="">Select</option>

                <option value="full_length">
                    Full Length
                </option>

                <option value="sectional">
                    Sectional
                </option>

            </select>

        </div>
        <div class="form-group col-md-4">
            <label>Diagnostic Assessment *</label>
                <select name="diagnostic_assessment" class="form-control">
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>

    {{-- ROW 2 --}}
    <div class="row">

        
        

        <div class="form-group col-md-8" id="sectionsWrapper">

            <label>Sections *</label>

            <div class="section-checkbox">

                <label>
                    <input type="checkbox"
                    name="sections[]"
                    value="reading">

                    Reading
                </label>

                <label>
                    <input type="checkbox"
                    name="sections[]"
                    value="thinking">

                    Thinking
                </label>

                <label>
                    <input type="checkbox"
                    name="sections[]"
                    value="reasoning">

                    Reasoning
                </label>

                <label>
                    <input type="checkbox"
                    name="sections[]"
                    value="writing">

                    Writing
                </label>

                <label>
                    <input type="checkbox"
                    name="sections[]"
                    value="logic">

                    Logic
                </label>

            </div>

        </div>

        <div class="form-group col-md-4">
            <label>Status *</label>
            <select name="status" class="form-control">
                <option value="">Select</option>
                <option value="1">
                    Active
                </option>
                <option value="0">
                    Inactive
                </option>
            </select>

        </div>

        <div class="form-group col-md-4">
            <label>Description</label>
            <textarea name="description" rows="2" class="form-control"></textarea>
        </div>

        {{-- PASSAGES --}}
        <div id="passageWrapper" style="display:none; margin-top:20px;">
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h4 style="margin-bottom:20px;">
                        Reading Passages
                    </h4>
                </div>
            </div>

            {{-- PASSAGE LIST --}}
            <div id="passageContainer"></div>
                {{-- ADD BUTTON --}}
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary" id="addPassageBtn">
                            Add Passage
                        </button>
                    </div>
                 </div>
            </div>
             {{-- SUBMIT --}}
            <div class="row" style="margin-top:30px;">
                <div class="col-md-12 rm05">
                    <button type="button" class="btn btn-primary" id="submitBtn">
                        Save Form
                     </button>
                 </div>
            </div>
        </div>
    </form>
        <div id="successMessage"    class="alert alert-success" style="display:none; margin:15px;"></div>
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

    toggleAssessmentFields();

    $('select[name="assessment_type"]').change(function () {
        toggleAssessmentFields();
    });

    function toggleAssessmentFields()
    {
        let assessmentType =
            $('select[name="assessment_type"]').val();

        if (assessmentType === 'general') {

            $('#categoryWrapper').hide();
            $('#sectionsWrapper').hide();

            $('select[name="category"]').val('');

            $('input[name="sections[]"]')
                .prop('checked', false);

            $('#passageWrapper').hide();
            $('#passageContainer').html('');

        } else {

            $('#categoryWrapper').show();
            $('#sectionsWrapper').show();
        }
    }

    let passageIndex = 0;

    /*
    |--------------------------------------------------------------------------
    | TOGGLE PASSAGES
    |--------------------------------------------------------------------------
    */

    function togglePassages()
    {
        let checked =
            $('input[value="reading"]').is(':checked');

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

    /*
    |--------------------------------------------------------------------------
    | ADD PASSAGE
    |--------------------------------------------------------------------------
    */

    $('#addPassageBtn').click(function () {

        let html = `

        <div class="passage-box">

            <div class="passage-header clearfix">

                <h4 class="pull-left"
                style="margin:0;">

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
                        class="form-control  passage-no"
                        readonly>

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

    /*
    |--------------------------------------------------------------------------
    | REMOVE PASSAGE
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '.removePassage', function () {

        $(this)
        .closest('.passage-box')
        .remove();
        renumberPassages();
    });

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

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    $('#frm').validate({

        rules: {
            form_name: "required",
            assessment_type: "required",
            diagnostic_assessment: "required",
            description: { maxlength: 1000 },
            category: {
                required: function () {
                    return $('select[name="assessment_type"]').val() !== 'general';
                }
            },

            status: "required",
        }
    });

    /*
    |--------------------------------------------------------------------------
    | SUBMIT
    |--------------------------------------------------------------------------
    */

    /*
|--------------------------------------------------------------------------
| SUBMIT
|--------------------------------------------------------------------------
*/

$('#submitBtn').click(function () {

    if (!$('#frm').valid()) {
        return;
    }

    /*
    |----------------------------------------------------------------------
    | REMOVE OLD BACKEND ERRORS
    |----------------------------------------------------------------------
    */

    $('.backend-error').remove();

    let btn = $(this);

    btn.prop('disabled', true)
    .text('Saving...');

    fetch(
        "{{ route('learning.assessment.forms.added') }}",
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

        /*
        |----------------------------------------------------------------------
        | VALIDATION ERROR
        |----------------------------------------------------------------------
        */

        if (res.status === 422) {

            $.each(data.errors, function (key, value) {

                let input =
                    $('[name="' + key + '"]');

                /*
                |------------------------------------------------------------------
                | ARRAY FIELD SUPPORT
                |------------------------------------------------------------------
                */

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

        /*
        |----------------------------------------------------------------------
        | SUCCESS
        |----------------------------------------------------------------------
        */

        if (data.success) {

            $('#successMessage')
            .text(data.message)
            .fadeIn();

            $('#frm')[0].reset();

            $('#passageContainer').html('');

            $('#passageWrapper').hide();

            setTimeout(function () {

                $('#successMessage').fadeOut();

            }, 3000);
        }
    })

    .finally(() => {

        btn.prop('disabled', false)
        .text('Save Form');
    });
});

});

</script>

@endsection
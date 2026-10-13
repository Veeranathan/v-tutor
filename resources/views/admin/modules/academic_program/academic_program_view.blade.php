@extends('admin.layouts.app')

@section('title')
Academic Program Management
@endsection

@section('links')
@include('admin.includes.links')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
.program-editor-wrapper textarea {
    width: 100% !important;
    max-width: 100% !important;
}

.program-doc-preview {
    font-size: 13px;
    margin-top: 6px;
}

.remove-doc-btn {
    margin-top: 6px;
}

label.error,
.backend-error {
    color: #e74c3c;
    font-size: 13px;
    margin-top: 4px;
    display: block;
}

.label-title {
    display: block;
}

.label-hint {
    display: block;
    font-size: 12px;
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
            <h1 class="pull-left page-title">Edit Academic Program</h1>
            <div class="rm05 backclass">
                <a href="{{ route('academic.program.list') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-md-12">
    <div class="panel panel-default">

        <form id="frm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="program_id" value="{{ $program->id }}">

            <div class="panel-heading rm02 rm04">

                <!-- ROW 1 -->
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Name *</label>
                        <input type="text" name="name" class="form-control" maxlength="50" value="{{ $program->name }}">
                    </div>

                    <!-- Program Type -->
                    <div class="form-group col-md-4">
                        <label>Program Type *</label>
                        <select name="program_type" class="form-control">
                            <option value="">Select Program Type</option>
                            <option value="Micro Learning Program" {{ $program->program_type == 'Micro Learning Program' ? 'selected' : '' }}>
                                Micro Learning Program (MLP)
                            </option>
                            <option value="Core Training Program" {{ $program->program_type == 'Core Training Program' ? 'selected' : '' }}>
                                Core Training Program (CTP)
                            </option>
                            <option value="Intensive Crash Program" {{ $program->program_type == 'Intensive Crash Program' ? 'selected' : '' }}>
                                Intensive Crash Program (ICP)
                            </option>
                            <option value="Foundation Training Program" {{ $program->program_type == 'Foundation Training Program' ? 'selected' : '' }}>
                                Foundation Training Program (FTP)
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Code *</label>
                        <input type="text" name="code" class="form-control"  maxlength="25" value="{{ $program->code }}">
                    </div>
                </div>

                <!-- ROW 2 -->
                <div class="row">
                    <!-- SUBJECT -->
                    <div class="form-group col-md-4" id="subjectWrapper">
                        <label>Subject *</label>
                        <select name="branch_id" class="form-control">
                            <option value="">Select Subject</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}"
                                {{ $program->branch_id == $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Year (Grade) *</label>
                        <select name="grade_id" class="form-control">
                            <option value="">Select Grade</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->id }}"
                                    {{ $program->grade_id == $grade->id ? 'selected' : '' }}>
                                    {{ $grade->grade_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Status *</label>
                        <select name="status" class="form-control">
                            <option value="">Select status</option>
                            <option value="1" {{ $program->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$program->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- ROW 3 -->
                <div class="row">

                    <div class="form-group col-md-4">
                        <label>Regular Price *</label>
                        <input type="number" step="0.01" name="regular_price"  id="regular_price" class="form-control" value="{{ $program->regular_price }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Discount</label>
                        <input type="number" step="0.01" name="discount" id="discount" class="form-control" value="{{ $program->discount }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Price</label>
                        <input type="number"    step="0.01" name="price"    id="price"  class="form-control"    value="{{ $program->price }}" readonly>
                    </div>
                </div>

                <!-- ROW 4 -->
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Curriculum *</label>
                        <select name="curriculum" class="form-control">
                            <option value="">Select Curriculum</option>
                            <option value="NESA Curriculum" {{ $program->curriculum == 'NESA Curriculum' ? 'selected' : '' }}>NESA Curriculum</option>
                            <option value="VCAA curriculum" {{ $program->curriculum == 'VCAA curriculum' ? 'selected' : '' }}>VCAA curriculum</option>
                            <option value="QCAA Curriculum" {{ $program->curriculum == 'QCAA Curriculum' ? 'selected' : '' }}>QCAA Curriculum</option>
                            <option value="SACE Curriculum" {{ $program->curriculum == 'SACE Curriculum' ? 'selected' : '' }}>SACE Curriculum</option>
                            <option value="WACE Curriculum" {{ $program->curriculum == 'WACE Curriculum' ? 'selected' : '' }}>WACE Curriculum</option>
                            <option value="BSSS Curriculum" {{ $program->curriculum == 'BSSS Curriculum' ? 'selected' : '' }}>BSSS Curriculum</option>
                            <option value="TASC Curriculum" {{ $program->curriculum == 'TASC Curriculum' ? 'selected' : '' }}>TASC Curriculum</option>
                            <option value="NTBS Curriculum" {{ $program->curriculum == 'NTBS Curriculum' ? 'selected' : '' }}>NTBS Curriculum</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>City *</label>
                        <select name="city" class="form-control">
                            <option value="">Select City</option>
                                @foreach(['Sydney','Melbourne','Brisbane','Adelaide','Perth','Hobart','Canberra','Darwin'] as $city)
                                <option value="{{ $city }}" {{ $program->city == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>State *</label>
                        <select name="state" class="form-control">
                        <option value="">Select State</option>
                        @foreach([
                            'New South Wales',
                            'Victoria',
                            'Queensland',
                            'South Australia',
                            'Western Australia',
                            'Tasmania',
                            'Australian Capital Territory',
                            'Northern Territory'
                        ] as $state)
                        <option value="{{ $state }}" {{ $program->state == $state ? 'selected' : '' }}>{{ $state }}</option>
                        @endforeach
                         </select>
                    </div>
                </div>

                <!-- ROW 5 -->
                <div class="row">
                    <div class="form-group col-md-12 program-editor-wrapper">
                        <label>Description *</label>
                        <textarea name="description"
                                  class="form-control"
                                  maxlength="90"
                                  rows="3">{{ $program->description }}</textarea>
                        <small class="text-muted">Maximum 90 characters</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="label-title">
                            Parent Session Plan
                            <span class="text-muted label-hint">(PDF only, max 5 MB)</span>
                        </label>

                        <input type="file" name="parent_session_plan" id="parent_session_plan" class="form-control" onchange="previewSessionPlan(this, 'parent')">

                        <button type="button"   class="btn btn-danger btn-sm remove-parent-session-plan-btn"    style="{{ $program->parent_session_plan ? '' : 'display:none;' }}"
                            onclick="removeSessionPlan('parent')">
                            Remove Document
                        </button>

                        <div id="parent_session_plan_preview" class="program-doc-preview">
                            @if($program->parent_session_plan)
                            <a href="{{ asset('storage/academic_program_docs/'.$program->parent_session_plan) }}"   download>
                                View Existing Document
                            </a>
                            @endif
                        </div>

                        <input type="hidden"    name="remove_parent_session_plan"   id="remove_parent_session_plan" value="0">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="label-title">
                            Tutor Session Plan
                            <span class="text-muted label-hint">(PDF only, max 5 MB)</span>
                        </label>
                        <input type="file"  name="tutor_session_plan"   id="tutor_session_plan" class="form-control"    onchange="previewSessionPlan(this, 'tutor')">
                        <button type="button"   class="btn btn-danger btn-sm remove-tutor-session-plan-btn"
                            style="{{ $program->tutor_session_plan ? '' : 'display:none;' }}"   onclick="removeSessionPlan('tutor')">
                            Remove Document
                        </button>

                        <div id="tutor_session_plan_preview" class="program-doc-preview">
                            @if($program->tutor_session_plan)
                                <a href="{{ asset('storage/academic_program_docs/'.$program->tutor_session_plan) }}"    download>
                                    View Existing Document
                                </a>
                            @endif
                        </div>

                        <input type="hidden"    name="remove_tutor_session_plan"    id="remove_tutor_session_plan"  value="0">
                    </div>
                </div>

                <!-- ROW 6 -->
                <div class="row">

                    <div class="form-group col-md-4">
                        <label>Validity (Days)</label>
                        <input type="number" name="validity" class="form-control" value="{{ $program->validity }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="{{ $program->display_order }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Mode of Delivery *</label>
                        <input type="text" name="mode_of_delivery"  class="form-control"    value="{{ $program->mode_of_delivery }}">
                    </div>
                </div>
                <!-- ROW 7 -->
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Number Of Sessions *</label>
                        <select name="number_of_sessions" class="form-control" data-selected="{{ $program->number_of_sessions }}">
                            <option value="">Select Session</option>
                        </select>
                    </div>

                    <!-- <div class="form-group col-md-4">
                        <label>Session Duration *</label>
                        <select name="session_duration" class="form-control">
                            <option value="">Select Session Duration</option>
                            @for($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }} hour"
                                {{ $program->session_duration == $i.' hour' ? 'selected' : '' }}>
                                {{ $i }} hour
                            </option>
                            @endfor
                        </select>
                    </div> -->

                    <div class="form-group col-md-6">
                        <label>Session Interval *</label>
                        <input type="text"  name="session_interval" class="form-control"    value="{{ $program->session_interval }}">
                    </div>

                     <div class="form-group col-md-6">
                        <label>Booking Method *</label>
                        <input type="text"  name="booking_method"   class="form-control"    value="{{ $program->booking_method }}">
                    </div>
                </div>

                <!-- ROW 8 -->
                <div class="row">

                    <div class="form-group col-md-12">
                    <label>Assessments *</label><br>
                    @php
                        $selectedAssessments = $program->assessments ?? [];
                    @endphp

                    <label>
                    <input type="checkbox" name="assessments[]" value="Diagnostic Assessment"
                        {{ in_array('Diagnostic Assessment', $selectedAssessments) ? 'checked' : '' }}>
                        Diagnostic Assessment (Beginning of Program)
                    </label><br>

                    <label>
                    <input type="checkbox" name="assessments[]" value="Micro Assessments"
                        {{ in_array('Micro Assessments', $selectedAssessments) ? 'checked' : '' }}>
                        Micro Assessments (During & After Every Session)
                    </label><br>

                    <label>
                    <input type="checkbox" name="assessments[]" value="Main Assessment"
                        {{ in_array('Main Assessment', $selectedAssessments) ? 'checked' : '' }}>
                        Main Assessment (End of Program)
                    </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Display For *</label><br>
                        <label>
                            <input type="checkbox" name="display_for[]" value="tutor"
                                {{ in_array('tutor', $program->display_for) ? 'checked' : '' }}>
                            Tutor
                        </label><br>

                        <label>
                            <input type="checkbox" name="display_for[]" value="student"
                                {{ in_array('student', $program->display_for) ? 'checked' : '' }}>
                            Student
                        </label><br>

                        <label>
                            <input type="checkbox" name="display_for[]" value="website"
                                {{ in_array('website', $program->display_for) ? 'checked' : '' }}>
                            Website
                        </label>
                    </div>

                    <div class="form-group col-md-4">
                        <label>
                            <input type="checkbox" name="popular" value="1"
                                {{ $program->popular ? 'checked' : '' }}>
                            Popular Program
                        </label>
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-md-12 program-editor-wrapper">
                        <label>Detail *</label>
                        <textarea name="program_detail"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Program Details">{{ $program->program_detail }}</textarea>
                        <small class="text-muted"></small>
                    </div>
                    <div class="form-group col-md-12 program-editor-wrapper">
                        <label>Outcome *</label>
                        <textarea name="outcome"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Program Details">{{ $program->outcome }}</textarea>
                        <small class="text-muted"></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Program Tutor *</label>
                        <input type="text"  name="program_tutor"    class="form-control"    value="{{ $program->program_tutor }}">
                    </div>

                <!-- SUBMIT -->
                <div class="row">
                    <div class="col-md-12 faqbtn rm05">
                        <button type="button" class="btn btn-primary w-md" id="submitBtn">
                            Update Academic Program
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>

<script>
$(document).ready(function () {

    $.validator.addMethod("filesize", function (value, element, param) {
        if (this.optional(element)) {
            return true;
        }

        return element.files && element.files.length > 0
            ? element.files[0].size <= param
            : true;
    }, "File size must not exceed 5 MB");

    $('#frm').validate({
        rules: {
        code: "required",
        branch_id: "required",
        grade_id: "required",
        status: "required",
        price: "required",
        curriculum: "required",
        city: "required",
        state: "required",
        program_detail: "required",
        number_of_sessions: "required",
        "assessments[]": "required",
        "display_for[]": "required",
        name: {
            required: true,
            minlength: 10,
            maxlength: 50
        },
        outcome: {
            required: true,
        },
        regular_price: {
                required: true,
                number: true,
                min: 0
            },
        discount: {
                number: true,
                min: 0,
                max: 100
            },
        code: {
                required: true,
                maxlength: 25
        },
        description: {
            required: true,
            minlength: 45,
            maxlength: 90
        },
        parent_session_plan: {
            extension: "pdf",
            filesize: 5242880
        },

        tutor_session_plan: {
            extension: "pdf",
            filesize: 5242880
        }
        },
        messages: {
             code: {
                maxlength: "Program code must not exceed 25 characters"
            },
           name: {
                minlength: "Program name must be at least 30 characters",
                maxlength: "Program name must not exceed 50 characters"
            },
            description: {
                minlength: "Description must be at least 45 characters",
                maxlength: "Description must not exceed 0 characters"
            },
            parent_session_plan: {
                extension: "Only PDF files are allowed",
                filesize: "PDF file size must not exceed 5 MB"
            },

            tutor_session_plan: {
                extension: "Only PDF files are allowed",
                filesize: "PDF file size must not exceed 5 MB"
            }
        }
    });

    $("#submitBtn").on("click", function () {

        if (!$('#frm').valid()) return;

        $(".backend-error").remove();

        let btn = $(this);
        btn.prop("disabled", true).html(
            `<span class="spinner-border spinner-border-sm"></span> Updating...`
        );

        fetch("{{ route('update.academic.program') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: new FormData(document.getElementById("frm"))
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                $("#successMessage").text(data.message).fadeIn();
                setTimeout(() => $("#successMessage").fadeOut(), 3000);
            } else if (data.errors) {
                $.each(data.errors, function (field, messages) {
                    $('[name="'+field+'"]').after(
                        `<label class="error backend-error">${messages[0]}</label>`
                    );
                });
            }
        })
        .catch(() => alert("Something went wrong"))
        .finally(() => {
            btn.prop("disabled", false).text("Update Academic Program");
        });
    });
});

/* DOCUMENT PREVIEW */
function previewSessionPlan(input, type) {

    if (input.files && input.files[0]) {

        if (type === 'parent') {

            $('#remove_parent_session_plan').val('0');

            $('#parent_session_plan_preview')
                .text(input.files[0].name)
                .show();

            $('.remove-parent-session-plan-btn').show();

        } else if (type === 'tutor') {

            $('#remove_tutor_session_plan').val('0');

            $('#tutor_session_plan_preview')
                .text(input.files[0].name)
                .show();

            $('.remove-tutor-session-plan-btn').show();
        }
    }
}

function removeSessionPlan(type) {

    if (type === 'parent') {

        $('#parent_session_plan').val('');

        $('#parent_session_plan_preview')
            .hide()
            .text('');

        $('#remove_parent_session_plan').val('1');

        $('.remove-parent-session-plan-btn').hide();

    } else if (type === 'tutor') {

        $('#tutor_session_plan').val('');

        $('#tutor_session_plan_preview')
            .hide()
            .text('');

        $('#remove_tutor_session_plan').val('1');

        $('.remove-tutor-session-plan-btn').hide();
    }
}
function calculatePrice() {
    let regularPrice = parseFloat($('#regular_price').val());
    let discount = parseFloat($('#discount').val());

    if (isNaN(regularPrice) || regularPrice <= 0) {
        $('#price').val('');
        return;
    }

    if (!isNaN(discount) && discount > 0) {
        let discountAmount = (regularPrice * discount) / 100;
        let finalPrice = regularPrice - discountAmount;
        $('#price').val(finalPrice.toFixed(2));
    } else {
        $('#price').val(regularPrice.toFixed(2));
    }
}

$('#regular_price, #discount').on('input', calculatePrice);
$(document).ready(function () {
    calculatePrice();
});

function updateSessionsDropdown() {
    let programType = $('select[name="program_type"]').val();
    let sessionDropdown = $('select[name="number_of_sessions"]');
    
    // Check if user already changed it, otherwise fallback to DB record from Blade or data attribute
    let selectedValue = sessionDropdown.val() || sessionDropdown.attr('data-selected') || "{{ $program->number_of_sessions }}";

    sessionDropdown.empty();
    sessionDropdown.append('<option value="">Select Session</option>');

    const ranges = {
        "Micro Learning Program": [3, 5],        // MLP: 3 to 5
        "Core Training Program": [8, 15],       // CTP: 8 to 15
        "Foundation Training Program": [5, 10], // FTP: 5 to 10
        "Intensive Crash Program": [5, 5]       // ICP: 5
    };

    if (ranges[programType]) {
        let [min, max] = ranges[programType];
        for (let i = min; i <= max; i++) {
            sessionDropdown.append(`<option value="${i}">${i}</option>`);
        }
    }

    // Restore selected value
    sessionDropdown.val(selectedValue);
}

// Event bindings
$(document).ready(function () {
    $('select[name="program_type"]').on('change', function () {
        // Clear stored data attribute when user changes program type manually
        $('select[name="number_of_sessions"]').removeAttr('data-selected');
        updateSessionsDropdown();
    });

    // Run on initial page load
    updateSessionsDropdown();
});

$('select[name="program_type"]').on('change', function () {
    updateSessionsDropdown();
});

$(document).ready(function () {
    updateSessionsDropdown();
});
</script>
@endsection

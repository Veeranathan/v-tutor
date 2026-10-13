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
    display: none;
    font-size: 13px;
    margin-top: 6px;
}

.remove-doc-btn {
    display: none;
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

.remove-parent-session-plan-btn,
.remove-tutor-session-plan-btn {
    display: none;
    margin-top: 6px;
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
            <h1 class="pull-left page-title">Add Academic Program</h1>
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

            <div class="panel-heading rm02 rm04">

                <!-- ROW 1 -->
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Name *</label>
                        <input type="text" name="name" placeholder="Program Name" maxlength="50" class="form-control">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Program Type</label>
                        <select name="program_type" class="form-control">
                            <option value="">Select Program Type</option>
                            <option value="Micro Learning Program">Micro Learning Program (MLP)</option>
                            <option value="Core Training Program">Core Training Program (CTP)</option>
                            <option value="Intensive Crash Program">Intensive Crash Program (ICP)</option>
                            <option value="Foundation Training Program">Foundation Training Program (FTP)</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Code *</label>
                        <input type="text" name="code" class="form-control"  maxlength="25" placeholder="CTP-NSW-ENG-HSC-MAP01">
                    </div>                
                                                            
                </div>

                <!-- ROW 2 -->
                <div class="row">
                    <!-- SUBJECT -->
                    <div class="form-group col-md-4">
                        <label>Subject *</label>
                        <select name="branch_id" id="subject"  class="form-control">
                            <option value="">Select Subject</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">
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
                            <option value="{{ $grade->id }}">
                            {{ $grade->grade_name }}
                            </option>
                            @endforeach
                        </select>

                    </div>

                    <div class="form-group col-md-4">
                        <label>Status *</label>
                        <select name="status" class="form-control">
                            <option value="">Select status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- ROW 3 -->
                <div class="row">

                    <div class="form-group col-md-4">
                        <label>Regular Price *</label>
                        <input type="number" step="0.01" name="regular_price" id="regular_price" class="form-control">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Discount</label>
                        <input type="number"    step="0.01" name="discount" id="discount"   class="form-control">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Price</label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control" readonly>
                    </div>

                </div>

                <!-- ROW 4 -->
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Curriculum *</label>
                        <select name="curriculum" class="form-control">
                            <option value="">Select Curriculum</option>
                            <option value="NESA Curriculum">NESA Curriculum</option>
                            <option value="VCAA curriculum">VCAA curriculum</option>
                            <option value="QCAA Curriculum">QCAA Curriculum</option>
                            <option value="SACE Curriculum">SACE Curriculum</option>
                            <option value="WACE Curriculum">WACE Curriculum</option>
                            <option value="BSSS Curriculum">BSSS Curriculum</option>
                            <option value="TASC Curriculum">TASC Curriculum</option>
                            <option value="NTBS Curriculum">NTBS Curriculum</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>City *</label>
                        <select name="city" class="form-control">
                            <option value="">Select City</option>
                            <option value="Sydney">Sydney</option>
                            <option value="Melbourne">Melbourne</option>
                            <option value="Brisbane">Brisbane</option>
                            <option value="Adelaide">Adelaide</option>
                            <option value="Perth">Perth</option>
                            <option value="Hobart">Hobart</option>
                            <option value="Canberra">Canberra</option>
                            <option value="Darwin">Darwin</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>State *</label>
                        <select name="state" class="form-control">
                            <option value="">Select State</option>
                            <option value="New South Wales">New South Wales</option>
                            <option value="Victoria">Victoria</option>
                            <option value="Queensland">Queensland</option>
                            <option value="South Australia">South Australia</option>
                            <option value="Western Australia">Western Australia</option>
                            <option value="Tasmania">Tasmania</option>
                            <option value="Australian Capital Territory">Australian Capital Territory</option>
                            <option value="Northern Territory">Northern Territory</option>
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
                                  rows="3"
                                  placeholder="Max 90 characters"></textarea>
                        <small class="text-muted">Maximum 90 characters</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="label-title">
                            Parent Session Plan
                            <span class="text-muted label-hint">(PDF only, max 5 MB)</span>
                        </label>

                        <input type="file" name="parent_session_plan" id="parent_session_plan" class="form-control" onchange="previewSessionPlan(this, 'parent')">

                        <button type="button"   class="btn btn-danger btn-sm remove-parent-session-plan-btn"    onclick="removeSessionPlan('parent')">
                            Remove Document
                        </button>

                        <div id="parent_session_plan_preview" class="program-doc-preview"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="label-title">
                            Tutor Session Plan
                            <span class="text-muted label-hint">(PDF only, max 5 MB)</span>
                        </label>

                        <input type="file"  name="tutor_session_plan"   id="tutor_session_plan" class="form-control"    onchange="previewSessionPlan(this, 'tutor')">

                        <button type="button"   class="btn btn-danger btn-sm remove-tutor-session-plan-btn" onclick="removeSessionPlan('tutor')">
                            Remove Document
                        </button>

                        <div id="tutor_session_plan_preview"    class="program-doc-preview"></div>
                    </div>
                    </div>

                <!-- ROW 6 -->
                <div class="row">
                     <div class="form-group col-md-4">
                        <label>Validity (Days)</label>
                        <input type="number" name="validity" class="form-control">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Display Order</label>
                        <input type="number" name="display_order" class="form-control">
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label>Mode of Delivery</label>
                        <input type="text" name="mode_of_delivery" class="form-control" placeholder="Online via Zoom">
                    </div>
 
                </div>

                <!-- ROW 7 -->
                <div class="row">
                    <!-- Program Duration -->
                    <div class="form-group col-md-4">
                        <label>Number Of Sessions</label>
                        <select name="number_of_sessions" class="form-control">
                            <option value="">Select Session</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                        </select>
                    </div>

                    <!-- Session Duration -->
                    <!-- <div class="form-group col-md-4">
                        <label>Session Duration</label>
                        <select name="session_duration" class="form-control">
                            <option value="">Select Session Duration</option>
                            @for($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }} hour">{{ $i }} hour</option>
                            @endfor
                        </select>
                    </div> -->

                    <div class="form-group col-md-6">
                        <label>Session Interval</label>
                        <input type="text" name="session_interval" class="form-control" placeholder="No minimum frequency between sessions. Booking can be made with any intervals.">
                    </div>

                     <div class="form-group col-md-6">
                        <label>Booking Method</label>
                        <input type="text" name="booking_method" class="form-control" placeholder="Self-booking or assisted booking (extra charges apply)">
                    </div>

                </div>
                <!-- ROW 8 -->
                <div class="row">

                    <div class="form-group col-md-12">
                        <label>Assessments</label><br>
                        <label>
                        <input type="checkbox" name="assessments[]" value="Diagnostic Assessment">
                            Diagnostic Assessment (Beginning of Program)
                        </label><br>

                        <label>
                        <input type="checkbox" name="assessments[]" value="Micro Assessments">
                            Micro Assessments (During & After Every Session)
                        </label><br>
                        <label>
                        <input type="checkbox" name="assessments[]" value="Main Assessment">
                             Main Assessment (End of Program)
                        </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Display For *</label><br>
                        <label><input type="checkbox" name="display_for[]" value="tutor"> Tutor</label><br>
                        <label><input type="checkbox" name="display_for[]" value="student"> Student</label><br>
                        <label><input type="checkbox" name="display_for[]" value="website"> Website</label>
                    </div>

                    <div class="form-group col-md-4">
                        <label>
                            <input type="checkbox" name="popular" value="1">  Popular Program
                        </label>
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-md-12 program-editor-wrapper">
                        <label>Detail *</label>
                        <textarea name="program_detail"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Program Details"></textarea>
                        <small class="text-muted"></small>
                    </div>

                    <div class="form-group col-md-12 program-editor-wrapper">
                        <label>Outcome *</label>
                        <textarea name="outcome"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Outcome"></textarea>
                        <small class="text-muted"></small>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Program Tutor</label>
                        <input type="text" name="program_tutor" class="form-control"    placeholder="To be assigned at the start of the program">
                    </div> 

                <!-- SUBMIT -->
                <div class="row">
                    <div class="col-md-12 faqbtn rm05">
                        <button type="button" class="btn btn-primary w-md" id="submitBtn">
                            Add Academic Program
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
$.validator.addMethod(
    "filesize",
    function (value, element, param) {
        if (element.files.length === 0) return true;
        return element.files[0].size <= param;
    },
    "File size must not exceed 5 MB"
);

$(document).ready(function () {

    $('#frm').validate({
        rules: {
            subject: "required",
            year: "required",
            display_order: "required",
            price: "required",
            validity: "required",
            curriculum: "required",
            city: "required",
            state: "required",
            status: "required",
            curriculum: "required",
            city: "required",
            state: "required",
            program_detail: "required",
            program_type: "required",
            number_of_sessions: "required",
            session_duration: "required",
            session_interval: "required",
            mode_of_delivery: "required",
            program_tutor: "required",
            booking_method: "required",
            "assessments[]": "required",
            "display_for[]": "required",
            name: {
                required: true,
                minlength: 10,
                maxlength: 40
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
            parent_session_plan: {
                extension: "Only PDF files are allowed",
                filesize: "PDF file size must not exceed 5 MB"
            },

            tutor_session_plan: {
                extension: "Only PDF files are allowed",
                filesize: "PDF file size must not exceed 5 MB"
            },
            name: {
                minlength: "Program name must be at least 30 characters",
                maxlength: "Program name must not exceed 50 characters"
            },
            description: {
                minlength: "Description must be at least 45 characters",
                maxlength: "Description must not exceed 90 characters"
            },
             code: {
                maxlength: "Program code must not exceed 25 characters"
             }
        }
    });

    $("#submitBtn").on("click", function () {

        if (!$('#frm').valid()) return;

        $(".backend-error").remove();

        let btn = $(this);
        btn.prop("disabled", true).html(
            `<span class="spinner-border spinner-border-sm"></span> Saving...`
        );

        fetch("{{ route('academic.program.added') }}", {
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
                $('#frm')[0].reset();
                // removeProgramDoc();
                removeSessionPlan('parent');
                removeSessionPlan('tutor');

                $('#frm').validate().resetForm();
                $('#frm .error').removeClass('error');

            } else if (data.errors) {
                $.each(data.errors, function (field, messages) {
                    let input = $('[name="' + field + '"]');
                    if (input.length) {
                        input.after(
                            `<label class="error backend-error">${messages[0]}</label>`
                        );
                    }
                });
            }
        })
        .catch(() => alert("Something went wrong"))
        .finally(() => {
            btn.prop("disabled", false).text("Add Academic Program");
        });
    });

    function updateSessionsDropdown() {
    let programType = $('select[name="program_type"]').val();
    let sessionDropdown = $('select[name="number_of_sessions"]');

    // Store the currently selected value so we can preserve it if it exists in the new options
    let currentValue = sessionDropdown.val();

    sessionDropdown.empty();
    sessionDropdown.append('<option value="">Select Session</option>');

    let min = 0, max = 0;

    if (programType === "Micro Learning Program") {
        min = 3; max = 5;       // MLP: 3 to 5
    } else if (programType === "Core Training Program") {
        min = 8; max = 15;      // CTP: 8 to 15
    } else if (programType === "Foundation Training Program") {
        min = 5; max = 10;      // FTP: 5 to 10
    } else if (programType === "Intensive Crash Program") {
        min = 5; max = 5;
    }

    // Populate options dynamically based on min and max
    if (min > 0 && max > 0) {
        for (let i = min; i <= max; i++) {
            sessionDropdown.append(`<option value="${i}">${i}</option>`);
        }
    }

    // Restore selected value if it's still valid for the selected program type
    if (currentValue) {
        sessionDropdown.val(currentValue);
    }
}

// on change
$('select[name="program_type"]').on('change', function () {
    updateSessionsDropdown();
});

//  on page load
updateSessionsDropdown();

});

function previewSessionPlan(input, type) {
    if (input.files && input.files[0]) {

        if (type === 'parent') {
            $('#parent_session_plan_preview')
                .text(input.files[0].name)
                .show();

            $('.remove-parent-session-plan-btn').show();

            $('#parent_session_plan').valid();

        } else if (type === 'tutor') {
            $('#tutor_session_plan_preview')
                .text(input.files[0].name)
                .show();

            $('.remove-tutor-session-plan-btn').show();

            $('#tutor_session_plan').valid();
        }
    }
}

function removeSessionPlan(type) {

    if (type === 'parent') {

        $('#parent_session_plan').val('');

        $('#parent_session_plan_preview')
            .hide()
            .text('');

        $('.remove-parent-session-plan-btn').hide();

        $('#parent_session_plan').valid();

    } else if (type === 'tutor') {

        $('#tutor_session_plan').val('');

        $('#tutor_session_plan_preview')
            .hide()
            .text('');

        $('.remove-tutor-session-plan-btn').hide();

        $('#tutor_session_plan').valid();
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
</script>
@endsection

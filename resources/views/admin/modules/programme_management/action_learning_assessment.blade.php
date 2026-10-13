@extends('admin.layouts.app')

@section('title')
Action Learning Assessment
@endsection

@section('links')
@include('admin.includes.links')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- TinyMCE Editor JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.2/tinymce.min.js"></script>
@endsection

@section('header')
@include('admin.includes.header')
@endsection

@section('sidebar')
@include('admin.includes.sidebar')
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">

        <!-- Title & Navigation -->
        <div class="row mb-3">
            <div class="col-sm-12 d-flex justify-content-between align-items-center">
                <h1 class="page-title pull-left">Action Learning Program</h1>
                <div class="rm05 backclass pull-right">
                    <a href="{{ route('manage.learning.assessments') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Main Container Panel -->
                <div class="panel panel-default assessment-card">
                    <div class="panel-body">

                        <form id="frm">
                            @csrf
                            <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                            <h3 class="section-heading mb-4">Academic Feedback & Learning Recommendations</h3>

                            <!-- SECTION 1: ASSESSMENT SUMMARY (SINGLE ROW) -->
                            <div class="row align-items-end">

                                <!-- 1. Status -->
                                <div class="form-group col-md-3 mb-0">
                                    <label class="font-weight-bold">Status</label>
                                    <select class="form-control" disabled>
                                        <option>{{ ucfirst($assessment->status) }}</option>
                                    </select>
                                </div>

                                <!-- 2. Assessment Result -->
                                <div class="form-group col-md-3 mb-0">
                                    <label class="font-weight-bold">Assessment Result</label>
                                    <div>
                                    @if($assessment->status === 'completed')
                                        <a href="{{ route('learning.assessment.download.result', $assessment->id) }}"
                                            class="btn btn-success btn-block text-truncate">
                                            <i class="fa fa-download"></i> Download Result
                                        </a>
                                    @else
                                        <button class="btn btn-default btn-block" disabled>Not Available</button>
                                    @endif
                                    </div>
                                </div>

                                <!-- 3. Send Reminder -->
                                <div class="form-group col-md-3 mb-0">
                                    <label class="d-none d-md-block">&nbsp;</label>
                                    <button type="button" id="sendEmailBtn" class="btn btn-primary btn-block mt-0" 
                                        {{ ($assessment->visit_reason !== 'free_assessment' || $assessment->status === 'completed') ? 'disabled' : '' }}>
                                        Send Reminder
                                    </button>
                                </div>

                                <!-- 4. Send Report -->
                                <!-- <div class="form-group col-md-3 mb-0">
                                    <label class="d-none d-md-block">&nbsp;</label>
                                    <button type="button" id="sendReportBtn" class="btn btn-info btn-block mt-0" 
                                        {{ isset($suggestion) && $suggestion->id ? '' : 'disabled' }}>
                                        <i class="fa fa-envelope"></i> Send Report
                                    </button>
                                </div> -->
                                <!-- 4. Suggestion Report Split Button Dropdown -->
                                <div class="form-group col-md-3 mb-0">
                                    <label class="d-none d-md-block">&nbsp;</label>
                                    <div class="btn-group btn-block">
                                    <!-- Main Button -->
                                    <button type="button" class="btn btn-info dropdown-toggle-split-main" {{ isset($suggestion) && $suggestion->id ? '' : 'disabled' }}>
                                        <i class="fa fa-file-text-o"></i> Review Report
                                    </button>
                                    <!-- Dropdown Toggle Caret -->
                                    <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" {{ isset($suggestion) && $suggestion->id ? '' : 'disabled' }}>
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <!-- Dropdown Menu Options -->
                                    <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                    <a href="{{ isset($suggestion) && $suggestion->id ? route('learning.assessment.view.report', $assessment->id) : '#' }}" target="_blank" id="viewReportLink">
                                        <i class="fa fa-eye"></i> View Report
                                     </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                    <a href="#" id="sendReportBtn">
                                        <i class="fa fa-envelope"></i> Send Report
                                    </a>
                                    </li>
                                </ul>
                                </div>
                            </div>

                            </div>
                        </form>

                        <!-- Alert Message for Email Actions -->
                        <div id="successMessage" class="alert alert-success mt-3" style="display:none;"></div>

                        <hr class="my-4">

                        <!-- SECTION 2: ASSESSMENT SUGGESTION -->
                        <div class="mt-4">
                            <h3 class="section-heading mb-4">Academic Feedback & Learning Recommendations Form</h3>

                            <form id="suggestionForm" novalidate>
                                @csrf
                                <input type="hidden" name="learning_program_assessment_id" value="{{ $assessment->id }}">
                                <input type="hidden" name="student_id" value="{{ $assessment->student_id ?? '' }}">

                                <!-- SUBHEADING: Feedback -->
                                <h5 class="subheading text-primary font-weight-bold mb-3"><i class="fa fa-comments"></i> Feedback</h5>

                                <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold">Performance Comment <span class="text-danger">*</span></label>
                                    <select name="performance_comment" class="form-control" required>
                                        <option value="">Select Performance Comment</option>
                                        @foreach(\App\Models\AssessmentSuggestion::PERFORMANCE_COMMENT_OPTIONS as $key => $label)
                                        <option value="{{ $key }}" {{ (isset($suggestion) && $suggestion->performance_comment === $key) ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- TinyMCE Applied Field -->
                                    <div class="form-group col-md-8 blog-editor-wrapper">
                                        <label class="font-weight-bold">Advisor Summary Report <span class="text-danger">*</span></label>
                                        <textarea name="advisor_summary_report" class="form-control advisor_desc" rows="5" 
                                            placeholder="Enter advisor summary report" required>{{ old('advisor_summary_report', $suggestion->advisor_summary_report ?? '') }}</textarea>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- SUBHEADING: Strengths -->
                                <h5 class="subheading text-primary font-weight-bold mb-3"><i class="fa fa-star"></i> Strengths</h5>
                                
                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <label class="font-weight-bold">Key Strengths <span class="text-danger">*</span></label>
                                        <select name="key_strengths[]" class="form-control select2" multiple="multiple" required>
                                            @foreach(\App\Models\AssessmentSuggestion::KEY_STRENGTHS_OPTIONS as $option)
                                                <option value="{{ $option }}" 
                                                    {{ (isset($suggestion) && is_array($suggestion->key_strengths) && in_array($option, $suggestion->key_strengths)) ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="font-weight-bold">Additional Strength</label>
                                        <input type="text" name="additional_strength" class="form-control" 
                                               value="{{ old('additional_strength', $suggestion->additional_strength ?? '') }}" 
                                               placeholder="Optional additional strength">
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- SUBHEADING: Opportunities -->
                                <h5 class="subheading text-primary font-weight-bold mb-3"><i class="fa fa-line-chart"></i> Opportunities</h5>
                                
                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <label class="font-weight-bold">Learning Opportunities <span class="text-danger">*</span></label>
                                        <select name="learning_opportunities[]" class="form-control select2" multiple="multiple" required>
                                            @foreach(\App\Models\AssessmentSuggestion::LEARNING_OPPORTUNITIES_OPTIONS as $option)
                                                <option value="{{ $option }}" 
                                                    {{ (isset($suggestion) && is_array($suggestion->learning_opportunities) && in_array($option, $suggestion->learning_opportunities)) ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="font-weight-bold">Additional Opportunity</label>
                                        <input type="text" name="additional_opportunity" class="form-control" 
                                               value="{{ old('additional_opportunity', $suggestion->additional_opportunity ?? '') }}" 
                                               placeholder="Optional additional opportunity">
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- SUBHEADING: Assessment Validation and Insights -->
                                <h5 class="subheading text-primary font-weight-bold mb-3"><i class="fa fa-check-circle"></i> Assessment Validation and Insights</h5>
                                
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="font-weight-bold">Quantitative Status <span class="text-danger">*</span></label>
                                        <select name="quantitative_status" class="form-control" required>
                                            <option value="">Select Status</option>
                                            @foreach(\App\Models\AssessmentSuggestion::QUANTITATIVE_STATUS_OPTIONS as $key => $label)
                                                <option value="{{ $key }}" {{ (isset($suggestion) && $suggestion->quantitative_status === $key) ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="font-weight-bold">Quantitative Statement <span class="text-danger">*</span></label>
                                        <select name="quantitative_statement" class="form-control" required>
                                            <option value="">Select Statement</option>
                                            @foreach(\App\Models\AssessmentSuggestion::QUANTITATIVE_STATEMENT_OPTIONS as $option)
                                                <option value="{{ $option }}" {{ (isset($suggestion) && $suggestion->quantitative_statement === $option) ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="font-weight-bold">Qualitative Status <span class="text-danger">*</span></label>
                                        <select name="qualitative_status" class="form-control" required>
                                            <option value="">Select Status</option>
                                            @foreach(\App\Models\AssessmentSuggestion::QUALITATIVE_STATUS_OPTIONS as $key => $label)
                                                <option value="{{ $key }}" {{ (isset($suggestion) && $suggestion->qualitative_status === $key) ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="font-weight-bold">Qualitative Statement <span class="text-danger">*</span></label>
                                        <select name="qualitative_statement" class="form-control" required>
                                            <option value="">Select Statement</option>
                                            @foreach(\App\Models\AssessmentSuggestion::QUALITATIVE_STATEMENT_OPTIONS as $option)
                                                <option value="{{ $option }}" {{ (isset($suggestion) && $suggestion->qualitative_statement === $option) ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="font-weight-bold">Quantitative Assessment Summary</label>
                                        <textarea name="quantitative_assessment_summary" class="form-control" rows="2" 
                                                  placeholder="Enter quantitative assessment summary">{{ old('quantitative_assessment_summary', $suggestion->quantitative_assessment_summary ?? '') }}</textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="font-weight-bold">Qualitative Responses Summary</label>
                                        <textarea name="qualitative_responses_summary" class="form-control" rows="2" 
                                                  placeholder="Enter qualitative responses summary">{{ old('qualitative_responses_summary', $suggestion->qualitative_responses_summary ?? '') }}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="font-weight-bold">Overall Alignment <span class="text-danger">*</span></label>
                                        <select name="overall_alignment" class="form-control" required>
                                            <option value="">Select Alignment</option>
                                            @foreach(\App\Models\AssessmentSuggestion::OVERALL_ALIGNMENT_OPTIONS as $option)
                                                <option value="{{ $option }}" {{ (isset($suggestion) && $suggestion->overall_alignment === $option) ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="font-weight-bold">Alignment Summary <span class="text-danger">*</span></label>
                                        <input type="text" name="alignment_summary" class="form-control" 
                                               value="{{ old('alignment_summary', $suggestion->alignment_summary ?? '') }}" 
                                               placeholder="Enter alignment summary" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="font-weight-bold">Additional Notes</label>
                                        <input type="text" name="additional_notes" class="form-control" 
                                               value="{{ old('additional_notes', $suggestion->additional_notes ?? '') }}" 
                                               placeholder="Optional notes">
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- SUBHEADING: Learning Gap Summary -->
                                <h5 class="subheading text-primary font-weight-bold mb-3"><i class="fa fa-bar-chart"></i> Learning Gap Summary</h5>
                                
                                <div class="row">
                                    <div class="form-group col-md-2-4 col-sm-4">
                                        <label class="font-weight-bold">Reading <span class="text-danger">*</span></label>
                                        <select name="reading" class="form-control" required>
                                            <option value="">Select Rating</option>
                                            @foreach(\App\Models\AssessmentSuggestion::PERFORMANCE_RATING_OPTIONS as $key => $label)
                                                <option value="{{ $key }}" {{ (isset($suggestion) && $suggestion->reading === $key) ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2-4 col-sm-4">
                                        <label class="font-weight-bold">Reasoning <span class="text-danger">*</span></label>
                                        <select name="reasoning" class="form-control" required>
                                            <option value="">Select Rating</option>
                                            @foreach(\App\Models\AssessmentSuggestion::PERFORMANCE_RATING_OPTIONS as $key => $label)
                                                <option value="{{ $key }}" {{ (isset($suggestion) && $suggestion->reasoning === $key) ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2-4 col-sm-4">
                                        <label class="font-weight-bold">Thinking <span class="text-danger">*</span></label>
                                        <select name="thinking" class="form-control" required>
                                            <option value="">Select Rating</option>
                                            @foreach(\App\Models\AssessmentSuggestion::PERFORMANCE_RATING_OPTIONS as $key => $label)
                                                <option value="{{ $key }}" {{ (isset($suggestion) && $suggestion->thinking === $key) ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2-4 col-sm-4">
                                        <label class="font-weight-bold">Logic <span class="text-danger">*</span></label>
                                        <select name="logic" class="form-control" required>
                                            <option value="">Select Rating</option>
                                            @foreach(\App\Models\AssessmentSuggestion::PERFORMANCE_RATING_OPTIONS as $key => $label)
                                                <option value="{{ $key }}" {{ (isset($suggestion) && $suggestion->logic === $key) ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2-4 col-sm-4">
                                        <label class="font-weight-bold">Writing <span class="text-danger">*</span></label>
                                        <select name="writing" class="form-control" required>
                                            <option value="">Select Rating</option>
                                            @foreach(\App\Models\AssessmentSuggestion::PERFORMANCE_RATING_OPTIONS as $key => $label)
                                                <option value="{{ $key }}" {{ (isset($suggestion) && $suggestion->writing === $key) ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- SUBHEADING: Recommended -->
                                <h5 class="subheading text-primary font-weight-bold mb-3"><i class="fa fa-bullseye"></i> Recommended</h5>
                                
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="font-weight-bold">Recommended Learning Priorities <small class="text-muted">(Max 4)</small> <span class="text-danger">*</span></label>
                                        <select name="recommended_learning_priorities[]" id="recommended_priorities" class="form-control select2" multiple="multiple" required>
                                            @foreach(\App\Models\AssessmentSuggestion::RECOMMENDED_PRIORITIES_OPTIONS as $option)
                                                <option value="{{ $option }}" 
                                                    {{ (isset($suggestion) && is_array($suggestion->recommended_learning_priorities) && in_array($option, $suggestion->recommended_learning_priorities)) ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- SUBHEADING: Recommended Programs -->
                                <h5 class="subheading text-primary font-weight-bold mb-3"><i class="fa fa-graduation-cap"></i> Recommended Programs</h5>
                                
                                <div class="row">
                                    <!-- Primary Learning Recommendation (Core Training Programs) -->
                                    <div class="form-group col-md-6">
                                        <label class="font-weight-bold">Primary Learning Recommendation <small class="text-muted">(Max 2)</small><span class="text-danger">*</span></label>
                                        <select name="primary_learning_recommendation[]" id="primary_recommendations" class="form-control select2" multiple="multiple" required>
                                            @foreach($primaryPrograms as $program)
                                            <option value="{{ $program->id }}" 
                                                {{ (isset($suggestion) && is_array($suggestion->primary_learning_recommendation) && in_array($program->id, $suggestion->primary_learning_recommendation)) ? 'selected' : '' }}>
                                                {{ $program->name }} ({{ $program->program_type }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Secondary Learning Recommendation (All Program Types) -->
                                    <div class="form-group col-md-6">
                                        <label class="font-weight-bold">Secondary Learning Recommendation<small class="text-muted">(Max 4)</small></label>
                                        <select name="secondary_learning_recommendation[]" id="secondary_recommendations" class="form-control select2" multiple="multiple">
                                         @foreach($secondaryPrograms as $program)
                                            <option value="{{ $program->id }}" 
                                                {{ (isset($suggestion) && is_array($suggestion->secondary_learning_recommendation) && in_array($program->id, $suggestion->secondary_learning_recommendation)) ? 'selected' : '' }}>
                                                {{ $program->name }} ({{ $program->program_type }})
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Alert Message moved directly above submission section -->
                                <div id="suggestionAlert" class="alert mt-3" style="display:none;"></div>

                                <!-- Submit Button -->
                                <div class="row mt-4">
                                    <div class="col-md-12 text-right">
                                        <button type="button" id="saveSuggestionBtn" class="btn btn-success btn-lg">
                                            <i class="fa fa-save"></i> Save Response
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

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

<style>
/* Custom grid column for 5 items in a row */
.col-md-2-4 {
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
}
@media (min-width: 768px) {
    .col-md-2-4 {
        flex: 0 0 20%;
        max-width: 20%;
    }
}

/* Main Card Full White Styling */
.assessment-card {
    background-color: #ffffff !important;
    border: 1px solid #e3e6f0;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);
}

.section-heading {
    font-size: 20px;
    font-weight: 700;
    color: #333;
    border-bottom: 3px solid #007bff;
    display: inline-block;
    padding-bottom: 4px;
}

.subheading {
    font-size: 16px;
    letter-spacing: 0.5px;
}

/* Disabled button & select hover effect */
button:disabled,
.btn:disabled {
    cursor: not-allowed;
    opacity: 0.65;
}

button:disabled:hover,
.btn:disabled:hover {
    background-color: #2e6da4;
    border-color: #2e6da4;
}

select:disabled {
    cursor: not-allowed;
    background-color: #f5f5f5;
}

/* Validation Styling */
.is-invalid {
    border-color: #dc3545 !important;
}

.select2-container--default .select2-selection--multiple.is-invalid {
    border-color: #dc3545 !important;
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 80%;
    color: #dc3545;
}
</style>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {

    // Initialize TinyMCE for Advisor Summary Report
    tinymce.init({
        selector: "textarea.advisor_desc",
        height: 300,
        plugins: "advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount",
        toolbar: "undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | code help",
        setup: function (editor) {
            editor.on('change keyup blur', function () {
                editor.save();
                $(editor.getElement()).removeClass('is-invalid');
                $(editor.getElement()).closest('.form-group').find('.invalid-feedback').remove();
            });
        }
    });

    // Initialize Select2 on page load
    $('.select2').select2({ width: '100%' });

    $('#recommended_priorities').select2({
        maximumSelectionLength: 4,
        width: '100%',
        language: {
            maximumSelected: function (e) {
                return 'You can only select up to 4 priorities.';
            }
        }
    });

    // Primary Learning Recommendation (Max 2)
    $('#primary_recommendations').select2({
        maximumSelectionLength: 2,
        width: '100%',
        language: {
            maximumSelected: function (e) {
                return 'You can only select up to 2 primary recommendations.';
            }
        }
    });

    // Secondary Learning Recommendation (Max 4)
    $('#secondary_recommendations').select2({
        maximumSelectionLength: 4,
        width: '100%',
        language: {
            maximumSelected: function (e) {
                return 'You can only select up to 4 secondary recommendations.';
            }
        }
    });

    // Clear validation state on input change
    $('#suggestionForm').on('input change', 'input, select, textarea', function () {
        $(this).removeClass('is-invalid');
        $(this).closest('.form-group').find('.invalid-feedback').remove();
        if ($(this).hasClass('select2-hidden-accessible')) {
            $(this).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
        }
    });

    // Send Email Handler
    $("#sendEmailBtn").on("click", function () {
        let btn = $(this);
        btn.prop("disabled", true).html(
            `<span class="spinner-border spinner-border-sm"></span> Sending...`
        );

        fetch("{{ route('action.learning.assessment.send') }}", {
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
            } else {
                alert(data.message || "Failed to send email.");
            }
        })
        .catch(() => alert("Something went wrong"))
        .finally(() => {
            btn.prop("disabled", false).text("Send Email");
        });
    });

    // Save/Update Suggestion AJAX with Validation
    $("#saveSuggestionBtn").on("click", function () {
        let form = $("#suggestionForm")[0];
        
        // Clear previous error styles
        $(".is-invalid").removeClass("is-invalid");
        $(".invalid-feedback").remove();
        $("#suggestionAlert").hide();

        // Frontend HTML5 Validation
        if (!form.checkValidity()) {
            form.reportValidity();
            
            // Highlight empty Select2 fields
            $("#suggestionForm [required]").each(function () {
                if (!this.checkValidity()) {
                    $(this).addClass("is-invalid");
                    if ($(this).hasClass("select2-hidden-accessible")) {
                        $(this).next(".select2-container").find(".select2-selection").addClass("is-invalid");
                    }
                }
            });

            $("#suggestionAlert")
                .removeClass("alert-success")
                .addClass("alert-danger")
                .text("Please fill in all required fields before submitting.")
                .fadeIn();

            return false;
        }

        let btn = $(this);
        let originalText = btn.html();

        btn.prop("disabled", true).html(
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...`
        );

        $.ajax({
            url: "{{ route('learning.assessment.save.suggestion') }}",
            type: "POST",
            data: $("#suggestionForm").serialize(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    
                    // 1. ENABLE SPLIT BUTTON & CARET
                    $(".btn-group .btn-info").prop("disabled", false).removeAttr("disabled");

                    // 2. UPDATE VIEW REPORT LINK DYNAMICALLY
                    let assessmentId = $('input[name="assessment_id"]').val();
                    let viewUrl = "{{ route('learning.assessment.view.report', ':id') }}".replace(':id', assessmentId);
                    $("#viewReportLink").attr("href", viewUrl);
                    
                    $("#suggestionAlert")
                        .removeClass("alert-danger")
                        .addClass("alert-success")
                        .text(response.message)
                        .fadeIn();

                    setTimeout(() => $("#suggestionAlert").fadeOut(), 3500);
                } else {
                    $("#suggestionAlert")
                        .removeClass("alert-success")
                        .addClass("alert-danger")
                        .text(response.message || "Failed to save suggestion.")
                        .fadeIn();
                }
            },
            error: function (xhr) {
                let msg = "An error occurred while saving.";
                
                // Handle Backend Validation Errors (HTTP 422)
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    msg = xhr.responseJSON.message || "Please fix the validation errors below.";

                    $.each(errors, function (field, messages) {
                        let fieldName = field.replace(/\.\d+$/, '[]');
                        let input = $(`[name="${field}"], [name="${fieldName}"]`);

                        if (input.length) {
                            input.addClass("is-invalid");
                            
                            if (input.hasClass("select2-hidden-accessible")) {
                                input.next(".select2-container").find(".select2-selection").addClass("is-invalid");
                                input.closest(".form-group").append(`<div class="invalid-feedback">${messages[0]}</div>`);
                            } else {
                                input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                            }
                        }
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }

                $("#suggestionAlert")
                    .removeClass("alert-success")
                    .addClass("alert-danger")
                    .text(msg)
                    .fadeIn();
            },
            complete: function () {
                btn.prop("disabled", false).html(originalText);
            }
        });
    });

    // Send Report Dropdown Option Handler
    $('#sendReportBtn').on('click', function(e) {
        e.preventDefault();

        let $btnGroup = $(this).closest('.btn-group');
        let $mainBtn = $btnGroup.find('.dropdown-toggle-split-main');
        let originalText = $mainBtn.html();
        let assessmentId = $('input[name="assessment_id"]').val();

        // Show loading state on main split button & disable toggle caret
        $mainBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending...');
        $btnGroup.find('.dropdown-toggle').prop('disabled', true);
        $('#successMessage').hide().removeClass('alert-danger alert-success');

        $.ajax({
            url: "{{ route('learning.assessment.send.report') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                assessment_id: assessmentId
            },
            success: function(response) {
                if(response.success) {
                    $('#successMessage')
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .html(response.message)
                        .show();
                } else {
                    $('#successMessage')
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .html(response.message || 'Failed to send the report.')
                        .show();
                }
            },
            error: function(xhr) {
                let errorMsg = 'An error occurred while sending the email.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                $('#successMessage')
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .html(errorMsg)
                    .show();
            },
            complete: function() {
                // Restore split button state
                $mainBtn.prop('disabled', false).html(originalText);
                $btnGroup.find('.dropdown-toggle').prop('disabled', false);
            }
        });
    });

});
</script>
@endsection
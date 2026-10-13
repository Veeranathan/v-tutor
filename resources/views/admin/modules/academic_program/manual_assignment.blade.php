@extends('admin.layouts.app')

@section('title')
Manual Academic Program Assignment
@endsection

@section('links')
@include('admin.includes.links')

<!-- SELECT2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
.section-card {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.info-row {
    margin-bottom: 18px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f1f1f1;
}

.info-row label {
    font-weight: 600;
    color: #6c757d;
    font-size: 13px;
    margin-bottom: 6px;
    display: block;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 0;
}

.form-control {
    border-radius: 6px;
    min-height: 42px;
}

.btn-primary {
    min-width: 180px;
}

.alert {
    border-radius: 8px;
}

.select2-container .select2-selection--single {
    height: 42px !important;
    border: 1px solid #ced4da !important;
    border-radius: 6px !important;
    padding-top: 5px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 40px !important;
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
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="page-title">
                Manual Academic Program Assignment
            </h1>
        </div>

        <div class="col-md-6 text-right">
            <a href="{{ route('academic.assignment.list') }}"
               class="btn btn-default">
                Back
            </a>
        </div>
    </div>

    <!-- ASSIGNMENT FORM -->
    <div class="section-card">

        <h2 class="mb-4">
            <strong>Assign Academic Program</strong>
        </h2>

        <!-- SUCCESS MESSAGE -->
        <div id="assignSuccessMessage"
             class="alert alert-success"
             style="display:none;">
        </div>

        <!-- ERROR MESSAGE -->
        <div id="assignErrorMessage"
             class="alert alert-danger"
             style="display:none;">
        </div>

        <form id="manualAssignmentForm">

            @csrf

            <div class="row">

                <!-- STUDENT -->
                <div class="col-md-6">

                    <div class="info-row">

                        <label>Select Student</label>

                        <select name="student_id"
                                id="student_id"
                                class="form-control select2"
                                required>

                            <option value="">
                                Search & Select Student
                            </option>

                            @foreach($students as $student)

                                <option value="{{ $student->id }}">

                                    {{ $student->f_name }}
                                    {{ $student->l_name }}

                                    ({{ $student->email }})

                                    -

                                    @if($student->student_type == 'G')
                                        Guardian
                                    @elseif($student->student_type == 'P')
                                        Parent
                                    @elseif($student->student_type == 'S')
                                        Student
                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <!-- PROGRAM -->
                <div class="col-md-6">

                    <div class="info-row">

                        <label>Select Academic Program</label>

                        <select name="program_id"
                                id="program_id"
                                class="form-control select2"
                                required>

                            <option value="">
                                Search & Select Academic Program
                            </option>

                            @foreach($programs as $program)

                                <option value="{{ $program->id }}">

                                    {{ $program->name }}
                                    ({{ $program->code }})

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>

            <!-- BUTTON -->
            <div class="row mt-4">

                <div class="col-md-3">

                    <button type="button"
                            id="assignProgramBtn"
                            class="btn btn-primary btn-block">

                        Assign Program

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
</div>

@endsection

@section('footer')
@include('admin.includes.footer')
@endsection

@section('script')
@include('admin.includes.script')

<!-- SELECT2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {

    // SELECT2 SEARCH
    $('.select2').select2({
        width: '100%',
        placeholder: 'Search here'
    });

    // ASSIGN PROGRAM
    $("#assignProgramBtn").on("click", function () {

        $(".backend-error").remove();

        let studentId = $("#student_id").val();
        let programId = $("#program_id").val();

        $("#assignErrorMessage").hide();
        $("#assignSuccessMessage").hide();

        if (!studentId) {

            $('#student_id')
                .parent()
                .append('<label class="error backend-error text-danger">Please select student</label>');

            return;
        }

        if (!programId) {

            $('#program_id')
                .parent()
                .append('<label class="error backend-error text-danger">Please select academic program</label>');

            return;
        }

        let btn = $("#assignProgramBtn");

        btn.prop("disabled", true).html(
            `<span class="spinner-border spinner-border-sm"></span> Assigning...`
        );

        fetch("{{ route('academic.assignment.manual.store') }}", {

            method: "POST",

            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },

            body: new FormData(document.getElementById("manualAssignmentForm"))

        })
        .then(res => res.json())
        .then(data => {

            if (data.success) {

                $("#assignSuccessMessage")
                    .text(data.message)
                    .fadeIn();

                // RESET FORM
                $('#manualAssignmentForm')[0].reset();

                // RESET SELECT2
                $('#student_id').val(null).trigger('change');
                $('#program_id').val(null).trigger('change');

                // AUTO HIDE
                setTimeout(() => {
                    $("#assignSuccessMessage").fadeOut();
                }, 3000);

            } else {

                $("#assignErrorMessage")
                    .text(data.message || 'Something went wrong')
                    .fadeIn();
            }

        })
        .catch(() => {

            $("#assignErrorMessage")
                .text('Something went wrong')
                .fadeIn();

        })
        .finally(() => {

            btn.prop("disabled", false)
               .text("Assign Program");

        });

    });

});
</script>
@endsection
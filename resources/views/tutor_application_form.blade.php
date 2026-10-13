@php
    use Carbon\Carbon;
    $nextThreeMonths = Carbon::now()->addMonths(3);
    $nextThreeMonths = date('Y-m-d', strtotime($nextThreeMonths));
@endphp

@extends('layouts.app')
@section('title')
    <title>V-Tutor  Tutor Application Form</title>
@endsection

@section('left_part')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @include('include.header_menu_part')
    <link href="{{ public_asset('assets/css/tutor_style.css')}}" rel="stylesheet">
    <style type="text/css">
        .header_sec {
            top: 0px;
        }
        .val_err {
            margin-bottom: 10px;
        }
        .gj_inf_cir {
            color: #d73c5e;
            cursor: pointer;
            margin-left: 5px;
        }
        .gj_inf_cir {
            color: #d73c5e;
            cursor: pointer;
            margin-left: 5px;
        }
        section.gj_tut_app_frm_sec {
            margin-top: 30px;
            margin-bottom: 80px;
        }

        .gj_tut_app_frm_div .tab-content {
            padding: 20px;
            border: 1px solid transparent;
            border-radius: 9px;
            box-shadow: 0px 2px 8px 0px rgb(0 0 0 / 14%);
            -webkit-box-shadow: 0px 2px 8px 0px rgb(0 0 0 / 14%);
            -moz-box-shadow: 0px 2px 8px 0px rgba(0, 0, 0, 0.14);
        }

        #formTabs.nav-tabs a.nav-link {
            background: #fff;
            border-radius: 5px 5px 0 0;
            margin-right: 5px;
            padding: 10px 9px;
            border: 1px solid #d73c5e;
            border-bottom: 0 !important;
            border-bottom: 0;
            height: 44px;
            color: #d73c5e;
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            -ms-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
            width: max-content;
        }

        #formTabs.nav-tabs a.nav-link.active,
        #formTabs.nav-tabs a.nav-link:hover {
            background: #d73c5e;
            border: 1px solid #d73c5e;
            color: #fff;
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            -ms-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        ul#formTabs {
            border: 0;
            margin-bottom: -22px;
            width: 100%;
            overflow-x: auto;
        }

        .btn_stl {
            /* background-color: #28a745;
                border-color: #28a745; */
            background: rgba(184, 17, 11, 1) !important;
            border-color: rgba(184, 17, 11, 1);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b8110b', endColorstr='#9c0705', GradientType=0);
            height: 47px;
            border-radius: 6px;
            font-family: 'Cerebri Sans SemiBold';
            letter-spacing: 0.5px;
            color: #ffffff;
            margin-top: 20px;
            text-transform: capitalize !important;
        }

        .btn_stl:hover {
            background: rgb(139 13 9) !important;
            border-color: rgb(139 13 9) !important;
        }

        .gj_tut_app_frm_div .form-control:disabled,
        .gj_tut_app_frm_div .form-control[readonly] {
            background-color: transparent;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #d73c5e;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .disability_health_yes span,
        .disability_health_no span {
            vertical-align: text-bottom;
        }

        .gj_tut_app_frm_div label {
            display: block;
        }

        .gj_ca_txt {
            margin: 5px 0px 10px;
            font-size: 16px;
            font-weight: 600;
        }

        .subject_chks,
        .assist_chks,
        .grades_chks,
        .tcs_choose,
        .merits_choose,
        .cpw_choose,
        .oce_choose,
        .wwcc_choose {
            display: block;
        }

        .subject_chks span,
        .assist_chks span,
        .grades_chks span,
        .tcs_choose span,
        .merits_choose span,
        .cpw_choose span,
        .oce_choose span,
        .wwcc_choose span,
        .build_act_choose span {
            vertical-align: text-bottom;
        }

        .subject_chks .select_tutor_subjects,
        .assist_chks .select_assist,
        .grades_chks .select_tutor_grade,
        .tcs_choose .select_tutor_status,
        .merits_choose .select_merits,
        .cpw_choose .select_commit_per_week,
        .oce_choose .select_online_class_experience,
        .wwcc_choose .select_wwcc,
        .build_act_choose .select_building_activities {
            height: 17px;
        }

        .elp_choose,
        .australian_states_wwcc_choose,
        .wwcc_check_choose {
            display: block;
        }

        .elp_choose span,
        .biological_parent_choose span,
        .not_biological_parent_choose span,
        .domestic_violence_choose span,
        .addicted_to_drugs_choose span,
        .showing_your_face_choose span,
        .worked_children_choose span,
        .working_wwcc_choose span,
        .australian_states_wwcc_choose span,
        .crime_in_any_country_choose span,
        .pending_criminal_cases_choose span,
        .children_related_offences_choose span,
        .wwcc_check_choose span {
            vertical-align: text-bottom;
        }

        .elp_choose .select_english_language_proficiency,
        .biological_parent_choose .select_biological_parent,
        .not_biological_parent_choose .select_not_biological_parent,
        .domestic_violence_choose .select_domestic_violence,
        .addicted_to_drugs_choose .select_addicted_to_drugs,
        .showing_your_face_choose .select_showing_your_face,
        .worked_children_choose .select_worked_children,
        .working_wwcc_choose .select_working_wwcc,
        .australian_states_wwcc_choose .select_australian_states_wwcc,
        .crime_in_any_country_choose .select_crime_in_any_country,
        .pending_criminal_cases_choose .select_pending_criminal_cases,
        .children_related_offences_choose .select_children_related_offences,
        .wwcc_check_choose .select_wwcc_check {
            height: 17px;
        }

        .tutor_subjects {
            margin-bottom: 10px !important;
        }

        .gj_form_note {
            font-size: 12px;
            font-style: oblique;
            /* color: #fd4747; */
        }

        .gj_tut_app_frm_common_note_div {
            margin-bottom: 20px;
            font-weight: 600;
        }

        .gj_demograph_note,
        .gj_compliance_note,
        .gj_psycho_analytical_note,
        .gj_right_to_work_note {
            /* font-style: italic; */
            /* font-weight: 400; */
            font-size: 14px;
        }

        .gj_right_to_work_sub_note {
            /* margin-left: 0px;
            font-size: 14px;
            font-style: italic; */
        }

        .gj_wwcc_tbl_desc {
            margin-top: 15px;
            margin-bottom: 10px;
            /* font-style: italic;
            font-weight: 600;
            font-size: 12px; */
        }

        .gj_wwcc_tbl_hd {
            color: #d73c5d;
            text-align: center;
        }

        .next-tab,
        .prev-tab {
            color: #fff;
            background: rgba(184, 17, 11, 1) !important;
            border-color: rgba(184, 17, 11, 1);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b8110b', endColorstr='#9c0705', GradientType=0);
        }

        .next-tab:hover,
        .prev-tab:hover {
            background: rgb(139 13 9) !important;
            border-color: rgb(139 13 9) !important;
        }

        /* .prev-tab {
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b8110b', endColorstr='#9c0705', GradientType=0 );
            }
            .prev-tab:hover {
                background: #044288;
                border-color: #044288;
            } */
        /* .academic_achievements_lbl {
                min-height: 72px;
            } */
        @keyframes countdownFade {
            0%   { transform: scale(1);   opacity: 1; }
            50%  { transform: scale(1.5); opacity: 0.7; }
            100% { transform: scale(0.5); opacity: 0; }
        }
        .countdown-number {
            animation: countdownFade 1s ease-in-out forwards;
        }
        #countdownDisplay {
            position: fixed;
            top: 0;
            left: 0;
            font-size: 4rem;
            color: white;
            background: #00000080 !important;
            background: #b8110b5e !important;
            padding: 20px;
            border-radius: 10px;
            z-index: 99999;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        video#preview {
            width: 45%;
            width: 45%;
            margin: 15px auto 10px;
            display: block;
            box-shadow: 0px 2px 8px 0px rgb(0 0 0 / 14%);
            -webkit-box-shadow: 0px 2px 8px 0px rgb(0 0 0 / 14%);
            -moz-box-shadow: 0px 2px 8px 0px rgba(0, 0, 0, 0.14);
        }

        .gj_vi_rec_div {
            text-align: center;
        }

        .gj_vi_vid_remain {
            margin-bottom: 5px;
            font-weight: 600;
        }

        button#startBtn,
        button#pauseBtn,
        button#stopBtn {
            margin-top: 0px;
            color: #fff;
            background: rgba(184, 17, 11, 1) !important;
            border-color: rgba(184, 17, 11, 1);
            height: 32px;
            line-height: 15px;
            margin-right: 10px;
        }

        .gj_vi_note {
            margin-bottom: 10px;
            font-size: 14px;
        }

        ul.gj_vi_ul1,
        ul.gj_vi_ul2 {
            list-style: circle;
            padding-left: 30px;
            margin: 5px auto 10px;
        }

        ul.gj_vi_ul2_sub {
            list-style: square;
            padding-left: 30px;
            margin: 5px auto 10px;
        }

        .gj_vi_inote {
            margin: 40px auto 10px !important;
            font-size: 16px;
            font-weight: 600;
        }

        .gj_wwcc_check_flex_div {
            gap: 40px;
        }

        .gj_wwcc_check_flex_div .form-control {
            margin: 0px;
        }

        .gj_wwcc_check_choose_div {
            width: 200px;
        }

        .link_color {
            color: #d73c5e;
        }

        .gj_dis_confirm {
            margin-bottom: 3px;
        }

        .gj_trade_note {
            font-size: 12px;
            font-style: italic;
            margin-top: 5px;
        }

        ol.gj_dis_ol li ul {
            list-style: circle;
            padding-left: 30px;
            margin: 5px auto 10px;
        }

        a.wwcc_doc_file {
            color: #d73c5d;
        }

        .gj_wwcc_check_flex_div .form-control.wwcc_doc {
            padding: 2px;
        }

        @media (max-width: 991px) {
            .gj_wwcc_check_flex_div {
                gap: 10px;
                flex-direction: column;
            }
            .gj_wwcc_doc_div.wwcc_check_div {
                margin-bottom: 20px;
            }
        }
        @media (max-width: 420px) {
            .btn {
                padding: 6px 12px !important;
            }
            /* .gj_save_btn {
                width: 100px !important;
                margin-left: 5px !important;
                margin-right: 5px !important;
            } */

        }
        /* Center the modal vertically & horizontally */
.modal-dialog.modal-dialog-centered {
  display: flex;
  align-items: center;
  min-height: calc(100vh - 1rem);
}

/* Optional fallback centering if Bootstrap doesn’t handle it */
.log_modal_bx .modal {
  position: fixed;
  top: 50% !important;
  left: 50% !important;
  transform: translate(-50%, -50%) !important;
}

/* Modal content styling */
.log_modal_bx .modal-content {
  border-radius: 8px;
  overflow: hidden;
  max-width: 500px; /* adjust width as needed */
  width: 90%;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

/* Modal header */
.log_modal_bx .modal-header {
  background-color: #fff;
  border-bottom: 1px solid #e5e5e5;
  padding: 1rem 1.5rem;
}
.log_modal_bx .modal-header .modal-title {
  font-size: 1.25rem;
  font-weight: bold;
  margin: 0;
  color: #000;
}
.log_modal_bx .modal-header .btn-close {
  background: none;
  border: none;
  font-size: 1.25rem;
}

/* Modal body */
.log_modal_bx .modal-body {
  padding: 1.5rem;
  text-align: center;
}
.log_modal_bx .modal-body p {
  font-size: 1rem;
  margin: 0 0 1rem 0;
  color: #333;
}

/* Button group: centered and spaced */
.log_modal_bx .button-group {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-top: 1.5rem;
}

/* Button styles */
.log_modal_bx .btn-login,
.log_modal_bx .btn-signup {
  min-width: 140px;
  padding: 0.65rem 1.2rem;
  font-size: 1rem;
  font-weight: 600;
  /* Removed uppercase transform */
  text-transform: none;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

/* Red buttons */
.log_modal_bx .btn-login {
  background-color: #c00; /* your brand red */
}
.log_modal_bx .btn-login:hover {
  background-color: #a00;
}

/* If both should have same color */
.log_modal_bx .btn-signup {
  background-color: #c00;
}
.log_modal_bx .btn-signup:hover {
  background-color: #a00;
}

/* Responsive: stack buttons on very small screens */
@media (max-width: 400px) {
  .log_modal_bx .button-group {
    flex-direction: column;
    gap: 0.75rem;
  }
  .log_modal_bx .btn-login,
  .log_modal_bx .btn-signup {
    width: 100%;
    min-width: auto;
  }
}

    </style>
@endsection

@section('content')
    {{-- Tutor Application Form Start --}}
    <section class="gj_tut_app_frm_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="gj_tut_app_frm_common_note_div">
                        <p class="gj_tut_app_frm_common_note_text mb-3">Please fill this application form to assess your
                            capability as a tutor on our online platform. It might take approximately 30-40 minutes to
                            complete the process. You may save your changes to visit later for completion.</p>

                        <p class="gj_tut_app_frm_common_note_text">The application section is divided into 4 parts –
                            personal details, demography, behaviour-based, and compliance. At the end of which you will be
                            required to record a video interview and submit valid WWCC checks for verification. </p>
                    </div>

                    <div class="gj_tut_app_frm_div">
                        <ul class="nav nav-tabs" id="formTabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-tab_id="tab1" data-bs-toggle="tab"
                                    href="#tab1">Personal Details</a></li>
                            <li class="nav-item"><a class="nav-link" data-tab_id="tab2" data-bs-toggle="tab"
                                    href="#tab2">Tutoring Details</a></li>
                            <li class="nav-item"><a class="nav-link" data-tab_id="tab3" data-bs-toggle="tab"
                                    href="#tab3">Demographic Details</a></li>
                            <li class="nav-item"><a class="nav-link" data-tab_id="tab4" data-bs-toggle="tab"
                                    href="#tab4">Compliance</a></li>
                            <li class="nav-item"><a class="nav-link" data-tab_id="tab5" data-bs-toggle="tab"
                                    href="#tab5">Behaviour-based</a></li>
                            <li class="nav-item"><a class="nav-link" data-tab_id="tab6" data-bs-toggle="tab"
                                    href="#tab6">Video Interview</a></li>
                            <li class="nav-item"><a class="nav-link" data-tab_id="tab7" data-bs-toggle="tab"
                                    href="#tab7">Right to Work</a></li>
                            <li class="nav-item"><a class="nav-link" data-tab_id="tab8" data-bs-toggle="tab"
                                    href="#tab8">Disclaimer</a></li>
                        </ul>

                        <div class="tab-content mt-1">
                            {{-- Tab 1: Personal Details --}}
                            <div class="tab-pane fade show active" id="tab1">
                                <form method="POST" action="{{ route('tutor_application_form_save_tab1') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="form_id" value="{{ @$taf_data->id ?? '0' }}"
                                        class="form_id">
                                    <input type="hidden" name="current_tab" value="0" class="current_tab">
                                    <input type="hidden" name="form_action" value="" class="form_action">

                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>First Name *</label>
                                            <input type="text" name="first_name"
                                                value="{{ @$taf_data->first_name ?? auth()->user()->f_name }}" class="form-control first_name"
                                                requiredx>
                                            <div class="text-danger val_err" id="first_nameError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Middle Name </label>
                                            <input type="text" name="middle_name"
                                                value="{{ @$taf_data->middle_name ?? '' }}"
                                                class="form-control middle_name">
                                            <div class="text-danger val_err" id="middle_nameError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Last Name *</label>
                                            <input type="text" name="last_name" value="{{ @$taf_data->last_name ?? auth()->user()->l_name }}"
                                                class="form-control last_name">
                                            <div class="text-danger val_err" id="last_nameError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Primary Email *</label>
                                            <input type="email" readonly name="primary_email"
                                                value="{{ auth()->user()->email }}"
                                                class="form-control primary_email" requiredx>
                                            <div class="text-danger val_err" id="primary_emailError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Primary Phone (Mobile) {{-- <i class="fa-solid fa-circle-info"></i> --}} *</label>
                                            <input type="text" name="primary_phone"
                                                value="{{ @$taf_data->primary_phone ?? '' }}"
                                                class="form-control primary_phone" requiredx>
                                            <div class="text-danger val_err" id="primary_phoneError"></div>
                                        </div>

                                        {{-- <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Communication Address (in Australia) *</label>
                                            <textarea name="communication_address" class="form-control communication_address" requiredx>{{ @$taf_data->communication_address ?? '' }}</textarea>
                                            <div class="text-danger val_err" id="communication_addressError"></div>
                                        </div> --}}

                                        {{-- <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Permanent Address </label>
                                            <select name="pick_permanent_address" class="form-control pick_permanent_address">
                                                <option value="">Select</option>
                                                <option {{ @$taf_data->pick_permanent_address == 1 ? 'selected' : '' }} value="1">Same as above</option>
                                                <option {{ @$taf_data->pick_permanent_address == 2 ? 'selected' : '' }} value="2">Other</option>
                                            </select>
                                            <div class="text-danger val_err" id="pick_permanent_addressError"></div>

                                            <textarea name="permanent_address" class="form-control permanent_address" placeholder="Enter Permanent Address">{{ @$taf_data->permanent_address ?? '' }}</textarea>
                                            <div class="text-danger val_err" id="permanent_addressError"></div>
                                        </div> --}}

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Date of Birth *</label>
                                            <input type="date" name="dob" value="{{ @$taf_data->dob ?? '' }}"
                                                class="form-control dob" requiredx>
                                            <div class="text-danger val_err" id="dobError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Nationality *</label>

                                            <input type="text" id="country_selector"
                                                class="form-control country_selector">
                                            <input type="hidden" id="nationality"
                                                value="{{ @$taf_data->nationality ?? '' }}" name="nationality">
                                            {{-- <select name="nationality" class="form-control nationality" requiredx>
                                                <option value="">Select</option>
                                                @if (is_array(config('tutor_form.nationality')))
                                                    @foreach (config('tutor_form.nationality') as $n_k => $n_v)
                                                        <option value="{{ $n_k }}">{{ $n_v }}</option>
                                                    @endforeach
                                                @endif
                                            </select> --}}
                                            <div class="text-danger val_err" id="nationalityError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Current Residency Status *</label>
                                            <select name="current_residency_status"
                                                class="form-control current_residency_status" requiredx>
                                                <option value="">Select</option>
                                                @if (is_array(config('tutor_form.current_residency_status')))
                                                    @foreach (config('tutor_form.current_residency_status') as $css_k => $css_v)
                                                        <option
                                                            {{ @$taf_data->current_residency_status == $css_k ? 'selected' : '' }}
                                                            value="{{ $css_k }}">{{ $css_v }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="text-danger val_err" id="current_residency_statusError"></div>

                                            <input type="text" name="current_residency"
                                                value="{{ @$taf_data->current_residency ?? '' }}"
                                                class="form-control current_residency"
                                                placeholder="Enter Current Residency">
                                            <div class="text-danger val_err" id="current_residencyError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Do you have any disability or health condition that we need to be aware
                                                of? *</label>
                                            <span class="disability_health_yes">
                                                <input type="radio"
                                                    {{ @$taf_data->disability_health == 1 ? 'checked' : '' }}
                                                    value="1" name="disability_health" class="disability_health">
                                                <span>Yes</span>
                                            </span>

                                            <span class="disability_health_no">
                                                <input type="radio"
                                                    {{ @$taf_data->disability_health == 2 ? 'checked' : '' }}
                                                    value="2" name="disability_health" class="disability_health">
                                                <span>No</span>
                                            </span>

                                            <div class="text-danger val_err" id="disability_healthError"></div>

                                            <textarea name="disability_health_details" class="form-control disability_health_details"
                                                placeholder="Please provide additional details regarding your disability">{{ @$taf_data->disability_health_details ?? '' }}</textarea>

                                            <div class="text-danger val_err" id="disability_health_detailsError"></div>
                                        </div>
                                    </div>

                                    <div class="row gj_comm_row">
                                        <div class="col-md-12">
                                            <p class="gj_ca_txt my-3">Communication Address (in Australia) *</p>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Country *</label>
                                            <input type="text" name="com_addr_country"
                                                value="{{ @$taf_data->com_addr_country ?? 'Australia' }}"
                                                class="form-control com_addr_country" readonly>

                                            <div class="text-danger val_err" id="com_addr_countryError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>State / Province / Region *</label>

                                            <select name="com_addr_state" class="form-control com_addr_state" requiredx>
                                                <option value="">Select State / Province / Region</option>
                                                @if (is_array(config('tutor_form.australian_states')))
                                                    @foreach (config('tutor_form.australian_states') as $aspr_k => $aspr_v)
                                                        <option
                                                            {{ @$taf_data->com_addr_state == $aspr_k ? 'selected' : '' }}
                                                            value="{{ $aspr_k }}">{{ $aspr_v }}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                            <div class="text-danger val_err" id="com_addr_stateError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Suburb / City *</label>
                                            <input type="text" name="com_addr_city"
                                                value="{{ @$taf_data->com_addr_city ?? '' }}"
                                                class="form-control com_addr_city">

                                            <div class="text-danger val_err" id="com_addr_cityError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Unit & Street Address *</label>
                                            <input type="text" name="com_addr_street"
                                                value="{{ @$taf_data->com_addr_street ?? '' }}"
                                                class="form-control com_addr_street">

                                            <div class="text-danger val_err" id="com_addr_streetError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Postcode *</label>
                                            <input type="text" name="com_addr_zip"
                                                value="{{ @$taf_data->com_addr_zip ?? '' }}"
                                                class="form-control com_addr_zip numberOnly">

                                            <div class="text-danger val_err" id="com_addr_zipError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Time Zone </label>
                                            <input type="text" name="com_addr_timezone"
                                                value="{{ @$taf_data->com_addr_timezone ?? '' }}"
                                                class="form-control com_addr_timezone" readonly>

                                            <div class="text-danger val_err" id="com_addr_timezoneError"></div>
                                        </div>
                                    </div>

                                    <div class="row gj_perm_row">
                                        <div class="col-md-12">
                                            <p class="gj_ca_txt my-3">Permanent Address (in Australia) *</p>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 ">
                                            <label>Permanent Address </label>
                                            <select name="pick_permanent_address"
                                                class="form-control pick_permanent_address">
                                                {{-- <option value="">Select</option> --}}
                                                <option {{ @$taf_data->pick_permanent_address == 1 ? 'selected' : '' }}
                                                    value="1">Same as above</option>
                                                <option {{ @$taf_data->pick_permanent_address == 2 ? 'selected' : '' }}
                                                    value="2">Other</option>
                                            </select>

                                            <div class="text-danger val_err" id="pick_permanent_addressError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12  perm_addr_div">
                                            <label>Country *</label>
                                            <input type="text" name="perm_addr_country"
                                                value="{{ @$taf_data->perm_addr_country ?? 'Australia' }}"
                                                class="form-control perm_addr_country" readonly>

                                            <div class="text-danger val_err" id="perm_addr_countryError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12  perm_addr_div">
                                            <label>State / Province / Region *</label>

                                            <select name="perm_addr_state" class="form-control perm_addr_state" requiredx>
                                                <option value="">Select State / Province / Region</option>
                                                @if (is_array(config('tutor_form.australian_states')))
                                                    @foreach (config('tutor_form.australian_states') as $aspr_k => $aspr_v)
                                                        <option
                                                            {{ @$taf_data->perm_addr_state == $aspr_k ? 'selected' : '' }}
                                                            value="{{ $aspr_k }}">{{ $aspr_v }}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                            <div class="text-danger val_err" id="perm_addr_stateError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12  perm_addr_div">
                                            <label>Suburb / City *</label>
                                            <input type="text" name="perm_addr_city"
                                                value="{{ @$taf_data->perm_addr_city ?? '' }}"
                                                class="form-control perm_addr_city">
                                            <div class="text-danger val_err" id="perm_addr_cityError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12  perm_addr_div">
                                            <label>Unit & Street Address *</label>
                                            <input type="text" name="perm_addr_street"
                                                value="{{ @$taf_data->perm_addr_street ?? '' }}"
                                                class="form-control perm_addr_street">
                                            <div class="text-danger val_err" id="perm_addr_streetError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12  perm_addr_div">
                                            <label>Postcode *</label>
                                            <input type="text" name="perm_addr_zip"
                                                value="{{ @$taf_data->perm_addr_zip ?? '' }}"
                                                class="form-control perm_addr_zip numberOnly">
                                            <div class="text-danger val_err" id="perm_addr_zipError"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between mb-3">
                                                <div></div>
                                                <button type="button"
                                                    class="btn_stl btn btn-success save_up_tab1_btn gj_save_btn">Save & Update</button>
                                                <button type="button"
                                                    class="btn_stl btn btn-warning next-tab">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- Tab 2: Tutoring Details --}}
                            <div class="tab-pane fade" id="tab2">
                                <form method="POST" action="{{ route('tutor_application_form_save_tab2') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="form_id" value="{{ @$taf_data->id ?? '0' }}"
                                        class="form_id">
                                    <input type="hidden" name="current_tab" value="0" class="current_tab">
                                    <input type="hidden" name="form_action" value="" class="form_action">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-4">
                                            <label class="pb-2">1. What subjects would you able to tutor? </label>

                                            @if (is_array(config('tutor_form.tutor_subjects')))
                                                <div class="row">
                                                    @foreach (config('tutor_form.tutor_subjects') as $ts_k => $ts_v)
                                                        <span
                                                            class="subject_chks col-xl-4 col-md-4 col-sm-6 col-xs-6 col-12 mb-1">
                                                            <input type="checkbox"
                                                                {{ in_array($ts_k, json_decode(@$taf_data->select_tutor_subjects, true) ?? []) ? 'checked' : '' }}
                                                                value="{{ $ts_k }}"
                                                                name="select_tutor_subjects[]"
                                                                class="select_tutor_subjects">
                                                            <span>{{ $ts_v }}</span>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="text-danger val_err" id="select_tutor_subjectsError"></div>

                                            <input type="text" name="tutor_subjects"
                                                value="{{ @$taf_data->tutor_subjects ?? '' }}"
                                                class="col-md-4 col-sm-6 col-xs-6 col-12 mb-3 form-control tutor_subjects"
                                                placeholder="Enter other subjects you are able to tutor">

                                            <div class="text-danger val_err" id="tutor_subjectsError"></div>

                                            <p class="gj_form_note">Note: We may not offer all subjects for tutoring at all
                                                times. This information is collected for general reference and future use.
                                            </p>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-4">
                                            <label class="pb-2">2. Would you able to assist with ancillary subject related activities for
                                                students? </label>

                                            @if (is_array(config('tutor_form.assist')))
                                                <div class="row">
                                                    @foreach (config('tutor_form.assist') as $ass_k => $ass_v)
                                                        <span
                                                            class="assist_chks col-xl-4 col-md-4 col-sm-6 col-xs-6 col-12 mb-1">
                                                            <input type="checkbox"
                                                                {{ in_array($ass_k, json_decode(@$taf_data->select_assist, true) ?? []) ? 'checked' : '' }}
                                                                value="{{ $ass_k }}" name="select_assist[]"
                                                                class="select_assist">
                                                            <span>{{ $ass_v }}</span>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="text-danger val_err" id="select_assistError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-4">
                                            <label class="pb-2">3. What are the grades that you would be able to tutor? </label>
                                            @if (is_array(config('tutor_form.grades')))
                                                <div class="row">
                                                    @foreach (config('tutor_form.grades') as $grd_k => $grd_v)
                                                        <span
                                                            class="grades_chks col-xl-4 col-md-4 col-sm-6 col-xs-6 col-12 mb-1">
                                                            <input type="checkbox"
                                                                {{ in_array($grd_k, json_decode(@$taf_data->select_tutor_grade, true) ?? []) ? 'checked' : '' }}
                                                                value="{{ $grd_k }}" name="select_tutor_grade[]"
                                                                class="select_tutor_grade">
                                                            <span>{{ $grd_v }}</span>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="text-danger val_err" id="select_tutor_gradeError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-4">
                                            <label  class="mb-2">4. What is your current status as a tutor? </label>
                                            @if (is_array(config('tutor_form.tutor_current_status')))
                                                @foreach (config('tutor_form.tutor_current_status') as $tcs_k => $tcs_v)
                                                    <span class="tcs_choose">
                                                        <input type="radio"
                                                            {{ @$taf_data->select_tutor_status == $tcs_k ? 'checked' : '' }}
                                                            value="{{ $tcs_k }}" name="select_tutor_status"
                                                            class="select_tutor_status">
                                                        <span>{{ $tcs_v }}</span>
                                                    </span>
                                                @endforeach
                                            @endif

                                            <div class="text-danger val_err" id="select_tutor_statusError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-4">
                                            <label  class="mb-2">5. Can you tell us about your qualifications and merits as a tutor?
                                            </label>
                                            @if (is_array(config('tutor_form.merits')))
                                                @foreach (config('tutor_form.merits') as $mer_k => $mer_v)
                                                    <span class="merits_choose">
                                                        <input type="radio"
                                                            {{ @$taf_data->select_merits == $mer_k ? 'checked' : '' }}
                                                            value="{{ $mer_k }}" name="select_merits"
                                                            class="select_merits">
                                                        <span>{{ $mer_v }}</span>
                                                    </span>
                                                @endforeach
                                            @endif

                                            <div class="text-danger val_err" id="select_meritsError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-4">
                                            <label  class="mb-2">6. How many hours can you commit per week for online tutoring? *</label>
                                            @if (is_array(config('tutor_form.commit_per_week')))
                                                @foreach (config('tutor_form.commit_per_week') as $cpw_k => $cpw_v)
                                                    <span class="cpw_choose">
                                                        <input type="radio"
                                                            {{ @$taf_data->select_commit_per_week == $cpw_k ? 'checked' : '' }}
                                                            value="{{ $cpw_k }}" name="select_commit_per_week"
                                                            class="select_commit_per_week">
                                                        <span>{{ $cpw_v }}</span>
                                                    </span>
                                                @endforeach
                                            @endif

                                            <div class="text-danger val_err" id="select_commit_per_weekError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-4">
                                            <label  class="mb-2">7. What is your experience in conducting online sessions for students?
                                            </label>
                                            @if (is_array(config('tutor_form.online_class_experience')))
                                                @foreach (config('tutor_form.online_class_experience') as $oce_k => $oce_v)
                                                    <span class="oce_choose">
                                                        <input type="radio"
                                                            {{ @$taf_data->select_online_class_experience == $oce_k ? 'checked' : '' }}
                                                            value="{{ $oce_k }}"
                                                            name="select_online_class_experience"
                                                            class="select_online_class_experience">
                                                        <span>{{ $oce_v }}</span>
                                                    </span>
                                                @endforeach
                                            @endif

                                            <div class="text-danger val_err" id="select_online_class_experienceError">
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-4">
                                            <label  class="mb-2">8. Can you tell us about your status of Working with Children Check
                                                (WWCC)? </label>
                                            @if (is_array(config('tutor_form.wwcc')))
                                                @foreach (config('tutor_form.wwcc') as $wwcc_k => $wwcc_v)
                                                    <span class="wwcc_choose">
                                                        <input type="radio"
                                                            {{ @$taf_data->select_wwcc == $wwcc_k ? 'checked' : '' }}
                                                            value="{{ $wwcc_k }}" name="select_wwcc"
                                                            class="select_wwcc">
                                                        <span>{{ $wwcc_v }}</span>
                                                    </span>
                                                @endforeach
                                            @endif

                                            <div class="text-danger val_err" id="select_wwccError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-4">
                                            <label  class="mb-2">9. Would you be able to assist with capability building activities with
                                                us from time-to-time? </label>
                                            @if (is_array(config('tutor_form.building_activities')))
                                                @foreach (config('tutor_form.building_activities') as $bact_k => $bact_v)
                                                    <span class="build_act_choose">
                                                        <input type="radio"
                                                            {{ @$taf_data->select_building_activities == $bact_k ? 'checked' : '' }}
                                                            value="{{ $bact_k }}" name="select_building_activities"
                                                            class="select_building_activities">
                                                        <span>{{ $bact_v }}</span>
                                                    </span>
                                                @endforeach
                                            @endif

                                            <div class="text-danger val_err" id="select_building_activitiesError"></div>

                                            <p class="gj_form_note">Note: Capability building activities may include
                                                contributing to additional content, features or toolsets that we build or
                                                uplift from time-to-time.</p>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between mb-3">
                                                <button type="button"
                                                    class="btn_stl btn btn-primary prev-tab">Previous</button>
                                                <button type="button"
                                                    class="btn_stl btn btn-success save_up_tab2_btn gj_save_btn">Save & Update</button>
                                                <button type="button"
                                                    class="btn_stl btn btn-warning next-tab">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- Tab 3: Demographic Details --}}
                            <div class="tab-pane fade" id="tab3">
                                <form method="POST" action="{{ route('tutor_application_form_save_tab3') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="form_id" value="{{ @$taf_data->id ?? '0' }}"
                                        class="form_id">
                                    <input type="hidden" name="current_tab" value="0" class="current_tab">
                                    <input type="hidden" name="form_action" value="" class="form_action">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <p class="gj_demograph_note">We collect this information as demography and
                                                culture plays a role in tutoring and dealing with children. This information
                                                is collected, retained and used in accordance with V-Tutor <a href="{{ url('privacy-policy') }}" target="_blank" class="link_color">Privacy Policy</a>. </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-2">
                                            <label>1. State the languages known to you </label>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 mb-1">
                                            <label>Native language / Mother tongue *</label>
                                            {{-- <select name="mother_tongue" class="form-control mother_tongue" requiredx>
                                                <option value="">Select</option>
                                                @if (is_array(config('tutor_form.nationality')))
                                                    @foreach (config('tutor_form.nationality') as $n_k => $n_v)
                                                        <option {{ @$taf_data->mother_tongue ==  $n_k ? 'selected' : '' }} value="{{ $n_k }}">{{ $n_v }}</option>
                                                    @endforeach
                                                @endif
                                            </select> --}}
                                            <input type="text" value="{{ @$taf_data->mother_tongue ?? '' }}"
                                                name="mother_tongue" class="form-control mother_tongue" requiredx>

                                            <div class="text-danger val_err" id="mother_tongueError"></div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12 mb-1">
                                            <label>Primary communication language *</label>
                                            <input type="text"
                                                value="{{ @$taf_data->primary_communication_language ?? '' }}"
                                                name="primary_communication_language"
                                                class="form-control primary_communication_language" requiredx>

                                            <div class="text-danger val_err" id="primary_communication_languageError">
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-4 col-sm-6 col-xs-6 col-12 mb-3">
                                            <label>Secondary communication language *</label>
                                            <input type="text" name="secondary_communication_language" class="form-control secondary_communication_language" requiredx>
                                        </div> --}}

                                        {{-- <div class="col-md-4 col-sm-6 col-xs-6 col-12 mb-3">
                                            <label>Tertiary communication language *</label>
                                            <input type="text" value="{{ @$taf_data->tertiary_communication_language ?? '' }}" name="tertiary_communication_language" class="form-control tertiary_communication_language" requiredx>

                                            <div class="text-danger val_err" id="tertiary_communication_languageError"></div>
                                        </div> --}}

                                        {{-- <div class="col-md-4 col-sm-6 col-xs-6 col-12 mb-3">
                                            <label>Other languages *</label>
                                            <input type="text" name="other_language" class="form-control other_language" requiredx>
                                        </div> --}}
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">2. State your English language proficiency in verbal communication? *</label>
                                            @if (is_array(config('tutor_form.english_language_proficiency')))
                                                @foreach (config('tutor_form.english_language_proficiency') as $elp_k => $elp_v)
                                                    <span class="elp_choose">
                                                        <input type="radio"
                                                            {{ @$taf_data->select_english_language_proficiency == $elp_k ? 'checked' : '' }}
                                                            value="{{ $elp_k }}"
                                                            name="select_english_language_proficiency"
                                                            class="select_english_language_proficiency">
                                                        <span>{{ $elp_v }}</span>
                                                    </span>
                                                @endforeach
                                            @endif

                                            <div class="text-danger val_err"
                                                id="select_english_language_proficiencyError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">3. Do you have any kids for whom you are a biological parent
                                                (father/mother)? *</label>
                                            <span class="biological_parent_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_biological_parent == 1 ? 'checked' : '' }}
                                                    value="1" name="select_biological_parent"
                                                    class="select_biological_parent">
                                                <span>Yes</span>
                                            </span>

                                            <span class="biological_parent_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_biological_parent == 2 ? 'checked' : '' }}
                                                    value="2" name="select_biological_parent"
                                                    class="select_biological_parent">
                                                <span>No</span>
                                            </span>

                                            <div class="text-danger val_err" id="select_biological_parentError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">4. Do you live with any children at home for whom you are not a
                                                biological parent (foster child, relative kids, adopted children)?  *</label>
                                            <span class="not_biological_parent_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_not_biological_parent == 1 ? 'checked' : '' }}
                                                    value="1" name="select_not_biological_parent"
                                                    class="select_not_biological_parent">
                                                <span>Yes</span>
                                            </span>

                                            <span class="not_biological_parent_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_not_biological_parent == 2 ? 'checked' : '' }}
                                                    value="2" name="select_not_biological_parent"
                                                    class="select_not_biological_parent">
                                                <span>No</span>
                                            </span>

                                            <div class="text-danger val_err" id="select_not_biological_parentError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">5. Do you have any family history of domestic violence or abuse in which
                                                you were an affected party (victim)? *</label>
                                            <span class="domestic_violence_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_domestic_violence == 1 ? 'checked' : '' }}
                                                    value="1" name="select_domestic_violence"
                                                    class="select_domestic_violence">
                                                <span>Yes</span>
                                            </span>

                                            <span class="domestic_violence_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_domestic_violence == 2 ? 'checked' : '' }}
                                                    value="2" name="select_domestic_violence"
                                                    class="select_domestic_violence">
                                                <span>No</span>
                                            </span>

                                            <div class="text-danger val_err" id="select_domestic_violenceError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">6. Are you addicted to drugs (medicinal or recreational) that could
                                                impair your mental ability from performing as a tutor? *</label>
                                            <span class="addicted_to_drugs_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_addicted_to_drugs == 1 ? 'checked' : '' }}
                                                    value="1" name="select_addicted_to_drugs"
                                                    class="select_addicted_to_drugs">
                                                <span>Yes</span>
                                            </span>

                                            <span class="addicted_to_drugs_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_addicted_to_drugs == 2 ? 'checked' : '' }}
                                                    value="2" name="select_addicted_to_drugs"
                                                    class="select_addicted_to_drugs">
                                                <span>No</span>
                                            </span>

                                            <div class="text-danger val_err" id="select_addicted_to_drugsError"></div>

                                            <textarea name="select_addicted_to_drugs_details" class="col-md-6 col-sm-6 col-xs-12 col-12 mb-3 form-control select_addicted_to_drugs_details"
                                                placeholder="Please provide more details.">{{ @$taf_data->select_addicted_to_drugs_details ?? '' }}</textarea>

                                            <div class="text-danger val_err" id="select_addicted_to_drugs_detailsError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">7. Do you have any reservations or considerations about showing your face
                                                in online sessions? *</label>
                                            <span class="showing_your_face_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_showing_your_face == 1 ? 'checked' : '' }}
                                                    value="1" name="select_showing_your_face"
                                                    class="select_showing_your_face">
                                                <span>Yes</span>
                                            </span>

                                            <span class="showing_your_face_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_showing_your_face == 2 ? 'checked' : '' }}
                                                    value="2" name="select_showing_your_face"
                                                    class="select_showing_your_face">
                                                <span>No</span>
                                            </span>

                                            <div class="text-danger val_err" id="select_showing_your_faceError"></div>

                                            <textarea name="select_showing_your_face_details" class="col-md-6 col-sm-6 col-xs-12 col-12 mb-3 form-control select_showing_your_face_details"
                                                placeholder="Please provide more details.">{{ @$taf_data->select_showing_your_face_details ?? '' }}</textarea>

                                            <div class="text-danger val_err" id="select_showing_your_face_detailsError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">8. Have you worked with or interacted or worked with children (below 16)
                                                in any capacity in the past? *</label>
                                            <span class="worked_children_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_worked_children == 1 ? 'checked' : '' }}
                                                    value="1" name="select_worked_children"
                                                    class="select_worked_children">
                                                <span>Yes</span>
                                            </span>

                                            <span class="worked_children_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_worked_children == 2 ? 'checked' : '' }}
                                                    value="2" name="select_worked_children"
                                                    class="select_worked_children">
                                                <span>No</span>
                                            </span>

                                            <div class="text-danger val_err" id="select_worked_childrenError"></div>

                                            <textarea name="worked_children" class="col-md-6 col-sm-6 col-xs-12 col-12 mb-3 form-control worked_children"
                                                placeholder="Please provide more details.">{{ @$taf_data->worked_children ?? '' }}</textarea>

                                            <div class="text-danger val_err" id="worked_childrenError"></div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between mb-3">
                                                <button type="button"
                                                    class="btn_stl btn btn-primary prev-tab">Previous</button>
                                                <button type="button"
                                                    class="btn_stl btn btn-success save_up_tab3_btn gj_save_btn">Save & Update</button>
                                                <button type="button"
                                                    class="btn_stl btn btn-warning next-tab">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- Tab 4: Compliance --}}
                            <div class="tab-pane fade" id="tab4">
                                <form method="POST" action="{{ route('tutor_application_form_save_tab4') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="form_id" value="{{ @$taf_data->id ?? '0' }}"
                                        class="form_id">
                                    <input type="hidden" name="current_tab" value="0" class="current_tab">
                                    <input type="hidden" name="form_action" value="" class="form_action">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <p class="gj_compliance_note">We collect this information in line with the
                                                regulatory requirements and background checks. This information is
                                                collected, retained and used in accordance with V-Tutor <a href="{{ url('privacy-policy') }}" target="_blank" class="link_color">Privacy Policy</a>. </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">1. Do you have a valid Working with Children Check (WWCC)? *</label>

                                            <span class="working_wwcc_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_working_wwcc == 1 ? 'checked' : '' }}
                                                    value="1" name="select_working_wwcc"
                                                    class="select_working_wwcc">
                                                <span>Yes</span>
                                            </span>

                                            <span class="working_wwcc_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_working_wwcc == 2 ? 'checked' : '' }}
                                                    value="2" name="select_working_wwcc"
                                                    class="select_working_wwcc">
                                                <span>No</span>
                                            </span>

                                            <div class="text-danger val_err" id="select_working_wwccError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3 select_working_wwcc_div">
                                            <label class="mb-2">Please select the Australian States that you have valid WWCC checks for.
                                            </label>

                                            @if (is_array(config('tutor_form.australian_states')))
                                                <div class="row">
                                                    @foreach (config('tutor_form.australian_states') as $asts_k => $asts_v)
                                                        <span
                                                            class="australian_states_wwcc_choose col-xl-3 col-md-4 col-sm-6 col-xs-6 col-12 mb-3">
                                                            <input type="checkbox"
                                                                {{ in_array($asts_k, json_decode(@$taf_data->select_australian_states_wwcc, true) ?? []) ? 'checked' : '' }}
                                                                value="{{ $asts_k }}"
                                                                name="select_australian_states_wwcc[]"
                                                                class="select_australian_states_wwcc">
                                                            <span>{{ $asts_v }}</span>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="text-danger val_err" id="select_australian_states_wwccError">
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">2. Have you ever been convicted or found guilty of a crime in Australia
                                                or any country of your residence past or present? *</label>
                                            <span class="crime_in_any_country_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_crime_in_any_country == 1 ? 'checked' : '' }}
                                                    value="1" name="select_crime_in_any_country"
                                                    class="select_crime_in_any_country">
                                                <span>Yes</span>
                                            </span>

                                            <span class="crime_in_any_country_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_crime_in_any_country == 2 ? 'checked' : '' }}
                                                    value="2" name="select_crime_in_any_country"
                                                    class="select_crime_in_any_country">
                                                <span>No</span>
                                            </span>

                                            <div class="text-danger val_err" id="select_crime_in_any_countryError"></div>

                                            <textarea name="crime_in_any_country"
                                                class="col-md-6 col-sm-6 col-xs-12 col-12 mb-3 form-control crime_in_any_country"
                                                placeholder="Please provide more details">{{ @$taf_data->crime_in_any_country ?? '' }}</textarea>

                                            <div class="text-danger val_err" id="crime_in_any_countryError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">3. Do you have any pending criminal cases on court awaiting judgement?
                                                *</label>
                                            <span class="pending_criminal_cases_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_pending_criminal_cases == 1 ? 'checked' : '' }}
                                                    value="1" name="select_pending_criminal_cases"
                                                    class="select_pending_criminal_cases">
                                                <span>Yes</span>
                                            </span>

                                            <span class="pending_criminal_cases_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_pending_criminal_cases == 2 ? 'checked' : '' }}
                                                    value="2" name="select_pending_criminal_cases"
                                                    class="select_pending_criminal_cases">
                                                <span>No</span>
                                            </span>

                                            <div class="text-danger val_err" id="select_pending_criminal_casesError">
                                            </div>

                                            <textarea name="pending_criminal_cases"
                                                class="col-md-6 col-sm-6 col-xs-12 col-12 mb-3 form-control pending_criminal_cases"
                                                placeholder="Please provide more details">{{ @$taf_data->pending_criminal_cases ?? '' }}</textarea>

                                            <div class="text-danger val_err" id="pending_criminal_casesError"></div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">4. Have you ever been convicted or found guilty of children related
                                                offences? *</label>
                                            <span class="children_related_offences_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_children_related_offences == 1 ? 'checked' : '' }}
                                                    value="1" name="select_children_related_offences"
                                                    class="select_children_related_offences">
                                                <span>Yes</span>
                                            </span>

                                            <span class="children_related_offences_choose">
                                                <input type="radio"
                                                    {{ @$taf_data->select_children_related_offences == 2 ? 'checked' : '' }}
                                                    value="2" name="select_children_related_offences"
                                                    class="select_children_related_offences">
                                                <span>No</span>
                                            </span>

                                            <div class="text-danger val_err" id="select_children_related_offencesError">
                                            </div>

                                            <textarea name="children_related_offences"
                                                class="col-md-6 col-sm-6 col-xs-12 col-12 mb-3 form-control children_related_offences"
                                                placeholder="Please provide more details">{{ @$taf_data->children_related_offences ?? '' }}</textarea>

                                            <div class="text-danger val_err" id="children_related_offencesError"></div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between mb-3">
                                                <button type="button"
                                                    class="btn_stl btn btn-primary prev-tab">Previous</button>
                                                <button type="button"
                                                    class="btn_stl btn btn-success save_up_tab4_btn gj_save_btn">Save & Update</button>
                                                <button type="button"
                                                    class="btn_stl btn btn-warning next-tab">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- Tab 5: Behaviour-based --}}
                            <div class="tab-pane fade" id="tab5">
                                <form method="POST" action="{{ route('tutor_application_form_save_tab5') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="form_id" value="{{ @$taf_data->id ?? '0' }}"
                                        class="form_id">
                                    <input type="hidden" name="current_tab" value="0" class="current_tab">
                                    <input type="hidden" name="form_action" value="" class="form_action">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <p class="gj_psycho_analytical_note">The below section contains behavioural and
                                                scenario-based questions. Answer them based on your experience as a tutor
                                                and general understanding of children. Try to answer all the questions
                                                within a maximum of 150 words. </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">What motivated you to apply as a tutor with V-Tutor? </label>

                                            <textarea name="motivated_tutor" rows="5" class="form-control motivated_tutor" requiredx>{{ @$taf_data->motivated_tutor ?? '' }}</textarea>

                                            <div class="text-danger val_err" id="motivated_tutorError"></div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">What is teaching or tutoring according to your belief and values?
                                            </label>

                                            <textarea name="belief_values" rows="5" class="form-control belief_values" requiredx>{{ @$taf_data->belief_values ?? '' }}</textarea>

                                            <div class="text-danger val_err" id="belief_valuesError"></div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">How would you ensure that a student who attends your session has
                                                understood the topic? </label>

                                            <textarea name="understood_topic" rows="5" class="form-control understood_topic" requiredx>{{ @$taf_data->understood_topic ?? '' }}</textarea>

                                            <div class="text-danger val_err" id="understood_topicError"></div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">What would be your approach to a student who joins late to an online
                                                session and shows limited or no attention? </label>

                                            <textarea name="late_online_session" rows="5" class="form-control late_online_session" requiredx>{{ @$taf_data->late_online_session ?? '' }}</textarea>

                                            <div class="text-danger val_err" id="late_online_sessionError"></div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12 col-12 mb-3">
                                            <label class="mb-2">A parent who has been watching your online session intervene and complain
                                                (challenge) your teaching methods as incorrect. How would you react and
                                                respond to that challenge and accusation? </label>

                                            <textarea name="parent_watching" rows="5" class="form-control parent_watching" requiredx>{{ @$taf_data->parent_watching ?? '' }}</textarea>

                                            <div class="text-danger val_err" id="parent_watchingError"></div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12 col-12 mb-3">
                                            <label class="academic_achievements_lbl mb-2">Why should you be recruited as a
                                                tutor? Feel free to mention your academic achievements, if any. </label>

                                            <textarea name="academic_achievements" rows="5" class="form-control academic_achievements" requiredx>{{ @$taf_data->academic_achievements ?? '' }}</textarea>

                                            <div class="text-danger val_err" id="academic_achievementsError"></div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between mb-3">
                                                <button type="button"
                                                    class="btn_stl btn btn-primary prev-tab">Previous</button>
                                                <button type="button"
                                                    class="btn_stl btn btn-success save_up_tab5_btn gj_save_btn">Save & Update</button>
                                                <button type="button"
                                                    class="btn_stl btn btn-warning next-tab">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- Tab 6: Video Interview --}}
                            <div class="tab-pane fade" id="tab6">
                                <form id="uploadForm" method="POST"
                                    action="{{ route('tutor_application_form_save_tab6') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="form_id" value="{{ @$taf_data->id ?? '0' }}"
                                        class="form_id" id="vid_form_id">
                                    <input type="hidden" name="current_tab" value="0" class="current_tab">
                                    <input type="hidden" name="form_action" value="" class="form_action">
                                    <input type="hidden" name="video_file" id="video_file">
                                    <button type="submit" style="display: none;" id="uploadBtn">Upload</button>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="gj_vi_note">This is an audio-visual interview section. We would like
                                                you spend few minutes to talk about yourself and how you can be a good
                                                tutor. You may follow the prompts down below as guidance. to speak about.
                                            </p>

                                            <p class="gj_vi_note gj_form_note">Note: If you are unable to record the
                                                audio-visual interview for personal or technical reasons, reach out to <a href="https://mail.google.com/mail/?view=cm&fs=1&to=be-a-tutor@v-tutor.com.au" target="_blank">
    be-a-tutor@v-tutor.com.au
</a>
                                            </p>

                                            <p class="gj_vi_note">You will have until 2 minutes to complete this task after
                                                which the recording would automatically stop, so pace your time accordingly.
                                                Please make sure you rehearse well before recording the session. Kindly note
                                                the instructions below. </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="gj_vi_ul1">
                                                <li>Speak only in English and not in any other language</li>

                                                <li>Record with your face fully visible (until bust) to the camera</li>

                                                <li>Formal or semi-formal attire is preferred over casuals</li>

                                                <li>Be seated while recording with your face visible always</li>

                                                <li>Smile gracefully, be cheerful and positive</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="gj_vi_rec_div">
                                                <video id="preview" autoplay muted
                                                    poster="{{ public_asset('assets/images/video_interview_image.webp')}}"
                                                    class="gj_vi_vid"></video>

                                                <p class="gj_vi_vid_remain">Time remaining: <span
                                                        id="timer">02:00</span></p>

                                                <button type="button" class="btn_stl btn" id="startBtn">Start</button>
                                                <button type="button" class="btn_stl btn" id="pauseBtn">Pause</button>
                                                <button type="button" class="btn_stl btn" id="stopBtn">Stop</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="gj_vi_inote">You may consider the following pointers to talk through
                                                the recording:</p>

                                            <ul class="gj_vi_ul2">
                                                <li>
                                                    <p>Personal introduction:</p>

                                                    <ul class="gj_vi_ul2_sub">
                                                        <li>Who are you?</li>
                                                        <li>Where are you from?</li>
                                                        <li>Where do you currently live?</li>
                                                        <li>What are your hobbies and interests?</li>
                                                        <li>What is your current occupation, and is it part-time or full-time? </li>
                                                    </ul>
                                                </li>

                                                <li>What is your biggest motivation to apply as a tutor with V-Tutor?</li>

                                                <li>What do you find interesting when working as a tutor?</li>

                                                <li>Why should you be recruited as a tutor at V-Tutor?</li>
                                                <li>How do you believe joining V-Tutor will support your growth and development? </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between mb-3">
                                                <button type="button"
                                                    class="btn_stl btn btn-primary prev-tab">Previous</button>
                                                <div></div>
                                                {{-- <button type="submit" class="btn_stl btn btn-success save_up_tab6_btn gj_save_btn">Save & Update</button> --}}
                                                <button type="button"
                                                    class="btn_stl btn btn-warning next-tab">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- Tab 7: Right to Work --}}
                            <div class="tab-pane fade" id="tab7">
                                <form method="POST" action="{{ route('tutor_application_form_save_tab7') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="form_id" value="{{ @$taf_data->id ?? '0' }}"
                                        class="form_id">
                                    <input type="hidden" name="current_tab" value="0" class="current_tab">
                                    <input type="hidden" name="form_action" value="" class="form_action">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <p class="gj_right_to_work_note">Please provide the following details to
                                                validate your identity and work authorisation. All information provided in
                                                this section are subject to further verification. </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <label>Working with Children Check (WWCC): *</label>

                                            <p class="gj_right_to_work_sub_note mb-2">Please select the Australian states and territories in which you hold a valid Working With Children Check (WWCC) authorisation. You are permitted to tutor students only in the jurisdictions where a valid WWCC number has been provided. Kindly ensure that the expiry date of your WWCC is more than three months from the current date.</p>

                                            <div class="text-danger val_err" id="wwcc_checkError"></div>

                                            @if (is_array(config('tutor_form.australian_states')))
                                                @php
                                                    $wwccData = collect(@$taf_wwcc ?? [])->keyBy('states');
                                                @endphp

                                                @foreach (config('tutor_form.australian_states') as $wwcc_chk_k => $wwcc_chk_v)
                                                    @php
                                                        $ext_wwcc_chk_k = @$wwccData[$wwcc_chk_k] ?? null;
                                                    @endphp

                                                    <div class="d-flex justify-between gj_wwcc_check_flex_div">
                                                        <div class="gj_wwcc_check_choose_div">
                                                            <span class="wwcc_check_choose">
                                                                <input type="checkbox"
                                                                    {{ $ext_wwcc_chk_k ? 'checked' : '' }}
                                                                    value="{{ $wwcc_chk_k }}" name="wwcc_check[{{ $wwcc_chk_k }}][wwcc_state]"

                                                                    value="{{ $wwcc_chk_k }}" name="wwcc_check[{{ $wwcc_chk_k }}][wwcc_state]"

                                                                    class="select_wwcc_check">
                                                                <span>{{ $wwcc_chk_v }}</span>
                                                            </span>
                                                        </div>

                                                        <div class="gj_wwcc_no_div wwcc_check_div"
                                                            {{ $ext_wwcc_chk_k ? '' : 'style=display:none;' }}>
                                                            <label>WWCC # *</label>
                                                            <input type="text"
                                                                value="{{ $ext_wwcc_chk_k['wwcc_no'] ?? '' }}"
                                                                name="wwcc_check[{{ $wwcc_chk_k }}][wwcc_no]"
                                                                class="form-control wwcc_no" requiredx>
                                                        </div>

                                                        <div class="gj_wwcc_exp_div wwcc_check_div"
                                                            {{ $ext_wwcc_chk_k ? '' : 'style=display:none;' }}>
                                                            <label>Date of Expiry *</label>
                                                            <input type="date" min="{{ @$nextThreeMonths }}" value="{{ $ext_wwcc_chk_k['expiry_date'] ?? '' }}"
                                                                name="wwcc_check[{{ $wwcc_chk_k }}][wwcc_expiry]"
                                                                class="form-control wwcc_expiry">
                                                        </div>

                                                        <div class="gj_wwcc_doc_div wwcc_check_div"
                                                            {{ $ext_wwcc_chk_k ? '' : 'style=display:none;' }}>
                                                            <label>
                                                                WWCC Doc (pdf or jpg) *

                                                                @if (isset($ext_wwcc_chk_k['wwcc_doc']) && $ext_wwcc_chk_k['wwcc_doc'])
                                                                    <a href="{{ $ext_wwcc_chk_k['wwcc_doc'] ? public_asset($ext_wwcc_chk_k['wwcc_doc']) : '' }}" target="_blank" class="wwcc_doc_file">View Doc</a>
                                                                @endif
                                                            </label>
                                                            <input type="file" name="wwcc_check[{{ $wwcc_chk_k }}][wwcc_doc]" class="form-control wwcc_doc">

                                                            <input type="hidden" value="{{ $ext_wwcc_chk_k['wwcc_doc'] ?? '' }}" name="wwcc_check[{{ $wwcc_chk_k }}][wwcc_doc_hdn]" class="form-control wwcc_doc_hdn">
                                                        </div>
                                                    </div>

                                                    {{-- <span class="wwcc_check_choose">
                                                        <input type="checkbox" {{ $ext_wwcc_chk_k ? 'checked' : '' }} value="{{ $wwcc_chk_k }}" name="select_wwcc_check" class="select_wwcc_check">
                                                        <span>{{ $wwcc_chk_v }}</span>
                                                    </span>

                                                    <div class="row wwcc_check_div" {{ $ext_wwcc_chk_k ? '' : 'style=display:none;' }}>
                                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12">
                                                            <label>WWCC # *</label>
                                                            <input type="text" value="{{ $ext_wwcc_chk_k['wwcc_no'] ?? '' }}" name="wwcc_check[{{ $wwcc_chk_k }}][wwcc_no]" class="form-control wwcc_no" requiredx>
                                                        </div>

                                                        <div class="col-md-4 col-sm-6 col-xs-6 col-12">
                                                            <label>Date of Expiry </label>
                                                            <input type="date" value="{{ $ext_wwcc_chk_k['expiry_date'] ?? '' }}" name="wwcc_check[{{ $wwcc_chk_k }}][wwcc_expiry]" class="form-control wwcc_expiry">
                                                        </div>
                                                    </div> --}}
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <div class="gj_wwcc_tbl_div">
                                                <p class="gj_wwcc_tbl_desc">Below is a list of official government websites
                                                    where users can find information, apply, or check the status of a
                                                    Working with Children Check (WWCC) (or its equivalent) in each
                                                    Australian state and territory:</p>

                                                <h4 class="gj_wwcc_tbl_hd">WWCC Information by State and Territory –
                                                    Official Websites </h4>

                                                <div class="table-responsive gj_tbl_resp">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>State / Territory</th>
                                                                <th> WWCC Name </th>
                                                                <th style="width: 450px;"> Official Website </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @if (is_array(config('tutor_form.wwcc_australian_states')))
                                                                @foreach (config('tutor_form.wwcc_australian_states') as $aus_sts_k => $aus_sts_v)
                                                                    <tr>
                                                                        <td>{{ $aus_sts_v['states'] }}</td>

                                                                        <td>{{ $aus_sts_v['wwcc'] }}</td>

                                                                        <td>
                                                                            <a href="{{ $aus_sts_v['link'] }}"
                                                                                target="_blank">{{ $aus_sts_v['link_text'] }}</a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between mb-3">
                                                <button type="button"
                                                    class="btn_stl btn btn-primary prev-tab">Previous</button>
                                                <button type="button"
                                                    class="btn_stl btn btn-success save_up_tab7_btn gj_save_btn">Save & Update</button>
                                                <button type="button"
                                                    class="btn_stl btn btn-warning next-tab">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- Tab 8: Disclaimer --}}
                            <div class="tab-pane fade" id="tab8">
                                <form method="POST" action="{{ route('tutor_application_form_save_tab8') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="form_id" value="{{ @$taf_data->id ?? '0' }}"
                                        class="form_id">
                                    <input type="hidden" name="current_tab" value="0" class="current_tab">
                                    <input type="hidden" name="form_action" value="" class="form_action">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12">
                                            <p class="gj_disclaimer_note mb-3">By submitting your application through this
                                                website, you acknowledge and agree to the following terms: </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <div class="gj_dis_div">
                                                <ol class="gj_dis_ol">
                                                    <li class="mb-3">
                                                        <h5 class="mb-1">Purpose of Information Collection</h5>
                                                        <p>You understand that the personal information you provide,
                                                            including but not limited to your identity, qualifications,
                                                            employment history, and work authorisation status (e.g., visa,
                                                            WWCC), is collected for the purpose of assessing your skills,
                                                            capabilities, and overall suitability for roles or opportunities
                                                            that may be offered by or through V-Tutor. </p>
                                                    </li>

                                                    <li class="mb-3">
                                                        <h5 class="mb-1" >No Guarantee of Selection or Engagement</h5>
                                                        <p>Submission of an application does not constitute an offer of
                                                            employment, engagement, or any form of commitment by V-Tutor. We
                                                            reserve the sole and absolute right to accept or reject any
                                                            application at our full discretion, without the need to provide
                                                            reasons or justification.</p>
                                                    </li>

                                                    <li class="mb-3">
                                                        <h5 class="mb-1">Accuracy of Information</h5>
                                                        <p>You are responsible for ensuring the accuracy and completeness of
                                                            all information submitted. V-Tutor accepts no liability for
                                                            decisions based on false, misleading, or incomplete information
                                                            provided by you or third-party data sources. </p>
                                                    </li>

                                                    <li class="mb-3">
                                                        <h5 class="mb-1">Use of Third-Party Verification </h5>
                                                        <p>We may verify your information with authorised third-party
                                                            services (such as government-issued identity or work entitlement
                                                            systems) where necessary. Your data will be handled in
                                                            accordance with our Privacy Policy and applicable Australian
                                                            privacy legislation. </p>
                                                    </li>

                                                    <li class="mb-3">
                                                        <h5 class="mb-1">Limitation of Liability </h5>
                                                        <p>To the maximum extent permitted by law, V-Tutor, its officers,
                                                            agents, and affiliates shall not be held liable for any direct,
                                                            indirect, incidental, or consequential loss, damage, or claim
                                                            arising out of or in connection with: </p>

                                                        <ul>
                                                            <li>the use of this website;</li>
                                                            <li>the submission of your personal data;</li>
                                                            <li>any decision to accept or reject your application;</li>
                                                            <li>or any delay or failure to engage your services.</li>
                                                        </ul>
                                                    </li>

                                                    <li class="mb-3">
                                                        <h5 class="mb-1">Indemnity </h5>
                                                        <p>You agree to indemnify and hold harmless V-Tutor from any claims,
                                                            losses, liabilities, costs, or expenses (including legal fees)
                                                            arising from or related to:</p>

                                                        <ul>
                                                            <li>your use of the website or services, </li>
                                                            <li>your application submission, </li>
                                                            <li>or any breach of these terms. </li>
                                                        </ul>
                                                    </li>

                                                    <li class="mb-3">
                                                        <h5 class="mb-1">Right to Modify or Withdraw Services</h5>
                                                        <p>V-Tutor reserves the right to modify, suspend, or discontinue any
                                                            part of the application process or related services at any time
                                                            without notice. </p>
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                            <p class="gj_dis_confirm">By proceeding, you confirm that you have read,
                                                understood, and accepted this disclaimer and all associated terms and
                                                conditions. </p>

                                            <div class="gj_accept_div">
                                                <p class="gj_auth_accept">
                                                    <input type="checkbox" value="1" name="choose_auth_accept"
                                                        class="choose_auth_accept">
                                                    <span>I have read the above terms and authorise the company to undertake
                                                        relevant checks with respective agencies, government or
                                                        private.</span>
                                                </p>

                                                <div class="text-danger val_err" id="choose_auth_acceptError"></div>

                                                <p class="gj_term_accept">
                                                    <input type="checkbox" value="1" name="choose_term_accept"
                                                        class="choose_term_accept">
                                                    <span>I have read and agree to V-Tutor <a
                                                            href="{{ url('privacy-policy') }}" target="_blank"
                                                            class="link_color">Privacy Policy</a> and <a
                                                            href="{{ url('terms-conditions') }}" target="_blank"
                                                            class="link_color">Terms & Conditions</a>.</span>
                                                </p>

                                                <div class="text-danger val_err" id="choose_term_acceptError"></div>

                                                <p class="gj_trade_note">*V-Tutor is a trading name of Afor Edventure Pty
                                                    Ltd (ABN 58 651286 207)</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between mb-3">
                                                <button type="button"
                                                    class="btn_stl btn btn-primary prev-tab">Previous</button>
                                                <button type="button"
                                                    class="btn_stl btn btn-success save_up_tab8_btn_confirm">Submit</button>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="countdownDisplay" style="display:none;"> </div>
    {{-- Tutor Application Form End --}}

    <!-- Form Error Modal -->
    <div class="modal " id="taf_errorModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title bb_disabled_booking_u" id="taf_errorModalLabel">Message</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body taf_errorModalbody">
                    <div class="">
                        <div class=" ">
                            <div class="meass-popup">
                                <ul class="taf_errorModalUl">
                                    <li class="">

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer taf_errorFooter" style="display: none">
                    <button type="button" class="btn_stl btn btn-secondary" id="cancelButton" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn_stl btn btn-primary" id="confirmProceed">Yes, Continue</button>
                    <a href="{{ route('tutor_landing') }}" id="taf_redirectButton" style="display:none;"><button type="button" class="btn_stl btn btn-primary">Close</button></a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal " id="final_submitModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title bb_disabled_booking_u" id="final_submitModalLabel">Saved?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body final_submitModalbody">
                    <div class="">
                        <div class=" ">
                            <div class="meass-popup">
                                <ul class="final_submitModalUl">
                                    <li class="">
                                        The application is ready to be submitted for review. To make further changes, select ‘Cancel’. To proceed with submission, select ‘Yes’.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer final_submitFooter">
                    <button type="button" class="btn_stl btn btn-secondary" id="final_submitcancelButton" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn_stl btn btn-primary" id="final_submitconfirmProceed">Yes, Continue</button>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="modal " id="taf_confirmModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title bb_disabled_booking_u" id="taf_confirmModalLabel">Message</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body taf_confirmModalbody">
                    <div class="">
                        <div class=" ">
                            <div class="meass-popup">
                                <ul class="taf_confirmModalUl">
                                    <li class="">

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmProceed">Yes, Continue</button>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="modal fade" id="taf_errorModal" tabindex="-1" aria-labelledby="taf_errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taf_errorModalLabel">Validation Errors</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <ul id="taf_modalErrorList" class="text-danger mb-0"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div> --}}
    <!-- Form Error Modal -->
@endsection

@section('footer')
    @include('include.tutor_footer')
    <div class="modal fade log_modal_bx" id="log_modal{{ @$tutor->id }}">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Login / Sign up</h4>
        <button type="button" class="btn-close" data-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p>Click on Login or Sign up to continue</p>
        <div class="button-group">
          <a href="{{ route('login') }}" class="btn btn-login">Login</a>
          <a href="{{ route('register') }}" class="btn btn-signup">Sign up</a>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
    {{-- <script src="{{ public_asset('assets/js/jquerymin.js') }}"></script>
    <script src="{{ public_asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ public_asset('assets/js/carouselscript.js')}}"></script>
    <script src="{{ public_asset('assets/js/owl.carousel.js')}}"></script>
    <script src="{{ public_asset('assets/js/moment.js')}}"></script>
    <script src="{{ public_asset('assets/js/jquery-ui.js')}}"></script>
    <script src="{{ public_asset('assets/js/semantic.min.js')}}"></script>
    <script src="{{ public_asset('assets/js/custom.js')}}"></script>     --}}
    @include('include.script')

    {{-- <script>
        const tabs = ['#tab1', '#tab2', '#tab3', '#tab4', '#tab5'];
        let currentTab = 0;

        function showTab(index) {
            const tabTrigger = new bootstrap.Tab(document.querySelector(`a[href="${tabs[index]}"]`));
            tabTrigger.show();
            currentTab = index;
        }

        document.querySelectorAll('.next-tab').forEach(btn => {
            btn.addEventListener('click', () => {
                if (currentTab < tabs.length - 1) {
                    showTab(currentTab + 1);
                }
            });
        });

        document.querySelectorAll('.prev-tab').forEach(btn => {
            btn.addEventListener('click', () => {
                if (currentTab > 0) {
                    showTab(currentTab - 1);
                }
            });
        });

        showTab(currentTab);
    </script> --}}

    <script>
        function confirmWithModal(callback) {
            // Show modal
            // $('.taf_errorModalUl li').text('Do you wish to continue to the next step?');
            $('.taf_errorModalUl li').removeClass('taf_success');
            $('.taf_errorFooter').show();
            $('#taf_errorModal').modal('show');

            // When user confirms
            $('#confirmProceed').off('click').on('click', function() {
                $('#taf_errorModal').modal('hide');
                if (typeof callback === 'function') {
                    callback();
                }
            });
        }
    </script>

    <script>
        let mediaRecorder;
        let chunks = [];
        let countdown;
        let remainingSeconds = 120;
        let form_id = '{{ @$taf_data->id ?? '' }}';

        $('.gj_vi_vid_remain').hide();

        const updateTimer = () => {
            const mins = String(Math.floor(remainingSeconds / 60)).padStart(2, '0');
            const secs = String(remainingSeconds % 60).padStart(2, '0');
            $('.gj_vi_vid_remain').show();
            $('#timer').text(`${mins}:${secs}`);
        };

        function uploadVideo(blob) {
            const file = new File([blob], "recording.mp4", {
                type: 'video/mp4'
            });

            if(!form_id) {
                form_id = $('#vid_form_id').val();
            }
            // alert(form_id);

            const formData = new FormData();
            formData.append('video', file);
            formData.append('form_id', form_id);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '{{ route('tutor_application_form_save_tab6') }}',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.taf_errorFooter').hide();
                    $('.taf_errorModalUl li').text('Please wait while we save the recording, This might take a couple of minutes. Thank you for the patience.');
                    setTimeout(function () {
                        $('#taf_errorModal').modal('show');
                    }, 100);
                },
                success: function(response) {
                    $('.prev-tab').prop('disabled', false);
                    $('.next-tab').prop('disabled', false);
                    // alert('Video recorded successfully.');
                    $('.taf_errorFooter').hide();
                    if (response.data) {
                        $('.taf_errorModalUl li').addClass('taf_success');
                        $('#taf_errorModalLabel').text('Recording Saved');
                        $('.taf_errorModalUl li').text(response.message || 'The recording was completed and saved successfully.');
                        setTimeout(function () {
                            $('#taf_errorModal').modal('show');
                        }, 1000);
                        if (response.data.id) {
                            $('.form_id').val(response.data.id);
                        }
                    } else if (response.errors) {
                        $('.taf_errorModalUl li').text('Kindly ensure that all required fields are completed.');
                        let errors = response.errors;
                        $.each(errors, function(key, messages) {
                            messages.forEach(function(msg) {
                                // alert(key+'-'+msg);
                                $('#' + key + 'Error').text(msg);
                            });
                        });

                        setTimeout(function () {
                            $('#taf_errorModal').modal('show');
                        }, 1000);
                    } else {
                        $('.taf_errorModalUl li').text(response.message || 'Please try again!');
                        setTimeout(function () {
                            $('#taf_errorModal').modal('show');
                        }, 1000);
                        if(response.status == 1) {
                            setTimeout(function () {
                                window.location.href = "{{ route('tutor_application_form') }}#gotab_6";
                            }, 3000);
                        }
                    }
                },
                error: function(res) {
                    $('.prev-tab').prop('disabled', false);
                    $('.next-tab').prop('disabled', false);
                    // alert('Failed to record video.');
                    $('.taf_errorFooter').hide();
                    $('.taf_errorModalUl li').removeClass('taf_success');
                    $('.taf_errorModalUl li').text('Failed to record video.');
                    setTimeout(function () {
                        $('#taf_errorModal').modal('show');
                    }, 1000);
                }
            });
        }

        /* $(document).on('click', '#startBtn', async function() {
            if (!confirm('Ready to start recording?')) {
                return;
            }

            const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
            $('#preview')[0].srcObject = stream;

            mediaRecorder = new MediaRecorder(stream);
            chunks = [];

            mediaRecorder.ondataavailable = e => chunks.push(e.data);
            mediaRecorder.onstop = () => {
                const blob = new Blob(chunks, { type: 'video/mp4' });
                uploadVideo(blob);
            };

            mediaRecorder.start();
            $('#startBtn').prop('disabled', true);
            $('#pauseBtn, #stopBtn').prop('disabled', false);

            // Start countdown
            remainingSeconds = 120;
            updateTimer();
            countdown = setInterval(() => {
                remainingSeconds--;
                updateTimer();
                if (remainingSeconds <= 0) {
                    clearInterval(countdown);
                    $('#stopBtn').click(); // Auto-stop
                    $('.gj_vi_vid_remain').hide();
                }
            }, 1000);
        }); */

        $(document).on('click', '#startBtn', function() {
            $('.taf_errorModalUl li').removeClass('taf_success');
            $('#taf_errorModalLabel').text('Consent for Recording');
            $('.taf_errorModalUl li').html('<p>To begin the self-interview session, we require your consent to record your video and audio. The recorded content will be securely stored and processed in accordance with our <a href="{{ url('privacy-policy') }}" target="_blank" class="link_color">Privacy Policy</a>.</p><p>Recording will commence once you provide your consent.</p>');
            $('#confirmProceed').text('I Consent');

            confirmWithModal(async function() {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: true
                    });
                    $('#preview')[0].srcObject = stream;

                    let startCountdown = 5;
                    // $('#countdownDisplay').show().text(startCountdown);
                    $('#countdownDisplay').show().html(`<span class="countdown-number">${startCountdown}</span>`);

                    let preTimer = setInterval(() => {
                        startCountdown--;
                        // $('#countdownDisplay').text(startCountdown);
                        $('#countdownDisplay').html(`<span class="countdown-number">${startCountdown}</span>`);


                        if (startCountdown <= 0) {
                            clearInterval(preTimer);
                            $('#countdownDisplay').hide();

                            // Start recording after countdown ends
                            mediaRecorder = new MediaRecorder(stream);
                            chunks = [];

                            mediaRecorder.ondataavailable = e => chunks.push(e.data);
                            mediaRecorder.onstop = () => {
                                const blob = new Blob(chunks, { type: 'video/mp4' });
                                // uploadVideo(blob);
                                // Show pop-up modal before saving
                                $('.taf_errorModalUl li').removeClass('taf_success');
                                $('#taf_errorModalLabel').text('Recording Stopped');
                                $('.taf_errorModalUl li').text('Recording has stopped. Your session will now be saved.');
                                $('#confirmProceed').text('Yes');
                                $('#cancelButton').text('No');

                                // Show modal and handle confirmation
                                $('#taf_errorModal').modal('show');

                                $('#confirmProceed').off('click').on('click', function () {
                                    $('#taf_errorModal').modal('hide');
                                    setTimeout(function () {
                                        uploadVideo(blob); // Proceed with saving to backend
                                    }, 1000);
                                });
                            };

                            mediaRecorder.start();
                            $('#startBtn').prop('disabled', true);
                            $('#pauseBtn, #stopBtn').prop('disabled', false);
                            $('.prev-tab, .next-tab').prop('disabled', true);

                            // Recording countdown (120 seconds)
                            remainingSeconds = 120;
                            updateTimer();
                            countdown = setInterval(() => {
                                remainingSeconds--;
                                updateTimer();
                                if (remainingSeconds <= 0) {
                                    clearInterval(countdown);
                                    $('#stopBtn').click();
                                    $('.gj_vi_vid_remain').hide();
                                }
                            }, 1000);
                        }
                    }, 1000);

                    /* mediaRecorder = new MediaRecorder(stream);
                    chunks = [];

                    mediaRecorder.ondataavailable = e => chunks.push(e.data);
                    mediaRecorder.onstop = () => {
                        const blob = new Blob(chunks, {
                            type: 'video/mp4'
                        });
                        uploadVideo(blob);
                    };

                    mediaRecorder.start();
                    $('#startBtn').prop('disabled', true);
                    $('#pauseBtn, #stopBtn').prop('disabled', false);
                    $('.prev-tab').prop('disabled', true);
                    $('.next-tab').prop('disabled', true);

                    // Start countdown
                    remainingSeconds = 120;
                    updateTimer();
                    countdown = setInterval(() => {
                        remainingSeconds--;
                        updateTimer();
                        if (remainingSeconds <= 0) {
                            clearInterval(countdown);
                            $('#stopBtn').click(); // Auto-stop
                            $('.gj_vi_vid_remain').hide();
                        }
                    }, 1000); */
                } catch (err) {
                    // alert("Could not access camera or microphone.");
                    $('.taf_errorFooter').hide();
                    $('.taf_errorModalUl li').removeClass('taf_success');
                    $('.taf_errorModalUl li').text('Could not access camera or microphone.');
                    $('#taf_errorModal').modal('show');
                    console.error(err);
                }
            });
        });


        $(document).on('click', '#pauseBtn', function() {
            if (mediaRecorder?.state === 'recording') {
                $(this).text('Resume');
                mediaRecorder.pause();
                clearInterval(countdown);
            } else if (mediaRecorder?.state === 'paused') {
                $(this).text('Pause');
                mediaRecorder.resume();
                countdown = setInterval(() => {
                    remainingSeconds--;
                    updateTimer();
                    if (remainingSeconds <= 0) {
                        clearInterval(countdown);
                        $('#stopBtn').click();
                        $('.gj_vi_vid_remain').hide();
                    }
                }, 1000);
            }
        });

        $(document).on('click', '#stopBtn', function() {
            if (mediaRecorder?.state !== 'inactive') {
                mediaRecorder.stop();
                $('#startBtn').prop('disabled', false);
                $('#pauseBtn, #stopBtn').prop('disabled', true);
                clearInterval(countdown);
                $('.gj_vi_vid_remain').hide();
            }

            let stream = $('#preview')[0].srcObject;
            if (stream) {
                // stream.getTracks().forEach(track => track.stop()); // stop camera/mic
                $('#preview')[0].srcObject = null; // clear preview
            }
        });

        /* $('#startBtn').on('click', async function () {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
            $('#preview')[0].srcObject = stream;

            mediaRecorder = new MediaRecorder(stream);
            chunks = [];

            mediaRecorder.ondataavailable = e => chunks.push(e.data);
            mediaRecorder.onstop = () => {
                const blob = new Blob(chunks, { type: 'video/mp4' });
                const file = new File([blob], "recording.mp4", { type: 'video/mp4' });

                const formData = new FormData();
                formData.append('video', file);
                formData.append('_token', '{{ csrf_token() }}');

                // Upload via Ajax
                $.ajax({
                    url: '{{ route('tutor_application_form_save_tab6') }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (res) => alert('Video uploaded successfully.'),
                    error: () => alert('Upload failed.')
                });
            };

            mediaRecorder.start();
            $('#startBtn').prop('disabled', true);
            $('#pauseBtn, #stopBtn').prop('disabled', false);

            // Start countdown
            remainingSeconds = 120;
            updateTimer();
            countdown = setInterval(() => {
                remainingSeconds--;
                updateTimer();
                if (remainingSeconds <= 0) {
                    clearInterval(countdown);
                    $('#stopBtn').click();
                }
            }, 1000);
        }); */

        /* $('#pauseBtn').on('click', function () {
            if (mediaRecorder && mediaRecorder.state === 'recording') {
                mediaRecorder.pause();
                clearInterval(countdown);
            } else if (mediaRecorder && mediaRecorder.state === 'paused') {
                mediaRecorder.resume();
                countdown = setInterval(() => {
                    remainingSeconds--;
                    updateTimer();
                    if (remainingSeconds <= 0) {
                        clearInterval(countdown);
                        $('#stopBtn').click();
                    }
                }, 1000);
            }
        });

        $('#stopBtn').on('click', function () {
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
                $('#startBtn').prop('disabled', false);
                $('#pauseBtn, #stopBtn').prop('disabled', true);
                clearInterval(countdown);
            }
        }); */
    </script>


    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            // Save & Update Script Start
            function formSave(its) {
                return new Promise(function(resolve, reject) {
                    var success = 2;
                    let url = its.closest('form').attr('action');
                    let formData = new FormData(its.closest('form')[0]);

                    $('.val_err').text('');
                    var btn_text = its.text();
                    its.prop('disabled', true);
                    // its.prop('disabled', true).text('Saving...');
                    $('.taf_errorModalUl li').text('Your information is being saved');
                    setTimeout(function () {
                        $('#taf_errorModal').modal('show');
                    }, 1000);

                    $.ajax({
                        url: url,
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // $('#taf_errorModal').modal('hide');
                            its.prop('disabled', false).text(btn_text);
                            $('.taf_errorFooter').hide();
                            $('.taf_errorModalUl li').removeClass('taf_success');
                            // alert(response.message || 'Data saved Success!');
                            if (response.complete) {
                                its.prop('disabled', true).text(btn_text);
                                // alert(response.complete_msg || 'Data saved Success!');
                                $('.taf_errorModalUl li').addClass('taf_success');
                                $('#taf_errorModalLabel').text('Application Submitted');
                                $('.taf_errorModalUl li').html(response.complete_msg ||
                                    'The information has been saved successfully.');
                                $('#taf_errorModal').modal('show');

                                setTimeout(function () {
                                    window.location.href = "{{ route('tutor_landing') }}";
                                }, 15000);
                                resolve(1);
                            } else if (response.data) {
                                $('.taf_errorModalUl li').addClass('taf_success');
                                $('#taf_errorModalLabel').text('Saved');
                                // alert(response.message || 'Data saved Success!');
                                $('.taf_errorModalUl li').text(response.message ||
                                    'The information has been saved successfully.');
                                $('#taf_errorModal').modal('show');
                                if (response.data.id) {
                                    $('.form_id').val(response.data.id);
                                }

                                resolve(1);
                            } else if (response.errors) {
                                $('.taf_errorModalUl li').text(
                                    'Kindly ensure that all required fields are completed.');
                                // alert(response.message || 'Validation Error!');
                                let errors = response.errors;
                                $.each(errors, function(key, messages) {
                                    messages.forEach(function(msg) {
                                        // alert(key+'-'+msg);
                                        $('#' + key + 'Error').text(msg);
                                    });
                                });

                                setTimeout(function () {
                                    $('#taf_errorModal').modal('show');
                                }, 1000);
                                resolve(2);
                            } else {
                                // alert(response.message || 'Please try again!');
                                $('.taf_errorModalUl li').text(response.message ||
                                    'Please try again!');
                                setTimeout(function () {
                                    $('#taf_errorModal').modal('show');
                                }, 1000);
                                resolve(2);
                            }
                        },
                        error: function(xhr) {
                            // alert('Unexpected error occurred.');
                            // $('#taf_errorModal').modal('hide');
                            its.prop('disabled', false).text(btn_text);
                            $('.taf_errorFooter').hide();
                            $('.taf_errorModalUl li').removeClass('taf_success');
                            $('.taf_errorModalUl li').text('Unexpected error occurred');
                            setTimeout(function () {
                                $('#taf_errorModal').modal('show');
                            }, 1000);
                            resolve(2);
                        },
                        complete: function() {
                            // $btn.prop('disabled', false).text('Save');
                        }
                    });
                });
            }

            $(document).on('click', '.save_up_tab1_btn, .save_up_tab2_btn, .save_up_tab3_btn, .save_up_tab4_btn, .save_up_tab5_btn, .save_up_tab6_btn, .save_up_tab7_btn, .save_up_tab8_btn', function(e) {
                e.preventDefault();
                var its = $(this);
                formSave(its);
            });

            $(document).on('click', '.save_up_tab8_btn_confirm', function(e) {
                e.preventDefault();
                $('#final_submitModal').modal('show');
            });

            $(document).on('click', '#final_submitconfirmProceed', function(e) {
                e.preventDefault();
                var its = $('.save_up_tab8_btn_confirm');
                formSave(its);
            });
            // Save & Update Script End

            // Dob before 18yr script start
            var today = new Date();

            // 18 years ago from today
            var minDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

            // Format dates as YYYY-MM-DD
            function formatDate(d) {
                var year = d.getFullYear();
                var month = String(d.getMonth() + 1).padStart(2, '0');
                var day = String(d.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            $('.dob').attr('max', formatDate(minDate)); // cannot select future
            // Dob before 18yr script end

            $("#country_selector").countrySelect({
                defaultCountry: "au",
                responsiveDropdown: true
            });

            $('#nationality').val($("#country_selector").countrySelect("getSelectedCountryData").name);

            @if (isset($taf_data->nationality) && $taf_data->nationality)
                $("#country_selector").countrySelect("setCountry", "{{ $taf_data->nationality }}");
                $('#nationality').val($("#country_selector").countrySelect("getSelectedCountryData").name);
            @endif

            $(document).on('change', '#country_selector', function() {
                var country = $(this).countrySelect("getSelectedCountryData");
                // console.log(country.name);
                $('#nationality').val(country.name);
            });

            /* $(document).on('click', '.nav-item', function() {
                var tab = $(this).index();
                // alert(tab);
                showTab(tab);
            }); */

            const tabs = ['#tab1', '#tab2', '#tab3', '#tab4', '#tab5', '#tab6', '#tab7', '#tab8'];
            let currentTab = 0;

            function showTab(index) {
                const tabTrigger = new bootstrap.Tab($(`a[href="${tabs[index]}"]`)[0]);
                tabTrigger.show();
                currentTab = index;
            }

            var hash = window.location.hash;
            if(hash) {
                var tabIndex = hash.replace('#gotab_', '');
                // alert(tabIndex);
                var tab = parseInt(tabIndex) - 1;
                // alert(tab);
                if(tab) {
                    showTab(tab);
                }
            }

            /* $(document).on('click', '.next-tab', function () {
                let its = $(this);

                (async () => {
                    let succ = await formSave(its);
                    if (succ === 1 && currentTab < tabs.length - 1) {
                        showTab(currentTab + 1);
                    }
                })();
            });

            $(document).on('click', '.prev-tab', function () {
                let its = $(this);

                (async () => {
                    let succ = await formSave(its);
                    if (succ === 1 && currentTab > 0) {
                        showTab(currentTab - 1);
                    }
                })();
            }); */

            function formValidation(its) {
                return new Promise(function(resolve, reject) {
                    var success = 2;
                    let url = its.closest('form').attr('action');
                    let formData = new FormData(its.closest('form')[0]);
                    $('.form_action').val('');

                    $('.val_err').text('');
                    var btn_text = its.text();
                    its.prop('disabled', true);
                    // its.prop('disabled', true).text('Saving...');
                    $('.taf_errorModalUl li').text('Your information Validating');
                    setTimeout(function () {
                        $('#taf_errorModal').modal('show');
                    }, 1000);

                    $.ajax({
                        url: url,
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#taf_errorModal').modal('hide');
                            its.prop('disabled', false).text(btn_text);
                            $('.taf_errorFooter').hide();
                            $('.taf_errorModalUl li').removeClass('taf_success');
                            // alert(response.message || 'Data saved Success!');
                            if (response.data && response.data.id) {
                                $('.form_id').val(response.data.id);
                            }
                            if (response.complete) {
                                resolve(1);
                            } else if (response.data) {
                                resolve(1);
                            } else if (response.errors) {
                                $('.taf_errorModalUl li').text(
                                    'Kindly ensure that all required fields are completed.');
                                // alert(response.message || 'Validation Error!');
                                let errors = response.errors;
                                $.each(errors, function(key, messages) {
                                    messages.forEach(function(msg) {
                                        // alert(key+'-'+msg);
                                        $('#' + key + 'Error').text(msg);
                                    });
                                });

                                setTimeout(function () {
                                    $('#taf_errorModal').modal('show');
                                }, 1000);
                                resolve(2);
                            } else {
                                // alert(response.message || 'Please try again!');
                                $('.taf_errorModalUl li').text(response.message ||
                                    'Please try again!');
                                setTimeout(function () {
                                    $('#taf_errorModal').modal('show');
                                }, 1000);
                                resolve(2);
                            }
                        },
                        error: function(xhr) {
                            // alert('Unexpected error occurred.');
                            // $('#taf_errorModal').modal('hide');
                            its.prop('disabled', false).text(btn_text);
                            $('.taf_errorFooter').hide();
                            $('.taf_errorModalUl li').removeClass('taf_success');
                            $('.taf_errorModalUl li').text('Unexpected error occurred');
                            setTimeout(function () {
                                $('#taf_errorModal').modal('show');
                            }, 1000);
                            resolve(2);
                        },
                        complete: function() {
                            // $btn.prop('disabled', false).text('Save');
                        }
                    });
                });
            }

            $(document).on('click', '.next-tab', function(e) {
                e.preventDefault();
                $('.form_action').val(1);
                var its = $(this);
                
                // formValidation(its).then(function(valid) {
                formValidation(its).then(function(valid) {
                    if(valid == 1) {
                        if (currentTab < tabs.length - 1) {
                            $('.taf_errorModalUl li').removeClass('taf_success');
                            $('#taf_errorModalLabel').text('Continue?');
                            $('.taf_errorModalUl li').text('Do you wish to continue to the next step?');
                            confirmWithModal(function() {
                                showTab(currentTab + 1);
                                $('html, body').animate({ scrollTop: 0 }, 'slow');
                            });
                            /* if (confirm('Do you wish to continue to the next step?')) {
                                showTab(currentTab + 1);
                            } */
                        }
                    }
                });
            });

            $(document).on('click', '.prev-tab', function(e) {
                e.preventDefault();
                if (currentTab > 0) {
                    $('.taf_errorModalUl li').removeClass('taf_success');
                    $('.taf_errorModalUl li').text('Are you sure you want to proceed to the previous step?');
                    confirmWithModal(function() {
                        showTab(currentTab - 1);
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                    });
                    /* if (confirm('Are you sure you want to proceed to the previous step?')) {
                        showTab(currentTab - 1);
                    } */
                }
                /* $('.form_action').val(1);
                var its = $(this);

                formValidation(its).then(function(valid) {
                    if(valid == 1) {
                        if (currentTab > 0) {
                            $('.taf_errorModalUl li').removeClass('taf_success');
                            $('.taf_errorModalUl li').text('Are you sure you want to proceed to the previous step?');
                            confirmWithModal(function() {
                                showTab(currentTab - 1);
                                $('html, body').animate({ scrollTop: 0 }, 'slow');
                            });

                        }
                    }
                }); */
            });

            showTab(currentTab);

            // permanent address show & hide
            if ($('.pick_permanent_address').val() == 2) {
                $('.perm_addr_div').show();
            } else {
                $('.perm_addr_div').hide();
            }

            $(document).on('change', '.pick_permanent_address', function() {
                if ($(this).val() == 2) {
                    $('.perm_addr_div').slideDown("slow");
                } else {
                    $('.perm_addr_div').slideUp("slow");
                }
            });
            // permanent address show & hide

            // current_residency_status show & hide
            if ($('.current_residency_status').val() == 8) {
                $('.current_residency').show();
            } else {
                $('.current_residency').hide();
            }

            $(document).on('change', '.current_residency_status', function() {
                if ($(this).val() == 8) {
                    $('.current_residency').show();
                } else {
                    $('.current_residency').hide();
                }
            });
            // current_residency_status show & hide

            // select_tutor_subjects show & hide
            if ($('.select_tutor_subjects:checked').filter(function() {
                    return $(this).val() == 9;
                }).length > 0) {
                $('.tutor_subjects').show();
            } else {
                $('.tutor_subjects').hide();
            }

            $(document).on('change', '.select_tutor_subjects', function() {
                if ($(this).is(':checked')) {
                    if ($(this).val() == 9) {
                        $('.tutor_subjects').show();
                    } else {
                        $('.tutor_subjects').hide();
                    }
                } else {
                    $('.tutor_subjects').hide();
                }
            });
            // select_tutor_subjects show & hide

            // select_wwcc_check show & hide
            $(".select_wwcc_check").each(function(index) {
                if ($(this).is(':checked')) {
                    $(this).closest('.gj_wwcc_check_flex_div').find('.wwcc_check_div').show();
                } else {
                    $(this).closest('.gj_wwcc_check_flex_div').find('.wwcc_check_div').hide();
                }
            });

            $(document).on('change', '.select_wwcc_check', function() {
                if ($(this).is(':checked')) {
                    $(this).closest('.gj_wwcc_check_flex_div').find('.wwcc_check_div').show();
                } else {
                    $(this).closest('.gj_wwcc_check_flex_div').find('.wwcc_check_div').hide();
                }
            });
            // select_wwcc_check show & hide

            // select_worked_children show & hide
            if ($('.select_worked_children:checked').val() == 1) {
                $('.worked_children').show();
            } else {
                $('.worked_children').hide();
            }

            $(document).on('change', '.select_worked_children', function() {
                if ($(this).is(':checked')) {
                    if ($(this).val() == 1) {
                        $('.worked_children').show();
                    } else {
                        $('.worked_children').hide();
                    }
                } else {
                    $('.worked_children').hide();
                }
            });
            // select_worked_children show & hide

            // select_addicted_to_drugs show & hide
            if ($('.select_addicted_to_drugs:checked').val() == 1) {
                $('.select_addicted_to_drugs_details').show();
            } else {
                $('.select_addicted_to_drugs_details').hide();
            }

            $(document).on('change', '.select_addicted_to_drugs', function() {
                if ($(this).is(':checked')) {
                    if ($(this).val() == 1) {
                        $('.select_addicted_to_drugs_details').show();
                    } else {
                        $('.select_addicted_to_drugs_details').hide();
                    }
                } else {
                    $('.select_addicted_to_drugs_details').hide();
                }
            });
            // select_addicted_to_drugs show & hide

            // select_showing_your_face show & hide
            if ($('.select_showing_your_face:checked').val() == 1) {
                $('.select_showing_your_face_details').show();
            } else {
                $('.select_showing_your_face_details').hide();
            }

            $(document).on('change', '.select_showing_your_face', function() {
                if ($(this).is(':checked')) {
                    if ($(this).val() == 1) {
                        $('.select_showing_your_face_details').show();
                    } else {
                        $('.select_showing_your_face_details').hide();
                    }
                } else {
                    $('.select_showing_your_face_details').hide();
                }
            });
            // select_showing_your_face show & hide

            // select_crime_in_any_country show & hide
            if ($('.select_crime_in_any_country:checked').val() == 1) {
                $('.crime_in_any_country').show();
            } else {
                $('.crime_in_any_country').hide();
            }

            $(document).on('change', '.select_crime_in_any_country', function() {
                if ($(this).is(':checked')) {
                    if ($(this).val() == 1) {
                        $('.crime_in_any_country').show();
                    } else {
                        $('.crime_in_any_country').hide();
                    }
                } else {
                    $('.crime_in_any_country').hide();
                }
            });
            // select_crime_in_any_country show & hide

            // select_pending_criminal_cases show & hide
            if ($('.select_pending_criminal_cases:checked').val() == 1) {
                $('.pending_criminal_cases').show();
            } else {
                $('.pending_criminal_cases').hide();
            }

            $(document).on('change', '.select_pending_criminal_cases', function() {
                if ($(this).is(':checked')) {
                    if ($(this).val() == 1) {
                        $('.pending_criminal_cases').show();
                    } else {
                        $('.pending_criminal_cases').hide();
                    }
                } else {
                    $('.pending_criminal_cases').hide();
                }
            });
            // select_pending_criminal_cases show & hide

            // select_children_related_offences show & hide
            if ($('.select_children_related_offences:checked').val() == 1) {
                $('.children_related_offences').show();
            } else {
                $('.children_related_offences').hide();
            }

            $(document).on('change', '.select_children_related_offences', function() {
                if ($(this).is(':checked')) {
                    if ($(this).val() == 1) {
                        $('.children_related_offences').show();
                    } else {
                        $('.children_related_offences').hide();
                    }
                } else {
                    $('.children_related_offences').hide();
                }
            });
            // select_children_related_offences show & hide

            // select_working_wwcc show & hide
            if ($('.select_working_wwcc:checked').val() == 1) {
                $('.select_working_wwcc_div').show();
            } else {
                $('.select_working_wwcc_div').hide();
            }

            $(document).on('change', '.select_working_wwcc', function() {
                if ($(this).is(':checked')) {
                    if ($(this).val() == 1) {
                        $('.select_working_wwcc_div').show();
                    } else {
                        $('.select_working_wwcc_div').hide();
                    }
                } else {
                    $('.select_working_wwcc_div').hide();
                }
            });
            // select_working_wwcc show & hide

            // disability_health show & hide
            if ($('.disability_health:checked').val() == 1) {
                $('.disability_health_details').show();
            } else {
                $('.disability_health_details').hide();
            }

            $(document).on('change', '.disability_health', function() {
                if ($(this).is(':checked')) {
                    if ($(this).val() == 1) {
                        $('.disability_health_details').show();
                    } else {
                        $('.disability_health_details').hide();
                    }
                } else {
                    $('.disability_health_details').hide();
                }
            });
            // disability_health show & hide

            // get TimeZone script start
            var timezoneMap = @json(config('tutor_form.australian_states_timezone'));

            $(document).on('change', '.com_addr_state', function() {
                var selectedValue = $(this).val();
                var timezone = timezoneMap[selectedValue]['timezone'] || '';
                $('.com_addr_timezone').val(timezone);
            });
            // get TimeZone script end
        });
    </script>

    {{-- Allow No Only Script Start --}}
    <script>
        $(document).on('keydown', '.numberOnly', function(e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                (e.keyCode === 65 && e.ctrlKey === true) ||
                (e.keyCode === 67 && e.ctrlKey === true) ||
                (e.keyCode === 88 && e.ctrlKey === true) ||
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                return;
            }

            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
                (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        $(function () {
            $(document).tooltip();
        });
    </script>
    {{-- Allow No Only Script end --}}

    <script>
        function updateButtonText() {
            const buttons = document.querySelectorAll('.gj_save_btn');
            buttons.forEach(btn => {
                btn.textContent = (window.innerWidth <= 359) ? "Save" : "Save & Update";
            });
        }

        window.addEventListener('resize', updateButtonText);
        window.addEventListener('load', updateButtonText);
    </script>
@endsection

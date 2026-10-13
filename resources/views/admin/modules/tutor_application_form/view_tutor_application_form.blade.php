@extends('admin.layouts.app')

@section('title')
    View Tutor Application Form
@endsection

@section('links')
    @include('admin.includes.links')
    <style type="text/css">
    /*this is excel button needs to hide as we have already download option*/
        .buttons-excel{
            display: none;
        }
        .gj_adm_tab_sec h5, .gj_taf_rejappl_div h5 {
            font-size: 16px;
            color: #b80f0a;
        }
        .gj_adm_tab_sec h5, .gj_taf_det_div h5, .gj_taf_rejappl_div h5 {
            font-size: 16px;
        }
        .gj_taf_rejappl_div {
            margin-top: 35px;
        }
        .gj_tab1_com_addr_div, .gj_tab1_perm_addr_div {
            margin: 25px auto 10px;
        }
        .tab2 tr:first-child th, .tab2 td, .tab3 tr:first-child th, .tab3 td, .tab4 tr:first-child th, .tab4 td, .tab5 tr:first-child th, .tab5 td, .tab8 th, .tab8 td {
            border-top: 0 !important;
        }
        .tab4 tr:nth-child(2) td, .tab4 tr:nth-child(3) th {
            border-top: 0 !important;
        }
        .tab7 tr:nth-child(2) th {
            background: #ddd;
        }
        .gj_vid_div {
            width: 55%;
            margin: auto;
        }
        .gj_vid_div video {
            width: 100%;
        }
        .gj_taf_det_div th, .gj_taf_det_div td.gj_adm_tab_sec th, .gj_adm_tab_sec td {
            font-size: 13px !important;
        }
        .gj_adm_tab_sec a.item {
            background: #d73c5e !important;
            border-radius: 8px 8px 0 0;
            margin-right: 8px;
            padding: 10px 9px !important;
            border: 1px solid #d73c5e !important;
            border-bottom: 0 !important;
            height: 44px;
            color: #fff !important;
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            -ms-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
            font-size: 13px;
            top: 1px;
        }        
        .gj_adm_tab_sec a.item.active, .gj_adm_tab_sec a.item:hover {
            color: #b80f0a !important;
            background: #fff !important;
            border: 1px solid #b80f0a !important;
            border-bottom: 0 !important;
        }
        td.gj_vw_wwcc_hd {
            text-align: center;
            font-weight: 600;
            color: #232121;
        }
        .gj_disclaimer_note {
            margin-bottom: 15px !important;
        }
        ol.gj_dis_ol {
            list-style: auto;
            padding-left: 30px;
        }
        ol.gj_dis_ol h5 {
            color: #797979;
            font-size: 14px;
            font-weight: 600;
        }
        .tab8 li ul {
            list-style: circle;
            padding-left: 30px;
        }
        .tab8 li {
            margin-bottom: 10px;
        }
        .gj_taf_but_div {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        p.gj_trade_note {
            font-size: 12px;
        }
        a.link_color {
            color: #b80f0a;
        }
        .gj_term_accept span, .gj_auth_accept span {
            vertical-align: top;
            margin-left: 5px;
        }
        .gj_checkbox_wrapper_1 {
            box-sizing: border-box;
            --background-color: #fff;
            --checkbox-height: 15px;
        }

        @-moz-keyframes gj_dothabottomcheck {
            0% {
            height: 0;
            }
            100% {
            height: calc(var(--checkbox-height) / 2);
            }
        }

        @-webkit-keyframes gj_dothabottomcheck {
            0% {
            height: 0;
            }
            100% {
            height: calc(var(--checkbox-height) / 2);
            }
        }

        @keyframes gj_dothabottomcheck {
            0% {
            height: 0;
            }
            100% {
            height: calc(var(--checkbox-height) / 2);
            }
        }

        @keyframes gj_dothatopcheck {
            0% {
            height: 0;
            }
            50% {
            height: 0;
            }
            100% {
            height: calc(var(--checkbox-height) * 1.2);
            }
        }

        @-webkit-keyframes gj_dothatopcheck {
            0% {
            height: 0;
            }
            50% {
            height: 0;
            }
            100% {
            height: calc(var(--checkbox-height) * 1.2);
            }
        }

        @-moz-keyframes gj_dothatopcheck {
            0% {
            height: 0;
            }
            50% {
            height: 0;
            }
            100% {
            height: calc(var(--checkbox-height) * 1.2);
            }
        }

        .gj_checkbox_wrapper_1 input[type=checkbox] {
            display: none;
        }

        .gj_checkbox_wrapper_1 .gj_check_box {
            height: var(--checkbox-height);
            width: var(--checkbox-height);
            background-color: transparent;
            border: calc(var(--checkbox-height) * .1) solid #000;
            border-radius: 5px;
            position: relative;
            top: 3px;
            display: inline-block;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            -moz-transition: border-color ease 0.2s;
            -o-transition: border-color ease 0.2s;
            -webkit-transition: border-color ease 0.2s;
            transition: border-color ease 0.2s;
            cursor: pointer;
        }
        .gj_checkbox_wrapper_1 .gj_check_box::before,
        .gj_checkbox_wrapper_1 .gj_check_box::after {
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            position: absolute;
            height: 0;
            width: calc(var(--checkbox-height) * .2);
            background-color: #34b93d;
            display: inline-block;
            -moz-transform-origin: left top;
            -ms-transform-origin: left top;
            -o-transform-origin: left top;
            -webkit-transform-origin: left top;
            transform-origin: left top;
            border-radius: 5px;
            content: " ";
            -webkit-transition: opacity ease 0.5;
            -moz-transition: opacity ease 0.5;
            transition: opacity ease 0.5;
        }
        .gj_checkbox_wrapper_1 .gj_check_box::before {
            top: calc(var(--checkbox-height) * .72);
            left: calc(var(--checkbox-height) * .41);
            box-shadow: 0 0 0 calc(var(--checkbox-height) * .05) var(--background-color);
            -moz-transform: rotate(-135deg);
            -ms-transform: rotate(-135deg);
            -o-transform: rotate(-135deg);
            -webkit-transform: rotate(-135deg);
            transform: rotate(-135deg);
        }
        .gj_checkbox_wrapper_1 .gj_check_box::after {
            top: calc(var(--checkbox-height) * .37);
            left: calc(var(--checkbox-height) * .05);
            -moz-transform: rotate(-45deg);
            -ms-transform: rotate(-45deg);
            -o-transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }

        .gj_checkbox_wrapper_1 input[type=checkbox]:checked + .gj_check_box,
        .gj_checkbox_wrapper_1 .gj_check_box.checked {
            border-color: #34b93d;
        }
        .gj_checkbox_wrapper_1 input[type=checkbox]:checked + .gj_check_box::after,
        .gj_checkbox_wrapper_1 .gj_check_box.checked::after {
            height: calc(var(--checkbox-height) / 2);
            -moz-animation: gj_dothabottomcheck 0.2s ease 0s forwards;
            -o-animation: gj_dothabottomcheck 0.2s ease 0s forwards;
            -webkit-animation: gj_dothabottomcheck 0.2s ease 0s forwards;
            animation: gj_dothabottomcheck 0.2s ease 0s forwards;
        }
        .gj_checkbox_wrapper_1 input[type=checkbox]:checked + .gj_check_box::before,
        .gj_checkbox_wrapper_1 .gj_check_box.checked::before {
            height: calc(var(--checkbox-height) * 1.2);
            -moz-animation: gj_dothatopcheck 0.4s ease 0s forwards;
            -o-animation: gj_dothatopcheck 0.4s ease 0s forwards;
            -webkit-animation: gj_dothatopcheck 0.4s ease 0s forwards;
            animation: gj_dothatopcheck 0.4s ease 0s forwards;
        }

        .gj_taf_det_div table {
            background: #fff;
            margin-bottom: 35px;
        }
        i.valid_icon {
            color: #10dc10;
            cursor: pointer;
            font-size: 18px;
            margin-right: 20px;
            border: 1px solid #10dc10;
            padding: 4px;
            margin-bottom: 15px;
        }
        i.not_valid_icon {
            color: #dc3210;
            cursor: pointer;
            font-size: 18px;
            border: 1px solid #dc3210;
            padding: 4px;
            margin-bottom: 15px;
        }
        i.valid_icon {
            color: #10dc10;
            cursor: pointer;
            font-size: 18px;
            margin-right: 20px;
            border: 1px solid #10dc10;
            padding: 4px;
            margin-bottom: 15px;
        }
        i.not_valid_icon {
            color: #dc3210;
            cursor: pointer;
            font-size: 18px;
            border: 1px solid #dc3210;
            padding: 4px;
            margin-bottom: 15px;
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
        <div class="wraper container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="gj_alert_msg"></div>
                    @include('admin.includes.message')
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <h1 class="pull-left page-title">Tutor Application Form - {{ @$taf_data->taf_id }}<br/><p class="small_tag">This section contains information and access to the tutor application form.  </p></h1>
                    <ol class="breadcrumb pull-right">
                        <li> <a href="{{ route('admin_tutor_application_form_list') }}"><i class="fas fa-backward"></i> Back</a></li>

                        @if(@$previous_id)
                            <li> <a href="{{ route('admin_tutor_application_form_view',@$previous_id) }}"><i class="fas fa-angle-double-left"></i> Previous</a></li>
                        @endif

                        @if(@$next_id)
                            <li> <a href="{{ route('admin_tutor_application_form_view',@$next_id) }}"><i class="fas fa-angle-double-right"></i> Next</a></li>
                        @endif
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="gj_taf_det_div">
                        <h5 class="gj_taf_det_info_hd">Application Details</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Application ID</th>
                                        <td>{{ @$taf_data->taf_id }}</td>
                                        <th>Application Date</th>
                                        <td>{{ @$taf_data->created_at ? date('d M Y', strtotime($taf_data->created_at)) : '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Applicant Name</th>
                                        <td>{{ (isset($taf_data->getTutor->f_name) && $taf_data->getTutor->f_name) ? $taf_data->getTutor->f_name : @$taf_data->first_name }}</td>
                                        <th>Application Status</th>
                                        <td>
                                            @if (@$taf_data->status == 1)
                                                {{ 'Accepted' }}
                                            @elseif (@$taf_data->status == 2)
                                                {{ 'Rejected' }}
                                            @elseif (@$taf_data->status == 3)
                                                {{ 'Submitted' }}
                                            @elseif (@$taf_data->status == 4)
                                                {{ 'In Progress' }}
                                            @else
                                                {{ '-' }}
                                            @endif
                                        </td>
                                    </tr>

                                    @if (@$taf_data->status == 2 && @$taf_data->status_remark)
                                        <tr>
                                            <th>Reason</th>
                                            <td colspan="3">{{ @$taf_data->status_remark }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="gj_adm_tab_sec">
                        <div class="ui top attached tabular menu">
                            <a class="item active" data-tab="tab1">Personal Details</a>
                            <a class="item" data-tab="tab2">Tutoring Details</a>
                            <a class="item" data-tab="tab3">Demographic Details</a>
                            <a class="item" data-tab="tab4">Compliance</a>
                            <a class="item" data-tab="tab5">Behaviour-based</a>
                            <a class="item" data-tab="tab6">Video Interview</a>
                            <a class="item" data-tab="tab7">Right to Work</a>
                            <a class="item" data-tab="tab8">Disclaimer</a>
                        </div>

                        <div class="ui bottom attached tab segment active tab1" data-tab="tab1">
                            <h5 class="gj_tab1_pers_info_div">Personal Details</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Full Legal Name</th>
                                            <td>{{ @$taf_data->first_name }} {{ @$taf_data->middle_name }} {{ @$taf_data->last_name }}</td>
                                            <th>Primary Email</th>
                                            <td>{{ @$taf_data->primary_email }}</td>
                                        </tr>

                                        <tr>
                                            <th>Primary Phone (Mobile)</th>
                                            <td>{{ @$taf_data->primary_phone }}</td>
                                            <th>DOB</th>
                                            <td>{{ @$taf_data->dob ? date("d M Y", strtotime(@$taf_data->dob)) : '' }}</td>
                                        </tr>

                                        <tr>
                                            <th>Nationality</th>
                                            <td>{{ @$taf_data->nationality }}</td>
                                            <th>Current Residency Status</th>
                                            <td>{{ @$taf_data->current_residency_status ? config('tutor_form.current_residency_status')[@$taf_data->current_residency_status] : '' }}</td>
                                        </tr>

                                        @if (@$taf_data->current_residency_status == 8)
                                            <tr>
                                                <th>Other Residency</th>
                                                <td colspan="3">{{ @$taf_data->current_residency }}</td>
                                            </tr>
                                        @endif
                                        
                                        <tr>
                                            @if (@$taf_data->disability_health_details)
                                                <th>Do you have any disability or health condition that we need to be aware of?</th>
                                                <td>
                                                    @if (@$taf_data->disability_health == 1)
                                                    {{ 'Yes' }}
                                                    @elseif (@$taf_data->disability_health == 2)
                                                        {{ 'No' }}
                                                    @else
                                                        {{ 'Not Answered' }}
                                                    @endif
                                                </td>
                                                <td colspan="2">{{ @$taf_data->disability_health_details }}</td>
                                            @else
                                                <th colspan="3">Do you have any disability or health condition that we need to be aware of?</th>
                                                <td>
                                                    @if (@$taf_data->disability_health == 1)
                                                    {{ 'Yes' }}
                                                    @elseif (@$taf_data->disability_health == 2)
                                                        {{ 'No' }}
                                                    @else
                                                        {{ 'Not Answered' }}
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <h5 class="gj_tab1_com_addr_div">Communication Address</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Country</th>
                                            <td>{{ @$taf_data->com_addr_country }}</td>
                                            <th>State / Province / Region</th>
                                            <td>{{ @$taf_data->com_addr_state ? config('tutor_form.australian_states')[@$taf_data->com_addr_state] : '' }}</td>
                                        </tr>

                                        <tr>
                                            <th>Suburb / City</th>
                                            <td>{{ @$taf_data->com_addr_city }}</td>
                                            <th>Unit & Street Address</th>
                                            <td>{{ @$taf_data->com_addr_street }}</td>
                                        </tr>

                                        <tr>
                                            <th>Postcode</th>
                                            <td>{{ @$taf_data->com_addr_zip }}</td>
                                            <th>Time Zone</th>
                                            <td>{{ @$taf_data->com_addr_timezone }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <h5 class="gj_tab1_perm_addr_div">Permanent Address</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Permanent Address</th>
                                            <td colspan="3">{{ @$taf_data->pick_permanent_address == 2 ? 'Other' : 'Same as Communication Address'  }}</td>
                                        </tr>

                                        @if (@$taf_data->pick_permanent_address == 2)
                                            <tr>
                                                <th>State / Province / Region</th>
                                                <td>{{ @$taf_data->perm_addr_state ? config('tutor_form.australian_states')[@$taf_data->perm_addr_state] : '' }}</td>
                                                <th>Suburb / City</th>
                                                <td>{{ @$taf_data->perm_addr_city }}</td>
                                            </tr>

                                            <tr>
                                                <th>Unit & Street Address</th>
                                                <td>{{ @$taf_data->perm_addr_street }}</td>
                                                <th>Postcode</th>
                                                <td>{{ @$taf_data->perm_addr_zip }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="ui bottom attached tab segment tab2" data-tab="tab2">
                            {{-- <h5>Tutorship Info</h5> --}}
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>1. What subjects would you able to tutor?</th>
                                        </tr>
                                        <tr>
                                            @php
                                                $selectedSubjects = json_decode(@$taf_data->select_tutor_subjects ?? '[]', true);
                                                $subjectList = config('tutor_form.tutor_subjects');
                                            @endphp

                                            <td>
                                                {{ collect($selectedSubjects)->map(fn($id) => $subjectList[$id] ?? null)->filter()->implode(', ') }}
                                                @if (@$taf_data->tutor_subjects)
                                                    : {{ @$taf_data->tutor_subjects ? $taf_data->tutor_subjects : '' }}
                                                @endif
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th>2. Would you able to assist with ancillary subject related activities for students?</th>
                                        </tr>
                                        <tr>
                                            @php
                                                $selectedAssit = json_decode(@$taf_data->select_assist ?? '[]', true);
                                                $assitList = config('tutor_form.assist');
                                            @endphp

                                            <td>{{ collect($selectedAssit)->map(fn($id) => $assitList[$id] ?? null)->filter()->implode(', ') }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th>3. What are the grades that you would be able to tutor?</th>
                                        </tr>
                                        <tr>
                                            @php
                                                $selectedGrades = json_decode(@$taf_data->select_tutor_grade ?? '[]', true);
                                                $gradesList = config('tutor_form.grades');
                                            @endphp

                                            <td>{{ collect($selectedGrades)->map(fn($id) => $gradesList[$id] ?? null)->filter()->implode(', ') }}</td>
                                        </tr>

                                        <tr>
                                            <th>4. What is your current status as a tutor?</th>
                                        </tr>
                                        <tr>
                                            <td>{{ @$taf_data->select_tutor_status ? config('tutor_form.tutor_current_status')[@$taf_data->select_tutor_status] : '' }}</td>
                                        </tr>

                                        <tr>
                                            <th>5. Can you tell us about your qualifications and merits as a tutor?</th>
                                        </tr>
                                        <tr>
                                            <td>{{ @$taf_data->select_merits ? config('tutor_form.merits')[@$taf_data->select_merits] : '' }}</td>
                                        </tr>

                                        <tr>
                                            <th>6. How many hours can you commit per week for online tutoring?</th>
                                        </tr>
                                        <tr>
                                            <td>{{ @$taf_data->select_commit_per_week ? config('tutor_form.commit_per_week')[@$taf_data->select_commit_per_week] : '' }}</td>
                                        </tr>

                                        <tr>
                                            <th>7. What is your experience in conducting online sessions for students?</th>
                                        </tr>
                                        <tr>
                                            <td>{{ @$taf_data->select_online_class_experience ? config('tutor_form.online_class_experience')[@$taf_data->select_online_class_experience] : '' }}</td>
                                        </tr>

                                        <tr>
                                            <th>8. Can you tell us about your status of Working with Children Check (WWCC)?</th>
                                        </tr>
                                        <tr>
                                            <td>{{ @$taf_data->select_wwcc ? config('tutor_form.wwcc')[@$taf_data->select_wwcc] : '' }}</td>
                                        </tr>

                                        <tr>
                                            <th>9. Would you be able to assist with capability building activities with us from time-to-time?</th>
                                        </tr>
                                        <tr>
                                            <td>{{ @$taf_data->select_building_activities ? config('tutor_form.building_activities')[@$taf_data->select_building_activities] : '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="ui bottom attached tab segment tab3" data-tab="tab3">
                            {{-- <h5>Demographic Info</h5> --}}
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>1. State the languages known to you</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Native language / Mother tongue: {{ @$taf_data->mother_tongue ? $taf_data->mother_tongue : '' }}</p>
                                                <p>Primary communication language: {{ @$taf_data->primary_communication_language ? $taf_data->primary_communication_language : '' }}</p>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th>2. State your English language proficiency in verbal communication?</th>
                                        </tr>
                                        <tr>
                                            <td>{{ @$taf_data->select_english_language_proficiency ? config('tutor_form.english_language_proficiency')[@$taf_data->select_english_language_proficiency] : '' }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th>3. Do you have any kids for whom you are a biological parent (father/mother)?</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if (@$taf_data->select_biological_parent == 1)
                                                    {{ 'Yes' }}
                                                @elseif (@$taf_data->select_biological_parent == 2)
                                                    {{ 'No' }}
                                                @else
                                                    {{ 'Not Answered' }}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>4. Do you live with any children at home for whom you are not a biological parent (foster child, relative kids, adopted children)?</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if (@$taf_data->select_not_biological_parent == 1)
                                                    {{ 'Yes' }}
                                                @elseif (@$taf_data->select_not_biological_parent == 2)
                                                    {{ 'No' }}
                                                @else
                                                    {{ 'Not Answered' }}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>5. Do you have any family history of domestic violence or abuse in which you were an affected party (victim)?</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if (@$taf_data->select_domestic_violence == 1)
                                                    {{ 'Yes' }}
                                                @elseif (@$taf_data->select_domestic_violence == 2)
                                                    {{ 'No' }}
                                                @else
                                                    {{ 'Not Answered' }}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>6. Are you addicted to drugs (medicinal or recreational) that could impair your mental ability from performing as a tutor?</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if (@$taf_data->select_addicted_to_drugs == 1)
                                                    {{ 'Yes' }}
                                                @elseif (@$taf_data->select_addicted_to_drugs == 2)
                                                    {{ 'No' }}
                                                @else
                                                    {{ 'Not Answered' }}
                                                @endif
                                            </td>
                                        </tr>

                                        @if ((@$taf_data->select_addicted_to_drugs == 1) && @$taf_data->select_addicted_to_drugs_details)
                                            <tr>
                                                <td>{{ @$taf_data->select_addicted_to_drugs_details }}</td>
                                            </tr>                                    
                                        @endif

                                        <tr>
                                            <th>7. Do you have any reservations or considerations about showing your face in online sessions?</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if (@$taf_data->select_showing_your_face == 1)
                                                    {{ 'Yes' }}
                                                @elseif (@$taf_data->select_showing_your_face == 2)
                                                    {{ 'No' }}
                                                @else
                                                    {{ 'Not Answered' }}
                                                @endif
                                            </td>
                                        </tr>

                                        @if ((@$taf_data->select_showing_your_face == 1) && @$taf_data->select_showing_your_face_details)
                                            <tr>
                                                <td>{{ @$taf_data->select_showing_your_face_details }}</td>
                                            </tr>                                    
                                        @endif

                                        <tr>
                                            <th>8. Have you worked with or interacted or worked with children (below 16) in any capacity in the past?</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if (@$taf_data->select_worked_children == 1)
                                                    {{ 'Yes' }}
                                                @elseif (@$taf_data->select_worked_children == 2)
                                                    {{ 'No' }}
                                                @else
                                                    {{ 'Not Answered' }}
                                                @endif
                                            </td>
                                        </tr>

                                        @if ((@$taf_data->select_worked_children == 1) && @$taf_data->worked_children)
                                            <tr>
                                                <td>{{ @$taf_data->worked_children }}</td>
                                            </tr>                                    
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="ui bottom attached tab segment tab4" data-tab="tab4">
                            {{-- <h5>Compliance Info</h5> --}}
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>1. Do you have a valid Working with Children Check (WWCC)?</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if (@$taf_data->select_working_wwcc == 1)
                                                    {{ 'Yes' }}
                                                @elseif (@$taf_data->select_working_wwcc == 2)
                                                    {{ 'No' }}
                                                @else
                                                    {{ 'Not Answered' }}
                                                @endif
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th>Please select the Australian States that you have valid WWCC checks for.</th>
                                        </tr>
                                        <tr>
                                            @php
                                                $selectedAusState = json_decode(@$taf_data->select_australian_states_wwcc ?? '[]', true);
                                                $aus_state = config('tutor_form.australian_states');
                                            @endphp

                                            <td>{{ collect($selectedAusState)->map(fn($id) => $aus_state[$id] ?? null)->filter()->implode(', ') }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th>2. Have you ever been convicted or found guilty of a crime in Australia or any country of your residence past or present?</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if (@$taf_data->select_crime_in_any_country == 1)
                                                    {{ 'Yes' }}
                                                @elseif (@$taf_data->select_crime_in_any_country == 2)
                                                    {{ 'No' }}
                                                @else
                                                    {{ 'Not Answered' }}
                                                @endif
                                            </td>
                                        </tr>
                                        @if ((@$taf_data->select_crime_in_any_country == 1) && @$taf_data->crime_in_any_country)
                                            <tr>
                                                <td >{{ @$taf_data->crime_in_any_country }}</td>
                                            </tr>
                                        @endif
                                        
                                        <tr>
                                            <th>3. Do you have any pending criminal cases on court awaiting judgement?</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if (@$taf_data->select_pending_criminal_cases == 1)
                                                    {{ 'Yes' }}
                                                @elseif (@$taf_data->select_pending_criminal_cases == 2)
                                                    {{ 'No' }}
                                                @else
                                                    {{ 'Not Answered' }}
                                                @endif
                                            </td>
                                        </tr>
                                        @if ((@$taf_data->select_pending_criminal_cases == 1) && @$taf_data->pending_criminal_cases)
                                            <tr>
                                                <td >{{ @$taf_data->pending_criminal_cases }}</td>
                                            </tr>
                                        @endif
                                        
                                        <tr>
                                            <th>4. Have you ever been convicted or found guilty of children related offences?</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if (@$taf_data->select_children_related_offences == 1)
                                                    {{ 'Yes' }}
                                                @elseif (@$taf_data->select_children_related_offences == 2)
                                                    {{ 'No' }}
                                                @else
                                                    {{ 'Not Answered' }}
                                                @endif
                                            </td>
                                        </tr>
                                        @if ((@$taf_data->select_children_related_offences == 1) && @$taf_data->children_related_offences)
                                            <tr>
                                                <td >{{ @$taf_data->children_related_offences }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="ui bottom attached tab segment tab5" data-tab="tab5">
                            {{-- <h5>Behaviour-based Info</h5> --}}
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>What motivated you to apply as a tutor with V-Tutor?</th>
                                        </tr>
                                        <tr>
                                            <td>{{ @$taf_data->motivated_tutor }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th>What is teaching or tutoring according to your belief and values?</th>
                                        </tr>
                                        <tr>
                                            <td>{{ @$taf_data->belief_values }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th>How would you ensure that a student who attends your session has understood the topic?</th>
                                        </tr>
                                        <tr>
                                            <td>{{ @$taf_data->understood_topic }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th>What would be your approach to a student who joins late to an online session and shows limited or no attention?</th>
                                        </tr>
                                        <tr>
                                            <td>{{ @$taf_data->late_online_session }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th>A parent who has been watching your online session intervene and complain (challenge) your teaching methods as incorrect. How would you react and respond to that challenge and accusation?</th>
                                        </tr>
                                        <tr>
                                            <td>{{ @$taf_data->parent_watching }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th>Why should you be recruited as a tutor? Feel free to mention your academic achievements, if any.</th>
                                        </tr>
                                        <tr>
                                            <td>{{ @$taf_data->academic_achievements }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="ui bottom attached tab segment tab6" data-tab="tab6">
                            {{-- <h5>Video Interview Info</h5> --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="gj_vid_div">
                                        @php
                                            $videoPath = public_path('storage/admin/videos/' . @$taf_data->video_interview);
                                        @endphp

                                        @if(file_exists($videoPath) && @$taf_data->video_interview)
                                            <video poster="{{ public_asset('assets/images/video_interview_image.webp')}}" controls controlsList="nodownload">
                                                <source src="{{ env('STORAGE_URL') . 'admin/videos/' . @$taf_data->video_interview }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <p class="no_vid">Video Interview not available</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ui bottom attached tab segment tab7" data-tab="tab7">
                            {{-- <h5>Right to Work Info</h5> --}}
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="gj_vw_wwcc_hd">Working with Children Check (WWCC)</td>
                                        </tr>
                                        <tr>
                                            <th>State</th>
                                            <th>WWCC #</th>
                                            <th>Date of Expiry</th>
                                            <th>WWCC DOC</th>
                                            <th>Authorised</th>
                                        </tr>
                                        
                                        @if (is_array(config('tutor_form.australian_states')))
                                            @php
                                                $wwccData = collect(@$taf_wwcc ?? [])->keyBy('states');
                                            @endphp
                                            @foreach (config('tutor_form.australian_states') as $wwcc_chk_k => $wwcc_chk_v)
                                                @php
                                                    $ext_wwcc_chk_k = @$wwccData[$wwcc_chk_k] ?? null;
                                                @endphp
                                                
                                                <tr>
                                                    <td>{{ $wwcc_chk_v }}</td>
                                                    <td>{{ $ext_wwcc_chk_k['wwcc_no'] ?? '-' }}</td>
                                                    <td>{{ (isset($ext_wwcc_chk_k['expiry_date']) && $ext_wwcc_chk_k['expiry_date']) ? date('d M Y', strtotime($ext_wwcc_chk_k['expiry_date'])) : '-' }}</td>
                                                    <td>
                                                        @if (isset($ext_wwcc_chk_k['wwcc_doc']) && $ext_wwcc_chk_k['wwcc_doc'])
                                                            <a href="{{ $ext_wwcc_chk_k['wwcc_doc'] ? public_asset($ext_wwcc_chk_k['wwcc_doc']) : '' }}" target="_blank" class="wwcc_doc_file">View Doc</a>     
                                                        @else
                                                            {{ '-' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{-- @if (isset($ext_wwcc_chk_k['wwcc_no']) && $ext_wwcc_chk_k['wwcc_no'])
                                                            <input type="checkbox" {{ (isset($ext_wwcc_chk_k['is_valid']) && $ext_wwcc_chk_k['is_valid'] == 1) ? 'checked' : '' }} data-id="{{ $ext_wwcc_chk_k['id'] }}" class="is_valid">
                                                        @endif --}}
                                                        
                                                        @if (isset($ext_wwcc_chk_k['is_valid']) && $ext_wwcc_chk_k['is_valid'] == 3)
                                                            <i class="fa fa-check is_valid valid_icon" data-id="{{ $ext_wwcc_chk_k['id'] }}"></i>

                                                            <i class="fa fa-times is_not_valid not_valid_icon" data-id="{{ $ext_wwcc_chk_k['id'] }}"></i>
                                                            
                                                            <p class="gj_p_ane">Not Validated</p>
                                                        @elseif (isset($ext_wwcc_chk_k['is_valid']) && $ext_wwcc_chk_k['is_valid'] == 2)
                                                            {{ 'No' }}
                                                        @elseif (isset($ext_wwcc_chk_k['is_valid']) && $ext_wwcc_chk_k['is_valid'] == 1)
                                                            {{ 'Yes' }}
                                                        @else
                                                            {{ '-' }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="ui bottom attached tab segment tab8" data-tab="tab8">
                            {{-- <h5>Disclaimer Info</h5> --}}
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="row">                            
                                                    <div class="col-md-12 col-sm-12 col-xs-12 col-12">
                                                        <p class="gj_disclaimer_note">By submitting your application through this website, you acknowledge and agree to the following terms: </p>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">   
                                                    <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                                        <div class="gj_dis_div">
                                                            <ol class="gj_dis_ol">
                                                                <li>
                                                                    <h5>Purpose of Information Collection</h5>
                                                                    <p>You understand that the personal information you provide, including but not limited to your identity, qualifications, employment history, and work authorisation status (e.g., visa, WWCC), is collected for the purpose of assessing your skills, capabilities, and overall suitability for roles or opportunities that may be offered by or through V-Tutor. </p>
                                                                </li>
                                                                
                                                                <li>
                                                                    <h5>No Guarantee of Selection or Engagement</h5>
                                                                    <p>Submission of an application does not constitute an offer of employment, engagement, or any form of commitment by V-Tutor. We reserve the sole and absolute right to accept or reject any application at our full discretion, without the need to provide reasons or justification.</p>
                                                                </li>
                                                                
                                                                <li>
                                                                    <h5>Accuracy of Information</h5>
                                                                    <p>You are responsible for ensuring the accuracy and completeness of all information submitted. V-Tutor accepts no liability for decisions based on false, misleading, or incomplete information provided by you or third-party data sources. </p>
                                                                </li>
                                                                
                                                                <li>
                                                                    <h5>Use of Third-Party Verification </h5>
                                                                    <p>We may verify your information with authorised third-party services (such as government-issued identity or work entitlement systems) where necessary. Your data will be handled in accordance with our Privacy Policy and applicable Australian privacy legislation. </p>
                                                                </li>
                                                                
                                                                <li>
                                                                    <h5>Limitation of Liability </h5>
                                                                    <p>To the maximum extent permitted by law, V-Tutor, its officers, agents, and affiliates shall not be held liable for any direct, indirect, incidental, or consequential loss, damage, or claim arising out of or in connection with: </p>

                                                                    <ul>
                                                                        <li>the use of this website;</li>
                                                                        <li>the submission of your personal data;</li>
                                                                        <li>any decision to accept or reject your application;</li>
                                                                        <li>or any delay or failure to engage your services.</li>
                                                                    </ul>
                                                                </li>
                                                                
                                                                <li>
                                                                    <h5>Indemnity </h5>
                                                                    <p>You agree to indemnify and hold harmless V-Tutor from any claims, losses, liabilities, costs, or expenses (including legal fees) arising from or related to:</p>

                                                                    <ul>
                                                                        <li>your use of the website or services, </li>
                                                                        <li>your application submission, </li>
                                                                        <li>or any breach of these terms. </li>
                                                                    </ul>
                                                                </li>
                                                                
                                                                <li>
                                                                    <h5>Right to Modify or Withdraw Services</h5>
                                                                    <p>V-Tutor reserves the right to modify, suspend, or discontinue any part of the application process or related services at any time without notice. </p>
                                                                </li>
                                                            </ol>
                                                        </div>
                                                    </div>
                                                </div>
                                                    
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 col-12 mb-3">
                                                        <p class="gj_dis_confirm">By proceeding, you confirm that you have read, understood, and accepted this disclaimer and all associated terms and conditions. </p>

                                                        <div class="gj_accept_div">
                                                            <div class="gj_auth_accept gj_checkbox_wrapper_1">
                                                                <input type="checkbox" {{ @$taf_data->choose_auth_accept == 1 ? 'checked' : '' }} disabled id="gj_check_box_2" class="choose_auth_accept">
                                                                <label for="gj_check_box_2" class="gj_check_box"></label>
                                                                <span>I have read the above terms and authorise the company to undertake relevant checks with respective agencies, government or private.</span>
                                                            </div>
                                                            
                                                            <div class="gj_term_accept gj_checkbox_wrapper_1">
                                                                <input type="checkbox" {{ @$taf_data->choose_term_accept == 1 ? 'checked' : '' }} disabled id="gj_check_box_1" class="choose_term_accept">
                                                                <label for="gj_check_box_1" class="gj_check_box"></label>
                                                                <span>I have read and agree to V-Tutor <a href="{{ url('privacy-policy') }}" target="_blank" class="link_color">Privacy Policy</a> and <a href="{{ url('terms-conditions') }}" target="_blank" class="link_color">Terms & Conditions</a>.</span>
                                                            </div>

                                                            <p class="gj_trade_note">*V-Tutor is a trading name of Afor Edventure Pty Ltd (ABN 58 651286 207)</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            @if (isset($taf_data->status) && $taf_data->status == 3)
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="gj_action_alert_msg"></div>

                                        <div class="gj_taf_but_div">
                                            <div class="rm05">
                                                <button data-id="{{ @$taf_data->id }}" class="btn btn-primary waves-effect waves-light w-md wwcc_valid_but" type="button">Validate WWCC</button>
                                            </div>

                                            <div class="rm05 action_but_div" style="display: none">
                                                <button class="btn btn-primary waves-effect waves-light w-md accept_taf" onclick="window.location.href='{{ route('admin_tutor_application_form_change_accept_status', @$taf_data->id) }}'" type="button">Accept</button>
                                            </div>
                                            
                                            <div class="rm05 action_but_div" style="display: none">
                                                <button class="btn btn-primary waves-effect waves-light w-md reject_taf" type="button">Reject</button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="gj_taf_rejappl_div" style="display: none">
                                        <form method="POST" action="{{ route('admin_tutor_application_form_change_reject_status') }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="form_id" value="{{ @$taf_data->id ?? '0' }}" class="form_id">
                                            <h5>Reason for Rejection</h5>
                                            
                                            <textarea rows="5" class="form-control" name="status_remark" placeholder="Enter reason(s) for rejection of application"></textarea>

                                            <div class="rm05">
                                                <button class="btn btn-primary waves-effect waves-light w-md reset_search" type="submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
    <script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>

    <script>
        $(document).ready(function(){
            $('.menu .item').tab(); 

            $(document).on('click', '.wwcc_valid_but', function (e) {
                if($(this).data('id')) {
                    var id = $(this).data('id');

                    $.ajax({
                        url: "{{ route('admin_tutor_application_form_validate_wwcc') }}",
                        method: "POST",
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response && response == 1) {
                                $('.wwcc_valid_but').hide();
                                $('.action_but_div').show();

                                $('.gj_action_alert_msg').html('<div class="alert alert-success alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>WWCC validation successful. Proceed to Accept / Reject the application.</div>');
                            } else if (response && response == 2) {
                                $('.gj_action_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>WWCC validation failed. Go to ‘Right to Work’ tab and validate WWCC.</div>');
                            } else {
                                $('.gj_action_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Something wrong, please try again later</div>');
                            }
                        },
                        error: function(xhr) {
                            $('.gj_action_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Something wrong, please try again later</div>');
                        }
                    });
                } else {
                    $('.gj_action_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Something wrong, please try again later</div>');
                }
            });
            
            $(document).on('click', '.reject_taf', function (e) {
                $('.gj_taf_rejappl_div').slideToggle('slow');
            });

            $(document).on('click', '.is_valid', function (e) {
                var is_valid = 1;
                var its = $(this);

                if($(this).data('id')) {
                    var wwcc_id = $(this).data('id');

                    $.ajax({
                        url: "{{ route('admin_tutor_application_form_change_wwcc_status') }}",
                        method: "POST",
                        data: {
                            is_valid: is_valid,
                            wwcc_id: wwcc_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response && response == 1) {
                                its.closest('td').text('Yes');
                                $('.gj_alert_msg').html('<div class="alert alert-success alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>WWCC validation status updated!</div>');
                            } else {
                                $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>WWCC validation status update failed!</div>');
                            }
                        },
                        error: function(xhr) {
                            $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Something wrong, please try again later</div>');
                        }
                    });
                } else {
                    $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Something wrong, please try again later</div>');
                }
            });

            $(document).on('click', '.is_not_valid', function (e) {
                var is_valid = 2;
                var its = $(this);

                if($(this).data('id')) {
                    var wwcc_id = $(this).data('id');

                    $.ajax({
                        url: "{{ route('admin_tutor_application_form_change_wwcc_status') }}",
                        method: "POST",
                        data: {
                            is_valid: is_valid,
                            wwcc_id: wwcc_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response && response == 1) {
                                its.closest('td').text('No');
                                $('.gj_alert_msg').html('<div class="alert alert-success alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>WWCC validation status updated!</div>');

                                $('.gj_alert_msg').html('<div class="alert alert-success alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>WWCC validation status updated!</div>');
                                $('.gj_alert_msg').html('<div class="alert alert-success alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>WWCC validation status updated!</div>');
                                $('.gj_alert_msg').html('<div class="alert alert-success alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>WWCC validation status updated!</div>');

                            } else {
                                $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>WWCC validation status update failed!</div>');
                                $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>WWCC validation status update failed!</div>');
                            }
                        },
                        error: function(xhr) {
                            $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Something wrong, please try again later</div>');
                        }
                    });
                } else {
                    $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Something wrong, please try again later</div>');
                }
            });
        });
    </script>
@endsection
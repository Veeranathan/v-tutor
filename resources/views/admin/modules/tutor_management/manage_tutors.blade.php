@extends('admin.layouts.app')
@section('title')
Tutor Management
@endsection
@section('links')
@include('admin.includes.links')
<script src="{{ public_asset('admin/assets/js/modernizr.min.js') }}"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>
    :root {
        --tm-navy: #0f1d4a;
        --tm-red: #d0021b;
        --tm-red-dark: #b00217;
        --tm-text: #1f2a44;
        --tm-muted: #5b6785;
        --tm-border: #dfe4ee;
        --tm-bg: #f6f8fc;
        --tm-radius: 10px;
    }

    .tm-page {
        color: var(--tm-text);
        font-family: "Inter", "Segoe UI", Roboto, Arial, sans-serif;
        padding-bottom: 30px;
    }

    .tm-page * {
        box-sizing: border-box;
    }

    .tm-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin: 10px 0 22px;
        flex-wrap: wrap;
    }

    .tm-title {
        margin: 0;
        font-size: 30px;
        font-weight: 800;
        color: var(--tm-navy);
        line-height: 1.2;
    }

    .tm-subtitle {
        margin: 6px 0 0;
        font-size: 16px;
        color: var(--tm-muted);
    }

    .tm-btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 42px;
        padding: 0 20px;
        background: #fff;
        color: var(--tm-navy);
        border: 1.5px solid var(--tm-navy);
        border-radius: 8px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: .2s;
    }

    .tm-btn-outline:hover {
        background: var(--tm-navy);
        color: #fff;
    }

    .tm-stats {
        display: flex;
        flex-wrap: nowrap;
        gap: 14px;
        margin-bottom: 24px;
    }

    @media (max-width: 991px) {
        .tm-stats {
            flex-wrap: wrap;
        }

        .tm-stat {
            flex: 1 1 45% !important;
        }
    }

    .tm-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 8px 16px;
        font-size: 14px;
    }

    .tm-stat {
        flex: 1 1 0;
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 18px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(15, 29, 74, .06);
        border: 1px solid rgba(15, 29, 74, .04);
    }

    .tm-stat i {
        font-size: 34px;
    }

    .tm-stat .tm-num {
        display: block;
        font-size: 32px;
        font-weight: 800;
        line-height: 1;
        color: var(--tm-navy);
    }

    .tm-stat .tm-lbl {
        display: block;
        margin-top: 6px;
        font-size: 16px;
        color: var(--tm-text);
    }

    .tm-stat.total {
        background: #e8effc;
    }

    .tm-stat.total i {
        color: #3b5bb5;
    }

    .tm-stat.approved {
        background: #e5f5e9;
    }

    .tm-stat.approved i {
        color: #1e8e3e;
    }

    .tm-stat.pending {
        background: #fff0dc;
    }

    .tm-stat.pending i {
        color: #f39c12;
    }

    .tm-stat.rejected {
        background: #f1e8fb;
    }

    .tm-stat.rejected i {
        color: #8e44ad;
    }

    .tm-stat.suspended {
        background: #fde6ea;
    }

    .tm-stat.suspended i {
        color: #d0021b;
    }

    .tm-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 20px;
    }

    .tm-tab {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        height: 48px;
        padding: 0 24px;
        background: #fff;
        color: var(--tm-navy);
        border: 1.5px solid var(--tm-border);
        border-radius: 8px;
        font-weight: 700;
        font-size: 16px;
        text-decoration: none !important;
        transition: .2s;
    }

    .tm-tab:hover {
        border-color: var(--tm-navy);
        color: var(--tm-navy);
    }

    .tm-tab.active {
        background: var(--tm-red);
        border-color: var(--tm-red);
        color: #fff;
    }

    .tm-card {
        background: var(--tm-bg);
        border: 1px solid var(--tm-border);
        border-radius: 14px;
        padding: 18px;
    }

    .tm-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: flex-end;
    }

    .tm-filters .tm-field {
        display: flex;
        flex-direction: column;
        min-width: 150px;
    }

    .tm-filters .tm-field.grow {
        flex: 1 1 280px;
    }

    .tm-filters label {
        font-size: 12px;
        font-weight: 600;
        color: var(--tm-muted);
        margin: 0 0 4px;
    }

    .tm-filters .form-control,
    .tm-filters select.form-control {
        height: 42px;
        border: 1px solid var(--tm-border);
        border-radius: 8px;
        background: #fff;
        font-size: 14px;
        color: var(--tm-text);
        box-shadow: none;
        padding: 6px 12px;
        width: 100%;
    }

    .tm-filters .form-control:focus {
        border-color: var(--tm-navy);
        outline: 0;
        box-shadow: 0 0 0 3px rgba(15, 29, 74, .08);
    }

    .tm-search-wrap {
        position: relative;
    }

    .tm-search-wrap i {
        position: absolute;
        left: 13px;
        top: 13px;
        color: var(--tm-muted);
    }

    .tm-search-wrap .form-control {
        padding-left: 38px;
    }

    .tm-filter-actions {
        display: flex;
        gap: 10px;
    }

    .tm-btn {
        height: 42px;
        padding: 0 20px;
        border-radius: 8px;
        border: 1.5px solid transparent;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: .2s;
    }

    .tm-btn-primary {
        background: var(--tm-red);
        color: #fff;
    }

    .tm-btn-primary:hover {
        background: var(--tm-red-dark);
    }

    .tm-btn-light {
        background: #fff;
        color: var(--tm-navy);
        border-color: var(--tm-border);
    }

    .tm-btn-light:hover {
        border-color: var(--tm-navy);
    }

    .tm-more {
        display: none;
        width: 100%;
        padding-top: 12px;
        margin-top: 4px;
        border-top: 1px dashed var(--tm-border);
    }

    .tm-more.open {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .tm-more .tm-field {
        flex: 1 1 200px;
    }

    .tm-more .error {
        color: #ef5350;
        font-size: 12px;
    }

    .tm-more .ui.calendar .ui.input {
        position: relative;
        display: block;
    }

    .tm-more .over_llp1 {
        position: absolute;
        right: 12px;
        top: 11px;
    }

    .tm-more .over_llp1 img {
        width: 18px;
    }

    .tm-table-wrap {
        background: #fff;
        border: 1px solid var(--tm-border);
        border-radius: 12px;
        margin-top: 16px;
        padding: 4px 14px 14px;
        overflow: hidden;
    }

    #example {
        width: 100% !important;
        border: 0 !important;
        margin: 0 !important;
        border-collapse: collapse !important;
    }

    #example thead th {
        background: #eef1f7;
        color: var(--tm-navy);
        font-weight: 700;
        font-size: 15px;
        padding: 14px 16px !important;
        border: 0 !important;
        white-space: nowrap;
    }

    #example thead th:first-child {
        border-radius: 8px 0 0 8px;
    }

    #example thead th:last-child {
        border-radius: 0 8px 8px 0;
    }

    #example tbody td {
        padding: 14px 16px !important;
        vertical-align: middle !important;
        border: 0 !important;
        border-bottom: 1px solid #edf0f6 !important;
        font-size: 14px;
        color: var(--tm-text);
        background: #fff !important;
    }

    #example tbody tr:hover td {
        background: #fafbff !important;
    }

    #example.dataTable.no-footer {
        border-bottom: 0;
    }

    table.dataTable thead .sorting,
    table.dataTable thead .sorting_asc,
    table.dataTable thead .sorting_desc {
        background-color: #eef1f7;
    }

    .tm-tutor {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .tm-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #dfe6fb;
        color: #3b4f9e;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 15px;
        flex-shrink: 0;
    }

    .tm-tutor-name {
        display: block;
        font-weight: 700;
        font-size: 15px;
        color: var(--tm-navy);
    }

    .tm-tutor-id {
        display: block;
        font-size: 13px;
        color: var(--tm-muted);
    }

    .green_color,
    .pending_color,
    .suspend_color,
    .reject_color {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
    }

    .green_color {
        background: #d8f2dd;
        color: #1b7a34;
    }

    .green_color:before {
        content: "\f058";
        font-family: FontAwesome, "Font Awesome 5 Free";
        font-weight: 900;
    }

    .pending_color {
        background: #fff0cf;
        color: #b9770e;
    }

    .suspend_color {
        background: #fde0e4;
        color: #c0152a;
    }

    .reject_color {
        background: #f1e3fa;
        color: #7d3c98;
    }

    .gj_reason_qc {
        margin-left: 6px;
        color: var(--tm-muted);
        cursor: pointer;
    }

    .tm-avail {
        font-weight: 600;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 46px;
        height: 22px;
        margin: 0;
    }

    .switch input {
        display: none;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 2px;
        bottom: 2px;
        background: #fff;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #28a745;
    }

    input:checked+.slider:before {
        transform: translateX(24px);
    }

    .tm-actions {
        position: relative;
        display: inline-block;
    }

    .tm-manage {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 38px;
        padding: 0 18px;
        background: #fff;
        color: var(--tm-navy) !important;
        border: 1.5px solid var(--tm-navy);
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none !important;
        cursor: pointer;
    }

    .tm-manage:hover {
        background: var(--tm-navy);
        color: #fff !important;
    }

    .show-actions {
        position: absolute;
        right: 0;
        top: 44px;
        background: #fff;
        border: 1px solid var(--tm-border);
        border-radius: 8px;
        min-width: 150px;
        z-index: 9999;
        padding: 6px 0;
        box-shadow: 0 6px 18px rgba(15, 29, 74, .15);
        display: none;
    }

    .show-actions ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .show-actions ul li a {
        display: block;
        padding: 9px 16px;
        text-decoration: none;
        color: var(--tm-text);
        font-size: 14px;
    }

    .show-actions ul li a:hover {
        background: #f3f5fb;
        color: var(--tm-red);
    }

    .show-actions .angle {
        display: none;
    }

    .dataTables_wrapper .dataTables_info {
        padding-top: 16px;
        color: var(--tm-muted);
        font-size: 13px;
    }

    .dataTables_wrapper .dataTables_paginate {
        padding-top: 12px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 6px !important;
        border: 1px solid var(--tm-border) !important;
        background: #fff !important;
        color: var(--tm-navy) !important;
        margin: 0 2px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--tm-red) !important;
        border-color: var(--tm-red) !important;
        color: #fff !important;
    }

    .dataTables_wrapper .dataTables_processing {
        background: rgba(255, 255, 255, .9);
        border-radius: 8px;
        color: var(--tm-navy);
        font-weight: 600;
    }

    .adminpasswordPopup .modal-content {
        border: 0;
        border-radius: 12px;
        overflow: hidden;
    }

    .adminpasswordPopup .modal-header {
        background: var(--tm-navy);
        color: #fff;
        border: 0;
    }

    .adminpasswordPopup .modal-header .close {
        color: #fff;
        opacity: 1;
    }

    .adminpasswordPopup .modal-title {
        color: #fff;
    }

    .adminpasswordPopup .modal-footer {
        border: 0;
        justify-content: center;
        gap: 10px;
    }

    .adminpasswordPopup .gj_popup_warning {
        color: #c0152a;
        font-size: 13px;
    }

    @media (max-width: 767px) {
        .tm-title {
            font-size: 24px;
        }

        .tm-tab {
            flex: 1 1 100%;
            justify-content: center;
        }

        .tm-filters .tm-field {
            min-width: 100%;
        }
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
    <div class="container tm-page">

        <div class="tm-header">
            <div>
                <h1 class="tm-title">Tutor Management</h1>
                <p class="tm-subtitle">Manage tutor profiles, approvals, capabilities and availability.</p>
            </div>
            <button class="tm-btn-outline download" id="download" type="submit" form="tutorFilterForm">
                <i class="fa fa-download"></i> Export
            </button>
        </div>

        <div class="tm-stats">
            <div class="tm-stat total">
                <i class="fa fa-users"></i>
                <div><span class="tm-num" id="total_tutors">{{ (int)@$tot_active + (int)@$total_approve + (int)@$total_reject + (int)@$tot_inactive }}</span><span class="tm-lbl">Total Tutors</span></div>
            </div>
            <div class="tm-stat approved">
                <i class="fa fa-check-circle"></i>
                <div><span class="tm-num" id="total_approve">{{ @$total_approve }}</span><span class="tm-lbl">Approved</span></div>
            </div>
            <div class="tm-stat pending">
                <i class="fa fa-clock-o"></i>
                <div><span class="tm-num" id="total_active">{{ @$tot_active }}</span><span class="tm-lbl">Pending</span></div>
            </div>
            <div class="tm-stat rejected">
                <i class="fa fa-times-circle"></i>
                <div><span class="tm-num" id="total_reject">{{ @$total_reject }}</span><span class="tm-lbl">Rejected</span></div>
            </div>
            <div class="tm-stat suspended">
                <i class="fa fa-ban"></i>
                <div><span class="tm-num" id="total_inactive">{{ @$tot_inactive }}</span><span class="tm-lbl">Suspended</span></div>
            </div>
        </div>

        <div class="tm-tabs">
            <a href="javascript:void(0);" class="tm-tab active"><i class="fa fa-users"></i> All Tutors</a>
            <a href="javascript:void(0);" class="tm-tab"><i class="fa fa-shield"></i> Compliance</a>
            <a href="javascript:void(0);" class="tm-tab"><i class="fa fa-th-large"></i> Program Capabilities</a>
            <a href="javascript:void(0);" class="tm-tab"><i class="fa fa-id-card-o"></i> Profile Management</a>
        </div>

        <div class="tm-card">
            @include('admin.includes.message')

            <form method="get" id="tutorFilterForm" action="{{ route('tutor.management.list.tab') }}">
                <div class="tm-filters">
                    <div class="tm-field grow" data-column="1">
                        <label for="col1_filter">Name / Email / Phone / Tutor ID</label>
                        <div class="tm-search-wrap">
                            <i class="fa fa-search"></i>
                            <input type="text" placeholder="Search tutor name, email, phone or ID" id="col1_filter" name="col1_filter" class="form-control reset_val" value="" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                        </div>
                    </div>

                    <div class="tm-field" data-column="2">
                        <label for="col2_filter">Status</label>
                        <select id="col2_filter" name="col2_filter" class="form-control reset_val">
                            <option value="">Select Status</option>
                            <option value="A">Pending</option>
                            <option value="AP">Approved</option>
                            <option value="R">Rejected</option>
                            <option value="I">Suspended</option>
                        </select>
                    </div>

                    <div class="tm-field" data-column="6">
                        <label for="col5_filter">Availability</label>
                        <select id="col5_filter" name="col5_filter" class="form-control reset_val">
                            <option value="">Select Availability</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>

                    <div class="tm-field">
                        <label for="state_filter">State</label>
                        <select id="state_filter" name="state_filter" class="form-control reset_val">
                            <option value="">All States</option>

                            @foreach($states as $state)
                            <option value="{{ $state->id }}">
                                {{ $state->state_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="tm-field">
                        <label for="featured_filter">Featured</label>
                        <select id="featured_filter" name="featured_filter" class="form-control reset_val">
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="tm-filter-actions">
                        <button class="tm-btn tm-btn-light" type="button" id="toggleMoreFilters"><i class="fa fa-filter"></i> More filters</button>
                        <button class="tm-btn tm-btn-primary search_click" type="button">Search</button>
                        <button class="tm-btn tm-btn-light reset_search" type="button">Reset</button>
                    </div>

                    <div class="tm-more" id="moreFilters">
                        <div class="tm-field">
                            <label for="free_trial_filter">Free Trial</label>
                            <select id="free_trial_filter" name="free_trial_filter" class="form-control reset_val">
                                <option value="">Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="tm-field" data-column="3">
                            <label for="col3_filter">Search From Date</label>
                            <div class="ui calendar" id="from_date">
                                <div class="ui input left icon">
                                    <input type="text" id="col3_filter" name="col3_filter" placeholder="date joined from" class="form-control" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                    <span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
                                    <span class="error_from_date error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="tm-field" data-column="4">
                            <label for="col4_filter">Search To Date</label>
                            <div class="ui calendar" id="to_date">
                                <div class="ui input left icon">
                                    <input type="text" id="col4_filter" name="col4_filter" placeholder="date joined to" class="form-control" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                    <span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
                                    <span class="error_to_date error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="tm-table-wrap">
                <div class="table-responsive">
                    <table class="table" id="example">
                        <thead>
                            <tr>
                                <th>Tutor ID</th>
                                <th>Tutor</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date Joined</th>
                                <th>Availability</th>
                                <th>Featured</th>
                                <th>Free Trial</th>
                                <th class="mt_sts_col">Status</th>
                                <th>Closed on</th>
                                <th>Action</th>
                                <th>State</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===================== Modals (unchanged behaviour) ===================== --}}
<div class="modal res-modal newqusmo instructionModal adminpasswordPopup" id="approveTutorModal">
    <div class="modal-dialog modal-dialog-centered instructionModal">
        <div class="modal-content instructionModal">
            <div class="modal-header instructionModal">
                <h4 class="modal-title passText">Confirmation</h4>
                <button type="button" class="close" onclick="ClosePopupModel(this)" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body instructionModal noinsBodyDev">
                <div class="divs">
                    <div class="appome_input form_box_area cls1">
                        <div class="gj_confirm_div">
                            <p class="gj_popup_text">Are you sure you want to approve this tutor?</p>
                        </div>
                        <div class="gj_submit_div" style="display: none;">
                            <div class="app_frm_div">
                                <input type="email" name="zoom_email" id="zoom_email" class="form-control" placeholder="Enter Zoom Email ID">
                                <p class="zoom_email_error" style="color: #ef5350;"></p>
                            </div>
                            <button type="button" class="btn btn-new btn-danger" id="submit_approve" style="color: #b80f0a;" onclick="submitApproveFn(this)">Submit</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="" name="tut_id" id="tut_id">
            </div>
            <div class="modal-footer adm_modal_Footer">
                <button type="button" class="btn btn-new btn-danger" id="yes_tut_approve" onclick="approveTutorNow(this)" style="color: #b80f0a;">Yes</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-new btn-danger popup_no" onclick="ClosePopupModel(this)" style="color: #b80f0a;">No</button>
            </div>
        </div>
    </div>
</div>

<div class="modal res-modal newqusmo instructionModal adminpasswordPopup" id="rejectTutorModal">
    <div class="modal-dialog modal-dialog-centered instructionModal">
        <div class="modal-content instructionModal">
            <div class="modal-header instructionModal">
                <h4 class="modal-title passText gj_modal_title">Confirmation</h4>
                <button type="button" class="close" onclick="ClosePopupModel(this)" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body instructionModal noinsBodyDev">
                <div class="divs">
                    <div class="appome_input form_box_area cls1">
                        <div class="gj_confirm_div">
                            <p class="gj_popup_text">Are you sure you want to reject this tutor?</p>
                        </div>
                        <div class="gj_submit_div">
                            <textarea class="form-control" name="reject_reason" id="reject_reason" placeholder="Enter your reason"></textarea>
                            <p class="reject_reason_error" style="color: #ef5350;"></p>
                            <button type="button" class="btn btn-new btn-danger" id="submit_reject" style="color: #b80f0a;" onclick="submitRejectFn(this)">Submit</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="" name="rtut_id" id="rtut_id">
            </div>
            <div class="modal-footer adm_modal_Footer">
                <button type="button" class="btn btn-new btn-danger" id="yes_tut_reject" style="color: #b80f0a;" onclick="yesRejectFn(this)">Yes</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-new btn-danger popup_no" onclick="ClosePopupModel(this)" style="color: #b80f0a;">No</button>
            </div>
        </div>
    </div>
</div>

<div class="modal res-modal newqusmo instructionModal adminpasswordPopup" id="suspendTutorModal">
    <div class="modal-dialog modal-dialog-centered instructionModal">
        <div class="modal-content instructionModal">
            <div class="modal-header instructionModal">
                <h4 class="modal-title passText gj_modal_title">Confirmation</h4>
                <button type="button" class="close" onclick="ClosePopupModel(this)" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body instructionModal noinsBodyDev">
                <div class="divs">
                    <div class="appome_input form_box_area cls1">
                        <div class="gj_confirm_div">
                            <p class="gj_popup_text">Are you sure you want to suspend this tutor?</p>
                            <p class="gj_popup_warning">Warning: This action will disable the user’s ability to login. Consider the impact before proceeding.</p>
                        </div>
                        <div class="gj_submit_div">
                            <div class="gj_status_change_user"><span>Name: </span> <span>{{ @Auth::guard('admin')->user()->name }}</span></div>
                            <div class="gj_status_change_date"><span>Date: </span> <span>{{ date('d M Y') }}</span></div>
                            <textarea class="form-control" name="suspend_reason" id="suspend_reason" placeholder="Enter the reason"></textarea>
                            <p class="suspend_reason_error" style="color: #ef5350;"></p>
                            <button type="button" class="btn btn-new btn-danger" id="submit_suspend" style="color: #b80f0a;" onclick="submitSuspendFn(this)">Submit</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="" name="stut_id" id="stut_id">
            </div>
            <div class="modal-footer adm_modal_Footer">
                <button type="button" class="btn btn-new btn-danger" id="yes_tut_suspend" style="color: #b80f0a;" onclick="yesSuspendFn(this)">Yes</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-new btn-danger popup_no" onclick="ClosePopupModel(this)" style="color: #b80f0a;">No</button>
            </div>
        </div>
    </div>
</div>

<div class="modal res-modal newqusmo instructionModal adminpasswordPopup" id="adminReasonTutorModal">
    <div class="modal-dialog modal-dialog-centered instructionModal">
        <div class="modal-content instructionModal">
            <div class="modal-header instructionModal">
                <h4 class="modal-title passText gj_modal_title">Admin Reason</h4>
                <button type="button" class="close" onclick="ClosePopupModel(this)" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body instructionModal noinsBodyDev">
                <div class="divs">
                    <div class="appome_input form_box_area cls1">
                        <div class="gj_reason_div">
                            <ul>
                                <li class="gj_popupname_text text-left"></li>
                                <li class="gj_popupdate_text text-left"></li>
                                <li class="gj_popuprsn_text text-left"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer adm_modal_Footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-new btn-danger popup_no" onclick="ClosePopupModel(this)" style="color: #b80f0a;">Ok</button>
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
<script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" crossorigin="anonymous"></script>
<script type="text/javascript">
    function fmtDate(value) {
        if (!value) return '';
        var d = new Date(value);
        return ("0" + d.getDate()).slice(-2) + '-' + ("0" + (d.getMonth() + 1)).slice(-2) + '-' + d.getFullYear();
    }

    function initials(f, l) {
        return ((f ? f.charAt(0) : '') + (l ? l.charAt(0) : '')).toUpperCase() || '?';
    }

    function calFormatter() {
        return {
            date: function(date) {
                if (!date) return '';
                var day = ('0' + date.getDate()).slice(-2);
                var month = ('0' + (date.getMonth() + 1)).slice(-2);
                return date.getFullYear() + '-' + month + '-' + day;
            }
        };
    }

    $(document).ready(function() {
        $("#from_date").calendar({
            type: 'date',
            formatter: calFormatter()
        });
        $("#to_date").calendar({
            type: 'date',
            formatter: calFormatter()
        });

        // "More filters" toggle
        $('#toggleMoreFilters').on('click', function() {
            $('#moreFilters').toggleClass('open');
        });

        function filterColumn(i) {
            $('#example').DataTable().column(i).search($('#col' + i + '_filter').val()).draw();
        }

        function filterColumnForSelect(selectId, columnIndex) {
            $('#example').DataTable().column(columnIndex).search($('#' + selectId).val()).draw();
        }

        var dataTableObj = {
            "bStateSave": true,
            columnDefs: [{
                targets: 0,
                type: 'natural'
            }],
            stateSave: false,
            "order": [
                [4, "desc"]
            ],
            "stateLoadParams": function() {
                var p = localStorage.getItem("pageNo");
                table.page(p != null && !isNaN(parseInt(p)) ? parseInt(p) : 0).draw('page');
            },
            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            "language": {
                search: "",
                paginate: {
                    previous: "&lsaquo;",
                    next: "&rsaquo;"
                }
            },
            "createdRow": function(row, data) {
                $(row).addClass("tr_class_" + data.id).addClass("tr_row_class");
            },
            "ajax": {
                "url": "{{ route('list.tutors') }}",
                "data": function(d) {
                    d.myKey = "myValue";
                    d._token = "{{ @csrf_token() }}";
                },
                "dataSrc": function(response) {
                    $('#total_active').html(response.total_active);
                    $('#total_approve').html(response.total_approve);
                    $('#total_reject').html(response.total_reject);
                    $('#total_inactive').html(response.total_inactive);
                    $('#total_tutors').html(
                        (parseInt(response.total_active) || 0) + (parseInt(response.total_approve) || 0) +
                        (parseInt(response.total_reject) || 0) + (parseInt(response.total_inactive) || 0)
                    );
                    return response.aaData;
                },
                error: function() {
                    console.log("error in datatable");
                }
            },
            initComplete: function() {
                var p = localStorage.getItem("pageNo");
                table.page(p != null && !isNaN(parseInt(p)) ? parseInt(p) : 0).draw('page');
            },
            // NOTE: column order/indexes are unchanged so server-side column search keeps working.
            'columns': [{ // 0 Tutor ID (hidden, shown inside the Tutor cell)
                    data: "id",
                    visible: false,
                    render: function(data, type, full) {
                        return full.unique_id;
                    }
                },
                { // 1 Tutor (avatar + name + ID)
                    data: "id",
                    render: function(data, type, full) {
                        var name = '';
                        if (full.f_name != null) name += full.f_name + ' ';
                        if (full.l_name != null) name += full.l_name;
                        return '<div class="tm-tutor">' +
                            '<span class="tm-avatar">' + initials(full.f_name, full.l_name) + '</span>' +
                            '<div><span class="tm-tutor-name">' + name + '</span>' +
                            '<span class="tm-tutor-id">' + (full.unique_id || '') + '</span></div>' +
                            '</div>';
                    }
                },
                {
                    data: "email",
                    visible: false,
                    render: function(data) {
                        return data;
                    }
                },
                {
                    data: "phone",
                    visible: false,
                    render: function(data) {
                        return data;
                    }
                },
                {
                    data: "created_at",
                    visible: false,
                    render: function(data, type, full) {
                        return fmtDate(full.created_at) || ' ';
                    }
                },
                {
                    data: "availability",
                    render: function(data, type, full) {
                        return '<span class="tm-avail">' + (full.availability == 'Y' ? 'Yes' : 'No') + '</span>';
                    }
                },
                {
                    data: 'featured_button',
                    visible: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'free_trial_button',
                    visible: false,
                    orderable: false,
                    searchable: false
                },
                { // 8 Status
                    data: "status",
                    render: function(data, type, full) {
                        if (full.status == 'A' && full.subscription == 'S' && full.draft == 'N') {
                            return '<span class="green_color status_update_' + full.id + '">Approved</span>';
                        } else if (data == 'A') {
                            return '<span class="pending_color status_update_' + full.id + '">Pending</span>';
                        }

                        var sc_user = (full.status_change_user_id && full.status_change_user && full.status_change_user.name) ? full.status_change_user.name : '-';
                        var sc_date = full.status_change_date ? fmtDate(full.status_change_date) : '-';
                        var reason = full.admin_rej_sus_reason ? full.admin_rej_sus_reason : '';
                        var info = reason ?
                            '<span class="fa fa-question-circle gj_reason_qc" data-id="' + full.id + '" data-reason="' + reason + '" data-sc_user="' + sc_user + '" data-sc_date="' + sc_date + '"></span>' :
                            '';

                        if (data == 'I') return '<span class="suspend_color status_update_' + full.id + '">Suspended</span>' + info;
                        if (data == 'R') return '<span class="reject_color status_update_' + full.id + '">Rejected</span>' + info;
                        return data;
                    }
                },
                { // 9 Closed on (hidden – only ever applied to status C)
                    data: "updated_at",
                    visible: false,
                    render: function(data, type, full) {
                        if (full.status != 'C') return '';
                        return fmtDate(full.updated_at) || ' ';
                    }
                },
                { // 10 Action
                    data: "id",
                    orderable: false,
                    render: function(data, type, full) {
                        var a = '<div class="tm-actions">' +
                    '<a target="_self" href="{{ url('admin/view-tutor-overview').'/' }}' + full.id + '" class="tm-manage action" data-key="' + full.id + '" id="action' + full.id + '">' +
                    '<i class="fa fa-pencil"></i> Manage</a>' +
                    '</div>';
                        // var a = '<div class="tm-actions">' +
                        //         '<a href="javascript:void(0);" class="tm-manage action" data-key="' + full.id + '" id="action' + full.id + '"><i class="fa fa-pencil"></i> Manage</a>' +
                        //         '<div class="show-actions" id="show-action' + full.id + '" style="display:none;"><ul>';

                        // a += '<li><a target="_self" href="{{ url('admin/view-tutor-personal-info').'/' }}' + full.id + '">View</a></li>';
                        // a += '<li class="tm-toggle-row"><span>Featured</span>' + (full.featured_button || '') + '</li>';
                        // a += '<li class="tm-toggle-row"><span>Free Trial</span>' + (full.free_trial_button || '') + '</li>';

                        // if (full.status == 'A') {
                        //     if (full.subscription == 'S' && full.draft == 'N') {
                        //         a += '<li><a class="status_change_suspend" data-id="' + full.id + '" href="javascript:void(0);">Suspend</a></li>';
                        //     } else {
                        //         a += '<li><a class="status_change_approved" data-id="' + full.id + '" href="javascript:void(0);">Approve</a></li>';
                        //         a += '<li><a class="status_change_reject" data-id="' + full.id + '" href="javascript:void(0);">Reject</a></li>';
                        //     }
                        // }
                        // if (full.status == 'I') {
                        //     a += '<li><a class="status_change_approved" data-id="' + full.id + '" href="javascript:void(0);">Approve</a></li>';
                        // }

                        a += '</ul></div></div>';
                        return a;
                    }
                },
                { // 11 State (hidden, used only for the State filter)
                    data: "state",
                    visible: false,
                    orderable: false,
                    defaultContent: ''
                }
            ]
        };

        var table = dataTableCall(dataTableObj, "example");
        window.table = table;
        $("#example_filter").hide();

        // Manage dropdown
        $(document).on("click", ".action", function(e) {
            e.stopPropagation();
            var id = $(this).data("key");
            $(".show-actions").not("#show-action" + id).slideUp(120);
            $("#show-action" + id).slideToggle(120);
        });
        $(document).on("click", function(e) {
            if ($(e.target).closest('.tm-toggle-row').length) {
                return;
            }
            $(".show-actions").slideUp(120);
        });

        // Reset
        $('body').on('click', '.reset_search', function() {
            $(".reset_val").val("");
            $("#col3_filter, #col4_filter, #col5_filter").val("");
            $('#example').DataTable().search('').columns().search('').draw();
        });

        // Search
        $(document).on('click', '.search_click', function() {
            filterColumn(1); // Name / ID
            filterColumn(2); // Status
            filterColumn(3); // From date
            filterColumn(4); // To date
            filterColumn(5); // Availability
            filterColumnForSelect('featured_filter', 6);
            filterColumnForSelect('free_trial_filter', 7);
            filterColumnForSelect('state_filter', 11);
        });
        $('#col1_filter').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('.search_click').first().click();
            }
        });

        // Status modals
        $(document).on("click", ".status_change_approved", function(e) {
            var id = $(e.currentTarget).data("id");
            $('#tut_id').val(id);
            $('#approveTutorModal .gj_modal_title').text('Confirmation');
            $('#approveTutorModal .gj_popup_text').text('Are you sure you want to approve this tutor?');
            $('#approveTutorModal .adm_modal_Footer').show();
            $('#approveTutorModal .gj_confirm_div').show();
            $('#approveTutorModal').modal('show');
        });

        $(document).on("click", ".status_change_reject", function(e) {
            $('#rtut_id').val($(e.currentTarget).data("id"));
            $('#rejectTutorModal .gj_modal_title').text('Confirmation');
            $('#rejectTutorModal .adm_modal_Footer').show();
            $('#rejectTutorModal .gj_confirm_div').show();
            $('#rejectTutorModal .gj_submit_div').hide();
            $('#rejectTutorModal .reject_reason_error').hide();
            $('#rejectTutorModal').modal('show');
        });

        $(document).on("click", ".status_change_suspend", function(e) {
            $('#stut_id').val($(e.currentTarget).data("id"));
            $('#suspendTutorModal .gj_modal_title').text('Confirmation');
            $('#suspendTutorModal .adm_modal_Footer').show();
            $('#suspendTutorModal .gj_confirm_div').show();
            $('#suspendTutorModal .gj_submit_div').hide();
            $('#suspendTutorModal .suspend_reason_error').hide();
            $('#suspendTutorModal').modal('show');
        });

        $(document).on("click", ".gj_reason_qc", function(e) {
            var t = $(e.currentTarget);
            $('#adminReasonTutorModal .gj_popupname_text').text('Name: ' + t.data("sc_user"));
            $('#adminReasonTutorModal .gj_popupdate_text').text('Date: ' + t.data("sc_date"));
            $('#adminReasonTutorModal .gj_popuprsn_text').text('Reason: ' + t.data("reason"));
            $('#adminReasonTutorModal').modal('show');
        });

        // Date range validation
        function validateDates() {
            var from = Date.parse($("#col3_filter").val());
            var to = Date.parse($("#col4_filter").val());
            if (!isNaN(from) && !isNaN(to) && to < from) {
                $("#col3_filter").val("");
                $("#col4_filter").val("");
                $(".error_from_date").html("To date cannot be earlier than from date");
            } else {
                $(".error_from_date").html("");
            }
        }
        $(document).on("blur", "#col3_filter, #col4_filter", validateDates);

        $('#instructionModal').modal('hide');

        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

        $('#example').on('page.dt', function() {
            var info = table.page.info();
            localStorage.setItem("pageNo", isNaN(info.page) ? 0 : info.page);
        });
    });
</script>

<script>
    function ClosePopupModel(its) {
        $(its).closest('.modal').modal('hide');
    }

    // ---------- Approve ----------
    function approveTutorNow() {
        var id = $('#tut_id').val();
        $('#approveTutorModal').modal('hide');
        $("#v_tutor_Loader").css("display", "flex");

        $.ajax({
            url: "{{ route('ajax.status.change.user.approved') }}",
            dataType: 'json',
            data: {
                'jsonrpc': '2.0',
                '_token': '{{csrf_token()}}',
                'data': {
                    'id': id
                }
            },
            type: 'post',
            success: function(resp) {
                if (resp.status == 1) {
                    table.row('.tr_class_' + id).remove().draw(false);
                    toastr.success(resp.message);
                } else {
                    toastr.error(resp.message);
                }
            },
            error: function() {
                toastr.error("Something went wrong! Ajax error!");
            },
            complete: function() {
                $("#v_tutor_Loader").hide();
            }
        });
    }

    function submitApproveFn(its) {
        var id = $('#tut_id').val();
        var zoom_email = $('#zoom_email').val();
        if (id && zoom_email) {
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(zoom_email)) {
                $('#approveTutorModal .zoom_email_error').text('Please enter valid email id').show();
                return;
            }
            $(its).closest('.modal').modal('hide');
            $("#v_tutor_Loader").css("display", "flex");
            $.ajax({
                url: "{{ route('ajax.status.change.user.approved') }}",
                dataType: 'json',
                data: {
                    'jsonrpc': '2.0',
                    '_token': '{{csrf_token()}}',
                    'data': {
                        'id': id,
                        'zoom_email': zoom_email
                    }
                },
                type: 'post',
                success: function(resp) {
                    if (resp.status == 1) {
                        table.row('.tr_class_' + id).remove().draw(false);
                        toastr.success(resp.message);
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error: function() {
                    toastr.error("Something went wrong!Ajax error!");
                },
                complete: function() {
                    $("#v_tutor_Loader").hide();
                }
            });
        } else {
            $('#approveTutorModal .zoom_email_error').text('This field is required').show();
        }
    }

    function yesApproveSubmitModal() {
        $('#approveTutorModal .gj_modal_title').text('Enter Zoom Mail ID');
        $('#approveTutorModal .adm_modal_Footer').hide();
        $('#approveTutorModal .gj_confirm_div').hide();
        $('#approveTutorModal #zoom_email').val('');
        $('#approveTutorModal .gj_submit_div').show();
        $('#approveTutorModal .zoom_email_error').hide();
    }

    // ---------- Reject ----------
    function yesRejectFn() {
        $('#rejectTutorModal .gj_modal_title').text('Reject this Tutor?');
        $('#rejectTutorModal .adm_modal_Footer').hide();
        $('#rejectTutorModal .gj_confirm_div').hide();
        $('#rejectTutorModal #reject_reason').val('');
        $('#rejectTutorModal .gj_submit_div').show();
        $('#rejectTutorModal .reject_reason_error').hide();
    }

    function submitRejectFn(its) {
        var id = $('#rtut_id').val();
        var reason = $('#reject_reason').val();
        if (id && reason) {
            $(its).closest('.modal').modal('hide');
            $('#rejectTutorModal .reject_reason_error').text('').hide();
            $("#v_tutor_Loader").css("display", "flex");
            $.ajax({
                url: "{{ route('ajax.status.change.user.rejected') }}",
                dataType: 'json',
                data: {
                    'jsonrpc': '2.0',
                    '_token': '{{csrf_token()}}',
                    'data': {
                        'id': id,
                        'reason': reason
                    }
                },
                type: 'post',
                success: function(resp) {
                    if (resp.status == 1) {
                        table.row('.tr_class_' + id).remove().draw(false);
                        toastr.success(resp.message);
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error: function() {
                    toastr.error("Something went wrong!Ajax error!");
                },
                complete: function() {
                    $("#v_tutor_Loader").hide();
                }
            });
        } else {
            $('#rejectTutorModal .reject_reason_error').text('This field is required').show();
        }
    }

    // ---------- Suspend ----------
    function yesSuspendFn() {
        $('#suspendTutorModal .gj_modal_title').text('Reason to suspend');
        $('#suspendTutorModal .adm_modal_Footer').hide();
        $('#suspendTutorModal .gj_confirm_div').hide();
        $('#suspendTutorModal #suspend_reason').val('');
        $('#suspendTutorModal .gj_submit_div').show();
        $('#suspendTutorModal .suspend_reason_error').hide();
    }

    function submitSuspendFn(its) {
        var id = $('#stut_id').val();
        var reason = $('#suspend_reason').val();
        if (id && reason) {
            $(its).closest('.modal').modal('hide');
            $('#suspendTutorModal .suspend_reason_error').text('').hide();
            $("#v_tutor_Loader").css("display", "flex");
            $.ajax({
                url: "{{ route('ajax.status.change.user.suspended') }}",
                dataType: 'json',
                data: {
                    'jsonrpc': '2.0',
                    '_token': '{{csrf_token()}}',
                    'data': {
                        'id': id,
                        'reason': reason
                    }
                },
                type: 'post',
                success: function(resp) {
                    if (resp.status == 1) {
                        table.row('.tr_class_' + id).remove().draw(false);
                        toastr.success(resp.message);
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error: function() {
                    toastr.error("Something went wrong!Ajax error!");
                },
                complete: function() {
                    $("#v_tutor_Loader").hide();
                }
            });
        } else {
            $('#suspendTutorModal .suspend_reason_error').text('This field is required').show();
        }
    }

    // ---------- Featured / Free trial toggles ----------
    function notify(type, msg) {
        if (typeof toastr !== 'undefined') {
            toastr[type](msg);
        }
    }

    $(document).on('change', '.featuredToggle', function() {
        $.ajax({
            url: "{{ route('update.featured.status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                tutor_id: $(this).data('id'),
                status: $(this).is(':checked') ? 1 : 0
            },
            success: function(res) {
                res.status ? notify('success', res.message) : notify('error', 'Failed to update featured status');
            },
            error: function() {
                notify('error', 'Error updating featured status');
            }
        });
    });

    $(document).on('change', '.freeTrailToggle', function() {
        $.ajax({
            url: "{{ route('update.free.trail.status') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                tutor_id: $(this).data('id'),
                status: $(this).is(':checked') ? 1 : 0
            },
            success: function(res) {
                res.status ? notify('success', res.message) : notify('error', 'Failed to update free trial status');
            },
            error: function() {
                notify('error', 'Error updating free trial status');
            }
        });
    });
</script>
@endsection
@extends('layouts.app')
@section('title')
<title>V-Tutor | Student | Assessment</title>
@endsection

@section('left_part')
@include('include.header_menu_part')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
 <style>
        .table-head {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .user-right-top {
            width: 100%;
            overflow-x: hidden; 
        }
        .custom-table table {
            width: 100% !important;
            table-layout: auto;
        }
        .custom-table table thead th {
            background-color: #d73c5e ;
            vertical-align: middle;
        }
        .dt-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .dt-bottom .dataTables_length {
            text-align: left;
        }

        .dt-bottom .dataTables_paginate {
            text-align: right;
        }

        .btn {
            text-transform: none !important;
            letter-spacing: normal;
            font-weight: 500;
        }
        #programTable th,
        #programTable td {
            text-align: center;
            vertical-align: middle;
        }
        #programTable th:nth-child(1),
        #programTable td:nth-child(1) {
            text-align: left;
        }

        .section-card {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.summary-box {
    text-align: center;
    padding: 20px;
    border-radius: 10px;
    background: #f9fafc;
    border: 1px solid #e6ecf2;
    transition: 0.2s ease-in-out;
}

.summary-box:hover {
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    transform: translateY(-2px);
}

.text-total { color:#6c757d; }
.text-completed { color:#28a745; }
.text-scheduled { color:#17a2b8; }
.text-remaining { color:#fd7e14; }

.label-status {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
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
    margin-bottom: 3px;
    display: block;
}

.info-row p {
    margin: 0;
    font-size: 15px;
    color: #333;
}
.user-right-panel {
    text-align: left !important;
}

.user-right-top-new {
    width: 100% !important;
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
}

.user-right-top-new .profile-heading {
    margin: 0 !important;
    text-align: left !important;
}
.bk-btn {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    color: #fff !important;
}

.bk-btn:hover,
.bk-btn:focus,
.bk-btn:active {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    color: #fff !important;
    box-shadow: none !important;
}
    </style>
@endsection

@section('content')

@php
    $totalSessions     = $purchase->sessions->count();
    $completedSessions = $purchase->sessions->where('status', 'completed')->count();
    $scheduledSessions = $purchase->sessions->where('status', 'scheduled')->count();
    $remainingSessions = $purchase->sessions->where('status', 'pending')->count();
    $timezone = auth()->user()->timezone_id ?: 'UTC';
@endphp
<div class="top_mar"></div>

<section class="user-account">
    <div class="container">
        <div class="row">
            <div class="zin">
                @include('include.student_left_common')

                <div class="user-right-panel">
                    <div class="user-right-top-new">
    <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
        
        <h2 class="profile-heading mb-0">
            Academic Programs
        </h2>

        <a href="{{ url()->previous() }}" class="btn btn-sm bk-btn text-white">
            Back
        </a>

    </div>
</div>

                <div class="turo-edit">
                    <div class="user-right-top">
                        <!-- PURCHASE INFORMATION -->
                        <div class="section-card">
                            <h2 class="mb-4"><strong>Purchase Information</strong></h2>
                            <div class="row">
                            <!-- LEFT COLUMN -->
                                <div class="col-md-6">
                                    <div class="info-row">
                                        <label>Order ID</label>
                                        <p>#{{ $purchase->order_id }}</p>
                                    </div>
                                <div class="info-row">
                                    <label>Program</label>
                                    <p>{{ optional($purchase->academicProgram)->name ?? '-' }}</p>
                                </div>
                                <div class="info-row">
                                    <label>Program Code</label>
                                    <p>{{ optional($purchase->academicProgram)->code ?? '-' }}</p>
                                </div>
                                <div class="info-row">
                                    <label>Quantity</label>
                                    <p>{{ $purchase->quantity ?? 1 }}</p>
                                 </div>
                                <div class="info-row">
                                    <label>Subject</label>
                                    <p>{{ optional(optional($purchase->academicProgram)->branch)->branch_name ?? '-' }}</p>
                                </div>
                                <div class="info-row">
                                    <label>Year</label>
                                    <p>{{ optional(optional($purchase->academicProgram)->grade)->grade_name ?? '-' }}</p>
                                </div>
                            </div>

                            <!-- RIGHT COLUMN -->
                            <div class="col-md-6">
                                <div class="info-row">
                                    <label>Purchased Date</label>
                                    <p>{{ optional($purchase->start_date)->format('d M Y') ?? '-' }}</p>
                                </div>
                                <div class="info-row">
                                    <label>Expiry Date</label>
                                    <p>{{ optional($purchase->expires_at)->format('d M Y') ?? '-' }}</p>
                                </div>
                                <div class="info-row">
                                    <label>Assigned Tutor</label>
                                    <p>@if($purchase->assignedTutor)
                                    <strong>{{ $purchase->assignedTutor->full_name }}</strong><br>
                                    @else
                                        <span class="text-muted">No Tutor Assigned</span>
                                    @endif
                                    </p>
                                </div>
                                <div class="info-row">
                                    <label>Session Plan</label>
                                    <p>
                                    @if(optional($purchase->academicProgram)->parent_session_plan)
                                    <a href="{{ asset('storage/academic_program_docs/' . $purchase->academicProgram->parent_session_plan) }}"
                                        class="btn btn-sm btn-link" target="_blank" rel="noopener">
                                        View
                                    </a>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                    </p>
                                </div>

                                </div>

                             </div>
                        </div>

                   <!-- SESSION SUMMARY -->
    <div class="section-card">
        <h2><strong>Session Summary</strong></h2>
        <hr>

        <div class="row">

            <div class="col-md-3">
                <div class="summary-box">
                    <h5>Total Sessions</h5>
                    <h2 class="text-total">{{ $totalSessions }}</h2>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-box">
                    <h5>Completed</h5>
                    <h2 class="text-completed">{{ $completedSessions }}</h2>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-box">
                    <h5>Scheduled</h5>
                    <h2 class="text-scheduled">{{ $scheduledSessions }}</h2>
                </div>
            </div>

            <div class="col-md-3">
                <div class="summary-box">
                    <h5>Remaining</h5>
                    <h2 class="text-remaining">{{ $remainingSessions }}</h2>
                </div>
            </div>

        </div>

        @if($totalSessions > 0)
        @php
            $progress = ($completedSessions / $totalSessions) * 100;
        @endphp

        <div style="margin-top:25px;">
            <div class="progress" style="height:8px;">
                <div class="progress-bar bg-success"
                     role="progressbar"
                     style="width: {{ $progress }}%;">
                </div>
            </div>
            <small class="text-muted">
                {{ round($progress) }}% Sessions Completed
            </small>
        </div>
        @endif
    </div>
      <!-- SESSIONS TABLE -->
    <div class="section-card">
        <h2><strong>Sessions Details</strong></h2>
        <hr>

        @if($purchase->sessions->count() > 0)

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead style="background:#f8f9fa;">
                    <tr>
                        <th>S No</th>
                        <th>Session Date</th>
                        <th>Start  Time</th>
                        <th>End Time</th>
                        <th>Tutor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchase->sessions as $session)
                    <tr>
                        <td><strong>{{ $session->session_number }}</strong></td>

                        <td>
                            @if($session->scheduled_at)
                                {{ $session->scheduled_at->setTimezone($timezone)->format('d-m-Y') }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if($session->start_time)
                                {{ \Carbon\Carbon::parse($session->start_time, 'UTC')->setTimezone($timezone)->format('h:i A') }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if($session->end_time)
                                {{ \Carbon\Carbon::parse($session->end_time, 'UTC')->setTimezone($timezone)->format('h:i A') }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if($session->tutor)
                                {{ $session->tutor->full_name }} <br>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if($session->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($session->status == 'scheduled')
                                <span class="badge badge-info">Scheduled</span>
                            @elseif($session->status == 'completed')
                                <span class="badge badge-success">Completed</span>
                            @elseif($session->status == 'cancelled')
                                <span class="badge badge-danger">Cancelled</span>
                            @elseif($session->status == 'unattended')
                                <span class="badge badge-danger">Unattended</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @else
            <p class="text-muted">No sessions available.</p>
        @endif

    </div>


                        </div>
                    </div> 

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('footer')
@include('include.footer')
@endsection

@section('script')
@include('include.script')

<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script>

@endsection

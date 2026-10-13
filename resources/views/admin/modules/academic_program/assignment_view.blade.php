@extends('admin.layouts.app')

@section('title')
Academic Program Assignment
@endsection

@section('links')
@include('admin.includes.links')

<style>
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
</style>
@endsection

@section('header')
@include('admin.includes.header')
@endsection

@section('sidebar')
@include('admin.includes.sidebar')
@endsection

@section('content')

@php
    $totalSessions     = $purchase->sessions->count();
    $completedSessions = $purchase->sessions->where('status', 'completed')->count();
    $scheduledSessions = $purchase->sessions->where('status', 'scheduled')->count();
    $remainingSessions = $purchase->sessions->where('status', 'pending')->count();
    $adminTimezone = 'Australia/Sydney';
@endphp

<div class="content">
<div class="container">

    <!-- PAGE TITLE -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Academic Program Assignment</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('academic.assignment.list') }}" class="btn btn-default">
                Back
            </a>
        </div>
    </div>

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
                <label>Contact Details</label>
                <p>
                    {{ optional($purchase->user)->full_name ?? '-' }}<br>
                    <small>{{ optional($purchase->user)->email ?? '-' }}</small>
                </p>
            </div>

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
                <p>
                    @if($purchase->assignedTutor)
                        <strong>{{ $purchase->assignedTutor->full_name }}</strong><br>
                        <small>
                            ID: {{ $purchase->assignedTutor->id }} |
                            {{ $purchase->assignedTutor->email }}
                        </small>
                    @else
                        <span class="text-muted">No Tutor Assigned</span>
                    @endif
                </p>
            </div>

        </div>

    </div>
</div>
  

    <!-- ASSIGN TUTOR -->
     @php
        $isExpired = $purchase->expires_at && now()->gt($purchase->expires_at);
    @endphp
    <div class="section-card">
        <h2><strong>Assign Tutor</strong></h2>
        <hr>

    <form id="assignTutorForm">
    @csrf
    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">

        <div class="row">
            <div class="col-md-6">
                <label>Select Tutor</label>
                <select name="tutor_id" class="form-control" {{ $isExpired ? 'disabled' : '' }} required>
                    <option value="">-- Select Tutor --</option>

                    @forelse($tutors as $tutor)
                        <option value="{{ $tutor->id }}"
                            {{ $purchase->assigned_tutor_id == $tutor->id ? 'selected' : '' }}>
                            {{ $tutor->full_name }} ({{ $tutor->id }})
                        </option>
                    @empty
                        <option value="">No tutors available</option>
                    @endforelse
                </select>
            </div>

            <div class="col-md-3" style="margin-top:25px;">
                <button type="button" id="assignTutorBtn" class="btn btn-primary btn-block" {{ $isExpired ? 'disabled' : '' }}>
                    Assign Tutor
                </button>
            </div>
        </div>
    </form>
    @if($isExpired)
    <div class="alert alert-danger mt-3">
        This purchase has expired. Tutor reassignment is not allowed.
    </div>
    @endif

        <div id="assignSuccessMessage" class="alert alert-success" style="display:none;"></div>
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
                        <th>History</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchase->sessions as $session)
                        @php
                            $adminTimezone = 'Australia/Sydney';
                            $rawScheduledAt = $session->getRawOriginal('scheduled_at');
                            $rawStartTime   = $session->getRawOriginal('start_time');
                            $rawEndTime     = $session->getRawOriginal('end_time');
                            
                            $scheduledAt = null;
                            $startTime = null;
                            $endTime = null;

                            if ($rawScheduledAt) {
                                $scheduledAt = \Carbon\Carbon::parse($rawScheduledAt, 'UTC')->setTimezone($adminTimezone);
                            }

                            if ($rawScheduledAt) {

                                $sessionDateUtc = \Carbon\Carbon::parse($rawScheduledAt,    'UTC')->format('Y-m-d');
                                if ($rawStartTime) {
                                    $startTimeOnly = \Carbon\Carbon::parse( $rawStartTime,  'UTC')->format('H:i:s');
                                    $startDateTimeUtc = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $sessionDateUtc . ' ' . $startTimeOnly,'UTC');
                                    $startTime = $startDateTimeUtc->setTimezone($adminTimezone);
                                }

                            if ($rawEndTime) {
                                $endTimeOnly = \Carbon\Carbon::parse($rawEndTime,   'UTC')->format('H:i:s');
                                $endDateTimeUtc = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',   $sessionDateUtc . ' ' . $endTimeOnly,'UTC');
                                $endTime = $endDateTimeUtc->setTimezone($adminTimezone);        
                            }
                        }

                        @endphp
                        <tr>
                        <td><strong>{{ $session->session_number }}</strong></td>

                         <td>@if($session->scheduled_at)
                                {{  $scheduledAt ? $scheduledAt->format('d/m/Y') : '-' }}
                                @else
                                    -
                                @endif
                        </td>

                        <td>@if($session->start_time)
                                {{ $startTime ? $startTime->format('h:i A') : '-' }}
                                @else
                                    -
                                @endif
                        </td>

                        <td>@if($session->end_time)
                                {{ $endTime ? $endTime->format('h:i A') : '-' }}
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
                        <td class="text-center">
                            <a href="{{ route('academic.session.history', $session->id) }}" class="btn btn-sm btn-info">
                                View History
                            </a>
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

@endsection

@section('footer')
@include('admin.includes.footer')
@endsection

@section('script')
@include('admin.includes.script')
<script>
$(document).ready(function () {

    $("#assignTutorBtn").on("click", function () {

        $(".backend-error").remove();

        let tutorId = $('[name="tutor_id"]').val();

        if (!tutorId) {
            $('[name="tutor_id"]').after(
                '<label class="error backend-error">Please select tutor</label>'
            );
            return;
        }

        let btn = $(this);
        btn.prop("disabled", true).html(
            `<span class="spinner-border spinner-border-sm"></span> Assigning...`
        );

        fetch("{{ route('academic.assignment.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: new FormData(document.getElementById("assignTutorForm"))
        })
        .then(res => res.json())
        .then(data => {

            if (data.success) {

                $("#assignSuccessMessage")
                    .text(data.message)
                    .fadeIn();

                setTimeout(() => {
                    $("#assignSuccessMessage").fadeOut();
                }, 3000);

                // Optional: reload page to update session table
                location.reload();

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
            btn.prop("disabled", false).text("Assign Tutor");
        });

    });

});
</script>
@endsection
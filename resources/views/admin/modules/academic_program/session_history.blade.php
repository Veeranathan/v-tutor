@extends('admin.layouts.app')

@section('title')
    Session Booking History
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

        .history-table th {
            white-space: nowrap;
        }

        .history-table td {
            vertical-align: middle !important;
        }

        .action-badge {
            padding: 5px 10px;
            border-radius: 15px;
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

@php
    $adminTimezone = 'Australia/Sydney';
    $purchase = $session->purchase;

    $currentScheduledDate = null;
    $currentStartTime = null;
    $currentEndTime = null;

    $rawScheduledAt = $session->getRawOriginal('scheduled_at');
    $rawStartTime = $session->getRawOriginal('start_time');
    $rawEndTime = $session->getRawOriginal('end_time');

    if ($rawScheduledAt) {

        $scheduledAtUtc = \Carbon\Carbon::parse(
            $rawScheduledAt,
            'UTC'
        );

        $currentScheduledDate = $scheduledAtUtc->copy()
            ->setTimezone($adminTimezone);

        $sessionDateUtc = $scheduledAtUtc->format('Y-m-d');

        /*
         * START TIME
         */
        if ($rawStartTime) {

            if (preg_match('/\b(\d{2}:\d{2}:\d{2})\b/', $rawStartTime, $matches)) {

                $startTimeOnly = $matches[1];

                $startDateTimeUtc = \Carbon\Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $sessionDateUtc . ' ' . $startTimeOnly,
                    'UTC'
                );

                $currentStartTime = $startDateTimeUtc
                    ->setTimezone($adminTimezone);
            }
        }

        /*
         * END TIME
         */
        if ($rawEndTime) {

            if (preg_match('/\b(\d{2}:\d{2}:\d{2})\b/', $rawEndTime, $matches)) {

                $endTimeOnly = $matches[1];

                $endDateTimeUtc = \Carbon\Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $sessionDateUtc . ' ' . $endTimeOnly,
                    'UTC'
                );

                $currentEndTime = $endDateTimeUtc
                    ->setTimezone($adminTimezone);
            }
        }
    }
@endphp

<div class="content">

    <div class="container">

        <!-- PAGE TITLE -->
        <div class="row mb-4">

            <div class="col-md-8">
                <h1>Session Booking History</h1>
            </div>

            <div class="col-md-4 text-right">

                <a
                    href="{{ route('view.academic.assignment', $purchase->id) }}"
                    class="btn btn-default">

                    Back to Assignment

                </a>

            </div>

        </div>


        <!-- SESSION DETAILS --> 
         <div class="section-card"> <h2> <strong>Session Details</strong> </h2> <hr> <div class="row"> 
            <!-- LEFT --> 
             <div class="col-md-6"> 
                <div class="info-row"> 
                    <label>Session Number</label> 
                    <p> <strong> Session {{ $session->session_number }} </strong> </p>
                 </div> 
                 <div class="info-row"> 
                    <label>Current Tutor</label> <p> @if($session->tutor) {{ $session->tutor->full_name }} @else - @endif </p> 
                </div> 
            </div> 
            <!-- RIGHT --> 
             <div class="col-md-6"> 
                <div class="info-row"> 
                    <label>Current Status</label> 
                    <p> 
                        @if($session->status == 'pending') <span class="badge badge-warning"> Pending </span> 
                        @elseif($session->status == 'scheduled') <span class="badge badge-info"> Scheduled </span> 
                        @elseif($session->status == 'completed') <span class="badge badge-success"> Completed </span> 
                        @elseif($session->status == 'cancelled') <span class="badge badge-danger"> Cancelled </span> 
                        @elseif($session->status == 'unattended') <span class="badge badge-danger"> Unattended </span> 
                        @else {{ $session->status ?? '-' }} @endif 
                    </p> 
                </div> 
<div class="info-row">

    <label>Current Schedule</label>

    <p>

        @if($currentScheduledDate)

            {{ $currentScheduledDate->format('d M Y') }}

            @if($currentStartTime && $currentEndTime)

                <br>

                {{ $currentStartTime->format('h:i A') }}
                -
                {{ $currentEndTime->format('h:i A') }}

            @elseif($currentStartTime)

                <br>

                {{ $currentStartTime->format('h:i A') }}

            @endif

        @else

            -

        @endif

    </p>

</div>

            </div> 
        </div> 
    </div>
        



        <!-- HISTORY -->
        <div class="section-card">

            <h2>
                <strong>Booking History</strong>
            </h2>

            <hr>

            @if($session->logs->count() > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-hover history-table">

                        <thead style="background:#f8f9fa;">

                            <tr>

                                <th>#</th>

                                <th>Action</th>

                                <th>Booking No</th>

                                <th>Tutor</th>

                                <th>Scheduled Date</th>

                                <th>Start Time</th>

                                <th>End Time</th>

                                <th>Reason</th>

                                <th>Action By</th>

                                <th>Action At</th>

                            </tr>

                        </thead>

                        <tbody>

                        @foreach($session->logs->sortByDesc('action_at') as $index => $log)

                        @php
                            $logScheduledDate = null;
                            $logStartTime = null;
                            $logEndTime = null;

                            $rawScheduledDate = $log->getRawOriginal('scheduled_date');
                            $rawStartTime = $log->getRawOriginal('start_time');
                            $rawEndTime = $log->getRawOriginal('end_time');

                            if ($rawScheduledDate) {

                                $logScheduledDate = \Carbon\Carbon::parse($rawScheduledDate,'UTC')->setTimezone($adminTimezone);

                                $sessionDateUtc = \Carbon\Carbon::parse($rawScheduledDate,'UTC')->format('Y-m-d');

                                if ($rawStartTime) {

                                    $startTimeOnly = \Carbon\Carbon::parse($rawStartTime,'UTC')->format('H:i:s');

                                    $startDateTimeUtc = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $sessionDateUtc . ' ' . $startTimeOnly, 'UTC');

                                    $logStartTime = $startDateTimeUtc->setTimezone($adminTimezone);
                                }

                                if ($rawEndTime) {

                                    $endTimeOnly = \Carbon\Carbon::parse($rawEndTime,   'UTC')->format('H:i:s');

                                    $endDateTimeUtc = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',   $sessionDateUtc . ' ' . $endTimeOnly,   'UTC');

                                    $logEndTime = $endDateTimeUtc->setTimezone($adminTimezone);
                                }
                            }
                        @endphp

                         <tr>
                            <td>{{ $loop->iteration }} </td>
                            <td>
                                <strong>
                                    {{ $log->action }}
                                </strong>
                            </td>
                            <td>
                                {{ $session->booking->booking_no ?? '-' }}
                            </td>
                            <td>
                                {{ optional($log->tutor)->full_name ?? '-' }}
                            </td>
                            <td>
                                {{ $logScheduledDate ? $logScheduledDate->format('d/m/Y') : '-' }}
                            </td>
                            <td> 
                                {{ $logStartTime ? $logStartTime->format('h:i A') : '-' }} 
                            </td>
                            <td>
                                {{ $logEndTime  ? $logEndTime->format('h:i A')  : '-' }}    
                            </td>
                            <td>    {{ $log->reason ?? '-' }}   

                            </td>
                            <td>     
                                {{ optional($log->actionBy)->full_name ?? '-' }}
                            </td>
                            <td>
                                 @if($log->action_at)
                                    {{ $log->action_at->timezone($adminTimezone)->format('d/m/Y h:i A') }}
                                @else
                                    -
                                @endif
                            </td>

                        </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="alert alert-info">

                    No booking history available for this session.

                </div>

            @endif

        </div>
  
        <!-- SESSION LOGIN DETAIL -->
        <div class="section-card">
            <h2><strong>Session Login Detail</strong></h2>
            <hr>

            <div class="row">
                <div class="col-md-6">
                    <div class="info-row">
                    <label>Student Login Time</label>
                    <p>
                        @if($studentLoginTime)
                            {{ $studentLoginTime->format('d M Y, h:i A') }}
                        @else
                        -
                        @endif
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-row">
                    <label>Tutor Login Time</label>
                        <p>
                            @if($tutorLoginTime)
                                {{ $tutorLoginTime->format('d M Y, h:i A') }}
                            @else
                                -
                            @endif
                        </p>
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
@endsection
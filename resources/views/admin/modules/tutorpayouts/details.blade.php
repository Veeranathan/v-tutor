@extends('admin.layouts.app')

@section('title')
Payout Details
@endsection

@section('links')
@include('admin.includes.links')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

<style>
    .page-title {
        margin: 0;
    }

    .back-button-wrapper {
        text-align: right;
    }

    .back-button {
        padding: 5px 12px;
        font-size: 13px;
    }

    .payout-info {
        line-height: 24px;
    }

    .payout-table th {
        vertical-align: middle !important;
    }

    .payout-table td {
        vertical-align: middle !important;
    }

    .amount-cell {
        text-align: right;
        white-space: nowrap;
    }

    .status-completed {
        color: #5cb85c;
        font-weight: 600;
    }

    .status-cancelled {
        color: #d9534f;
        font-weight: 600;
    }

    .status-unknown {
        color: #777;
    }

    /* DataTable pagination - match existing admin theme */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: #fff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e65d58;
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

<div class="content">
<div class="container">

    <!-- PAGE TITLE -->
    <div class="row">
        <div class="col-sm-12">

            <h1 class="pull-left page-title">
                Payout Details
            </h1>

            <div class="pull-right back-button-wrapper">
                <a
                    href="{{ route('admin.payouts', [
                        'from_date' => $from,
                        'to_date' => $to
                    ]) }}"
                    class="btn btn-default btn-sm back-button"
                >
                    ← Back
                </a>
            </div>

            <div class="clearfix"></div>

        </div>
    </div>


    <!-- PAYOUT DETAILS -->
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">

                    <div class="payout-info">

                        <strong>Tutor:</strong>
                        {{ $tutor->unique_id }}
                        -
                        {{ $tutor->f_name }}
                        {{ $tutor->l_name }}

                        <br>

                        <strong>Period:</strong>
                        {{ $from }} to {{ $to }}

                    </div>

                </div>


                <div class="panel-body">

                    <div class="table-responsive">

                    <table id="payout-details-table" class="table table-striped table-bordered payout-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Booking Number</th>
                            <th>Program Name</th>
                            <th>Booking Status</th>
                            <th>Gross Revenue ($)</th>
                            <th>Deductions ($)</th>
                            <th>Net Payout ($)</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>

                <tbody>

                @foreach($payments as $p)

                    <tr>
                        <td>
                           {{ $p->booking && $p->booking->booking_date
                                ? \Carbon\Carbon::parse($p->booking->booking_date)->format('d-m-y')
                                : '-' }}
                        </td>
                        <td>
                            {{ optional($p->booking)->booking_no ?? '-' }}
                        </td>
                        <td>
                            @php
                                $booking = $p->booking;
                            @endphp

                            @if($booking && $booking->is_academic_program)
                                {{ optional($booking->academicProgramPurchase?->academicProgram)->name ?? '-' }}
                            @else
                                Ad-Hoc
                            @endif
                        </td>
                        <td>

                            @if($p->booking_status_label === 'Completed')

                                <span class="status-completed">
                                    Completed
                                </span>

                            @elseif($p->booking_status_label === 'Unattended')

                            <span class="status-unknown">
                                Unattended
                            </span>

                            @endif

                            </td>
                            <td class="amount-cell">
                                ${{ number_format($p->gross, 2) }}
                            </td>
                            <td class="amount-cell">
                                ${{ number_format($p->deduction, 2) }}
                            </td>
                            <td class="amount-cell">
                            <strong>
                                ${{ number_format($p->net, 2) }}
                            </strong>
                            </td>
                            <td>

                            @if($p->payment_status_label === 'Paid')

                                <span class="label label-success status-label">
                                    Paid
                                </span>
                            @else

                            <span class="label label-warning status-label">
                                Pending
                            </span>

                            @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

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

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {

    $('#payout-details-table').DataTable({
    processing: false,
    serverSide: false,
    pageLength: 10,
    order: [[0, 'desc']],
    language: {
        emptyTable: "No eligible payment details found"
    }
});

});
</script>

@endsection
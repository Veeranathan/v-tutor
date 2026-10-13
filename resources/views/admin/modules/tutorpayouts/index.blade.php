@extends('admin.layouts.app')

@section('title')
Tutor Payout Management
@endsection

@section('links')
@include('admin.includes.links')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<style>
    .payout-summary {
        font-weight: 600;
    }
    .amount-cell {
        text-align: right;
        white-space: nowrap;
    }
    .bulk-payment-wrapper {
        margin-bottom: 15px;
    }
    .filter-date-note {
        display: block;
        margin-top: 5px;
        font-size: 12px;
        color: #777;
    }
    td {
        position: relative;
    }

    .table > thead > tr > th {
        vertical-align: middle;
    }

    .table > tbody > tr > td {
        vertical-align: middle;
    }

    .no-payment-row {
        text-align: center;
        color: #777;
    }

    .amount-to-pay {
        font-weight: 700;
    }

    .payout-pending {
        font-weight: 700;
    }

    .status-label {
        font-size: 11px;
        padding: 4px 7px;
    }

    .payment-action {
        white-space: nowrap;
    }

    .payment-action .btn {
        padding: 4px 10px;
        font-size: 12px;
    }

    .payout-view-link {
        color: #337ab7;
        font-size: 13px;
        text-decoration: none;
        cursor: pointer;
    }

    .payout-view-link:hover,
    .payout-view-link:focus {
        color: #23527c;
        text-decoration: underline;
    }

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
                    Tutor Payout Management
                </h1>
            </div>
        </div>
        <!-- FILTER -->
        <div class="row">

            <div class="col-md-12">

                <div class="panel panel-default">

                    <div class="panel-heading rm02 rm04">

                        <div class="row">

                            <!-- FROM DATE -->
                            <div class="form-group col-md-3">

                                <label>
                                    From Date
                                </label>

                                <input
                                    type="date"
                                    name="from_date"
                                    id="from_date"
                                    class="form-control reset_val"
                                    value="{{ $from }}"
                                >

                            </div>


                            <!-- TO DATE -->
                            <div class="form-group col-md-3">

                                <label>
                                    To Date
                                </label>

                                <input
                                    type="date"
                                    name="to_date"
                                    id="to_date"
                                    class="form-control reset_val"
                                    value="{{ $to }}"
                                >

                            </div>


                            <!-- TUTOR -->
                            <div class="form-group col-md-3">

                                <label>
                                    Tutor
                                </label>

                                <select
                                    name="tutor_id"
                                    id="tutor_id"
                                    class="form-control reset_val"
                                >

                                    <option value="">
                                        All Tutors
                                    </option>

                                    @foreach($tutors as $tutor)

                                        <option
                                            value="{{ $tutor->id }}"
                                            {{ (string)$tutorId === (string)$tutor->id ? 'selected' : '' }}
                                        >

                                            {{ $tutor->unique_id }}
                                            -
                                            {{ $tutor->f_name }}
                                            {{ $tutor->l_name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <!-- BUTTONS -->
                            <div
                                class="col-md-3 centerButtons"
                                style="margin-top:25px;"
                            >

                                <button
                                    type="button"
                                    class="btn btn-primary search_click"
                                >
                                    Search
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-primary reset_search"
                                >
                                    Reset
                                </button>

                            </div>

                        </div>

                        <div class="clearfix"></div>

                    </div>


                    <!-- TABLE -->
                    <div class="panel-body">


                        <!-- BULK PAYMENT -->
                        @if($from && $to)

                            <div class="row bulk-payment-wrapper">

                                <div class="col-md-12 text-right">

                                    <button
                                        type="button"
                                        class="btn btn-success"
                                        id="bulk-mark-paid"
                                    >
                                        Mark All Pending as Paid
                                    </button>

                                </div>

                            </div>

                        @endif


                        <div class="table-responsive">

                            <table
                                id="example"
                                class="table table-striped table-bordered"
                            >

                                <thead>

                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Tutor Name
                                        </th>
                                        <th>
                                            Gross Revenue
                                        </th>
                                        <th>
                                            Deductions
                                        </th>
                                        <th>
                                            Net Payout
                                        </th>
                                        <th>
                                            Payout Pending
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Details
                                        </th>
                                        <th>
                                            Payment Action
                                        </th>

                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach($results as $row)

                                        @php
                                            $tutor = $row->get_tutor;
                                        @endphp

                                        <tr>
                                            <td>
                                                {{ optional($tutor)->unique_id }}
                                            </td>

                                            <td>

                                                {{ optional($tutor)->f_name }}
                                                {{ optional($tutor)->l_name }}

                                            </td>


                                            <td class="amount-cell">

                                                {{ number_format($row->gross, 2) }}

                                            </td>


                                            <td class="amount-cell">

                                                {{ number_format($row->deduction, 2) }}

                                            </td>

                                            <td class="amount-cell amount-to-pay">

                                                {{ number_format($row->net, 2) }}

                                            </td>
                                            <td class="amount-cell payout-pending">

                                                {{ number_format($row->payout_pending, 2) }}

                                            </td>
                                            <td>

                                                @if($row->payment_status === 'Pending')

                                                    <span class="label label-warning status-label">
                                                        Pending
                                                    </span>

                                                @elseif($row->payment_status === 'Paid')

                                                    <span class="label label-success status-label">
                                                        Paid
                                                    </span>

                                                @else

                                                    <span class="label label-default status-label">
                                                        No Payment
                                                    </span>

                                                @endif

                                            </td>
                                            <td>

                                                <a
                                                    href="{{ route('admin.payouts.detailsPage', [
                                                        'tutor_id' => $row->tutor_id,
                                                        'from_date' => $from,
                                                        'to_date' => $to
                                                    ]) }}"
                                                    class="payout-view-link"
                                                >
                                                    View
                                                </a>

                                            </td>
                                            <td class="payment-action">

                                                @if($row->pending_count > 0)

                                                    <button
                                                        type="button"
                                                        class="btn btn-success btn-xs mark-paid"
                                                        data-tutor-id="{{ $row->tutor_id }}"
                                                        data-tutor-name="{{ optional($tutor)->f_name }} {{ optional($tutor)->l_name }}"
                                                    >
                                                        Mark Paid
                                                    </button>

                                                @elseif($row->payment_status === 'Paid')

                                                    <span class="label label-success status-label">
                                                        Paid
                                                    </span>

                                                @else

                                                    <span class="label label-default status-label">
                                                        No Payment
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

    var table = $('#example').DataTable({

        processing: false,

        serverSide: false,

        pageLength: 10,

        order: [[0, 'asc']],

        language: {

            emptyTable: "No tutor payments found"

        }

    });

    $('.search_click').on('click', function () {

        var fromDate = $('#from_date').val();

        var toDate = $('#to_date').val();


        if (
            (fromDate && !toDate) ||
            (!fromDate && toDate)
        ) {

            alert(
                'Please select both From Date and To Date.'
            );

            return;
        }


        if (fromDate && toDate && fromDate > toDate) {

            alert(
                'From Date cannot be greater than To Date.'
            );

            return;
        }


        var form = $('<form>', {

            method: 'GET',

            action: "{{ route('admin.payouts') }}"

        });


        form.append(
            $('<input>', {

                type: 'hidden',

                name: 'from_date',

                value: fromDate

            })
        );


        form.append(
            $('<input>', {

                type: 'hidden',

                name: 'to_date',

                value: toDate

            })
        );


        form.append(
            $('<input>', {

                type: 'hidden',

                name: 'tutor_id',

                value: $('#tutor_id').val()

            })
        );


        $('body').append(form);

        form.submit();

    });

    $('.reset_search').on('click', function () {

        window.location.href =
            "{{ route('admin.payouts') }}";

    });

    $(document).on('click', '.mark-paid', function () {

        var button = $(this);

        var tutorId =
            button.data('tutor-id');

        var tutorName =
            button.data('tutor-name');

        var fromDate =
            $('#from_date').val();

        var toDate =
            $('#to_date').val();


        var message =
            'Are you sure you want to mark eligible pending payments as paid for ' +
            tutorName +
            '?';


        if (fromDate && toDate) {

            message +=
                '\n\nDate Range: ' +
                fromDate +
                ' to ' +
                toDate;

        } else {

            message +=
                '\n\nThis will mark all eligible pending payments for this tutor as paid.';

        }


        message +=
            '\n\nCancelled bookings and bookings where the tutor did not log in will not be paid.';


        if (!confirm(message)) {

            return;

        }


        button
            .prop('disabled', true)
            .text('Processing...');


        $.ajax({

            url: "{{ route('admin.payouts.disburse') }}",

            type: "POST",

            data: {

                _token: "{{ csrf_token() }}",

                tutor_id: tutorId,

                from_date: fromDate,

                to_date: toDate,

                bulk: 0

            },


            success: function (response) {

                if (response.status) {

                    alert(response.message);

                    window.location.reload();

                } else {

                    alert(response.message);

                    button
                        .prop('disabled', false)
                        .text('Mark Paid');

                }

            },


            error: function (xhr) {

                var message =
                    'Something went wrong.';


                if (
                    xhr.responseJSON &&
                    xhr.responseJSON.message
                ) {

                    message =
                        xhr.responseJSON.message;

                }


                alert(message);


                button
                    .prop('disabled', false)
                    .text('Mark Paid');

            }

        });

    });

    $('#bulk-mark-paid').on('click', function () {

        var button = $(this);

        var fromDate =
            $('#from_date').val();

        var toDate =
            $('#to_date').val();

        var tutorId =
            $('#tutor_id').val();


        if (!fromDate || !toDate) {

            alert(
                'Please select From Date and To Date.'
            );

            return;

        }


        if (fromDate > toDate) {

            alert(
                'From Date cannot be greater than To Date.'
            );

            return;

        }


        var message;


        if (tutorId) {

            message =
                'Are you sure you want to mark eligible pending payments for the selected tutor as paid?\n\n' +
                'Date Range: ' +
                fromDate +
                ' to ' +
                toDate;

        } else {

            message =
                'Are you sure you want to mark ALL eligible pending tutor payments as paid?\n\n' +
                'Date Range: ' +
                fromDate +
                ' to ' +
                toDate;

        }


        message +=
            '\n\nCancelled bookings and bookings where the tutor did not log in will not be paid.' +
            '\n\nThis action cannot be automatically undone.';


        if (!confirm(message)) {

            return;

        }


        button
            .prop('disabled', true)
            .text('Processing...');


        $.ajax({

            url: "{{ route('admin.payouts.disburse') }}",

            type: "POST",

            data: {

                _token: "{{ csrf_token() }}",

                tutor_id: tutorId,

                from_date: fromDate,

                to_date: toDate,

                bulk: 1

            },


            success: function (response) {

                if (response.status) {

                    alert(response.message);

                    window.location.reload();

                } else {

                    alert(response.message);

                    button
                        .prop('disabled', false)
                        .text(
                            'Mark All Pending as Paid'
                        );

                }

            },


            error: function (xhr) {

                var message =
                    'Something went wrong.';


                if (
                    xhr.responseJSON &&
                    xhr.responseJSON.message
                ) {

                    message =
                        xhr.responseJSON.message;

                }


                alert(message);


                button
                    .prop('disabled', false)
                    .text(
                        'Mark All Pending as Paid'
                    );

            }

        });

    });

});

</script>

@endsection
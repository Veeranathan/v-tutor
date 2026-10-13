@extends('admin.layouts.app')

@section('title')
Academic Program Assignment Management
@endsection

@section('links')
@include('admin.includes.links')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

<style>
td { position: relative; }

.show-actions {
    position: absolute;
    top: 50px;
    z-index: 999;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    min-width: 160px;
    left: 0px !important;
    box-shadow: 0 4px 10px rgba(0,0,0,0.12);
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #fff !important;
}

.panel-heading .form-group {
    float: left;
    margin-right: 15px;
}

.centerButtons {
    padding-top: 22px;
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
            <h1 class="pull-left page-title">Academic Program Assignment Management</h1>
        </div>
    </div>

    <!-- FILTER -->
    <div class="row">
        <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading">

                <div class="form-group">
                    <label>Assignment Status</label>
                    <select name="status" class="form-control">
                        <option value="">Select</option>
                        <option value="assigned">Assigned</option>
                        <option value="unassigned">UnAssigned</option>
                        <option value="active">Active</option>     
                        <option value="expired">Expired</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Search</label>
                    <input type="text" name="search_text"
                           class="form-control"
                           placeholder="Order ID / Student / Program">
                </div>

                <div class="pull-right">
                    <a href="{{ route('academic.assignment.manual.create') }}" class="btn btn-success">
                        Assign Student
                    </a>
                </div>

                <div class="form-group centerButtons">
                    <button class="btn btn-primary search_click" type="button">Search</button>
                    <button class="btn btn-primary reset_search" type="button">Reset</button>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Order ID</th>
                                <th>Program</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Purchased Date</th>
                                <th>Expiry Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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
        processing: true,
        serverSide: true,
        serverMethod: 'POST',
        order: [[6, 'desc']],
        pageLength: 10,

        ajax: {
            url: "{{ route('academic.assignment.list.ajax') }}",
            type: "POST",
            data: function (d) {
                d._token = "{{ csrf_token() }}";
                d.payment_status = $('select[name="payment_status"]').val();
                d.status = $('select[name="status"]').val();
                d.search_txt = $('input[name="search_text"]').val();
            }
        },

        language: {
            emptyTable: "No assignment records found"
        },

        createdRow: function (row, data) {
            $(row).attr('id', 'data' + data.id);
        },

        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'order_id' },
            { data: 'program_name' },
            { data: 'name' },
            { data: 'email' },
            { data: 'start_date' },
            { data: 'expires_at' },
            {
                data: 'status',
                render: function (val) {

                if (val === 'expired')
                    return '<span class="label label-danger">Expired</span>';

                if (val === 'assigned')
                    return '<span class="label label-info">Assigned</span>';

                if (val === 'unassigned')
                    return '<span class="label label-warning">Unassigned</span>';

                return '-';
                }
            },

            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function (id, type, row) {
                    return `
                        <a href="javascript:void(0);" class="action" data-id="${id}">
                            <img src="{{ public_asset('assets/images/action-dots.png') }}">
                        </a>

                        <div class="show-actions" style="display:none;">
                            <ul>
                                <li>
                                    <a href="${row.assign_url}">
                                        View / Assign Tutor
                                    </a>
                                </li>
                            </ul>
                        </div>
                    `;
                }
            }
        ]
    });

    // Search
    $('.search_click').on('click', function () {
        table.draw();
    });

    // Reset
    $('.reset_search').on('click', function () {
        $('select[name="payment_status"]').val('');
        $('select[name="status"]').val('');
        $('input[name="search_text"]').val('');
        table.draw();
    });

    // Action dropdown
    let openDropdown = null;

    $(document).on('click', '.action', function (e) {
        e.stopPropagation();
        const $dropdown = $(this).siblings('.show-actions');

        if (openDropdown && openDropdown.is($dropdown)) {
            $dropdown.hide();
            openDropdown = null;
            return;
        }

        $('.show-actions').hide();
        $dropdown.show();
        openDropdown = $dropdown;
    });

    $(document).on('click', function () {
        $('.show-actions').hide();
        openDropdown = null;
    });

    $(document).on('click', '.show-actions', function (e) {
        e.stopPropagation();
    });

});
</script>
@endsection
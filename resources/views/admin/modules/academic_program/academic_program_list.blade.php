@extends('admin.layouts.app')

@section('title')
Academic Program Management
@endsection

@section('links')
@include('admin.includes.links')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

<style>
.program-doc {
    font-size: 13px;
}
td {
    position: relative;
}

/* Action dropdown */
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
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #e65d58;
    color: #333;
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
            <h1 class="pull-left page-title">Academic Program Management</h1>

            <div class="rm05 backclass pull-right">
                <a href="{{ route('add.academic.program.page') }}" class="btn btn-primary">
                    Add Academic Program
                </a>
            </div>
        </div>
    </div>

    <!-- FILTER -->
    <div class="row">
        <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading rm02 rm04">

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control reset_val">
                        <option value="">Select</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Year</label>
                    <select name="year" class="form-control">
                            <option value="">Select Grade</option>
                            @foreach($grades as $grade)
                            <option value="{{ $grade->id }}">
                            {{ $grade->grade_name }}
                            </option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                <label>Subject</label>
                <select name="subject" id="subject"  class="form-control">
                            <option value="">Select Subject</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">
                            {{ $branch->branch_name }}
                            </option>
                            @endforeach
                        </select>
                </div>


                <div class="form-group">
                    <label>Curriculum</label>
                    <select name="curriculum" class="form-control reset_val">
                        <option value="">Select</option>
                        <option value="NESA Curriculum">NESA Curriculum</option>
                        <option value="VCAA curriculum">VCAA curriculum</option>
                        <option value="QCAA Curriculum">QCAA Curriculum</option>
                        <option value="SACE Curriculum">SACE Curriculum</option>
                        <option value="WACE Curriculum">WACE Curriculum</option>
                        <option value="BSSS Curriculum">BSSS Curriculum</option>
                        <option value="TASC Curriculum">TASC Curriculum</option>
                        <option value="NTBS Curriculum">NTBS Curriculum</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>State</label>
                    <select name="state" class="form-control reset_val">
                        <option value="">Select</option>
                        <option value="New South Wales">New South Wales</option>
                        <option value="Victoria">Victoria</option>
                        <option value="Queensland">Queensland</option>
                        <option value="South Australia">South Australia</option>
                        <option value="Western Australia">Western Australia</option>
                        <option value="Tasmania">Tasmania</option>
                        <option value="Australian Capital Territory">Australian Capital Territory</option>
                        <option value="Northern Territory">Northern Territory</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Search</label>
                    <input type="text" name="search_text" class="form-control reset_val" placeholder="Program Name or Code"></div>

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
                                <th>Program Code</th>
                                <th>Program Name</th>
                                <th>Subject</th>
                                <th>Year</th>
                                <th>State</th>
                                <th>Curriculum</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Updated</th>
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
            url: "{{ route('academic.program.list.ajax') }}",
            type: "POST",
            data: function (d) {
                d._token = "{{ csrf_token() }}";
                d.status = $('select[name="status"]').val();
                d.subject = $('select[name="subject"]').val();
                d.year    = $('select[name="year"]').val();
                d.curriculum = $('select[name="curriculum"]').val();
                d.state      = $('select[name="state"]').val();
                d.search_txt = $('input[name="search_text"]').val();
            }
        },

        language: {
            emptyTable: "No academic programs found"
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
            { data: 'code' },
            { data: 'name' },
            { data: 'subject' },
            { data: 'year' },
            { data: 'state' },
            { data: 'curriculum' },
            { data: 'price' },

            {
                data: 'status',
                render: function (val) {
                    return val == 1
                        ? '<span class="label label-success">Active</span>'
                        : '<span class="label label-warning">Inactive</span>';
                }
            },

            { data: 'updated_at' },

            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function (id, type, row) {
                    return `
                        <a href="javascript:void(0);" class="action" data-id="${id}">
                            <img src="{{ public_asset('assets/images/action-dots.png') }}">
                        </a>

                        <div class="show-actions" id="show-action${id}" style="display:none;">
                            <span class="angle">
                                <img src="{{ public_asset('assets/images/angle.png') }}">
                            </span>
                            <ul>
                                <li>
                                    <a href="${row.delete_url}"
                                       onclick="return confirm('Delete this academic program?')">
                                       Delete
                                    </a>
                                </li>

                                <li>
                                    <a href="${row.status_toggle_url}">
                                        ${row.status == 1 ? 'Deactivate' : 'Activate'}
                                    </a>
                                </li>

                                <li>
                                    <a href="${row.view_url}">View / Edit</a>
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
         $('select[name="status"]').val('');
        $('select[name="year"]').val('');
        $('select[name="subject"]').val('');
        $('select[name="curriculum"]').val('');
        $('select[name="state"]').val('');
        $('input[name="search_text"]').val('');
        table.draw();
    });

    // Action dropdown
    let openDropdown = null;

    $(document).on('click', '.action', function (e) {
        e.stopPropagation();

        const $btn = $(this);
        const $dropdown = $btn.siblings('.show-actions');

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

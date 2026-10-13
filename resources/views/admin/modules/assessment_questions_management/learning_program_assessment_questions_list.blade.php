@extends('admin.layouts.app')

@section('title')
Learning Program Assessment Questions
@endsection

@section('links')
@include('admin.includes.links')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
.content-preview {
    max-width: 260px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
td {
    position: relative;
}
.show-actions {
    position: absolute;
    top: 40px;
    z-index: 999;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    min-width: 160px;
    left: 0 !important;
    box-shadow: 0 4px 10px rgba(0,0,0,0.12);
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    color: #fff !important;
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
            <h1 class="pull-left page-title">Assessment Questions</h1>

            <div class="pull-right">
                <a href="{{ route('learning.assessment.questions.add.page') }}" class="btn btn-primary">
                    Add Question
                </a>
            </div>
        </div>
    </div>

    <!-- FILTER -->
    <div class="row">
        <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading rm02 rm04">

    <div class="row">

        <div class="form-group col-md-3">
            <label>Assessment Form</label>

            <select name="form_id" class="form-control reset_val">
                <option value="">Select Form</option>

                @foreach($forms as $form)
                <option value="{{ $form->id }}">
                    {{ $form->form_name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3">
            <label>Assessment Type</label>

            <select name="assessment_type" class="form-control reset_val">

                <option value="">Select</option>

                <!-- <option value="general">General</option> -->
                <option value="oc">OC</option>
                <option value="selective">Selective</option>

                <option value="year-1">Year 1</option>
                <option value="year-2">Year 2</option>
                <option value="year-3">Year 3</option>
                <option value="year-4">Year 4</option>
                <option value="year-5">Year 5</option>
                <option value="year-6">Year 6</option>
                <option value="year-7">Year 7</option>
                <option value="year-8">Year 8</option>
                <option value="year-9">Year 9</option>
                <option value="year-10">Year 10</option>
                <option value="year-11">Year 11</option>
                <option value="year-12">Year 12</option>

            </select>
        </div>

        <div class="form-group col-md-2">
            <label>Question Mode</label>

            <select name="type" class="form-control reset_val">
                <option value="">Select</option>
                <option value="qualitative">Qualitative</option>
                <option value="quantitative">Quantitative</option>
            </select>
        </div>

        <div class="form-group col-md-2">
            <label>Section</label>

            <select name="section" class="form-control reset_val">
                <option value="">Select</option>
                <option value="reading">Reading</option>
                <option value="writing">Writing</option>
                <option value="thinking">Thinking</option>
                <option value="reasoning">Reasoning</option>
                <option value="logic">Logic</option>
            </select>
        </div>

        <div class="form-group col-md-2">
            <label>Status</label>

            <select name="status" class="form-control reset_val">
                <option value="">Select</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

    </div>

    <div class="row">

    <div class="col-md-12 text-center" style="margin-top:1px;">

        <button class="btn btn-primary search_click" type="button">
            Search
        </button>

        <button class="btn btn-default reset_search"
                type="button"
                style="margin-left:10px;">
            Reset
        </button>

    </div>

</div>

</div>

            <div class="panel-body">
                <div class="table-responsive">
                    <table id="questionsTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Assessment Form</th>
                                <th>Assessment Type</th>
                                <th>Question Mode</th>
                                <th>Section</th>
                                <th>Question</th>
                                <!-- <th>Question Type</th> -->
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

    var table = $('#questionsTable').DataTable({
        processing: true,
        serverSide: true,
        serverMethod: 'POST',
        pageLength: 10,

        ajax: {
            url: "{{ route('learning.assessment.questions.list.ajax') }}",
            type: "POST",
            data: function (d) {
                d._token  = "{{ csrf_token() }}";
                d.section = $('select[name="section"]').val();
                d.type    = $('select[name="type"]').val();
                d.status  = $('select[name="status"]').val();
                d.form_id = $('select[name="form_id"]').val();
                d.assessment_type = $('select[name="assessment_type"]').val();
            }
        },

        language: {
            emptyTable: "No assessment questions found"
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
            { data: 'form_name' },
            { data: 'assessment_type',
                render: function (data) {
                if (!data) return '-';
                return data
                 .replace(/-/g, ' ')
                .replace(/\b\w/g, l => l.toUpperCase());
                }
            },
            { data: 'type' },
            { data: 'section' },
            {
                data: 'question',
                render: function (data) {
                    return `<div class="content-preview">${data}</div>`;
                }
            },
            // { data: 'question_type' },
            {
                data: 'status',
                render: function (val) {
                    return val
                        ? '<span class="label label-success">Active</span>'
                        : '<span class="label label-warning">Inactive</span>';
                }
            },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function (id, type, row) {
                    return `
                        <a href="javascript:void(0);" class="action">
                            <img src="{{ public_asset('assets/images/action-dots.png') }}">
                        </a>

                        <div class="show-actions" style="display:none;">
                            <ul>
                                <li>
                                    <a href="${row.view_url}">View / Edit</a>
                                </li>
                                <li>
                                    <a href="${row.status_toggle_url}">
                                        ${row.status ? 'Deactivate' : 'Activate'}
                                    </a>
                                </li>
                                <li>
                                    <a href="${row.delete_url}"
                                       onclick="return confirm('Delete this question?')">
                                       Delete
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
        $('.reset_val').val('');
        table.draw();
    });

    // Action dropdown logic (same as blog)
    let openDropdown = null;

    $(document).on('click', '.action', function (e) {
        e.stopPropagation();
        const dropdown = $(this).siblings('.show-actions');

        if (openDropdown && openDropdown.is(dropdown)) {
            dropdown.hide();
            openDropdown = null;
            return;
        }

        $('.show-actions').hide();
        dropdown.show();
        openDropdown = dropdown;
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

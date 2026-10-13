@extends('admin.layouts.app')

@section('title')
Assessment Forms
@endsection

@section('links')
@include('admin.includes.links')

<link rel="stylesheet"
href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

<style>
.show-actions{
    position:absolute;
    top:40px;
    left:0;
    z-index:999;
    background:#fff;
    border:1px solid #ddd;
    min-width:170px;
    border-radius:4px;
    box-shadow:0 4px 10px rgba(0,0,0,0.12);
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

    <div class="row">
        <div class="col-sm-12">

            <h1 class="pull-left page-title">
                Assessment Forms
            </h1>

            <div class="pull-right">
                <a href="{{ route('learning.assessment.forms.add.page') }}"
                class="btn btn-primary">
                    Add Form
                </a>
            </div>

        </div>
    </div>

    <div class="row">
    <div class="col-md-12">
    <div class="panel panel-default">

        <div class="panel-heading rm02 rm04">

            <div class="form-group">
                <label>Assessment Type</label>

                <select name="assessment_type"
                class="form-control reset_val">

                    <option value="">Select</option>
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

            <div class="form-group">
                <label>Status</label>

                <select name="status"
                class="form-control reset_val">

                    <option value="">Select</option>

                    <option value="1">Active</option>
                    <option value="0">Inactive</option>

                </select>
            </div>

            <div class="centerButtons" style="margin-top:25px;">
                <button type="button"
                class="btn btn-primary search_click">
                    Search
                </button>

                <button type="button"
                class="btn btn-primary reset_search">
                    Reset
                </button>
            </div>

            <div class="clearfix"></div>

        </div>

        <div class="panel-body">

            <div class="table-responsive">

                <table id="formsTable"
                class="table table-striped table-bordered">

                    <thead>
                        <tr>

                            <th>S.No</th>
                            <th>Form Name</th>
                            <th>Assessment Type</th>
                            <th>Form URL</th>
                            <th>Category</th>
                            <th>Sections</th>
                            <th>Passages</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>

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

    var table = $('#formsTable').DataTable({

        processing: true,

        serverSide: true,

        serverMethod: 'POST',

        ajax: {

            url: "{{ route('learning.assessment.forms.list.ajax') }}",

            type: "POST",

            data: function (d) {

                d._token =
                    "{{ csrf_token() }}";

                d.assessment_type =
                    $('select[name="assessment_type"]').val();

                d.status =
                    $('select[name="status"]').val();
            }
        },

        columns: [

            {
                data: null,
                render: function (data, type, row, meta) {

                    return meta.row +
                    meta.settings._iDisplayStart + 1;
                }
            },

            { data: 'form_name' },

            { data: 'assessment_type' },

            { data: 'form_url',
                render: function (url) {
                    return `
                    <a href="${url}" target="_blank">
                        ${url}
                    </a>`;
                }
            },

            { data: 'category' },

            { data: 'sections' },

            { data: 'passage_count' },

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

                render: function (id, type, row) {

                    return `
                    <a href="javascript:void(0);"
                    class="action">
                        <img src="{{ public_asset('assets/images/action-dots.png') }}">
                    </a>

                    <div class="show-actions" style="display:none;">
                        <ul>

                            <li>
                                <a href="${row.view_url}">
                                    View
                                </a>
                            </li>

                            <li>
                                <a href="${row.status_toggle_url}">
                                    ${row.status ? 'Deactivate' : 'Activate'}
                                </a>
                            </li>

                            <li>
                                <a href="${row.delete_url}"
                                onclick="return confirm('Delete form?')">
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

    $('.search_click').click(function () {
        table.draw();
    });

    $('.reset_search').click(function () {

        $('.reset_val').val('');

        table.draw();
    });

    $(document).on('click', '.action', function (e) {

        e.stopPropagation();

        $('.show-actions').hide();

        $(this)
        .siblings('.show-actions')
        .toggle();
    });

    $(document).click(function () {
        $('.show-actions').hide();
    });

});

</script>
@endsection
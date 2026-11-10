@extends('admin.layouts.app')

@section('title')
Tutor Details
@endsection

@section('links')
@include('admin.includes.links')
<script src="{{ public_asset('admin/assets/js/modernizr.min.js') }}"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

<style>
 
#example thead th {
    position: relative !important;
    padding: 14px 30px 14px 12px !important;
    white-space: nowrap !important;
    background: #f9fafb !important;
    font-weight: 600;
    color: #333;
    cursor: pointer;
    vertical-align: middle !important;
    border: 1px solid #dfe3e8 !important;
    border-bottom: 2px solid #d1d5db !important;
}

table.dataTable thead th.sorting:before,
table.dataTable thead th.sorting:after,
table.dataTable thead th.sorting_asc:before,
table.dataTable thead th.sorting_asc:after,
table.dataTable thead th.sorting_desc:before,
table.dataTable thead th.sorting_desc:after {
    right: 8px !important;
    opacity: 0.4;
}

table.dataTable thead th.sorting_asc:before,
table.dataTable thead th.sorting_desc:after {
    color: #b80f0a !important;
    opacity: 1 !important;
}

#example thead th:hover {
    background: #f1f1f1 !important;
    color: #b80f0a;
}

.td-sub {
    color: #6b7280;
    margin: 0 0 18px;
}

.td-filter-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 18px 20px;
    margin-bottom: 22px;
}

.td-filter-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    align-items: flex-end;
}

.td-filter-grid .form-group {
    flex: 1 1 220px;
    margin-bottom: 0;
}

.td-filter-grid label {
    font-weight: 600;
    display: block;
    margin-bottom: 6px;
}

.td-actions {
    display: flex;
    gap: 10px;
}

.td-btn-primary {
    background: #b80f0a;
    border: 1px solid #b80f0a;
    color: #fff;
    padding: 9px 26px;
    border-radius: 4px;
}

.td-btn-light {
    background: #fff;
    border: 1px solid #d1d5db;
    color: #333;
    padding: 9px 26px;
    border-radius: 4px;
}

.td-btn-outline {
    background: #fff;
    border: 1px solid #b80f0a;
    color: #b80f0a;
    padding: 7px 18px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
}

.td-btn-outline.download {
    background: #b80f0a;
    border: 1px solid #b80f0a;
    color: #eee6e6;
    padding: 7px 18px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
}

.td-btn-outline:hover {
    background: #b80f0a;
    color: #fff;
}

.td-help {
    color: #6b7280;
    font-size: 12px;
    margin: 14px 0 0;
}

.td-list-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.td-list-head h3 {
    margin: 0;
    display: inline-block;
}

.td-count {
    color: #6b7280;
    margin-left: 8px;
}

.td-tag {
    display: inline-block;
    background: #fde8e8;
    color: #b80f0a;
    border-radius: 14px;
    padding: 3px 10px;
    font-size: 12px;
}

.td-cap {
    max-width: 220px;
    white-space: normal !important;
    overflow: visible;
    text-overflow: unset;
    word-break: break-word;
    overflow-wrap: anywhere;
}

.td-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .35);
    z-index: 10000;
}

.td-overlay.open {
    display: block;
}

#example tbody td:nth-child(4),
#example tbody td:nth-child(6),
#example tbody td:nth-child(7) {
    white-space: normal !important;
    min-width: 150px;
    max-width: 220px;
    word-break: break-word;
    overflow-wrap: anywhere;
}

#example tbody td:not(:nth-child(4)):not(:nth-child(6)):not(:nth-child(7)) {
    white-space: nowrap;
}

.td-drawer {
    position: fixed;
    top: 0;
    right: -480px;
    width: 480px;
    max-width: 100%;
    height: 100%;
    background: #fff;
    z-index: 10001;
    box-shadow: -4px 0 16px rgba(0, 0, 0, .15);
    transition: right .3s;
    display: flex;
    flex-direction: column;
}

.td-drawer.open {
    right: 0;
}

.td-drawer-head {
    padding: 22px 26px 14px;
    border-bottom: 1px solid #e5e7eb;
    position: relative;
}

.td-drawer-head h3 {
    margin: 0 0 4px;
    font-weight: 700;
    color: #1f2d3d;
}

.td-drawer-head p {
    margin: 0;
    color: #6b7280;
}

.td-drawer-close {
    position: absolute;
    right: 22px;
    top: 20px;
    background: none;
    border: 0;
    font-size: 26px;
    line-height: 1;
    color: #6b7280;
    cursor: pointer;
}

.td-drawer-body {
    padding: 22px 26px;
    overflow-y: auto;
    flex: 1;
}

.td-drawer-foot {
    padding: 16px 26px;
    border-top: 1px solid #e5e7eb;
    text-align: right;
}

.td-drawer-foot button {
    margin-left: 10px;
}

/* Tutor Information */
.td-who {
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 14px 16px;
    margin-bottom: 22px;
}

.td-who strong {
    display: block;
    color: #1f2d3d;
}

.td-who span {
    color: #6b7280;
    font-size: 13px;
}

.td-drawer label {
    font-weight: 700;
    display: block;
    margin-bottom: 6px;
}

.td-hint {
    color: #6b7280;
    font-size: 12px;
    margin: 6px 0 0;
}

.td-counter {
    text-align: right;
    color: #6b7280;
    font-size: 12px;
}

.td-btn-red {
    background: #b80f0a;
    border: 1px solid #b80f0a;
    color: #fff;
    padding: 9px 22px;
    border-radius: 4px;
    font-weight: 600;
}

/* ================================
   DATATABLE STYLING
================================ */

/* Main Table */
#example {
    width: 100% !important;
    border-collapse: collapse !important;
    border-spacing: 0 !important;
    border: 1px solid #e5e7eb !important;
}

/* Header and Body Common */
#example thead th,
#example tbody td {
    vertical-align: middle !important;
    box-sizing: border-box !important;
}

/* Header */
#example thead th {
    background: #f9fafb !important;
    border: 1px solid #dfe3e8 !important;
    border-bottom: 2px solid #d1d5db !important;
}

/* Body Cells */
#example tbody td {
    border: 1px solid #e5e7eb !important;
    padding: 12px !important;
}

/* Alternate Row Background */
#example tbody tr:nth-child(even) {
    background-color: #fafafa !important;
}

#example tbody tr:nth-child(odd) {
    background-color: #ffffff !important;
}

/* Row Hover */
#example tbody tr:hover {
    background-color: #fff5f5 !important;
}

/* DataTable Wrapper */
.dataTables_wrapper {
    width: 100%;
}

.dataTables_scroll {
    width: 100%;
}

/* Header and Body Alignment */
.dataTables_scrollHead,
.dataTables_scrollBody {
    width: 100% !important;
}

.dataTables_scrollHeadInner {
    box-sizing: border-box !important;
}

.dataTables_scrollHeadInner table,
.dataTables_scrollBody table {
    width: 100% !important;
    margin: 0 !important;
    border-collapse: collapse !important;
    border-spacing: 0 !important;
}

/* Scroll Body */
.dataTables_scrollBody {
    overflow-x: auto !important;
    scrollbar-width: none !important;
    -ms-overflow-style: none !important;
    border-bottom: 1px solid #dfe3e8 !important;
}

.dataTables_scrollBody::-webkit-scrollbar {
    display: none !important;
    width: 0 !important;
    height: 0 !important;
}

/* DataTable Bottom Border */
table.dataTable.no-footer {
    border-bottom: 1px solid #dfe3e8 !important;
}

/* Consistent Cell Borders */
table.dataTable thead th,
table.dataTable tbody td {
    box-sizing: border-box !important;
}

    .dataTables_scrollBody {
    overflow-x: auto !important;
    scrollbar-width: none !important;
    -ms-overflow-style: none !important;
}

.dataTables_scrollBody::-webkit-scrollbar {
    display: none !important;
    width: 0 !important;
    height: 0 !important;
}
/* Remove extra line below table header */
.dataTables_scrollHead {
    border-bottom: 0 !important;
}

.dataTables_scrollHead table.dataTable {
    border-bottom: 0 !important;
}

.dataTables_scrollHead thead th {
    border-bottom: 1px  #dfe3e8 !important;
    box-shadow: none !important;
}

/* Avoid duplicate header border */
.dataTables_scrollBody table.dataTable thead {
    visibility: collapse !important;
}

.dataTables_scrollBody table.dataTable thead th {
    border: 0 !important;
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
            <div class="col-sm-12 col-xs-12">
                <h1 class="pull-left page-title">Tutor Details</h1>

                <ol class="breadcrumb pull-right">
                    <li>Tutor Management</li>
                    <li class="active">Tutor Details</li>
                </ol>
            </div>
        </div>

        <p class="td-sub">
            View tutor information and manage skill tags and capability statements.
        </p>

        @include('admin.includes.message')

        {{-- Filters --}}
        <div class="td-filter-card">

            <div class="td-filter-grid">

                <div class="form-group">
                    <label for="f_name">Tutor Name / Email / Phone</label>
                    <div class="form-group">
                        <input type="text"
                            id="f_name"
                            class="form-control bg-white"
                            placeholder="Name, email or phone"
                            value=""
                            autocomplete="off"
                            readonly
                            onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                    </div>
                </div>

                <div class="form-group">
                    <label for="f_state">State</label>
                    <select id="f_state" class="form-control">
                        <option value="">All states</option>
                        @foreach($states as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="f_year_level">Year Levels</label>
                    <select id="f_year_level" class="form-control">
                        <option value="">All year levels</option>
                        @foreach($yearLevels as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="f_subject">Subjects</label>
                    <select id="f_subject" class="form-control">
                        <option value="">All subjects</option>
                        @foreach($subjects as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="td-filter-grid" style="margin-top:16px;">

                <div class="form-group">
                    <label for="f_program_type">Program Type</label>
                    <select id="f_program_type" class="form-control">
                        <option value="">All program types</option>
                        @foreach($programTypes as $s)
                        <option value="{{ $s }}">{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="f_learning_program">Learning Programs</label>
                    <select id="f_learning_program" class="form-control">
                        <option value="">All learning programs</option>
                        @foreach($learningPrograms as $s)
                        <option value="{{ $s }}">{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="td-actions">
                    <button type="button" class="td-btn-primary" id="btn_search">
                        Search
                    </button>

                    <button type="button" class="td-btn-light" id="btn_reset">
                        Reset
                    </button>
                </div>

            </div>

            <p class="td-help">
                Choose one or more filters, then select Search. Tutor profile information
                is read-only here except Skill Tag and Capability Statement.
            </p>

        </div>

        {{-- List --}}
        <div class="td-list-head">
            <div>
                <h3>Tutors</h3>
                <span class="td-count" id="result_count"></span>
            </div>

            <a href="javascript:void(0);" class="td-btn-outline download" id="download">
                &#8681; Download
            </a>
        </div>

        <div>
            <table class="table table-bordered table-striped"
                id="example"
                style="width:100%">

                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>State</th>
                        <th>Year Levels</th>
                        <th>Subjects</th>
                        <th>Program Type</th>
                        <th>Learning Programs</th>
                        <th>Skill Tag</th>
                        <th>Capability Statement</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody></tbody>

            </table>
        </div>

    </div>
</div>
{{-- Edit drawer --}}
<div class="td-overlay" id="tdDrawerOverlay"></div>

<div class="td-drawer" id="tdDrawer">

    <form id="tutorDetailsForm">

        @csrf

        <div class="td-drawer-head">
            <h3>Tutor details</h3>
            <p>Update the tutor's skill tag and capability statement.</p>

            <button type="button"
                class="td-drawer-close"
                id="tdDrawerClose">
                &times;
            </button>
        </div>

        <div class="td-drawer-body">

            <input type="hidden" id="edit_tutor_id" name="tutor_id">

            <div class="td-who">
                <strong id="edit_tutor_name"></strong>
                <span id="edit_tutor_email"></span>
            </div>

            <div class="form-group">
                <label for="edit_skill_tag">Skill Tag</label>

                <input type="text"
                    id="edit_skill_tag"
                    name="skills"
                    class="form-control"
                    maxlength="80">

                <p class="td-hint">
                    A short description of this tutor's specialisation.
                </p>

                <div class="td-counter">
                    <span id="skill_count">0</span> / 80
                </div>

                <p class="error_skill_tag" style="color:#ef5350;"></p>
            </div>

            <div class="form-group">
                <label for="edit_capability">Capability Statement</label>

                <textarea id="edit_capability"
                    name="capabilities"
                    class="form-control"
                    rows="8"
                    maxlength="600"></textarea>

                  <p class="td-hint">
                    Describe who this tutor is, their relevant expertise, and how they help students.
                </p>

                <div class="td-counter">
                    <span id="capability_count">0</span> / 600
                </div>

                <p class="error_capability" style="color:#ef5350;"></p>
            </div>

        </div>

        <div class="td-drawer-foot">

            <button type="button"
                class="td-btn-light"
                id="btn_cancel_edit">
                Cancel
            </button>

            <button type="submit"
                class="td-btn-red"
                id="btn_save_edit">
                Save changes
            </button>

        </div>

    </form>

</div>
@endsection

@section('footer')
@include('admin.includes.footer')
@endsection

@section('script')
@include('admin.includes.script')

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#f_name').val('');

        function esc(v) {
            if (v === null || v === undefined) {
                return '';
            }

            return $('<div>').text(v).html();
        }

        function filters() {
            return {
                name: $('#f_name').val(),
                state: $('#f_state').val(),
                year_level: $('#f_year_level').val(),
                subject: $('#f_subject').val(),
                program_type: $('#f_program_type').val(),
                learning_program: $('#f_learning_program').val()
            };
        }

        var dataTableObj = {
            processing: true,
            serverSide: true,
            serverMethod: 'post',
            searching: false,
            lengthChange: true,
            ordering: false,
            paging: true,
            pageLength: 10,
            pagingType: 'simple_numbers',
            scrollX: true,
            autoWidth: false,

            language: {
                emptyTable: 'No tutors found',
                zeroRecords: 'No tutors found'
            },

            ajax: {
                url: "{{ route('list.tutors.details') }}",
                type: 'POST',

                data: function(d) {

                    d._token = "{{ csrf_token() }}";

                    $.extend(d, filters());

                    console.log('Name field value:', $('#f_name').val());
                    console.log('DataTables request:', d);
                },

                error: function(xhr) {

                    console.log('Tutor list error:', xhr.status, xhr.responseText);

                    toastr.error('Could not load tutors (' + xhr.status + ')');
                },

                dataSrc: function(resp) {

                    $('#result_count').text(
                        (resp.recordsFiltered || 0) + ' results'
                    );

                    return resp.data || [];
                }
            },

            columns: [

                {
                    data: 'f_name',
                    render: esc
                },

                {
                    data: 'l_name',
                    render: esc
                },

                {
                    data: 'state',
                    render: esc
                },

                {
                    data: 'year_levels',
                    render: esc
                },

                {
                    data: 'subjects',
                    render: esc
                },

                {
                    data: 'program_type',
                    render: esc
                },

                {
                    data: 'learning_programs',
                    render: esc
                },

                {
                    data: 'skills',

                    render: function(d) {

                        return d ?
                            '<span class="td-tag">' + esc(d) + '</span>' :
                            '';
                    }
                },

                {
                    data: 'capabilities',

                    render: function(d) {

                        return d ?
                            '<div class="td-cap" title="' + esc(d) + '">' + esc(d) + '</div>' :
                            '';
                    }
                },

                {
                    data: 'id',

                    render: function() {

                        return '<a href="javascript:void(0);" class="td-btn-outline edit_details">Edit details</a>';
                    }
                }

            ]

        };


        var table = dataTableCall(dataTableObj, "example");


        var sb = $('.dataTables_scrollBody');

        var dragging = false;
        var startX = 0;
        var startLeft = 0;

        $('#btn_search').on('click', function() {

            table.ajax.reload();

        });

        $('#btn_reset').on('click', function() {

            $('#f_name').val('');

            $('#f_state, #f_year_level, #f_subject, #f_program_type, #f_learning_program').val('');

            table.ajax.reload();

        });


        $('#download').on('click', function(e) {

            e.preventDefault();

            var url = "{{ route('tutor.details.download') }}";

            window.location.href = url + '?' + $.param(filters());

        });


        function openDrawer() {

            $('#tdDrawerOverlay, #tdDrawer').addClass('open');

        }

        function closeDrawer() {

            $('#tdDrawerOverlay, #tdDrawer').removeClass('open');

        }

        function updateCount() {

            $('#skill_count').text($('#edit_skill_tag').val().length);
            $('#capability_count').text($('#edit_capability').val().length);

        }



        $('#example tbody').on('click', '.edit_details', function() {

            var row = table.row($(this).closest('tr')).data();


            if (!row) {
                return;
            }

            $('#edit_tutor_id').val(row.id);

            $('#edit_tutor_name').text(
                ((row.f_name || '') + ' ' + (row.l_name || '')).trim()
            );

            $('#edit_tutor_email').text(row.email || '');

            $('#edit_skill_tag').val(row.skills || '');

            $('#edit_capability').val(row.capabilities || '');

            $('.error_skill_tag, .error_capability').text('');

            updateCount();

            openDrawer();

        });

        $('#edit_skill_tag').on('input', updateCount);
        $('#edit_capability').on('input', updateCount);

        $('#tdDrawerClose, #btn_cancel_edit, #tdDrawerOverlay').on('click', function() {

            closeDrawer();

        });

        $('#tutorDetailsForm').on('submit', function(e) {

            e.preventDefault();

            $('.error_skill_tag, .error_capability').text('');

            $.ajax({
                url: "{{ route('admin.tutor.details.save') }}",
                type: "POST",
                data: $(this).serialize(),

                success: function(response) {

                    if (response.success) {

                        toastr.success('Tutor details saved successfully!');

                        table.ajax.reload(null, false);

                        closeDrawer();
                    }
                },

                error: function(xhr) {

                    if (xhr.status === 422) {

                        let errors = xhr.responseJSON.errors;

                        $('.error_skill_tag').text(
                            errors.skills ? errors.skills[0] : ''
                        );

                        $('.error_capability').text(
                            errors.capabilities ? errors.capabilities[0] : ''
                        );

                    } else {

                        console.log(xhr.responseText);
                        toastr.error('Unable to save tutor details.');
                    }
                }
            });

        });
    });
</script>
@endsection
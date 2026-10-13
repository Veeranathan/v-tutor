@extends('admin.layouts.app')

@section('title')
Learning Program Management
@endsection

@section('links')
@include('admin.includes.links')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

<style>
td { position: relative; }

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
            <h1 class="pull-left page-title">Learning Program Management</h1>
        </div>
    </div>

    <!-- FILTER -->
    <div class="row">
        <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading rm02 rm04">

                 <!-- Assessment Mode -->
                <div class="form-group">
                    <label>Learning Program Mode</label>
                    <select name="visit_reason" class="form-control reset_val">
                        <option value="">Select</option>
                        <option value="free_assessment">Student Assessment</option>
                        <option value="book_session">Tutoring Session</option>
                        <option value="explore">Academic Programs</option>
                        <option value="research">Just Exploring</option>
                        <option value="oc_assessment">OC Assessment</option>
                        <option value="selective_assessment">Selective Assessment</option>
                    </select>
                </div>

                <!-- Assessment Status -->
                <div class="form-group" id="statusFilter" style="display:none;">
                    <label>Assessment Status</label>
                    <select name="status" class="form-control reset_val">
                        <option value="">Select</option>
                        <option value="pending">Pending</option>
                        <option value="progress">Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="centerButtons" style="margin-top:25px;">
                    <button class="btn btn-primary search_click" type="button">
                        Search
                    </button>
                    <button class="btn btn-primary reset_search" type="button">
                        Reset
                    </button>
                </div>

                <div class="clearfix"></div>
            </div>

            <!-- TABLE -->
            <div class="panel-body">
                @include('admin.includes.message')

                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Parent Name</th>
                                <th>Child Name</th>
                                <th>Learning For</th>
                                <th>Program Mode</th>
                                <th>Assessment Form</th>
                                <th>Grade</th>
                                <th>Status</th>
                                <th>Submitted On</th>
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
function toggleStatusFilter() {
    const mode = $('select[name="visit_reason"]').val();

    if (mode === 'free_assessment') {
        $('#statusFilter').show();
    } else {
        $('#statusFilter').hide();
        $('select[name="status"]').val(''); // reset status when hidden
    }
}

// on change
$('select[name="visit_reason"]').on('change', function () {
    toggleStatusFilter();
    table.draw(); // optional: auto refresh
});

// on page load (important)
toggleStatusFilter();

$(document).ready(function () {

    var table = $('#example').DataTable({
        processing: true,
        serverSide: true,
        serverMethod: 'POST',
        pageLength: 10,
        order: [[7, 'desc']],

        ajax: {
            url: "{{ route('learning.assessment.list') }}",
            type: "POST",
            data: function (d) {
                d._token       = "{{ csrf_token() }}";
                d.status       = $('select[name="status"]').val();
                d.visit_reason = $('select[name="visit_reason"]').val();
            }
        },

        language: {
            emptyTable: "No assessments found"
        },

        createdRow: function (row, data) {
            $(row).attr('id', 'row' + data.id);
        },

        columns: [
            { data: 'parent_name' },
            { data: 'child_name' },
            { data: 'assessment_for' },
            { data: 'visit_reason' },       
            { data: 'assessment_form_name' },
            { data: 'grade' },
            { data: 'status' },
            { data: 'created_at' },

            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function (id, type, row) {
                    return `
                        <a href="javascript:void(0);" class="action" data-id="${id}">
                            <img src="{{ public_asset('admin/assets/images/action-dots.png') }}">
                        </a>

                        <div class="show-actions" style="display:none;">
                            <ul>
                                <li>
                                    <a href="${row.view_url}">
                                        View
                                    </a>
                                </li>
                                <li>
                                    <a href="${row.action_url}">
                                     Action
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="delete_assessment" data-id="${id}">
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

    /* SEARCH */
    $('.search_click').on('click', function () {
        table.draw();
    });

    /* RESET */
    $('.reset_search').on('click', function () {
        $('.reset_val').val('');
        table.draw();
    });

    /* ACTION DROPDOWN */
    let openDropdown = null;

    $(document).on('click', '.action', function (e) {
        e.stopPropagation();

        const dropdown = $(this).siblings('.show-actions');

        $('.show-actions').hide();

        if (openDropdown && openDropdown.is(dropdown)) {
            openDropdown = null;
        } else {
            dropdown.show();
            openDropdown = dropdown;
        }
    });

    $(document).on('click', function () {
        $('.show-actions').hide();
        openDropdown = null;
    });

    /* DELETE */
    $(document).on('click', '.delete_assessment', function () {
        let id = $(this).data('id');

        if (!confirm('Are you sure you want to delete this assessment?')) return;

        $.get("{{ url('admin/delete-learning-assessment') }}/" + id, function (resp) {
            if (resp.success) {
                table.row('#row' + id).remove().draw(false);
                toastr.success(resp.message);
            } else {
                toastr.error(resp.message);
            }
        });
    });
});
</script>
@endsection

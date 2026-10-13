@extends('admin.layouts.app')

@section('title')
Programme Management
@endsection

@section('links')
@include('admin.includes.links')

<script src="{{ public_asset('admin/assets/js/modernizr.min.js') }}"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>
.show-actions
 {
    left: 79% !important;
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

        <!-- Title Row -->
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <h1 class="pull-left page-title">Programme Management</h1>
            </div>
        </div>

        <!-- Search Panel -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-heading rm02 rm04">
                        <form role="form" id="searchProgramme" method="GET">

                            <div data-column="1" class="form-group">
                                <label for="keyword_filter">Search Email / Program</label>
                                <input type="text"
                                       placeholder="Search..."
                                       id="keyword_filter"
                                       name="keyword"
                                       class="form-control reset_val mt-4"
                                       autocomplete="off"
                                       readonly
                                       onfocus="this.removeAttribute('readonly');"
                                       onblur="this.removeAttribute('readonly');">
                            </div>

                            <div class="rm05">
                                <button class="btn btn-primary waves-effect waves-light w-md search_click"
                                        type="button">Search</button>
                            </div>

                            <div class="rm05">
                                <button class="btn btn-primary waves-effect waves-light w-md reset_search"
                                        type="button">Reset</button>
                            </div>

                            <div class="rm05 rightButtons">
                                <button class="btn btn-primary waves-effect waves-light w-md download" id="download"
                                        type="button">Download</button>
                            </div>

                            <div class="clearfix"></div>

                        </form>
                    </div>

                    <!-- Table -->
                    <div class="panel-body">
                        @include('admin.includes.message')

                        <div class="row">
                            <div class="col-md-12">

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="example">
                                        <thead>
                                            <tr>
                                                <th class="rm07">Parent Name</th>
                                                <th class="rm07">Email</th>
                                                <th class="rm07">Student Name</th>
                                                <th class="rm07">Grade</th>
                                                <th class="rm07">Programs</th>
                                                <th class="rm07">Subscribed</th>
                                                <th class="rm07">Terms</th>
                                                <th class="rm07">State</th>
                                                <th class="rm07">Action</th>
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
$(document).ready(function() {

    var table = $('#example').DataTable({
        processing: true,
        serverSide: true,
        serverMethod: 'POST',

        ajax: {
            url: "{{ route('programme.management') }}",
            type: "POST",
            data: function (d) {
                d._token = "{{ csrf_token() }}";
                d.keyword = $('#keyword_filter').val();
            }
        },

        createdRow: function(row, data) {
            $(row).addClass("tr_class_" + data.id);
        },

        columns: [
            { data: 'parent_name' },
            { data: 'email' },
            { data: 'student_name' },
            { data: 'student_grade' },

            {
                data: 'programs',
                render: function(data) {
                    if (!data) return "";
                    try {
                        let arr = JSON.parse(data);
                        return arr.join(", ");
                    } catch(e) {
                        return data;
                    }
                }
            },

            {
                data: 'subscribe',
                render: val => val ? '<b class="text-success">Yes</b>' :
                                     '<b class="text-danger">No</b>'
            },

            {
                data: 'terms_agreed',
                render: val => val ? '<b class="text-success">Yes</b>' :
                                     '<b class="text-danger">No</b>'
            },
            { data: 'ref_source' },
            {
    data: 'id',
    render: function(id) {
        return `
            <a href="javascript:void(0);" class="action-dots action" data-key="${id}">
                <img src="{{ public_asset('admin/assets/images/action-dots.png') }}">
            </a>

            <div class="show-actions" id="show-action${id}" style="display:none;">
                <span class="angle">
                    <img src="{{ public_asset('admin/assets/images/angle.png') }}">
                </span>

                <ul>
                    <li>
                        <a href="{{ url('admin/view-Programme') }}/${id}">View</a>
                    </li>

                    <li>
                        <a href="javascript:void(0);"
                           class="delete_programme"
                           data-id="${id}">
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

    // Toggle dropdown
    $(document).on("click", ".action", function () {
        var id = $(this).data("key");
        $("#show-action" + id).slideToggle();
    });

    // Search
    $('.search_click').click(function () {
        table.draw();
    });

    // Reset
    $('.reset_search').click(function () {
        $(".reset_val").val("");
        table.search('').columns().search('').draw();
    });

    // Delete Programme
    $(document).on("click", ".delete_programme", function () {
        var id = $(this).data("id");

        if (!confirm("Are you sure you want to delete this programme?")) return;

        $.ajax({
            url: "{{ url('admin/delete-Programme') }}/" + id,
            type: "GET",
            success: function (resp) {
                if (resp.success) {
                    table.row(".tr_class_" + id).remove().draw(false);
                    toastr.success(resp.message);
                } else {
                    toastr.error(resp.message);
                }
            }
        });
    });

    // Download
    $('#download').click(function () {
    window.location.href =
        "{{ route('programme.management.download') }}?keyword=" +
        $('#keyword_filter').val();
});

});
</script>
@endsection

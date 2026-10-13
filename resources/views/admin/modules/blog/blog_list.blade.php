@extends('admin.layouts.app')

@section('title')
Blog Management
@endsection

@section('links')
@include('admin.includes.links')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

<style>
.blog-thumb {
    width: 60px;
    height: 45px;
    object-fit: cover;
    border-radius: 4px;
}
.content-preview {
    max-width: 220px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
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
.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
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
            <h1 class="pull-left page-title">Blog Management</h1>

            <div class="rm05 backclass pull-right">
                <a href="{{ route('add.blog.page') }}" class="btn btn-primary">
                    Add Blog
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
                    <label>User Type</label>
                    <select name="user_type" class="form-control reset_val">
                        <option value="">Select</option>
                        <option value="admin">Admin</option>
                        <option value="author">Author</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control reset_val">
                        <option value="">Select</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>

                <div class="centerButtons" style="margin-top:25px;">
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
                                <th>S.No</th>
                                <th>Post Title</th>
                                <th>Content</th>
                                <th>Image</th>
                                <th>User Type</th>
                                <th>User Name</th>
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
            url: "{{ route('blog.list.ajax') }}",
            type: "POST",
            data: function (d) {
                d._token   = "{{ csrf_token() }}";
                d.user_type = $('select[name="user_type"]').val();
                d.status    = $('select[name="status"]').val();
            }
        },

        language: {
            emptyTable: "No blogs found"
        },

        createdRow: function (row, data) {
            $(row).attr('id', 'data' + data.id);
        },

        columns: [
             {  data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'post_title' },

            {
                data: 'post_content',
                render: function (data) {
                    return `<div class="content-preview">${data}</div>`;
                }
            },

            {
                data: 'post_image',
                render: function (img) {
                    return img
                        ? `<img src="${img}" class="blog-thumb">`
                        : '—';
                }
            },

            { data: 'user_type' },
            { data: 'user_name' },

            {
                data: 'status',
                render: function (val) {
                    return val === 'published'
                        ? '<span class="label label-success">Published</span>'
                        : '<span class="label label-warning">Draft</span>';
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
                                       onclick="return confirm('Delete this blog?')">
                                       Delete
                                    </a>
                                </li>

                                <li>
                                    <a href="${row.status_toggle_url}">
                                        ${row.status === 'published' ? 'Deactivate' : 'Activate'}
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
        $('.reset_val').val('');
        table.draw();
    });

    // Action dropdown
    let openDropdown = null;

    $(document).on('click', '.action', function (e) {
        e.stopPropagation();

        const $btn = $(this);
        const $dropdown = $btn.siblings('.show-actions');

        // If clicking same icon → toggle
        if (openDropdown && openDropdown.is($dropdown)) {
            $dropdown.hide();
            openDropdown = null;
            return;
        }

        // Close any open dropdown
        $('.show-actions').hide();

        // Open current dropdown
        $dropdown.show();
        openDropdown = $dropdown;
    });

    // Close on outside click
    $(document).on('click', function () {
        $('.show-actions').hide();
        openDropdown = null;    
    });

    // Prevent closing when clicking inside dropdown
    $(document).on('click', '.show-actions', function (e) {
        e.stopPropagation();
    });
});
</script>
@endsection

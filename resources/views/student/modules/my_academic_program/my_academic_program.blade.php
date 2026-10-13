@extends('layouts.app')
@section('title')
<title>V-Tutor | Student | Assessment</title>
@endsection

@section('left_part')
@include('include.header_menu_part')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
 <style>
        .table-head {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .user-right-top {
            width: 100%;
            overflow-x: hidden; 
        }
        .custom-table table {
            width: 100% !important;
            table-layout: auto;
        }
        .custom-table table thead th {
            background-color: #d73c5e ;
            vertical-align: middle;
        }
        .dt-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .dt-bottom .dataTables_length {
            text-align: left;
        }

        .dt-bottom .dataTables_paginate {
            text-align: right;
        }

        .btn {
            text-transform: none !important;
            letter-spacing: normal;
            font-weight: 500;
        }
        #programTable th,
        #programTable td {
            text-align: center;
            vertical-align: middle;
        }
        #programTable th:nth-child(1),
        #programTable td:nth-child(1) {
            text-align: left;
        }
        .action-btn {
            padding: 4px 14px !important;
            font-size: 14px !important;
        }
        .get-program-btn {
            background-color: #d73c5e;
            color: #fff;
            display: inline-block;
            padding: 6px 15px;
            border-radius: 4px;
            text-decoration: none;
            border: none;
        }

        .get-program-btn:hover {
            background-color: #c23350; /* slightly darker on hover */
            color: #fff;
        }
    </style>
@endsection

@section('content')
<div class="top_mar"></div>

<section class="user-account">
    <div class="container">
        <div class="row">
            <div class="zin">
                @include('include.student_left_common')

                <div class="user-right-panel">
                    <div class="user-right-top-new">
                        @include('include.errors')
                        <h2 class="profile-heading">Learning Programs</h2>
                    </div>

                    <div class="turo-edit">
                        <div class="user-right-top">

                            <p>This section allows you to access learning program details</p>

                            {{-- FILTERS --}}
                            <div class="row mt-3 mb-3 align-items-center">

                                <div class="col-md-4">
                                    <label for="subject" class="form-label">Subject</label>
                                    <select class="form-select w-100" name="branch_id[]" id="filter_branch_id">
                                        <option value="">Select Subject</option>
                                        @php 
                                            $excluded = ['technologies-6', '-14'];
                                        @endphp
                                        @foreach($branches as $branch)
                                        @if(!in_array($branch->slug, $excluded))
                                        <option value="{{ $branch->slug }}">
                                            {{ $branch->branch_name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 d-flex gap-2 align-items-center">
                                    <button id="searchBtn" class="add_btn">Search</button>
                                    <button id="resetBtn" class="add_btn" style="background:#6c757d;">Reset</button>
                                </div>
                            </div>


                            {{-- TABLE --}}
                            <div class="custom-table">
                                <div class="mb-3" style="text-align: right;">
                                    <a href="{{ route('products',['type'=>'learning']) }}" class="get-program-btn">
                                        Get Programs
                                    </a>
                                </div>
                                <table id="programTable" class="cell-border table">
                                    <thead>
                                        <tr>
                                            <th>Program Name</th>
                                            <th>Subject</th>
                                            <th>Year</th>
                                            <th>Validity</th>
                                            <th>Sessions</th>
                                            <th>Tutor</th>
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
</section>
@endsection

@section('footer')
@include('include.footer')
@endsection

@section('script')
@include('include.script')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function () {

    let table = $('#programTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        autoWidth: false,
        scrollX: false,
        autoWidth: false,  
        scrollX: false,
        dom: 'frti<"dt-bottom"l p>',
        ajax: {
            url: "{{ route('student.academic.program.list.ajax') }}",
            data: function (d) {
                d.branch_id = $('#filter_branch_id').val();
            }
        },
        columns: [
            { data: 'name' },
            { data: 'subject' },
            { data: 'year' },
            { data: 'validity' },
            { data: 'remaining' },
            {
              data: 'tutor_name',
                render: function(data) {
                    return data ? data : '-';
            }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (row) {

                let viewBtn =
                    `<a href="/my-academic-program-view/${row.purchase_id}"
                        class="btn btn-sm btn-primary  action-btn">
                        View
                    </a>`;

                let bookBtn = '';

                if (row.remaining >= 1 && row.tutor_id) {

                let url = `/academic-booking/${row.purchase_id}`
                        + `?search_tutor_slug_studentclass=${row.tutor_slug}`
                        + `&search_tutor_id_studentclass=${row.tutor_id}`;

                bookBtn =
                    `<a href="${url}" class="btn btn-sm btn-success action-btn">
                    Book
                    </a>`;
                } else {
                bookBtn =
                    `<button class="btn btn-sm btn-secondary action-btn" disabled>
                    Book
                    </button>`;
                }

                return viewBtn + ' ' + bookBtn;
                }
            }   
        ],
        pageLength: 10,
        language: {
            emptyTable: "No learning programs found",
            info: "",
            infoEmpty: "",
            infoFiltered: ""
        }
    });

    $('#searchBtn').on('click', function () {
        table.ajax.reload();
    });
    $('#resetBtn').on('click', function () {
    $('#filter_branch_id').val('');
    table.ajax.reload();
});
});
</script>
@endsection

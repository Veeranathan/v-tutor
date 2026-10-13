@extends('layouts.app')
@section('title')
    <title>V-Tutor | Tutor | Academic Programs </title>
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

    </style>
@endsection

@section('content')
<div class="top_mar"></div>

<section class="user-account">
    <div class="container">
        <div class="row">
            <div class="zin">

                @include('include.teacher_left_common')

                <div class="user-right-panel tutor-right">
                    <div class="step_tab">
                        <ul>
                           <li>
                                    <a href="{{ route('teacher.profile') }}">
                                        <span><img src="{{ public_asset('assets/images/peri.png') }}" class="actt"><img
                                                src="{{ public_asset('assets/images/perih.png') }}" class="accth"></span>
                                        Personal
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('tutorship.plan') }}">
                                        <span><img src="{{ public_asset('assets/images/gar.png') }}" class="actt"><img
                                                src="{{ public_asset('assets/images/garh.png') }}" class="accth"></span>
                                        Tutoring Plan
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('tutor.acadamic') }}">
                                        <span><img src="{{ public_asset('assets/images/aca.png') }}" class="actt"><img
                                                src="{{ public_asset('assets/images/acah.png') }}" class="accth"></span>
                                        Academics
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('tutor.exp') }}">
                                        <span><img src="{{ public_asset('assets/images/ex.png') }}" class="actt"><img
                                                src="{{ public_asset('assets/images/exh.png') }}" class="accth"></span>
                                        Experience </a>
                                </li>
                                <li>
                                    <a href="{{ route('tutor.recognization') }}">
                                        <span><img src="{{ public_asset('assets/images/rec.png') }}" class="actt"><img
                                                src="{{ public_asset('assets/images/rech.png') }}" class="accth"></span>
                                        Recognitions
                                    </a>
                                </li>
                                 <li class="active">
                                    <a href="{{ route('tutorship.academic.program') }}">
                                        <span><img src="{{ public_asset('assets/images/rec.png') }}"
                                                class="actt"><img
                                                src="{{ public_asset('assets/images/rech.png') }}"
                                                class="accth"></span>
                                            Program
                                    </a>
                                </li>
                                <li>
                                    <a class="disable_class" href="{{ route('tutor.right_to_work') }}">
                                        <span><img src="{{ public_asset('assets/images/rec.png') }}" class="actt"><img
                                                src="{{ public_asset('assets/images/rech.png') }}" class="accth"></span>
                                        Compliance
                                    </a>
                                </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="turo-edit">
                        <div class="user-right-top">

                            <p>This section allows you to access academic program details</p>

                            {{-- FILTERS --}}
                            <div class="row mt-3 mb-3 align-items-center">
                                <div class="col-md-4">
                                    <label for="year" class="form-label">Year</label>
                                    <select id="grade_id" class="form-control">
                                        <option value="">Select Grade</option>
                                        @foreach($grades as $grade)
                                        <option value="{{ $grade->id }}">
                                        {{ $grade->grade_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="subject" class="form-label">Subject</label>
                                    <select  id="filter_branch_id"  class="form-control">
                                        <option value="">Select Subject</option>
                                        @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">
                                        {{ $branch->branch_name }}
                                        </option>
                                         @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 d-flex gap-2 align-items-center">
                                    <button id="searchBtn" class="add_btn">Search</button>
                                    <button id="resetBtn" class="add_btn" style="background:#6c757d;">Reset</button>
                                </div>
                            </div>


                            {{-- TABLE --}}
                            <div class="custom-table mt-6">
                                <table id="programTable" class="cell-border table">
                                    <thead>
                                        <tr>
                                            <th>Learning Program</th>
                                            <th>Subject</th>
                                            <th>Year</th>
                                            <th>State</th>
                                            <th>Curriculum</th>
                                             <th>Session Plan</th>
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
            url: "{{ route('tutor.academic.program.list.ajax') }}",
            data: function (d) {
                d.grade_id  = $('#grade_id').val();
                d.branch_id = $('#filter_branch_id').val();
            }
        },
        columns: [
            { data: 'name' },
            { data: 'subject' },
            { data: 'year' },
            { data: 'state' },
            { data: 'curriculum' },
            {
              data: 'document',
              orderable: false,
              searchable: false
            }  
        ],
        pageLength: 10,
        language: {
            emptyTable: "No academic programs found",
            info: "",
            infoEmpty: "",
            infoFiltered: ""
        }
    });

    $('#searchBtn').on('click', function () {
        table.ajax.reload();
    });
    $('#resetBtn').on('click', function () {
    $('#grade_id').val('');
    $('#filter_branch_id').val('');
    table.ajax.reload();
});
});
</script>
@endsection

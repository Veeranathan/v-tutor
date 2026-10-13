@extends('layouts.app')
@section('title')
    <title>V-Tutor | Tutor | Academic </title>
@endsection
@section('left_part')
    @include('include.header_menu_part')
    {{-- for datatable --}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <style>
        .table-head {
            display: flex;
            align-items: center;
            gap: 4px;
        }
    </style>
@endsection

@section('content')
    <!-- bannersec -->
    <div class="top_mar"></div>
    <!--- profile --->
    <section class="user-account">
        <div class="container">
            <div class="row">
                <div class="zin">
                    @include('include.teacher_left_common'){{-- left common part --}}
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
                                <li class="active">
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
                                <li>
                                    <a class="disable_class" href="{{ route('tutorship.academic.program') }}">
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
                                {{-- <li> --}}

                                {{-- <a @if (@Auth::user()->platform_type != null) href="{{ route('teacher.close.account') }}" onclick="return confirm('We find that you have decided to close the account and we are sorry to see you go! We may need your account password to validate closure! If you have any issues / concerns that you would like to share, kindly use the Complaints link . Please be aware that this process is irreversible. Any data on this account will be retained as per our privacy policy and purged after a certain time')" @else href="#" data-toggle="modal" data-target="#myModalnes" @endif --}}
                                {{-- class="">Close my account</a> --}}
                                {{-- <a href="#" data-toggle="modal" data-target="#myModalnes"> --}}
                                {{-- Close my account</a> --}}
                                {{-- <a class="" href="{{route('teacher.close.account')}}"> --}}
                                {{-- <span><i class="fa fa-user acttrr" aria-hidden="true"></i></span>
                                  Close Account
                                </a> --}}
                                {{-- <a class="" href="{{route('teacher.close.account')}}">
                                        <span><i class="fa fa-user acttrr" aria-hidden="true"></i></span>
                                      Close Account
                                    </a> --}}
                                {{-- </li> --}}
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="turo-edit">
                            <div class="user-right-top">

                                {{-- <h2 class="profile-heading"><span class="per-info"><img
                                            src="{{ public_asset('assets/images/acade.png') }}"></span>Academics</h2> --}}
                                <p>This section allows you to view and modify your academic information.</p>

                                @include('include.errors')
                                <form method="post" action="{{ route('academic.ins') }}" id="frm">
                                    @csrf
                                    <div class="user-account-info newst-acctinfo">

                                        <div class="row new_rows no-gutters">

                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Qualification*</label>
                                                    <select name="qualification" class="reset_input_val">
                                                        @php

                                                            // $QualificationAr = array("8"=>"Advanced Diploma","7"=>"Associate Degree","3"=>"Doctoral Degree","4"=>"Master's Degree","5"=>"Bachelor Honours Degree","6"=>"Bachelor’s Degree","9"=>"Diploma","1"=>"Doctoral Degree","10"=>"Certificate");
                                                            $QualificationAr = [
                                                                '1' => 'Certificate I',
                                                                '2' => 'Certificate II',
                                                                '3' => 'Certificate III',
                                                                '4' => 'Certificate IV',
                                                                '5' => 'Diploma',
                                                                '6' => 'Advanced Diploma',
                                                                '7' => 'Vocational Graduate Certificate',
                                                                '8' => 'Vocational Graduate Diploma',
                                                                '9' => 'Associate Degree',
                                                                '10' => 'Bachelor’s Degree',
                                                                '11' => 'Bachelor Honours Degree',
                                                                '12' => 'Graduate Certificate',
                                                                '13' => 'Graduate Diploma',
                                                                '14' => 'Master’s Degree',
                                                                '15' => 'Doctoral Degree / PhD',
                                                            ];

                                                            asort($QualificationAr);
                                                        @endphp
                                                        <option value="">Select Qualification </option>
                                                        @if (@$QualificationAr)
                                                            @foreach (@$QualificationAr as $key => $q)
                                                                <option value="{{ $key }}">{{ $q }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                        {{-- <option value="8">Advanced Diploma </option>
                                                        <option value="7">Associate Degree</option>
                                                        <option value="1">Doctoral Degree</option>1
                                                        <option value="3">Master's Degree (Research) </option>3
                                                        <option value="4">Master's Degree </option>4
                                                        <option value="2">Postgraduate</option>2
                                                        <option value="5">Bachelor Honours Degree </option>5
                                                        <option value="6"> Bachelor’s Degree</option>6
                                                        <option value="9">Diploma </option>7 --}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Field of Study*</label>
                                                    <select name="field_of_study" class="reset_input_val">
                                                        <option value="">Select Field</option>
                                                        @foreach ($study_field as $val)
                                                            <option value="{{ $val->id }}">{{ $val->field_of_study }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Name of the Institution*</label>
                                                    <select name="university" id="university" class="reset_input_val">
                                                        <option value="">Select University</option>
                                                        <option value="O">Others</option>
                                                        @foreach ($university as $val)
                                                            <option value="{{ $val->id }}">
                                                                {{ $val->university_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 university_name" style="display:none;">
                                                <div class="form_box_area">
                                                    <label for="university_name">University Name *</label>
                                                    <input type="text" name="university_name" id="university_name"
                                                        class="reset_input_val">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Located in*</span></label>
                                                    <input type="text" onfocus="this.removeAttribute('readonly');"
                                                        readonly="" onclick="this.removeAttribute('readonly');"
                                                        onblur="this.removeAttribute('readonly');" placeholder=""
                                                        value="" name="select_loc_in" required=""
                                                        id="select_loc_in" class="remove_error" autocomplete="off">

                                                    <input type="hidden" id="located_in" value="" name="located_in">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Qualification Status*</label>
                                                    <select name="qualification_status" class="reset_input_val">
                                                        <option value="">Select Status </option>
                                                        <option value="C">Completed </option>
                                                        <option value="IP">Enrolled / In-Progress</option>
                                                        <option value="W">Withdrawn</option>
                                                        <option value="NC">Not Completed</option>
                                                        <option value="D">Deferred </option>
                                                        <option value="SA">Statement of Attainment </option>

                                                        {{-- <option value="C">Completed </option>
                                                            <option value="G">Graduated</option>
                                                            <option value="IP">In Progress</option>
                                                            <option value="D">Discontinued </option>
                                                            <option value="GP">Gap Year </option> --}}
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Effective as on*</label>
                                                    <div class="ui input left icon">
                                                        <input type="text" id="effective_date" name="effective_date"
                                                            placeholder="Select Date"
                                                            value="{{ @$edit_aced->effective_date }}"
                                                            class="reset_input_val" autocomplete="off" required>

                                                    </div>
                                                    <label id="effective_date-error" class="error"
                                                        for="effective_date"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row new_rows no-gutters d-flex justify-content-center">
                                            <div class="col-md-2 col-sm-4">
                                                <div class="form_box_area">
                                                    <label></label>

                                                    <button type="submit" class="add_btn">Add</button>


                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form_box_area">
                                                    <label></label>

                                                    <a href="javascript:void(0)" id="reset_btn" class="add_btn">Reset
                                                    </a>

                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="custom-table mt-3">

                                                    <table id="example" class="cell-border table table-responsive">
                                                        <thead>
                                                            <tr>

                                                                <th>
                                                                    <div class="table-head">Qualification <img
                                                                            src="{{ public_asset('assets/images/sort.png') }}">
                                                                </th>
                                                                <th>
                                                                    <div class="table-head">Field of Study <img
                                                                            src="{{ public_asset('assets/images/sort.png') }}">
                                                                    </div>
                                                                </th>
                                                                <th>
                                                                    <div class="table-head">University Name <img
                                                                            src="{{ public_asset('assets/images/sort.png') }}">
                                                                    </div>
                                                                </th>
                                                                <th>
                                                                    <div class="table-head">Location <img
                                                                            src="{{ public_asset('assets/images/sort.png') }}">
                                                                    </div>
                                                                </th>
                                                                <th>
                                                                    <div class="table-head">Status <img
                                                                            src="{{ public_asset('assets/images/sort.png') }}">
                                                                    </div>
                                                                </th>
                                                                <th>
                                                                    <div class="table-head">As on <img
                                                                            src="{{ public_asset('assets/images/sort.png') }}">
                                                                    </div>
                                                                </th>
                                                                <th> </th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($tutor_acd as $key => $val)
                                                                <tr>

                                                                    <td data-label="Name">
                                                                        {{-- @if (@$val->qualification == '1')
                                                                            Doctoral Degree
                                                                        @elseif(@$val->qualification == '2')
                                                                            Postgraduate
                                                                        @elseif(@$val->qualification == '3')
                                                                            Master's Degree (Research)
                                                                        @elseif(@$val->qualification == '4')
                                                                            Master's Degree
                                                                        @elseif(@$val->qualification == '5')
                                                                            Bachelor Honours Degree
                                                                        @elseif(@$val->qualification == '6')
                                                                            Bachelor’s Degree
                                                                        @elseif(@$val->qualification == '7')
                                                                            Associate Degree
                                                                        @elseif(@$val->qualification == '8')
                                                                            Advanced Diploma
                                                                        @elseif(@$val->qualification == '9')
                                                                            Diploma
                                                                        @elseif(@$val->qualification == '10')
                                                                            Certificate
                                                                        @endif --}}

                                                                        {{ isset($QualificationAr[@$val->qualification]) && $QualificationAr[@$val->qualification] ? $QualificationAr[@$val->qualification] : '-' }}
                                                                    </td>
                                                                    <td data-label="Name">
                                                                        {{ @$val->getFieldStudy->field_of_study }}</td>
                                                                    <td data-label="Name">
                                                                        {{ @$val->getUniversity->university_name }}</td>
                                                                    <td data-label="Name">
                                                                        {{ @$val->located_in ?? '-' }}</td>
                                                                    <td data-label="Name">
                                                                        @if (@$val->qualification_status == 'C')
                                                                            Completed
                                                                        @elseif(@$val->qualification_status == 'IP')
                                                                            Enrolled / In-Progress
                                                                        @elseif(@$val->qualification_status == 'W')
                                                                            Withdrawn
                                                                        @elseif(@$val->qualification_status == 'NC')
                                                                            Not Completed
                                                                        @elseif(@$val->qualification_status == 'D')
                                                                            Deferred
                                                                        @elseif(@$val->qualification_status == 'SA')
                                                                            Statement of Attainment
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td data-label="Name">
                                                                        {{ date('d/m/Y', strtotime(@$val->effective_date)) }}
                                                                    </td>
                                                                    <td>
                                                                        <div class="add_ttrr actions-main">
                                                                            <a href="javascript:void(0);"
                                                                                class="action-dots"
                                                                                id="action{{ $val->id }}"><img
                                                                                    src="{{ public_asset('assets/images/action-dots.png') }}"
                                                                                    alt=""
                                                                                    onclick="fun({{ $val->id }})"></a>
                                                                            <div class="show-actions"
                                                                                id="show-action{{ $val->id }}"
                                                                                style="display: none;"> <span
                                                                                    class="angle"><img
                                                                                        src="{{ public_asset('assets/images/angle.png') }}"
                                                                                        alt=""></span>
                                                                                <ul>
                                                                                    <li><a
                                                                                            href="{{ route('aced.edit.page', $val->id) }}">Edit</a>
                                                                                    </li>
                                                                                    <li><a onclick="return confirm('Are you sure want to delete this?')"
                                                                                            href="{{ route('aced.dlt', $val->id) }}">Delete</a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                    <nav aria-label="...">

                                                    </nav>
                                                </div>
                                            </div>


                                        </div>
                                    </div>



                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal res-modal newqusmo" id="myModalnes">
        <div class="modal-dialog modal-dialog-centered divPoMW tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Warning</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class="proDiv " id="warningTextDi">
                            {{-- <h6>We are sorry to se</h6> --}}
                            <span class="proclosespan">We are sorry to see you go</span>😔
                            <h6></h6>
                            <p>We notice that you have decided to close your account. If there are any issues / concerns
                                that you would like to share or discuss, kindly message us. Our backend team will review and
                                respond over email or give you a call, if needed.</p>
                            <p>We require your account password to validate closure! Please be aware that this process is
                                not reversible. Any data on this user account will be retained as per our policies and
                                purged after a certain date. For more details, review our Privacy Policy.</p>
                            <p class="tutoracademiccor academic_team_bold">Academics Team</p>
                            {{-- <p>We are sorry to see you go (sad)
                    </p> --}}
                            <div class="next-btn1 newst_btn-pop">

                                <button type="button" class="btn btn-new btn-danger float-left change-new-link"
                                    id="nextValueShow">Yes, please close</button>
                                <button type="button" class="btn btn-new btn-danger " data-dismiss="modal">No, don’t
                                    close </button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="appome_input form_box_area cls2 " id="passwordForm" style="display:none;">
                            @if (@Auth::user()->user_type == 'T')
                                <form action="{{ route('teacher.close.account') }}" id="checkPassword" method="post">
                                    @csrf
                                @else
                                    <form action="{{ route('teacher.close.account') }}" id="checkPassword"
                                        method="post">
                                        @csrf
                            @endif
                            <span class="form_box_area mt-2" id="abcd">
                                <label>Password </label>
                                <span class="autocomplete">
                                    <input id="mypassword" type="password" name="mypassword" placeholder="Password"
                                        autocomplete="off" required="" class="required">
                                </span>
                            </span>
                            <div class="next-btn1 newst_btn-pop">
                                <button type="submit" class="btn btn-new btn-danger change-new-link">Submit</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @include('include.footer')
@endsection
@section('script')
    @include('include.script')
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>
    {{-- for datatable --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    {{-- for validation --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>
    <script>
        $("#select_loc_in").countrySelect({
            defaultCountry: "au",
            responsiveDropdown: true
        });

        $('#located_in').val($("#select_loc_in").countrySelect("getSelectedCountryData").name);

        $(document).on('change', '#select_loc_in', function() {
            var country = $(this).countrySelect("getSelectedCountryData");
            // console.log(country.name);
            $('#located_in').val(country.name);
        });
    </script>

    <script>
        oTable = $('#example').DataTable({
            "order": [
                [0, "desc"]
            ],
            "pageLength": 5,
            "language": {
                "emptyTable": "No data available",
                "info": "",
                "infoEmpty": "",
                "infoFiltered": "" 
            },
            dom: '<"top"f>t<"bottom row"<"col-12 d-flex justify-content-end"p>>',
            columnDefs: [{
                targets: 0,
                type: 'natural'
            }]
        });

        if (oTable.rows().data().length === 0) {
            $(oTable.table().container())
                .find('.dataTables_paginate')
                .hide();
        }
    </script>
    <script>
        $(document).ready(function() {
            flatpickr("#effective_date", {
                dateFormat: "d-m-Y",
                maxDate: "today"
            });
            $('#frm').validate({
                rules: {
                    qualification: {
                        required: true,
                    },
                    field_of_study: {
                        required: true,
                    },
                    university: {
                        required: true,
                    },
                    qualification_status: {
                        required: true,
                    },
                    effective_date: {
                        required: true,
                    }
                },
                // messages:{
                //      qualification:{
                //         required:" Category name is mandatory",
                //     }
                // }
            });
            $(document).on("click", "#reset_btn", function() {
                $(".reset_input_val").val("");
            });
            $(document).on("change", "#university", function() {
                // alert($.trim($(this).val()));
                if ($.trim($(this).val()) == 'O') {
                    $(".university_name").show();
                    $("#university_name").addClass('required');
                } else {
                    $(".university_name").hide();
                    $("#university_name").removeClass('required');
                }
            });
        });
    </script>
    <script>
        function fun(id) {
            $('.show-actions').slideUp();
            $("#show-action" + id).show();
        }

        function Cancel(id) {
            $("#show-action" + id).hide();
        }
        $(document).mouseup(function(e) {
            var container = $(".show-actions");
            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.hide();
            }
        });
        $("#checkPassword").validate();
        $("#checkPro").click(function() {
            if (confirm(
                    'We find that you have decided to close the account and we are sorry to see you go! We may need your account password to validate closure! If you have any issues / concerns that you would like to share, kindly use the Complaints link . Please be aware that this process is irreversible. Any data on this account will be retained as per our privacy policy and purged after a certain time'
                )) {
                $("#checkPassword").submit();
            }
        });
    </script>
@endsection

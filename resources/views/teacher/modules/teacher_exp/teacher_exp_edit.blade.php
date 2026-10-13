@extends('layouts.app')
@section('title')
    <title>V-Tutor  | Tutor | Experience | Edit</title>
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
                                        Personal Details
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
                                <li class="active">
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
                                    <a class="disable_class" href="{{ route('tutor.right_to_work') }}">
                                        <span><img src="{{ public_asset('assets/images/rec.png') }}" class="actt"><img
                                                src="{{ public_asset('assets/images/rech.png') }}" class="accth"></span>
                                        Right to Work
                                    </a>
                                </li>
                                {{-- <li>
                                    <a @if (@Auth::user()->platform_type != null) href="{{ route('teacher.close.account') }}" onclick="return confirm('We find that you have decided to close the account and we are sorry to see you go! We may need your account password to validate closure! If you have any issues / concerns that you would like to share, kindly use the Complaints link . Please be aware that this process is irreversible. Any data on this account will be retained as per our privacy policy and purged after a certain time')" @else href="#" data-toggle="modal" data-target="#myModalnes" @endif
                                        class="">Close my account</a>

                                    <a href="#" data-toggle="modal" data-target="#myModalnes"   >
                                    Close my account</a>
                                    <a class="" href="{{route('teacher.close.account')}}">
                                    <span><i class="fa fa-user acttrr" aria-hidden="true"></i></span>
                                    Close Account
                                    </a>
                                    <a class="" href="{{route('teacher.close.account')}}">
                                        <span><i class="fa fa-user acttrr" aria-hidden="true"></i></span>
                                    Close Account
                                    </a>
                                </li> --}}
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="turo-edit">
                            <div class="user-right-top">

                                {{-- <h2 class="profile-heading"><span class="per-info"><img
                                            src="{{ public_asset('assets/images/exp.png') }}"></span>My Experience</h2> --}}
                                <p>This section allows you to view or update your teaching experience details</p>

                                @include('include.errors')
                                <form action="{{ route('tutor.exp.update') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="exp_id" value="{{ @$edit_exp->id }}">
                                    <div class="user-account-info">

                                        <div class="row new_rows no-gutters">
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Organisation / Institution *</label>
                                                    <input type="text" placeholder="ABC School " name="organization"
                                                        value="{{ @$edit_exp->organization }}" class="reset_input_val">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Is this an educational  institution? *</label>
                                                    <span class="is_edu_inst is_edu_inst_yes">
                                                        <input type="radio"
                                                            {{ @$edit_exp->is_educational_institution == 1 ? 'checked' : '' }}
                                                            value="1" name="is_educational_institution" class="is_educational_institution">
                                                        <span>Yes</span>
                                                    </span>

                                                    <span class="is_edu_inst is_edu_inst_no">
                                                        <input type="radio"
                                                            {{ @$edit_exp->is_educational_institution == 2 ? 'checked' : '' }}
                                                            value="2" name="is_educational_institution" class="is_educational_institution">
                                                        <span>No</span>
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-4 col-sm-6 is_edu_inst_act_div">
                                                <div class="form_box_area">
                                                    <label> Institution Name *</label>
                                                    <input type="text" placeholder="Institution Name" name="institution_name" value="{{ @$edit_exp->institution_name }}" class="reset_input_val">
                                                </div>
                                            </div> --}}

                                            @php
                                                $ins_types = array(
                                                    '1' => 'Childcare / Daycare centre',
                                                    '2' => 'Preschool / Kindergarten',
                                                    '3' => 'Early learning centre',
                                                    '4' => 'Public School',
                                                    '5' => 'Private School',
                                                    '6' => 'Catholic and Religious School',
                                                    '7' => 'Specialist School',
                                                    '8' => 'Boarding School',
                                                    '9' => 'Montessori / Steiner School',
                                                    '10' => 'TAFE Institute',
                                                    '11' => 'RTO (Registered Training Organisation)',
                                                    '12' => 'University',
                                                    '13' => 'Private  college',
                                                );
                                            @endphp

                                            <div class="col-md-4 col-sm-6 is_edu_inst_act_div">
                                                <div class="form_box_area">
                                                    <label> Institution Type *</label>
                                                    <select class="reset_input_val required" name="institution_type">
                                                        <option value="">Select</option>
                                                        @foreach ($ins_types as $tkey => $tval)
                                                            <option {{ @$edit_exp->institution_type == $tkey ? 'selected' : '' }} value="{{ $tkey }}">{{ $tval }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label> Job Title*</label>
                                                    <input type="text" placeholder="Music Teacher " name="job_title"
                                                        value="{{ @$edit_exp->job_title }}" class="reset_input_val">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>From*</label>
                                                    <select name="from_year" onchange="abc()" id="from"
                                                        class="reset_input_val">

                                                        @for ($i = (int) date('Y'); $i >= 1950; $i--)
                                                            <option value="{{ $i }}"
                                                                @if (@$edit_exp->from_year == $i) selected @endif>
                                                                {{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>To*</label>
                                                    <select name="to_year" onchange="abc()" id="to"
                                                        class="reset_input_val">

                                                        @for ($i = (int) date('Y'); $i >= 1950; $i--)
                                                            <option value="{{ $i }}"
                                                                @if (@$edit_exp->to_year == $i) selected @endif>
                                                                {{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <span id="err" style="color: red"></span>
                                            </div>
                                        </div>

                                        <div class="row new_rows no-gutters d-flex justify-content-center">
                                            {{-- <div class="col-md-3 col-sm-6" id="old_branch">
                                                <div class="form_box_area">
                                                    <label>Branch*</label>
                                                    <select name="branch" id="branch" class="required"
                                                        onchange="getSub()">
                                                        <option value="">Select Branch</option>
                                                        @if (@$branches)
                                                            @foreach (@$branches as $key => $val)
                                                                <option value="{{ @$val->id }}"
                                                                    @if (@$sinfo->branch_id == $val->id) selected="" @endif>
                                                                    {{ @$val->branch_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6" id="new_branch" style="display: none">
                                            </div>
                                            <div class="col-md-3 col-sm-6" id="new" style="display: none">
                                            </div>
                                            <div class="col-md-4 col-sm-6" id="old">
                                                <div class="form_box_area">
                                                    <label>Subject taught*</label>
                                                    <select class="reset_input_val   required" name="subject">
                                                        <option value="">Select</option>
                                                        @foreach ($subject as $key => $val)
                                                            <option value="{{ @$val->id }}"
                                                                @foreach (@$already_sub as $tt) @if ($tt->subject_id == $val->id)selected  @endif @endforeach>
                                                                {{ @$val->subject }}</option>
                                                        @endforeach
                                                    </select>
                                                    <label id="subject[]-error" class="error" for="subject[]"
                                                        style="display: block;"></label>
                                                </div>

                                            </div>
                                            <div class="clearfix"></div> --}}




                                            {{-- <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Years of Exp.*</label>
                                                    <input type="number" placeholder="" min="0" id="yoe"
                                                        @if (@$edit_exp->year_of_exp) value="{{ @$edit_exp->year_of_exp }}" @else value="0" @endif
                                                        readonly="" class="reset_input_val">
                                                    <input type="hidden" name="year_of_exp" min="0"
                                                        id="yoe2"
                                                        @if (@$edit_exp->year_of_exp) value="{{ @$edit_exp->year_of_exp }}" @else value="0" @endif>
                                                </div>
                                            </div> --}}

                                            {{--   @php
                                                $month=array('January','February','March','April','May','June','July','August','September','October','November','December');
                                            @endphp --}}

                                            {{-- <div class="col-md-12 col-sm-12">
                                                <div class="form_box_area">
                                                    <label>Description </label>
                                                    <textarea id="description" placeholder="Describe your awards and recognitions in about 100 words" name="description"
                                                        class="textarea_box" maxlength="1000" class="reset_input_val">{{ @$edit_exp->description }}</textarea>
                                                    <div class="error_description error error_textarea"></div>
                                                </div>
                                            </div> --}}


                                            <div class="col-md-2 col-sm-4">
                                                <div class="form_box_area">
                                                    <button type="submit" class="add_btn">Save</button>

                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-4">
                                                <div class="form_box_area">

                                                    <a href="javascript:void(0)" id="reset_btn" class="add_btn">Reset
                                                    </a>

                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="custom-table mt-3">
                                                    {{-- -999 --}}
                                                    {{-- 99 --}}
                                                    <table id="example" class="cell-border table table-responsive">
                                                        <thead>
                                                            <tr>

                                                                <th><div class="table-head">Organisation / Institution <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}"></div>
                                                                </th>
                                                                {{-- <th>Institution Name <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}">
                                                                </th> --}}
                                                                <th><div class="table-head">Institution Type <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}"></div>
                                                                </th>
                                                                <th><div class="table-head">Job Title <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}"></div>
                                                                </th>
                                                                {{-- <th>Years of Exp. <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}">
                                                                </th>
                                                                <th>Subject taught <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}">
                                                                </th>
                                                                <th>Description <img
                                                                        src="{{ public_asset('assets/images/sort.png') }}">
                                                                </th> --}}

                                                                <th> </th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($tutor_exp as $key => $val)
                                                                <tr>

                                                                    <td data-label="Name">
                                                                        {{ @$val->organization }}
                                                                    </td>
                                                                    {{-- <td data-label="Name">
                                                                        @if (@$val->is_educational_institution == 1)
                                                                            {{ @$val->institution_name ?? '-' }}
                                                                        @else
                                                                            {{ '-' }}
                                                                        @endif
                                                                    </td> --}}
                                                                    <td data-label="Name">
                                                                        @if (@$val->is_educational_institution == 1)
                                                                            {{ @$val->institution_type ? $ins_types[$val->institution_type] : '-' }}
                                                                        @else
                                                                            {{ '-' }}
                                                                        @endif
                                                                    </td>
                                                                    <td data-label="Name">{{ @$val->job_title }}</td>
                                                                    {{-- <td data-label="Name">{{ @$val->year_of_exp }}</td>

                                                                    <td data-label="Name">
                                                                        @foreach ($val->getExpToSub as $sub)
                                                                            {{ @$sub->subjectName->subject }}
                                                                        @endforeach
                                                                    </td> --}}

                                                                    {{-- <td data-label="Name">
                                                                        @if (@$val->description)
                                                                            <p class="add_ttrr desi">
                                                                                {{ substr(@$val->description, 0, 120) }}</p>
                                                                            <a class="allread"
                                                                                onclick="readmore({{ $val->id }})"
                                                                                id="rr{{ $val->id }}">Read More +</a>
                                                                            <p class="moretext2 desi"
                                                                                style="display: none;"
                                                                                id="desc{{ $val->id }}">
                                                                                {{ substr(@$val->description, 120) }}
                                                                                <a class="allread"
                                                                                    style="display: none;"
                                                                                    onclick="readless({{ $val->id }})"
                                                                                    id="rrr{{ $val->id }}">Read less
                                                                                    -</a>
                                                                            </p>
                                                                        @endif
                                                                    </td> --}}

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
                                                                                            href="{{ route('tutor.exp.edit.page', $val->id) }}">Edit
                                                                                        </a></li>
                                                                                    <li><a onclick="return confirm('Are you sure want to delete this?')"
                                                                                            href="{{ route('tutor.exp.dlt', $val->id) }}">Delete</a>
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
    <script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            // is_educational_institution show & hide
                if ($('.is_educational_institution:checked').val() == 1) {
                    $('.is_edu_inst_act_div').show();
                } else {
                    $('.is_edu_inst_act_div').hide();
                }

                $(document).on('change', '.is_educational_institution', function() {
                    if ($(this).is(':checked')) {
                        if ($(this).val() == 1) {
                            $('.is_edu_inst_act_div').show();
                        } else {
                            $('.is_edu_inst_act_div').hide();
                        }
                    } else {
                        $('.is_edu_inst_act_div').hide();
                    }
                });
            // is_educational_institution show & hide
        });
    </script>
    <script>
        (function() {

            /*
             * Natural Sort algorithm for Javascript - Version 0.7 - Released under MIT license
             * Author: Jim Palmer (based on chunking idea from Dave Koelle)
             * Contributors: Mike Grier (mgrier.com), Clint Priest, Kyle Adams, guillermo
             * See: http://js-naturalsort.googlecode.com/svn/trunk/naturalSort.js
             */
            function naturalSort(a, b, html) {
                var re = /(^-?[0-9]+(\.?[0-9]*)[df]?e?[0-9]?%?$|^0x[0-9a-f]+$|[0-9]+)/gi,
                    sre = /(^[ ]*|[ ]*$)/g,
                    dre =
                    /(^([\w ]+,?[\w ]+)?[\w ]+,?[\w ]+\d+:\d+(:\d+)?[\w ]?|^\d{1,4}[\/\-]\d{1,4}[\/\-]\d{1,4}|^\w+, \w+ \d+, \d{4})/,
                    hre = /^0x[0-9a-f]+$/i,
                    ore = /^0/,
                    htmre = /(<([^>]+)>)/ig,
                    // convert all to strings and trim()
                    x = a.toString().replace(sre, '') || '',
                    y = b.toString().replace(sre, '') || '';
                // remove html from strings if desired
                if (!html) {
                    x = x.replace(htmre, '');
                    y = y.replace(htmre, '');
                }
                // chunk/tokenize
                var xN = x.replace(re, '\0$1\0').replace(/\0$/, '').replace(/^\0/, '').split('\0'),
                    yN = y.replace(re, '\0$1\0').replace(/\0$/, '').replace(/^\0/, '').split('\0'),
                    // numeric, hex or date detection
                    xD = parseInt(x.match(hre), 10) || (xN.length !== 1 && x.match(dre) && Date.parse(x)),
                    yD = parseInt(y.match(hre), 10) || xD && y.match(dre) && Date.parse(y) || null;

                // first try and sort Hex codes or Dates
                if (yD) {
                    if (xD < yD) {
                        return -1;
                    } else if (xD > yD) {
                        return 1;
                    }
                }

                // natural sorting through split numeric strings and default strings
                for (var cLoc = 0, numS = Math.max(xN.length, yN.length); cLoc < numS; cLoc++) {
                    // find floats not starting with '0', string or 0 if not defined (Clint Priest)
                    var oFxNcL = !(xN[cLoc] || '').match(ore) && parseFloat(xN[cLoc], 10) || xN[cLoc] || 0;
                    var oFyNcL = !(yN[cLoc] || '').match(ore) && parseFloat(yN[cLoc], 10) || yN[cLoc] || 0;
                    // handle numeric vs string comparison - number < string - (Kyle Adams)
                    if (isNaN(oFxNcL) !== isNaN(oFyNcL)) {
                        return (isNaN(oFxNcL)) ? 1 : -1;
                    }
                    // rely on string comparison if different types - i.e. '02' < 2 != '02' < '2'
                    else if (typeof oFxNcL !== typeof oFyNcL) {
                        oFxNcL += '';
                        oFyNcL += '';
                    }
                    if (oFxNcL < oFyNcL) {
                        return -1;
                    }
                    if (oFxNcL > oFyNcL) {
                        return 1;
                    }
                }
                return 0;
            }

            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "natural-asc": function(a, b) {
                    return naturalSort(a, b, true);
                },

                "natural-desc": function(a, b) {
                    return naturalSort(a, b, true) * -1;
                },

                "natural-nohtml-asc": function(a, b) {
                    return naturalSort(a, b, false);
                },

                "natural-nohtml-desc": function(a, b) {
                    return naturalSort(a, b, false) * -1;
                },

                "natural-ci-asc": function(a, b) {
                    a = a.toString().toLowerCase();
                    b = b.toString().toLowerCase();

                    return naturalSort(a, b, true);
                },

                "natural-ci-desc": function(a, b) {
                    a = a.toString().toLowerCase();
                    b = b.toString().toLowerCase();

                    return naturalSort(a, b, true) * -1;
                }
            });

        }());
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
                targets: '_all',
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
            $(document).on("click", "#reset_btn", function() {
                $(".reset_input_val").val("");
            });
            $('#frm').validate({
                ignore: [],
                rules: {
                    'subject': {
                        required: true,
                    },
                    'branch': {
                        required: true,
                    },
                    organization: {
                        required: true,
                    },
                    job_title: {
                        required: true,
                    },
                    // year_of_exp:{
                    // required:true,
                    // },
                    from_year: {
                        required: true,

                    },
                    to_year: {
                        required: true,

                    },
                    description: {
                        // required:true,
                        minlength: 10,
                    },

                },
                // messages:{
                //      qualification:{
                //         required:" Category name is mandatory",
                //     }
                // }
                submitHandler: function(form) {
                    var from_year = parseInt($("#from").val());
                    var to_year = parseInt($("#to").val());
                    if (from_year > to_year) {
                        //alert("From year should be less than to year..!");
                        $("#err").html("From year should be less than to year..!");
                        return false;
                    } else {
                        check();
                        form.submit();

                    }
                }
            });
            // jayatri 18-11-2021 for flagged words

            function check() {

                var badWords = [];
                @php
                    $badwords = \DB::table('bad_words')->pluck('words')->toArray();
                @endphp
                @foreach (@$badwords as $value)
                    badWords.push('{{ $value }}');
                @endforeach
                badWords.push('email');
                badWords.push('phone');
                badWords.push('reach');
                badWords.push('call');
                badWords.push('gmail');
                badWords.push('.net');
                badWords.push('.com');
                var wordInput = textarea.val();
                wordInput = wordInput.toLowerCase();
                var arr = wordInput.split(" ");
                var foundBadWords = arr.filter(el => badWords.includes(el));

                if (foundBadWords.length > 0) {
                    $(".error_textarea").html(
                        'Kindly refrain from using email, phone or flagged words on the description!');
                    textarea.val("");
                    return false;
                }
                var wordInput = textarea.val();
                wordInput = wordInput.toLowerCase();
                var arr = wordInput.split(" ");
                $.each(arr, function(_, t) {
                    if (/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(t.toLowerCase())) {
                        $(".error_textarea").html(
                            'Kindly refrain from using email, phone or flagged words on the description!'
                            );
                        textarea.val("");
                    }

                    if (/^[+]?\d+$/.test(t.toLowerCase()) && t.length == 10) {
                        $(".error_textarea").html(
                            'Kindly refrain from using email, phone or flagged words on the description!'
                            );
                        textarea.val("");
                    }

                    // if(t.match("\d{10}")){
                    //     $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                    //     textarea.val("");
                    // }
                });


            }
            var textarea = $('.textarea_box');
            textarea.on({
                keyup: function(e) {
                    if (e.which == 188) check();
                    if (e.which == 32) check();
                    // if (e.which == 13) check();
                    // check();
                    var words = 0;
                    if ((this.value.match(/\S+/g)) != null) {
                        words = this.value.match(/\S+/g).length;
                    }
                    if (words > 100) {
                        var trimmed = $(this).val().split(/\s+/, 100).join(" ");
                        $(this).val(trimmed + " ");
                    }
                },
                blur: check
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
    </script>
    <script>
        function readmore(id) {
            //alert('j');
            $("#desc" + id).slideToggle("slow");
            $("#rr" + id).hide();
            $("#rrr" + id).show();
            $(".textLimit" + id).hide();

        }

        function readless(id) {
            //alert('j');
            $("#desc" + id).slideToggle("slow");
            $("#rr" + id).show();
            $("#rrr" + id).hide();
            $(".textLimit" + id).show();

        }
    </script>
    {{-- jayatri for flageed words on 18-11-2021 --}}
    <script type="text/javascript">
        function check() {
            var badWords = [];
            @php
                $badwords = \DB::table('bad_words')->pluck('words')->toArray();
            @endphp
            @foreach (@$badwords as $value)
                badWords.push('{{ $value }}');
            @endforeach
            badWords.push('email');
            badWords.push('phone');
            badWords.push('reach');
            badWords.push('call');
            badWords.push('gmail');
            badWords.push('.net');
            badWords.push('.com');
            var wordInput = textarea.val();
            wordInput = wordInput.toLowerCase();
            var arr = wordInput.split(" ");
            var foundBadWords = arr.filter(el => badWords.includes(el));

            if (foundBadWords.length > 0) {
                $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                textarea.val("");
                return false;
            }
            var wordInput = textarea.val();
            wordInput = wordInput.toLowerCase();
            var arr = wordInput.split(" ");

            $.each(arr, function(_, t) {
                if (/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(t.toLowerCase())) {
                    $(".error_textarea").html(
                        'Kindly refrain from using email, phone or flagged words on the description!');
                    textarea.val("");
                }

                if (/^[+]?\d+$/.test(t.toLowerCase()) && t.length == 10) {
                    $(".error_textarea").html(
                        'Kindly refrain from using email, phone or flagged words on the description!');
                    textarea.val("");
                }

                // if(t.match("\d{10}")){
                //     $(".error_textarea").html('Kindly refrain from using email, phone or flagged words on the description!');
                //     textarea.val("");
                // }
            });

        }
        var textarea = $('.textarea_box');
        textarea.on({
            keyup: function(e) {
                if (e.which === 188) check();
                if (e.which === 32) check();
                var words = 0;
                if ((this.value.match(/\S+/g)) != null) {
                    words = this.value.match(/\S+/g).length;
                }
                if (words > 100) {
                    var trimmed = $(this).val().split(/\s+/, 100).join(" ");
                    $(this).val(trimmed + " ");
                }
            },
            blur: check
        });
        $("#checkPassword").validate();
        $("#checkPro").click(function() {
            if (confirm(
                    'We find that you have decided to close the account and we are sorry to see you go! We may need your account password to validate closure! If you have any issues / concerns that you would like to share, kindly use the Complaints link . Please be aware that this process is irreversible. Any data on this account will be retained as per our privacy policy and purged after a certain time'
                    )) {
                $("#checkPassword").submit();
            }
        });

        function abc() {
            var from_year = parseInt($("#from").val());
            var to_year = parseInt($("#to").val());
            if (from_year > to_year) {
                $("#err").show();
                $("#err").html("From year should be less than to year..!");

                // $('#lastYear').val('');
                // $('#lastYear').hide();
                // $('#thisYear').show();
                // }else{
                // //console.log("not match");
                // $('#thisYear').val('');
                // $('#thisYear').hide();
                // $('#lastYear').show();
            }
            if (from_year <= to_year) {
                $("#err").hide();
                $("#yoe").val(to_year - from_year);
                $("#yoe2").val(to_year - from_year);
            }
        }
    </script>
    <script>
        function getSub() {
            //console.log("k");
            var grade_id = $("#hhh").val();
            var branch_id = $("#branch").val();
            console.log(grade_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            var fd = new FormData;
            fd.append('grade_id', grade_id);
            fd.append('branch_id', branch_id);

            $.ajax({
                url: '{{ route('get.sub') }}',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,

                success: function(res) {
                    $("#old").remove();
                    $("#new").show();
                    $("#new").html(res);

                }
            });


        }
    </script>
@endsection

@extends('admin.layouts.app')

@section('title')
    View WWCC Management
@endsection

@section('links')
    @include('admin.includes.links')
    <style type="text/css">
    /*this is excel button needs to hide as we have already download option*/
        .buttons-excel{
            display: none;
        }
        .gj_adm_tab_sec h5, .gj_taf_rejappl_div h5 {
            font-size: 16px;
            color: #b80f0a;
        }
        .gj_adm_tab_sec h5, .gj_taf_det_div h5, .gj_taf_rejappl_div h5 {
            font-size: 16px;
        }
        .gj_taf_rejappl_div {
            margin-top: 35px;
        }
        .gj_tab1_com_addr_div, .gj_tab1_perm_addr_div {
            margin: 25px auto 10px;
        }
        .tab2 tr:first-child th, .tab2 td, .tab3 tr:first-child th, .tab3 td, .tab4 tr:first-child th, .tab4 td, .tab5 tr:first-child th, .tab5 td, .tab8 th, .tab8 td {
            border-top: 0 !important;
        }
        .tab4 tr:nth-child(2) td, .tab4 tr:nth-child(3) th {
            border-top: 0 !important;
        }
        .tab7 tr:nth-child(2) th {
            background: #ddd;
        }
        .gj_vid_div {
            width: 75%;
            margin: auto;
        }
        .gj_vid_div video {
            width: 100%;
        }
        .gj_adm_tab_sec a.item {
            background: #d73c5e !important;
            border-radius: 8px 8px 0 0;
            margin-right: 8px;
            padding: 10px 9px !important;
            border: 1px solid #d73c5e !important;
            border-bottom: 0 !important;
            height: 44px;
            color: #fff !important;
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            -ms-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
            font-size: 12px;
            top: 1px;
        }        
        .gj_adm_tab_sec a.item.active, .gj_adm_tab_sec a.item:hover {
            color: #b80f0a !important;
            background: #fff !important;
            border: 1px solid #b80f0a !important;
            border-bottom: 0 !important;
        }
        .gj_disclaimer_note {
            margin-bottom: 15px !important;
        }
        ol.gj_dis_ol {
            list-style: auto;
            padding-left: 30px;
        }
        ol.gj_dis_ol h5 {
            color: #797979;
            font-size: 14px;
            font-weight: 600;
        }
        .tab8 li ul {
            list-style: circle;
            padding-left: 30px;
        }
        .tab8 li {
            margin-bottom: 10px;
        }
        p.gj_trade_note {
            font-size: 12px;
        }
        a.link_color {
            color: #b80f0a;
        }
        .gj_term_accept span, .gj_auth_accept span {
            vertical-align: top;
            margin-left: 5px;
        }
        .gj_checkbox_wrapper_1 {
            box-sizing: border-box;
            --background-color: #fff;
            --checkbox-height: 15px;
        }
        button.btn.wwcc_btn_edit {
            color: #fff;
        }
        button.btn.wwcc_btn_save {
            background-color: #077e07 !important;
            border: 1px solid #077e07 !important;
            color: #fff;
        }

        @-moz-keyframes gj_dothabottomcheck {
            0% {
            height: 0;
            }
            100% {
            height: calc(var(--checkbox-height) / 2);
            }
        }

        @-webkit-keyframes gj_dothabottomcheck {
            0% {
            height: 0;
            }
            100% {
            height: calc(var(--checkbox-height) / 2);
            }
        }

        @keyframes gj_dothabottomcheck {
            0% {
            height: 0;
            }
            100% {
            height: calc(var(--checkbox-height) / 2);
            }
        }

        @keyframes gj_dothatopcheck {
            0% {
            height: 0;
            }
            50% {
            height: 0;
            }
            100% {
            height: calc(var(--checkbox-height) * 1.2);
            }
        }

        @-webkit-keyframes gj_dothatopcheck {
            0% {
            height: 0;
            }
            50% {
            height: 0;
            }
            100% {
            height: calc(var(--checkbox-height) * 1.2);
            }
        }

        @-moz-keyframes gj_dothatopcheck {
            0% {
            height: 0;
            }
            50% {
            height: 0;
            }
            100% {
            height: calc(var(--checkbox-height) * 1.2);
            }
        }

        .gj_checkbox_wrapper_1 input[type=checkbox] {
            display: none;
        }

        .gj_checkbox_wrapper_1 .gj_check_box {
            height: var(--checkbox-height);
            width: var(--checkbox-height);
            background-color: transparent;
            border: calc(var(--checkbox-height) * .1) solid #000;
            border-radius: 5px;
            position: relative;
            top: 3px;
            display: inline-block;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            -moz-transition: border-color ease 0.2s;
            -o-transition: border-color ease 0.2s;
            -webkit-transition: border-color ease 0.2s;
            transition: border-color ease 0.2s;
            cursor: pointer;
        }
        .gj_checkbox_wrapper_1 .gj_check_box::before,
        .gj_checkbox_wrapper_1 .gj_check_box::after {
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            position: absolute;
            height: 0;
            width: calc(var(--checkbox-height) * .2);
            background-color: #34b93d;
            display: inline-block;
            -moz-transform-origin: left top;
            -ms-transform-origin: left top;
            -o-transform-origin: left top;
            -webkit-transform-origin: left top;
            transform-origin: left top;
            border-radius: 5px;
            content: " ";
            -webkit-transition: opacity ease 0.5;
            -moz-transition: opacity ease 0.5;
            transition: opacity ease 0.5;
        }
        .gj_checkbox_wrapper_1 .gj_check_box::before {
            top: calc(var(--checkbox-height) * .72);
            left: calc(var(--checkbox-height) * .41);
            box-shadow: 0 0 0 calc(var(--checkbox-height) * .05) var(--background-color);
            -moz-transform: rotate(-135deg);
            -ms-transform: rotate(-135deg);
            -o-transform: rotate(-135deg);
            -webkit-transform: rotate(-135deg);
            transform: rotate(-135deg);
        }
        .gj_checkbox_wrapper_1 .gj_check_box::after {
            top: calc(var(--checkbox-height) * .37);
            left: calc(var(--checkbox-height) * .05);
            -moz-transform: rotate(-45deg);
            -ms-transform: rotate(-45deg);
            -o-transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }

        .gj_checkbox_wrapper_1 input[type=checkbox]:checked + .gj_check_box,
        .gj_checkbox_wrapper_1 .gj_check_box.checked {
            border-color: #34b93d;
        }
        .gj_checkbox_wrapper_1 input[type=checkbox]:checked + .gj_check_box::after,
        .gj_checkbox_wrapper_1 .gj_check_box.checked::after {
            height: calc(var(--checkbox-height) / 2);
            -moz-animation: gj_dothabottomcheck 0.2s ease 0s forwards;
            -o-animation: gj_dothabottomcheck 0.2s ease 0s forwards;
            -webkit-animation: gj_dothabottomcheck 0.2s ease 0s forwards;
            animation: gj_dothabottomcheck 0.2s ease 0s forwards;
        }
        .gj_checkbox_wrapper_1 input[type=checkbox]:checked + .gj_check_box::before,
        .gj_checkbox_wrapper_1 .gj_check_box.checked::before {
            height: calc(var(--checkbox-height) * 1.2);
            -moz-animation: gj_dothatopcheck 0.4s ease 0s forwards;
            -o-animation: gj_dothatopcheck 0.4s ease 0s forwards;
            -webkit-animation: gj_dothatopcheck 0.4s ease 0s forwards;
            animation: gj_dothatopcheck 0.4s ease 0s forwards;
        }

        .gj_taf_det_div table {
            background: #fff;
            margin-bottom: 35px;
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
        <div class="wraper container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="gj_alert_msg"></div>
                    @include('admin.includes.message')
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    @php
                        $tutor_name = "";
                        if(isset($taf_data->getTutorForm->first_name) && $taf_data->getTutorForm->first_name) {
                            $tutor_name = " - ".$taf_data->getTutorForm->first_name;
                        }
                        if(isset($taf_data->getTutorForm->middle_name) && $taf_data->getTutorForm->middle_name) {
                            $tutor_name.= " ".$taf_data->getTutorForm->middle_name;
                        }
                        if(isset($taf_data->getTutorForm->last_name) && $taf_data->getTutorForm->last_name) {
                            $tutor_name.= " ".$taf_data->getTutorForm->last_name;
                        }
                    @endphp
                    <h1 class="pull-left page-title">WWCC Management{{$tutor_name}}<br/><p class="small_tag">This section contains information and access to the tutor WWCC.  </p></h1>
                    <ol class="breadcrumb pull-right">
                        <li> <a href="{{ route('admin_wwcc_management_list') }}"><i class="fas fa-backward"></i> Back</a></li>

                        @if(@$previous_id)
                            <li> <a href="{{ route('admin_wwcc_management_view',@$previous_id) }}"><i class="fas fa-angle-double-left"></i> Previous</a></li>
                        @endif

                        @if(@$next_id)
                            <li> <a href="{{ route('admin_wwcc_management_view',@$next_id) }}"><i class="fas fa-angle-double-right"></i> Next</a></li>
                        @endif
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    {{-- <h5>Right to Work Info</h5> --}}
                    <div class="table-responsive gj_wwcc_div">
                        <table class="table table-bordered gj_wwcc_tbl">
                            <tbody>
                                <tr>
                                    <td colspan="5">Working with Children Check (WWCC):</td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <th>WWCC #</th>
                                    <th>Date of Expiry</th>
                                    <th>WWCC Doc</th>
                                    <th>Authorised</th>
                                    <th>Action</th>
                                </tr>
                                
                                @if (is_array(config('tutor_form.australian_states')))
                                    @php
                                        $wwccData = collect(@$taf_wwcc ?? [])->keyBy('states');
                                        // print_r($wwccData);
                                    @endphp
                                    @foreach (config('tutor_form.australian_states') as $wwcc_chk_k => $wwcc_chk_v)
                                        @php
                                            $ext_wwcc_chk_k = @$wwccData[$wwcc_chk_k] ?? null;
                                        @endphp
                                        
                                        <tr>
                                            <td>
                                                <span class="wwcc_state">{{ $wwcc_chk_v }}</span>
                                                <input type="hidden" value="{{ $ext_wwcc_chk_k['id'] ?? '' }}" name="wwcc_id" class="wwcc_id">
                                                <input type="hidden" value="{{ $taf_data->tutor_id ?? '' }}" name="wwcc_tutor_id" class="wwcc_tutor_id">
                                                <input type="hidden" value="{{ $taf_data->tutor_app_id ?? '' }}" name="wwcc_tutor_app_id" class="wwcc_tutor_app_id">
                                                <input type="hidden" value="{{ $wwcc_chk_k ?? '' }}" name="wwcc_states" class="wwcc_states">
                                            </td>

                                            <td>
                                                <span>{{ $ext_wwcc_chk_k['wwcc_no'] ?? '-' }}</span>
                                                <input type="text" value="{{ $ext_wwcc_chk_k['wwcc_no'] ?? '' }}" name="wwcc_no" class="wwcc_no" style="display: none">
                                            </td>
                                            
                                            <td>
                                                <span>{{ (isset($ext_wwcc_chk_k['expiry_date']) && $ext_wwcc_chk_k['expiry_date']) ? date('d M Y', strtotime($ext_wwcc_chk_k['expiry_date'])) : '-' }}</span>
                                                <input type="date" value="{{ $ext_wwcc_chk_k['expiry_date'] ?? '' }}" min="{{ date('Y-m-d') }}" name="wwcc_expiry_date" class="wwcc_expiry_date" style="display: none">
                                            </td>

                                            <td>
                                                @if (isset($ext_wwcc_chk_k['wwcc_doc']) && $ext_wwcc_chk_k['wwcc_doc'])
                                                    <a href="{{ $ext_wwcc_chk_k['wwcc_doc'] ? public_asset($ext_wwcc_chk_k['wwcc_doc']) : '' }}" target="_blank" class="wwcc_doc_file">View Doc</a>     
                                                @else
                                                    {{ '-' }}
                                                @endif
                                            </td>

                                            <td>
                                                @if (isset($ext_wwcc_chk_k['wwcc_no']) && $ext_wwcc_chk_k['wwcc_no'])
                                                    @if (isset($ext_wwcc_chk_k['is_valid']) && $ext_wwcc_chk_k['is_valid'] == 1)
                                                        <span>Yes</span>
                                                        <input type="checkbox" checked data-id="{{ $ext_wwcc_chk_k['id'] }}" class="is_valid" style="display: none">
                                                    @else
                                                        <span>No</span>
                                                        <input type="checkbox" data-id="" class="is_valid" style="display: none">
                                                    @endif
                                                @else
                                                    <span>No</span>
                                                    <input type="checkbox" data-id="" class="is_valid" style="display: none">
                                                @endif
                                            </td>

                                            <td>
                                                <button type="button" class="btn wwcc_btn_edit">Edit</button>
                                                <button type="button" class="btn wwcc_btn_save" style="display: none">Save</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
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
    <script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>

    <script>
        $(document).ready(function(){
            $(document).on('click', '.wwcc_btn_edit', function (e) {
                $(this).closest('tr').find('span').hide();
                $(this).closest('tr').find('.wwcc_state').show();
                $(this).closest('tr').find('input').show();
                $(this).closest('tr').find('.wwcc_btn_edit').hide();
                $(this).closest('tr').find('.wwcc_btn_save').show();
            });
            
            $(document).on('click', '.wwcc_btn_save', function (e) {
                $(this).closest('tr').find('input').hide();
                $(this).closest('tr').find('span').show();
                $(this).closest('tr').find('.wwcc_state').show();
                $(this).closest('tr').find('.wwcc_btn_save').hide();
                $(this).closest('tr').find('.wwcc_btn_edit').show();

                wwcc_id = $(this).closest('tr').find('.wwcc_id').val();
                wwcc_tutor_id = $(this).closest('tr').find('.wwcc_tutor_id').val();
                wwcc_tutor_app_id = $(this).closest('tr').find('.wwcc_tutor_app_id').val();
                wwcc_states = $(this).closest('tr').find('.wwcc_states').val();
                wwcc_no = $(this).closest('tr').find('.wwcc_no').val();
                wwcc_expiry_date = $(this).closest('tr').find('.wwcc_expiry_date').val();
                is_valid = $(this).closest('tr').find('.is_valid').val();
                var is_valid = 2;
                if ($(this).closest('tr').find('.is_valid').is(':checked')) {
                    is_valid = 1;
                }

                $.ajax({
                    url: "{{ route('admin_wwcc_management_update') }}",
                    method: "POST",
                    data: {
                        wwcc_id: wwcc_id,
                        wwcc_tutor_id: wwcc_tutor_id,
                        wwcc_tutor_app_id: wwcc_tutor_app_id,
                        wwcc_states: wwcc_states,
                        wwcc_no: wwcc_no,
                        wwcc_expiry_date: wwcc_expiry_date,
                        is_valid: is_valid,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response && response == 1) {
                            $('.gj_alert_msg').html('<div class="alert alert-success alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>The data has been saved successfully.</div>');
                            
                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                        } else if (response && response == 2) {
                            $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>The data has been saved failed.</div>');
                        } else if (response && response == 3) {
                            $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Something wrong, please try again later</div>');
                        } else if (response && response == 4) {
                            $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>WWCC Number is required</div>');
                        } else if (response && response == 5) {
                            $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>WWCC Expiry date is required</div>');
                        } else if (response && response == 6) {
                            $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Something wrong, please try again later</div>');
                        } else {
                            $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Something wrong, please try again later</div>');
                        }
                    },
                    error: function(xhr) {
                        $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Something wrong, please try again later</div>');
                    }
                });
            });

            /* $(document).on('change', '.is_valid', function (e) {
                var is_valid = 2;
                if ($(this).is(':checked')) {
                    is_valid = 1;
                }

                if($(this).data('id')) {
                    var wwcc_id = $(this).data('id');

                    $.ajax({
                        url: "{{ route('admin_tutor_application_form_change_wwcc_status') }}",
                        method: "POST",
                        data: {
                            is_valid: is_valid,
                            wwcc_id: wwcc_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response && response == 1) {
                                $('.gj_alert_msg').html('<div class="alert alert-success alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Validation status change success!</div>');
                            } else {
                                $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Validation status change failed!</div>');
                            }
                        },
                        error: function(xhr) {
                            $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Something wrong, please try again later</div>');
                        }
                    });
                } else {
                    $('.gj_alert_msg').html('<div class="alert alert-danger alert-dismissible" style="text-align: center;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Something wrong, please try again later</div>');
                }
            }); */
        });
    </script>
@endsection
@extends('layouts.app')
@section('title')
    <title>V-Tutor  | Tutor | Advanced</title>
@endsection
@section('left_part')
    @include('include.header_menu_part')
    {{-- for datatable --}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    {{-- date exclusion list --}}
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.914/styles/kendo.default-main.min.css" />

    <script src="https://kendo.cdn.telerik.com/2021.3.914/js/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous"></script>
    <style type="text/css">
        .addDisablePhone {
            opacity: 0.5 !important;
        }

        .pointerEventsNone {
            pointer-events: none !important;
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
                    <div class="user-right-panel tutor-right ">

                        <div class="turo-edit">
                            <div class="user-right-top tranhis">

                                <h2 class="profile-heading">
                                    <span class="per-info">
                                        <img src="{{ public_asset('assets/images/per-info.png') }}">
                                    </span>
                                    Advanced
                                </h2>
                                <p>You can find information or edit your advanced information in this section</p>
                                <br>
                                @include('include.errors')
                                <div class="float-right" style="margin-right: 10px">
                                    <a class="deen" target="_blank" href="{{ route('teacher.profile') }}"
                                        style="color: white;">Back</a>
                                </div>
                                <form class="" method="post" action="{{ route('teacher.update.advance.page') }}"
                                    enctype="multipart/form-data" id="frm">
                                    @csrf

                                    <div class="user-account-info ">
                                        <div class="row new_rows no-gutters">
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label for="nationality_id">Nationality*</label>
                                                    <select name="nationality_id" class="required" id="nationality_id">
                                                        <option value="">Select Nationality</option>
                                                        @if (@$nationalities)
                                                            @foreach (@$nationalities as $n)
                                                                <option value="{{ @$n->id }}"
                                                                    @if (@Auth::user()->nationality_id == @$n->id) selected="" @endif>
                                                                    {{ @$n->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="error_nationality_id error"></div>
                                                </div>
                                            </div>


                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label for="visa_type">Residency Status*</label>
                                                    <select name="visa_type" class="required" id="visa_type"
                                                        onchange="showOtherVisa()">
                                                        <option value="">Select one</option>
                                                        <option value="A"
                                                            @if (@Auth::user()->visa_type == 'A') selected="" @endif>Australian
                                                            Citizen</option>
                                                        <option value="P"
                                                            @if (@Auth::user()->visa_type == 'P') selected="" @endif>Permanent
                                                            Resident</option>
                                                        <option value="S"
                                                            @if (@Auth::user()->visa_type == 'S') selected="" @endif>Student or
                                                            Temporary Work Visa</option>
                                                        <option value="W"
                                                            @if (@Auth::user()->visa_type == 'W') selected="" @endif>Sponsored
                                                            or Work Permit Visa</option>

                                                        <option value="O"
                                                            @if (@Auth::user()->visa_type == 'O') selected="" @endif>Others
                                                        </option>
                                                    </select>
                                                    <div class="error_visa_type error"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 other_visa_type_div"
                                                @if (!@Auth::user()->other_visa_type) style="display: none;" @endif>
                                                <div class="form_box_area">
                                                    <label for="other_visa_type">Type of Visa*</label>
                                                    <input type="text" name="other_visa_type"
                                                        value="{{ @Auth::user()->other_visa_type }}" id="other_visa_type">
                                                    <div class="error_other_visa_type error"></div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-4 col-sm-6 from_time_value book_f_t_v">
                                                <div class="form_box_area">
                                                    <label>Visa Expiry (if applicable)</label>
                                                    <input id="visa_expiry" name="visa_expiry" class=" datepickeropen"
                                                        value="{{ @Auth::user()->visa_expiry }}" placeholder="Select date">
                                                    <span id="error_visa_expiry"
                                                        class="error error_visa_expiry_text_show required"></span>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="row new_rows no-gutters">
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label for="id_proof_type">Identification Proof*</label>
                                                    <select name="id_proof_type" class="required" id="id_proof_type">
                                                        <option value="">Select ID Proof</option>
                                                        <option value="P"
                                                            @if (@Auth::user()->id_proof_type == 'P') selected="" @endif>Copy of
                                                            Passport </option>
                                                        <option value="D"
                                                            @if (@Auth::user()->id_proof_type == 'D') selected="" @endif>Driving
                                                            Licence</option>
                                                        <option value="G"
                                                            @if (@Auth::user()->id_proof_type == 'G') selected="" @endif>Govt
                                                            issued ID card</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="para_italics">Passport copy will be required to confirm work
                                                    entitlements / citizenship</p>
                                            </div>

                                            <div class="col-sm-12">
                                                <p class="text_advance_show">Please select the document that you wish to
                                                    upload to complete 60 points in the 100 point check</p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="identy_proff">Upload ID Proof*

                                                </p>
                                                <div class="uplodimg text_sm_c">
                                                    <div class="uplodimgfil">
                                                        <input type="file" name="id_proof" id="id_proof"
                                                            class="inputfile inputfile-1 imgValue  @if (!@Auth::user()->id_proof) required @endif">
                                                        <label for="id_proof">Upload ID Proof<img
                                                                src="{{ public_asset('assets/images/up.png') }}"
                                                                alt=""></label>
                                                        <div class="error error_id_proof note"></div>
                                                    </div>
                                                    <div class="uplodimgfilimg review_img pt-0" style="display: block;">
                                                        @if (@Auth::user()->id_proof)
                                                            <a id="id_proof_link"
                                                                href="{{ url('storage/id_proof') . '/' }}{{ @Auth::user()->id_proof }}">{{ @Auth::user()->id_proof }}</a>
                                                        @else
                                                            <a id="id_proof_link" href="#"></a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="note error_image"></p>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label for="residence_id_proof_type">Residence Proof*</label>
                                                    <select name="residence_id_proof_type" class="required"
                                                        id="residence_id_proof_type">
                                                        <option value="">Select Residence Proof</option>

                                                        <option value="U"
                                                            @if (@Auth::user()->residence_id_proof_type == 'U') selected="" @endif>Utility
                                                            Bills</option>
                                                        <option value="L"
                                                            @if (@Auth::user()->residence_id_proof_type == 'L') selected="" @endif>Lease
                                                            Agreement</option>
                                                        <option value="B"
                                                            @if (@Auth::user()->residence_id_proof_type == 'B') selected="" @endif>Bank
                                                            Statement</option>
                                                        <option value="O"
                                                            @if (@Auth::user()->residence_id_proof_type == 'O') selected="" @endif>Others
                                                        </option>


                                                    </select>
                                                    <div class="error_residence_id_proof_type error"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="text_advance_show">Please select the document that you wish to
                                                    upload to complete 40 points in the 100 point check</p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="identy_proff">Residence Proof*

                                                </p>
                                                <div class="uplodimg text_sm_c">
                                                    <div class="uplodimgfil">

                                                        <input type="file" name="residence_proof" id="residence_proof"
                                                            class="inputfile inputfile-1 imgValue  @if (!@Auth::user()->residence_proof) required @endif"
                                                            data-multiple-caption="{count} files selected">
                                                        <label for="residence_proof">Upload Residence Proof<img
                                                                src="{{ public_asset('assets/images/up.png') }}"
                                                                alt=""></label>
                                                        <span class="error error_residence_proof note"></span>
                                                    </div>
                                                    <div class="uplodimgfilimg review_img pt-0" style="display: block;">
                                                        @if (@Auth::user()->residence_proof)
                                                            <a id="residence_proof_link"
                                                                href="{{ url('storage/residence_proof') . '/' }}{{ @Auth::user()->residence_proof }}">{{ @Auth::user()->residence_proof }}</a>
                                                        @else
                                                            <a id="residence_proof_link" href=""></a>
                                                        @endif
                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>
                                                <p class="note error_image"></p>
                                            </div>


                                        </div>
                                        <div class="row new_rows no-gutters">

                                            <div class="col-12 p-0">
                                                <div class="row new_rows no-gutters">

                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">

                                            </div>



                                        </div>
                                    </div>
                                    <div class="user-account-info ">
                                        <div class="row new_rows no-gutters">
                                            <div class="col-12">
                                                <h3>Residential Address</h3>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Country*</label>
                                                    <select name="country">
                                                        <option value="1">Australia</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>State / Province / Region*</label>
                                                    <select name="state" id="state" class="form-control"
                                                        class="required">
                                                        <option value="">Select State</option>
                                                        @foreach ($state as $st)
                                                            <option value="{{ $st->id }}"
                                                                data-timezone="{{ $st->time_zone }}"
                                                                {{ @Auth::user()->state == $st->id || @Auth::user()->state_id == $st->id ? 'selected' : '' }}>
                                                                {{ $st->state_name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>City* </label>
                                                    <input type="text" class="required" placeholder="Sydney"
                                                        name="city" value="{{ @$teacher->city }}">
                                                    <div class="error_city"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Unit & Street Address *</label>
                                                    <input type="text" class="required" placeholder="123, Sample St"
                                                        name="address" value="{{ @$teacher->address }}">
                                                    <div class="error_address"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>Zip / Postal Code *</label>
                                                    <input type="text" minlength="4" maxlength="4" class="required"
                                                        placeholder="1234" name="zip" value="{{ @$teacher->zip }}"
                                                        onkeypress='validate(event)' pattern="\d{4}">
                                                    <div class="error_zip"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form_box_area">

                                                    <label for="time_zone">Time Zone</label>
                                                    <input type="text" id="timezone_id" name="timezone_id"
                                                        class="form-control" readonly
                                                        value="{{ @Auth::user()->timezone_id ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row new_rows no-gutters">

                                            <div class="col-12">
                                                <div class="check-box check-box-cu">

                                                    <input type="checkbox" id="checkbox1" name="checkbox1"
                                                        class="required" value="all">
                                                    <label for="checkbox1" class="checklabeel">I authorise V-Tutor to
                                                        undertake background,
                                                        reference and other related checks with respective agencies.</label>
                                                    <input type="checkbox" id="checkbox2" name="checkbox2"
                                                        class="required" value="all">
                                                    <label for="checkbox2" class="checklabeel">I have read and agree to
                                                        V-Tutor <a href="{{ url('privacy-policy') }}" target="_blank">
                                                            Privacy Policy </a> and <a href="{{ url('terms-conditions') }}"
                                                            target="_blank"> Terms &amp; Conditions </a></label>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-12">
                                                <div class="btn_3_cc ">
                                                    <a href="javascript:void(0)" data-toggle="modal"
                                                        data-target="#confirmationPopup"
                                                        id="openMessagePopupAfterValidate" style="display:none;"></a>
                                                    <input type="button" value="Submit & Apply"
                                                        class="sub_btn2 new-subbtn pointerEventsNone addDisablePhone disable-input submit-login"
                                                        id="updateTutorProfile2">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="footdashSec">
                                                    <div class="sub2-lap">
                                                        <img src="{{ public_asset('assets/images/cona.png') }}">
                                                    </div>
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
@endsection
@section('footer')
    @include('include.footer')
    <div class="modal res-modal newqusmo" id="confirmationPopup">
        <div class="modal-dialog modal-dialog-centered confirmationPopupDiv tapDiv proClose">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Message</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body ">
                    <div class="testPro">
                        <div class=" proDiv">
                            <span class="proclosespan"></span>
                            <h6></h6>

                            <p>Your application will now be submitted. Kindly allow 24-48 hrs for the backend team to
                                process and get back.</p>



                            <div class="next-btn1 newst_btn-pop">
                                <button type="button" class="btn btn-new btn-danger float-left change-new-link "
                                    data-dismiss="modal">Cancel </button>

                                <a href="javascript:void(0);" id="confirm_btn" class="btn btn-new btn-danger">Confirm</a>


                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('include.script')
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

    <script src="{{ public_asset('assets/toastr/build/toastr.min.js') }}"></script>
    <script src="https://kit.fontawesome.com/446e463225.js" crossorigin="anonymous"></script>
    <script src="https://kendo.cdn.telerik.com/2021.3.914/js/kendo.all.min.js"></script>
    <script>
        document.getElementById('state').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById('timezone_id').value = selectedOption.getAttribute('data-timezone');
        });
    </script>
    <script>
        function showOtherVisa() {
            var visa_type = $.trim($("#visa_type option:selected").val());
            if (visa_type == "O") {
                $(".other_visa_type_div").show();
                $("#other_visa_type").addClass("required");

            } else {
                $(".other_visa_type_div").hide();
                $("#other_visa_type").removeClass("required");
                $("#other_visa_type").val("");
            }
            if (visa_type == 'A' || visa_type == 'P') {
                // $("#visa_expiry").removeClass("required");
                $("#visa_expiry").val("");
            } else {
                // $("#visa_expiry").addClass("required");
            }
        }

        function residence_proof() {
            var i = document.getElementById('residence_proof').files[0];
            $("#residence_proof_link").html(i);
        }

        function id_proof() {
            var i = document.getElementById('id_proof').files[0];
            $("#id_proof_link").html(i);
        }
        $(document).ready(function() {
            $('#frm').validate({
                submitHandler: function(form) {
                    $("#confirmationPopup").hide();
                    var id_proof = $.trim($("#id_proof").val());
                    var residence_proof = $.trim($("#residence_proof").val());
                    @if (!@Auth::user()->id_proof)
                        if (id_proof == "") {
                            $(".error_id_proof").html("This field is required");
                            return false;
                        }
                    @endif
                    @if (!@Auth::user()->residence_proof)
                        if (residence_proof == "") {
                            $(".error_residence_proof").html("This field is required");
                            return false;
                        }
                    @endif
                    if ($.trim($("#visa_type").val()) == "A" || $.trim($("#visa_type").val()) == "P") {
                        form.submit();
                    } else {
                        if ($.trim($("#visa_expiry").val()) == "") {
                            $("#error_visa_expiry").html("This field is required");
                            return false;
                        } else {
                            form.submit();
                        }
                    }
                }
            });
            $('#confirm_btn').click(function() {
                $("#frm").submit();
            });
            $('#updateTutorProfile2').click(function() {
                var isvalidator = $("#frm").validate();
                if (isvalidator.form()) {
                    if (isvalidator.valid()) {
                        // $("#confirmationPopup").hide();
                        var id_proof = $.trim($("#id_proof").val());
                        var residence_proof = $.trim($("#residence_proof").val());
                        @if (!@Auth::user()->id_proof)
                            if (id_proof == "") {
                                $(".error_id_proof").html("This field is required");
                                return false;
                            } else {
                                $(".error_id_proof").html("");
                            }
                        @endif
                        @if (!@Auth::user()->residence_proof)
                            if (residence_proof == "") {
                                $(".error_residence_proof").html("This field is required");
                                return false;
                            } else {
                                $(".error_residence_proof").html("");
                            }
                        @endif
                        if ($.trim($("#visa_type").val()) == "A" || $.trim($("#visa_type").val()) == "P") {
                            $("#openMessagePopupAfterValidate").trigger("click");
                        } else {
                            if ($.trim($("#visa_expiry").val()) == "") {
                                $("#error_visa_expiry").html("This field is required");
                                return false;
                            } else {
                                $("#error_visa_expiry").html("");
                                $("#openMessagePopupAfterValidate").trigger("click");
                            }
                        }

                    }
                }
            });
            $('#checkbox1').change(function() {
                var obj = $('#checkbox2');
                var obj1 = $('#checkbox1');
                if ($(this).prop('checked') == true && obj.prop('checked') == true && obj1.prop(
                        'checked') == true) {
                    $('.disable-input').prop("disabled", false);
                    $('.submit-login').removeClass('disable-input');
                    $('.submit-login').removeClass('pointerEventsNone');
                    $('.submit-login').removeClass('addDisablePhone');

                } else {
                    $('.submit-login').addClass('disable-input');
                    $('.submit-login').addClass('pointerEventsNone');
                    $('.submit-login').addClass('addDisablePhone');
                    $('.disable-input').prop("disabled", true);

                }
            });
            $('#checkbox2').change(function() {
                var obj = $('#checkbox2');
                var obj1 = $('#checkbox1');
                if ($(this).prop('checked') == true && obj.prop('checked') == true && obj1.prop(
                        'checked') == true) {
                    $('.disable-input').prop("disabled", false);
                    $('.submit-login').removeClass('disable-input');
                    $('.submit-login').removeClass('pointerEventsNone');
                    $('.submit-login').removeClass('addDisablePhone');

                } else {
                    $('.submit-login').addClass('disable-input');
                    $('.submit-login').addClass('pointerEventsNone');
                    $('.submit-login').addClass('addDisablePhone');
                    $('.disable-input').prop("disabled", true);

                }
            });

            var d = $("#visa_expiry").kendoDatePicker({
                min: new Date(),
                format: "yyyy-MM-dd",
                footer: false
            }).data("kendoDatePicker");
            d.readonly();
            $(document).on("click", "#visa_expiry", function() {
                var id = $(this).attr("id");
                $("#" + id).data("kendoDatePicker").open();
            });
            $(document).on("click", "#visa_expiry", function() {
                var id = $(this).attr("id");
                $("#" + id).data("kendoDatePicker").open();
            });
            $(document).on("change", "#id_proof", function() {
                readURL(this);
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#id_proof_link').attr('href', e.target.result);
                        $('#id_proof_link').html(input.files[0].name);
                        $(".error_id_proof").html("");
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(document).on("change", "#residence_proof", function() {
                readURLResidenceProof(this);
            });

            function readURLResidenceProof(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#residence_proof_link').attr('href', e.target.result);
                        $('#residence_proof_link').html(input.files[0].name);
                        $(".error_residence_proof").html("");
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(document).on("click", ".k-select", function() {
                $("#visa_expiry").trigger("click");
            });
        });
    </script>
    <script></script>
@endsection

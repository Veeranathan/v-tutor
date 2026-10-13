@extends('admin.layouts.app')
@section('title')
Edit Advance
@endsection
@section('links')
@include('admin.includes.links')
<link rel="stylesheet" type="text/css" href="{{ public_asset('admin/assets/libs/css/chosen.css') }}">
<link href="{{ public_asset('admin/assets/css/owl.carousel.css') }}" rel="stylesheet" type="text/css">
<script src="{{ public_asset('admin/assets/js/modernizr.min.js') }}"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style type="text/css">
    .addDisablePhone{
        opacity: 0.5 !important;
    }
    .pointerEventsNone{
        pointer-events: none !important;
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
                <h1 class="pull-left page-title">Personal Details<br/><p class="small_tag">You can find information or edit your profile in this section</p></h1>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.tutors') }}"><i class="fas fa-backward"></i> Back</a></li>
                    <li> <a href="{{ route('view.tutor.advance.page',$user->id) }}"><i class="fas fa-eye"></i> View</a></li>

                    @if(@$previous_id)
                    <li> <a href="{{ route('edit.tutor.advance.page',@$previous_id) }}"><i class="fas fa-angle-double-left"></i> Previous</a></li>
                    @endif
                    @if(@$next_id)
                    <li> <a href="{{ route('edit.tutor.advance.page',@$next_id) }}"><i class="fas fa-angle-double-right"></i> Next</a></li>
                    @endif
                </ol>
            </div>
        </div>
        <div class="step_tab">
            <ul>
                <li>
                    <a href="javascript:void(0);" id="clickHere" data-toggle="modal" data-target="#instructionModal" style="display:none;">Click</a>
                    <a href="{{ route('edit.tutor.personal.info.step.1',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/peri.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/perih.png') }}" class="accth"></span>
                    Personal Details
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.tutorship.plans',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/gar.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/garh.png') }}" class="accth"></span>
                    Tutorship Plan
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.academics',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/aca.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/acah.png') }}" class="accth"></span>
                    Academics
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.experience',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/ex.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/exh.png') }}" class="accth"></span>
                    Experience </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.rec',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Recognitions
                    </a>
                </li>
                <li>
                    <a href="{{ route('edit.tutor.availablity',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Availability
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('edit.tutor.advance.page',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Advanced
                    </a>
                </li>
                <div class="clearfix"></div>
            </ul>
        </div>
        <!-- Personal-Information -->
        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')
                <form id="updateAdvanceInfo" method="post" action="{{ route('edit.tutor.advance.page',@$user->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="frm_admin">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="nationality_id">Nationality*</label>
                                    <select id="nationality_id" name="nationality_id" class="required form-control">
                                        <option value="">Select Nationality</option>
                                        @if(@$nationalities)
                                        @foreach(@$nationalities as $n)
                                        <option value="{{ @$n->id }}" @if(@$user->nationality_id == @$n->id) selected="" @endif>{{ @$n->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="visa_type">Visa Type*</label>
                                    <select id="visa_type" name="visa_type" class="required form-control" onchange="showOtherVisa()">
                                        <option value="">Select Visa Type</option>
                                        <option value="A" @if(@$user->visa_type == "A") selected="" @endif>Australian Citizen</option>
                                        <option value="P" @if(@$user->visa_type == "P") selected="" @endif>Permanent Resident</option>
                                        <option value="S" @if(@$user->visa_type == "S")  selected="" @endif>Student</option>
                                        <option value="W" @if(@$user->visa_type == "W")  selected="" @endif>Work Permit</option>
                                        <option value="O" @if(@$user->visa_type == "O") selected="" @endif>Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                <div class="dash-d1">
                                    <label for="visa_expiry">Visa Expiry Date</label>
                                    <div class="ui calendar" id="from_date">
                                        <div class="ui input left icon">
                                          <input type="text" id="visa_expiry" name="visa_expiry" placeholder="Visa Expiry Date" class="form-control " autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{ @$user->visa_expiry }}">
                                          <span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
                                          <span class="error_from_date error"></span>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="visa_expiry">Visa Expiry Date*</label>
                                    <input type="date" id="visa_expiry" name="visa_expiry" class="form-control" value="{{ @$user->visa_expiry }}">
                                </div>
                            </div> --}}
                            <div class="col-md-4 col-sm-6 other_visa_type_div" @if(!@$user->other_visa_type) style="display: none;" @endif>
                                <div class="form-group" >
                                    <label for="other_visa_type">Type of Visa*</label>
                                    <input type="text" name="other_visa_type" value="{{ @$user->other_visa_type }}" id="other_visa_type" class="form-control">
                                    <div class="error_other_visa_type error"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label for="id_proof_type">Id Proof Type*</label>
                                    <select name="id_proof_type" class="required form-control" id="id_proof_type">
                                        <option value="">Select Id Proof Type</option>
                                        <option value="P" @if(@$user->id_proof_type == "P") selected="" @endif>Copy of Passport </option>
                                        <option value="D" @if(@$user->id_proof_type == "D") selected="" @endif>Driving Licence</option>
                                        <option value="G" @if(@$user->id_proof_type == "G") selected="" @endif>Govt issued ID card</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <p class="identy_proff">Identification Proof* <span> (Please select the document that you wish to upload to complete 60 points in the 100 point)</span></p>
                                <div class="uplodimg form-group">
                                    <div class="uplodimgfil">
                                        <input type="file" name="id_proof" id="id_proof" class="inputfile inputfile-1 @if(!@$user->id_proof)  required @endif " >
                                        <label for="id_proof">
                                            Upload Id Proof
                                            <img src="{{ public_asset('admin/assets/images/up.png') }}" alt="">
                                        </label>
                                        <span class="error_id_proof error"></span>
                                    </div>
                                    <div class="uplodimgfilimg pt-0">
                                        @if(@$user->id_proof)
                                            <a id="id_proof_link" download="" href="{{ URL::to('storage/id_proof/'.decrypt(@$user->id_proof)) }}">{{ decrypt(@$user->id_proof) }}</a>
                                        @else
                                            <a id="id_proof_link" download="" href=""></a>
                                        @endif

                                    </div>
                                </div>
                                <p class="note error_image selected_image_error"></p>
                            </div>
                            {{-- </div> --}}

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="residence_id_proof_type">Residence Proof Type*</label>
                                    <select name="residence_id_proof_type" class="required form-control" id="residence_id_proof_type">
                                        <option value="">Select Residence Proof Type</option>
                                        <option value="D" @if(@$user->residence_id_proof_type == "D") selected="" @endif>Driving Licence</option>
                                        <option value="U" @if(@$user->residence_id_proof_type == "U") selected="" @endif>Utility Bills</option>
                                        <option value="L" @if(@$user->residence_id_proof_type == "L") selected="" @endif>Lease Agreement</option>
                                        <option value="B" @if(@$user->residence_id_proof_type == "B") selected="" @endif>Bank Statement</option>
                                        {{-- <option value="G" @if(@$user->residence_id_proof_type == "O") selected="" @endif>Govt issued ID card</option> --}}
                                        <option value="O" @if(@$user->residence_id_proof_type == "O") selected="" @endif>Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <p class="identy_proff">Residence Proof* <span> (Please select the document that you wish to upload to complete 40 points in the 100 point)</span></p>
                                <div class="uplodimg form-group">
                                    <div class="uplodimgfil">
                                        <input type="file" name="residence_proof" id="residence_proof" class="inputfile inputfile-1 @if(!@$user->residence_proof) required @endif">
                                        <label for="residence_proof">Upload Residence Proof<img src="{{ public_asset('admin/assets/images/up.png') }}" alt=""></label>

                                        <span class="error error_residence_proof"></span>
                                    </div>
                                    <div class="uplodimgfilimg pt-0">
                                        @if(@$user->residence_proof)
                                        <a id="residence_proof_link" download="" href="{{ URL::to('storage/residence_proof/'.decrypt(@$user->residence_proof)) }}">{{ decrypt(@$user->residence_proof) }}</a>
                                        @else
                                        <a id="residence_proof_link" download="" href=""></a>
                                        @endif
                                    </div>
                                </div>
                                <p class="note error_image selected_image_error"></p>
                            </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="user-account-info">
                                    <h3>Residential Address</h3>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select class="form-control rm06 required" name="country" id="country">
                                        <option value="1" @if(@$user->country == 1) selected="" @endif>Australia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="state">State / Province / Region</label>
                                    <select class="form-control rm06 required" name="state" id="state">
                                        <option value="">Select State</option>
                                        @if(@$states)
                                        @foreach(@$states as $state)
                                        <option value="{{ @$state->id }}" @if(@$user->state == @$state->id) selected="" @endif>{{ @$state->state_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city" class="form-control required" placeholder="Sydney" value="{{ @$user->city }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="address">Unit & Street Address</label>
                                    <input type="text" id="address" name="address" class="form-control required" placeholder="123, Sample St" value="{!! strip_tags(@$user->address) !!}">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="zip">Zip / Postal Code</label>
                                    <input type="number" id="zip" name="zip" class="form-control required" placeholder="1234" value="{{ @$user->zip }}" minlength="4">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="timezone_id">Timezone</label>
                                    <select name="timezone_id" class="required form-control" id="timezone_id">
                                        <option value="">Select timezone</option>
                                        @if(@$timezonesLists)
                                        @foreach(@$timezonesLists as $t)
                                        @if(@$t->id == 6)
                                        <option value="{{ @$t->id }}" @if(@$t->id==@$user->timezone_id) selected=""  @endif >{{ @$t->time_zone_abbreviation }},{{ @$t->time_zone_name }},{{ @$t->city }} @if($t->id == 6),Melbourne @endif ({{ @$t->utc_offset }})</option>
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12">
                                <div class="ad_btn">
                                    <button class="btn btn-primary waves-effect waves-light w-md c_save_edit_tutor_personal_info onpopupclickopne"  type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
<script src="{{ public_asset('admin/assets/libs/js/chosen.jquery.min.js') }}"></script>
<script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>
<script src="{{ url('/') }}/public/admin/assets/js/owl.carousel.js"></script>
<script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>
{{-- for datatable --}}
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
{{-- for validation --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>

<script type="text/javascript">
    function showOtherVisa(){
        var visa_type = $.trim($("#visa_type option:selected").val());
        if(visa_type == "O"){
            $(".other_visa_type_div").show();
            $("#other_visa_type").addClass("required");
        }else{
            $(".other_visa_type_div").hide();
            $("#other_visa_type").removeClass("required");
            $("#visa_expiry").val("");
        }
        if(visa_type == 'A'){
            $("#visa_expiry").removeClass("required");
        }else{
            $("#visa_expiry").addClass("required");
        }
    }
    $("#updateAdvanceInfo").validate({
        submitHandler: function(form){
            var id_proof = $.trim($("#id_proof").val());
            var residence_proof = $.trim($("#residence_proof").val());
            @if(!@$user->id_proof)
            if(id_proof == ""){
                $(".error_id_proof").html("This field is required");
                return false;
            }
            @endif
            @if(!@$user->residence_proof)
            if(residence_proof == ""){
                $(".error_residence_proof").html("This field is required");
                return false;
            }
            @endif

            if($.trim($("#visa_type").val()) == "A"){
                form.submit();
            }else{
                if($.trim($("#visa_expiry").val()) == ""){
                    $("#error_visa_expiry").html("This field is required");
                    return false;
                }else{
                    form.submit();
                }
            }
        }
    });
    $(document).ready(function(){
        $(document).on("change","#id_proof",function(){
           readURL(this);
        });
        function readURL(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $('#id_proof_link').attr('href',e.target.result);
                  $('#id_proof_link').html(input.files[0].name);
                  $(".error_id_proof").html("");
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).on("change","#residence_proof",function(){
           readURLResidenceProof(this);
        });
        function readURLResidenceProof(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $('#residence_proof_link').attr('href',e.target.result);
                  $('#residence_proof_link').html(input.files[0].name);
                  $(".error_residence_proof").html("");
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#from_date").calendar({
            type: 'date',
            minDate:new Date(),
            formatter: {
                date: function (date, settings) {
                    if (!date) return '';
                    var day = date.getDate() + '';
                    if (day.length < 2) {
                        day = '0' + day;
                    }
                    var month = (date.getMonth() + 1) + '';
                    if (month.length < 2) {
                        month = '0' + month;
                    }
                    var year = date.getFullYear();
                    var date_value = year + '-' + month + '-' + day;
                    // if(date_value > $.trim($("#from_time").val())){
                    //     $("#to_time").val("");
                    // }
                    return date_value;
                }
            }
        });
    });
</script>
@endsection

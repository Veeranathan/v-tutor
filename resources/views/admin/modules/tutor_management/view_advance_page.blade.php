@extends('admin.layouts.app')
@section('title')
Tutor Advance information
@endsection
@section('links')
@include('admin.includes.links')

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
                <h1 class="pull-left page-title">Personal Details<br/><p class="small_tag">You can find information or view of tutor profile in this section  </p></h1>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.tutors') }}"><i class="fas fa-backward"></i> Back</a></li>
                    {{-- <li> <a href="{{ route('edit.tutor.advance.page',$user->id) }}"><i class="fas fa-pen"></i> Edit</a></li> --}}

                    @if(@$previous_id)
                    <li> <a href="{{ route('view.tutor.advance.page',@$previous_id) }}"><i class="fas fa-angle-double-left"></i> Previous</a></li>
                    @endif
                    @if(@$next_id)
                    <li> <a href="{{ route('view.tutor.advance.page',@$next_id) }}"><i class="fas fa-angle-double-right"></i> Next</a></li>
                    @endif
                </ol>
            </div>
        </div>
        <div class="step_tab">
            <ul>
                <li >

                    <a href="{{ route('view.tutor.personal.info.step.1',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/peri.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/perih.png') }}" class="accth"></span>
                    Personal Details
                    </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor.tutorship.plans',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/gar.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/garh.png') }}" class="accth"></span>
                    Tutorship Plan
                    </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor.academics',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/aca.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/acah.png') }}" class="accth"></span>
                    Academics
                    </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor.experience',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/ex.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/exh.png') }}" class="accth"></span>
                    Experience </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor.recognitions',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Recognitions
                    </a>
                </li>
                <li>
                    <a href="{{ route('view.tutor',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Availability
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('view.tutor.advance.page',$user->id) }}">
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
                <form id="updatePersonalInfo" method="post" action="{{ route('edit.tutor.personal.info.step.1',@$user->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="frm_admin">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="f_name">Nationality</label>
                                    <p class="text-muted">

                                        @if(@$user->nationality_id != 0)
                                        {{ @$user->getNationality->name }}
                                        @endif
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="l_name"> Visa Type</label>
                                    <p class="text-muted">
                                        @if(@$user->visa_type == 'A')
                                        Australian Citizen
                                        @endif
                                        @if(@$user->visa_type == 'P')
                                        Permanent Resident
                                        @endif
                                        @if(@$user->visa_type == 'S')
                                        Student
                                        @endif
                                        @if(@$user->visa_type == 'W')
                                        Work Permit
                                        @endif
                                        @if(@$user->visa_type == 'O')
                                        Others
                                        @endif
                                        @if(@$user->visa_type == 'G')
                                        Govt issued ID card
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="l_name"> Other Type of Visa</label>
                                    <p class="text-muted">

                                        @if(@$user->visa_type == 'O')
                                        {{ @$user->other_visa_type }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="email">Visa Expiry Date</label>
                                    <p class="text-muted">{{ @$user->visa_expiry }}</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="id_proof">Id Proof Type</label>
                                    <p class="text-muted">
                                        @if(@$user->id_proof_type == 'P')
                                        Copy of Passport
                                        @endif
                                        @if(@$user->id_proof_type == 'D')
                                        Driving Licence
                                        @endif
                                        @if(@$user->id_proof_type == 'G')
                                        Govt issued ID card
                                        @endif
                                    </p>
                                </div>
                            </div>
                            {{-- <div class="clearfix"></div> --}}
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="teacher_emp_status">Id proof</label>
                                    <p class="text-muted">
                                        @if(@$user->id_proof)
                                        <a download="" href="{{ url('storage/id_proof').'/' }}{{ decrypt(@$user->id_proof) }}">{{ decrypt(@$user->id_proof) }}</a>
                                        @endif
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="id_proof">Residence Proof Type</label>
                                    <p class="text-muted">
                                        @if(@$user->residence_id_proof_type == 'U')
                                        Utility Bills
                                        @endif
                                        @if(@$user->residence_id_proof_type == 'D')
                                        Driving Licence
                                        @endif
                                        @if(@$user->residence_id_proof_type == 'L')
                                        Lease Agreement
                                        @endif
                                        @if(@$user->residence_id_proof_type == 'O')
                                        Others
                                        @endif
                                        @if(@$user->residence_id_proof_type == 'G')
                                        Govt issued ID card
                                        @endif
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="teacher_emp_status">Residence proof</label>
                                    <p class="text-muted">
                                        @if(@$user->residence_proof)
                                        <a download="" href="{{ url('storage/residence_proof').'/' }}{{ decrypt(@$user->residence_proof) }}">{{ decrypt(@$user->residence_proof) }}</a>
                                        @endif
                                    </p>

                                </div>
                            </div>
                            {{-- <div class="col-sm-12 col-xs-12">
                                <div class="user-account-info">
                                    <h3>Bank Information</h3>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="zip">Bank Name</label>
                                    <p class="text-muted">
                                        {{ @$user->bank_name }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="zip">Account No</label>
                                    <p class="text-muted">
                                        {{ @$user->account_no }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="zip">Account Name</label>
                                    <p class="text-muted">
                                        {{ @$user->account_name }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="zip">BSB Code</label>
                                    <p class="text-muted">
                                        {{ @$user->bsb_code }}
                                    </p>

                                </div>
                            </div> --}}
                            <div class="col-sm-12 col-xs-12">
                                <div class="user-account-info">
                                    <h3>Residential Address</h3>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <p class="text-muted">
                                        @if(@$user->country == 1)
                                        Australia
                                        @endif
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="state">State / Province / Region</label>
                                    <p class="text-muted">
                                        {{ @$user->getState->state_name }}
                                    </p>

                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <p class="text-muted">
                                        {{ @$user->city }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="address">Unit & Street Address</label>
                                    <p class="text-muted">
                                        {!! strip_tags(@$user->address) !!}
                                    </p>

                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="zip">Zip / Postal Code</label>
                                    <p class="text-muted">
                                        {{ @$user->zip }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="school">Timezone</label>
                                    <p class="text-muted">
                                        {{-- {{ @$user->getTimezone->time_zone_abbreviation }},{{ @$user->getTimezone->time_zone_name }},{{ @$user->getTimezone->city }}@if(@$user->getTimezone->id == 6),Melbourne @endif ({{ @$user->getTimezone->utc_offset }}) --}}
                                        {{ @$user->timezone_id }}
                                    </p>
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
<script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>

@endsection

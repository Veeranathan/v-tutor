@extends('admin.layouts.app')
@section('title')
View Tutor Details
@endsection
@section('links')
@include('admin.includes.links')
<link rel="stylesheet" type="text/css" href="{{ public_asset('admin/assets/libs/css/chosen.css') }}">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.2.1/css/fixedColumns.dataTables.min.css"/>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style type="text/css">
/*this is excel button needs to hide as we have already download option*/
.buttons-excel{
    display: none;
}
</style>
<script src="{{ public_asset('admin/assets/js/modernizr.min.js') }}"></script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','../../www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-65046120-1', 'auto');
    ga('send', 'pageview');
</script>
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
        <h1 class="pull-left page-title">View Tutor Details</h1>
        <ol class="breadcrumb pull-right">
            <li> <a href="{{ route('manage.tutors') }}"><i class="fas fa-backward"></i> Back</a></li>
            @if(@$next_id)
            <li> <a href="{{ route('view.tutor.experience',@$next_id) }}"><i class="fas fa-angle-double-left"></i> Next</a></li>
            @endif
            @if($previous_id)
            <li> <a href="{{ route('view.tutor.experience',@$previous_id) }}"><i class="fas fa-angle-double-left"></i> Previous</a></li>
            @endif
            <li> <a href="{{ route('view.tutor.personal.info.step.1',@$user->id) }}"><i class="fas fa-angle-double-left"></i> Personal Details</a></li>
            <li> <a href="{{ route('view.tutor.tutorship.plans',@$user->id) }}"><i class="fas fa-angle-double-left"></i> Tutorship Plan</a></li>
            <li> <a href="{{ route('view.tutor.academics',@$user->id) }}"><i class="fas fa-angle-double-left"></i> Academics </a></li>
            <li> <a href="{{ route('view.tutor.experience',@$user->id) }}"><i class="fas fa-angle-double-left"></i> Experience </a></li>
            <li> <a href="{{ route('view.tutor.recognitions',@$user->id) }}"><i class="fas fa-angle-double-left"></i> Recognitions</a></li>
            <li> <a href="{{ route('view.tutor.right.to.work',@$user->id) }}"><i class="fas fa-angle-double-left"></i> Right to Work</a></li>
             <li class="">
                <a href="{{ route('view.tutor',$user->id) }}">
                <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                Availability
                </a>
            </li>
            {{--<li class="">
                <a href="{{ route('view.tutor.advance.page',$user->id) }}">
                <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                Advanced
                </a>
            </li> --}}

        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div>
            <div class="row">
                <div class="col-md-6">
                    <!-- Personal-Information -->
                    <div class="panel panel-default panel-fill">
                        <div class="panel-heading">
                            <h3 class="panel-title">View Teacher Personal Details</h3>
                        </div>
                        <div class="panel-body">
                            <div class="about-info-p">
                                <strong>Name</strong>
                                <br>
                                <p class="text-muted">{{ @$user->f_name }} {{ @$user->l_name }}</p>
                            </div>
                            <div class="about-info-p">
                                <strong>Date of joining</strong>
                                <br>
                                <p class="text-muted">{{ @$user->created_at->format('d-M-Y') }}</p>
                            </div>
                            <div class="about-info-p">
                                <strong>Email</strong>
                                <br>
                                <p class="text-muted">{{ @$user->email }}</p>
                            </div>
                            <div class="about-info-p">
                                <strong>Phone</strong>
                                <br>
                                <p class="text-muted">{{ @$user->phone }}</p>
                            </div>
                            <div class="about-info-p">
                                <strong>Platform</strong>
                                <br>
                                <p class="text-muted">
                                    @if(@$user->platform_type)
                                    {{ @$user->platform_type }}
                                    @else
                                    Web
                                    @endif
                                </p>
                            </div>
                            <div class="about-info-p" style="height:100% !important;width: :100%;">
                                <strong>Profile Picture</strong>
                                <br>
                                <p class="text-muted">
                                    @if(@$user->profile_pic)

                                            <img src="{{env('STORAGE_URL') . '/teacher_profile_pic/'.@$user->profile_pic}}" alt="" style="height: 50% !important;
    width: 50% !important;">

                                    @else
                                        @if(@$user->avatar)
                                            <img src="{{@$user->avatar}}" alt="" style="height: 50% !important;
    width: 50% !important;">
                                        @endif
                                    @endif
                                </p>
                            </div>


                            <div class="about-info-p">
                                <strong>status</strong>
                                <br>
                                <p class="text-muted">
                                    @if(@$user->status == 'A')
                                    Active
                                    @elseif(@$user->status == 'I')
                                    Inactive
                                    @elseif(@$user->status == 'AA')
                                    Awaiting Approval
                                    @elseif(@$user->status == 'U')
                                    Unverified
                                    @endif
                                </p>
                            </div>
                            <div class="about-info-p">
                                <strong>Gender</strong>
                                <br>
                                <p class="text-muted">
                                    @if(@$user->gender == 'F')
                                    Female
                                    @elseif(@$user->gender == 'M')
                                    Male
                                    @elseif(@$user->gender == 'O')
                                    Others
                                    @elseif(@$user->gender == 'P')
                                    PREFER NOT TO SAY
                                    @endif
                                </p>
                            </div>



                            <div class="about-info-p">
                                <strong>Address</strong>
                                <br>
                                <p class="text-muted">{!! strip_tags(@$user->address) !!}</p>
                            </div>
                            <div class="about-info-p">
                                <strong>Country</strong>
                                <br>
                                <p class="text-muted">
                                    @if(@$user->country == '1')
                                    Australia
                                    @endif
                                </p>
                            </div>
                            <div class="about-info-p">
                                <strong>State</strong>
                                <br>
                                <p class="text-muted">
                                    {{ @$user->getState->state_name }}
                                </p>
                            </div>
                            <div class="about-info-p">
                                <strong>City</strong>
                                <br>
                                <p class="text-muted">
                                    {{ @$user->city }}
                                </p>
                            </div>
                            <div class="about-info-p">
                                <strong>Zip</strong>
                                <br>
                                <p class="text-muted">
                                    {{ @$user->zip }}
                                </p>
                            </div>

                        </div>
                    </div>
                    <!-- Personal-Information -->
                </div>
                <div class="col-md-6">
                    <!-- Personal-Information -->
                    <div class="panel panel-default panel-fill">
                        <div class="panel-heading">
                            <h3 class="panel-title">View Teacher Employee Details</h3>
                        </div>
                        <div class="panel-body">
                            <div class="about-info-p">
                                <strong>Teacher Employee Status</strong>
                                <br>
                                <p class="text-muted">
                                    @if(@$user->teacher_emp_status == 'A')
                                    Yes, I'm a full-time teacher
                                    @elseif(@$user->teacher_emp_status == 'B')
                                    No, but I have teaching experience
                                    @elseif(@$user->teacher_emp_status == 'C')
                                    Yes, but I'm not a teacher
                                    @elseif(@$user->teacher_emp_status == 'D')
                                    No, but I have passion for teaching
                                    @endif
                                </p>
                            </div>

                            <div class="about-info-p">
                                <strong>What makes you an awesome V-Tutor?</strong>
                                <br>
                                <p class="text-muted">
                                    {!! strip_tags(@$user->about_me) !!}
                                </p>
                            </div>

                            <div class="about-info-p">
                                <strong>How many hours you can commit?</strong>
                                <br>
                                <p class="text-muted">
                                   @if(@$user->hours == '1-4')
                                   < 5 hrs a week
                                   @elseif(@$user->hours == '5-10')
                                   5 – 10 hrs a week
                                   @elseif(@$user->hours == '10-20')
                                   10 – 20 hrs a week
                                   @elseif(@$user->hours == '20-40')
                                   20 – 40 hrs a week
                                   @elseif(@$user->hours == '40+')
                                   > 40 hrs a week
                                   @endif

                                </p>
                            </div>
                            <div class="about-info-p">
                                <strong>Why Tutor</strong>
                                <br>
                                <p class="text-muted">
                                    @if(@$user->why_tutor == 'A')
                                   Leverage my teaching experience
                                   @elseif(@$user->why_tutor == 'B')
                                   Looking for after-hours gig
                                   @elseif(@$user->why_tutor == 'C')
                                   To make more money by teaching
                                   @elseif(@$user->why_tutor == 'D')
                                   Teaching is my passion, money secondary
                                   @elseif(@$user->why_tutor == 'E')
                                   Safe way to make money from home
                                   @endif

                                </p>
                            </div>
                            <div class="about-info-p">
                                <strong>Work With Child</strong>
                                <br>
                                <p class="text-muted">
                                    @if(@$user->work_with_child == 'Y')
                                    Yes
                                    @else
                                    No
                                    @endif
                                </p>
                            </div>
                            <div class="about-info-p">
                                <strong>Criminal Case</strong>
                                <br>
                                <p class="text-muted">
                                    @if(@$user->criminal_case == 'Y')
                                    Yes
                                    @else
                                    No
                                    @endif
                                </p>
                            </div>
                            <div class="about-info-p">
                                <strong>Criminal details</strong>
                                <br>
                                <p class="text-muted">
                                    {!! strip_tags(@$user->criminal_details) !!}
                                </p>
                            </div>
                            <div class="about-info-p">
                                <strong>Profile Video</strong>
                                <br>
                                <p class="text-muted">
                                    <a target="_blank" href="{{ @$user->profile_video }}"> {{ @$user->profile_video }}</a>
                                </p>
                            </div>

                        </div>
                    </div>
                    <!-- Personal-Information -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default panel-fill">
                        <div class="panel-heading">
                            <h3 class="panel-title">Tutor Availability</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="example">
                                    <thead>
                                        <tr>
                                            <th>Day </th>
                                            <th>From Time</th>
                                            <th>To Time</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(@$availablity)
                                        @foreach(@$availablity as $key=>$b)
                                        <tr>
                                            <td>
                                                @if(@$b->day == '1')
                                                Monday
                                                @elseif(@$b->day == '2')
                                                Tuesday
                                                @elseif(@$b->day == '3')
                                                Wednesday
                                                @elseif(@$b->day == '4')
                                                Thursday
                                                @elseif(@$b->day == '5')
                                                Friday
                                                @elseif(@$b->day == '6')
                                                Saturday
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                $date = @$b->from_time." ".date('y-m-d');
                                                $d = date('h:i:s a - m/d/Y', strtotime($date));
                                                $d1 = explode("-",$d);
                                                @endphp
                                                {{ $d1[0] }}
                                            </td>
                                            <td>
                                                @php
                                                $date = @$b->to_time." ".date('y-m-d');
                                                $d = date('h:i:s a - m/d/Y', strtotime($date));
                                                $d1 = explode("-",$d);
                                                @endphp
                                                {{ $d1[0] }}
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
<script src="{{ public_asset('admin/assets/libs/js/chosen.jquery.min.js') }}"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script type="text/javascript">
    $('#instructionModal').modal('hide');
    // $("#example").DataTable();
    oTable = $('#example').DataTable({
      "order": [
          [0, "desc"]
      ],
      "pageLength": 10,
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
    // $("#example").DataTable({dom: "<div class='table-res'></div>"+'p'+'B'});
    $("#download").click(function(){
        $(".buttons-excel").trigger("click");
    });
    // $("#example_wrapper div").eq(0).addClass("table-res");
    $("#example_info").remove();
        $("#example_length").remove();
</script>
@endsection

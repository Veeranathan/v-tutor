@extends('admin.layouts.app')
@section('title')
Schedule
@endsection
@section('links')
@include('admin.includes.links')
<link rel="stylesheet" type="text/css" href="{{ public_asset('admin/assets/libs/css/chosen.css') }}">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.2.1/css/fixedColumns.dataTables.min.css"/>
<style type="text/css">
/*this is excel button needs to hide as we have already download option*/
    .buttons-excel{
    display: none;
}
.step_tab ul {
    display: flex;
    flex-wrap: nowrap !important;
    padding-left: 0;
    margin-bottom: 10px;
}

.step_tab ul li {
    margin-right: 6px;
}

.step_tab ul li a {
    font-size: 11px !important;       /* Smaller font */
    padding: 5px 10px !important;      /* Reduce tab width */
    border-radius: 6px !important;     /* Slightly smaller curve */
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 4px;                          /* Reduce icon + text gap */
}

.step_tab ul li a span img {
    width: 15px !important;           /* Reduce icon size */
    height: auto;
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
                <h1 class="pull-left page-title">Schedule<br/><p class="small_tag">You can find information or view tutor profile in this section </p></h1>
                <ol class="breadcrumb pull-right">
                    <li> <a href="{{ route('manage.tutors') }}"><i class="fas fa-backward"></i> Back</a></li>
                    {{-- <li> <a href="{{ route('edit.tutor.availablity',$user->id) }}"><i class="fas fa-pen"></i> Edit Availability</a></li> --}}

                    @if(@$previous_id)
                    <li> <a href="{{ route('view.tutor',@$previous_id) }}"><i class="fas fa-angle-double-left"></i> Previous</a></li>
                    @endif

                    @if(@$next_id)
                    <li> <a href="{{ route('view.tutor',@$next_id) }}"><i class="fas fa-angle-double-right"></i> Next</a></li>
                    @endif

                </ol>
            </div>
        </div>
        <div class="step_tab">
            <ul>
                <li class="">
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
                    <a href="{{ route('view.tutor.right.to.work',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Right to Work
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('view.tutor',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Availability
                    </a>
                </li>
                {{--<li>
                    <a href="{{ route('view.tutor.advance.page',$user->id) }}">
                    <span><img src="{{ public_asset('admin/assets/images/rec.png') }}" class="actt"><img src="{{ public_asset('admin/assets/images/rech.png') }}" class="accth"></span>
                    Advanced
                    </a>
                </li>--}}

                <div class="clearfix"></div>
            </ul>
        </div>
        <!-- Personal-Information -->
        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')

                    <div class="frm_admin">
                        <div class="row">
                            <div class="centerButtons">

                                {{--<div class="rm05 rightButtons">
                                <button class="btn btn-primary waves-effect waves-light w-md download" id="download" type="button">Download </button>
                            </div>--}}
                            <div class="clearfix"></div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Tutor Availability</h3>
                                    </div>
                                    
                                    <div class="panel-body">
                                        <div class="row">
    <div class="col-md-12">
        <label><strong>Time Zone :</strong></label>
        <span>{{ $user->timezone_id }}</span>
    </div>
</div>
                                        <table class="table table-bordered table-striped" id="example">
                                            {{-- <table class="table"> --}}
                                                <thead>
                                                    <tr>
                                                        <th>Day </th>
                                                        <th> Time</th>
                                                        

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   @php
    $order = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        7 => 'Sunday'
    ];

    // Sort strictly by numeric day value
    $slotsByDay = collect($availablity)
        ->groupBy('day')
        ->sortBy(function($slots, $day) {
            return (int)$day;
        });
@endphp

@if ($slotsByDay->isNotEmpty())
    @foreach ($slotsByDay as $day => $slots)
        <tr>
            <td><strong>{{ $order[(int)$day] }}</strong></td>

            @php
                $formattedSlots = $slots->map(function($slot){
                    return date('h:i a', strtotime($slot->from_time))
                           .' – '.date('h:i a', strtotime($slot->to_time));
                })->implode(', ');
            @endphp

            <td>{{ $formattedSlots }}</td>
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

<script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>
{{-- for datatable --}}
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
{{-- for validation --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
{{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script> --}}
<script type="text/javascript">
$.validator.setDefaults({ ignore: ":hidden:not(.slct)" });
$(document).ready(function(){
    // $("#example").DataTable(columnDefs: [ { targets: 0, type: 'natural' } ]);
   oTable = $('#example').DataTable({
    "ordering": false,     // <--- STOP DATATABLE SORTING
    "pageLength": 10,
    "language": {
        "emptyTable": "No data available",
        "info": "",
        "infoEmpty": "",
        "infoFiltered": ""
    },
    dom: '<"top"f>t<"bottom row"<"col-12 d-flex justify-content-end"p>>'
});
    

  if (oTable.rows().data().length === 0) {
      $(oTable.table().container())
          .find('.dataTables_paginate')
          .hide();
  }
    // $("#example").DataTable({dom: "<div class='table-res'></div>"+'p'+'B'});

    $("#from_date").calendar({
        type: 'date',
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
                return year + '-' + month + '-' + day;
            }
        }
    });
    $('.slct').chosen();
    function filterColumn ( i ) {
        $('#example').DataTable().column( i ).search(
            $('#col'+i+'_filter').val(),
        ).draw();
    }
    $("#example_filter").hide();
    $("#download").click(function(){
        $(".buttons-excel").trigger("click");
    });
    // $("#example_wrapper div").eq(0).addClass("table-res");
    $("#example_info").remove();
    $("#example_length").remove();
});
</script>
@endsection

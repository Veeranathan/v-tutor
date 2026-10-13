@extends('layouts.app')
@section('title')
<title>V-Tutor  | Tutor | Transaction history</title>
@endsection
@section('left_part')
@include('include.header_menu_part')
{{-- for datatable --}}
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
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
                    {{-- user-right-panel addDisablePhone pointerEventsNone --}}
                    <div class="user-right-panel">
                        <div class="user-right-top-new  tranhis">
                        	@include('include.errors')
                            <h2 class="profile-heading">Transaction History</h2>
                           {{--  <p>You can find information about your payments in this section</p> --}}
                            <div class="float-right" style="margin-right: 10px">
                                <a class="deen" href="{{route('tutor.my.payments')}}" style="color: white;">Back</a>
                            </div>
                           <div class="tu-info detailspayment_002">
                            <div class="sed detailspayment">
                                <span>Earnings before Commission: <b>${{@$userDetails->total_earning+@$userDetails->total_commission}}</b></span>
                                <span>Earnings after Commission:: <b>${{@$userDetails->total_earning}}</b></span>
                                </span>

                              <span>Amount Due: <b>${{@$userDetails->total_due}}</b></span>
                              <span>Amount Last Paid: <b>${{@$userDetails->total_paid}}</b></span>
                              <span>Total Earnings: <b>${{@$userDetails->total_earning}}</b></span>

                            </div>
                        </div>


                        </div>

                        <div class="class-feild gj_pay_his_frm_div @if(@$payment_history->count() <= 0) addDisablePhone pointerEventsNone @endif">
                            <form method="post" action="{{route('transaction.history')}}" id="frm">
                            	@csrf
                                <div class="row new_rows no-gutters transactHistoryCls">

                                            <div class="col-sm-3">
                                                <div class="form_box_area">
                                                    <label>Payment Type</label>
                                                    <select name="perpous">
                                                        <option value="">Select Payment Type</option>
                                                        <option value="I" @if(request('perpous')=="I") selected @endif >Incentives</option>
                                                        <option value="W" @if(request('perpous')=="W") selected @endif >Remuneration</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-5 srCls">
                                                <div class="form_box_area">

                                                    <div class="dash-d1">
                                                      <label>From Date</label>
                                                       <div class="ui calendar" id="from">
                                                            <div class="ui input left icon">

                                                              <input type="text" placeholder="From Date"  name="from_date" id="from_date" value="{{request('from_date')}}">
                                                              <span class="over_llp1"><img src="{{ public_asset('assets/images/cal.png')}}" alt=""></span>
                                                            </div>
                                                         </div>
                                                    </div>

                                                    <div class="dash-d1">
                                                      <label>To Date</label>
                                                       <div class="ui calendar" id="to">
                                                            <div class="ui input left icon">

                                                              <input type="text" placeholder="To Date"  name="to_date" id="to_date" value="{{request('to_date')}}">
                                                              <span class="over_llp1"><img src="{{ public_asset('assets/images/cal.png')}}" alt=""></span>
                                                            </div>
                                                         </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                 </div>
                                            </div>




                                        {{-- <div class="col-sm-2"> --}}
                                            {{-- <button class="dash-btn @if(@$tot_payments <= 0) addDisablePhone pointerEventsNone @endif"> <img src="{{ public_asset('assets/images/ser.png')}}"> Search </button> --}}

                                        {{-- </div> --}}
                                        {{-- &nbsp;&nbsp;&nbsp;&nbsp; --}}
                                        <div class="col-sm-2">
                                            <div class="form_box_area">
                                                <button class="dash-btn @if(@$payment_history->count() <= 0) addDisablePhone pointerEventsNone @endif"> <img src="{{ public_asset('assets/images/ser.png')}}"> Search </button>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form_box_area">
                                                <a href="{{route('transaction.history')}}" class="dash-btn @if(@$payment_history->count() <= 0) addDisablePhone pointerEventsNone @endif">Reset</a>
                                            </div>
                                        </div>

                                </div>
                            </form>
                        </div>

                        <div class="user-right-top-new gj_tut_sess_tbl_sec @if(@$payment_history->count() <= 0) addDisablePhone pointerEventsNone @endif">
                            <div class="main-tabels">
                                <!-- Nav tabs -->

                                <!-- Tab panes -->
                                {{--
                                    <div class="float-right">
                                        <a href="#" class="deen">Download</a>
                                    </div> --}}

                                      <div class="custom-table">
                                       {{-- start --}}
                                            <table id="example" class="cell-border table table-responsive">
                                                <thead>
                                                    <tr>

                                                        <th >Amount <img src="{{ public_asset('assets/images/sort.png')}}"></th>
                                                        <th >Note <img src="{{ public_asset('assets/images/sort.png')}}"></th>
                                                        <th >Payment Type <img src="{{ public_asset('assets/images/sort.png')}}"></th>
                                                        <th >Date <img src="{{ public_asset('assets/images/sort.png')}}"></th>

                                                       {{--  <th> </th> --}}

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($payment_history as $key=> $val)
                                                    <tr>

                                                        <td data-label="Name">
                                                            {{@$val->amount}}
                                                        </td>

                                                        <td data-label="Name">{{@$val->note}} </td>

                                                        <td data-label="Name">
                                                        	@if($val->purpose=="I")
														Incentive
														@else
														Remuneration
														@endif
                                                        </td>
                                                        	<td data-label="Name">{{date('d.m.Y', strtotime(@$val->created_at))}}  </td>



                                                       {{--  <td >
                                                            <div class="add_ttrr actions-main">
                                                                <a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
                                                                <div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
                                                                <ul>
                                                                    <li><a href="{{route('review.details',$val->id)}}">View Review</a></li>

                                                                </ul>
                                                            </div>



                                                    </div>
                                                </td> --}}
                                                </tr>


                                                @endforeach

                                            </tbody>
                                        </table>

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
	{{-- for datatable --}}
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

	<script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
	<script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
         <script>
            $(document).ready(function(){
                $('#frm').validate({

                    rules:{
                        qualification:{
                            required:true,
                        },
                         field_of_study:{
                            required:true,
                        },
                         university:{
                            required:true,
                        },
                         qualification_status:{
                            required:true,
                        },
                        effective_date:{
                            required:true,
                        }

                    },
                    // messages:{
                    //      qualification:{
                    //         required:" Category name is mandatory",
                    //     }

                    // }


                });

            });
        </script>
	<script>
	function fun(id){
	$('.show-actions').slideUp();
	$("#show-action"+id).show();
	}
	function Cancel(id){
	$("#show-action"+id).hide();
	}
	$(document).mouseup(function(e)
	{
	var container = $(".show-actions");
	// if the target of the click isn't the container nor a descendant of the container
	if (!container.is(e.target) && container.has(e.target).length === 0)
	{
	container.hide();
	}
	});
	</script>

<script>
oTable = $('#example').DataTable({
"pageLength":10,
"language": {
                "emptyTable": "No data available",
                "info": "",
                "infoEmpty": "",
                "infoFiltered": "" 
            },
            dom: '<"top"f>t<"bottom row"<"col-12 d-flex justify-content-end"p>>',
});

if (oTable.rows().data().length === 0) {
            $(oTable.table().container())
                .find('.dataTables_paginate')
                .hide();
        }
</script>

<script >
$('#from').calendar({
type: 'date',
maxDate:new Date({{strtotime(date('Y-m-d H:i:s') )}}*1000),
});
</script>
<script >
$('#to').calendar({
type: 'date',
maxDate:new Date({{strtotime(date('Y-m-d H:i:s')  )}}*1000),
});
</script>



<script>
//var d = new Date();
$('#frm').validate({
submitHandler: function (form) {
var val1 = new Date($('#from_date').val());
var val2 = new Date($('#to_date').val());


console.log($('#from').val());
console.log(val2);
//return false;
if(val1 != "Invalid Date" || val2 != "Invalid Date"){
if(val1 == "Invalid Date" && val2 == "Invalid Date") {
alert("select both dates");
return false;

}
else if(val1 == "Invalid Date" && val2 != "Invalid Date" ) {
alert("select from date");
return false;
}
else if(val1 != "Invalid Date" && val2 == "Invalid Date" ) {
alert("select to date");
return false;
}
else if(val1 > val2) {
console.log('max');
console.log(val1);
console.log(val2);

alert('From date cannot be greater than to date');
}
else{
form.submit();
}
}else{
form.submit();
}

}
});
</script>

	@endsection

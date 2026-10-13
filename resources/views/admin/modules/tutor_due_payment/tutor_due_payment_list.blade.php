@extends('admin.layouts.app')
@section('title')
Payments Management
@endsection
@section('links')
@include('admin.includes.links')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@endsection
@section('header')
@include('admin.includes.header')
@endsection
@section('sidebar')
@include('admin.includes.sidebar')
@endsection
@section('content')
<div class="content">
	<div class="container">
		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				{{-- <div class="col-sm-12"> --}}
					<h1 class="pull-left page-title">Payments Management</h1>
					<ol class="breadcrumb pull-right">
					</ol>
				</div>
			</div>
			    <div class="row">
        <div class="col-lg-12">
            <div>
                <!-- Personal-Information -->
                <div class="panel panel-default panel-fill">
                    <div class="panel-heading">
                        <h3 class="panel-title">Change Commission*</h3>
                    </div>
                    <div class="panel-body rm02 rm04">

                        <form class="form-horizontal" id="commissionForm" method="post" action="{{ route('admin.set.commission') }}" role="form">
                            @csrf
                            <div class="form-group">
                                <label for="grade_name">Commission Percentage*</label>
                                <input type="number" placeholder="Commission" id="commission" name="commission" class="form-control required" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" min="0" max="100" value="{{ @$admin_commission_management->commission }}">
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md c_save_g" id="save_g" type="button">Save</button> </div>
                        </form>
                    </div>
                </div>
                <!-- Personal-Information -->
            </div>
        </div>
    </div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default ">
						<form action="{{ route('due.payments') }}" method="post" id="frm">
							@csrf
							<div class="panel-heading rm02 rm04">
								<div data-column="2" class="form-group">
	                                <label for="">Show Tutors with Dues Only</label>
	                                <select id="show_only" name="show_only" class="form-control reset_val">
	                                    <option value="">Select </option>
	                                    <option value="Y" @if(request('show_only') == 'Y') selected="" @endif>Yes</option>
	                                    <option value="N" @if(request('show_only') == 'N') selected="" @endif>No</option>

	                                </select>
	                            </div>
								<div data-column="1" class="form-group">
									<label for="col1_filter">Keyword</label>
									<input type="text" placeholder="Keyword" id="keyword" name="keyword" class="form-control reset_val"  autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{request('keyword')}}">
								</div>
								{{-- <div class="form-group show_tutor_due_frm_cls"> --}}
                                    {{-- <div class="checkBox new-cus tur-radio"> --}}
                                        {{-- <span>Show Tutors with Dues Only </span> --}}
                                        {{-- <ul> --}}
                                            {{-- <li class="one_li_check show_tutors_due_onlycls">
                                                <input type="checkBox" id="show_only" name="show_only" value="Y" class=" " @if(request('show_only') == 'Y') checked="" @endif>
                                                <label for="show_only">Show Tutors with Dues Only </label>
                                            </li> --}}
                                            {{-- <li>
                                                <input type="checkBox" id="radio4" name="criminal_case" value="N" checked="" class=" criminal_case" onclick="no()">
                                                <label for="radio4">No</label>
                                            </li> --}}
                                        {{-- </ul> --}}
                                    {{-- </div> --}}
                                {{-- </div> --}}
								{{-- <div data-column="1" class="form-group"> --}}

									{{-- <label for="col1_filter">Keyword</label> --}}
									{{-- <li class="one_li_check">
                                                <input type="radio" id="radio3" name="criminal_case" value="Y" class=" criminal_case" onclick="yes()">
                                                <label for="radio3">Yes</label>
                                            </li> --}}
                                            {{-- <input id="radios4" type="checkbox" value="4" name="review" checked="" class="click_apply" onclick="searchResults();">
                                            <label for="radios4">
                                            <span>
                                            test
                                            </span>
                                            <strong>(4 and Above)</strong>
                                            </label> --}}

								{{-- </div> --}}
								{{--   <div data-column="2" class="form-group">
									<label for="col2_filter">Rating</label>
									<select id="rating" name="ratting" class="form-control reset_val">
										<option value="">Select rating</option>
										<option value="1" @if(request('ratting')=="1") selected @endif>1 star</option>
										<option value="2" @if(request('ratting')=="2") selected @endif>2 star</option>
										<option value="3" @if(request('ratting')=="3") selected @endif>3 star</option>
										<option value="4" @if(request('ratting')=="4") selected @endif>4 star</option>
										<option value="5" @if(request('ratting')=="5") selected @endif>5 star</option>
									</select>
								</div> --}}

								{{--      <div data-column="3" class="form-group">
									<div class="dash-d1">
										<label for="col3_filter">Search From Date</label>
										<div class="ui calendar" id="from">
											<div class="ui input left icon">
												<input type="text" id="from_date" name="from_date" placeholder="date joined from" class="form-control " autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{request('from_date')}}">
												<span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
												<span class="error_from_date error"></span>
											</div>
										</div>
									</div>
								</div> --}}
								{{-- <div class="clearfix"></div> --}}
								{{--      <div data-column="4" class="form-group">
									<div class="dash-d1">
										<label for="col4_filter">Search To Date </label>
										<div class="ui calendar" id="to">
											<div class="ui input left icon">
												<input type="text" id="to_date" name="to_date" placeholder="date joined to" class="form-control " autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{request('to_date')}}">
												<span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
												<span class="error_to_date error"></span>
											</div>
										</div>
									</div>
								</div> --}}
								{{-- <div class="clearfix"></div> --}}
								<div class="centerButtons">
									<div class="rm05">
										<button class="btn btn-primary waves-effect waves-light w-md search_click" type="submit">Search</button>
									</div>
									<div class="rm05">
										<button class="btn btn-primary waves-effect waves-light w-md reset_search" onclick="rst()" type="button">Reset </button>
									</div>
									{{--  <div class="rm05 rightButtons">
										<button class="btn btn-primary waves-effect waves-light w-md download" id="download" type="submit">Download </button>
									</div> this.form.reset(); --}}
								</div>
								<div class="clearfix"></div>
							</div>
						</form>
						<div class="panel-body">
							@include('include.errors')
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="table-responsive" id="t1">
										{{-- start --}}
										<table id="example" class="cell-border table table-responsive">
											<thead>
												<tr>
													<th >Tutor Id</th>
													<th >Tutor Name</th>
													<th>Total Revenue</th>
													<th >Commission </th>
													<th >Incentive </th>
													<th >Total Due </th>
													<th >Total Paid </th>


													<th >Online Hours </th>
													<th >Last Paid </th>



													<th> </th>

												</tr>
											</thead>
											<tbody>
												@foreach($due_payment as $key=> $val)
												<tr id="data{{$val->id}}">


													<td data-label="Name">{{@$val->unique_id}} </td>
													<td data-label="Name">
														{{@$val->f_name}}  {{@$val->l_name}}
													</td>
													<td data-label="Name">
														{{@$val->total_earning+@$val->total_commission}}
													</td>

													<td data-label="Name">{{@$val->total_commission}} </td>
                                                    <td data-label="Name">{{@$val->total_incentive}} </td>

													<td data-label="Name">
														{{@$val->total_due}}
													</td>

													<td data-label="Name">{{@$val->total_paid}} </td>

													<td data-label="Name">
														@php
														$online=DB::table('student_class_bookings')->where('tutor_id',$val->id)->where('booking_status','CM')->get();
														$sum=0;
														foreach($online as $val2){
															@$timeone=strtotime($val2->to_time);
													        @$timetwo=strtotime($val2->from_time);
													        @$diff = abs($timetwo - $timeone);
													        $min=$diff/60;
													        $sum=$sum+$min;
													        $hours  = floor($sum/60); //round down to nearest minute.
                                                             $minutes = $sum % 60;
 														}

														@endphp
														{{@$hours?@$hours:0}} hr: {{@$minutes?@$minutes:0}} min
													</td>

													<td>
														@php
														$lastpay=DB::table('user_transaction')->where('tutor_id',$val->id)->where('purpose','W')->orderBy('id','desc')->first();
														@endphp
														@if(@$lastpay)
														{{date('d.m.Y', strtotime(@$lastpay->created_at))}}
														@endif
													</td>






													<td class="reviews-lists">
														<div class="add_ttrr actions-main ">
															<a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
															<div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
															<ul>
																{{--  <li><a onclick=" return confirm('Are you sure want to delete this review ?')?dlt({{$val->id}}):'';">Pay</a></li> --}}
																<li><a href="#" data-toggle="modal" data-target="#myModal{{$val->id}}" data-total_due="{{@$val->total_due}}">Pay Tutor</a></li>
																<li><a href="#" data-toggle="modal" data-target="#modifyCommission{{$val->id}}" data-total_due="{{@$val->total_due}}">Modify Commission</a></li>
																{{--<li><a href="{{route('payments.history',$val->id)}}" >Transaction history</a></li>--}}



																{{-- <li><a href="#" data-toggle="modal" data-target="#myModal2{{$val->id}}">Add Incentive</a></li> --}}

															</ul>
														</div>


													</div>
												</td>
											</tr>


											@endforeach

										</tbody>
									</table>

								</div>



							</div>
							@foreach($due_payment as $key=> $pay)
							{{-- payment due start --}}
							<div class="modal fade" id="myModal{{$pay->id}}" role="dialog">
								<div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Pay Tutor</h4>
										</div>
										<div class="modal-body">
											<form action="{{route('tutor.payment')}}" method="post" id="pay{{$pay->id}}">
												@csrf
												<input type="hidden" name="tutor_id" value="{{$pay->id}}">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label for="search">Amount Due($)</label>
															<p class="text-muted" id="get_amount{{ @$key }}">{{ $pay->total_due }}</p>

														</div>
													</div>
													<div class="clearfix"></div>
													{{-- <div class="col-sm-6"> --}}
														{{-- <div class="form-group"> --}}
															{{-- <label for="search">Payment ($)</label> --}}
															<input type="hidden" name="payment" id="payment{{ @$key }}" min="0" class="form-control" max="{{($pay->total_due)}}" value="{{ $pay->total_due }}">
															{{-- <label id="payment-error" class="error" for="payment"></label> --}}
														{{-- </div> --}}
													{{-- </div> --}}
													<div class="col-sm-6">
														<div class="form-group">
															<label for="incentive">Incentive ($)</label>
															<input type="number" name="incentive" id="incentive{{ @$key }}" min="0" class="form-control add_incentive" value="" data-key="{{ @$key }}">
															<label id="incentive-error" class="error" for="incentive"></label>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label for="total_due">Total Due ($)</label>
															<input type="number" name="total_due" id="total_due{{ @$key }}" min="0" class="form-control total_due_textbox" max="{{$pay->total_due}}" value="{{ $pay->total_due }}">
															<label id="total_due-error" class="error" for="total_due"></label>
														</div>
													</div>
													<div class="col-sm-12">
														<div class="form-group">
															<label for="search">Payment notes</label>
															<input type="text" class="form-control" name="notes" id="notes{{ $key }}">
														</div>
													</div>
													{{-- <div class="col-sm-12">
														<div class="form-group">
															<label for="search">Incentive notes</label>
															<input type="text" class="form-control" name="incentive_notes" id="incentive_notes{{ $key }}">
														</div>
													</div> --}}
													{{-- <div class="col-sm-12">
														<div class="form-group">
															<label for="search">Payment Method</label>
															<select class="form-control rm06" name="payment_method" required>
																<option selected value="">Select Payment Method</option>
																<option value="C" @if(request('payment_method')=="C")selected @endif>Cash</option>
																<option value="O" @if(request('payment_method')=="O")selected @endif>Online</option>

															</select>
														</div>
													</div> --}}
													<div class="col-sm-12">
														<input type="submit" value="Pay" class="btn btn-primary">
														<button type="button" class="btn btn-default" data-dismiss="modal" style="float: right;">Close</button>
													</div>
												</div>
											</form>
										</div>

									</div>

								</div>
							</div>
                            {{-- payment due end --}}

							{{-- incentive  start--}}
							<div class="modal fade" id="myModal2{{$pay->id}}" role="dialog">
								<div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Make tutor incentive</h4>
										</div>
										<div class="modal-body">
											<form action="{{route('tutor.incentive')}}" method="post" id="inc{{$pay->id}}">
												@csrf
												<input type="hidden" name="tutor_id" value="{{$pay->id}}">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label for="search">Incentive ($)</label>
															<input type="number" name="inc" id="inc{{ $key }}" min="0" class="form-control" >
															<label id="payment-error" class="error" for="payment"></label>
														</div>
													</div>
													<div class="col-sm-12">
														<div class="form-group">
															<label for="search">Incentive notes</label>
															<input type="text" class="form-control" name="notes" id="notes">
														</div>
													</div>

													<div class="col-sm-12">
														<input type="submit" value="Pay" class="btn btn-primary">
														<button type="button" class="btn btn-default" data-dismiss="modal" style="float: right;">Close</button>
													</div>
												</div>
											</form>
										</div>

									</div>

								</div>
							</div>
							{{-- modify commission percentage --}}
							<div class="modal fade" id="modifyCommission{{$pay->id}}" role="dialog">
								<div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Modify Commission</h4>
										</div>
										<div class="modal-body">
											<form action="{{route('admin.modify.commission',$pay->id)}}" method="post" id="modifyCommissionId{{$pay->id}}">
												@csrf
												<input type="hidden" name="tutor_id" value="{{$pay->id}}">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label for="commissionPercentage{{ $key }}">Commission Percentage ($)</label>
															<input type="number" name="commission_percentage" id="commissionPercentage{{ $key }}" min="0" max="100" class="form-control required" value="{{ $pay->commission_percentage }}">
															<label id="com-error{{ $key }}" class="error" for="err{{ $key }}"></label>
														</div>
													</div>
													<div class="col-sm-12">
														<input type="submit" value="Save" class="btn btn-primary">
														<button type="button" class="btn btn-default" data-dismiss="modal" style="float: right;">Close</button>
													</div>
												</div>
											</form>
										</div>

									</div>

								</div>
							</div>
							{{-- incentive  end--}}
							@endforeach
							<div class="clearfix"></div>
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
@include('admin.includes.footer')
@endsection
@section('script')
@include('admin.includes.script')
<script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>
{{-- for datatable --}}
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
{{-- for validation --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
<script>
	var isvalidator = $('#commissionForm').validate();
        $('#commissionForm').on('keyup keypress keydown', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) {
            e.preventDefault();
            return false;
          }
        });
        $("#save_g").click(function(){
            if(isvalidator.form()){
	            if(isvalidator.valid()){
	                var obj = $("#save_g"),
	                tId = obj.attr("id"),
	                tName = "c_save_g",
	                tFrmId = "commissionForm";
	                $("#type_popup_next").val("R");
	                isAuthorizedByAdmin(tName,tId,tFrmId);
	            }else{
	                $('#instructionModal').modal('hide');
	            }
            }
        });
		oTable = $('#example').DataTable({
      "order": [
          [5, "desc"]
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
</script>
<script>
// $(document).ready(function(){
// $('#frm').validate({
// rules:{
// qualification:{
// required:true,
// },
// field_of_study:{
// required:true,
// },
// university:{
// required:true,
// },
// qualification_status:{
// required:true,
// },
// effective_date:{
// required:true,
// }
// },
// messages:{
//      qualification:{
//         required:" Category name is mandatory",
//     }
// }
// });
// });
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
function readmore(id){
//alert('j');
$("#desc"+id).slideToggle("slow");
$("#rr"+id).hide();
$("#rrr"+id).show();

}
function readless(id){
//alert('j');
$("#desc"+id).slideToggle("slow");
$("#rr"+id).show();
$("#rrr"+id).hide();

}
</script>
<script>
function dlt(id){
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': "{{csrf_token()}}"
}
});
var fd= new FormData;
fd.append('id',id);

$.ajax({
url:'{{route('review.dlt')}}',
type:'POST',
data: fd,
contentType: false,
processData: false,

success:function(res){
//console.log(res.msg,res.dates);
//alert(res.id);
$("#data"+id).remove();

}
});
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
<script>
function rst(p){
$('#to_date').val('');
$('#from_date').val('');
$('#rating').val('');
$('#keyword').val('');

// $('#show_only').attr("checked","");
$('#show_only').prop('checked', false); // Unchecks it

 //ajax call
   $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
            });
            //var fd= new FormData;
            //fd.append('grade_id',grade_id);

            $.ajax({
            url:'{{route('get.all.payment')}}',
            type:'GET',
            //data: fd,
            contentType: false,
            processData: false,

            success:function(res){
           // console.log(res);
             $("#example").remove();
              $("#t1").html(res);
            // $("#new").html(res);


            }
            });


}
</script>
<script>
$(document).ready(function(){
	@foreach($due_payment as $key=> $pay)
$.validator.addMethod("notOnlyZero", function (value, element, param) {
	var i = parseFloat($.trim($("#incentive"+$key).val()));
	var t = i+parseFloat(value).toFixed(2);
return this.optional(element) || parseFloat(t) > 0;
});
$('#pay{{$pay->id}}').validate({
rules:{
total_due:{
required:true,
notOnlyZero: '0',
}
},
messages:{
total_due:{
required:"it should not be null",
notOnlyZero: '0 is not allowed',
}
}
});

		$.validator.addMethod("commissionPercentage", function (value, element, param) {
			return this.optional(element) || parseFloat(value) > 0.00 || parseFloat(value) < 100;
		});
		$('#modifyCommissionId{{$pay->id}}').validate({
				rules:{
					commission_percentage:{
					required:true,
					number:true,
					commissionPercentage: '0'
				},
				commission_percentage:{
					required:true,
				}
			},
			messages:{
				commission_percentage:{
					required:"it should not be null",
					commissionPercentage: '0 is not allowed',
				}
			}
		});
@endforeach
});
</script>


<script>
$(document).ready(function(){
	@foreach($due_payment as $key=> $pay)
$.validator.addMethod("notOnlyZero", function (value, element, param) {
return this.optional(element) || parseFloat(value) > 0;
});
$('#inc{{$pay->id}}').validate({
rules:{
inc:{
required:true,
notOnlyZero: '0',
},
notes:{
	required:true,
}
},
messages:{
inc:{
required:"it should not be null",
notOnlyZero: '0 is not allowed',
}
}
});
@endforeach
	$(document).on("keyup blur",".add_incentive",function(){
		var key = $(this).data("key");
		var incentive = parseFloat($.trim($("#incentive"+key).val()));
		var payment = parseFloat($.trim($("#payment"+key).val()));
		var total = (payment+incentive);
		total = parseFloat(total).toFixed(2);
		$("#total_due"+key).attr("max",total);
		// incentive
		// total_due
		$("#total_due"+key).val(total);
	});
});
</script>

{{-- jayatri 01-12-2021 feedback --}}
<script>
$(document).ready(function(){


});
</script>
@endsection

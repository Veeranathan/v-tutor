@extends('admin.layouts.app')
@section('title')
Student Payments
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
					<h1 class="pull-left page-title">Student Payments </h1>
					<ol class="breadcrumb pull-right">
					</ol>
				</div>

			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default ">
						<div class="tu-info">

                            	@php
                            	$total_tutors=DB::table('users')->where('user_type','T')->where('is_email_verify','Y')->count();

                            	$total_class=DB::table('student_class_bookings')->where('booking_status','CM')->count();

                            	$total_students=DB::table('users')->where('user_type','U')->where('is_email_verify','Y')->count();

                            	$total_payment=DB::table('payments')->where('status','S')->count();

                            	$total_hours=DB::table('student_class_bookings')->where('booking_status','CM')->get();
                            	$sum=0;
                            	foreach($total_hours as $val2){
								@$timeone=strtotime($val2->to_time);
						        @$timetwo=strtotime($val2->from_time);
						        @$diff = abs($timetwo - $timeone);
						        $min=$diff/60;
						        $sum=$sum+$min;
						        $hours  = floor($sum/60); //round down to nearest minute.
                                 $minutes = $sum % 60;
								}

                            	@endphp

                            <div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="table-responsive" >
										{{-- start --}}
										<table {{-- id="example3" --}} class="cell-border table table-responsive" style="margin-bottom: 20px;margin-top: 20px; width: 90%;margin-left: auto; margin-right:auto">
											<thead>
												<tr>
													 <th >Total Students Enrolled</th>
													<th >Total Tutors Enrolled</th>
													<th>Total Sessions Conducted</th>
													<th>Total Payments Done</th>
													<th>Total Hours Spent</th>

												</tr>
											</thead>
											<tbody>
												<tr id="data">
												<td data-label="Name">{{@$total_students}} </td>
												<td data-label="Name">{{@$total_tutors}}</td>
												<td data-label="Name">{{@$total_class}}</td>
												<td data-label="Name">{{@$total_payment}}</td>
												<td data-label="Name">{{@$hours}}hr : {{@$minutes}}min</td>
												</tr>




										</tbody>
									</table>


								</div>



							</div>

							<div class="clearfix"></div>
						</div>






                        </div>

						<form action="{{ route('student.pay.list') }}" method="post" id="frm">
							@csrf
							<div class="panel-heading rm02 rm04">
								<div data-column="1" class="form-group">
									<label for="col1_filter">Keyword</label>
									<input type="text" placeholder="Keyword" id="keyword" name="keyword" class="form-control reset_val"  autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{request('keyword')}}">
								</div>
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
													 <th >Student Id</th>
													<th >Student Name</th>
													<th>Total Sessions</th>
													<th>Total Hours</th>
													<th>Total Paid</th>




													{{--
													<th> </th> --}}

												</tr>
											</thead>
											<tbody>
												@foreach($users as $key=> $val)
												<tr id="data{{$val->id}}">


													<td data-label="Name">
														{{@$val->unique_id}}
													</td>
													<td data-label="Name">
														{{@$val->f_name}}  {{@$val->l_name}}
													</td>
													{{-- <td data-label="Name">
														{{(int)@$val->total_earning+(int)@$val->total_commission}}
													</td>
													<td data-label="Name">
														{{@$val->total_due}}
													</td> --}}
													<td data-label="Name">
														@php
														$totalclass=DB::table('student_class_bookings')->where('student_id',$val->id)->where('booking_status','CM')->count();
														@endphp
														{{@$totalclass}}
													</td>

													 <td data-label="Name">
														@php
														$online=DB::table('student_class_bookings')->where('student_id',$val->id)->where('booking_status','CM')->get();
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
														{{@$hours}} hr: {{@$minutes}} min
													</td>





													<td>
														@php
														$totalPaid=DB::table('student_class_bookings')->where('student_id',$val->id)->whereIn('booking_status',['CM','B'])->get();
														$amount=0;
														foreach($totalPaid as $val){
                                                          $srch=DB::table('payments')->where('booking_id',$val->id)->where('status','S')->first();
                                                          if($srch){
                                                          	$amount=(int)$amount+(int)$srch->amount;
                                                          }
														}
														@endphp
														{{$amount}}
													</td>






													{{-- <td class="reviews-lists">
														<div class="add_ttrr actions-main ">
															<a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
															<div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
															<ul>

																<li><a href="#" data-toggle="modal" data-target="#myModal{{$val->id}}">Make tutor paid</a></li>
																<li><a href="{{route('payments.history',$val->id)}}" >Transaction history</a></li>



																<li><a href="#" data-toggle="modal" data-target="#myModal2{{$val->id}}" >Incentive</a></li>

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
<footer class="footer text-right">
Copyright &copy; {{ date('Y') }} <a href="{{ route('admin.dashboard') }}">V-Tutor</a>  All rights reserved.
</footer>
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
</script>
<script>
oTable = $('#example3').DataTable({
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
</script>
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

 //ajax call
   $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
            });
            //var fd= new FormData;
            //fd.append('grade_id',grade_id);

            $.ajax({
            url:'{{route('get.all.student.payment')}}',
            type:'GET',
            //data: fd,
            contentType: false,
            processData: false,

            success:function(res){
            console.log(res);
             $("#example").remove();
              $("#t1").html(res);
            // $("#new").html(res);


            }
            });


}
</script>
{{-- <script>
$(document).ready(function(){
	@foreach($due_payment as $key=> $pay)
$.validator.addMethod("notOnlyZero", function (value, element, param) {
return this.optional(element) || parseInt(value) > 0;
});
$('#pay{{$pay->id}}').validate({
rules:{
payment:{
required:true,
notOnlyZero: '0',
}
},
messages:{
payment:{
required:"it should not be null",
notOnlyZero: '0 is not allowed',
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
return this.optional(element) || parseInt(value) > 0;
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
});
</script> --}}
<script>
	$(document).ready(function(){
       $("#example3_info").hide();
       $("#example3_paginate").hide();
	});

</script>
@endsection

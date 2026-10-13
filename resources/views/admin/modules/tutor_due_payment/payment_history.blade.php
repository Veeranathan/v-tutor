@extends('admin.layouts.app')
@section('title')
Payment History
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
					<h1 class="pull-left page-title">Payment History / {{@$tutor_name}}</h1>
					<ol class="breadcrumb pull-right">
					</ol>
					 <div class="rm05 backclass">
                    <button class="btn btn-primary waves-effect waves-light w-md reset_search" onclick="rst()" type="button"><a href="{{route('due.payments')}} " style="color: white"> Back</a>   </button>
                  </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default ">
						<form action="{{ route('payments.history.search',$tutor_id) }}" method="post" id="frm">
							@csrf
							<div class="panel-heading rm02 rm04">
								<input type="hidden" name="tutor_id" value="{{@$tutor_id}}">
								{{--  <div data-column="1" class="form-group">
									<label for="col1_filter">Keyword</label>
									<input type="text" placeholder="Keyword" id="keyword" name="keyword" class="form-control reset_val"  autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{request('keyword')}}">
								</div> --}}
								  <div data-column="2" class="form-group">
									<label for="col2_filter">Payment Type</label>
									<select id="perpous" name="perpous" class="form-control reset_val">
										<option value="">Select Payment Type</option>
										<option value="I" @if(request('perpous')=="I") selected @endif>Incentives</option>
										<option value="W" @if(request('perpous')=="W") selected @endif>Remuneration</option>

									</select>
								</div>

								<div data-column="3" class="form-group">
									<div class="dash-d1">
										<label for="col3_filter">From Date</label>
										<div class="ui calendar" id="from">
											<div class="ui input left icon">
												<input type="text" id="from_date" name="from_date" placeholder=" from date" class="form-control " autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{request('from_date')}}">
												<span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
												<span class="error_from_date error"></span>
											</div>
										</div>
									</div>
								</div>
								{{-- <div class="clearfix"></div> --}}
								<div data-column="4" class="form-group">
									<div class="dash-d1">
										<label for="col4_filter">To Date </label>
										<div class="ui calendar" id="to">
											<div class="ui input left icon">
												<input type="text" id="to_date" name="to_date" placeholder=" to date" class="form-control " autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly="" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');" value="{{request('to_date')}}">
												<span class="over_llp1"><img src="{{ public_asset('admin/assets/images/cal.png') }}" alt=""></span>
												<span class="error_to_date error"></span>
											</div>
										</div>
									</div>
								</div>
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
							@include('admin.includes.message')
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="table-responsive" id="t1">
										{{-- start --}}
										<table id="example" class="cell-border table table-responsive">
											<thead>
												<tr>
													{{--    <th >Tutor </th> --}}
													<th >Amount </th>
													<th >Payment Notes </th>
													<th >Payment Type </th>
													<th >Date </th>

													{{--  <th> </th> --}}

												</tr>
											</thead>
											<tbody>
												@foreach($payment_history as $key=> $val)
												<tr id="data{{$val->id}}">


													{{--   <td data-label="Name">
														{{@$val->tutor->f_name}}  {{@$val->tutor->l_name}}
													</td> --}}
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





													{{--   <td class="reviews-lists">
														<div class="add_ttrr actions-main ">
															<a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
															<div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
															<ul>

																<li><a href="#" data-toggle="modal" data-target="#myModal{{$val->id}}">Make Payment</a></li>

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
@include('admin.includes.footer')
{{-- <footer class="footer text-right">
    Copyright &copy; {{ date('Y') }} <a href="{{ route('admin.dashboard') }}">V-Tutor</a>  All rights reserved.
</footer> --}}
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
$('#perpous').val('');
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
            url:'{{route('get.all.history',$tutor_id)}}',
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
$.validator.addMethod("notOnlyZero", function (value, element, param) {
return this.optional(element) || parseInt(value) > 0;
});
$('#pay').validate({
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
});
</script>
@endsection

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<table id="example2" class="cell-border table table-responsive">
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
						{{-- <li><a href="{{route('payments.history',$val->id)}}" >Transaction history</a></li> --}}

						{{-- <li><a href="#" data-toggle="modal" data-target="#myModal2{{$val->id}}" >Add Incentive</a></li> --}}

					</ul>
				</div>


			</div>
		</td>
	</tr>


	@endforeach

</tbody>
</table>
@foreach($due_payment as $key=> $pay)
{{-- payment  start--}}
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
{{-- payment  end--}}
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
							<input type="number" name="inc" id="inc" min="0" class="form-control" >
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
{{-- incentive  end--}}
@endforeach
<script>
oTable = $('#example2').DataTable({
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
</script>

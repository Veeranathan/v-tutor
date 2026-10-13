
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<table id="example2" class="cell-border table table-responsive">
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
												
											</tr>
											
											
											@endforeach
											
										</tbody>
									</table>
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

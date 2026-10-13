<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

		<table id="example2" class="cell-border table table-responsive">
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
														{{number_format(@$val->amount,2)}}
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

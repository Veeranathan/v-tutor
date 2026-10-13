<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<div class="table-responsive">
	{{-- start --}}
	<table id="example2" class="cell-border table table-responsive">
		<thead>
			<tr>

				<th >Review by (Student) </th>
				<th >Review for (Tutor) </th>
				<th >Review Date </th>
				<th style="white-space: nowrap;">Rating </th>
				<th >Comments </th>

				<th> </th>

			</tr>
		</thead>
		<tbody>
			@foreach($allreviews as $key=> $val)
			<tr id="data{{$val->id}}">

				<td data-label="Name">
					{{@$val->student->f_name}}  {{@$val->student->l_name}}
				</td>
				<td data-label="Name">
					{{@$val->tutor->f_name}}  {{@$val->tutor->l_name}}
				</td>

				<td data-label="Name">{{date('d.m.Y', strtotime(@$val->created_at))}} </td>

				<td data-label="Name" style="white-space: nowrap;">
					{{-- for gold star --}}
					@for($i=0;$i<=(@$val->ratting-1);$i++)

					<a href="#url"><img src="{{ public_asset('assets/images/star.png')}}" style="width: 10px"></a>

					@endfor
					{{-- blank --}}
					@for($i=0;$i<(5-@$val->ratting);$i++)

					<a href="#url"><img src="{{ public_asset('assets/images/star1.png')}}" style="width: 10px"></a>

					@endfor

				</td>
				{{--  <td data-label="Name">{{@$val->message}}</td> --}}
				<td data-label="Name">
					<p class="add_ttrr desi">{{substr(@$val->message,0,120)}}</p>
					<a class="{{-- moreless-button2 --}}  allread" onclick="readmore({{$val->id}})" id="rr{{$val->id}}">Read More +</a>
					<p class="moretext2 desi" style="display: none;" id="desc{{$val->id}}"> {{substr(@$val->message,120)}}
						<a class="{{-- moreless-button2 --}}  allread" style="display: none;" onclick="readless({{$val->id}})" id="rrr{{$val->id}}">Read less -</a>
					</p>
				</td>


				<td class="reviews-lists">
					<div class="add_ttrr actions-main ">
						<a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
						<div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
						<ul>
							<li><a onclick=" return confirm('Are you sure want to delete this review ?')?dlt({{$val->id}}):'';">Delete</a></li>

						</ul>
					</div>
					{{-- <div class="add_ttrr actions-main"> --}}
						{{-- <a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
						<div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
						<ul> --}}
							{{--  <li><a href="{{route('aced.edit.page',$val->id)}}">Edit</a></li>
							<li><a onclick="return confirm('Are you sure want to delete this?')" href="{{route('aced.dlt',$val->id)}}">Delete</a></li> --}}
						{{-- </ul>
						--}}

					</div></td>
				</tr>


				@endforeach

			</tbody>
		</table>

	</div>
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

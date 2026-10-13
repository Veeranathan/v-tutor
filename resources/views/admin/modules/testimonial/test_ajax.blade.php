<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<div class="table-responsive">
	{{-- start --}}
  <table id="example2" class="cell-border table table-responsive">
                      <thead>
                        <tr>

                          <th >Name </th>
                          <th >Email</th>
                          <th >Phone</th>
                          <th >Location </th>
                          <th >Rating </th>
                          <th >Status </th>

                          <th> </th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach($test as $key=> $val)
                        <tr id="data{{$val->id}}">

                          <td data-label="Name">
                            {{@$val->name}}
                          </td>
                          <td data-label="Name">
                            {{@$val->email}}
                          </td>
                          <td data-label="Name">
                            {{@$val->phone}}
                          </td>
                          <td data-label="Name">
                               {{@$val->location}}
                          </td>
                          <td data-label="Name">
                               {{@$val->rating}}
                          </td>
                          <td data-label="Name">
                            @if($val->status=="A")
                            Active
                            @else
                            Inactive
                            @endif
                          </td>




                          {{--  <td data-label="Name">{{@$val->message}}</td> --}}



                          <td class="reviews-lists">
                            <div class="add_ttrr actions-main ">
                              <a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
                              <div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
                              <ul>
                                <li><a onclick="return confirm('Are you sure want to delete this testimonial?');" href="{{route('del.test',$val->id)}}">Delete</a></li>
                                @if($val->status=="A")
                                <li><a onclick=" return confirm('Are you sure want to inactive this testimonial ?');"href="{{route('inactive.test',$val->id)}}" >Inactive</a></li>
                                @else
                                <li><a onclick=" return confirm('Are you sure want to active this testimonial ?');"href="{{route('active.test',$val->id)}}" >Active</a></li>
                                @endif
                                <li><a href="{{route('edit.test',$val->id)}}" >Edit</a></li>
                                <li><a href="{{route('view.test',$val->id)}}" >View</a></li>

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

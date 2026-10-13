<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<div class="table-responsive">
	{{-- start --}}
	 <table id="example2" class="cell-border table table-responsive">
                      <thead>
                        <tr>

                         <th >Questions </th>
                          <th >User Type </th>
                          <th >Status </th>
                         <th >Display Order </th>
                          <th >Date </th>

                          <th> </th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach($faqs as $key=> $val)
                        <tr id="data{{$val->id}}">

                          <td data-label="Name">
                            {{@$val->question}}
                          </td>
                            <td data-label="Name">
                            @if($val->user_type=="T")
                            Tutor
                            @else
                            Student
                            @endif
                          </td>
                            <td data-label="Name">
                            @if($val->status=="A")
                            Active
                            @else
                            Inactive
                            @endif
                          </td>
                          <td data-label="Name">
                            {{@$val->display_order}}
                          </td>
                          <td data-label="Name">{{date('d.m.Y', strtotime(@$val->updated_at))}} </td>


                          {{--  <td data-label="Name">{{@$val->message}}</td> --}}



                          <td class="reviews-lists">
                            <div class="add_ttrr actions-main ">
                              <a href="javascript:void(0);" class="action-dots"  id="action{{$val->id}}"><img src="{{ public_asset('assets/images/action-dots.png')}}" alt="" onclick="fun({{$val->id}})"></a>
                              <div class="show-actions" id="show-action{{$val->id}}" style="display: none;"> <span class="angle"><img src="{{ public_asset('assets/images/angle.png')}}" alt=""></span>
                              <ul>
                                <li><a onclick="return confirm('Are you sure want to delete this FAQ?');" href="{{route('del.faq',$val->id)}}">Delete</a></li>

                                @if($val->status=="A")
                                <li><a onclick=" return confirm('Are you sure want to deactivate this FAQ ?');"href="{{route('inactive.faq',$val->id)}}" >Deactivate</a></li>
                                @else
                                <li><a onclick=" return confirm('Are you sure want to activate this FAQ ?');"href="{{route('active.faq',$val->id)}}" >Activate</a></li>

                                @endif
                                 {{-- <li><a href="{{route('edit.faq',$val->id)}}" >Edit</a></li> --}}
                                  <li><a href="{{route('view.faq',$val->id)}}" >View/Edit</a></li>




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
      "pageLength": 5,
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

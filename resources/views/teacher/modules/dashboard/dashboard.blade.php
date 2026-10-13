{{-- @extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Teacher Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    You are logged in! {{Auth()->user()->email}}
                    <a class="list-group-item-action left-nav" href="{{ route('logout') }}"
                        }
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        &nbsp;Logout
                    </a>
                    <form id="logout-form-top" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

{{-- @extends('layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">User Dashboard</div>
        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          You are logged in! {{Auth()->user()->email}}
          <a class="list-group-item-action left-nav" href="{{ route('logout') }}"
            }
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
            &nbsp;Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
--}}
@extends('layouts.app')
@section('title')
<title>V-Tutor  | Tutor | Home</title>
@endsection
@section('left_part')
@include('include.header_menu_part')
@endsection
<style type="text/css">
    .redBorder{
        border-color: #b80f0ab3 !important;
    }
</style>

@section('content')
<!-- bannersec -->
<!-- bannersec -->
  <!-- bannersec -->
    <div class="top_mar"></div>
    <!--- profile --->
     <!--- profile --->
    <section class="user-account">
        <div class="container">
            <div class="row">
                <div class="zin">
                      @include('include.teacher_left_common'){{-- left common part --}}

                    <div class="user-right-panel @if(@Auth::user()->status == 'AA')addDisablePhone pointerEventsNone @endif">
                       <div class="user-right-top pb-50">
                            <h2 class="profile-heading">My Dashboard</h2>
                            <p class="mb-3">You can find information dashboard in this section</p>

                            <div class="user-account-info boxx_size_n01">
                                {{-- <div class="extra-dashs">
                                </div> --}}
                                <div class="row">
                                <div class="col-sm-6 col-12">

                                    <div class="dashboxitm redBorder">
                                        <div class="media">
                                            <div class="meadia-img">
                                                {{-- <img src="{{ public_asset('assets/images/dash-ic1.png')}}"> --}}

                                            </div>
                                            <div class="meadia-body">

                                                <h6>Sessions by Type  </h6>
                                                @if(@$total_classes > 0)

                                                <div id="piechart" class=""></div>
                                                @else

                                                <li>No data to display</li>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm redBorder">
                                        <div class="media">
                                            <div class="meadia-img">
                                                {{-- <img src="{{ public_asset('assets/images/dash-ic1.png')}}"> --}}
                                            </div>
                                            <div class="meadia-body">
                                                <h6>Sessions by Student </h6>
                                                @if(count(@$top_tutors) > 0)
                                                <div id="chart" class=""></div>
                                                @else
                                                <li>No data to display</li>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm redBorder">
                                        <div class="media">
                                            <div class="meadia-img">
                                                {{-- <img src="{{ public_asset('assets/images/dash-ic1.png')}}"> --}}
                                            </div>
                                            <div class="meadia-body">
                                                <h6>Hours by Student</h6>
                                                @if(count(@$top_5_no_of_hours_per_tutor) > 0)
                                                <div id="top_5_no_of_hours_per_tutor" class=""></div>
                                                @else
                                                <li>No data to display</li>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm redBorder">
                                        <div class="media">
                                            <div class="meadia-img">
                                                {{-- <img src="{{ public_asset('assets/images/dash-ic1.png')}}"> --}}
                                            </div>
                                            <div class="meadia-body">
                                                <h6>Subject by Sessions </h6>
                                                @if(count(@$sub_learn_sessions) > 0)
                                                <div id="sub_learn_sessions" class=""></div>
                                                @else
                                                <li>No data to display</li>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm redBorder">
                                        <div class="media">
                                            <div class="meadia-img">
                                                {{-- <img src="{{ public_asset('assets/images/dash-ic14.png')}}"> --}}
                                            </div>
                                            <div class="meadia-body">
                                                <h6>Hours by Subjects </h6>
                                                @if(count(@$tot_hr_by_sub) > 0)
                                                <div id="tot_hr_by_sub" class=""></div>
                                                @else
                                                <li>No data to display</li>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm redBorder">
                                        <div class="media">
                                            <div class="meadia-img">
                                                {{-- <img src="{{ public_asset('assets/images/dash-ic3.png')}}"> --}}
                                            </div>
                                            <div class="meadia-body">
                                                <h6>Earning by Subjects</h6>
                                                {{-- <div class="demo-section k-content wide"> --}}
                                                    @if(count(@$payments_by_subjects) > 0)
                                                    <div id="payments_by_subjects" class=""></div>
                                                    @else
                                                    <li>No data to display</li>
                                                    @endif
                                                {{-- </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm redBorder">
                                        <div class="media">
                                            {{-- <div class="meadia-img"> --}}
                                                {{-- <img src="{{ public_asset('assets/images/dash-ic3.png')}}"> --}}
                                            {{-- </div> --}}
                                                <div class="meadia-body">
                                                    <h6> Review by Sessions </h6>
                                                    {{-- <div class="demo-section k-content wide"> --}}

                                                    {{-- </div> --}}
                                                </div>
                                                @if(@$rev_pe->count() > 0)
                                                    <div id="rev_pe" class="">
                                                @else
                                                    <li>No data to display</li>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            </div>

                            <div class="user-account-info">
                                <div class="extra-dashs">
                                </div>
                                <div class="row">

                                </div>
                            </div>

                            <div class="user-account-info">
                                <div class="extra-dashs">
                            </div>
                                <div class="row">

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
@include('include.footer')
@endsection
@section('script')
@include('include.script')
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.1109/styles/kendo.default-v2.min.css"/>

    <script src="https://kendo.cdn.telerik.com/2021.3.1109/js/kendo.all.min.js"></script>
    {{-- class by type pie chart --}}
    {{-- <script>
        function createChart() {
            $("#piechart").kendoChart({
                title: {
                    position: "bottom",
                    text: "Class by type"
                },
                legend: {
        position: "bottom"
      },
                chartArea: {
                    background: ""
                },
                seriesDefaults: {
                    labels: {
                        visible: true,
                        background: "transparent",
                        position: "insideEnd",
                        color:"black",
                        template: "#= category #: \n #= value#%"
                    }
                },
                series: [{
                    type: "pie",
                    startAngle: 150,
                    data: [{
                        category: "Booked({{ @$count_booked_classes }})",
                        value: {{ number_format(@$booked_classes,2) }},
                        color: "#0099FF"
                    },{
                        category: "Completed({{ @$count_completed_classes }})",
                        value: {{ number_format(@$completed_classes,2) }},
                        color: "#669900"
                    },{
                        category: "Cancelled({{ @$count_cancelled_classes }})",
                        value: {{ number_format(@$cancelled_classes,2) }},
                        color: "#CC3300"
                    }]
                }],
                tooltip: {
                    visible: true,
                    format: "{0}%"
                }
            });
        }

        $(document).ready(createChart);
        $(document).bind("kendo:skinChange", createChart);
    </script> --}}

    {{-- Number of Classes bar chart--}}
    {{-- <script>

    $("#chart").kendoChart({
        legend: {
        position: "bottom"
      },
     categoryAxis: [
    { name: "month", categories: ["{{@$top_tutors[0]->getStudent->f_name }} {{@$top_tutors[0]->getStudent->l_name }}","{{@$top_tutors[1]->getStudent->f_name }} {{@$top_tutors[1]->getStudent->l_name }}","{{@$top_tutors[2]->getStudent->f_name }} {{@$top_tutors[2]->getStudent->l_name }}","{{@$top_tutors[3]->getStudent->f_name }} {{@$top_tutors[3]->getStudent->l_name }}","{{@$top_tutors[4]->getStudent->f_name }} {{@$top_tutors[5]->getStudent->l_name }}"] ,labels: {
                rotation: {
                    angle: 45
                }
            }}
  ],
  series: [
    {
        name: "Tutor Name",
        autoFit: true,
         field: "value",
        colorField: "valueColor",categoryAxis: "month", data: [
        @if(@$top_tutors)
        @foreach(@$top_tutors as $key=>$tutor)
         { value: {{(float) number_format(((@$tutor->count_booking/@$tot_count_booking)*100),2) }},
         category: "{{ @$tutor->getStudent->f_name }} {{ @$tutor->getStudent->l_name }}({{ @$tutor->count_booking }})",
         @if($key == 0)
          valueColor:"#66FF33"
          @endif
          @if($key == 1)
          valueColor:"#00CCFF"
          @endif
          @if($key == 2)
          valueColor:"#CC9900"
          @endif
          @if($key == 3)
          valueColor:"#CC6600"
          @endif
          @if($key == 4)
          valueColor:"#CC66CC"
          @endif
            },
         @endforeach
        @endif] }
  ]
      // series: [{
      //   colorField: "valueColor",
      //   data: [
      //   @if(@$top_tutors)
      //   @foreach(@$top_tutors as $key=>$tutor)
      //    { value: {{(float) number_format(((@$tutor->count_booking/@$tot_count_booking)*100),2) }},
      //    category: "{{ @$tutor->getStudent->f_name }} {{ @$tutor->getStudent->l_name }}({{ @$tutor->count_booking }})",
      //    @if($key == 0)
      //     valueColor:"#66FF33"
      //     @endif
      //     @if($key == 1)
      //     valueColor:"#00CCFF"
      //     @endif
      //     @if($key == 2)
      //     valueColor:"#CC9900"
      //     @endif
      //     @if($key == 3)
      //     valueColor:"#CC6600"
      //     @endif
      //     @if($key == 4)
      //     valueColor:"#CC66CC"
      //     @endif
      //       },
      //    @endforeach
      //   @endif
      //   ]
      // }],

      // categoryAxis: {
      //       field: "category",
      //       labels: {
      //           rotation: {
      //               angle: 45
      //           }
      //       }
      //     },
      //     tooltip: {
      //       visible: true,
      //       format: "{0}",
      //       template: "#= series.name #: #= value #"
      //     }
    });
</script> --}}
{{-- end of no of classes --}}
{{-- <script>

    $("#top_5_no_of_hours_per_tutor").kendoChart({
        legend: {
        position: "bottom"
      },
     categoryAxis: [
    { name: "month", categories: ["{{@$top_5_no_of_hours_per_tutor[0]->getStudent->f_name }} {{@$top_5_no_of_hours_per_tutor[0]->getStudent->l_name }}","{{@$top_5_no_of_hours_per_tutor[1]->getStudent->f_name }} {{@$top_5_no_of_hours_per_tutor[1]->getStudent->l_name }}","{{@$top_5_no_of_hours_per_tutor[2]->getStudent->f_name }} {{@$top_5_no_of_hours_per_tutor[2]->getStudent->l_name }}","{{@$top_5_no_of_hours_per_tutor[3]->getStudent->f_name }} {{@$top_5_no_of_hours_per_tutor[3]->getStudent->l_name }}","{{@$top_5_no_of_hours_per_tutor[4]->getStudent->f_name }} {{@$top_5_no_of_hours_per_tutor[5]->getStudent->l_name }}"] ,labels: {
                rotation: {
                    angle: 45
                }
            }}
  ],
  series: [
    {
        name: "Tutor Name",
        autoFit: true,
         field: "value",
        colorField: "valueColor",categoryAxis: "month", data: [
        @if(@$top_5_no_of_hours_per_tutor)
        @foreach(@$top_5_no_of_hours_per_tutor as $key=>$tutor)
         { value: {{(float) number_format(((@$tutor->shift_length)*100),2) }},
            category: "{{ @$tutor->getStudent->f_name }} {{ @$tutor->getStudent->l_name }}({{ @$tutor->shift_length }})",
         @if($key == 0)
          valueColor:"#66FF33"
          @endif
          @if($key == 1)
          valueColor:"#00CCFF"
          @endif
          @if($key == 2)
          valueColor:"#CC9900"
          @endif
          @if($key == 3)
          valueColor:"#CC6600"
          @endif
          @if($key == 4)
          valueColor:"#CC66CC"
          @endif
            },
         @endforeach
        @endif] }
  ]
      // series: [{
      //   colorField: "valueColor",
      //   data: [
      //   @if(@$top_tutors)
      //   @foreach(@$top_tutors as $key=>$tutor)
      //    { value: {{(float) number_format(((@$tutor->count_booking/@$tot_count_booking)*100),2) }},
      //    category: "{{ @$tutor->getStudent->f_name }} {{ @$tutor->getStudent->l_name }}({{ @$tutor->count_booking }})",
      //    @if($key == 0)
      //     valueColor:"#66FF33"
      //     @endif
      //     @if($key == 1)
      //     valueColor:"#00CCFF"
      //     @endif
      //     @if($key == 2)
      //     valueColor:"#CC9900"
      //     @endif
      //     @if($key == 3)
      //     valueColor:"#CC6600"
      //     @endif
      //     @if($key == 4)
      //     valueColor:"#CC66CC"
      //     @endif
      //       },
      //    @endforeach
      //   @endif
      //   ]
      // }],

      // categoryAxis: {
      //       field: "category",
      //       labels: {
      //           rotation: {
      //               angle: 45
      //           }
      //       }
      //     },
      //     tooltip: {
      //       visible: true,
      //       format: "{0}",
      //       template: "#= series.name #: #= value #"
      //     }
    });
</script> --}}
{{-- sub_learn_sessions bar chart --}}
{{-- <script>
    function createChart() {
        $("#sub_learn_sessions").kendoChart({
            title: {
                position: "bottom",
                text: " "
            },
            legend: {
        position: "bottom"
      },
            chartArea: {
                background: ""
            },
            seriesDefaults: {
                type: "pie",
                startAngle: 150
            },
            series: [{
                name: "Student Name",
                data: [
                    @if(@$sub_learn_sessions)
                    @foreach(@$sub_learn_sessions as $key=>$tutor)
                    {
                        category: "{{ @$tutor->getSubject->subject }}( total : {{ @$tutor->count_booking }})",
                        value: {{ number_format(((@$tutor->count_booking/@$tot_sub_learn_sessions)*100),2) }},
                        @if($key == 0)
                    color:"#0099FF",
                    @endif
                    @if($key == 1)
                    color:"#669900",
                    @endif
                    @if($key == 2)
                    color:"#CC3300",
                    @endif
                    @if($key == 3)
                    color:"red",
                    @endif
                    @if($key == 4)
                    color:"green",
                    @endif
                    }
                    @if($key <= 4),@endif
                    @endforeach
                    @endif
                ],
                labels: {
                    visible: true,
                    // background: "red",
                    // color:"white",
                    position: "insideEnd",
                    template: "#= category #: \n #= value#%"
                },
      autoFit: true

            }],
            tooltip: {
                visible: true,
                template: "#= category # (#= series.name #): #= value #%"
            }
        });
    }
    $(document).ready(createChart);
    $(document).bind("kendo:skinChange", createChart);
</script> --}}
{{-- payments_by_subjects pie chart --}}
{{-- <script>
    function createChart() {
        $("#payments_by_subjects").kendoChart({
            title: {
                position: "bottom",
                text: " "
            },
            legend: {
        position: "bottom"
      },
            chartArea: {
                background: ""
            },
            seriesDefaults: {
                type: "pie",
                startAngle: 150
            },
            series: [{
                name: " ",
                data: [
                @if(@$payments_by_subjects)
                    @foreach(@$payments_by_subjects as $key=>$s)
                {
                    category: "{{ @$s->getSubject->subject }}(total : {{ @$s->total_payments_by_subjects }})",
                    value: {{ number_format(((@$s->total_payments_by_subjects/@$total_payments_by_subjects)*100),2) }},
                    @if($key == 0)
                    color:"#0099FF",
                    @endif
                    @if($key == 1)
                    color:"#669900",
                    @endif
                    @if($key == 2)
                    color:"#CC3300",
                    @endif
                    @if($key == 3)
                    color:"red",
                    @endif
                    @if($key == 4)
                    color:"green",
                    @endif
                }
                @if($key <= 4),@endif
                @endforeach
                @endif
                ],
                labels: {
                    visible: true,
                    // background: "red",
                    // color:"white",
                    position: "insideEnd",
                    template: "#= category #: \n #= value#%"
                },
      autoFit: true
            }],
            tooltip: {
                visible: true,
                template: "#= category # (#= series.name #): #= value #%"
            }
        });
    }

    $(document).ready(createChart);
    $(document).bind("kendo:skinChange", createChart);
</script> --}}
    {{-- tot_hr_by_sub pie chart --}}
{{-- <script>
    function createChart() {
        $("#tot_hr_by_sub").kendoChart({
            title: {
                position: "bottom",
                text: ""
            },
            legend: {
        position: "bottom"
      },
            chartArea: {
                background: ""
            },
            seriesDefaults: {
                type: "pie",
                startAngle: 150
            },
            series: [{
                name: " ",
                data: [
                @if(@$tot_hr_by_sub)
                @foreach(@$tot_hr_by_sub as $key=>$s)
                {
                    category: "{{ @$s->getSubject->subject }}(total : {{ @$s->shift_length }})",
                    value: {{ number_format(((@$s->shift_length/@$tot_tot_hr_by_sub)*100),2) }},
                    @if($key == 0)
                    color:"#0099FF",
                    @endif
                    @if($key == 1)
                    color:"#669900",
                    @endif
                    @if($key == 2)
                    color:"#CC3300",
                    @endif
                    @if($key == 3)
                    color:"red",
                    @endif
                    @if($key == 4)
                    color:"green",
                    @endif
                }
                @if($key <= 4),@endif
                @endforeach

                @endif
                ],
                labels: {
                    visible: true,
                    // background: "red",
                // color:"white",
                    position: "insideEnd",
                    template: "#= category #: \n #= value#%"
                },
      autoFit: true
            }],
            tooltip: {
                visible: true,
                template: "#= category # (#= series.name #): #= value #%"
            }
        });
    }

    $(document).ready(createChart);
    $(document).bind("kendo:skinChange", createChart);
</script> --}}
    {{-- earn_by_subject  --}}
    {{-- <script>
        function createChart() {
            $("#earn_by_subject").kendoChart({
                title: {
                    position: "bottom",
                    text: ""
                },
                legend: {
        position: "bottom"
      },
                chartArea: {
                    background: ""
                },
                seriesDefaults: {
                    type: "pie",
                    startAngle: 150
                },
                series: [{
                    name: "",
                    data: [
                    @if(@$tot_hr_by_sub)
                        @foreach(@$tot_hr_by_sub as $key=>$s)
                    {
                        category: "{{ @$s->getSubject->subject }}(total : {{ @$s->shift_length }})",
                        value: {{ @$s->shift_length }},
                        @if($key == 0)
                        color:"#0099FF",
                        @endif
                        @if($key == 1)
                        color:"#669900",
                        @endif
                        @if($key == 2)
                        color:"#CC3300",
                        @endif
                        @if($key == 3)
                        color:"red",
                        @endif
                        @if($key == 4)
                        color:"green",
                        @endif
                    }
                    @if($key <= 4),@endif
                    @endforeach
                    @endif
                    ],
                    labels: {
                        visible: true,
                        // background: "red",
                    // color:"white",
                        position: "insideEnd",
                        template: "#= category #: \n #= value#%"
                    },
          autoFit: true
                }],
                tooltip: {
                    visible: true,
                    template: "#= category # (#= series.name #): #= value #%"
                }
            });
        }
        $(document).ready(createChart);
        $(document).bind("kendo:skinChange", createChart);
    </script> --}}
    {{-- rev_pe --}}
    <script>
        function createChart() {
            $("#rev_pe").kendoChart({
                title: {
                    position: "bottom",
                    text: " "
                },
                legend: {
                    position: "bottom"
                },
                chartArea: {
                    background: ""
                },
                seriesDefaults: {
                    type: "pie",
                    startAngle: 150
                },
                series: [{
                    name: " ",
                    data: [
                    @if(@$rev_pe)
                        @foreach(@$rev_pe as $key=>$s)
                    {
                        category: "Ratings {{ @$s->rating }} ({{ number_format(((@$s->count_n)/(@$tot_rev_pe)*100),2) }}%)Total : {{ @$s->count_n }}",
                        value: {{ number_format(((@$s->count_n)/(@$tot_rev_pe)*100),2) }},
                        @if($key == 0)
                        color:"#0099FF",
                        @endif
                        @if($key == 1)
                        color:"#669900",
                        @endif
                        @if($key == 2)
                        color:"#CC3300",
                        @endif
                        @if($key == 3)
                        color:"red",
                        @endif
                        @if($key == 4)
                        color:"green",
                        @endif
                    }
                    @if($key <= 4),@endif
                    @endforeach
                    @endif
                    ],
                    labels: {
                        visible: true,
                        color:"black",
                        position: "insideEnd",
                        template: "#= value#%"
                        // template: "#= category #: \n #= value#%"
                    },
                    autoFit: true
                }],
                tooltip: {
                    visible: true,
                    template: "#= category # (#= series.name #): #= value #%"
                }
            });
        }
        $(document).ready(createChart);
        $(document).bind("kendo:skinChange", createChart);
    </script>
{{-- new charts --}}
{{-- class by type pie chart --}}
@if(@$total_classes > 0)
<script>
        function createChart() {
            $("#piechart").kendoChart({
                title: {
                    position: "top",
                    text: ""
                },
                legend: {
                    position: "bottom"
                },
                chartArea: {
                    background: ""
                },
                seriesDefaults: {
                    labels: {
                        visible: true,
                        background: "transparent",
                        position: "insideEnd",
                        color:"black",
                        template: "#= value#%"
                        // \n #= value#%
                    }
                },
                series: [{
                    type: "pie",
                    startAngle: 150,
                    data: [
                    {
                        category: "Booked ({{ number_format(@$booked_classes,2) }}%) Total {{ @$count_booked_classes }}",
                        value: {{ number_format(@$booked_classes,2) }},
                        color: "#0099FF"
                    },
                    {
                        category: "Completed ({{ number_format(@$completed_classes,2) }}%) Total {{ @$count_completed_classes }}",
                        value: {{ number_format(@$completed_classes,2) }},
                        color: "#669900"
                    },
                    {
                        category: "Cancelled ({{ number_format(@$cancelled_classes,2) }}%) Total {{ @$count_cancelled_classes }}",
                        value: {{ number_format(@$cancelled_classes,2) }},
                        color: "#CC3300"
                    }]
                }],
                tooltip: {
                    visible: true,
                    template: "#= category #",
                    format: "{0}%"
                }
            });
        }

        $(document).ready(createChart);
        $(document).bind("kendo:skinChange", createChart);
</script>
@endif
{{-- Sessions by Tutor bar chart --}}
<script>
    $("#chart").kendoChart({
        valueAxis: {
            majorUnit: 10,
            max: 100,
            min: 0
        },
        legend: {
            position: "bottom"
        },
        categoryAxis: [
        {
            name: "name",
            categories: [
            "{{@$top_tutors[0]->getStudent->f_name }} {{@$top_tutors[0]->getStudent->l_name }}",
            "{{@$top_tutors[1]->getStudent->f_name }} {{@$top_tutors[1]->getStudent->l_name }}",
            "{{@$top_tutors[2]->getStudent->f_name }} {{@$top_tutors[2]->getStudent->l_name }}",
            "{{@$top_tutors[3]->getStudent->f_name }} {{@$top_tutors[3]->getStudent->l_name }}",
            "{{@$top_tutors[4]->getStudent->f_name }} {{@$top_tutors[5]->getStudent->l_name }}"
            ] ,labels: {
                rotation: {
                    angle: 45
                }
            }
        }
        ],
        series: [
            {
                name: "Student Name",
                color:"#66FF33",
                autoFit: true,
                field: "value",
                colorField: "valueColor",
                categoryAxis: "name",
                noteTextField: "noteText",
                notes: {
                  icon: {
                    border: {
                      width: 1,
                      color: "transparent"
                    }
                  }
                },
                data: [
                @if(@$top_tutors)
                @foreach(@$top_tutors as $key=>$tutor)
                {
                    value: {{(float) number_format(((@$tutor->count_booking)),0) }},
                    noteText: "{{(float) number_format(((@$tutor->count_booking)),0) }}",
                    category: "{{ @$tutor->getStudent->f_name }} {{ @$tutor->getStudent->l_name }} ({{ @$tutor->count_booking }})",
                    @if($key == 0)
                    valueColor:"#66FF33"
                    @endif
                    @if($key == 1)
                    valueColor:"#00CCFF"
                    @endif
                    @if($key == 2)
                    valueColor:"#CC9900"
                    @endif
                    @if($key == 3)
                    valueColor:"#CC6600"
                    @endif
                    @if($key == 4)
                    valueColor:"#CC66CC"
                    @endif
                },
                @endforeach
                @endif
                ]
            }
      ],
    tooltip:
    {
        visible: true,
        template: "#= category #\n #= value#",
        format: "{0}"
    }
    });
</script>
{{-- Hours by Tutor bar chart--}}
<script>
    $("#top_5_no_of_hours_per_tutor").kendoChart({
        valueAxis: {
            majorUnit: 10,
            max: 100,
            min: 0
        },
        legend: {
            position: "bottom"
        },
        categoryAxis: [
        {
            name: "name",
            categories: [
            "{{@$top_5_no_of_hours_per_tutor[0]->getStudent->f_name }} {{@$top_5_no_of_hours_per_tutor[0]->getStudent->l_name }}",
            "{{@$top_5_no_of_hours_per_tutor[1]->getStudent->f_name }} {{@$top_5_no_of_hours_per_tutor[1]->getStudent->l_name }}",
            "{{@$top_5_no_of_hours_per_tutor[2]->getStudent->f_name }} {{@$top_5_no_of_hours_per_tutor[2]->getStudent->l_name }}",
            "{{@$top_5_no_of_hours_per_tutor[3]->getStudent->f_name }} {{@$top_5_no_of_hours_per_tutor[3]->getStudent->l_name }}",
            "{{@$top_5_no_of_hours_per_tutor[4]->getStudent->f_name }} {{@$top_5_no_of_hours_per_tutor[5]->getStudent->l_name }}"
            ] ,labels: {
                rotation: {
                    angle: 45
                }
            }
        }
        ],
        series: [
            {
                name: "Student Name",
                color:"#66FF33",
                autoFit: true,
                field: "value",
                colorField: "valueColor",
                categoryAxis: "name",
                noteTextField: "noteText",
                notes: {
                  icon: {
                    border: {
                      width: 1,
                      color: "transparent"
                    }
                  }
                },
                data: [
                @if(@$top_5_no_of_hours_per_tutor)
                @foreach(@$top_5_no_of_hours_per_tutor as $key=>$tutor)
                {
                    value: "{{(float) number_format(((@$tutor->shift_length)),2) }}",
                    noteText: "{{(float) number_format(((@$tutor->shift_length)),2) }} hrs",
                    category: "{{ @$tutor->getStudent->f_name }} {{ @$tutor->getStudent->l_name }}",
                    @if($key == 0)
                    valueColor:"#66FF33"
                    @endif
                    @if($key == 1)
                    valueColor:"#00CCFF"
                    @endif
                    @if($key == 2)
                    valueColor:"#CC9900"
                    @endif
                    @if($key == 3)
                    valueColor:"#CC6600"
                    @endif
                    @if($key == 4)
                    valueColor:"#CC66CC"
                    @endif
                },
                @endforeach
                @endif
                ]
            }
      ],
        tooltip:
        {
            visible: true,
            template: "#= category #\n #= value#",
            format: "{0}"
        }
    });
</script>
@if(@$total_classes > 0)
{{-- Subject by Sessions pie chart --}}
<script>
        function createChart() {
            $("#sub_learn_sessions").kendoChart({
                title: {
                    position: "top",
                    text: ""
                },
                legend: {
                    position: "bottom"
                },
                chartArea: {
                    background: ""
                },
                seriesDefaults: {
                    labels: {
                        visible: true,
                        background: "transparent",
                        position: "insideEnd",
                        color:"black",
                        template: "#= value#%"
                        // template: "#= category #: \n #= value#%"
                    }
                },
                series: [{
                    type: "pie",
                    startAngle: 150,
                    data: [
                    @if(@$sub_learn_sessions)
                    @foreach(@$sub_learn_sessions as $key=>$tutor)
                    {
                        category: "{{ @$tutor->getSubject->subject }} ({{ number_format(((@$tutor->count_booking/@$tot_sub_learn_sessions)*100),2) }}%) Total : {{ @$tutor->count_booking }}",
                        value: {{ number_format(((@$tutor->count_booking/@$tot_sub_learn_sessions)*100),2) }},
                        @if($key == 0)
                        color:"#0099FF",
                        @endif
                        @if($key == 1)
                        color:"#669900",
                        @endif
                        @if($key == 2)
                        color:"#CC3300",
                        @endif
                        @if($key == 3)
                        color:"red",
                        @endif
                        @if($key == 4)
                        color:"green",
                        @endif
                    }
                    @if($key <= 4),@endif
                    @endforeach
                    @endif
                    ]
                }],
                tooltip:
                {
                    visible: true,
                    template: "#= category #",
                    format: "{0}%"
                }
            });
        }
        $(document).ready(createChart);
        $(document).bind("kendo:skinChange", createChart);
</script>
@endif
@if(@$total_classes > 0)
{{-- tot_hr_by_sub pie chart--}}
<script>
        function createChart() {
            $("#tot_hr_by_sub").kendoChart({
                title: {
                    position: "top",
                    text: ""
                },
                legend: {
                    position: "bottom"
                },
                chartArea: {
                    background: ""
                },
                seriesDefaults: {
                    labels: {
                        visible: true,
                        background: "transparent",
                        position: "insideEnd",
                        color:"black",
                        template: "#= value#%"
                        // template: "#= category #: \n #= value#%"
                    }
                },
                series: [{
                    type: "pie",
                    startAngle: 150,
                    data: [
                    @if(@$tot_hr_by_sub)
                    @foreach(@$tot_hr_by_sub as $key=>$s)
                    {
                        category: "{{ @$s->getSubject->subject }} ({{ number_format(((@$s->shift_length/@$tot_tot_hr_by_sub)*100),2) }}%) Total : {{ number_format(@$s->shift_length,1) }} hrs",
                        value: {{ number_format(((@$s->shift_length/@$tot_tot_hr_by_sub)*100),2) }},
                        @if($key == 0)
                        color:"#0099FF",
                        @endif
                        @if($key == 1)
                        color:"#669900",
                        @endif
                        @if($key == 2)
                        color:"#CC3300",
                        @endif
                        @if($key == 3)
                        color:"red",
                        @endif
                        @if($key == 4)
                        color:"green",
                        @endif
                    }
                    @if($key <= 4),@endif
                    @endforeach
                    @endif
                    ]
                }],
                tooltip:
                {
                    visible: true,
                    template: "#= category #",
                    format: "{0}%"
                }
            });
        }
        $(document).ready(createChart);
        $(document).bind("kendo:skinChange", createChart);
</script>
@endif
@if(@$total_classes > 0)
{{-- payments_by_subjects pie chart --}}
<script>
        function createChart() {
            $("#payments_by_subjects").kendoChart({
                title: {
                    position: "top",
                    text: ""
                },
                legend: {
                    position: "bottom"
                },
                chartArea: {
                    background: ""
                },
                seriesDefaults: {
                    labels: {
                        visible: true,
                        background: "transparent",
                        position: "insideEnd",
                        color:"black",
                        template: "#= value#%"
                        // template: "#= category #: \n #= value#%"
                    }
                },
                series: [{
                    type: "pie",
                    startAngle: 150,
                    data: [
                    @if(@$payments_by_subjects)
                    @foreach(@$payments_by_subjects as $key=>$s)
                {
                    category: "{{ @$s->getSubject->subject }} ({{ number_format(((@$s->total_payments_by_subjects/@$total_payments_by_subjects)*100),2) }}%) Total : ${{ @$s->total_payments_by_subjects }}",
                    value: {{ number_format(((@$s->total_payments_by_subjects/@$total_payments_by_subjects)*100),2) }},
                    @if($key == 0)
                    color:"#0099FF",
                    @endif
                    @if($key == 1)
                    color:"#669900",
                    @endif
                    @if($key == 2)
                    color:"#CC3300",
                    @endif
                    @if($key == 3)
                    color:"red",
                    @endif
                    @if($key == 4)
                    color:"green",
                    @endif
                }
                @if($key <= 4),@endif
                @endforeach
                @endif
                    ]
                }],
                tooltip:
                {
                    visible: true,
                    template: "#= category #",
                    format: "{0}%"
                }
            });
        }
        $(document).ready(createChart);
        $(document).bind("kendo:skinChange", createChart);
</script>
@endif
@endsection

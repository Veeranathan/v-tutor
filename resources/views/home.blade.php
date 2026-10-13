@if(@Auth::user()->is_login=="0")
<script>window.location = "{{url('/')}}/my-profile";</script>
@else
@extends('layouts.app')
@section('title')
<title>V-Tutor  | Student | Home </title>
@endsection
@section('left_part')
{{-- @include('include.student_top_common') --}}
@include('include.header_menu_part')
<style type="text/css">
    .redBorder{
        border-color: #b80f0ab3;
    }
</style>
@endsection
@section('content')
<!-- bannersec -->
<div class="top_mar"></div>
<!--- profile --->
<section class="user-account">
    <div class="container">
        <div class="row">
            <div class="zin">
                @include('include.student_left_common'){{-- student left part --}}
                <div class="user-right-panel">
                    <div class="user-right-top ">
                        <h2 class="profile-heading">My Dashboard</h2>
                        <p class="mb-3">You can find information about your sessions and tutors in this section</p>
                        <hr class="das-hr">
                        <div class="user-account-info boxx_size_n01">
                            {{--  --}}

                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm redBorder">

                                        <div class="media">
                                            {{-- <div class="meadia-img"> --}}
                                                {{-- <img src="{{ public_asset('assets/images/dash-ic1.png')}}"> --}}
                                            {{-- </div> --}}
                                            <div class="meadia-body">

                                                <h6>Sessions by Type </h6>
                                            </div>
                                            {{-- @if(@$total_classes > 0) --}}
                                            @if(@$count_booked_classes <= 0 && @$count_completed_classes <= 0 && @$count_cancelled_classes <= 0)
                                                <li>No data to display</li>
                                            @else
                                                <div id="piechart" class=""></div>
                                            @endif
                                            {{-- @else --}}
                                                {{-- <li>No data to display</li> --}}
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm redBorder">
                                        <div class="media">
                                            {{-- <div class="meadia-img"> --}}
                                                {{-- <img src="{{ public_asset('assets/images/dash-ic1.png')}}"> --}}
                                            {{-- </div> --}}
                                            <div class="meadia-body">
                                                <h6>Sessions by Tutor </h6>

                                            </div>
                                            @if(count(@$top_tutors) > 0)
                                            <div id="chart" class=""></div>
                                            @else
                                                <li>No data to display</li>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm redBorder">
                                        <div class="media">
                                            {{-- <div class="meadia-img"> --}}
                                                {{-- <img src="{{ public_asset('assets/images/dash-ic1.png')}}"> --}}
                                            {{-- </div> --}}
                                            <div class="meadia-body">
                                                <h6>Hours by Tutor</h6>

                                            </div>
                                            @if(count(@$top_5_no_of_hours_per_tutor) > 0)
                                            <div id="top_5_no_of_hours_per_tutor" class=""></div>
                                            @else
                                                <li>No data to display</li>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm redBorder">
                                        <div class="media">
                                            {{-- <div class="meadia-img"> --}}
                                                {{-- <img src="{{ public_asset('assets/images/dash-ic1.png')}}"> --}}
                                            {{-- </div> --}}
                                            <div class="meadia-body">
                                                <h6>Subject by Sessions</h6>

                                            </div>
                                            @if(count(@$sub_learn_sessions) > 0)
                                            <div id="sub_learn_sessions" class=""></div>
                                            @else
                                                <li>No data to display</li>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm redBorder">
                                        <div class="media">
                                            {{-- <div class="meadia-img"> --}}
                                                {{-- <img src="{{ public_asset('assets/images/dash-ic14.png')}}"> --}}
                                            {{-- </div> --}}
                                            <div class="meadia-body">
                                                <h6>Hours by Subjects</h6>

                                            </div>
                                            @if(count(@$tot_hr_by_sub) > 0)
                                            <div id="tot_hr_by_sub" class=""></div>
                                            @else
                                                <li>No data to display</li>
                                            @endif

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
                                                <h6>Payment by Subjects</h6>

                                                {{-- <div class="demo-section k-content wide"> --}}
                                                    {{-- <div id="payments_by_subjects" style="background: center no-repeat url('../content/shared/styles/world-map.png');"></div> --}}
                                                {{-- </div> --}}
                                            </div>
                                            @if(count(@$payments_by_subjects) > 0)
                                            <div id="payments_by_subjects" ></div>
                                            @else
                                                <li>No data to display</li>
                                            @endif
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
                                                <h6> Review by Sessions</h6>

                                            </div>
                                            @if(@$total_classes > 0)
                                            <div id="rev_pe_tot_cls" class=""></div>
                                            @else
                                                <li>No data to display</li>
                                            @endif
                                        </div>
                                        {{-- <div class="demo-section k-content wide">
                                            <div id="rev_pe_tot_cls" style="background: center no-repeat url('../content/shared/styles/world-map.png');">
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="user-account-info">

                            <div class="row">


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--- profile --->
@endsection
@section('footer')
@include('include.footer')
@endsection
@section('script')
@include('include.script')
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.1109/styles/kendo.default-v2.min.css"/>
<script src="https://kendo.cdn.telerik.com/2021.3.1109/js/kendo.all.min.js"></script>
{{-- class by type pie chart --}}
{{-- @if(@$total_classes > 0) --}}
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
                    },{
                        category: "Completed ({{ number_format(@$completed_classes,2) }}%) Total {{ @$count_completed_classes }}",
                        value: {{ number_format(@$completed_classes,2) }},
                        color: "#669900"
                    },{
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
{{-- @endif --}}
{{-- Classes by Tutor bar chart --}}
{{-- @if(@$tot_count_booking>0) --}}
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
            "{{@$top_tutors[0]->getTutor->f_name }} {{@$top_tutors[0]->getTutor->l_name }}",
            "{{@$top_tutors[1]->getTutor->f_name }} {{@$top_tutors[1]->getTutor->l_name }}",
            "{{@$top_tutors[2]->getTutor->f_name }} {{@$top_tutors[2]->getTutor->l_name }}",
            "{{@$top_tutors[3]->getTutor->f_name }} {{@$top_tutors[3]->getTutor->l_name }}",
            "{{@$top_tutors[4]->getTutor->f_name }} {{@$top_tutors[4]->getTutor->l_name }}"
            ],
            labels: {
                rotation: {
                    angle: 45
                }
            }
        }
        ],
        series: [
            {
                name: "Tutor Name",
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
                    value: {{(float) number_format(((@$tutor->count_booking)),2) }},
                    noteText: "{{(float) number_format(((@$tutor->count_booking)),0) }}",
                    category: "{{ @$tutor->getTutor->f_name }} {{ @$tutor->getTutor->l_name }} ",
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
{{-- @endif --}}
{{-- Hours by Tutor bar chart--}}
@if(@$tot_top_5_no_of_hours_per_tutor >0)
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
            "{{@$top_5_no_of_hours_per_tutor[0]->getTutor->f_name }} {{@$top_5_no_of_hours_per_tutor[0]->getTutor->l_name }}",
            "{{@$top_5_no_of_hours_per_tutor[1]->getTutor->f_name }} {{@$top_5_no_of_hours_per_tutor[1]->getTutor->l_name }}",
            "{{@$top_5_no_of_hours_per_tutor[2]->getTutor->f_name }} {{@$top_5_no_of_hours_per_tutor[2]->getTutor->l_name }}",
            "{{@$top_5_no_of_hours_per_tutor[3]->getTutor->f_name }} {{@$top_5_no_of_hours_per_tutor[3]->getTutor->l_name }}",
            "{{@$top_5_no_of_hours_per_tutor[4]->getTutor->f_name }} {{@$top_5_no_of_hours_per_tutor[5]->getTutor->l_name }}"
            ] ,labels: {
                rotation: {
                    angle: 45
                }
            }
        }
        ],
        series: [
            {
                name: "Tutor Name",
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
                    value: {{(float) number_format(((@$tutor->shift_length)),2) }},
                    noteText: "{{(float) number_format(((@$tutor->shift_length)),2) }} hrs",

                    category: "{{ @$tutor->getTutor->f_name }} {{ @$tutor->getTutor->l_name }}",
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
@endif
{{-- Subject by Sessions pie chart --}}
@if(@$tot_sub_learn_sessions > 0)
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
                        // template: "#= category #"
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
{{-- tot_hr_by_sub pie chart--}}
@if(@$tot_tot_hr_by_sub > 0)
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
                        // template: "#= category #"
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
{{-- payments_by_subjects pie chart --}}
@if(@$total_payments_by_subjects > 0)
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
                        // template: "#= category #"
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
{{-- rev_pe_tot_cls review percentage total reviews given vs total classes attended --}}
{{-- <script>
    function createChart() {
        $("#rev_pe_tot_cls").kendoChart({
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
                    // background: "red",
                    color:"black",
                    template: "#= category  #: "
                    // template: "#= category  #: \n #= value#%"
                }
            },
            series: [{
                type: "pie",
                startAngle: 150,
                name: "",
                data: [
                {
                    category: "Total Reviews ({{ number_format(((@$total_reviews_given/@$total_classes)*100),2) }}% ) Total {{ number_format(@$total_reviews_given,0) }}",

                    value: {{ number_format(((@$total_reviews_given/@$total_classes)*100),2) }},

                    color: "#0099FF"
                },
                {
                    category: "Total Classes ({{ number_format((((@$total_classes - @$total_reviews_given)/@$total_classes)*100),2) }}% ) Total {{ number_format((@$total_classes - @$total_reviews_given),0) }}",
                    // category: "Total Classes",
                    value: {{ number_format((((@$total_classes - @$total_reviews_given)/@$total_classes)*100),2) }},
                    color: "#669900"
                }

                ],
                labels: {
                    visible: true,
                    color:"black",
                    position: "insideEnd",
                    template: "#= category #: "
                    // template: "#= category #: \n #= value#%"
                },
          autoFit: true
            }],
            tooltip: {
                visible: true,
                template: "#= category # "
                // template: "#= category # (#= series.name #): #= value #%"
            }
        });
    }

    $(document).ready(createChart);
    $(document).bind("kendo:skinChange", createChart);
</script> --}}
@if(@$total_classes > 0)
<script>
        function createChart() {
            $("#rev_pe_tot_cls").kendoChart({
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
                        // template: "#= category #"
                        // \n #= value#%
                    }
                },
                series: [{
                    type: "pie",
                    startAngle: 150,
                    data: [
                    {
                    category: "Total Reviews ({{ number_format(((@$total_reviews_given/@$total_classes)*100),2) }}% ) Total {{ number_format(@$total_reviews_given,0) }}",

                    value: {{ number_format(((@$total_reviews_given/@$total_classes)*100),2) }},

                    color: "#0099FF"
                },
                {
                    category: "Total Sessions({{ number_format((((@$total_classes - @$total_reviews_given)/@$total_classes)*100),2) }}% ) Total {{ number_format((@$total_classes - @$total_reviews_given),0) }}",
                    // category: "Total Classes",
                    value: {{ number_format((((@$total_classes - @$total_reviews_given)/@$total_classes)*100),2) }},
                    color: "#669900"
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
@endsection
@endif

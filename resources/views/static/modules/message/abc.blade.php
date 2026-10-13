<!DOCTYPE html>
<html lang="en">
<head>
    <title id='Description'>jqxScheduler widget displays a set of Appointments in Day, Week, Month, Timeline Day, Timeline Week and Timeline Month views
    </title>
     {{-- <link rel="stylesheet" href="../../jqwidgets/styles/jqx.base.css" type="text/css" /> --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 minimum-scale=1" />
    {{-- <script type="text/javascript" src="../../scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxdate.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxscheduler.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxscheduler.api.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxtooltip.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxnumberinput.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxradiobutton.js"></script>
    <script type="text/javascript" src="../../jqwidgets/jqxinput.js"></script>
    <script type="text/javascript" src="../../jqwidgets/globalization/globalize.js"></script>
    <script type="text/javascript" src="../../jqwidgets/globalization/globalize.culture.de-DE.js"></script>
    <script type="text/javascript" src="../../scripts/demos.js"></script> --}}
    <script src="{{ public_asset('assets/js/jquerymin.js') }}"></script>
    <script src="https://jqwidgets.com/public/jqwidgets/jqx-all.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jqwidgets.com/public/jqwidgets/styles/jqx.base.css">
    <script type="text/javascript">
        $(document).ready(function () {

           var d = new Date();
           var n = d.getDay();
          //console.log(n);//5=friday

// var date = new Date();
// var k=date. setDate(date. getDate() + 7);
// console. log(date);


   var appointments = new Array();
@php

@endphp

 @for($i=94;$i>=0;$i--)

      //   echo date('Y-m-d', strtotime("+".$i." days")) .'<br>';
      //   echo date('d', strtotime("+".$i." days")) .'<br>';
      // }
      @if(date('w', strtotime("+".$i."days"))=="1")

@foreach($availability_mon as $val)

@php
$chkMon=1;
@endphp

@foreach(@$val->getBook as $item)
  @if( $item->booking_date==date('Y-m-d', strtotime("+".$i."days")) )
      @php
       $chkMon=0;
      @endphp
  @endif
@endforeach

@if($chkMon==1)
@php
$from=explode(":",$val->from_time);
$to=explode(":",$val->to_time);
//dd($from,$to);
$val['av_from_hour']=$from[0];
$val['av_from_min']=$from[1];

$val['av_to_hour']=$to[0];
$val['av_to_min']=$to[1];
@endphp




        var monday{{$i}} = {
        id: "id1",
        description: "Mondays",
        location: "",
        subject: "Monday",
        calendar: "Room 1",
        start: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}},{{(int)($val['av_from_hour'])}}, {{(int)($val['av_from_min'])}}, 0),
        end: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}}, {{(int)($val['av_to_hour'])}},{{(int)($val['av_to_min'])}}, 0)
         }
      appointments.push(monday{{$i}});
      @endif
@endforeach
     @endif






  {{--   @if(date('w', strtotime("+".$i."days"))=="2")
 @foreach($availability_tues as $val)
        var tues{{$i}} = {
        id: "id1",
        description: "Tuesday",
        location: "",
        subject: "Tuesday",
      calendar: "Room 1",
         start: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}},{{(int)($val['av_from_hour'])}}, {{(int)($val['av_from_min'])}}, 0),
        end: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}}, {{(int)($val['av_to_hour'])}},{{(int)($val['av_to_min'])}}, 0)
         }
      appointments.push(tues{{$i}});
@endforeach
     @endif--}}





     @if(date('w', strtotime("+".$i."days"))=="2")
 @foreach($availability_tues as $val)
    @php
        $chk=1;
    @endphp
     @foreach(@$val->getBook? @$val->getBook:[] as$item)
     // console.log( {{date('Y-m-d', strtotime(date('Y-m-d')."+".$i."days"))}} ,{{$item->booking_date}});
        @if(date('Y-m-d', strtotime("+".$i."days"))==$item->booking_date)

            @php
            $chk=0;
            @endphp

        @endif
     @endforeach

     @if($chk==1)
     @php

            $from=explode(":",$val->from_time);
            $to=explode(":",$val->to_time);
            //dd($from,$to);
            $val['av_from_hour']=$from[0];
            $val['av_from_min']=$from[1];

            $val['av_to_hour']=$to[0];
            $val['av_to_min']=$to[1];
    @endphp

        var tues{{$i}} = {
        id: "id1",
        description: "Tuesday",
        location: "",
        subject: "Tuesday",
      calendar: "Room 2",
         start: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}},{{(int)($val['av_from_hour'])}}, {{(int)($val['av_from_min'])}}, 0),
        end: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}}, {{(int)($val['av_to_hour'])}},{{(int)($val['av_to_min'])}}, 0)
         }
      appointments.push(tues{{$i}});
      @endif
@endforeach
     @endif












@if(date('w', strtotime("+".$i."days"))=="3")
 @foreach($availability_wed as $val)
 /*here we get the availability id ($val->id  mention in relation) as primary key ad this has relation with below getBook and getBook has date .. now we need to chk that the date of getBook is equal to which date. and that date will not gonna push to arry as available date...*/

 @php
$chkWed=1;
 @endphp

@foreach($val->getBook as $item)
  @if( $item->booking_date==date('Y-m-d', strtotime("+".$i."days")) )
     @php
      $chkWed=0;
     @endphp
  @endif
@endforeach

@if($chkWed==1)
@php
 $from=explode(":",$val->from_time);
            $to=explode(":",$val->to_time);
            //dd($from,$to);
            $val['av_from_hour']=$from[0];
            $val['av_from_min']=$from[1];

            $val['av_to_hour']=$to[0];
            $val['av_to_min']=$to[1];

@endphp
        var wed{{$i}} = {
        id: "id1",
        description: "Wednesday",
        location: "",
        subject: "Wednesday",
       calendar: "Room 1",
        start: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}},{{(int)($val['av_from_hour'])}}, {{(int)($val['av_from_min'])}}, 0),
        end: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}}, {{(int)($val['av_to_hour'])}},{{(int)($val['av_to_min'])}}, 0)
         }
      appointments.push(wed{{$i}});
      @endif
@endforeach
     @endif









@if(date('w', strtotime("+".$i."days"))=="4")
 @foreach($availability_thurs as $val)

@php
$chkThurs=1;
@endphp

@foreach($val->getBook as $item)
  @if( $item->booking_date==date('Y-m-d', strtotime("+".$i."days")) )
     @php
      $chkThurs=0;
     @endphp
  @endif
@endforeach

@if($chkThurs==1)
@php
 $from=explode(":",$val->from_time);
            $to=explode(":",$val->to_time);
            //dd($from,$to);
            $val['av_from_hour']=$from[0];
            $val['av_from_min']=$from[1];

            $val['av_to_hour']=$to[0];
            $val['av_to_min']=$to[1];

@endphp
        var thurs{{$i}} = {
        id: "id1",
        description: "Thuesday",
        location: "",
        subject: "Thuesday",
       calendar: "Room 1",
        start: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}},{{(int)($val['av_from_hour'])}}, {{(int)($val['av_from_min'])}}, 0),
        end: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}}, {{(int)($val['av_to_hour'])}},{{(int)($val['av_to_min'])}}, 0)
         }
      appointments.push(thurs{{$i}});
      @endif
@endforeach
     @endif









@if(date('w', strtotime("+".$i."days"))=="5")
 @foreach($availability_fri as $val)


@php
$chkFri=1;
@endphp

@foreach($val->getBook as $item)
  @if( $item->booking_date==date('Y-m-d', strtotime("+".$i."days")) )
     @php
      $chkFri=0;
     @endphp
  @endif
@endforeach

@if($chkFri==1)
@php
 $from=explode(":",$val->from_time);
            $to=explode(":",$val->to_time);
            //dd($from,$to);
            $val['av_from_hour']=$from[0];
            $val['av_from_min']=$from[1];

            $val['av_to_hour']=$to[0];
            $val['av_to_min']=$to[1];

@endphp
        var fri{{$i}} = {
        id: "id1",
        description: "Friday",
        location: "",
        subject: "Friday",
      calendar: "Room 1",
       start: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}},{{(int)($val['av_from_hour'])}}, {{(int)($val['av_from_min'])}}, 0),
        end: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}}, {{(int)($val['av_to_hour'])}},{{(int)($val['av_to_min'])}}, 0)
         }
      appointments.push(fri{{$i}});
      @endif
@endforeach
     @endif






     @if(date('w', strtotime("+".$i."days"))=="6")
@foreach($availability_sat as $val)

@php
$chkSat=1;
@endphp

@foreach($val->getBook as $item)
  @if( $item->booking_date==date('Y-m-d', strtotime("+".$i."days")) )
     @php
      $chkSat=0;
     @endphp
  @endif
@endforeach

@if($chkSat==1)
@php
 $from=explode(":",$val->from_time);
            $to=explode(":",$val->to_time);
            //dd($from,$to);
            $val['av_from_hour']=$from[0];
            $val['av_from_min']=$from[1];

            $val['av_to_hour']=$to[0];
            $val['av_to_min']=$to[1];

@endphp
        var sat{{$i}} = {
        id: "id1",
        description: "Sat",
        location: "",
        subject: "Sat",
      calendar: "Room 1",
        start: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}},{{(int)($val['av_from_hour'])}}, {{(int)($val['av_from_min'])}}, 0),
        end: new Date({{date('Y', strtotime("+".$i." days"))}}, {{date('m', strtotime("+".$i." days"))-1}}, {{date('d', strtotime("+".$i." days"))}}, {{(int)($val['av_to_hour'])}},{{(int)($val['av_to_min'])}}, 0)
         }
      appointments.push(sat{{$i}});
@endif
@endforeach
     @endif

@endfor















@foreach($booked as $key=> $val)
//console.log({{(int)($val['year'])}}, {{(int)($val['month'])}},{{(int)($val['day'])}} , {{(int)($val['from_hour'])}}, {{(int)($val['from_min'])}}, 0);
var appointment{{$key}} = {
    id: "id2",
    description: "",
    location: "",
    subject: "Booked",
    calendar: "Room 2",
     start: new Date({{(int)($val['year'])}}, {{(int)($val['month'])-1}},{{(int)($val['day'])}} , {{(int)($val['from_hour'])}}, {{(int)($val['from_min'])}}, 0),
    end: new Date({{(int)($val['year'])}}, {{(int)($val['month'])-1}},{{(int)($val['day'])}} , {{(int)($val['to_hour'])}}, {{(int)(@$val['to_min'])}}, 0)
}
appointments.push(appointment{{$key}});

@endforeach

// var appointment3 = {
//     id: "id3",
//     description: "",
//     location: "",
//     subject: "Course Social Media",
//     calendar: "Room 3",
//     start: new Date(2015, 10, 27, 11, 0, 0),
//     end: new Date(2015, 10, 27, 13, 0, 0)
// }

// var appointment4 = {
//     id: "id4",
//     description: "",
//     location: "",
//     subject: "New Projects Planning",
//     calendar: "Room 6",
//     start: new Date(2015, 10, 23, 10, 0, 0),
//     end: new Date(2015, 10, 23, 12, 0, 0)
// }

// var appointment5 = {
//     id: "id5",
//     description: "",
//     location: "",
//     subject: "Interview with James",
//     calendar: "Room 1",
//     start: new Date(2015, 10, 25, 11, 0, 0),
//     end: new Date(2015, 10, 25, 17, 0, 0)
// }

// var appointment6 = {
//     id: "id6",
//     description: "",
//     location: "",
//     subject: "Interview with Nancy",
//     calendar: "Room 4",
//     start: new Date(2015, 10, 26, 14, 0, 0),
//     end: new Date(2015, 10, 26, 16, 0, 0)
// }
// //appointments.push(appointment1);
// appointments.push(appointment2);
// appointments.push(appointment3);
// appointments.push(appointment4);
// appointments.push(appointment5);
// appointments.push(appointment6);


// prepare the data
var source =
{
    dataType: "array",
    dataFields: [
        { name: 'id', type: 'string' },
        { name: 'description', type: 'string' },
        { name: 'location', type: 'string' },
        { name: 'subject', type: 'string' },
        { name: 'calendar', type: 'string' },
        { name: 'start', type: 'date' },
        { name: 'end', type: 'date' }
    ],
    id: 'id',
    localData: appointments
};
var adapter = new $.jqx.dataAdapter(source);
$("#scheduler").jqxScheduler({
    date: new $.jqx.date({{date('Y')}}, {{date('m')}}, {{date('d')}}),
    width: 1100,
    height: 800,
    //editDialog: false,
    source: adapter,
    view: 'weekView',
    showLegend: true,
    ready: function () {
        $("#scheduler").jqxScheduler('ensureAppointmentVisible', 'id1');
    },
    resources:
    {
        colorScheme: "scheme27",
        dataField: "calendar",
        source:  new $.jqx.dataAdapter(source)
    },
    appointmentDataFields:
    {
        from: "start",
        to: "end",
        id: "id",
        description: "description",
        location: "place",
        subject: "subject",
        resourceId: "calendar"
    },
    views:
    [
        //'dayView',
        'weekView',
        //'monthView'
    ]
});
});
    </script>
</head>
{{date('Y')}}<br>
{{date('m')}}<br>
{{date('D')}}
<div id="scheduler">

        </div>
</html>



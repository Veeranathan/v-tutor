<!DOCTYPE html>
<html>
<head>
    <title></title>

    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.2.616/styles/kendo.common.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.2.616/styles/kendo.blueopal.min.css" />

  <script src={{ public_asset('assets/js/jquerymin.js')}}"></script>


  <script src="https://kendo.cdn.telerik.com/2021.2.616/js/kendo.all.min.js"></script>


</head>
<body>
    <div id="example">
    <div id="team-schedule">
        <div id="people">
            <input checked type="checkbox" id="alex" aria-label="Alex" value="1">
            <input checked type="checkbox" id="bob" aria-label="Bob" value="2">
            <input type="checkbox" id="charlie" aria-label="Charlie" value="3">
        </div>
    </div>
    <div id="scheduler"></div>
</div>
<script>$(function() {
    $("#scheduler").kendoScheduler({
        date: new Date("2013/6/13"),
        startTime: new Date("2013/6/13 06:00 AM"),
        height: 500,
        //width:550,
        // views: [
        //     "day",
        //     { type: "workWeek", selected: true },
        //     "week",
        //     "month",
        //     "year",
        //     "agenda",
        //     { type: "timeline", eventHeight: 50}
        // ],
        timezone: "Etc/UTC",
        dataSource: {
            batch: true,
            transport: {
                read: {
                    url: "https://demos.telerik.com/kendo-ui/service/tasks",
                    dataType: "jsonp"
                },
                update: {
                    url: "https://demos.telerik.com/kendo-ui/service/tasks/update",
                    dataType: "jsonp"
                },
                create: {
                    url: "https://demos.telerik.com/kendo-ui/service/tasks/create",
                    dataType: "jsonp"
                },
                destroy: {
                    url: "https://demos.telerik.com/kendo-ui/service/tasks/destroy",
                    dataType: "jsonp"
                },
                parameterMap: function(options, operation) {
                    if (operation !== "read" && options.models) {
                        return {models: kendo.stringify(options.models)};
                    }
                }
            },
            schema: {
                model: {
                    id: "taskId",
                    fields: {
                        taskId: { from: "TaskID", type: "number" },
                        title: { from: "Title", defaultValue: "No title", validation: { required: true } },
                        start: { type: "date", from: "Start" },
                        end: { type: "date", from: "End" },
                        startTimezone: { from: "StartTimezone" },
                        endTimezone: { from: "EndTimezone" },
                        description: { from: "Description" },
                        // recurrenceId: { from: "RecurrenceID" },
                        // recurrenceRule: { from: "RecurrenceRule" },
                        // recurrenceException: { from: "RecurrenceException" },
                        //ownerId: { from: "OwnerID", defaultValue: 1 },
                        //isAllDay: { type: "boolean", from: "IsAllDay" }
                    }
                }
            },
            filter: {
                logic: "or",
                filters: [
                    { field: "ownerId", operator: "eq", value: 1 },
                    { field: "ownerId", operator: "eq", value: 2 }
                ]
            }
        },
        resources: [
            {
                field: "ownerId",
                title: "Owner",
                dataSource: [
                    { text: "Alex", value: 1, color: "#f8a398" },
                    { text: "Bob", value: 2, color: "#51a0ed" },
                    { text: "Charlie", value: 3, color: "#56ca85" }
                ]
            }
        ]
    });

    $("#people :checkbox").change(function(e) {
        var checked = $.map($("#people :checked"), function(checkbox) {
            return parseInt($(checkbox).val());
        });

        var scheduler = $("#scheduler").data("kendoScheduler");

        scheduler.dataSource.filter({
            operator: function(task) {
                return $.inArray(task.ownerId, checked) >= 0;
            }
        });
    });
});</script>
<style>


    #team-schedule {
        background: url('../content/web/scheduler/team-schedule.png') transparent no-repeat;
        height: 115px;
        position: relative;
    }

    #people {
        background: url('../content/web/scheduler/scheduler-people.png') no-repeat;
        width: 345px;
        height: 115px;
        position: absolute;
        right: 0;
    }

    #alex {
        position: absolute;
        left: 4px;
        top: 81px;
    }

    #bob {
        position: absolute;
        left: 119px;
        top: 81px;
    }

    #charlie {
        position: absolute;
        left: 234px;
        top: 81px;
    }
    .k-scheduler-layout {
    color: #003f59 !important;
}
</style>




</body>
</html>
























{{-- jqwidgets --}}
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
    var appointments = new Array();
 @for($i=1;$i<13;$i++)
    var appointment1{{$i}} = {
    id: "id1",
    description: "George brings projector for presentations.",
    location: "",
    subject: "jeeet",
    calendar: "Room 1",

    start: new Date({{date('Y')}}, {{$i}}, 23, 9, 0, 0),
    end: new Date({{date('Y')}}, {{$i}}, 23, 10, 0, 0)

}
appointments.push(appointment1{{$i}});
 @endfor
var appointment2 = {
    id: "id2",
    description: "",
    location: "",
    subject: "IT Group Mtg.",
    calendar: "Room 2",
    start: new Date(2015, 10, 24, 10, 0, 0),
    end: new Date(2015, 10, 24, 15, 0, 0)
}

var appointment3 = {
    id: "id3",
    description: "",
    location: "",
    subject: "Course Social Media",
    calendar: "Room 3",
    start: new Date(2015, 10, 27, 11, 0, 0),
    end: new Date(2015, 10, 27, 13, 0, 0)
}

var appointment4 = {
    id: "id4",
    description: "",
    location: "",
    subject: "New Projects Planning",
    calendar: "Room 2",
    start: new Date(2015, 10, 23, 16, 0, 0),
    end: new Date(2015, 10, 23, 18, 0, 0)
}

var appointment5 = {
    id: "id5",
    description: "",
    location: "",
    subject: "Interview with James",
    calendar: "Room 1",
    start: new Date(2015, 10, 25, 15, 0, 0),
    end: new Date(2015, 10, 25, 17, 0, 0)
}

var appointment6 = {
    id: "id6",
    description: "",
    location: "",
    subject: "Interview with Nancy",
    calendar: "Room 4",
    start: new Date(2015, 10, 26, 14, 0, 0),
    end: new Date(2015, 10, 26, 16, 0, 0)
}
//appointments.push(appointment1);
appointments.push(appointment2);
appointments.push(appointment3);
appointments.push(appointment4);
appointments.push(appointment5);
appointments.push(appointment6);


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
                date: new $.jqx.date(2019, 11, 23),
                //width: getWidth("Scheduler"),
                 width: 1050,
                height: 600,
                source: adapter,

                ready: function () {
                },
                appointmentDataFields:
                {
                    from: "start",
                    to: "end",
                    id: "id",
                    description: "about",
                    location: "address",
                    subject: "name",
                    style: "style",
                    status: "status"
                },
                view: 'weekView',
                views:
                [
                    { type: "dayView", showWeekends: false, timeRuler: { hidden: false } },
                    { type: "weekView", workTime:
                    {
                        fromDayOfWeek: 1,
                        toDayOfWeek: 1,
                        fromHour: 7,
                        toHour: 13,
                         calendar: "Room 2",
                    }
                    }
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
        <style>
        	.jqx-scheduler-cell-focus {
    border-style: dotted;
    border-color: #59a0d5 !important;
    background: #d41010 !important;
}
/*.jqx-scheduler-work-time-cell {
    background:red !important;
}*/
        </style>
</html>


















{{--  --}}
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
    var appointments = new Array();

    var appointment1 = {
    id: "id1",
    description: "George brings projector for presentations.",
    location: "",
    subject: "jeeet",
    calendar: "Room 1",
    start: new Date(2015, 10, 23, 9, 0, 0),
    end: new Date(2015, 10, 23, 10, 0, 0)
}

var appointment2 = {
    id: "id2",
    description: "",
    location: "",
    subject: "IT Group Mtg.",
    calendar: "Room 2",
    start: new Date(2015, 10, 24, 10, 0, 0),
    end: new Date(2015, 10, 24, 15, 0, 0)
}

var appointment3 = {
    id: "id3",
    description: "",
    location: "",
    subject: "Course Social Media",
    calendar: "Room 3",
    start: new Date(2015, 10, 27, 11, 0, 0),
    end: new Date(2015, 10, 27, 13, 0, 0)
}

var appointment4 = {
    id: "id4",
    description: "",
    location: "",
    subject: "New Projects Planning",
    calendar: "Room 6",
    start: new Date(2015, 10, 23, 10, 0, 0),
    end: new Date(2015, 10, 23, 12, 0, 0)
}

var appointment5 = {
    id: "id5",
    description: "",
    location: "",
    subject: "Interview with James",
    calendar: "Room 1",
    start: new Date(2015, 10, 25, 11, 0, 0),
    end: new Date(2015, 10, 25, 17, 0, 0)
}

var appointment6 = {
    id: "id6",
    description: "",
    location: "",
    subject: "Interview with Nancy",
    calendar: "Room 4",
    start: new Date(2015, 10, 26, 14, 0, 0),
    end: new Date(2015, 10, 26, 16, 0, 0)
}
appointments.push(appointment1);
appointments.push(appointment2);
appointments.push(appointment3);
appointments.push(appointment4);
appointments.push(appointment5);
appointments.push(appointment6);


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
    date: new $.jqx.date(2015, 11, 23),
    width: 1100,
    height: 600,
    source: adapter,
    view: 'weekView',
    showLegend: true,
    ready: function () {
        $("#scheduler").jqxScheduler('ensureAppointmentVisible', 'id1');
    },
    resources:
    {
        colorScheme: "scheme05",
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
<div id="scheduler">

        </div>
</html>









{{-- schedule --}}
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

    <link rel="stylesheet" href="{{ public_asset('assets/scheduler/dist/jquery.schedule.css">

<script src="{{url('/')}}/assets/scheduler/dist/jquery.schedule.js"></script>

</head>
<div id="schedule-demo" style="width: 1000px; height: 500px"></div>
<script>
    $("#schedule-demo").jqs({
  mode: "read",
  hour: 24, // 12
  periodDuration: 30, // 15/30/60
  data: [],
  periodOptions: true,
  periodColors: [],
  periodTitle: "",
  periodBackgroundColor: "#59a0d5",
  periodBorderColor: "#2a3cff",
  periodTextColor: "#000",
  periodRemoveButton: "Remove",
  periodDuplicateButton: 'Duplicate',
  periodTitlePlaceholder: "Title",
  data: [
    {
      day: 1,
      periods: [
          ["20:00", "00:00"],
          ["00:00", "02:00"]
      ]
    },
    {
      day: 5,
      periods: [
          ["20:00", "00:00"],
          ["00:00", "02:00"]
      ]
    },
    {
      day: 3,
      periods: [
          ["00:00", "08:30"],
          ["09:00", "12:00"]
      ]
    }
  ]
});
</script>
</html>

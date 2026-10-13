<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Kendo UI</title>

      <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.2.616/styles/kendo.common.min.css" />
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.2.616/styles/kendo.blueopal.min.css" />

    <script src="https://kendo.cdn.telerik.com/2021.2.616/js/jquery.min.js"></script>
  {{--   <script>
        if (typeof jQuery == "undefined") {
            // Fallback to local jQuery.
            document.write(decodeURIComponent('%3Cscript src="/path/to/local/jquery.min.js" %3E%3C/script%3E'));
        }
    </script> --}}

    <script src="https://kendo.cdn.telerik.com/2021.2.616/js/kendo.all.min.js"></script>
   {{--  <script>
        if (typeof kendo == "undefined") {
            // Checking for loaded CSS files is cumbersome,
            // therefore assume that if the scripts have failed, so have the stylesheets.

            // Fallback to local Kendo UI stylesheets.
            document.write(decodeURIComponent('%3Clink rel="stylesheet" href="/path/to/local/kendo.common.min.css" %3C/%3E'));
            document.write(decodeURIComponent('%3Clink rel="stylesheet" href="/path/to/local/kendo.blueopal.min.css" %3C/%3E'));

            // Fallback to local Kendo UI scripts.
            document.write(decodeURIComponent('%3Cscript src="/path/to/local/kendo.all.min.js" %3E%3C/script%3E'));
            // Also add kendo.aspnetmvc.min.js or kendo.timezones.min.js if needed.
        }
    </script> --}}
 {{--    <style>
    	.k-autocomplete, .k-dropdown-wrap.k-state-default, .k-numeric-wrap.k-state-default, .k-picker-wrap.k-state-default {
    background-image: url(textures/highlight.png);
    background-image: none,linear-gradient(to bottom,rgba(255,255,255,.4) 0,rgba(255,255,255,0) 100%);
    background-position: 50% 50%;
    background-color: #deeef5;
    border-color: #a3d0e4;
    width: 141px;
}
    </style> --}}
</head>
{{-- <body>
    Hello world!
    <input id="dateTimePicker" />
<script>
$("#dateTimePicker").kendoTimePicker({
    interval: 30,
  //value: new Date(),
  // dateInput: false, 
    min: new Date({{date('Y,m,d')}}, 6, 0, 0),
    max: new Date({{date('Y,m,d')}}, 20, 0, 0)
});
</script> --}}
<body>
   <div class="container">
	<div class=" demo-section k-content row" style="margin-top:10px ">
		<div class="col-md-6">
			<h6>Start time</h6>
                <input id="start" placeholder="start"  style="width: 150px;" />
		</div>

		<div class="col-md-6">
			<h6>End time</h6>
                <input id="end" placeholder="end" style="width: 150px;" />
		</div>

	</div>
</div>
    
     
        	
            <script>
                $(document).ready(function() {
                    function startChange() {
                        var startTime = start.value();

                        if (startTime) {
                            startTime = new Date(startTime);

                            end.max(startTime);

                            startTime.setMinutes(startTime.getMinutes() + this.options.interval);

                            end.min(startTime);
                            end.value(startTime);
                            end.max("8:30 PM");  
                            //to set the max to_time , min to_time and value after selecting from time
                        }
                    }

                    //init start timepicker
                    var start = $("#start").kendoTimePicker({
                        change: startChange,
                        interval:30,
                    }).data("kendoTimePicker");

                    //init end timepicker
                    var end = $("#end").kendoTimePicker({
                    	 interval:30,
                    	  min: new Date({{date('Y,m,d')}}, 6, 30, 0),
                          max: new Date({{date('Y,m,d')}}, 20, 0, 0)

                    }).data("kendoTimePicker");

                    //define min/max range
                    start.min("6:00 AM");

                    start.max("8:00 PM");

                    //define min/max range
                    end.min("6:30 AM");
                    end.max("8:30 PM");
                });
            </script>

            <style>

            </style>
        </div>

    

</body>
</body>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
{{-- <title>V-Tutor – Tutor – Profile</title> --}}
{{-- <link rel="icon" href="{{ public_asset('assets/images/favicon.ico')}}" type="image/x-icon" />
<link rel="shortcut icon" href="{{ public_asset('assets/images/favicon.ico')}}" type="image/x-icon" /> --}}
<link rel="icon" href="{{ public_asset('assets/images/favicon.ico')}}" type="image/x-icon" />
<link rel="shortcut icon" href="{{ public_asset('assets/images/favicon.ico')}}" type="image/x-icon" />
<link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="32x32">
<link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="96x96">
<link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="192x192">
<link rel="apple-touch-icon" href="{{ public_asset('assets/images/favicon.png') }}">
<meta name="msapplication-TileImage" content="{{ public_asset('assets/images/favicon.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ public_asset('assets/images/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ public_asset('assets/images/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ public_asset('assets/images/favicon-16x16.png') }}">
<link href="{{ public_asset('assets/css/bootstrap.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="{{ public_asset('assets/css/font-awesome/all.min.css')}}" rel="stylesheet">
{{-- <link href="{{ public_asset('assets/css/semantic.min.css" rel="stylesheet')}}" type="text/css" /> --}}
{{-- https://www.jqueryscript.net/form/country-picker-flags.html --}}
<link href="{{ public_asset('css/countrySelect.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ public_asset('assets/css/style.css')}}" rel="stylesheet">

<link href="{{ public_asset('assets/css/responsive.css')}}" rel="stylesheet">
<link href="{{ public_asset('assets/css/owl.carousel.css')}}" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Alex+Brush&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css">
<link href="{{ public_asset('assets/css/calender.css')}}" rel="stylesheet"> </head>
<link rel="stylesheet" href="{{ public_asset('assets/css/jquery-ui.css')}}">
<link rel="stylesheet" href="{{ public_asset('assets/css/chosen.css')}}">
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" /> --}}
<link rel="stylesheet" href="{{ public_asset('assets/css/swiper-bundle.min.css')}}" />
<link href="{{ public_asset('assets/faro_font/stylesheet.css')}}" rel="stylesheet">
<link href="{{ public_asset('assets/css/tutor_style.css')}}" rel="stylesheet">
<style type="text/css">
    .autocomplete-items {
    height: auto!important;
    overflow-y: scroll;
    max-height: 400px;
}
.completed_green_color{
    color: #669900 !important;
}
.cancelled_red_color{
    color: #CC3300 !important;
}

/* Ensure consistent styling for both the dropdown and buttons */
.form_box_area select,
.dash-btn {
  /* Set a fixed height for consistency */
  height: 38px; /* Adjust this value as needed to your preferred height */

  /* Set consistent vertical and horizontal padding */
  padding: 8px 15px; /* Adjust these values */

  /* Ensure background and border are consistent */
  background-color: #f0f0f0; /* Example background, adjust to match your design */
  border: 1px solid #c7d8dd;    /* Example border, adjust to match your design */
  border-radius: 8px;       /* Match border-radius for rounded corners */

  /* Font styling for consistency */
  font-size: 14px; /* Adjust font size to fit */
  line-height: 20px; /* Adjust line-height to vertically center text within the height */

  /* Remove default button/select styles that might interfere */
  -webkit-appearance: none; /* For WebKit browsers (Chrome, Safari) */
  -moz-appearance: none;    /* For Mozilla Firefox */
  appearance: none;         /* Standard property */
}

/* Specific adjustments for the select element's arrow icon */
.form_box_area select {
  /* Add custom arrow if default is removed */
  background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23000%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-6.5%200-13%205.4-13%2013s5.4%2013%2013%2013h255.3c6.5%200%2013-5.4%2013-13S293.5%2074.7%20287%2069.4zM287%20220.6a17.6%2017.6%200%200%200-13-5.4H18.4c-6.5%200-13%205.4-13%2013s5.4%2013%2013%2013h255.3c6.5%200%2013-5.4%2013-13S293.5%20225.9%20287%20220.6z%22%2F%3E%3C%2Fsvg%3E'); /* A simple SVG down arrow */
  background-repeat: no-repeat;
  background-position: right 10px center; /* Position the arrow */
  background-size: 10px; /* Size of the arrow */
  padding-right: 30px; /* Make space for the arrow so text doesn't overlap */
}

/* Adjustments for the image inside the Search button if it exists */
.dash-btn img {
    height: 16px; /* Adjust image height to fit button */
    vertical-align: middle; /* Align image vertically with text */
    margin-right: 5px; /* Space between image and text */
}

/* To ensure text within the buttons doesn't wrap and stays on one line */
.dash-btn {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}


</style>          

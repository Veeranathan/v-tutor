<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="V-Tutor Admin">
    <meta name="author" content="V-Tutor Admin">
    <meta name="robots" content="noindex, nofollow">

    {{-- <link rel="icon" href="{{ public_asset('admin/assets/images/favicon.ico') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ public_asset('admin/assets/images/favicon.ico') }}" type="image/x-icon" /> --}}
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
    <title>V-Tutor::Admin :: @yield('title')</title>
    @yield('links')
    <style>
        #v_tutor_Loader {
            display: none; /* hidden initially */
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.9); /* white background */
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

            /* Spinner loader */
        .v_tutor_Loader_div {
            border: 6px solid #f3f3f3;  /* light border */
            border-top: 6px solid #D7263D; /* your brand color */
            border-radius: 50%;
            width: 50px; height: 50px;
            animation: v_tutor_Loader_spin 1s linear infinite;
        }

        @keyframes v_tutor_Loader_spin {
            0%   { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body class="fixed-left">
    {{-- loader start --}}
    <div id="v_tutor_Loader">
        <div class="v_tutor_Loader_div"></div>
    </div>
    {{-- loader end --}}

    <div class="wrapper" id="wrapper">
        @yield('header')
        @yield('sidebar')
        <div class="content-page @if(Route::is('view.subject')) man-us-wiew @endif">
            @yield('content')
            @yield('footer')
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->


{{-- @endif --}}

@yield('script')

</body>
</html>

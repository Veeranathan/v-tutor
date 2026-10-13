<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>V-Tutor Live Session - {{ $booking->booking_no }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ public_asset('assets/images/favicon.ico') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ public_asset('assets/images/favicon.ico') }}" type="image/x-icon" />
    <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="32x32">
    <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="96x96">
    <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="192x192">
    <link rel="apple-touch-icon" href="{{ public_asset('assets/images/favicon.png') }}">
    <meta name="msapplication-TileImage" content="{{ public_asset('assets/images/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ public_asset('assets/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ public_asset('assets/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ public_asset('assets/images/favicon-16x16.png') }}">

    <!-- Daily SDK -->
    <script src="https://unpkg.com/@daily-co/daily-js"></script>

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background: #fff;
        }

        #call {
            width: 100%;
            height: 100vh;
        }
    </style>
</head>

<body>

    <div id="call"></div>

    <script>
        const callFrame = window.DailyIframe.createFrame(
            document.getElementById('call'),
            {
                showLeaveButton: true,
                showFullscreenButton: false,
                showRecording: false,
                enable_recording_ui: false
            }
        );

        callFrame.join({
            url: "{{ $roomUrl }}"
        });
    </script>

</body>
</html>
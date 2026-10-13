<?php

return [
    'min_start_time' => '06:00', // 8:00 AM
    'max_end_time'   => '20:00', // 8:00 PM (24-hour format)
    'max_booking_duration_minutes' => 60, // Maximum booking duration in minutes
    'book_before_hours' => 2, // Minimum hours before booking
    'GST' => 0.10, // GST percentage (18% in this case)
    'dayNames' => [
    1 => 'Monday',
    2 => 'Tuesday',
    3 => 'Wednesday',
    4 => 'Thursday',
    5 => 'Friday',
    6 => 'Saturday',
    7 => 'Sunday',
    ],
    'shortDayNames' => [
        1 => 'Mon',
        2 => 'Tue',
        3 => 'Wed',
        4 => 'Thu',
        5 => 'Fri',
        6 => 'Sat',
        7 => 'Sun',
    ],

];

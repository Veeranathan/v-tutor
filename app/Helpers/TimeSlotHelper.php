<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimeSlotHelper
{
    public static function filterTimesByConfig($startTimes, $endTimes)
    {
        $minStartTime = Carbon::createFromFormat('H:i', config('sessionsettings.min_start_time'));
        $maxEndTime   = Carbon::createFromFormat('H:i', config('sessionsettings.max_end_time'));

        $filtered_start_times = [];
        $filtered_end_times   = [];

        foreach ($startTimes as $index => $start) {
            $startTime = Carbon::createFromFormat('h:i A', $start);
            $endTime   = Carbon::createFromFormat('h:i A', $endTimes[$index]);

            if ($startTime->gte($minStartTime) && $endTime->lte($maxEndTime)) {
                $filtered_start_times[] = $start;
                $filtered_end_times[]   = $endTimes[$index];
            }
        }

        return [$filtered_start_times, $filtered_end_times];
    }

    public static function getRealSql($query) {
    foreach ($query->bindings as $binding) {
        $value = is_numeric($binding) ? $binding : "'$binding'";
        $query->sql = preg_replace('/\?/', $value, $query->sql, 1);
    }
    return $query->sql;
}
}

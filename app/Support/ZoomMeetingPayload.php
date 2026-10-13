<?php
// App\Support\ZoomMeetingPayload.php
namespace App\Support;

use Carbon\Carbon;

class ZoomMeetingPayload
{
    public static function build(
        string $topic,
        Carbon $startAtUtc,
        int $durationMinutes,
        string $timezone = 'Australia/Melbourne'
    ): array {
        return [
            'topic'      => $topic,
            'type'       => 2, // scheduled
            'start_time' => $startAtUtc->copy()->tz($timezone)->toIso8601String(),
            'duration'   => $durationMinutes,
            'timezone'   => $timezone,
            'settings'   => [
                // Waiting room + join controls
                'waiting_room'      => true,
                'join_before_host'  => true,   // participant can arrive early, stays in waiting room

                // Screen share + whiteboard
                'participant_video' => false,
                'host_video'        => true,
                'allow_multiple_devices' => true,
                'whiteboard'        => true,
                'share_screen'      => true,

                // Recording
                'auto_recording'    => 'cloud', // start automatically

                // Security
                'approval_type'     => 2, // No registration approval required (0=auto,1=manual,2=no registration)
                'enforce_login'     => false,
                'meeting_authentication' => false,

                // Misc
                'audio'             => 'voip',
            ],
        ];
    }
}

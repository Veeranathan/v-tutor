<?php 
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\StudentClassBooking;
use App\Models\Recording;
use Carbon\Carbon;

class DailyService
{
    public function createRoom($roomName)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.daily.key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.daily.co/v1/rooms', [
            "name" => $roomName,
            "privacy" => "private",  
            "properties" => [
                "enable_chat" => true,
                "enable_screenshare" => true,
                "start_video_off" => false,
                "start_audio_off" => false,
                // "enable_recording" => "cloud",
            ]
        ]);
        return $response->json();
    }

    public function generateToken($roomName, $userName, $isOwner = false, $exp = null)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.daily.key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.daily.co/v1/meeting-tokens', [
            "properties" => [
                "room_name" => $roomName,
                "user_name" => $userName,
                "is_owner" => $isOwner,
                "exp" => $exp,
            ]
        ]);

        return $response->json();
    }


    public function startRecording($roomName)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.daily.key'),
            'Content-Type' => 'application/json',
        ])->post(
            "https://api.daily.co/v1/rooms/{$roomName}/recordings/start",
            [
                'type' => 'cloud',
                'layout' => [
                'preset' => 'default',
                ],
            ]
        );

        Log::info('Daily recording response', [
            'room' => $roomName,
            'status' => $response->status(),
            'response' => $response->json(),
            'body' => $response->body(),
        ]);

        return $response->json();
    }

    public function stopRecording($roomName)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.daily.key'),
            'Content-Type'  => 'application/json',
        ])->post(
            "https://api.daily.co/v1/rooms/{$roomName}/recordings/stop",
            []
        );

        Log::info('Daily stop recording response', [
            'room' => $roomName,
            'status' => $response->status(),
            'response' => $response->json(),
            'body' => $response->body(),
        ]);

        return $response->json();
    }

    public function handleRecordingReadyToDownload(array $data)
    {
        $roomName = data_get(
            $data,
            'payload.room_name'
        );

        $bookingNo = str_replace(
            'session-',
            '',
            $roomName
        );

        $booking = StudentClassBooking::where(
            'booking_no',
            $bookingNo
        )->first();

        if (!$booking) {
            return;
        }

        Recording::create([
            'booking_id' => $booking->id,
            'session_id' => $bookingNo,
            'daily_recording_id' => data_get($data,'payload.recording_id'),
            'daily_instance_id' => data_get($data,'payload.instance_id'),
            'daily_status' => data_get($data,'payload.status'),
            'duration' => data_get($data,'payload.duration'),
            'max_participants' => data_get($data,'payload.max_participants'),
            's3_key' => data_get($data,'payload.s3_key'),
            'recording_started_at' => Carbon::createFromTimestamp(data_get($data, 'payload.start_ts')),
            'recording_ended_at'   => Carbon::createFromTimestamp(data_get($data, 'payload.end_ts')),
            'status' => 'pending'
        ]);
    }

    public function deleteFromDaily(Recording $recording)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.daily.key'),
        ])->delete(
            "https://api.daily.co/v1/recordings/{$recording->daily_recording_id}"
        );

        if (!$response->successful()) {
            Log::error('Failed to delete Daily recording', [
                'id' => $recording->daily_recording_id,
                'response' => $response->body()
            ]);

            return false;
        }

        $recording->update([
            'daily_status' => 'downloaded'
        ]);


        Log::info('Daily recording deleted successfully', [
            'id' => $recording->daily_recording_id
        ]);

        return true;
    }
}
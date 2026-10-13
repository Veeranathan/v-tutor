<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\StudentClassBooking;

class ZoomWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Log::info("Request:",[$request]);
        $event = $request->input('event');

        Log::info('📩 Zoom Webhook Received', [
            'event' => $event,
            'payload' => $request->all(),
        ]);

        // ✅ Handle Zoom URL Validation
        if ($event === 'endpoint.url_validation') {
            $plainToken = $request->input('payload.plainToken');
            $secretToken = env('ZOOM_WEBHOOK_SECRET');
            $encryptedToken = hash_hmac('sha256', $plainToken, $secretToken);

            return response()->json([
                'plainToken' => $plainToken,
                'encryptedToken' => $encryptedToken,
            ]);
        }

        // ✅ Handle Zoom event notifications
        $payload = $request->input('payload.object');
        $uuid = $payload['uuid'] ?? null;
        $meetingId = $payload['id'] ?? null;

        Log::info("im here");

        Log::info('📘 Zoom Event', [
            'event' => $event,
            'uuid' => $uuid,
            'meeting_id' => $meetingId,
        ]);
        $uuid = urldecode($payload['uuid'] ?? '');

        Log::info("UUid:",[$uuid]);
       $trackingFields = $payload['uuid'] ?? [];
       $booking = DB::table('student_class_bookings')
    ->whereJsonContains('total_responce->uuid', $uuid)
    ->first();
    Log::info("Booking id:",$booking->id);



        Log::info('🔍 Extracted Booking ID from tracking_fields', [
            'tracking_fields' => $trackingFields,
            'booking_id' => $bookingId,
        ]);
        Log::info("Webhook booking no:",[$bookingId]);

        if ($bookingId) {
            $booking = StudentClassBooking::where('id', $bookingId)->first();
            if ($booking) {
                Log::info("Booking updated from Zoom webhook via topic", [$booking]);
            }
        }

        try {
            switch ($event) {
                case 'meeting.started':
                    Cache::put("meeting:$uuid:status", 'started');
                    Log::info("🟢 Meeting started", ['uuid' => $uuid]);
                    break;

                case 'meeting.ended':
                    Cache::put("meeting:$uuid:status", 'ended');
                    Cache::forget("meeting:$uuid:participants");
                    Log::info("🔴 Meeting ended", ['uuid' => $uuid]);

                    // ✅ Update your DB record when meeting ends
                    // $affected = DB::table('zoom_meetings')
                    //     ->where('zoom_meeting_id', $meetingId)
                    //     ->orWhere('uuid', $uuid)
                    //     ->update([
                    //         'status' => 'ended',
                    //         'ended_at' => now(),
                    //         'updated_at' => now(),
                    //     ]);

                    // Log::info("✅ Meeting DB updated", [
                    //     'uuid' => $uuid,
                    //     'meeting_id' => $meetingId,
                    //     'rows_updated' => $affected,
                    // ]);

                    break;

                case 'meeting.participant_joined':
                    $participant = $payload['participant'] ?? [];
                    $participants = collect(Cache::get("meeting:$uuid:participants", []))
                        ->push($participant)
                        ->all();
                    Cache::put("meeting:$uuid:participants", $participants);
                    break;

                case 'meeting.participant_left':
                    $participant = $payload['participant'] ?? [];
                    $participants = collect(Cache::get("meeting:$uuid:participants", []))
                        ->reject(fn($p) => $p['user_id'] == ($participant['user_id'] ?? null))
                        ->all();
                    Cache::put("meeting:$uuid:participants", $participants);
                    break;

                default:
                    Log::warning('⚠️ Unhandled Zoom event', ['event' => $event]);
                    break;
            }
        } catch (\Exception $e) {
            Log::error('❌ Zoom Webhook DB update failed', [
                'event' => $event,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}


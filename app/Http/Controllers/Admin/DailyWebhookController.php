<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Services\DailyService;

class DailyWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('DAILY WEBHOOK FULL PAYLOAD', $request->all());

        $event = $request->input('type');

        $dailyService = app(DailyService::class);

        /* Recording Events */

        if ($event === 'recording.ready-to-download') {

            Log::info('RECORDING READY TO DOWNLOAD', $request->all());

            $dailyService->handleRecordingReadyToDownload(
                $request->all()
            );
        }

        /* Participant Events */

        $payload = $request->all();

        $room = data_get($payload, 'payload.room');
        $isOwner = data_get($payload, 'payload.owner') === true;

        if ($event === 'participant.joined' && $isOwner) {

            Log::info('TUTOR JOINED', [
                'room' => $room,
                'payload' => $payload['payload'] ?? null
            ]);

            $dailyService->startRecording($room);
        }

        if ($event === 'participant.left' && $isOwner) {

            Log::info('TUTOR LEFT', [
                'room' => $room,
            ]);

            // Daily automatically finalizes recording
            // $dailyService->stopRecording($room);
        }

        return response()->json(['ok' => true]);
    }
}
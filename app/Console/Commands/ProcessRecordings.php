<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Recording;
use App\Services\RecordingProcessorService;
use Illuminate\Support\Facades\Log;

class ProcessRecordings extends Command
{
    protected $signature = 'recordings:process';

    protected $description = 'Process Daily recordings and upload to SharePoint';

    public function handle()
    {
        Log::info('recordings:process triggered at ' . now());

        $recording = Recording::where('status', 'pending')
            ->orderBy('id')
            ->first();

        if (!$recording) {
            Log::info('No pending recordings found');
            return;
        }

        Log::info('Processing recording ID: ' . $recording->id);

        try {
            $recording->update(['status' => 'processing']);

            app(RecordingProcessorService::class)
                ->process($recording);

            Log::info('Recording processed successfully', [
                'id' => $recording->id
            ]);

        } catch (\Exception $e) {

            Log::error('Recording failed', [
                'id' => $recording->id,
                'error' => $e->getMessage()
            ]);

            $recording->update(['status' => 'failed']);
        }
    }
}
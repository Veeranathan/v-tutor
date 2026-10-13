<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Recording;
use App\Services\DailyService;

class RecordingProcessorService
{
    private function getMicrosoftAccessToken()
    {
        $response = Http::asForm()->post(
            'https://login.microsoftonline.com/' .
            config('services.microsoft.ms_tenant_id') .
            '/oauth2/v2.0/token',
            [
                'client_id' => config('services.microsoft.ms_client_id'),
                'client_secret' => config('services.microsoft.ms_client_secret'),
                'scope' => 'https://graph.microsoft.com/.default',
                'grant_type' => 'client_credentials',
            ]
        );

        if (!$response->successful()) {
            throw new \Exception(
                'Failed to get Microsoft token: ' .
                $response->body()
            );
        }

        return $response->json()['access_token'];
    }

    /*  MAIN ENTRY POINT */
    public function process(Recording $recording)
    {
        Log::info('Processing recording started', [
            'id' => $recording->id,
            'daily_id' => $recording->daily_recording_id
        ]);

        $downloadUrl = $this->getDownloadUrl($recording);

        if (!$downloadUrl) {
            throw new \Exception('Download URL not found from Daily');
        }

        $filePath = $this->downloadFileToDisk($downloadUrl, $recording);

        $this->uploadToSharePointChunked($filePath, $recording);

        Log::info('Processing recording completed', [
            'id' => $recording->id
        ]);
    }

    /* DAILY DOWNLOAD URL */
    private function getDownloadUrl(Recording $recording)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.daily.key'),
        ])->get("https://api.daily.co/v1/recordings/{$recording->daily_recording_id}/access-link");

        if ($response->successful()) {
            $data = $response->json();
            return $data['download_link'] ?? null;
        }

        Log::warning('Daily access-link failed', [
            'id' => $recording->id
        ]);

        return null;
    }

    /* STREAM DOWNLOAD TO DISK  */
    private function downloadFileToDisk($url, Recording $recording)
    {
        $directory = storage_path('app/temp');

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $filePath = $directory . "/" .
            $recording->session_id . "_" .
            $recording->id . ".mp4";

        Log::info('Downloading recording via stream', [
            'id' => $recording->id
        ]);

        Http::timeout(0)
            ->sink($filePath) 
            ->get($url);

        return $filePath;
    }

    /* SHAREPOINT UPLOAD */
    private function uploadToSharePointChunked($filePath, Recording $recording)
    {
        $token = $this->getMicrosoftAccessToken();

        $fileName = $recording->session_id . '_' . $recording->id . '.mp4';
        $folderPath = '07 Interviews & Session Recordings/Session Recordings';

        $fileSize = filesize($filePath);
        $chunkSize = 10 * 1024 * 1024; // 10MB

        /*CREATE UPLOAD SESSION */
        $sessionResponse = Http::withToken($token)->post(
            "https://graph.microsoft.com/v1.0/drives/" .
            config('services.microsoft.ms_drive_id') .
            "/root:/{$folderPath}/{$fileName}:/createUploadSession",
            [
                "item" => [
                    "@microsoft.graph.conflictBehavior" => "replace",
                    "name" => $fileName
                ]
            ]
        );

        if (!$sessionResponse->successful()) {
            throw new \Exception('Upload session failed: ' . $sessionResponse->body());
        }

        $uploadUrl = $sessionResponse->json()['uploadUrl'];

        /*  STREAM FILE IN CHUNKS */
        $handle = fopen($filePath, 'rb');
        $start = 0;

        while (!feof($handle)) {

            $chunk = fread($handle, $chunkSize);
            $length = strlen($chunk);
            $end = $start + $length - 1;

            $response = Http::withHeaders([
                'Content-Length' => $length,
                'Content-Range'  => "bytes {$start}-{$end}/{$fileSize}",
            ])
            ->withBody($chunk, 'application/octet-stream')
            ->put($uploadUrl);

            // success or in-progress
            if (!in_array($response->status(), [200, 201, 202])) {
                fclose($handle);

                Log::error('Chunk upload failed', [
                    'start' => $start,
                    'response' => $response->body()
                ]);

                throw new \Exception('SharePoint chunk upload failed');
            }

            $start = $end + 1;

            if ($response->status() === 201 || $response->status() === 200) {

                fclose($handle);

                $data = $response->json();

                $recording->update([
                    'recording_url' => $data['webUrl'] ?? null,
                    'sharepoint_file_id' => $data['id'] ?? null,
                    'recording_folder' => $folderPath,
                    'file_name' => $fileName,
                    'status' => 'uploaded'
                ]);

                unlink($filePath);

                app(DailyService::class)->deleteFromDaily($recording);

                return;
            }
        }

        fclose($handle);

        throw new \Exception('Upload incomplete - unexpected end');
    }
}
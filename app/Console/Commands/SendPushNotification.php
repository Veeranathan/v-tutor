<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log;

class SendPushNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Firebase push notification every 2 minutes';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $serviceAccount = config('services.firebase.file');
            $factory = (new Factory)->withServiceAccount($serviceAccount);
            $messaging = $factory->createMessaging();

            // ✅ Get all valid FCM tokens from users table
            $tokens = \DB::table('users')
                ->whereNotNull('fcm_token')
                ->pluck('fcm_token')
                ->toArray();

            if (empty($tokens)) {
                Log::warning('⚠️ No users with FCM tokens found.');
                return;
            }

            foreach ($tokens as $token) {
                try {
                    $message = CloudMessage::new()
                        ->withNotification(
                            Notification::create(
                                'Scheduled Notification',
                                'This is a push notification sent every 2 minutes'
                            )
                        )
                        ->withData(['time' => now()->toDateTimeString()])
                        ->withChangedTarget('token', $token);

                    $messaging->send($message);
                    Log::info("✅ Push sent successfully to token: {$token}");
                } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
                    Log::warning("❌ Invalid token: {$token}. Setting to NULL...");
                    // Automatically clear invalid tokens
                    \DB::table('users')->where('fcm_token', $token)->update(['fcm_token' => null]);
                } catch (\Throwable $e) {
                    Log::error("🔥 Push failed for {$token}: " . $e->getMessage());
                }
            }

            Log::info('✅ Push cycle completed at ' . now());
        } catch (\Throwable $e) {
            Log::error('🔥 Push notification process failed: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Helpers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log;
use App\Models\UserFcmToken;

class FirebaseHelper
{
    public static function sendPushNotification($token, $title, $body, $link = null, $user = null, $tokenRecord = null, $extraData = [])
    {
        try {
            $serviceAccount = config('services.firebase.file');
            $factory = (new Factory)->withServiceAccount($serviceAccount);
            $messaging = $factory->createMessaging();

            // --- build payload ---
            $notification = Notification::create($title, $body);

            $dataPayload = array_merge([
                'title' => $title,
                'body'  => $body,
                'link'  => $link ?? '',
                'time'  => now()->toDateTimeString(),
            ], $extraData);

            // --- construct message ---
            $message = CloudMessage::new()
                ->withNotification($notification)
                ->withData($dataPayload)
                ->withChangedTarget('token', $token);

            // --- send ---
            try {
                $response = $messaging->send($message);

                Log::info("✅ FCM push sent successfully", [
                    'token'     => $token,
                    'title'     => $title,
                    'body'      => $body,
                    'link'      => $link,
                    'extra'     => $extraData,
                    'response'  => $response,
                ]);
            } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
                Log::warning("🚫 Invalid/expired FCM token: {$token}");
                // delete token logic...
            } catch (\Throwable $e) {
                Log::error("🔥 Firebase push failed for {$token}: " . $e->getMessage(), [
                    'trace' => $e->getTraceAsString()
                ]);
            }

        } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
            Log::warning("🚫 Invalid/expired FCM token: {$token}");

            if ($tokenRecord instanceof UserFcmToken) {
                $tokenRecord->delete();
            } elseif ($user) {
                $user->fcmTokens()->where('fcm_token', $token)->delete();
            } else {
                UserFcmToken::where('fcm_token', $token)->delete();
            }
        } catch (\Throwable $e) {
            Log::error("🔥 Firebase push failed for {$token}: " . $e->getMessage());
        }
    }
}

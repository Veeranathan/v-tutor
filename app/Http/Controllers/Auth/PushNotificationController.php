<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserFcmToken;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Http;

class PushNotificationController extends Controller
{
  public function saveToken(Request $request)
    {
        $request->validate(['token' => 'required|string']);

        $user = auth()->user() ?? auth('tutor')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $auth_user = User::Where('id', @$user->id)->first();
        if($auth_user) {
            $fcm = $auth_user->fcmTokens()->where('fcm_token', $request->token)->first();
            if (!$fcm) {
                $fcm = UserFcmToken::where('fcm_token', $request->token)->first();
            }

            if ($fcm) {
                $fcm->update([
                    'user_id' => $auth_user->id,
                    'device' => $request->header('User-Agent')
                ]);
            } else {
                $auth_user->fcmTokens()->create([
                    'fcm_token' => $request->token,
                    'device' => $request->header('User-Agent')
                ]);
            }
            
            /* $auth_user->fcmTokens()->updateOrCreate(
                ['fcm_token' => $request->token],
                ['device' => $request->header('User-Agent')]
            ); */
            
            return response()->json(['status' => 'ok']);
        }

        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    public function sendPushNotification($token, $title, $body)
    {
        $messaging = config('services.firebase.file');

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::create($title, $body))
            ->withData([
                'click_action' => env('APP_URL'),
                'title' => $title,
                'body' => $body,
            ]);

        $response = $messaging->send($message);

        return response()->json([
            'success' => true,
            'message_id' => $response,
        ]);
    }

    public function unreadCount(Request $request)
    {
        $userId = Auth::user()->id;

        // Count only unread
        $count = \App\Models\AppNotification::where('user_id', $userId)
            ->where('read', false)
            ->count();

        // Show ALL latest notifications (not only unread)
        $items = \App\Models\AppNotification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json([
            'unread_count' => $count,
            'items' => $items
        ]);
    }


    public function markRead(Request $request)
    {
        $userId = $request->user()->id;
        $ids = $request->input('ids', []);

        $query = \App\Models\AppNotification::where('user_id', $userId);

        if (!empty($ids)) {
            // 🔹 Mark specific notifications as read
            $query->whereIn('id', $ids);
        } else {
            // 🔹 If no IDs provided, mark ALL unread as read
            $query->where('read', false);
        }

        $updatedCount = $query->update(['read' => true]);

        return response()->json([
            'ok' => true,
            'updated_count' => $updatedCount,
            'message' => !empty($ids)
                ? "Marked selected notifications as read"
                : "Marked all notifications as read"
        ]);
    }
}

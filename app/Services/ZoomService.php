<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZoomService
{
    protected string $base;

    public function __construct()
    {
        $this->base = config('services.zoom.base_url');
    }

    /** Get OAuth token */
    protected function token(): string
    {
        return Cache::remember('zoom_s2s_token', 3500, function () {
            $res = Http::asForm()->post('https://zoom.us/oauth/token', [
                'grant_type'    => 'account_credentials',
                'account_id'    => config('services.zoom.account_id'),
                'client_id'     => config('services.zoom.client_id'),
                'client_secret' => config('services.zoom.client_secret'),
            ]);

            if ($res->failed()) {
                throw new \RuntimeException('Zoom token failed: ' . $res->body());
            }
            return $res->json()['access_token'];
        });
    }

    /** HTTP client */
    protected function client()
    {
        return Http::withToken($this->token())->baseUrl($this->base);
    }

    /** Public Methods for Controller Usage */

    /** Get all groups */
    public function getGroups(): array
    {
        $res = $this->client()->get('/groups');
        if ($res->failed()) {
            throw new \RuntimeException('Zoom fetch groups failed: ' . $res->body());
        }
        return $res->json()['groups'] ?? [];
    }

    /** Fetch user details by ID */
    public function getUserDetails(string $zoomUserId): array
    {
        $res = $this->client()->get("/users/{$zoomUserId}");
        if ($res->failed()) {
            throw new \RuntimeException('Zoom fetch user details failed: ' . $res->body());
        }
        return $res->json();
    }

    /** Add user to a group */
    public function addUserToGroup(string $zoomUserId, string $groupId): void
    {
        $res = $this->client()->post("/groups/{$groupId}/members", [
            'members' => [
                ['id' => $zoomUserId],
            ],
        ]);
        if ($res->failed()) {
            throw new \RuntimeException('Zoom add user to group failed: ' . $res->body());
        }
    }

    /** Create a licensed user */
    public function createLicensedUser(string $email, string $password, string $first, string $last): array
    {
        $groups = $this->getGroups();
        $tutorsGroup = collect($groups)->firstWhere('name', 'Tutors');
        if (!$tutorsGroup) {
            throw new \RuntimeException('Zoom group "Tutors" not found.');
        }
        $groupId = $tutorsGroup['id'];

        $res = $this->client()->post('/users', [
            'action'    => 'autoCreate',
            // 'action'    => 'create',
            'user_info' => [
                'email'      => $email,
                'type'       => 2, // Licensed
                'first_name' => $first,
                'last_name'  => $last,
                'password' => $password
                // 'password'=> "Str0ng!Pass123"
            ],
        ]);

       // Log::info("createLicensedUser resp:", [$res]);

        if ($res->failed()) {
            throw new \RuntimeException('Zoom create user failed: ' . $res->body());
        }
        $user = $res->json();

        // Fetch user details (PMI, etc.)
        $details = $this->getUserDetails($user['id']);

        return array_merge($user, $details, ['group_id' => $groupId]);
    }

    public function canAddMoreRegistrants(string $meetingId): bool
    {
        $res = $this->client()->get("/meetings/{$meetingId}/registrants");

        if ($res->failed()) {
            throw new \RuntimeException('Failed to get meeting registrants: ' . $res->body());
        }

        $registrants = $res->json()['registrants'] ?? [];

        return count($registrants) < 3; // max 3 registrants + 1 host
    }

    public function registerUserForMeeting(string $meetingId, string $name, string $email): array
    {
        $res = $this->client()->post("/meetings/{$meetingId}/registrants", [
            'email' => $email,
            'first_name' => $name,
        ]);

        if ($res->failed()) {
            throw new \RuntimeException('Zoom registration failed: ' . $res->body());
        }

        return $res->json();
    }



    /** Delete user */
    public function deleteUser(string $zoomUserId, bool $disassociate = false): void
    {
        $query = $disassociate ? ['action' => 'disassociate'] : [];
        $res = $this->client()->delete("/users/{$zoomUserId}", $query);

        if ($res->failed()) {
            throw new \RuntimeException('Zoom delete user failed: ' . $res->body());
        }
    }

    /** Activate or deactivate user */
    public function setUserStatus(string $zoomUserId, bool $active): void
    {
        $res = $this->client()->put("/users/{$zoomUserId}/status", [
            'action' => $active ? 'activate' : 'deactivate',
        ]);
        if ($res->failed()) {
            throw new \RuntimeException('Zoom set user status failed: ' . $res->body());
        }
    }

    /** Create meeting for user */
    public function createMeetingForUser(string $zoomUserId, array $payload): array
    {
        // Force PMI usage
        $payload['type'] = 2; // scheduled meeting
        $payload['use_pmi'] = true;

        $payload['settings'] = array_merge($payload['settings'] ?? [], [
            'waiting_room' => true,
            'meeting_authentication' => false
            // 'password' => '12345' // ❌ leave this out if you don't want a passcode
        ]);

        $res = $this->client()->post("/users/{$zoomUserId}/meetings", $payload);
      //  Log::info("Meeting Created", [$res]);

        if ($res->failed()) {
            throw new \RuntimeException('Zoom create PMI meeting failed: ' . $res->body());
        }

        return $res->json();
    }

    /** End meeting */
    public function endMeeting(string $meetingId): void
    {
        $res = $this->client()->put("/meetings/{$meetingId}/status", ['action' => 'end']);
        if ($res->failed()) {
            throw new \RuntimeException('Zoom end meeting failed: ' . $res->body());
        }
    }
}

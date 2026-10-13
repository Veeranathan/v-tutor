<?php

namespace App\Services;

use App\Models\ZohoToken;
use Illuminate\Support\Facades\Http;

class ZohoDeskClient
{
    protected string $deskBase;
    protected string $accountsBase;
    protected string $orgId;

    public function __construct()
    {
        $this->deskBase     = rtrim(config('services.zoho.desk_base'), '/');
        $this->accountsBase = rtrim(config('services.zoho.accounts_base'), '/');
        $this->orgId        = config('services.zoho.org_id');
    }

    /**
     * Get valid access token (refresh if expired).
     */
    protected function token(): ZohoToken
    {
        $token = ZohoToken::firstOrFail();

        if (!$token->expires_at || now()->gte($token->expires_at)) {
            if (!$token->refresh_token) {
                throw new \Exception('Zoho refresh token missing. Please reconnect Zoho.');
            }

            $resp = Http::asForm()->post("{$this->accountsBase}/oauth/v2/token", [
                'grant_type'    => 'refresh_token',
                'client_id'     => config('services.zoho.client_id'),
                'client_secret' => config('services.zoho.client_secret'),
                'refresh_token' => $token->refresh_token,
            ])->throw()->json();

            $token->update([
                'access_token' => $resp['access_token'],
                'expires_at'   => now()->addSeconds(($resp['expires_in'] ?? 3600) - 60),
            ]);
        }

        return $token;
    }

    /**
     * Build a ready-to-use HTTP client.
     */
    protected function http()
    {
        $token = $this->token();

        return Http::withHeaders([
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
            'orgId'         => $this->orgId,
        ])->acceptJson();
    }

    /**
     * GET request to Zoho Desk.
     */
    public function get(string $path, array $query = [])
    {
        return $this->http()
            ->get("{$this->deskBase}{$path}", $query)
            ->throw()
            ->json();
    }

    /**
     * POST request to Zoho Desk.
     */
    public function post(string $path, array $payload = [])
    {
        return $this->http()
            ->post("{$this->deskBase}{$path}", $payload)
            ->throw()
            ->json();
    }

    /**
     * Find or create a contact by email.
     */
    public function findOrCreateContact(string $email, ?string $name = null): array
    {
       try {
    // 1. Find or create the contact
    $contact = $desk->findOrCreateContact($data['email'], $data['name']);

    // 2. Create a ticket
    $ticket = $desk->createTicket([
        'subject'      => $data['subject'],
        'description'  => "Message: {$data['message']}\nPhone: {$data['number']}",
        'contactId'    => $contact['id'],
        'email'        => $data['email'],
        'departmentId' => config('services.zoho.default_department_id'), // set your department
        'channel'      => 'Web',
    ]);

    // 3. Save Zoho ticket ID in your local messages table
    $message->update(['zoho_ticket_id' => $ticket['id']]);

} catch (\Exception $e) {
    \Log::error("Zoho Desk ticket creation failed: " . $e->getMessage());
}

        return $this->post('/api/v1/contacts', [
            'email'    => $email,
            'lastName' => $name ?: $email,
        ]);
    }

    /**
     * Create a ticket in Zoho Desk.
     */
    public function createTicket(array $data): array
    {
        return $this->post('/api/v1/tickets', $data);
    }

    /**
     * List tickets (simple wrapper).
     */
    public function listTickets(int $limit = 10, int $from = 1): array
    {
        return $this->get('/api/v1/tickets', [
            'limit'   => $limit,
            'from'    => $from,
            'include' => 'contacts,assignee,department',
        ]);
    }

    /**
     * Get departments (helpful if you don’t know the ID).
     */
    public function departments(): array
    {
        return $this->get('/api/v1/departments');
    }
}

<?php 
namespace App\Http\Controllers;

use App\Models\Message;
use App\Services\ZohoDeskClient;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(private ZohoDeskClient $desk) {}

    public function store(Request $request)
    {
        // Validate user input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Save locally
        $local = Message::create($validated);

        // Ensure contact exists in Zoho Desk
        $contact = $this->desk->findOrCreateContact(
            $validated['email'],
            $validated['name']
        );

        // Create ticket in Zoho Desk
        $departmentId = config('services.zoho.default_department_id');

        $ticket = $this->desk->createTicket([
            'subject' => $validated['subject'],
            'description' => $validated['message'],
            'contactId' => $contact['id'],
            'email' => $validated['email'],
            'departmentId' => $departmentId,
            'channel' => 'Web',
        ]);

        // Update local record with Zoho ticket ID
        $local->update(['zoho_ticket_id' => $ticket['id']]);

        return response()->json([
            'success' => true,
            'ticketId' => $ticket['id'],
            'message' => 'Thank you! Your request has been submitted.'
        ], 201);
    }
}

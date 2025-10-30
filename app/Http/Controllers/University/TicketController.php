<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the tickets.
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');
        $priority = $request->get('priority');
        $category = $request->get('category');
        
        $query = Auth::user()->university->tickets()
            ->with(['creator', 'assignedAdmin', 'messages'])
            ->latest('created_at');

        // Filter by status
        if ($status) {
            $query->where('status', $status);
        }

        // Filter by priority
        if ($priority) {
            $query->where('priority', $priority);
        }

        // Filter by category
        if ($category) {
            $query->where('category', $category);
        }

        // Search by subject or description
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tickets = $query->paginate(15)->withQueryString();

        // Get statistics
        $stats = [
            'total' => Auth::user()->university->tickets()->count(),
            'open' => Auth::user()->university->tickets()->open()->count(),
            'in_progress' => Auth::user()->university->tickets()->inProgress()->count(),
            'resolved' => Auth::user()->university->tickets()->resolved()->count(),
            'closed' => Auth::user()->university->tickets()->closed()->count(),
        ];

        return view('university.tickets.index', compact('tickets', 'stats', 'status', 'search', 'priority', 'category'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        return view('university.tickets.create');
    }

    /**
     * Store a newly created ticket.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'category' => 'required|in:news_article,bug_report,feature_request,general,other',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        $ticketData = [
            'university_id' => Auth::user()->university_id,
            'created_by' => Auth::id(),
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'category' => $validated['category'],
            'status' => 'open',
            'last_reply_at' => now(),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $ticketData['image'] = $request->file('image')->store('ticket-images', 'public');
        }

        $ticket = Ticket::create($ticketData);

        return redirect()->route('university.tickets.show', $ticket)
            ->with('success', 'Your support ticket has been created successfully! Our team will respond soon.');
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        // Ensure user can only view their university's tickets
        if ($ticket->university_id !== Auth::user()->university_id) {
            abort(403, 'Unauthorized access to this ticket.');
        }

        $ticket->load(['creator', 'assignedAdmin', 'messages.user', 'university']);

        // Mark ticket as read when university views it
        if ($ticket->has_unread_reply) {
            $ticket->update(['has_unread_reply' => false]);
        }

        return view('university.tickets.show', compact('ticket'));
    }

    /**
     * Add a reply to the ticket.
     */
    public function reply(Request $request, Ticket $ticket)
    {
        // Ensure user can only reply to their university's tickets
        if ($ticket->university_id !== Auth::user()->university_id) {
            abort(403, 'Unauthorized access to this ticket.');
        }

        // Validate the message
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        // Create the message
        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'is_internal_note' => false,
        ]);

        // Update ticket last reply time and reopen if closed
        $updateData = ['last_reply_at' => now()];
        
        // If ticket is resolved or closed, reopen it when university replies
        if ($ticket->isClosed()) {
            $updateData['status'] = 'open';
        }

        $ticket->update($updateData);

        return redirect()->route('university.tickets.show', $ticket)
            ->with('success', 'Your reply has been added successfully!');
    }

    /**
     * Close the ticket (mark as resolved by university).
     */
    public function close(Ticket $ticket)
    {
        // Ensure user can only close their university's tickets
        if ($ticket->university_id !== Auth::user()->university_id) {
            abort(403, 'Unauthorized access to this ticket.');
        }

        $ticket->update([
            'status' => 'closed',
        ]);

        return redirect()->route('university.tickets.index')
            ->with('success', 'Ticket has been closed successfully!');
    }
}

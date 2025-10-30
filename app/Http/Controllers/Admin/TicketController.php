<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of tickets with filters.
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['university', 'creator', 'assignedAdmin', 'messages'])
            ->latest('last_reply_at');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by university
        if ($request->filled('university_id')) {
            $query->where('university_id', $request->university_id);
        }

        // Filter by assigned admin
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Search by subject or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tickets = $query->paginate(15)->withQueryString();

        // Get universities for filter dropdown
        $universities = University::where('status', 'approved')
            ->orderBy('name')
            ->get(['id', 'name']);

        // Get admin users for assignment filter
        $admins = User::whereIn('role', ['admin', 'super_admin'])
            ->where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name']);

        // Get counts for each status
        $statusCounts = [
            'all' => Ticket::count(),
            'open' => Ticket::open()->count(),
            'in_progress' => Ticket::inProgress()->count(),
            'resolved' => Ticket::resolved()->count(),
            'closed' => Ticket::closed()->count(),
        ];

        return view('admin.tickets.index', compact('tickets', 'universities', 'admins', 'statusCounts'));
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['university', 'creator', 'assignedAdmin', 'messages.user']);

        // Get admin users for assignment
        $admins = User::whereIn('role', ['admin', 'super_admin'])
            ->where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.tickets.show', compact('ticket', 'admins'));
    }

    /**
     * Update ticket status.
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $ticket->update([
            'status' => $validated['status'],
        ]);

        return redirect()->back()
            ->with('success', 'Ticket status updated successfully!');
    }

    /**
     * Update ticket priority.
     */
    public function updatePriority(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket->update([
            'priority' => $validated['priority'],
        ]);

        return redirect()->back()
            ->with('success', 'Ticket priority updated successfully!');
    }

    /**
     * Assign ticket to an admin.
     */
    public function assign(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $ticket->update([
            'assigned_to' => $validated['assigned_to'],
        ]);

        $message = $validated['assigned_to'] 
            ? 'Ticket assigned successfully!' 
            : 'Ticket assignment removed successfully!';

        return redirect()->back()
            ->with('success', $message);
    }

    /**
     * Add a reply to the ticket.
     */
    public function reply(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'is_internal_note' => 'boolean',
        ]);

        $isInternalNote = $validated['is_internal_note'] ?? false;

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
            'is_internal_note' => $isInternalNote,
        ]);

        // Update ticket last reply time and mark as having unread reply (only for public replies)
        $updateData = ['last_reply_at' => now()];
        
        // Only mark as unread if it's a public reply (not internal note)
        if (!$isInternalNote) {
            $updateData['has_unread_reply'] = true;
        }

        $ticket->update($updateData);

        $message = $isInternalNote
            ? 'Internal note added successfully!'
            : 'Reply sent successfully!';

        return redirect()->back()
            ->with('success', $message);
    }

    /**
     * Bulk update ticket status.
     */
    public function bulkUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'ticket_ids' => 'required|array',
            'ticket_ids.*' => 'exists:tickets,id',
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        Ticket::whereIn('id', $validated['ticket_ids'])
            ->update(['status' => $validated['status']]);

        return redirect()->back()
            ->with('success', count($validated['ticket_ids']) . ' ticket(s) updated successfully!');
    }
}

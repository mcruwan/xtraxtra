<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Models\NewsSubmission;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UniversityDashboardController extends Controller
{
    public function index()
    {
        $university = Auth::user()->university;
        
        // News submission stats
        $newsStats = [
            'total' => $university->newsSubmissions()->count(),
            'drafts' => $university->newsSubmissions()->drafts()->count(),
            'pending' => $university->newsSubmissions()->pending()->count(),
            'approved' => $university->newsSubmissions()->approved()->count(),
            'scheduled' => $university->newsSubmissions()->scheduled()->count(),
            'published' => $university->newsSubmissions()->published()->count(),
            'rejected' => $university->newsSubmissions()->rejected()->count(),
            'this_month' => $university->newsSubmissions()
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->count(),
        ];

        // Ticket stats
        $ticketStats = [
            'total' => $university->tickets()->count(),
            'open' => $university->tickets()->open()->count(),
            'in_progress' => $university->tickets()->inProgress()->count(),
            'resolved' => $university->tickets()->resolved()->count(),
            'closed' => $university->tickets()->closed()->count(),
            'unread_replies' => $university->tickets()->where('has_unread_reply', true)->count(),
        ];

        // Recent news submissions
        $recentNews = $university->newsSubmissions()
            ->with(['categories', 'tags'])
            ->latest()
            ->take(5)
            ->get();

        // Recent tickets
        $recentTickets = $university->tickets()
            ->with(['creator', 'assignedAdmin'])
            ->latest()
            ->take(5)
            ->get();

        return view('university.dashboard', compact(
            'newsStats', 
            'ticketStats', 
            'recentNews', 
            'recentTickets'
        ));
    }
}

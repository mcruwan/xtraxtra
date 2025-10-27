<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsSubmission;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class NewsSubmissionController extends Controller
{
    /**
     * Display a listing of news submissions with filters
     */
    public function index(Request $request)
    {
        $query = NewsSubmission::with(['university', 'user', 'categories', 'tags', 'approver'])
            ->latest('created_at');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by university
        if ($request->filled('university_id')) {
            $query->where('university_id', $request->university_id);
        }

        // Search by title or excerpt
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $newsSubmissions = $query->paginate(15)->withQueryString();

        // Get universities for filter dropdown
        $universities = University::where('status', 'approved')
            ->orderBy('name')
            ->get(['id', 'name']);

        // Get counts for each status
        $statusCounts = [
            'all' => NewsSubmission::count(),
            'draft' => NewsSubmission::drafts()->count(),
            'pending' => NewsSubmission::pending()->count(),
            'approved' => NewsSubmission::approved()->count(),
            'rejected' => NewsSubmission::rejected()->count(),
            'published' => NewsSubmission::published()->count(),
        ];

        return view('admin.news.index', compact('newsSubmissions', 'universities', 'statusCounts'));
    }

    /**
     * Display the specified news submission
     */
    public function show(NewsSubmission $newsSubmission)
    {
        $newsSubmission->load(['university', 'user', 'categories', 'tags', 'approver']);

        return view('admin.news.show', compact('newsSubmission'));
    }

    /**
     * Approve a news submission
     */
    public function approve(Request $request, NewsSubmission $newsSubmission)
    {
        Gate::authorize('approve', $newsSubmission);

        $newsSubmission->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'News submission has been approved successfully!');
    }

    /**
     * Reject a news submission
     */
    public function reject(Request $request, NewsSubmission $newsSubmission)
    {
        Gate::authorize('reject', $newsSubmission);

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $newsSubmission->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by' => null,
            'approved_at' => null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'News submission has been rejected.');
    }

    /**
     * Bulk approve multiple submissions
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'submission_ids' => 'required|array',
            'submission_ids.*' => 'exists:news_submissions,id',
        ]);

        $submissions = NewsSubmission::whereIn('id', $request->submission_ids)
            ->where('status', 'pending')
            ->get();

        foreach ($submissions as $submission) {
            if (Gate::allows('approve', $submission)) {
                $submission->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                ]);
            }
        }

        return redirect()
            ->back()
            ->with('success', count($submissions) . ' submission(s) approved successfully!');
    }
}


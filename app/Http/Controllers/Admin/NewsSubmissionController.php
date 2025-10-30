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
            // Special handling for "scheduled_today" filter
            if ($request->status === 'scheduled_today') {
                $query->where('status', 'scheduled')
                      ->whereDate('scheduled_at', today());
            } else {
                $query->where('status', $request->status);
            }
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
            'scheduled' => NewsSubmission::scheduled()->count(),
            'scheduled_today' => NewsSubmission::scheduled()->whereDate('scheduled_at', today())->count(),
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
     * Show the form for editing a news submission
     */
    public function edit(NewsSubmission $newsSubmission)
    {
        $newsSubmission->load(['categories', 'tags']);
        
        $categories = \App\Models\Category::orderBy('name')->get();
        $tags = \App\Models\Tag::orderBy('name')->get();
        
        return view('admin.news.edit', compact('newsSubmission', 'categories', 'tags'));
    }

    /**
     * Update the specified news submission
     */
    public function update(\App\Http\Requests\AdminNewsEditRequest $request, NewsSubmission $newsSubmission)
    {
        $data = $request->validated();
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($newsSubmission->featured_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($newsSubmission->featured_image);
            }
            
            $data['featured_image'] = $request->file('featured_image')->store('news', 'public');
        } else {
            // Keep existing image if not updating
            unset($data['featured_image']);
        }
        
        // Auto-generate slug from title if empty
        if (empty($data['slug']) || !$data['slug']) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title']);
        }
        
        // Set last_edited_at timestamp
        $data['last_edited_at'] = now();
        
        // Handle status changes
        if (isset($data['status'])) {
            // When changing to published, ensure published_at is set
            if ($data['status'] === 'published') {
                if (!$newsSubmission->published_at) {
                    $data['published_at'] = now();
                }
                // live_url is required by validation, but ensure it's set
                if (!isset($data['live_url']) || empty($data['live_url'])) {
                    // This should have been caught by validation, but as a safeguard
                    return redirect()
                        ->back()
                        ->withErrors(['live_url' => 'Live URL is required when publishing an article.'])
                        ->withInput();
                }
                // Clear scheduled_at when publishing
                $data['scheduled_at'] = null;
            } else {
                // Clear live_url if status is not published
                if ($data['status'] !== 'published') {
                    $data['live_url'] = null;
                }
            }
            
            // Handle approved status with scheduling
            if ($data['status'] === 'approved') {
                // If scheduled_at is provided and is in the future, automatically change status to scheduled
                if (isset($data['scheduled_at']) && !empty($data['scheduled_at'])) {
                    $scheduledAt = \Carbon\Carbon::parse($data['scheduled_at']);
                    $now = \Carbon\Carbon::now();
                    
                    // If scheduled date is in the future, change status to scheduled
                    if ($scheduledAt->isFuture()) {
                        $data['status'] = 'scheduled';
                        // Set approved_at if not already set
                        if (!$newsSubmission->approved_at) {
                            $data['approved_at'] = now();
                            $data['approved_by'] = auth()->id();
                        }
                    } else {
                        // If scheduled date is today or in the past, clear it and keep as approved
                        $data['scheduled_at'] = null;
                        // Set approved_at if not already set
                        if (!$newsSubmission->approved_at) {
                            $data['approved_at'] = now();
                            $data['approved_by'] = auth()->id();
                        }
                    }
                } else {
                    // No scheduled_at provided, set approved_at if not already set
                    if (!$newsSubmission->approved_at) {
                        $data['approved_at'] = now();
                        $data['approved_by'] = auth()->id();
                    }
                }
            }
            
            // Handle scheduled status
            if ($data['status'] === 'scheduled') {
                // scheduled_at is required by validation, but ensure it's set
                if (!isset($data['scheduled_at']) || empty($data['scheduled_at'])) {
                    return redirect()
                        ->back()
                        ->withErrors(['scheduled_at' => 'Scheduled date is required when status is scheduled.'])
                        ->withInput();
                }
                
                // Validate that scheduled_at is in the future
                $scheduledAt = \Carbon\Carbon::parse($data['scheduled_at']);
                if (!$scheduledAt->isFuture()) {
                    return redirect()
                        ->back()
                        ->withErrors(['scheduled_at' => 'Scheduled date must be in the future.'])
                        ->withInput();
                }
                
                // Set approved_at if not already set (since scheduled articles are approved)
                if (!$newsSubmission->approved_at) {
                    $data['approved_at'] = now();
                    $data['approved_by'] = auth()->id();
                }
            } else {
                // Clear scheduled_at if status is not scheduled or approved
                if ($data['status'] !== 'scheduled' && $data['status'] !== 'approved') {
                    $data['scheduled_at'] = null;
                }
            }
        }
        
        $newsSubmission->update($data);

        // Sync category (single category only) if provided
        if (isset($data['categories']) && $data['categories']) {
            $newsSubmission->categories()->sync([$data['categories']]);
        }

        // Sync tags if provided
        if (isset($data['tag_names'])) {
            $tags = collect($data['tag_names'])->map(function($tagName) {
                return \App\Models\Tag::firstOrCreate(['name' => $tagName]);
            })->pluck('id');
            
            $newsSubmission->tags()->sync($tags);
        } else {
            $newsSubmission->tags()->sync([]);
        }

        return redirect()
            ->route('admin.news.show', $newsSubmission)
            ->with('success', 'News article has been updated successfully!');
    }

    /**
     * Approve a news submission
     */
    public function approve(Request $request, NewsSubmission $newsSubmission)
    {
        Gate::authorize('approve', $newsSubmission);

        // Check if scheduled_at is provided in the request
        $scheduledAt = $request->input('scheduled_at');
        $status = 'approved';
        
        // If scheduled_at is provided and is in the future, set status to scheduled
        if ($scheduledAt && !empty($scheduledAt)) {
            $scheduledDate = \Carbon\Carbon::parse($scheduledAt);
            if ($scheduledDate->isFuture()) {
                $status = 'scheduled';
            } else {
                // If scheduled date is today or in the past, ignore it
                $scheduledAt = null;
            }
        }

        $updateData = [
            'status' => $status,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ];
        
        if ($scheduledAt) {
            $updateData['scheduled_at'] = \Carbon\Carbon::parse($scheduledAt);
        }

        $newsSubmission->update($updateData);

        $message = $status === 'scheduled' 
            ? 'News submission has been approved and scheduled for publication.' 
            : 'News submission has been approved successfully!';

        return redirect()
            ->back()
            ->with('success', $message);
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



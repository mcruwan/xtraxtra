<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsSubmissionRequest;
use App\Models\Category;
use App\Models\NewsSubmission;
use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsSubmissionController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        
        $query = Auth::user()->university->newsSubmissions()
            ->with(['user', 'categories', 'tags'])
            ->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $newsSubmissions = $query->paginate(15);

        $stats = [
            'total' => Auth::user()->university->newsSubmissions()->count(),
            'drafts' => Auth::user()->university->newsSubmissions()->drafts()->count(),
            'pending' => Auth::user()->university->newsSubmissions()->pending()->count(),
            'approved' => Auth::user()->university->newsSubmissions()->approved()->count(),
            'published' => Auth::user()->university->newsSubmissions()->published()->count(),
            'rejected' => Auth::user()->university->newsSubmissions()->rejected()->count(),
        ];

        return view('university.news.index', compact('newsSubmissions', 'stats', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        
        return view('university.news.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsSubmissionRequest $request)
    {
        $data = $request->validated();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $count = 1;
        while (NewsSubmission::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')
                ->store('news-images', 'public');
        }

        // Set university and user
        $data['university_id'] = Auth::user()->university_id;
        $data['user_id'] = Auth::id();

        // Set submitted_at if status is pending
        if (isset($data['status']) && $data['status'] === 'pending') {
            $data['submitted_at'] = now();
        }

        // Create news submission
        $newsSubmission = NewsSubmission::create($data);

        // Attach categories
        if ($request->has('categories')) {
            $newsSubmission->categories()->sync($request->categories);
        }
        
        // Handle tags - create new ones that don't exist
        if ($request->has('tag_names')) {
            $tagIds = [];
            foreach ($request->tag_names as $tagName) {
                $tagName = trim($tagName);
                if (empty($tagName)) {
                    continue;
                }
                
                // Find or create the tag
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                
                $tagIds[] = $tag->id;
            }
            
            // Sync all tags to the news submission
            $newsSubmission->tags()->sync($tagIds);
        }

        $message = $newsSubmission->status === 'pending' 
            ? 'News submission submitted for approval successfully!' 
            : 'News submission saved as draft successfully!';

        return redirect()->route('university.news.index')
            ->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsSubmission $newsSubmission)
    {
        // Ensure user can only view their university's submissions
        $this->authorize('view', $newsSubmission);

        $newsSubmission->load(['user', 'categories', 'tags', 'approver']);

        return view('university.news.show', compact('newsSubmission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsSubmission $newsSubmission)
    {
        // Ensure user can only edit their university's submissions
        $this->authorize('update', $newsSubmission);

        // Can't edit if approved, rejected, or published
        if (in_array($newsSubmission->status, ['approved', 'rejected', 'published'])) {
            return redirect()->route('university.news.show', $newsSubmission)
                ->with('error', 'You cannot edit a submission that has been ' . $newsSubmission->status . '.');
        }

        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('university.news.edit', compact('newsSubmission', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsSubmissionRequest $request, NewsSubmission $newsSubmission)
    {
        // Ensure user can only update their university's submissions
        $this->authorize('update', $newsSubmission);

        // Can't edit if approved, rejected, or published
        if (in_array($newsSubmission->status, ['approved', 'rejected', 'published'])) {
            return redirect()->route('university.news.show', $newsSubmission)
                ->with('error', 'You cannot edit a submission that has been ' . $newsSubmission->status . '.');
        }

        $data = $request->validated();

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Ensure slug is unique (excluding current submission)
        $originalSlug = $data['slug'];
        $count = 1;
        while (NewsSubmission::where('slug', $data['slug'])->where('id', '!=', $newsSubmission->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($newsSubmission->featured_image) {
                Storage::disk('public')->delete($newsSubmission->featured_image);
            }
            
            $data['featured_image'] = $request->file('featured_image')
                ->store('news-images', 'public');
        }

        // Set submitted_at if status changed to pending
        if (isset($data['status']) && $data['status'] === 'pending' && $newsSubmission->status === 'draft') {
            $data['submitted_at'] = now();
        }

        // Update news submission
        $newsSubmission->update($data);

        // Sync categories
        if ($request->has('categories')) {
            $newsSubmission->categories()->sync($request->categories);
        } else {
            $newsSubmission->categories()->sync([]);
        }
        
        // Handle tags - create new ones that don't exist
        if ($request->has('tag_names')) {
            $tagIds = [];
            foreach ($request->tag_names as $tagName) {
                $tagName = trim($tagName);
                if (empty($tagName)) {
                    continue;
                }
                
                // Find or create the tag
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                
                $tagIds[] = $tag->id;
            }
            
            $newsSubmission->tags()->sync($tagIds);
        } else {
            $newsSubmission->tags()->sync([]);
        }

        $message = $newsSubmission->status === 'pending' 
            ? 'News submission submitted for approval successfully!' 
            : 'News submission updated successfully!';

        return redirect()->route('university.news.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsSubmission $newsSubmission)
    {
        // Ensure user can only delete their university's submissions
        $this->authorize('delete', $newsSubmission);

        // Can't delete if approved or published
        if (in_array($newsSubmission->status, ['approved', 'published'])) {
            return redirect()->route('university.news.index')
                ->with('error', 'You cannot delete a submission that has been ' . $newsSubmission->status . '.');
        }

        // Delete featured image if exists
        if ($newsSubmission->featured_image) {
            Storage::disk('public')->delete($newsSubmission->featured_image);
        }

        $newsSubmission->delete();

        return redirect()->route('university.news.index')
            ->with('success', 'News submission deleted successfully!');
    }
}

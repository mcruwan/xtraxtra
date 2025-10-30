<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\University;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of all FAQs
     */
    public function index(Request $request)
    {
        $query = Faq::with('university');

        // Search by question or answer
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        // Filter by university
        if ($request->filled('university_id')) {
            $query->where('university_id', $request->university_id);
        }

        // Filter by active status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }

        // Sort by specified column
        $sortBy = $request->get('sort_by', 'order');
        $sortDirection = in_array($request->get('sort_direction', 'asc'), ['asc', 'desc']) 
            ? $request->get('sort_direction', 'asc') 
            : 'asc';

        $validSortColumns = ['id', 'question', 'order', 'is_active', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'order';
        }

        $faqs = $query->orderBy($sortBy, $sortDirection)
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Get universities for filter dropdown
        $universities = University::orderBy('name')->get(['id', 'name']);

        return view('admin.faqs.index', compact('faqs', 'universities', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new FAQ
     */
    public function create()
    {
        $universities = University::where('status', 'active')->orderBy('name')->get(['id', 'name']);
        return view('admin.faqs.create', compact('universities'));
    }

    /**
     * Store a newly created FAQ in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'university_id' => ['required', 'exists:universities,id'],
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        $faq = Faq::create($validated);

        return redirect()
            ->route('admin.faqs.show', $faq)
            ->with('success', 'FAQ created successfully!');
    }

    /**
     * Display the specified FAQ
     */
    public function show(Faq $faq)
    {
        $faq->load('university');
        return view('admin.faqs.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified FAQ
     */
    public function edit(Faq $faq)
    {
        $faq->load('university');
        $universities = University::where('status', 'active')->orderBy('name')->get(['id', 'name']);
        return view('admin.faqs.edit', compact('faq', 'universities'));
    }

    /**
     * Update the specified FAQ in storage
     */
    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'university_id' => ['required', 'exists:universities,id'],
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['order'] = $validated['order'] ?? $faq->order;
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : $faq->is_active;

        $faq->update($validated);

        return redirect()
            ->route('admin.faqs.show', $faq)
            ->with('success', 'FAQ updated successfully!');
    }

    /**
     * Remove the specified FAQ from storage
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', 'FAQ deleted successfully!');
    }
}

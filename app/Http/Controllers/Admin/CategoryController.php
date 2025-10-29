<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories
     */
    public function index(Request $request)
    {
        $query = Category::query();

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Sort by specified column
        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = in_array($request->get('sort_direction', 'asc'), ['asc', 'desc']) 
            ? $request->get('sort_direction', 'asc') 
            : 'asc';

        $validSortColumns = ['id', 'name', 'slug', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'name';
        }

        $categories = $query->orderBy($sortBy, $sortDirection)
            ->withCount('newsSubmissions')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact('categories', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage
     */
    public function store(CategoryFormRequest $request)
    {
        $data = $request->validated();

        // Generate slug from name if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $count = 1;
        while (Category::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        $category = Category::create($data);

        return redirect()
            ->route('admin.categories.show', $category)
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified category
     */
    public function show(Category $category)
    {
        $category->load('newsSubmissions');
        
        // Get recent submissions in this category
        $recentSubmissions = $category->newsSubmissions()
            ->latest('created_at')
            ->limit(10)
            ->get();

        return view('admin.categories.show', compact('category', 'recentSubmissions'));
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage
     */
    public function update(CategoryFormRequest $request, Category $category)
    {
        $data = $request->validated();

        // Generate slug from name if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Ensure slug is unique (excluding current category)
        $originalSlug = $data['slug'];
        $count = 1;
        while (Category::where('slug', $data['slug'])->where('id', '!=', $category->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        $category->update($data);

        return redirect()
            ->route('admin.categories.show', $category)
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category from storage
     */
    public function destroy(Category $category)
    {
        // Check if category has any news submissions
        if ($category->newsSubmissions()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'Cannot delete this category as it has ' . $category->newsSubmissions()->count() . ' associated news submission(s). Please reassign or remove them first.');
        }

        $categoryName = $category->name;
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Category '{$categoryName}' deleted successfully!");
    }

    /**
     * Bulk delete categories
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $categories = Category::whereIn('id', $request->category_ids)->get();
        $deletedCount = 0;
        $failedCount = 0;

        foreach ($categories as $category) {
            if ($category->newsSubmissions()->count() === 0) {
                $category->delete();
                $deletedCount++;
            } else {
                $failedCount++;
            }
        }

        $message = "Deleted $deletedCount category(ies).";
        if ($failedCount > 0) {
            $message .= " Could not delete $failedCount category(ies) with associated submissions.";
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', $message);
    }
}


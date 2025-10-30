<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Only show active FAQs for the university
        $query = Auth::user()->university->faqs()->where('is_active', true);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        // Order by order column and created_at
        $faqs = $query->ordered()->paginate(15)->withQueryString();

        return view('university.faqs.index', compact('faqs'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        // Ensure user can only view their university's FAQs
        if ($faq->university_id !== Auth::user()->university_id) {
            abort(403, 'Unauthorized access.');
        }

        // Only show active FAQs
        if (!$faq->is_active) {
            abort(404, 'FAQ not found.');
        }

        return view('university.faqs.show', compact('faq'));
    }
}


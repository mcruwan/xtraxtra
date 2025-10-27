<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $university = auth()->user()->university;
        
        $stats = [
            'total_news' => $university->newsSubmissions()->count(),
            'drafts' => $university->newsSubmissions()->drafts()->count(),
            'pending' => $university->newsSubmissions()->pending()->count(),
            'approved' => $university->newsSubmissions()->approved()->count(),
            'published' => $university->newsSubmissions()->published()->count(),
            'rejected' => $university->newsSubmissions()->rejected()->count(),
        ];

        // Recent submissions
        $recentNews = $university->newsSubmissions()
            ->with(['user', 'categories'])
            ->latest()
            ->take(5)
            ->get();

        return view('university.dashboard', compact('stats', 'recentNews'));
    }
}

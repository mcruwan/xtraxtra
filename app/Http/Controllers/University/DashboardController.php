<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $university = auth()->user()->university;
        
        // Check if user has a university assigned
        if (!$university) {
            abort(403, 'No university assigned to your account. Please contact administrator.');
        }
        
        // Basic stats
        $stats = [
            'total_news' => $university->newsSubmissions()->count(),
            'drafts' => $university->newsSubmissions()->drafts()->count(),
            'pending' => $university->newsSubmissions()->pending()->count(),
            'approved' => $university->newsSubmissions()->approved()->count(),
            'published' => $university->newsSubmissions()->published()->count(),
            'rejected' => $university->newsSubmissions()->rejected()->count(),
        ];

        // Calculate approval rate
        $totalReviewed = $stats['approved'] + $stats['rejected'];
        $stats['approval_rate'] = $totalReviewed > 0 ? round(($stats['approved'] / $totalReviewed) * 100, 1) : 0;

        // Submission trends - Last 30 days
        $submissionTrends = $university->newsSubmissions()
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        // Fill in missing dates with 0
        $trendData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $trendData[$date] = $submissionTrends->get($date, 0);
        }

        // Category performance
        $categoryPerformance = DB::table('news_submissions')
            ->join('news_submission_category', 'news_submissions.id', '=', 'news_submission_category.news_submission_id')
            ->join('categories', 'news_submission_category.category_id', '=', 'categories.id')
            ->where('news_submissions.university_id', $university->id)
            ->select('categories.name', 
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN news_submissions.status = "approved" OR news_submissions.status = "published" THEN 1 ELSE 0 END) as approved'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // This month's submissions
        $stats['this_month_submissions'] = $university->newsSubmissions()
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Recent submissions
        $recentNews = $university->newsSubmissions()
            ->with(['user', 'categories'])
            ->latest()
            ->take(5)
            ->get();

        return view('university.dashboard', compact('stats', 'recentNews', 'trendData', 'categoryPerformance'));
    }
}

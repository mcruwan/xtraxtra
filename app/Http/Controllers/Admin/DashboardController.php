<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\NewsSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats
        $stats = [
            'pending_universities' => University::where('status', 'pending')->count(),
            'active_universities' => University::where('status', 'active')->count(),
            'total_universities' => University::count(),
            
            // News submission stats
            'pending_news' => NewsSubmission::pending()->count(),
            'approved_news' => NewsSubmission::approved()->count(),
            'rejected_news' => NewsSubmission::rejected()->count(),
            'published_news' => NewsSubmission::where('status', 'published')->count(),
            'draft_news' => NewsSubmission::where('status', 'draft')->count(),
            'total_news' => NewsSubmission::count(),
        ];

        // Platform growth trends - Last 30 days
        $universityTrends = University::where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        $submissionTrends = NewsSubmission::where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        // Fill in missing dates with 0
        $trendData = [
            'dates' => [],
            'universities' => [],
            'submissions' => [],
        ];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $trendData['dates'][] = Carbon::now()->subDays($i)->format('M d');
            $trendData['universities'][] = $universityTrends->get($date, 0);
            $trendData['submissions'][] = $submissionTrends->get($date, 0);
        }

        // University leaderboard
        $universityLeaderboard = University::withCount('newsSubmissions')
            ->with(['newsSubmissions' => function($query) {
                $query->select('university_id', 
                    DB::raw('SUM(CASE WHEN status IN ("approved", "published") THEN 1 ELSE 0 END) as approved_count'),
                    DB::raw('COUNT(*) as total_count'))
                ->groupBy('university_id');
            }])
            ->where('status', 'active')
            ->orderByDesc('news_submissions_count')
            ->limit(5)
            ->get()
            ->map(function($university) {
                $totalSubmissions = $university->news_submissions_count;
                $approvedCount = $university->newsSubmissions()
                    ->whereIn('status', ['approved', 'published'])
                    ->count();
                
                return [
                    'name' => $university->name,
                    'total_submissions' => $totalSubmissions,
                    'approved' => $approvedCount,
                    'approval_rate' => $totalSubmissions > 0 ? round(($approvedCount / $totalSubmissions) * 100, 1) : 0,
                ];
            });

        // Average review time
        $avgReviewTime = NewsSubmission::whereNotNull('submitted_at')
            ->whereNotNull('approved_at')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(HOUR, submitted_at, approved_at)) as avg_hours'))
            ->value('avg_hours');
        $stats['avg_review_hours'] = $avgReviewTime ? round($avgReviewTime, 1) : null;

        // Category analytics
        $categoryStats = DB::table('news_submissions')
            ->join('news_submission_category', 'news_submissions.id', '=', 'news_submission_category.news_submission_id')
            ->join('categories', 'news_submission_category.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('COUNT(*) as count'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Status distribution for funnel
        $statusDistribution = [
            'draft' => $stats['draft_news'],
            'pending' => $stats['pending_news'],
            'approved' => $stats['approved_news'],
            'published' => $stats['published_news'],
            'rejected' => $stats['rejected_news'],
        ];

        // Recent platform activity
        $recentActivity = NewsSubmission::with(['university', 'user'])
            ->whereIn('status', ['pending', 'approved', 'published'])
            ->latest('updated_at')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'trendData', 
            'universityLeaderboard', 
            'categoryStats', 
            'statusDistribution',
            'recentActivity'
        ));
    }
}

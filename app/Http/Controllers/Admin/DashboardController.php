<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending_universities' => University::where('status', 'pending')->count(),
            'active_universities' => University::where('status', 'active')->count(),
            'total_universities' => University::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}

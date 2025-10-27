<?php

namespace App\Providers;

use App\Models\NewsSubmission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('layouts.admin-layout', 'admin-layout');
        Blade::component('layouts.university-layout', 'university-layout');
        
        // Bind 'news' route parameter to NewsSubmission model
        Route::bind('news', function ($value) {
            return NewsSubmission::findOrFail($value);
        });
        
        // Bind 'newsSubmission' route parameter to NewsSubmission model
        Route::bind('newsSubmission', function ($value) {
            return NewsSubmission::findOrFail($value);
        });
        
        // Share pending news count with admin layout views
        view()->composer('layouts.admin-layout', function ($view) {
            if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())) {
                $pendingNewsCount = NewsSubmission::pending()->count();
                $view->with('pendingNewsCount', $pendingNewsCount);
            }
        });
    }
}

<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\University\DashboardController as UniversityDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Flowbite demo page
Route::get('/demo-flowbite', function () {
    return view('demo-flowbite');
});

// Quick test route to verify test data exists
Route::get('/test-credentials', function() {
    $university = \App\Models\University::first();
    $user = \App\Models\User::where('role', 'university_user')->first();
    $news = \App\Models\NewsSubmission::count();
    
    return [
        'university' => $university ? $university->name : 'None',
        'user_email' => $user ? $user->email : 'None',
        'user_password' => 'password',
        'total_news' => $news,
        'news_list' => \App\Models\NewsSubmission::with('university')->get()->map(fn($n) => [
            'id' => $n->id,
            'title' => $n->title,
            'university' => $n->university->name,
            'status' => $n->status,
        ])->toArray(),
    ];
});

// Public university registration
Route::get('/university/register', [App\Http\Controllers\UniversityRegistrationController::class, 'create'])
    ->name('university.register.create');
Route::post('/university/register', [App\Http\Controllers\UniversityRegistrationController::class, 'store'])
    ->name('university.register.store');

// Role-based dashboard redirect
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isSuperAdmin() || $user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->isUniversityUser()) {
        return redirect()->route('university.dashboard');
    }
    
    abort(403, 'Unauthorized access.');
})->middleware(['auth'])->name('dashboard');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Category management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::post('/categories/bulk-delete', [App\Http\Controllers\Admin\CategoryController::class, 'bulkDelete'])
        ->name('categories.bulk-delete');
    
    // University management
    Route::resource('universities', App\Http\Controllers\Admin\UniversityController::class);
    Route::post('/universities/{university}/approve', [App\Http\Controllers\Admin\UniversityController::class, 'approve'])
        ->name('universities.approve');
    Route::post('/universities/{university}/reject', [App\Http\Controllers\Admin\UniversityController::class, 'reject'])
        ->name('universities.reject');
    
    // News submissions management
    Route::get('/news', [App\Http\Controllers\Admin\NewsSubmissionController::class, 'index'])
        ->name('news.index');
    Route::get('/news/{newsSubmission}', [App\Http\Controllers\Admin\NewsSubmissionController::class, 'show'])
        ->name('news.show');
    Route::get('/news/{newsSubmission}/edit', [App\Http\Controllers\Admin\NewsSubmissionController::class, 'edit'])
        ->name('news.edit');
    Route::put('/news/{newsSubmission}', [App\Http\Controllers\Admin\NewsSubmissionController::class, 'update'])
        ->name('news.update');
    Route::post('/news/{newsSubmission}/approve', [App\Http\Controllers\Admin\NewsSubmissionController::class, 'approve'])
        ->name('news.approve');
    Route::post('/news/{newsSubmission}/reject', [App\Http\Controllers\Admin\NewsSubmissionController::class, 'reject'])
        ->name('news.reject');
    Route::post('/news/bulk-approve', [App\Http\Controllers\Admin\NewsSubmissionController::class, 'bulkApprove'])
        ->name('news.bulk-approve');
    
    // FAQ management
    Route::resource('faqs', App\Http\Controllers\Admin\FaqController::class);
    
    // Admin user management (only super admins can manage)
    Route::resource('admin-users', App\Http\Controllers\Admin\AdminUserController::class)->names([
        'index' => 'admin-users.index',
        'create' => 'admin-users.create',
        'store' => 'admin-users.store',
        'show' => 'admin-users.show',
        'edit' => 'admin-users.edit',
        'update' => 'admin-users.update',
        'destroy' => 'admin-users.destroy',
    ]);
    
    // University user management
    Route::resource('university-users', App\Http\Controllers\Admin\UniversityUserController::class)->names([
        'index' => 'university-users.index',
        'create' => 'university-users.create',
        'store' => 'university-users.store',
        'show' => 'university-users.show',
        'edit' => 'university-users.edit',
        'update' => 'university-users.update',
        'destroy' => 'university-users.destroy',
    ]);
    Route::post('/university-users/{universityUser}/reset-password', [App\Http\Controllers\Admin\UniversityUserController::class, 'resetPassword'])
        ->name('university-users.reset-password');
    Route::post('/university-users/{universityUser}/generate-password', [App\Http\Controllers\Admin\UniversityUserController::class, 'generatePassword'])
        ->name('university-users.generate-password');
    
    // Settings management
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])
        ->name('settings.index');
    Route::post('/settings/logo', [App\Http\Controllers\Admin\SettingsController::class, 'updateLogo'])
        ->name('settings.logo.update');
    Route::delete('/settings/logo', [App\Http\Controllers\Admin\SettingsController::class, 'removeLogo'])
        ->name('settings.logo.remove');
    Route::put('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])
        ->name('settings.update');
    Route::put('/settings/email-api', [App\Http\Controllers\Admin\SettingsController::class, 'updateEmailApi'])
        ->name('settings.update-email-api');
    Route::post('/settings/test-brevo-api', [App\Http\Controllers\Admin\SettingsController::class, 'testBrevoApi'])
        ->name('settings.test-brevo-api');
    
    // Storage diagnostics
    Route::get('/diagnostics/storage', [App\Http\Controllers\Admin\StorageDiagnosticController::class, 'index'])
        ->name('diagnostics.storage');
});

// University routes
Route::middleware(['auth', 'university_user'])->prefix('university')->name('university.')->group(function () {
    Route::get('/dashboard', [UniversityDashboardController::class, 'index'])->name('dashboard');
    
    // News submissions
    Route::resource('news', App\Http\Controllers\University\NewsSubmissionController::class);
    
    // FAQs (read-only for universities - knowledge base)
    Route::get('/faqs', [App\Http\Controllers\University\FaqController::class, 'index'])->name('faqs.index');
    Route::get('/faqs/{faq}', [App\Http\Controllers\University\FaqController::class, 'show'])->name('faqs.show');
});

// Profile routes (accessible to all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/university', [ProfileController::class, 'updateUniversity'])->name('profile.university.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

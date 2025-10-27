<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\University\DashboardController as UniversityDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
    
    // University management
    Route::resource('universities', App\Http\Controllers\Admin\UniversityController::class);
    Route::post('/universities/{university}/approve', [App\Http\Controllers\Admin\UniversityController::class, 'approve'])
        ->name('universities.approve');
    Route::post('/universities/{university}/reject', [App\Http\Controllers\Admin\UniversityController::class, 'reject'])
        ->name('universities.reject');
});

// University routes
Route::middleware(['auth', 'university_user'])->prefix('university')->name('university.')->group(function () {
    Route::get('/dashboard', [UniversityDashboardController::class, 'index'])->name('dashboard');
});

// Profile routes (accessible to all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

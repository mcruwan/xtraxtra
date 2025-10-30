<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ImpersonationController extends Controller
{
    /**
     * Impersonate a university by logging in as one of its users.
     */
    public function impersonate(University $university)
    {
        // Ensure only admins can impersonate
        if (!auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Find an active university user for this university
        $universityUser = $university->users()
            ->where('role', 'university_user')
            ->where('status', 'active')
            ->first();

        if (!$universityUser) {
            return redirect()->back()->with('error', 'No active university user found for this university. Please create an active user first.');
        }

        // Store the original admin user ID in session
        Session::put('impersonating_admin_id', auth()->id());
        Session::put('impersonating', true);

        // Login as the university user
        Auth::login($universityUser);

        // Regenerate session to prevent fixation attacks
        request()->session()->regenerate();

        return redirect()->route('university.dashboard')
            ->with('success', "You are now logged in as {$universityUser->name} from {$university->name}");
    }

    /**
     * Stop impersonating and return to admin account.
     */
    public function stopImpersonating()
    {
        if (!Session::has('impersonating_admin_id')) {
            return redirect()->route('dashboard');
        }

        $adminId = Session::get('impersonating_admin_id');
        
        // Clear impersonation session data
        Session::forget('impersonating_admin_id');
        Session::forget('impersonating');

        // Find and login as the original admin
        $admin = User::find($adminId);
        
        if ($admin) {
            Auth::login($admin);
            request()->session()->regenerate();
            
            return redirect()->route('admin.dashboard')
                ->with('success', 'You have stopped impersonating and returned to your admin account.');
        }

        // Fallback if admin not found
        Auth::logout();
        return redirect()->route('login');
    }
}


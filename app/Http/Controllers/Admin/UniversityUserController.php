<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UniversityUserFormRequest;
use App\Models\User;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UniversityUserController extends Controller
{
    /**
     * Display a listing of all university users
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'university_user')->with('university');

        // Search by name, email, or university name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('university', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by university
        if ($request->filled('university_id')) {
            $query->where('university_id', $request->university_id);
        }

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['active', 'inactive', 'pending'])) {
            $query->where('status', $request->status);
        }

        // Sort by specified column
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = in_array($request->get('sort_direction', 'desc'), ['asc', 'desc']) 
            ? $request->get('sort_direction', 'desc') 
            : 'desc';

        $validSortColumns = ['id', 'name', 'email', 'status', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'created_at';
        }

        $universityUsers = $query->orderBy($sortBy, $sortDirection)
            ->withCount('newsSubmissions')
            ->paginate(15)
            ->withQueryString();

        // Get all universities for filter dropdown
        $universities = University::orderBy('name')->get();

        return view('admin.university-users.index', compact('universityUsers', 'universities', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new university user
     */
    public function create()
    {
        $universities = University::where('status', 'active')->orderBy('name')->get();
        return view('admin.university-users.create', compact('universities'));
    }

    /**
     * Store a newly created university user in storage
     */
    public function store(UniversityUserFormRequest $request)
    {
        $data = $request->validated();
        
        // Hash the password
        $data['password'] = Hash::make($data['password']);
        
        // Set role to university_user
        $data['role'] = 'university_user';

        $universityUser = User::create($data);

        return redirect()
            ->route('admin.university-users.show', $universityUser)
            ->with('success', 'University user created successfully!');
    }

    /**
     * Display the specified university user
     */
    public function show(User $universityUser)
    {
        // Ensure we're viewing a university user
        if ($universityUser->role !== 'university_user') {
            abort(404);
        }

        $universityUser->load(['university', 'newsSubmissions']);
        
        // Get recent submissions
        $recentSubmissions = $universityUser->newsSubmissions()
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.university-users.show', compact('universityUser', 'recentSubmissions'));
    }

    /**
     * Show the form for editing the specified university user
     */
    public function edit(User $universityUser)
    {
        // Ensure we're editing a university user
        if ($universityUser->role !== 'university_user') {
            abort(404);
        }

        $universities = University::orderBy('name')->get();
        return view('admin.university-users.edit', compact('universityUser', 'universities'));
    }

    /**
     * Update the specified university user in storage
     */
    public function update(UniversityUserFormRequest $request, User $universityUser)
    {
        // Ensure we're updating a university user
        if ($universityUser->role !== 'university_user') {
            abort(404);
        }

        $data = $request->validated();

        // Only hash password if it's being updated
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Ensure role remains university_user
        $data['role'] = 'university_user';

        $universityUser->update($data);

        return redirect()
            ->route('admin.university-users.show', $universityUser)
            ->with('success', 'University user updated successfully!');
    }

    /**
     * Remove the specified university user from storage
     * 
     * DISABLED: User deletion is not allowed for security reasons.
     */
    public function destroy(User $universityUser)
    {
        // User deletion is disabled for all users
        return redirect()
            ->back()
            ->with('error', 'User deletion is disabled. Users cannot be deleted for security and data integrity reasons.');
    }

    /**
     * Reset password for a university user
     */
    public function resetPassword(Request $request, User $universityUser)
    {
        // Ensure we're resetting password for a university user
        if ($universityUser->role !== 'university_user') {
            abort(404);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $universityUser->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('admin.university-users.show', $universityUser)
            ->with('success', 'Password has been reset successfully!');
    }

    /**
     * Generate a random password for a university user
     */
    public function generatePassword(Request $request, User $universityUser)
    {
        // Ensure we're generating password for a university user
        if ($universityUser->role !== 'university_user') {
            abort(404);
        }

        // Generate a random secure password
        $newPassword = Str::random(12);
        
        $universityUser->update([
            'password' => Hash::make($newPassword),
        ]);

        return redirect()
            ->route('admin.university-users.show', $universityUser)
            ->with('success', 'Password has been generated and reset successfully!')
            ->with('generated_password', $newPassword);
    }
}


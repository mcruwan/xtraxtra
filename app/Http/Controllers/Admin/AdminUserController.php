<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of all admin users
     */
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'super_admin']);

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role') && in_array($request->role, ['admin', 'super_admin'])) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['active', 'inactive'])) {
            $query->where('status', $request->status);
        }

        // Sort by specified column
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = in_array($request->get('sort_direction', 'desc'), ['asc', 'desc']) 
            ? $request->get('sort_direction', 'desc') 
            : 'desc';

        $validSortColumns = ['id', 'name', 'email', 'role', 'status', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'created_at';
        }

        $adminUsers = $query->orderBy($sortBy, $sortDirection)
            ->paginate(15)
            ->withQueryString();

        return view('admin.admin-users.index', compact('adminUsers', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new admin user
     */
    public function create()
    {
        return view('admin.admin-users.create');
    }

    /**
     * Store a newly created admin user in storage
     */
    public function store(AdminUserFormRequest $request)
    {
        $data = $request->validated();
        
        // Hash the password
        $data['password'] = Hash::make($data['password']);
        
        // Ensure university_id is null for admin users
        $data['university_id'] = null;

        $adminUser = User::create($data);

        return redirect()
            ->route('admin.admin-users.show', $adminUser)
            ->with('success', 'Admin user created successfully!');
    }

    /**
     * Display the specified admin user
     */
    public function show(User $adminUser)
    {
        // Ensure we're viewing an admin/super_admin user
        if (!in_array($adminUser->role, ['admin', 'super_admin'])) {
            abort(404);
        }

        return view('admin.admin-users.show', compact('adminUser'));
    }

    /**
     * Show the form for editing the specified admin user
     */
    public function edit(User $adminUser)
    {
        // Ensure we're editing an admin/super_admin user
        if (!in_array($adminUser->role, ['admin', 'super_admin'])) {
            abort(404);
        }

        return view('admin.admin-users.edit', compact('adminUser'));
    }

    /**
     * Update the specified admin user in storage
     */
    public function update(AdminUserFormRequest $request, User $adminUser)
    {
        // Ensure we're updating an admin/super_admin user
        if (!in_array($adminUser->role, ['admin', 'super_admin'])) {
            abort(404);
        }

        $data = $request->validated();

        // Only hash password if it's being updated
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Ensure university_id remains null for admin users
        $data['university_id'] = null;

        $adminUser->update($data);

        return redirect()
            ->route('admin.admin-users.show', $adminUser)
            ->with('success', 'Admin user updated successfully!');
    }

    /**
     * Remove the specified admin user from storage
     */
    public function destroy(User $adminUser)
    {
        // Ensure we're deleting an admin/super_admin user
        if (!in_array($adminUser->role, ['admin', 'super_admin'])) {
            abort(404);
        }

        // Prevent deleting the currently logged-in user
        if ($adminUser->id === auth()->id()) {
            return redirect()
                ->back()
                ->with('error', 'You cannot delete your own account.');
        }

        $adminUserEmail = $adminUser->email;
        $adminUser->delete();

        return redirect()
            ->route('admin.admin-users.index')
            ->with('success', "Admin user '{$adminUserEmail}' deleted successfully!");
    }
}


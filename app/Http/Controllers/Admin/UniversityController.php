<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UniversityController extends Controller
{
    /**
     * Display a listing of universities.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = University::with('users')->latest();
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $universities = $query->paginate(15);
        
        return view('admin.universities.index', compact('universities', 'status'));
    }

    /**
     * Show the form for creating a new university.
     */
    public function create()
    {
        return view('admin.universities.create');
    }

    /**
     * Store a newly created university in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:universities,name'],
            'domain' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'status' => ['required', 'in:pending,active,inactive'],
        ]);

        University::create($validated);

        return redirect()->route('admin.universities.index')
            ->with('success', 'University created successfully.');
    }

    /**
     * Display the specified university.
     */
    public function show(University $university)
    {
        $university->load('users');
        
        return view('admin.universities.show', compact('university'));
    }

    /**
     * Show the form for editing the specified university.
     */
    public function edit(University $university)
    {
        return view('admin.universities.edit', compact('university'));
    }

    /**
     * Update the specified university in storage.
     */
    public function update(Request $request, University $university)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:universities,name,' . $university->id],
            'domain' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'status' => ['required', 'in:pending,active,inactive'],
        ]);

        $university->update($validated);

        return redirect()->route('admin.universities.index')
            ->with('success', 'University updated successfully.');
    }

    /**
     * Remove the specified university from storage.
     */
    public function destroy(University $university)
    {
        $university->delete();

        return redirect()->route('admin.universities.index')
            ->with('success', 'University deleted successfully.');
    }

    /**
     * Approve a pending university.
     */
    public function approve(University $university)
    {
        if ($university->status !== 'pending') {
            return back()->with('error', 'Only pending universities can be approved.');
        }

        try {
            DB::beginTransaction();

            // Update university status
            $university->update(['status' => 'active']);

            // Activate all university users
            $university->users()->update(['status' => 'active']);

            DB::commit();

            return back()->with('success', 'University approved and users activated!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve university.');
        }
    }

    /**
     * Reject a pending university.
     */
    public function reject(University $university)
    {
        if ($university->status !== 'pending') {
            return back()->with('error', 'Only pending universities can be rejected.');
        }

        try {
            DB::beginTransaction();

            // Delete university and associated users (cascade)
            $university->delete();

            DB::commit();

            return back()->with('success', 'University registration rejected and removed.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to reject university.');
        }
    }
}

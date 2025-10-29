<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UniversityProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the university's profile information.
     */
    public function updateUniversity(UniversityProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Ensure user has a university and is authorized
        if (!$user->university) {
            abort(403, 'You do not have a university associated with your account.');
        }

        // Update university information
        $university = $user->university;
        $university->update([
            'name' => $request->input('university_name'),
            'domain' => $request->input('domain'),
            'contact_email' => $request->input('contact_email'),
        ]);

        return Redirect::route('profile.edit')
            ->with('status', 'university-updated')
            ->with('success', 'University information updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

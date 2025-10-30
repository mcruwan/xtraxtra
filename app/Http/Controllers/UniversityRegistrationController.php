<?php

namespace App\Http\Controllers;

use App\Http\Requests\UniversityRegistrationRequest;
use App\Models\University;
use App\Models\User;
use App\Models\Setting;
use App\Notifications\UniversityRegistrationReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UniversityRegistrationController extends Controller
{
    /**
     * Show the university registration form.
     */
    public function create()
    {
        return view('university.register');
    }

    /**
     * Handle university registration.
     */
    public function store(UniversityRegistrationRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create university
            $university = University::create([
                'name' => $request->university_name,
                'domain' => $request->domain,
                'contact_email' => $request->contact_email,
                'status' => 'pending',
            ]);

            // Create primary university admin user
            $adminUser = User::create([
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'university_id' => $university->id,
                'role' => 'university_user',
                'status' => 'pending', // Will be activated when university is approved
            ]);

            // Send registration received email if enabled
            if (Setting::get('enable_registration_received_notifications', '1') == '1') {
                $adminUser->notify(new UniversityRegistrationReceived($university));
            }

            DB::commit();

            return redirect()->route('login')
                ->with('success', 'University registration submitted successfully! You will receive an email once your registration is approved.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Registration failed. Please try again.');
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class SettingsController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        // Check if settings table exists
        if (!Schema::hasTable('settings')) {
            // Return empty collection if table doesn't exist
            $settings = collect([]);
            return view('admin.settings.index', compact('settings'))
                ->with('warning', 'Settings table does not exist. Please run the migration first.');
        }
        
        $settings = Setting::all()->keyBy('key');
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update platform logo
     */
    public function updateLogo(Request $request)
    {
        // Check if settings table exists
        if (!Schema::hasTable('settings')) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Settings table does not exist. Please run the migration first.');
        }

        $validated = $request->validate([
            'platform_logo' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ], [
            'platform_logo.required' => 'Please select a logo file to upload.',
            'platform_logo.image' => 'The uploaded file must be an image.',
            'platform_logo.mimes' => 'The logo must be a file of type: jpeg, jpg, png, gif, svg.',
            'platform_logo.max' => 'The logo may not be greater than 2MB in size.',
        ]);

        try {
            // Get old logo path to delete it later
            $oldLogoPath = Setting::get('platform_logo');

            // Store the new logo
            $path = $request->file('platform_logo')->store('logos', 'public');

            // Update the setting
            Setting::set('platform_logo', $path, 'image', 'Platform logo displayed in the header');

            // Delete old logo if exists
            if ($oldLogoPath) {
                Setting::deleteOldLogo($oldLogoPath);
            }

            return redirect()
                ->route('admin.settings.index')
                ->with('success', 'Platform logo updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to upload logo: ' . $e->getMessage());
        }
    }

    /**
     * Remove platform logo
     */
    public function removeLogo()
    {
        // Check if settings table exists
        if (!Schema::hasTable('settings')) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Settings table does not exist. Please run the migration first.');
        }

        try {
            $logoPath = Setting::get('platform_logo');

            if ($logoPath) {
                // Delete the file
                Setting::deleteOldLogo($logoPath);

                // Remove the setting
                Setting::where('key', 'platform_logo')->delete();

                return redirect()
                    ->route('admin.settings.index')
                    ->with('success', 'Platform logo removed successfully!');
            }

            return redirect()
                ->back()
                ->with('info', 'No logo to remove.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to remove logo: ' . $e->getMessage());
        }
    }

    /**
     * Update general settings
     */
    public function update(Request $request)
    {
        // Check if settings table exists
        if (!Schema::hasTable('settings')) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Settings table does not exist. Please run the migration first.');
        }

        $request->validate([
            'platform_name' => 'nullable|string|max:255',
            'platform_tagline' => 'nullable|string|max:500',
            'contact_email' => 'nullable|email|max:255',
        ]);

        try {
            if ($request->filled('platform_name')) {
                Setting::set('platform_name', $request->platform_name, 'text', 'Platform name');
            }

            if ($request->filled('platform_tagline')) {
                Setting::set('platform_tagline', $request->platform_tagline, 'text', 'Platform tagline');
            }

            if ($request->filled('contact_email')) {
                Setting::set('contact_email', $request->contact_email, 'text', 'Contact email address');
            }

            return redirect()
                ->route('admin.settings.index')
                ->with('success', 'Settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }

    /**
     * Update email and API settings
     */
    public function updateEmailApi(Request $request)
    {
        // Check if settings table exists
        if (!Schema::hasTable('settings')) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Settings table does not exist. Please run the migration first.');
        }

        $request->validate([
            'bravo_api_key' => 'nullable|string|max:255',
            'bravo_api_secret' => 'nullable|string|max:255',
            'bravo_api_base_url' => 'nullable|url|max:500',
        ], [
            'bravo_api_key.max' => 'API key cannot exceed 255 characters.',
            'bravo_api_secret.max' => 'API secret cannot exceed 255 characters.',
            'bravo_api_base_url.url' => 'Please provide a valid URL for the API base URL.',
            'bravo_api_base_url.max' => 'API base URL cannot exceed 500 characters.',
        ]);

        try {
            // Update Brevo API Key
            if ($request->filled('bravo_api_key')) {
                Setting::set('bravo_api_key', $request->bravo_api_key, 'text', 'Brevo API key for email service integration');
            }
            // Note: Only update if provided, don't delete if empty

            // Update Brevo API Secret
            if ($request->filled('bravo_api_secret')) {
                Setting::set('bravo_api_secret', $request->bravo_api_secret, 'text', 'Brevo API secret key for email service integration');
            }
            // Note: Only update if provided, don't delete if empty

            // Update Brevo API Base URL
            if ($request->filled('bravo_api_base_url')) {
                Setting::set('bravo_api_base_url', $request->bravo_api_base_url, 'text', 'Brevo API base URL endpoint');
            } else {
                // Allow clearing the base URL explicitly
                Setting::where('key', 'bravo_api_base_url')->delete();
            }

            return redirect()
                ->to(route('admin.settings.index') . '#email-api')
                ->with('success', 'Email & API settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update email & API settings: ' . $e->getMessage());
        }
    }

    /**
     * Test Brevo API key validity
     */
    public function testBrevoApi(Request $request)
    {
        $request->validate([
            'api_key' => 'required|string',
            'api_secret' => 'nullable|string',
            'base_url' => 'nullable|url',
        ]);

        try {
            $apiKey = $request->api_key;
            $baseUrl = $request->base_url ?? 'https://api.brevo.com';
            
            // Ensure base URL doesn't end with a slash
            $baseUrl = rtrim($baseUrl, '/');
            
            // Test the API key by fetching account information
            // Brevo API v3 uses the /account endpoint which requires authentication
            $response = Http::timeout(10)
                ->withHeaders([
                    'api-key' => $apiKey,
                    'Accept' => 'application/json',
                ])
                ->get($baseUrl . '/v3/account');

            if ($response->successful()) {
                $accountData = $response->json();
                
                return response()->json([
                    'success' => true,
                    'message' => 'API key is valid and working!',
                    'account' => [
                        'email' => $accountData['email'] ?? 'N/A',
                        'firstName' => $accountData['firstName'] ?? 'N/A',
                        'lastName' => $accountData['lastName'] ?? 'N/A',
                        'companyName' => $accountData['companyName'] ?? 'N/A',
                        'plan' => $accountData['plan'] ?? [],
                    ],
                ]);
            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? 'Invalid API key or connection failed';
                
                return response()->json([
                    'success' => false,
                    'message' => 'API key test failed: ' . $errorMessage,
                    'status_code' => $response->status(),
                ], $response->status());
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to connect to Brevo API. Please check your internet connection and API base URL.',
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while testing the API key: ' . $e->getMessage(),
            ], 500);
        }
    }
}


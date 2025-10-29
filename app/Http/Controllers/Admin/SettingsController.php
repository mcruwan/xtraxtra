<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update platform logo
     */
    public function updateLogo(Request $request)
    {
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
}


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
    public function updateLogo(Request $request, $type = 'dark')
    {
        // Check if settings table exists
        if (!Schema::hasTable('settings')) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Settings table does not exist. Please run the migration first.');
        }

        // Validate logo type
        if (!in_array($type, ['dark', 'light'])) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Invalid logo type. Must be "dark" or "light".');
        }

        $fieldName = $type === 'dark' ? 'platform_logo_dark' : 'platform_logo_light';
        $logoLabel = $type === 'dark' ? 'dark logo' : 'light logo';

        $validated = $request->validate([
            $fieldName => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ], [
            $fieldName . '.required' => 'Please select a logo file to upload.',
            $fieldName . '.image' => 'The uploaded file must be an image.',
            $fieldName . '.mimes' => 'The logo must be a file of type: jpeg, jpg, png, gif, svg.',
            $fieldName . '.max' => 'The logo may not be greater than 2MB in size.',
        ]);

        try {
            // Get old logo path to delete it later
            $settingKey = $type === 'dark' ? 'platform_logo_dark' : 'platform_logo_light';
            $oldLogoPath = Setting::get($settingKey);

            // Store the new logo
            $path = $request->file($fieldName)->store('logos', 'public');

            // Update the setting
            $description = $type === 'dark' 
                ? 'Platform dark logo displayed in the header (for light backgrounds)' 
                : 'Platform light logo displayed in the header (for dark backgrounds)';
            Setting::set($settingKey, $path, 'image', $description);

            // Delete old logo if exists
            if ($oldLogoPath) {
                Setting::deleteOldLogo($oldLogoPath);
            }

            return redirect()
                ->route('admin.settings.index')
                ->with('success', 'Platform ' . $logoLabel . ' updated successfully!');
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
    public function removeLogo($type = 'dark')
    {
        // Check if settings table exists
        if (!Schema::hasTable('settings')) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Settings table does not exist. Please run the migration first.');
        }

        // Validate logo type
        if (!in_array($type, ['dark', 'light'])) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Invalid logo type. Must be "dark" or "light".');
        }

        try {
            $settingKey = $type === 'dark' ? 'platform_logo_dark' : 'platform_logo_light';
            $logoLabel = $type === 'dark' ? 'dark logo' : 'light logo';
            $logoPath = Setting::get($settingKey);

            if ($logoPath) {
                // Delete the file
                Setting::deleteOldLogo($logoPath);

                // Remove the setting
                Setting::where('key', $settingKey)->delete();

                return redirect()
                    ->route('admin.settings.index')
                    ->with('success', 'Platform ' . $logoLabel . ' removed successfully!');
            }

            return redirect()
                ->back()
                ->with('info', 'No ' . $logoLabel . ' to remove.');
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
     * Test Brevo API key validity and send a test email
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
                
                // Send test email to rc@appliedhe.com
                $testEmail = 'rc@appliedhe.com';
                
                // Send a test email using the provided API key
                $emailSent = false;
                $emailMessage = '';
                
                try {
                    $emailPayload = [
                        'sender' => [
                            'name' => config('mail.from.name', 'AppliedHE Xtra Xtra'),
                            'email' => config('mail.from.address', 'info@appliedhe.com'),
                        ],
                        'to' => [
                            [
                                'email' => $testEmail,
                                'name' => 'Test Recipient',
                            ]
                        ],
                        'subject' => 'Brevo API Test Email',
                        'textContent' => 'This is a test email sent from XtraXtra to verify your Brevo API key configuration. If you received this email, your API key is working correctly and emails can be sent successfully.',
                        'htmlContent' => '<html><body><h2>Brevo API Test Email</h2><p>This is a test email sent from XtraXtra to verify your Brevo API key configuration.</p><p>If you received this email, your API key is working correctly and emails can be sent successfully.</p><hr><p style="color: #666; font-size: 12px;">This is an automated test email from the XtraXtra platform.</p></body></html>',
                        'tags' => ['api-test', 'brevo-test'],
                    ];
                    
                    \Log::info('Attempting to send test email via Brevo', [
                        'to' => $testEmail,
                        'api_endpoint' => $baseUrl . '/v3/smtp/email'
                    ]);
                    
                    $emailResponse = Http::timeout(30)
                        ->withHeaders([
                            'api-key' => $apiKey,
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                        ])
                        ->post($baseUrl . '/v3/smtp/email', $emailPayload);
                    
                    \Log::info('Brevo email response', [
                        'status' => $emailResponse->status(),
                        'body' => $emailResponse->body(),
                    ]);
                    
                    if ($emailResponse->successful()) {
                        $emailSent = true;
                        $emailMessage = " Test email has been sent to {$testEmail}.";
                        \Log::info('Test email sent successfully', ['to' => $testEmail]);
                    } else {
                        $emailError = $emailResponse->json();
                        $errorMsg = $emailError['message'] ?? 'Unknown error';
                        $emailMessage = " However, failed to send test email: " . $errorMsg;
                        \Log::error('Failed to send test email via Brevo', [
                            'status' => $emailResponse->status(),
                            'error' => $emailError,
                            'to' => $testEmail
                        ]);
                    }
                } catch (\Exception $emailException) {
                    $emailMessage = " However, failed to send test email: " . $emailException->getMessage() . ".";
                    \Log::error('Exception while sending test email', [
                        'exception' => $emailException->getMessage(),
                        'to' => $testEmail
                    ]);
                }
                
                $message = 'API key is valid and working!' . $emailMessage;
                
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'email_sent' => $emailSent,
                    'test_email' => $testEmail,
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
                
                // Return 200 with success: false so Laravel doesn't intercept the error
                // The actual HTTP status from Brevo is included in the response for reference
                return response()->json([
                    'success' => false,
                    'message' => 'API key test failed: ' . $errorMessage,
                    'status_code' => $response->status(),
                    'error_details' => $errorData,
                ], 200);
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

    /**
     * Update email templates
     */
    public function updateEmailTemplates(Request $request)
    {
        // Check if settings table exists
        if (!Schema::hasTable('settings')) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Settings table does not exist. Please run the migration first.');
        }

        $request->validate([
            'template_type' => 'required|in:approval,rejection,registration_received,registration_approved',
            'enable_approval_notifications' => 'nullable|boolean',
            'approval_email_subject' => 'nullable|string|max:500',
            'approval_email_template' => 'nullable|string',
            'enable_rejection_notifications' => 'nullable|boolean',
            'rejection_email_subject' => 'nullable|string|max:500',
            'rejection_email_template' => 'nullable|string',
            'enable_registration_received_notifications' => 'nullable|boolean',
            'registration_received_email_subject' => 'nullable|string|max:500',
            'registration_received_email_template' => 'nullable|string',
            'enable_registration_approved_notifications' => 'nullable|boolean',
            'registration_approved_email_subject' => 'nullable|string|max:500',
            'registration_approved_email_template' => 'nullable|string',
        ], [
            'approval_email_subject.max' => 'Email subject cannot exceed 500 characters.',
            'rejection_email_subject.max' => 'Email subject cannot exceed 500 characters.',
            'registration_received_email_subject.max' => 'Email subject cannot exceed 500 characters.',
            'registration_approved_email_subject.max' => 'Email subject cannot exceed 500 characters.',
        ]);

        try {
            // Update based on template type
            if ($request->template_type === 'approval') {
                // Update Enable/Disable Toggle
                Setting::set(
                    'enable_approval_notifications', 
                    $request->has('enable_approval_notifications') ? '1' : '0', 
                    'boolean', 
                    'Enable email notifications when articles are approved'
                );

                // Update Email Subject
                if ($request->filled('approval_email_subject')) {
                    Setting::set('approval_email_subject', $request->approval_email_subject, 'text', 'Subject line for article approval emails');
                }

                // Update Email Template
                if ($request->filled('approval_email_template')) {
                    Setting::set('approval_email_template', $request->approval_email_template, 'textarea', 'HTML template for article approval emails');
                }
            } elseif ($request->template_type === 'rejection') {
                // Update Enable/Disable Toggle
                Setting::set(
                    'enable_rejection_notifications', 
                    $request->has('enable_rejection_notifications') ? '1' : '0', 
                    'boolean', 
                    'Enable email notifications when articles are rejected'
                );

                // Update Email Subject
                if ($request->filled('rejection_email_subject')) {
                    Setting::set('rejection_email_subject', $request->rejection_email_subject, 'text', 'Subject line for article rejection emails');
                }

                // Update Email Template
                if ($request->filled('rejection_email_template')) {
                    Setting::set('rejection_email_template', $request->rejection_email_template, 'textarea', 'HTML template for article rejection emails');
                }
            } elseif ($request->template_type === 'registration_received') {
                // Update Enable/Disable Toggle
                Setting::set(
                    'enable_registration_received_notifications', 
                    $request->has('enable_registration_received_notifications') ? '1' : '0', 
                    'boolean', 
                    'Enable email notifications when university registers'
                );

                // Update Email Subject
                if ($request->filled('registration_received_email_subject')) {
                    Setting::set('registration_received_email_subject', $request->registration_received_email_subject, 'text', 'Subject line for registration received emails');
                }

                // Update Email Template
                if ($request->filled('registration_received_email_template')) {
                    Setting::set('registration_received_email_template', $request->registration_received_email_template, 'textarea', 'HTML template for registration received emails');
                }
            } elseif ($request->template_type === 'registration_approved') {
                // Update Enable/Disable Toggle
                Setting::set(
                    'enable_registration_approved_notifications', 
                    $request->has('enable_registration_approved_notifications') ? '1' : '0', 
                    'boolean', 
                    'Enable email notifications when university is approved'
                );

                // Update Email Subject
                if ($request->filled('registration_approved_email_subject')) {
                    Setting::set('registration_approved_email_subject', $request->registration_approved_email_subject, 'text', 'Subject line for registration approved emails');
                }

                // Update Email Template
                if ($request->filled('registration_approved_email_template')) {
                    Setting::set('registration_approved_email_template', $request->registration_approved_email_template, 'textarea', 'HTML template for registration approved emails');
                }
            }

            return redirect()
                ->to(route('admin.settings.index') . '#email-templates')
                ->with('success', 'Email template updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update email template: ' . $e->getMessage());
        }
    }

    /**
     * Send test email for email templates
     */
    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'template_type' => 'required|in:approval,rejection,registration_received,registration_approved',
            'recipient_email' => 'required|email',
        ]);

        try {
            $recipientEmail = $request->recipient_email;
            $templateType = $request->template_type;

            // Get current user as sender
            $user = auth()->user();
            
            // Create dummy data for template variables
            $dummyData = $this->getDummyTemplateData($templateType);
            
            // Get email template and subject from settings
            if ($templateType === 'approval') {
                $emailTemplate = Setting::get('approval_email_template');
                $emailSubject = Setting::get('approval_email_subject', 'News Submission Approved - {{article_title}}');
            } elseif ($templateType === 'rejection') {
                $emailTemplate = Setting::get('rejection_email_template');
                $emailSubject = Setting::get('rejection_email_subject', 'News Submission Rejected - {{article_title}}');
            } elseif ($templateType === 'registration_received') {
                $emailTemplate = Setting::get('registration_received_email_template');
                $emailSubject = Setting::get('registration_received_email_subject', 'Registration Received - {{university_name}}');
            } elseif ($templateType === 'registration_approved') {
                $emailTemplate = Setting::get('registration_approved_email_template');
                $emailSubject = Setting::get('registration_approved_email_subject', 'Registration Approved - Welcome to {{platform_name}}!');
            }

            if (!$emailTemplate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email template not found. Please save the template first.',
                ], 404);
            }

            // Parse template variables
            $subject = $this->parseTestTemplate($emailSubject, $dummyData);
            $htmlContent = $this->parseTestTemplate($emailTemplate, $dummyData);

            // Check if Brevo API is configured
            $brevoService = new \App\Services\BrevoMailService();
            
            if ($brevoService->isConfigured()) {
                // Send via Brevo
                $result = $brevoService->sendTransactionalEmail([
                    'to' => [
                        'email' => $recipientEmail,
                        'name' => 'Test Recipient',
                    ],
                    'subject' => '[TEST] ' . $subject,
                    'html_content' => $htmlContent,
                    'tags' => ['test-email', $templateType],
                ]);

                if ($result['success']) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Test email sent successfully to ' . $recipientEmail,
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to send test email: ' . $result['message'],
                    ], 500);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Brevo API is not configured. Please configure your Brevo API credentials in the Email & API settings.',
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get dummy data for test email templates
     */
    private function getDummyTemplateData(string $templateType): array
    {
        $baseData = [
            '{{platform_name}}' => Setting::get('platform_name', 'XtraXtra'),
            '{{dashboard_url}}' => route('admin.settings.index') . '#email-templates',
        ];

        if ($templateType === 'approval' || $templateType === 'rejection') {
            // Article-related templates
            $baseData['{{user_name}}'] = 'John Doe';
            $baseData['{{user_email}}'] = 'johndoe@example.com';
            $baseData['{{article_title}}'] = 'Groundbreaking Research at University Lab';
            $baseData['{{article_excerpt}}'] = 'Scientists at the university have made a significant discovery in renewable energy technology that could revolutionize the industry.';
            $baseData['{{status}}'] = $templateType === 'approval' ? 'Approved' : 'Rejected';
            $baseData['{{university_name}}'] = 'Example University';

            if ($templateType === 'approval') {
                $baseData['{{approved_at}}'] = now()->format('F j, Y \a\t g:i A');
                $baseData['{{scheduled_at}}'] = now()->addDays(2)->format('F j, Y \a\t g:i A');
                $baseData['{{approver_name}}'] = auth()->user()->name ?? 'Admin';
            } else {
                $baseData['{{rejection_reason}}'] = 'The article content needs more detailed research and additional sources to support the claims. Please revise and include at least 3 authoritative references.';
                $baseData['{{rejected_at}}'] = now()->format('F j, Y \a\t g:i A');
                $baseData['{{rejector_name}}'] = auth()->user()->name ?? 'Admin';
            }
        } elseif ($templateType === 'registration_received' || $templateType === 'registration_approved') {
            // University registration-related templates
            $baseData['{{university_name}}'] = 'Example University';
            $baseData['{{admin_name}}'] = 'Jane Smith';
            $baseData['{{admin_email}}'] = 'admin@exampleuniversity.edu';
            $baseData['{{contact_email}}'] = 'contact@exampleuniversity.edu';

            if ($templateType === 'registration_received') {
                $baseData['{{registered_at}}'] = now()->format('F j, Y \a\t g:i A');
            } else {
                $baseData['{{approved_at}}'] = now()->format('F j, Y \a\t g:i A');
                $baseData['{{login_url}}'] = route('login');
            }
        }

        return $baseData;
    }

    /**
     * Parse template with test data
     */
    private function parseTestTemplate(string $template, array $data): string
    {
        return str_replace(array_keys($data), array_values($data), $template);
    }
}


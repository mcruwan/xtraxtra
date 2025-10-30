<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Template 1: Registration Received (sent immediately when university registers)
        $registrationReceivedTemplate = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Received</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f7;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1f2937;
        }
        .message {
            margin-bottom: 20px;
            color: #4b5563;
        }
        .info-box {
            background-color: #eff6ff;
            border-left: 4px solid: #3b82f6;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            color: #1f2937;
            font-size: 16px;
        }
        .info-box p {
            margin: 8px 0;
            color: #6b7280;
            font-size: 14px;
        }
        .info-box strong {
            color: #374151;
        }
        .next-steps {
            background-color: #fef3c7;
            border: 1px solid: #fcd34d;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .next-steps h4 {
            margin: 0 0 8px 0;
            color: #92400e;
            font-size: 14px;
            font-weight: 600;
        }
        .next-steps p {
            margin: 0;
            color: #78350f;
            font-size: 14px;
        }
        .footer {
            background-color: #f9fafb;
            padding: 25px 30px;
            text-align: center;
            color: #6b7280;
            font-size: 13px;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Registration Received</h1>
        </div>
        <div class="content">
            <div class="greeting">Hello {{admin_name}},</div>
            <div class="message">
                <p>Thank you for registering <strong>{{university_name}}</strong> with {{platform_name}}!</p>
                <p>We have received your registration request and our team is currently reviewing your application.</p>
            </div>
            <div class="info-box">
                <h3>Registration Details</h3>
                <p><strong>University Name:</strong> {{university_name}}</p>
                <p><strong>Contact Email:</strong> {{contact_email}}</p>
                <p><strong>Admin Name:</strong> {{admin_name}}</p>
                <p><strong>Admin Email:</strong> {{admin_email}}</p>
                <p><strong>Registered At:</strong> {{registered_at}}</p>
            </div>
            <div class="next-steps">
                <h4>What Happens Next?</h4>
                <p>Our team will review your registration within 1-2 business days. Once approved, you will receive another email with your login credentials and further instructions to get started.</p>
            </div>
            <div class="message">
                <p>If you have any questions in the meantime, please don\'t hesitate to contact our support team.</p>
            </div>
        </div>
        <div class="footer">
            <p><strong>Best regards,</strong></p>
            <p>The {{platform_name}} Team</p>
        </div>
    </div>
</body>
</html>';

        // Template 2: Registration Approved (sent when admin approves the university)
        $registrationApprovedTemplate = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Approved</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f7;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1f2937;
        }
        .message {
            margin-bottom: 20px;
            color: #4b5563;
        }
        .info-box {
            background-color: #d1fae5;
            border-left: 4px solid #10b981;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            color: #1f2937;
            font-size: 16px;
        }
        .info-box p {
            margin: 8px 0;
            color: #6b7280;
            font-size: 14px;
        }
        .info-box strong {
            color: #374151;
        }
        .credentials-box {
            background-color: #fef3c7;
            border: 2px solid #fbbf24;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
            text-align: center;
        }
        .credentials-box h4 {
            margin: 0 0 10px 0;
            color: #92400e;
            font-size: 16px;
            font-weight: 600;
        }
        .credentials-box p {
            margin: 5px 0;
            color: #78350f;
            font-size: 14px;
        }
        .credentials-box .credential {
            background-color: #ffffff;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            font-family: monospace;
        }
        .button {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .button:hover {
            opacity: 0.9;
        }
        .footer {
            background-color: #f9fafb;
            padding: 25px 30px;
            text-align: center;
            color: #6b7280;
            font-size: 13px;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Registration Approved!</h1>
        </div>
        <div class="content">
            <div class="greeting">Congratulations {{admin_name}},</div>
            <div class="message">
                <p>Great news! Your registration for <strong>{{university_name}}</strong> has been approved!</p>
                <p>You can now access the {{platform_name}} platform and start submitting news articles.</p>
            </div>
            <div class="info-box">
                <h3>Account Information</h3>
                <p><strong>University:</strong> {{university_name}}</p>
                <p><strong>Admin Name:</strong> {{admin_name}}</p>
                <p><strong>Login Email:</strong> {{admin_email}}</p>
                <p><strong>Status:</strong> Active</p>
                <p><strong>Approved At:</strong> {{approved_at}}</p>
            </div>
            <div class="credentials-box">
                <h4>🔐 Your Login Credentials</h4>
                <p>Use these credentials to access your account:</p>
                <div class="credential">
                    <strong>Email:</strong> {{admin_email}}
                </div>
                <p class="text-sm">Use the password you created during registration</p>
            </div>
            <div style="text-align: center;">
                <a href="{{login_url}}" class="button">Login to Dashboard</a>
            </div>
            <div class="message">
                <p><strong>Next Steps:</strong></p>
                <ul style="color: #4b5563; margin: 10px 0;">
                    <li>Login to your dashboard</li>
                    <li>Complete your university profile</li>
                    <li>Start submitting news articles</li>
                    <li>Track your submissions in real-time</li>
                </ul>
            </div>
            <div class="message">
                <p>If you need any assistance getting started, our support team is here to help!</p>
            </div>
        </div>
        <div class="footer">
            <p><strong>Welcome aboard!</strong></p>
            <p>The {{platform_name}} Team</p>
        </div>
    </div>
</body>
</html>';

        // Insert settings for Registration Received template
        DB::table('settings')->insertOrIgnore([
            [
                'key' => 'registration_received_email_subject',
                'value' => 'Registration Received - {{university_name}}',
                'type' => 'text',
                'description' => 'Subject line for registration received emails',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'registration_received_email_template',
                'value' => $registrationReceivedTemplate,
                'type' => 'textarea',
                'description' => 'HTML template for registration received emails',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'enable_registration_received_notifications',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable email notifications when university registers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert settings for Registration Approved template
        DB::table('settings')->insertOrIgnore([
            [
                'key' => 'registration_approved_email_subject',
                'value' => 'Registration Approved - Welcome to {{platform_name}}!',
                'type' => 'text',
                'description' => 'Subject line for registration approved emails',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'registration_approved_email_template',
                'value' => $registrationApprovedTemplate,
                'type' => 'textarea',
                'description' => 'HTML template for registration approved emails',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'enable_registration_approved_notifications',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable email notifications when university is approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove registration email template settings
        DB::table('settings')->whereIn('key', [
            'registration_received_email_subject',
            'registration_received_email_template',
            'enable_registration_received_notifications',
            'registration_approved_email_subject',
            'registration_approved_email_template',
            'enable_registration_approved_notifications',
        ])->delete();
    }
};

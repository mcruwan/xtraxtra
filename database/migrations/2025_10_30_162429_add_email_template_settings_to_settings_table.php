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
        // Insert default email template settings
        $defaultHtmlTemplate = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Submission Approved</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        .article-info {
            background-color: #f9fafb;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .article-info h3 {
            margin: 0 0 10px 0;
            color: #1f2937;
            font-size: 16px;
        }
        .article-info p {
            margin: 8px 0;
            color: #6b7280;
            font-size: 14px;
        }
        .article-info strong {
            color: #374151;
        }
        .button {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            <h1>✓ News Submission Approved</h1>
        </div>
        <div class="content">
            <div class="greeting">Hello {{user_name}},</div>
            <div class="message">
                <p>Great news! Your news submission has been approved by our editorial team.</p>
            </div>
            <div class="article-info">
                <h3>Article Details</h3>
                <p><strong>Title:</strong> {{article_title}}</p>
                <p><strong>Status:</strong> {{status}}</p>
                <p><strong>Approved At:</strong> {{approved_at}}</p>
                <p><strong>Approved By:</strong> {{approver_name}}</p>
            </div>
            <div class="message">
                <p>You can now view your approved article in your dashboard. Click the button below to access it:</p>
            </div>
            <div style="text-align: center;">
                <a href="{{dashboard_url}}" class="button">View Article in Dashboard</a>
            </div>
            <div class="message">
                <p>Thank you for your contribution to {{platform_name}}!</p>
            </div>
        </div>
        <div class="footer">
            <p><strong>Best regards,</strong></p>
            <p>The Editorial Team</p>
            <p style="margin-top: 15px;">{{platform_name}}</p>
        </div>
    </div>
</body>
</html>';

        // Insert or update email template settings
        DB::table('settings')->insertOrIgnore([
            [
                'key' => 'approval_email_subject',
                'value' => 'News Submission Approved - {{article_title}}',
                'type' => 'text',
                'description' => 'Subject line for article approval emails',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'approval_email_template',
                'value' => $defaultHtmlTemplate,
                'type' => 'textarea',
                'description' => 'HTML template for article approval emails',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'enable_approval_notifications',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable email notifications when articles are approved',
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
        // Remove email template settings
        DB::table('settings')->whereIn('key', [
            'approval_email_subject',
            'approval_email_template',
            'enable_approval_notifications',
        ])->delete();
    }
};

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
        // Insert default rejection email template settings
        $defaultRejectionHtmlTemplate = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Submission Rejected</title>
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
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
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
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
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
        .rejection-reason {
            background-color: #fff7ed;
            border: 1px solid #fdba74;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .rejection-reason h4 {
            margin: 0 0 8px 0;
            color: #c2410c;
            font-size: 14px;
            font-weight: 600;
        }
        .rejection-reason p {
            margin: 0;
            color: #9a3412;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
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
            <h1>✗ News Submission Rejected</h1>
        </div>
        <div class="content">
            <div class="greeting">Hello {{user_name}},</div>
            <div class="message">
                <p>Thank you for your submission. After careful review, we regret to inform you that your news article has been rejected.</p>
            </div>
            <div class="article-info">
                <h3>Article Details</h3>
                <p><strong>Title:</strong> {{article_title}}</p>
                <p><strong>Status:</strong> Rejected</p>
                <p><strong>Rejected At:</strong> {{rejected_at}}</p>
                <p><strong>Rejected By:</strong> {{rejector_name}}</p>
            </div>
            <div class="rejection-reason">
                <h4>Reason for Rejection:</h4>
                <p>{{rejection_reason}}</p>
            </div>
            <div class="message">
                <p>Please review the feedback above and make the necessary improvements. You are welcome to revise and resubmit your article.</p>
            </div>
            <div style="text-align: center;">
                <a href="{{dashboard_url}}" class="button">View Submission in Dashboard</a>
            </div>
            <div class="message">
                <p>If you have any questions about the rejection, please don\'t hesitate to contact our editorial team.</p>
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
                'key' => 'rejection_email_subject',
                'value' => 'News Submission Rejected - {{article_title}}',
                'type' => 'text',
                'description' => 'Subject line for article rejection emails',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'rejection_email_template',
                'value' => $defaultRejectionHtmlTemplate,
                'type' => 'textarea',
                'description' => 'HTML template for article rejection emails',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'enable_rejection_notifications',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable email notifications when articles are rejected',
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
        // Remove rejection email template settings
        DB::table('settings')->whereIn('key', [
            'rejection_email_subject',
            'rejection_email_template',
            'enable_rejection_notifications',
        ])->delete();
    }
};

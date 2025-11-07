<?php

namespace App\Notifications;

use App\Models\NewsSubmission;
use App\Models\Setting;
use App\Services\BrevoMailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NewsSubmissionRejected extends Notification implements ShouldQueue
{
    use Queueable;

    protected $newsSubmission;

    /**
     * Create a new notification instance.
     */
    public function __construct(NewsSubmission $newsSubmission)
    {
        $this->newsSubmission = $newsSubmission;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Check if Brevo API is configured
        $brevoService = new BrevoMailService();
        
        if ($brevoService->isConfigured()) {
            // Send via Brevo API
            return $this->sendViaBrevo($notifiable);
        }

        // Fallback to Laravel's default mail
        return $this->sendViaLaravelMail($notifiable);
    }

    /**
     * Send email via Brevo API
     */
    protected function sendViaBrevo(object $notifiable): MailMessage
    {
        $brevoService = new BrevoMailService();
        
        // Get email template from settings or use default
        $emailTemplate = Setting::get('rejection_email_template');
        $emailSubject = Setting::get('rejection_email_subject', 'News Submission Rejected - {{article_title}}');
        
        // Parse template variables
        $subject = $this->parseTemplate($emailSubject, $notifiable);
        $htmlContent = $this->parseTemplate(
            $emailTemplate ?? $this->getDefaultHtmlTemplate(),
            $notifiable
        );

        $result = $brevoService->sendTransactionalEmail([
            'to' => [
                'email' => $notifiable->email,
                'name' => $notifiable->name,
            ],
            'subject' => $subject,
            'html_content' => $htmlContent,
            'tags' => ['news-rejection', 'notification'],
        ]);

        if ($result['success']) {
            Log::info('Rejection email sent successfully via Brevo', [
                'user_id' => $notifiable->id,
                'user_email' => $notifiable->email,
                'news_submission_id' => $this->newsSubmission->id,
            ]);
        } else {
            Log::error('Failed to send rejection email via Brevo', [
                'user_id' => $notifiable->id,
                'news_submission_id' => $this->newsSubmission->id,
                'error' => $result['message'],
            ]);
            
            // If Brevo fails, fallback to Laravel mail
            return $this->sendViaLaravelMail($notifiable);
        }

        // Create a dummy MailMessage to satisfy the interface
        // The email was already sent via Brevo API
        return (new MailMessage)
            ->subject($subject)
            ->line('This message was sent via Brevo API.');
    }

    /**
     * Send email via Laravel's default mail system (fallback)
     */
    protected function sendViaLaravelMail(object $notifiable): MailMessage
    {
        $dashboardUrl = route('university.news.show', $this->newsSubmission);
        
        return (new MailMessage)
            ->subject('News Submission Rejected - ' . $this->newsSubmission->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your news submission "' . $this->newsSubmission->title . '" has been rejected.')
            ->line('**Rejection Reason:**')
            ->line($this->newsSubmission->rejection_reason)
            ->line('Please review the feedback and make the necessary improvements before resubmitting.')
            ->action('View Submission', $dashboardUrl)
            ->line('Thank you for your submission. We look forward to reviewing your revised article.')
            ->salutation('Best regards, The Editorial Team');
    }

    /**
     * Parse template variables
     */
    protected function parseTemplate(string $template, object $notifiable): string
    {
        $variables = [
            '{{user_name}}' => $notifiable->name,
            '{{user_email}}' => $notifiable->email,
            '{{article_title}}' => $this->newsSubmission->title,
            '{{article_excerpt}}' => $this->newsSubmission->excerpt ?? '',
            '{{status}}' => ucfirst($this->newsSubmission->status),
            '{{rejection_reason}}' => $this->newsSubmission->rejection_reason ?? '',
            '{{rejected_at}}' => $this->newsSubmission->rejected_at ? $this->newsSubmission->rejected_at->format('F j, Y \a\t g:i A') : '',
            '{{dashboard_url}}' => route('university.news.show', $this->newsSubmission),
            '{{university_name}}' => $this->newsSubmission->university->name ?? '',
            '{{rejector_name}}' => $this->newsSubmission->rejector->name ?? 'Admin',
            '{{platform_name}}' => Setting::get('platform_name', 'XtraXtra'),
        ];

        return str_replace(array_keys($variables), array_values($variables), $template);
    }

    /**
     * Get default HTML email template
     */
    protected function getDefaultHtmlTemplate(): string
    {
        return '
<!DOCTYPE html>
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
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'news_submission_id' => $this->newsSubmission->id,
            'title' => $this->newsSubmission->title,
            'rejection_reason' => $this->newsSubmission->rejection_reason,
            'rejected_at' => $this->newsSubmission->rejected_at,
            'rejector_name' => $this->newsSubmission->rejector->name ?? 'Admin',
        ];
    }
}

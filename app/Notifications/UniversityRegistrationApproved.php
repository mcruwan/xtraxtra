<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Setting;
use App\Services\BrevoMailService;

class UniversityRegistrationApproved extends Notification
{
    use Queueable;

    protected $university;

    /**
     * Create a new notification instance.
     */
    public function __construct($university)
    {
        $this->university = $university;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Check if Brevo is configured
        $brevoService = new BrevoMailService();
        
        if ($brevoService->isConfigured()) {
            return $this->sendViaBrevo($notifiable);
        }
        
        return $this->sendViaLaravelMail($notifiable);
    }

    /**
     * Send email via Brevo with custom template
     */
    protected function sendViaBrevo($notifiable)
    {
        $emailTemplate = Setting::get('registration_approved_email_template');
        $emailSubject = Setting::get('registration_approved_email_subject', 'Registration Approved - Welcome to {{platform_name}}!');
        
        $htmlContent = $this->parseTemplate($emailTemplate ?: $this->getDefaultHtmlTemplate());
        $subject = $this->parseTemplate($emailSubject);
        
        $brevoService = new BrevoMailService();
        $result = $brevoService->sendTransactionalEmail([
            'to' => [
                'email' => $notifiable->email,
                'name' => $notifiable->name,
            ],
            'subject' => $subject,
            'html_content' => $htmlContent,
            'tags' => ['university-registration-approved'],
        ]);
        
        // Return a dummy MailMessage (won't be sent, just for interface compliance)
        return (new MailMessage)->subject($subject);
    }

    /**
     * Send via Laravel's default mail
     */
    protected function sendViaLaravelMail($notifiable)
    {
        $emailTemplate = Setting::get('registration_approved_email_template');
        $emailSubject = Setting::get('registration_approved_email_subject', 'Registration Approved - Welcome to {{platform_name}}!');
        
        $htmlContent = $this->parseTemplate($emailTemplate ?: $this->getDefaultHtmlTemplate());
        $subject = $this->parseTemplate($emailSubject);
        
        return (new MailMessage)
            ->subject($subject)
            ->view('emails.custom-html', ['htmlContent' => $htmlContent]);
    }

    /**
     * Parse template variables
     */
    protected function parseTemplate(string $template): string
    {
        $variables = [
            '{{university_name}}' => $this->university->name,
            '{{admin_name}}' => $this->university->adminUser->name ?? 'Admin',
            '{{admin_email}}' => $this->university->adminUser->email ?? $this->university->contact_email,
            '{{contact_email}}' => $this->university->contact_email ?? $this->university->adminUser->email,
            '{{platform_name}}' => Setting::get('platform_name', 'XtraXtra'),
            '{{approved_at}}' => $this->university->updated_at->format('F j, Y \a\t g:i A'),
            '{{login_url}}' => route('login'),
        ];
        
        return str_replace(array_keys($variables), array_values($variables), $template);
    }

    /**
     * Get default HTML template as fallback
     */
    protected function getDefaultHtmlTemplate(): string
    {
        return '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h2>🎉 Registration Approved!</h2>
                <p>Congratulations {{admin_name}},</p>
                <p>Your registration for <strong>{{university_name}}</strong> has been approved!</p>
                <p>You can now login to {{platform_name}} and start submitting news articles.</p>
                <p><strong>Account Information:</strong></p>
                <ul>
                    <li><strong>University:</strong> {{university_name}}</li>
                    <li><strong>Login Email:</strong> {{admin_email}}</li>
                    <li><strong>Status:</strong> Active</li>
                </ul>
                <p><a href="{{login_url}}" style="display: inline-block; padding: 12px 24px; background-color: #10b981; color: white; text-decoration: none; border-radius: 6px;">Login to Dashboard</a></p>
                <p>Welcome aboard!<br>The {{platform_name}} Team</p>
            </div>
        ';
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'university_id' => $this->university->id,
            'university_name' => $this->university->name,
            'type' => 'registration_approved',
        ];
    }
}

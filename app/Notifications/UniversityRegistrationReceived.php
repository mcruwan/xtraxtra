<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Setting;
use App\Services\BrevoMailService;

class UniversityRegistrationReceived extends Notification
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
        $emailTemplate = Setting::get('registration_received_email_template');
        $emailSubject = Setting::get('registration_received_email_subject', 'Registration Received - {{university_name}}');
        
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
            'tags' => ['university-registration-received'],
        ]);
        
        // Return a dummy MailMessage (won't be sent, just for interface compliance)
        return (new MailMessage)->subject($subject);
    }

    /**
     * Send via Laravel's default mail
     */
    protected function sendViaLaravelMail($notifiable)
    {
        $emailTemplate = Setting::get('registration_received_email_template');
        $emailSubject = Setting::get('registration_received_email_subject', 'Registration Received - {{university_name}}');
        
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
            '{{registered_at}}' => $this->university->created_at->format('F j, Y \a\t g:i A'),
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
                <h2>Registration Received</h2>
                <p>Hello {{admin_name}},</p>
                <p>Thank you for registering <strong>{{university_name}}</strong> with {{platform_name}}!</p>
                <p>We have received your registration request and our team is currently reviewing your application.</p>
                <p><strong>Registration Details:</strong></p>
                <ul>
                    <li><strong>University:</strong> {{university_name}}</li>
                    <li><strong>Contact Email:</strong> {{contact_email}}</li>
                    <li><strong>Registered At:</strong> {{registered_at}}</li>
                </ul>
                <p>Once approved, you will receive another email with your login credentials.</p>
                <p>Best regards,<br>The {{platform_name}} Team</p>
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
            'type' => 'registration_received',
        ];
    }
}

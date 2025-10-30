<?php

namespace App\Notifications;

use App\Models\NewsSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewsSubmissionRejected extends Notification
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
        return (new MailMessage)
            ->subject('News Submission Rejected - ' . $this->newsSubmission->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your news submission "' . $this->newsSubmission->title . '" has been rejected.')
            ->line('**Rejection Reason:**')
            ->line($this->newsSubmission->rejection_reason)
            ->line('Please review the feedback and make the necessary improvements before resubmitting.')
            ->action('View Submission', route('university.news.show', $this->newsSubmission))
            ->line('Thank you for your submission. We look forward to reviewing your revised article.')
            ->salutation('Best regards, The Editorial Team');
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

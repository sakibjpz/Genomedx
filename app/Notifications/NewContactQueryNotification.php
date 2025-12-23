<?php

namespace App\Notifications;

use App\Models\ContactQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactQueryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $contactQuery;

    public function __construct(ContactQuery $contactQuery)
    {
        $this->contactQuery = $contactQuery;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Contact Query: ' . $this->contactQuery->query_type)
            ->greeting('New Query Received!')
            ->line('A new contact query has been submitted:')
            ->line('**Type:** ' . $this->contactQuery->query_type)
            ->line('**From:** ' . $this->contactQuery->name)
            ->line('**Company:** ' . $this->contactQuery->company)
            ->line('**Message:** ' . substr($this->contactQuery->message, 0, 100) . '...')
            ->action('View Query', url('/admin/contact-queries/' . $this->contactQuery->id))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'query_id' => $this->contactQuery->id,
            'query_type' => $this->contactQuery->query_type,
            'name' => $this->contactQuery->name,
            'company' => $this->contactQuery->company,
            'message' => 'New contact query received',
            'link' => '/admin/contact-queries/' . $this->contactQuery->id,
            'time' => now()->toDateTimeString()
        ];
    }
}
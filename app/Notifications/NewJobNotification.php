<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;


class NewJobNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $job;

    /**
     * Create a new notification instance.
     */
    public function __construct($job)
    {
        $this->job = $job;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
       \Log::info('Notification triggered for user: '.$notifiable->id);
      return ['broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

   public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => "New job posted: {$this->job->title}",
            'title' => $this->job->title,
            'salary' => $this->job->salary,
            'location' => $this->job->location,
        ]);
    }

    public function broadcastOn()
    {
        // This is the MOST important part for Pusher to know where to send
        return new PrivateChannel('App.Models.User.' . $this->job->user_id);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

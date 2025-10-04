<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // ← Add this
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;

class NewJobNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $job;

    public function __construct($job)
    {
        $this->job = $job;
    }

    public function via(object $notifiable): array
    {
        return ['database','broadcast']; // Only store in DB
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message'   => "A new job has been posted: {$this->job->title}",
            'id'    => $this->job->id,
            'title' => $this->job->title,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
          return (new MailMessage)
        ->subject('New Job Posted')
        ->greeting('Hello!')
        ->line("A new job has been posted: {$this->job->title}")
        ->line("Location: {$this->job->location}")
        ->line("Salary: {$this->job->salary}")
        ->action('View Job', url('/jobs/' . $this->job->id))
        ->line('Thank you for using our application!');
    }

      public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'job_id' => $this->job->id,
            'job_title' => $this->job->title,
            'message' => 'A new job has been posted!',
        ]);
    }

    public function broadcastAs(): string
{
    return 'new.job.posted';
}
    
   
}

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
        return ['database','mail']; // Only store in DB
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

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message'  => "New job posted: {$this->job->title}",
            'title'    => $this->job->title,
            'salary'   => $this->job->salary,
            'location' => $this->job->location,
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->job->user_id);
    }
}

<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TestEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
{
    \Log::info('Queue is working!');
    \Mail::raw('Test from queue', function ($m) {
        $m->to('test@example.com')->subject('Queue Test');
    });
}
}

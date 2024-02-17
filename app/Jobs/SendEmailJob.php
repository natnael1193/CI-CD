<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
    
     public function __destruct()
     {
         Artisan::call('queue:work --stop-when-empty');
     }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        Mail::to($this->user)->queue(new \App\Mail\WelcomeEmail($this->user));
//        Artisan::call('queue:work');
    }
}

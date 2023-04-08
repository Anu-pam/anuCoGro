<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\OrderAdminSendEmail as OrderAdminSendMail;
use Mail;

class OrderAdminSendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */ 
    protected $details;
    public function __construct($details)
    {
        $this->details = $details;
    } 
 
    /**
     * Execute the job.
     *
     * @return void
     */ 
    public function handle()
    {  
         
        $email = new OrderAdminSendMail($this->details);
        
        Mail::to($this->details['email'])->send($email);
    }
}

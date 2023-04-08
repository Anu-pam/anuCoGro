<?php

namespace App\Listeners;
use App\Events\SendMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Models\Otp;
use Mail;
class SendMailFired
{
    public function __construct()
    {
        
    }
    public function handle(SendMail $event)
    {
        $user = User::find($event->userId)->toArray();
	  
        // $getOtp = Otp::where('user_id',$event->userId)->where('is_for','forgot')->first();
		// $otp = !empty($getOtp->is_otp) ? $getOtp->is_otp : '';
        
        Mail::send('emails.mailEvent', ['user' => $user], function($message) use ($user) {
            $message->to($user['email']);
            $message->subject('Otp For forgot password');
        });
      
    }
}

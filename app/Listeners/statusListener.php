<?php

namespace App\Listeners;
use App\Events\statusEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
class statusListener
{
    /** 
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    } 

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(statusEvent $event)
    {
        // var_dump($event);
        User::where('id',$event->userId)
        ->update(['available_status' => $event->status]);
    }
}

<?php

namespace App\Providers;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\SendMail' => [
            'App\Listeners\SendMailFired',
        ], 
        'App\Events\statusEvent'=>[
            'App\Listeners\statusListener',
        ]

    ];
    public function boot() 
{
    parent::boot();
}
} 

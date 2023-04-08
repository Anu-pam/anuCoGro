<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register Interface and Repository in here
        // You must place Interface in first place
        // If you dont, the Repository will not get readed.
        $this->app->bind('App\Interfaces\UserInterface','App\Repositories\UserRepository');
        $this->app->bind('App\Interfaces\ServicesCategoryInterface','App\Repositories\ServicesCategoryRepository');
		$this->app->bind('App\Interfaces\ServicesInterface','App\Repositories\ServicesRepository');
		$this->app->bind('App\Interfaces\BookingInterface','App\Repositories\BookingRepository');
		$this->app->bind('App\Interfaces\SettingInterface','App\Repositories\SettingRepository');
		$this->app->bind('App\Interfaces\CustomerInterface','App\Repositories\CustomerRepository');
        
    }
}
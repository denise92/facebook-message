<?php

namespace Denise92\FacebookMessage;

use Illuminate\Support\ServiceProvider;

class FacebookMessageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //Publishes package config file to applications config folder
        $this->publishes([__DIR__.'/config/FacebookMessage.php' => config_path('facebook_message.php')]);
    }
 
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Register Our Package routes
		include __DIR__.'/routes.php';
		// Let Laravel Ioc Container know about our Controller
		$this->app->make('Denise92\FacebookMessage\FacebookMessageController');
    }
}

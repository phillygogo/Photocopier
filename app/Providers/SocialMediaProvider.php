<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Facebook\Facebook;

class SocialMediaProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Facebook::class, function () {
            if (!session_id()) {
                session_start();
            }

            return new Facebook([
                'app_id' => env('client_id'),
                'app_secret' => env('client_secret'),
                'default_graph_version' => 'v3.2',
            ]);
        });
    }
}

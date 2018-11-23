<?php

namespace App\Providers;

use Google_Client;
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

        $this->app->bind(Google_Client::class, function () {
            $client = new Google_Client();
            $client->setApplicationName('Photocopier');
            $client->setScopes("https://www.googleapis.com/auth/drive");
            $client->setClientSecret(env('googleDrive_client_secret'));
            $client->setClientId(env('googleDrive_client_id'));
            $client->setRedirectUri(env('googleDrive_redirect_url'));

            return $client;
        });
    }
}

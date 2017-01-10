<?php

namespace App\Providers;

use Facebook\Facebook;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('facebook', function() {
            return new Facebook([
                'app_id' => env('FB_APP_KEY'),
                'app_secret' => env('FB_APP_SECRET'),
                'default_graph_version' => 'v2.8',
                'default_access_token' => '1161296450644866|8x-eRd91uQ3dCP_7c0WCJDA69pc'
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

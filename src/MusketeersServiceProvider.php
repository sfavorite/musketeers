<?php

namespace Sfavorite\Musketeers;

use Illuminate\Support\ServiceProvider;

class MusketeersServiceProvider extends ServiceProvider
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
        $this->app['musketeers'] = $this->app->share(function($app) {
            return new Musketeers;
        });
    }
}

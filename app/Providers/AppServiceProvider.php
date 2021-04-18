<?php

namespace App\Providers;

use App\Services\Netlify;
use App\Services\Wordpress;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->bind(Netlify::class,function($app){
            return new Netlify();
        });
        $this->app->bind(Wordpress::class,function($app){
            return new Wordpress();
        });
    }
}

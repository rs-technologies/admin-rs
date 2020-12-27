<?php

namespace App\Providers;

use App\Repositories\contract\SiteRepositoryInterface;
use App\Repositories\SiteRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    private $repos=[
        SiteRepositoryInterface::class=>SiteRepository::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        foreach($this->repos as $interface=>$repo){
            $this->app->bind($interface,$repo);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

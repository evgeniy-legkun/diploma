<?php

namespace App\Providers;

use App\Services\UserManager\UserManger;
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

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Contracts\Services\UserManager\UserManagerInterface::class,
            \App\Services\UserManager\UserManger::class
        );


    }
}

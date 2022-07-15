<?php

namespace App\Providers;

use App\Repositories\Country\CountryRepositoryEloquent;
use App\Repositories\Country\CountryRepositoryInterface;
use App\Repositories\User\UserRepositoryEloquent;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(CountryRepositoryInterface::class, CountryRepositoryEloquent::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepositoryEloquent::class);
    }
}

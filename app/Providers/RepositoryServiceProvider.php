<?php

namespace App\Providers;

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
        //
        // $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        // $this->app->bind(PersonRepositoryInterface::class, PersonRepository::class);
        // $this->app->bind(RecipientRepositoryInterface::class, RecipientRepository::class);
        // $this->app->bind(DriverRepositoryInterface::class, DriverRepository::class);
        // $this->app->bind(DriverExceptionRepositoryInterface::class, DriverExceptionRepository::class);
        // $this->app->bind(RouteRepositoryInterface::class, RouteRepository::class);
        // $this->app->bind(AgencyRepositoryInterface::class, AgencyRepository::class);
        // $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
    }
}

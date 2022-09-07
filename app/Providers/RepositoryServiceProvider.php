<?php

namespace App\Providers;

use App\Repository\AgencyRepositoryInterface;
use App\Repository\CommentRepositoryInterface;
use App\Repository\DriverExceptionRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\DriverRepository;
use App\Repository\Eloquent\RecipientRepository;
use App\Repository\Eloquent\RouteRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\DriverRepositoryInterface;
use App\Repository\Eloquent\AgencyRepository;
use App\Repository\Eloquent\CommentRepository;
use App\Repository\Eloquent\DriverExceptionRepository;
use App\Repository\Eloquent\PersonRepository;
use App\Repository\PersonRepositoryInterface;
use App\Repository\RecipientRepositoryInterface;
use App\Repository\RouteRepositoryInterface;
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

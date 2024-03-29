<?php

namespace App\Providers;

use App\Models\Person;
use App\Models\Recipient;
use App\Observers\PersonObserver;
use App\Observers\RecipientObserver;
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
    }
}

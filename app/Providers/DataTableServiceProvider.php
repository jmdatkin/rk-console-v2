<?php

namespace App\Providers;

use App\DataTables\DriverDataTableInterface;
use App\DataTables\Eloquent\DriverDataTable;
use App\DataTables\Eloquent\RecipientDataTable;
use App\DataTables\Eloquent\RouteDataTable;
use App\DataTables\RecipientDataTableInterface;
use App\DataTables\RouteDataTableInterface;
use Illuminate\Support\ServiceProvider;

class DataTableServiceProvider extends ServiceProvider
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
        $this->app->bind(RecipientDataTableInterface::class, RecipientDataTable::class);
        $this->app->bind(DriverDataTableInterface::class, DriverDataTable::class);
        $this->app->bind(RouteDataTableInterface::class, RouteDataTable::class);
    }
}

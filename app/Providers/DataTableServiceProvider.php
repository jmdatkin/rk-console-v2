<?php

namespace App\Providers;

use App\DataTables\Eloquent\RecipientDataTable;
use App\DataTables\RecipientDataTableInterface;
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
    }
}

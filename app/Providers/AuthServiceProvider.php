<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-admin', function($user) {
            return $user->hasRole(Role::ADMIN);
        });

        Auth::provider('person_user_provider', function ($app, array $config) {
            return new PersonUserProvider($app['hash'], $config['model'], $config['foreign_model']);
        });
        //
    }
}

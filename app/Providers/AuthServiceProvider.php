<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('app', function ($user) {
            if ($user->level == 'admin') {
                return 'admin';
            } elseif ($user->level == 'user') {
                return 'user';
            } elseif ($user->level == 'manager') {
                return 'manager';
            } else {
                return 'gagal';
            }
        }); 
    }
}

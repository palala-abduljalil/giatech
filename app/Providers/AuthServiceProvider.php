<?php

namespace App\Providers;

use App\Models\SystemModule;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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

        Passport::routes();

        Gate::define('isAdmin', function ($user) {
            return $user->role->name === 'Admin';
        });

        Gate::define('isUser', function ($user) {
            return $user->role->name === 'User';
        });

        Gate::define('canManageContent', function () {
            return in_array(SystemModule::CAN_MANAGE_CONTENT, array_column(auth()->user()->modules->all(), 'id'));
        });

        Gate::define('canManageEmployees', function () {
            return in_array(SystemModule::CAN_MANAGE_EMPLOYEES, array_column(auth()->user()->modules->all(), 'id'));
        });

        Gate::define('canManageUsers', function () {
            return in_array(SystemModule::CAN_MANAGE_USER, array_column(auth()->user()->modules->all(), 'id'));
        });

        Gate::define('canManageClients', function () {
            return in_array(SystemModule::CAN_MANAGE_CLIENTS, array_column(auth()->user()->modules->all(), 'id'));
        });

        Gate::define('canManageProjects', function () {
            return in_array(SystemModule::CAN_MANAGE_PROJECTS, array_column(auth()->user()->modules->all(), 'id'));
        });

        Gate::define('canManageFinance', function () {
            return in_array(SystemModule::CAN_MANAGE_FINANCE, array_column(auth()->user()->modules->all(), 'id'));
        });
        
        Gate::define('canGenerateReports', function () {
            return in_array(SystemModule::CAN_GENERATE_REPORTS, array_column(auth()->user()->modules->all(), 'id'));
        });
    }
}

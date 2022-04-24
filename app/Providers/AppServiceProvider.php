<?php

namespace App\Providers;

use App\Models\Employee;
use Illuminate\Support\ServiceProvider;
use App\Http\Resources\EmployeeResource;

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
        EmployeeResource::withoutWrapping();

        view()->composer(['partials._sidebar-user-panel'], function ($view) {
            $view->with('auth', new EmployeeResource(Employee::with([
                'position',
                'department',
                'profilePicture'
            ])->find(auth()->user()->employee_id)));
        });
    }
}

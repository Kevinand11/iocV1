<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): Void
    {
        $this->registerPolicies();
        Passport::routes();
        Gate::define('canEditUser','App\Policies\EditPolicy@canEditUser');
        Gate::define('canEditStore','App\Policies\EditPolicy@canEditStore');
        Gate::define('canEditPost','App\Policies\EditPolicy@canEditPost');
        Gate::define('canEditCategory','App\Policies\EditPolicy@canEditCategory');
    }
}

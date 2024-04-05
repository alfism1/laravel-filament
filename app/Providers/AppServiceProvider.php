<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;

use App\Policies\RoleAndPermissionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Contracts\Permission;
use \Spatie\Permission\Models\Role;

class AppServiceProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Role::class => RoleAndPermissionPolicy::class,
        Permission::class => RoleAndPermissionPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
        Model::unguard();
    }
}

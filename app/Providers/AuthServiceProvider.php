<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Permission;
use Illuminate\Support\Facades\Schema;

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
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot()
    {
        parent::registerPolicies();
        // Not sure why I registered permissions here?
        //if (Schema::hasTable('permissions')) {
            // Dynamically register permissions with Laravel's Gate.
            //foreach ($this->getPermissions() as $permission) {
            //    $gate->define($permission->name, function ($user) use ($permission) {
            //        return $user->hasPermission($permission);
            //    });
            //}
        //}
    }
    /**
     * Fetch the collection of site permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}

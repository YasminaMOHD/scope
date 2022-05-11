<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
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

        Gate::before(function ($user, $ability) {
            if ($user->user_type == 'super-admin') {
                return true;
            }
        });

        foreach(config('Permission') as $key=>$v){
            Gate::define($key , function($user) use ($key){
                return $user->hasAbility($key);
            });
        }
        //         $roles = Role::whereRaw('id IN (select role_id from roles_users where user_id = ?)',[
        //             $user->id
        //         ])->get();
        //         foreach($roles as $role){
        //             if(in_array($key , $role->permissions)){
        //                 return true;
        //             }
        //         }
        //         return false;
        //     });
        // }

        //
    }
}

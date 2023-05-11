<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */

    public static $permission = [
        // 'pages' => ['superadmin','admin','user'],
        'home' => ['superadmin','admin','user','direktur'],
        'indikators' => ['superadmin','admin','user'],
        'units' => ['superadmin','admin'],
        'users' => ['superadmin','admin'],
        'index-user' => ['superadmin','admin'],
        'show-user' => ['superadmin','admin'],
        'create-user' => ['superadmin'],
        'store-user' => ['superadmin'],
        'edit-user' => ['superadmin'],
        'update-user' => ['superadmin'],
        'destroy-user' => ['superadmin'],
    ];

    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function (User $user){
            if ($user->role == 'superadmin')
                return true;
        });



        foreach (self::$permission as $action => $roles) {
            Gate::define($action,function(User $user) use ($roles){
                if (in_array($user->role, $roles)){
                    return true;
                }
            });
        }
    }
}

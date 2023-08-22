<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Recipe;
use App\Models\FoodRecord;

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

        // 管理者ユーザーのゲート
        Gate::define('isAdministrator',function($user){
            return $user->role === 1;
        });

        // 一般ユーザーのゲート
        Gate::define('isUser', function($user){
            return $user->role === 1 || $user->role === 2;
        });


        // blade上でゲートを制御
        // --------------------------------------------------------------
        // レシピの編集・削除のゲート
        Gate::define('controlRecipe', function (User $user, Recipe $recipe) {
            return $user->id === $recipe->user_id;
        });

        Gate::define('controlFoodRecord', function (User $user, FoodRecord $foodRecord) {
            return $user->id === $foodRecord->user_id;
        });
        
    }
}

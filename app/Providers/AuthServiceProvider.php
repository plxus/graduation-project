<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Repository;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     * 为模型（model）指定授权策略（policy）。
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\User::class  => \App\Policies\UserPolicy::class,
        \App\Repository::class  => \App\Policies\RepositoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}

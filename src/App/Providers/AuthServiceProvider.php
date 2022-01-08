<?php

namespace App\Providers;

use App\Policies\AdminProfilePolicy;
use App\Policies\MediaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public const MEDIA_SHOW = "media.show";
    public const PROFILE_UPDATE = 'admin.profile.update';

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
    public function boot()
    {
        $this->registerPolicies();

        Gate::define(static::MEDIA_SHOW, [MediaPolicy::class, "show"]);
        Gate::define(static::PROFILE_UPDATE, [AdminProfilePolicy::class, 'update']);
    }
}

<?php

namespace Davidnadejdin\LaravelReferral;

use Illuminate\Support\ServiceProvider as BaseProvider;

class ServiceProvider extends BaseProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/referral.php', 'referral'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'../database/migrations');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../config/referral.php' => config_path('referral.php'),
        ]);
    }
}

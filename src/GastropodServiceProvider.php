<?php

namespace RadFic\Gastropod\Providers;

use App\Services\Riak\Connection;
use Illuminate\Support\ServiceProvider;

class GastropodServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // Export the migration
            if (! class_exists('CreateGastropodAdminsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_gastropod_admins_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . 'create_gastropod_admins_table.php'),
                    // you can add any number of migrations here
                ], 'migrations');
            }

            // Publish assets
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('gastropod'),
            ], 'assets');
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/gastropod.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'gastropod');
    }
}

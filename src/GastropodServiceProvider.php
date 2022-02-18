<?php

namespace RadFic\Gastropod;
use RadFic\Gastropod\Console\InstallGastropod;
use RadFic\Gastropod\Http\Middleware\GastropodAuth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

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
            $this->commands([
                InstallGastropod::class,
            ]);

            // Export the migration
            if (! class_exists('CreateGastropodAdminsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_gastropod_admins_table.php.stub' => database_path('migrations/' . '2022_02_14_000001_create_gastropod_admins_table.php'),
                    // you can add any number of migrations here
                ], 'migrations');
            }

            // Publish config file
            $this->publishes([
            __DIR__.'/../config/gastropod.php' => config_path('gastropod.php'),
            ], 'config');

            // Publish assets
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('gastropod_assets'),
            ], 'assets');

            // Publish views
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/gastropod'),
            ], 'views');

            // Publish GastropodAdmin model
            $this->publishes([
                __DIR__.'/Models/GastropodAdmin.php.stub' => app_path('Models/GastropodAdmin.php'),
            ], 'admin_model');

           
        }
        $this->loadRoutesFrom(__DIR__.'../routes/gastropod.php');
    }
}

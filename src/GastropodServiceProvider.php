<?php

namespace RadFic\Gastropod;

use RadFic\Gastropod\Http\Middleware\GastropodAuth;
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
                    __DIR__ . '/../database/migrations/create_gastropod_admins_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_gastropod_admins_table.php'),
                    // you can add any number of migrations here
                ], 'migrations');
            }

            // Publish assets
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('gastropod'),
            ], 'assets');

            // Publish views
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/radfic/gastropod'),
            ], 'views');
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/gastropod.php');
        //$this->loadViewsFrom(__DIR__.'/../resources/views', 'gastropod');
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('gastropodAuth', GastropodAuth::class);
    }
}

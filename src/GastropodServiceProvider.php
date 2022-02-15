<?php

namespace RadFic\Gastropod;

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
            // Export the migration
            if (! class_exists('CreateGastropodAdminsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_gastropod_admins_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_gastropod_admins_table.php'),
                    // you can add any number of migrations here
                ], 'migrations');
            }

            // Publish config file
            $this->publishes([
            __DIR__.'/../config/gastropod.php' => config_path('gastropod.php'),
            ], 'config');

            // Publish assets
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('gastropod'),
            ], 'assets');

            // Publish views
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/radfic/gastropod'),
            ], 'views');

            // Publish controllers
            $this->publishes([
                __DIR__.'/Http/Controllers/BaseCrudTableController.php' => app_path('Http/Controllers/Gastropod'),
                __DIR__.'/Http/Controllers/GastropodAdminCrudController.php' => app_path('Http/Controllers/Gastropod'),
                __DIR__.'/Http/Controllers/GastropodController.php' => app_path('Http/Controllers/Gastropod'),
                __DIR__.'/Http/Controllers/UserCrudController.php' => app_path('Http/Controllers/Gastropod'),
            ], 'controllers');

            // Publish routes
            $this->publishes([
                __DIR__.'/../routes/gastropod.php' => base_path('routes'),
            ], 'views');



        }
        //$this->loadRoutesFrom(__DIR__.'/../routes/gastropod.php');
        //$this->loadViewsFrom(__DIR__.'/../resources/views', 'gastropod');
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('gastropodAuth', GastropodAuth::class);
    }
}

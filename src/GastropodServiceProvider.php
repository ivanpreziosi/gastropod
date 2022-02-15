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

            // Publish controllers
            $this->publishes([
                __DIR__.'/Http/Controllers' => app_path('Http/Controllers/Gastropod'),
            ], 'controllers');

            // Publish routes
            $this->publishes([
                __DIR__.'/../routes/gastropod.php' => base_path('routes/gastropod.php'),
            ], 'routes');
        }
        //$this->loadRoutesFrom(base_path('routes/gastropod.php'));
        //$this->loadViewsFrom(__DIR__.'/../resources/views', 'gastropod');
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('gastropodAuth', GastropodAuth::class);
    }
}

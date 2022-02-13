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
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}

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
        $this->app->singleton(Connection::class, function ($app) {
            return new Connection(config('riak'));
        });
    }
}

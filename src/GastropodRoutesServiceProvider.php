<?php

namespace RadFic\Gastropod;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class GastropodRoutesServiceProvider extends RouteServiceProvider
{
    protected $namespace='RadFic\Gastropod\Http\Controllers';

    public function boot()
    {
        parent::boot();
        $this->routes(function () {
            Route::prefix('gastropod')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/gastropod.php'));
        });
    }
}

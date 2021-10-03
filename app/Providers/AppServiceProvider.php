<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Paginator::useBootstrapThree();
        //Paginator::useBootstrap();
        Paginator::defaultView('vendor.pagination.bootstrap-4');
        $google_auto_comp_countries = explode(',',env('GOOGLE_MAP_AUTO_COMP_COUNTRIES','ie'));
        View::share('google_auto_comp_countries', json_encode($google_auto_comp_countries));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

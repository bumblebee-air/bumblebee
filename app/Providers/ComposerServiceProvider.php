<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'templates.main', 'App\Http\ViewComposers\MainComposer'
        );
        View::composer(
            'templates.aviva', 'App\Http\ViewComposers\MainComposer'
        );
        View::composer('partials.admin_sidebar', 'App\Http\ViewComposers\SideNavComposer');
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

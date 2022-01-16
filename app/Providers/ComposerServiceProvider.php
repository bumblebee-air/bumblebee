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
            ['templates.main','templates.aviva','templates.auth','templates.dashboard','templates.doorder_dashboard','templates.garden_help-dashboard'],
            'App\Http\ViewComposers\MainComposer'
        );
        View::composer(['partials.admin_sidebar','partials.admin_sidebar_doorder','partials.admin_sidebar_gardenhelp'], 'App\Http\ViewComposers\SideNavComposer');
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

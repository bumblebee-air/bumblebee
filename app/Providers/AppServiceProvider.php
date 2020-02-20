<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Keyword;
use App\Observers\KeywordObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Keyword::observe(KeywordObserver::class);
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

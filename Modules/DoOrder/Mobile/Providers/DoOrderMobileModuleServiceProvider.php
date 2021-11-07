<?php

namespace Modules\DoOrder\Mobile\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DoOrderMobileModuleServiceProvider extends ServiceProvider
{

    protected $moduleNamespace = 'Modules\DoOrder\Mobile\Http\Controllers';
    protected $webRoute = 'Modules/DoOrder/Mobile/Routes/web.php';
    protected $apiRoute = 'Modules/DoOrder/Mobile/Routes/api.php';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->registerApiRoutes();
        $this->registerMigrations();
    }


    protected function registerRoutes()
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(base_path($this->webRoute));
    }

    protected function registerApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(base_path($this->apiRoute));
    }

    /**
     * Register module migrations.
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}

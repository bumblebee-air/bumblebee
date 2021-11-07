<?php

namespace Modules\DoOrder\Retailer\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DoOrderRetailerModuleServiceProvider extends ServiceProvider
{

    protected $moduleNamespace = 'Modules\DoOrder\Retailer\Http\Controllers';
    protected $webRoute = 'Modules/DoOrder/Retailer/Routes/web.php';
    protected $apiRoute = 'Modules/DoOrder/Retailer/Routes/api.php';

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

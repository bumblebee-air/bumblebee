<?php

namespace Modules\DoOrder\Driver\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DoOrderDriverModuleServiceProvider extends ServiceProvider
{

    protected $moduleNamespace = 'Modules\DoOrder\Driver\Http\Controllers';
    protected $webRoute = 'Modules/DoOrder/Driver/Routes/web.php';
    protected $apiRoute = 'Modules/DoOrder/Driver/Routes/api.php';

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

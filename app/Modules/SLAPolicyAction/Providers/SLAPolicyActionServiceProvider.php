<?php

namespace App\Modules\SLAPolicyAction\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\SLAPolicyAction\Contracts\SLAPolicyActionServiceInterface;
use App\Modules\SLAPolicyAction\Services\SLAPolicyActionService;

class SLAPolicyActionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SLAPolicyActionServiceInterface::class, SLAPolicyActionService::class);
    }

    public function boot(): void
    {
        $this->loadRoutes();
        $this->loadMigrations();
    }

    private function loadRoutes(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__ . '/../Routes/api.php');
    }

    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}

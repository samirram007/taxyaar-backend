<?php

namespace App\Modules\HelpCenter\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\HelpCenter\Contracts\HelpCenterServiceInterface;
use App\Modules\HelpCenter\Services\HelpCenterService;

class HelpCenterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(HelpCenterServiceInterface::class, HelpCenterService::class);
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

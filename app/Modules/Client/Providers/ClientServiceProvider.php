<?php

namespace App\Modules\Client\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\Client\Contracts\ClientServiceInterface;
use App\Modules\Client\Services\ClientService;

class ClientServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ClientServiceInterface::class, ClientService::class);
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

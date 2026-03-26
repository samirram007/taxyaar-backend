<?php

namespace App\Modules\TicketStatus\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\TicketStatus\Contracts\TicketStatusServiceInterface;
use App\Modules\TicketStatus\Services\TicketStatusService;

class TicketStatusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TicketStatusServiceInterface::class, TicketStatusService::class);
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

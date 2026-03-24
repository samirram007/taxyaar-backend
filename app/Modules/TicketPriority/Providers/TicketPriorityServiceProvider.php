<?php

namespace App\Modules\TicketPriority\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\TicketPriority\Contracts\TicketPriorityServiceInterface;
use App\Modules\TicketPriority\Services\TicketPriorityService;

class TicketPriorityServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TicketPriorityServiceInterface::class, TicketPriorityService::class);
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

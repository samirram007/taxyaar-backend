<?php

namespace App\Modules\TicketEvent\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\TicketEvent\Contracts\TicketEventServiceInterface;
use App\Modules\TicketEvent\Services\TicketEventService;

class TicketEventServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TicketEventServiceInterface::class, TicketEventService::class);
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

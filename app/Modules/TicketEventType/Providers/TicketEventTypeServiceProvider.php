<?php

namespace App\Modules\TicketEventType\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\TicketEventType\Contracts\TicketEventTypeServiceInterface;
use App\Modules\TicketEventType\Services\TicketEventTypeService;

class TicketEventTypeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TicketEventTypeServiceInterface::class, TicketEventTypeService::class);
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

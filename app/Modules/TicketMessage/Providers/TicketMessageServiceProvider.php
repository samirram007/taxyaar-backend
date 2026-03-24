<?php

namespace App\Modules\TicketMessage\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\TicketMessage\Contracts\TicketMessageServiceInterface;
use App\Modules\TicketMessage\Services\TicketMessageService;

class TicketMessageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TicketMessageServiceInterface::class, TicketMessageService::class);
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

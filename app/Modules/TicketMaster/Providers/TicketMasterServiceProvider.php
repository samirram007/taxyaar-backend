<?php

namespace App\Modules\TicketMaster\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\TicketMaster\Contracts\TicketMasterServiceInterface;
use App\Modules\TicketMaster\Services\TicketMasterService;

class TicketMasterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TicketMasterServiceInterface::class, TicketMasterService::class);
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

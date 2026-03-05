<?php

namespace App\Modules\Assessee\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\Assessee\Contracts\AssesseeServiceInterface;
use App\Modules\Assessee\Services\AssesseeService;

class AssesseeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AssesseeServiceInterface::class, AssesseeService::class);
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

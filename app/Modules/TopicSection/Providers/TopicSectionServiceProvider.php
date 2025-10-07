<?php

namespace App\Modules\TopicSection\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\TopicSection\Contracts\TopicSectionServiceInterface;
use App\Modules\TopicSection\Services\TopicSectionService;

class TopicSectionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TopicSectionServiceInterface::class, TopicSectionService::class);
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

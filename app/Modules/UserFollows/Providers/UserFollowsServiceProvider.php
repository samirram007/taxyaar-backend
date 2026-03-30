<?php

namespace App\Modules\UserFollows\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\UserFollows\Contracts\UserFollowsServiceInterface;
use App\Modules\UserFollows\Services\UserFollowsService;

class UserFollowsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserFollowsServiceInterface::class, UserFollowsService::class);
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

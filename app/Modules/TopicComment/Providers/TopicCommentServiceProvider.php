<?php

namespace App\Modules\TopicComment\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\TopicComment\Contracts\TopicCommentServiceInterface;
use App\Modules\TopicComment\Services\TopicCommentService;

class TopicCommentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TopicCommentServiceInterface::class, TopicCommentService::class);
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

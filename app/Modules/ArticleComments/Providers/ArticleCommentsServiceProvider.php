<?php

namespace App\Modules\ArticleComments\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\ArticleComments\Contracts\ArticleCommentsServiceInterface;
use App\Modules\ArticleComments\Services\ArticleCommentsService;

class ArticleCommentsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ArticleCommentsServiceInterface::class, ArticleCommentsService::class);
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

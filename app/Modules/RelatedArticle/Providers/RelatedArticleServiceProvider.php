<?php

namespace App\Modules\RelatedArticle\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\RelatedArticle\Contracts\RelatedArticleServiceInterface;
use App\Modules\RelatedArticle\Services\RelatedArticleService;

class RelatedArticleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RelatedArticleServiceInterface::class, RelatedArticleService::class);
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

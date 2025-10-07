<?php

namespace App\Modules\TopicArticle\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\TopicArticle\Contracts\TopicArticleServiceInterface;
use App\Modules\TopicArticle\Services\TopicArticleService;

class TopicArticleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TopicArticleServiceInterface::class, TopicArticleService::class);
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

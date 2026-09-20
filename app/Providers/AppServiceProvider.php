<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
    \App\Repositories\ProjectRepositoryInterface::class,
    \App\Repositories\Eloquent\ProjectRepository::class
);

$this->app->bind(
    \App\Repositories\FileRepositoryInterface::class,
    \App\Repositories\Eloquent\FileRepository::class
);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Providers;

use App\Repositories\Eloquent\ProjectDiscussionRepository;
use App\Repositories\Eloquent\StudyRepository;
use App\Repositories\ProjectDiscussionRepositoryInterface;
use App\Repositories\StudyRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use ProjectFileRepository;

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
    \App\Repositories\ProjectFileRepositoryInterface::class,
    \App\Repositories\Eloquent\ProjectFileRepository::class
);
$this->app->bind(StudyRepositoryInterface::class, StudyRepository::class);
$this->app->bind(ProjectDiscussionRepositoryInterface::class, ProjectDiscussionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

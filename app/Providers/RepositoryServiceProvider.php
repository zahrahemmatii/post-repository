<?php

namespace App\Providers;

use App\Interfaces\PostInterface;
use App\Interfaces\UserInterface;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class,UserRepository::class);
        $this->app->bind(PostInterface::class,PostRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       //
    }
}

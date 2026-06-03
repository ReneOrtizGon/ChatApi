<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\UserInterface;
use App\Repositories\UserRepository;
use App\Interfaces\ChatInterface;
use App\Repositories\ChatRepository;
use App\Interfaces\MessageInterface;
use App\Repositories\MessageRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(
            UserInterface::class,
            UserRepository::class,
            ChatInterface::class,
        );
        $this->app->bind(
            ChatInterface::class,
            ChatRepository::class,
        );
        $this->app->bind(
            MessageInterface::class,
            MessageRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

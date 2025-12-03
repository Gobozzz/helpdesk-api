<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\RefreshSession\RefreshSessionRepository;
use App\Repositories\RefreshSession\RefreshSessionRepositoryContract;
use App\Repositories\Ticket\TicketRepository;
use App\Repositories\Ticket\TicketRepositoryContract;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryContract;
use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceContract;
use App\Services\Hash\HasherContract;
use App\Services\Hash\LaravelHasher;
use App\Services\JWT\JWTServiceContract;
use App\Services\JWT\JWTServiceTymon;
use App\Services\Ticket\TicketService;
use App\Services\Ticket\TicketServiceContract;
use Illuminate\Support\ServiceProvider;

final class ServiceBindingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Репы
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(RefreshSessionRepositoryContract::class, RefreshSessionRepository::class);
        $this->app->bind(TicketRepositoryContract::class, TicketRepository::class);

        // Сервисы
        $this->app->bind(AuthServiceContract::class, AuthService::class);
        $this->app->bind(JWTServiceContract::class, JWTServiceTymon::class);
        $this->app->bind(HasherContract::class, LaravelHasher::class);
        $this->app->bind(TicketServiceContract::class, TicketService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

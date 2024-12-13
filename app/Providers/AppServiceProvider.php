<?php

namespace App\Providers;

use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use App\Interfaces\TicketRepositoryInterface;
use App\Interfaces\TransactionRepositoryInterface;
use App\Interfaces\TransportRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\CardRepository;
use App\Repositories\CityRepository;
use App\Repositories\TicketRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\TransportRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->bind(TicketRepositoryInterface::class, TicketRepository::class);
        $this->app->bind(TransportRepositoryInterface::class, TransportRepository::class);
        $this->app->bind(CardRepositoryInterface::class, CardRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

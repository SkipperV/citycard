<?php

namespace App\Providers;

use App\Repositories\CardRepository;
use App\Repositories\CityRepository;
use App\Repositories\Interfaces\CardRepositoryInterface;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\TransportRepositoryInterface;
use App\Repositories\TicketRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\TransportRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

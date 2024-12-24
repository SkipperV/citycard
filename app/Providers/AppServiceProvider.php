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
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
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

        // Elasticsearch client binding
        $this->bindSearchClient();
    }

    private function bindSearchClient()
    {
        $this->app->singleton(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

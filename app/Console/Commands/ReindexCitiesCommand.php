<?php

namespace App\Console\Commands;

use App\Models\City;
use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexCitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex-cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all cities to Elasticsearch';
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Indexing all cities. This might take a while...');

        foreach (City::cursor() as $city) {
            $this->elasticsearch->index([
                'index' => $city->getSearchIndex(),
                'id' => $city->getKey(),
                'body' => $city->toSearchArray(),
            ]);
        }

        $this->info("\nDone!");
    }
}

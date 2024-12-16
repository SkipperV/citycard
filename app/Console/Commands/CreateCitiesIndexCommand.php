<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;

class CreateCitiesIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:create-cities-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates cities index in Elasticsearch';

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
        $this->info('Creating cities index...');

        $this->elasticsearch->indices()->create([
            'index' => 'cities',
            'body' => [
                'settings' => [
                    'number_of_replicas' => 0,
                ],
                'mappings' => [
                    'properties' => [
                        'name' => [
                            'type' => 'text',
                            "fields" => [
                                "keyword" => [
                                    "type" => "keyword",
                                ],
                            ],
                        ],
                        'region' => [
                            'type' => 'text',
                            "fields" => [
                                "keyword" => [
                                    "type" => "keyword",
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $this->info("\nDone!");
    }
}

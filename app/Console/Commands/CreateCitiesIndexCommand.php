<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreateCitiesIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:create:cities';

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

        try {
            $response = $this->elasticsearch->indices()->create([
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

            if (isset($response['acknowledged']) && $response['acknowledged'] === true) {
                $this->info("\nDone!");
            } else {
                $this->error("\nFailed to create \"cities}\" index.");
            }
        } catch (\Exception $e) {
            Log::channel('elasticsearch')->error("Error creating \"cities\" index: " . $e->getMessage());
            $this->error("\nError creating \"cities\" index: " . $e->getMessage());
        }
    }
}

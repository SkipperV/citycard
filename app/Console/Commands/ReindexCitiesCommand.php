<?php

namespace App\Console\Commands;

use App\Models\City;
use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ReindexCitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex:cities';

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
        $errorsLogged = false;

        $this->info("Indexing all cities. This might take a while...");

        City::query()->orderBy('id')->chunk(500, function ($cities) use (&$errorsLogged) {
            $response = $this->reindexCities('cities', $cities->toArray());

            if (!empty($response['errors'])) {
                foreach ($response['items'] as $item) {
                    if (isset($item['index']['error'])) {
                        Log::channel('elasticsearch')->error('Error during Elasticsearch indexing.', [
                            'error' => $item['index']['error'],
                            'item' => $item,
                        ]);
                        $errorsLogged = true;
                    }
                }
            }
        });

        if ($errorsLogged) {
            $this->info('Some errors occurred during reindexing. Please check the "elasticsearch.log" for more details.');
        }
        $this->info("\nDone!");
    }

    public function reindexCities(string $index, array $cities)
    {
        $bulkData = [];

        foreach ($cities as $city) {
            $bulkData[] = [
                'index' => [
                    '_index' => $index,
                    '_id' => $city['id'],
                ]
            ];
            $bulkData[] = $city;
        }

        return $this->elasticsearch->bulk(['body' => $bulkData]);
    }
}

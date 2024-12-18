<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:delete:index {index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes specified index in Elasticsearch';

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
        $this->info("Deleting index \"{$this->argument('index')}\"...");
        try {
            $response = $this->elasticsearch->indices()->delete([
                'index' => $this->argument('index'),
            ]);

            if (isset($response['acknowledged']) && $response['acknowledged'] === true) {
                $this->info("\nDone!");
            } else {
                $this->error("\nFailed to delete index \"{$this->argument('index')}\".");
            }
        } catch (\Exception $e) {
            Log::channel('elasticsearch')
                ->error("Error deleting index \"{$this->argument('index')}\": " . $e->getMessage());
            $this->error("\nError deleting index: " . $e->getMessage());
        }
    }
}

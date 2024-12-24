<?php

namespace App\Observers;

use Elastic\Elasticsearch\Client;
use Illuminate\Support\Facades\Log;

class ElasticsearchObserver
{
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function saved($model)
    {
        try {
            $response = $this->elasticsearch->index([
                'index' => $model->getSearchIndex(),
                'id' => $model->getKey(),
                'body' => $model->toSearchArray(),
            ]);

            if (isset($response['error'])) {
                Log::channel('elasticsearch')->error('Error during Elasticsearch document indexing.', [
                    'error' => $response['error'],
                    'model' => $model,
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('elasticsearch')->error('Exception occurred during Elasticsearch document indexing.', [
                'error' => $e->getMessage(),
                'model' => $model,
            ]);
        }
    }

    public function deleted($model)
    {
        try {
            $response = $this->elasticsearch->delete([
                'index' => $model->getSearchIndex(),
                'id' => $model->getKey(),
            ]);

            if (isset($response['error'])) {
                Log::channel('elasticsearch')->error('Error during Elasticsearch document deletion.', [
                    'error' => $response['error'],
                    'model' => $model,
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('elasticsearch')->error('Exception occurred during Elasticsearch document deletion.', [
                'error' => $e->getMessage(),
                'model' => $model,
            ]);
        }
    }
}

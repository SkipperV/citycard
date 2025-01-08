<?php

namespace App\Repositories;

use App\Interfaces\CityRepositoryInterface;
use App\Models\City;
use Elastic\Elasticsearch\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class CityRepository implements CityRepositoryInterface
{
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        if (config('services.search.enabled')) {
            $this->elasticsearch = $elasticsearch;
        }
    }

    public function getAllCities(): LengthAwarePaginator
    {
        return City::paginate(10);
    }

    public function search(Request $request): LengthAwarePaginator
    {
        if (config('services.search.enabled')) {
            return $this->searchOnElasticsearch($request);
        }
        return $this->searchWithEloquent($request);
    }

    public function createCity(array $data): City
    {
        return City::create($data);
    }

    public function updateCity(City $city, array $newData): City
    {
        $city->update($newData);
        return $city->fresh();
    }

    public function deleteCity(City $city): bool
    {
        return $city->delete();
    }

    private function searchWithEloquent(Request $request): LengthAwarePaginator
    {
        return City::where('name', 'LIKE', '%' . $request->query('search', '') . '%')
            ->orWhere('region', 'LIKE', '%' . $request->query('search', '') . '%')
            ->paginate(10);
    }

    private function searchOnElasticsearch(Request $request): LengthAwarePaginator
    {
        $model = new City;

        $page = $request->input('page', 1);
        $perPage = 10;
        $from = ($page - 1) * $perPage;
        $searchQuery = $request->input('search', '');

        $response = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['region^2', 'name'],
                        'query' => $searchQuery,
                    ],
                ],
                'sort' => [
                    'region.keyword' => ['order' => 'asc'],
                    'name.keyword' => ['order' => 'asc'],
                ],
                'from' => $from,
                'size' => $perPage,
            ],
        ]);
        $total = $response['hits']['total']['value'];

        $ids = Arr::pluck($response['hits']['hits'], '_id');
        $results = collect(City::findMany($ids))
            ->sortBy(function ($city) use ($ids) {
                return array_search($city->getKey(), $ids);
            })->values()->toArray();

        return new LengthAwarePaginator(
            $results,
            $total,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    }
}

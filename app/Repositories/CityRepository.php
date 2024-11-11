<?php

namespace App\Repositories;

use App\Models\City;
use App\Repositories\Interfaces\CityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class CityRepository implements CityRepositoryInterface
{
    public function getAllCities(): LengthAwarePaginator
    {
        return City::paginate(10);
    }

    public function searchInCities(string $searchString): LengthAwarePaginator
    {
        return City::where('name', 'LIKE', '%' . $searchString . '%')
            ->orWhere('region', 'LIKE', '%' . $searchString . '%')
            ->paginate(10);
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
}

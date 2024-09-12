<?php

namespace App\Repositories;

use App\Models\City;
use App\Repositories\Interfaces\CityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CityRepository implements CityRepositoryInterface
{
    public function getAllCities(): Collection
    {
        return City::all();
    }

    public function searchInCities(string $searchString): Collection
    {
        return City::where('name', 'LIKE', '%' . $searchString . '%')
            ->orWhere('region', 'LIKE', '%' . $searchString . '%')
            ->get();
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

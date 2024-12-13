<?php

namespace App\Interfaces;

use App\Models\City;

interface CityRepositoryInterface
{
    public function getAllCities();

    public function searchInCities(string $searchString);

    public function createCity(array $data);

    public function updateCity(City $city, array $newData);

    public function deleteCity(City $city);
}

<?php

namespace App\Interfaces;

use App\Models\City;
use Illuminate\Http\Request;

interface CityRepositoryInterface
{
    public function getAllCities();

    public function search(Request $request);

    public function createCity(array $data);

    public function updateCity(City $city, array $newData);

    public function deleteCity(City $city);
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return City::all();
    }

    /**
     * Perform search in a listing of the resource.
     */
    public function search(string $searchString): Collection
    {
        return City::where('name', 'LIKE', '%' . $searchString . '%')
            ->orWhere('region', 'LIKE', '%' . $searchString . '%')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): City
    {
        $fields = $request->validate([
            'region' => 'required|string',
            'name' => 'required|string'
        ]);

        $city = City::create($fields);

        return $city;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $cityId): City|Response
    {
        $city = City::find($cityId);
        return $city ? $city : response(['error' => 'City not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $cityId): Response
    {
        if (!is_numeric($cityId)) {
            return response(['message' => 'Invalid ID supplied'], 400);
        }

        $fields = $request->validate([
            'region' => 'required|string',
            'name' => 'required|string'
        ]);

        $city = City::find($cityId);
        if (!$city) {
            return response(['message' => 'City not found'], 404);
        }

        $city->update($fields);

        return response($city, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $cityId)
    {
        City::destroy($cityId);

        return response(['message' => 'Operation successful']);
    }
}

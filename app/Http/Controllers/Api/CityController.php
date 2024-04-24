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
    public function index(): Collection|Response
    {
        $cities = City::all();
        return $cities->isNotEmpty() ? $cities : response([], 204);
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
    public function store(Request $request): Response
    {
        $fields = $request->validate([
            'region' => 'required|alpha|max:30',
            'name' => 'required|alpha|max:30'
        ]);

        $city = City::create($fields);

        return response($city, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city): City|Response
    {
        return $city;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city): Response|City
    {
        $fields = $request->validate([
            'region' => 'alpha|max:30',
            'name' => 'alpha|max:30'
        ]);
        $city->update($fields);

        return $city;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city): Response
    {
        $city->delete();
        return response(['message' => 'Successful operation']);
    }
}

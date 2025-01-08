<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CityController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Cities/Index');
    }

    public function create(): Response
    {
        return Inertia::render('Cities/Create');
    }

    public function store(StoreCityRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        City::create($formData);

        return to_route('cities.index');
    }

    public function edit(City $city): Response
    {
        return Inertia::render('Cities/Edit', ['city' => $city]);
    }

    public function update(UpdateCityRequest $request, City $city): RedirectResponse
    {
        $formData = $request->validated();
        $city->update($formData);

        return to_route('cities.index');
    }

    public function destroy(City $city): RedirectResponse
    {
        $city->delete();

        return to_route('cities.index');
    }
}

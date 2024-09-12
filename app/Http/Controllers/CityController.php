<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CityController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Cities/Index', [
            'cities' => City::orderBy('name')->filter(request(['search']))->get()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Cities/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $formData = $request->validate([
            'region' => 'required',
            'name' => 'required'
        ]);

        City::create($formData);

        return to_route('cities.index');
    }

    public function edit(City $city): Response
    {
        return Inertia::render('Cities/Edit', ['city' => $city]);
    }

    public function update(Request $request, City $city): RedirectResponse
    {
        $formData = $request->validate([
            'region' => 'required',
            'name' => 'required'
        ]);

        $city->update($formData);

        return to_route('cities.index');
    }

    public function destroy(City $city): RedirectResponse
    {
        $city->delete();

        return to_route('cities.index');
    }
}

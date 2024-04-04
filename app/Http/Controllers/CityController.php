<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CityController extends Controller
{
    public function index(): View
    {
        return view('cities.index', [
            'cities' => City::orderBy('name')->filter(request(['search']))->get()
        ]);
    }

    public function create(): View
    {
        return view('cities.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $formData = $request->validate([
            'region' => 'required',
            'name' => 'required'
        ]);

        City::create($formData);

        return redirect()->route('cities.index');
    }

    public function edit(City $city): View
    {
        return view('cities.edit', ['city' => $city]);
    }

    public function update(Request $request, City $city): RedirectResponse
    {
        $formData = $request->validate([
            'region' => 'required',
            'name' => 'required'
        ]);

        $city->update($formData);

        return redirect()->route('cities.index');
    }

    public function destroy(City $city): RedirectResponse
    {
        $city->delete();

        return redirect()->route('cities.index');
    }
}

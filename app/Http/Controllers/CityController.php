<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        return view('cities.index', [
            'cities' => City::orderBy('name')->filter(request(['search']))->get()
        ]);
    }

    public function create()
    {
        return view('cities.create');
    }

    public function store(Request $request)
    {
        $formData = $request->validate([
            'region' => 'required',
            'name' => 'required'
        ]);

        City::create($formData);

        return redirect('/admin/cities');
    }

    public function edit($city_id)
    {
        return view('cities.edit', ['city' => City::find($city_id)]);
    }

    public function update(Request $request, $city_id)
    {
        $formData = $request->validate([
            'region' => 'required',
            'name' => 'required'
        ]);

        City::find($city_id)->update($formData);

        return redirect('/admin/cities');
    }

    public function destroy($city_id)
    {
        City::find($city_id)->delete();
        return redirect('/admin/cities');
    }
}

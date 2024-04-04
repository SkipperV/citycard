<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\TransportRoute;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransportRouteController extends Controller
{
    public function index(City $city): View
    {
        return view('transport_routes.index', [
            'city' => $city,
            'transportRoutes' => $city->transportRoutes()->orderBy('transport_type')->orderBy('route_number')->get()
        ]);
    }

    public function create(City $city): View
    {
        return view('transport_routes.create', ['city' => $city]);
    }

    public function store(Request $request, City $city): RedirectResponse
    {
        $request->validate([
            'route_number' => ['required', 'numeric'],
            'transport_type' => 'required',
            'route_endpoint_1' => 'required',
            'route_endpoint_2' => 'required',
        ]);

        $transport = new TransportRoute();
        $transport->city_id = $city->id;
        $transport->route_number = $request->route_number;
        $transport->transport_type = $request->transport_type;
        $transport->route_endpoint_1 = $request->route_endpoint_1;
        $transport->route_endpoint_2 = $request->route_endpoint_2;

        $transport->save();

        return redirect()->route('transport.index', ['city' => $city]);
    }

    public function edit(City $city, TransportRoute $transport): View
    {
        return view('transport_routes.edit', [
            'city' => $city,
            'transportRoute' => $transport
        ]);
    }

    public function update(Request $request, City $city, TransportRoute $transport): RedirectResponse
    {
        $formData = $request->validate([
            'route_number' => ['required', 'numeric'],
            'transport_type' => 'required',
            'route_endpoint_1' => 'required',
            'route_endpoint_2' => 'required',
        ]);

        $transport->update($formData);

        return redirect()->route('transport.index', ['city' => $city]);
    }

    public function destroy(City $city, TransportRoute $transport): RedirectResponse
    {
        $transport->delete();

        return redirect()->route('transport.index', ['city' => $city]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\TransportRoute;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TransportRouteController extends Controller
{
    public function index(City $city): Response
    {
        return Inertia::render('Transport/Index', [
            'city' => $city,
            'transports' => $city->transportRoutes()->orderBy('transport_type')->orderBy('route_number')->get()
        ]);
    }

    public function create(City $city): Response
    {
        return Inertia::render('Transport/Create', ['city' => $city]);
    }

    public function store(Request $request, City $city): RedirectResponse
    {
        $request->validate([
            'route_number' => 'required|numeric',
            'transport_type' => 'required|in:Автобус,Тролейбус',
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

        return to_route('transport.index', ['city' => $city]);
    }

    public function edit(City $city, TransportRoute $transport): Response
    {
        if ($transport->city != $city) {
            return abort(404);
        }
        return Inertia::render('Transport/Edit', [
            'city' => $city,
            'transport' => $transport
        ]);
    }

    public function update(Request $request, City $city, TransportRoute $transport): RedirectResponse
    {
        $formData = $request->validate([
            'route_number' => 'required|numeric',
            'transport_type' => 'required|in:Автобус,Тролейбус',
            'route_endpoint_1' => 'required',
            'route_endpoint_2' => 'required',
        ]);

        $transport->update($formData);

        return to_route('transport.index', ['city' => $city]);
    }

    public function destroy(City $city, TransportRoute $transport): RedirectResponse
    {
        $transport->delete();

        return to_route('transport.index', ['city' => $city]);
    }
}

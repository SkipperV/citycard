<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransportRequest;
use App\Http\Requests\UpdateTransportRequest;
use App\Models\City;
use App\Models\TransportRoute;
use Illuminate\Http\RedirectResponse;
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

    public function store(StoreTransportRequest $request, City $city): RedirectResponse
    {
        $formData = $request->validated();
        $city->transportRoutes()->create($formData);

        return to_route('transport.index', ['city' => $city]);
    }

    public function edit(City $city, TransportRoute $transportRoute): \Illuminate\Http\Response|Response
    {
        if ($transportRoute->city != $city) {
            return response([], \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
        return Inertia::render('Transport/Edit', [
            'city' => $city,
            'transportRoute' => $transportRoute
        ]);
    }

    public function update(UpdateTransportRequest $request, City $city, TransportRoute $transportRoute): RedirectResponse
    {
        $formData = $request->validated();
        $transportRoute->update($formData);

        return to_route('transport.index', ['city' => $city]);
    }

    public function destroy(City $city, TransportRoute $transportRoute): RedirectResponse
    {
        $transportRoute->delete();

        return to_route('transport.index', ['city' => $city]);
    }
}

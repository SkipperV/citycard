<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\TransportRoute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransportRouteController extends Controller
{
    public function index(City $city): Response|Collection
    {
        $transport = $city->transportRoutes()->get();
        return $transport->isNotEmpty() ? $transport : response([], 204);
    }

    public function store(Request $request, City $city): Response
    {
        $fields = $request->validate([
            'route_number' => 'numeric',
            'transport_type' => 'in:Автобус,Тролейбус',
            'route_endpoint_1' => 'max:255',
            'route_endpoint_2' => 'max:255',
        ]);

        $transport = TransportRoute::make($fields);
        $transport->city_id = $city->id;
        $transport->save();

        return response($transport, 201);
    }

    public function show(City $city, TransportRoute $transport): TransportRoute|Response
    {
        if ($transport->city_id != $city->id) {
            return response(['message' => 'Resource not found'], 404);
        }

        return $transport;
    }

    public function update(Request $request, City $city, TransportRoute $transport): Response|TransportRoute
    {
        $fields = $request->validate([
            'route_number' => 'numeric',
            'transport_type' => 'in:Автобус,Тролейбус',
            'route_endpoint_1' => 'max:255',
            'route_endpoint_2' => 'max:255',
        ]);

        if ($transport->city_id != $city->id) {
            return response(['message' => 'Resource not found'], 404);
        }
        $transport->update($fields);

        return $transport;
    }

    public function destroy(City $city, TransportRoute $transport): Response
    {
        if ($transport->city_id != $city->id) {
            return response(['error' => 'Resource not found'], 404);
        }

        $transport->delete();
        return response(['message' => 'Successful operation']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\TransportRoute;
use Illuminate\Http\Request;

class TransportRouteController extends Controller
{
    public function index($city_id)
    {
        $city = City::find($city_id);
        return view('transport-routes.index', [
            'city' => $city,
            'transport_routes' => $city->transportRoutes()->orderBy('transport_type')->orderBy('route_number')->get()
        ]);
    }

    public function create($city_id)
    {
        return view('transport-routes.create', ['city_id' => $city_id]);
    }

    public function store(Request $request, $city_id)
    {
        $request->validate([
            'route_number' => ['required', 'numeric'],
            'transport_type' => 'required',
            'route_endpoint_1' => 'required',
            'route_endpoint_2' => 'required',
        ]);

        $transport = new TransportRoute();
        $transport->city_id = $city_id;
        $transport->route_number = $request->route_number;
        $transport->transport_type = $request->transport_type;
        $transport->route_endpoint_1 = $request->route_endpoint_1;
        $transport->route_endpoint_2 = $request->route_endpoint_2;

        $transport->save();

        return redirect('/admin/cities/' . $city_id . '/transport');
    }

    public function edit($city_id, $transport_id)
    {
        return view('transport-routes.edit', ['city_id' => $city_id, 'transport_route' => TransportRoute::find($transport_id)]);
    }

    public function update(Request $request, $city_id, $transport_id)
    {
        $formData = $request->validate([
            'route_number' => ['required', 'numeric'],
            'transport_type' => 'required',
            'route_endpoint_1' => 'required',
            'route_endpoint_2' => 'required',
        ]);

        TransportRoute::find($transport_id)->update($formData);

        return redirect('/admin/cities/' . $city_id . '/transport');
    }

    public function destroy($city_id, $transport_id)
    {
        TransportRoute::find($transport_id)->delete();
        return redirect('/admin/cities/' . $city_id . '/transport');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index($city_id)
    {
        $city = City::find($city_id);
        return view('tickets.index', [
            'city' => $city,
            'tickets' => $city->tickets()->orderBy('transport_type')->orderBy('ticket_type')->get()
        ]);
    }

    public function create($city_id)
    {
        return view('tickets.create', ['city_id' => $city_id]);
    }

    public function store(Request $request, $city_id)
    {
        $request->validate([
            'transport_type' => 'required',
            'ticket_type' => 'required',
            'price' => ['required', 'numeric']
        ]);

        $ticket = new Ticket();
        $ticket->city_id = $city_id;
        $ticket->transport_type = $request->transport_type;
        $ticket->ticket_type = $request->ticket_type;
        $ticket->price = $request->price;

        $ticket->save();

        return redirect('/admin/cities/' . $city_id . '/tickets');
    }

    public function edit($city_id, $ticket_id)
    {
        return view('tickets.edit', ['city_id' => $city_id, 'ticket' => Ticket::find($ticket_id)]);
    }

    public function update(Request $request, $city_id, $ticket_id)
    {
        $formData = $request->validate([
            'transport_type' => 'required',
            'ticket_type' => 'required',
            'price' => ['required', 'numeric']
        ]);

        Ticket::find($ticket_id)->update($formData);

        return redirect('/admin/cities/' . $city_id . '/tickets');
    }

    public function destroy($city_id, $ticket_id)
    {
        Ticket::find($ticket_id)->delete();
        return redirect('/admin/cities/' . $city_id . '/tickets');
    }
}

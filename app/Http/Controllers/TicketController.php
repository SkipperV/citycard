<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function index(City $city): View
    {
        return view('tickets.index', [
            'city' => $city,
            'tickets' => $city->tickets()->orderBy('transport_type')->orderBy('ticket_type')->get()
        ]);
    }

    public function create(City $city): View
    {
        return view('tickets.create', ['city' => $city]);
    }

    public function store(Request $request, City $city): RedirectResponse
    {
        $request->validate([
            'transport_type' => 'required',
            'ticket_type' => 'required',
            'price' => ['required', 'numeric']
        ]);

        $ticket = new Ticket();
        $ticket->city_id = $city->id;
        $ticket->transport_type = $request->transport_type;
        $ticket->ticket_type = $request->ticket_type;
        $ticket->price = $request->price;

        $ticket->save();

        return redirect()->route('tickets.index', ['city' => $city]);
    }

    public function edit(City $city, Ticket $ticket): View
    {
        return view('tickets.edit', [
            'city' => $city,
            'ticket' => $ticket
        ]);
    }

    public function update(Request $request, City $city, Ticket $ticket): RedirectResponse
    {
        $formData = $request->validate([
            'transport_type' => 'required',
            'ticket_type' => 'required',
            'price' => ['required', 'numeric']
        ]);

        $ticket->update($formData);

        return redirect()->route('tickets.index', ['city' => $city]);
    }

    public function destroy(City $city, Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()->route('tickets.index', ['city' => $city]);
    }
}

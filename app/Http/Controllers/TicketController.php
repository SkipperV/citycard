<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    public function index(City $city): Response
    {
        return Inertia::render('Tickets/Index', [
            'city' => $city,
            'tickets' => $city->tickets()->orderBy('transport_type')->orderBy('ticket_type')->get()
        ]);
    }

    public function create(City $city): Response
    {
        return Inertia::render('Tickets/Create', ['city' => $city]);
    }

    public function store(Request $request, City $city): RedirectResponse
    {
        $request->validate([
            'transport_type' => 'required|in:Автобус,Тролейбус',
            'ticket_type' => 'required|in:Стандартний,Дитячий,Студентський,Пільговий,Спеціальний',
            'price' => 'required|numeric'
        ]);

        $ticket = new Ticket();
        $ticket->city_id = $city->id;
        $ticket->transport_type = $request->transport_type;
        $ticket->ticket_type = $request->ticket_type;
        $ticket->price = $request->price;

        $ticket->save();

        return to_route('tickets.index', ['city' => $city]);
    }

    public function edit(City $city, Ticket $ticket): Response
    {
        if ($ticket->city != $city) {
            return abort(404);
        }
        return Inertia::render('Tickets/Edit', [
            'city' => $city,
            'ticket' => $ticket
        ]);
    }

    public function update(Request $request, City $city, Ticket $ticket): RedirectResponse
    {
        $formData = $request->validate([
            'transport_type' => 'required|in:Автобус,Тролейбус',
            'ticket_type' => 'required|in:Стандартний,Дитячий,Студентський,Пільговий,Спеціальний',
            'price' => 'required|numeric'
        ]);

        $ticket->update($formData);

        return to_route('tickets.index', ['city' => $city]);
    }

    public function destroy(City $city, Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return to_route('tickets.index', ['city' => $city]);
    }
}

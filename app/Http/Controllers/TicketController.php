<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\City;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
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

    public function store(StoreTicketRequest $request, City $city): RedirectResponse
    {
        $formData = $request->validated();
        $city->tickets()->create($formData);

        return to_route('tickets.index', ['city' => $city]);
    }

    public function edit(City $city, Ticket $ticket): Response
    {
        if ($ticket->city != $city) {
            return response()->abort(404);
        }
        return Inertia::render('Tickets/Edit', [
            'city' => $city,
            'ticket' => $ticket
        ]);
    }

    public function update(UpdateTicketRequest $request, City $city, Ticket $ticket): RedirectResponse
    {
        $formData = $request->validated();
        $ticket->update($formData);

        return to_route('tickets.index', ['city' => $city]);
    }

    public function destroy(City $city, Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return to_route('tickets.index', ['city' => $city]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TicketController extends Controller
{
    public function index(City $city): Response|Collection
    {
        $tickets = $city->tickets()->get();
        return $tickets->isNotEmpty() ? $tickets : response([], 204);
    }

    public function store(Request $request, City $city): Response
    {
        $fields = $request->validate([
            'transport_type' => 'required|in:Автобус,Тролейбус',
            'ticket_type' => 'required|in:Стандартний,Дитячий,Студентський,Пільговий,Спеціальний',
            'price' => 'required|numeric'
        ]);

        $ticket = Ticket::make($fields);
        $ticket->city_id = $city->id;
        $ticket->save();

        return response($ticket, 201);
    }

    public function show(City $city, Ticket $ticket): Ticket|Response
    {
        if ($ticket->city_id != $city->id) {
            return response(['error' => 'Resource not found'], 404);
        }

        return $ticket;
    }

    public function update(Request $request, City $city, Ticket $ticket): Response|Ticket
    {
        $fields = $request->validate([
            'transport_type' => 'in:Автобус,Тролейбус',
            'ticket_type' => 'in:Стандартний,Дитячий,Студентський,Пільговий,Спеціальний',
            'price' => 'numeric'
        ]);

        if ($ticket->city_id != $city->id) {
            return response(['error' => 'Resource not found'], 404);
        }
        $ticket->update($fields);

        return $ticket;
    }

    public function destroy(City $city, Ticket $ticket): Response
    {
        if ($ticket->city_id != $city->id) {
            return response(['error' => 'Resource not found'], 404);
        }

        $ticket->delete();
        return response(['message' => 'Successful operation']);
    }
}

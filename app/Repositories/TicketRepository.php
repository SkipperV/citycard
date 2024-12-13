<?php

namespace App\Repositories;

use App\Interfaces\TicketRepositoryInterface;
use App\Models\City;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;

class TicketRepository implements TicketRepositoryInterface
{
    public function getTicketsByCity(City $city): Collection
    {
        return $city->tickets;
    }

    public function createTicket(City $city, array $data): Ticket
    {
        $ticket = new Ticket($data);
        $city->tickets()->save($ticket);

        return $ticket;
    }

    public function updateTicket(Ticket $ticket, array $newData): Ticket
    {
        $ticket->update($newData);
        return $ticket->fresh();
    }

    public function deleteTicket(Ticket $ticket): bool
    {
        return $ticket->delete();
    }
}

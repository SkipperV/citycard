<?php

namespace App\Interfaces;

use App\Models\City;
use App\Models\Ticket;

interface TicketRepositoryInterface
{
    public function getTicketsByCity(City $city);

    public function createTicket(City $city, array $data);

    public function updateTicket(Ticket $ticket, array $newData);

    public function deleteTicket(Ticket $ticket);
}

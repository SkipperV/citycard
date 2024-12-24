<?php

namespace App\Interfaces;

use App\Models\City;
use App\Models\TransportRoute;

interface TransportRepositoryInterface
{
    public function getTransportByCity(City $city);

    public function createTransport(City $city, array $data);

    public function updateTransport(TransportRoute $transport, array $newData);

    public function deleteTransport(TransportRoute $transport);
}

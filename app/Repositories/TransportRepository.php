<?php

namespace App\Repositories;

use App\Interfaces\TransportRepositoryInterface;
use App\Models\City;
use App\Models\TransportRoute;
use Illuminate\Database\Eloquent\Collection;

class TransportRepository implements TransportRepositoryInterface
{
    public function getTransportByCity(City $city): Collection
    {
        return $city->transportRoutes;
    }

    public function createTransport(City $city, array $data): TransportRoute
    {
        $transport = new TransportRoute($data);
        $city->transportRoutes()->save($transport);

        return $transport;
    }

    public function updateTransport(TransportRoute $transport, array $newData): TransportRoute
    {
        $transport->update($newData);
        return $transport->fresh();
    }

    public function deleteTransport(TransportRoute $transport): ?bool
    {
        return $transport->delete();
    }
}

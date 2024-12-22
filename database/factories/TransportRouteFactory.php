<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransportRoute>
 */
class TransportRouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id' => 1,
            'route_number' => 1,
            'transport_type' => "bus",
            'route_endpoint_1' => "Кінцева",
            'route_endpoint_2' => "Кінцева"
        ];
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Card;
use App\Models\CardTransaction;
use App\Models\City;
use App\Models\Ticket;
use App\Models\TransportRoute;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'login' => 'admin',
            'is_admin' => '1',
            'password' => 'password',
        ]);
        User::factory()->create([
            'login' => '+380501234789',
            'password' => 'password',
        ]);

        City::factory()->create([
            'name' => 'Луцьк',
            'region' => 'Волинська'
        ]);

        Ticket::factory()->create([
            'city_id' => 1,
            'transport_type' => "bus",
            'ticket_type' => "regular",
            'price' => 14
        ]);
        Ticket::factory()->create([
            'city_id' => 1,
            'transport_type' => "electric",
            'ticket_type' => "student",
            'price' => 4
        ]);

        TransportRoute::factory()->create([
            'city_id' => 1,
            'route_number' => 32,
            'transport_type' => "electric",
            'route_endpoint_1' => "с. Липини",
            'route_endpoint_2' => "сел. Вересневе",
        ]);
        TransportRoute::factory()->create([
            'city_id' => 1,
            'route_number' => 12,
            'transport_type' => "electric",
            'route_endpoint_1' => "вул. Володимирська",
            'route_endpoint_2' => "КРЗ",
        ]);

        Card::factory(2)->create();
        Card::factory()->create([
            'number' => 11111111111,
            'type' => "special",
            'current_balance' => 250
        ]);

        CardTransaction::factory(20)->create([
            'transaction_type' => 'outcome'
        ]);

        for ($i = 1; $i < 4; $i++) {
            CardTransaction::factory()->create([
                'card_id' => $i,
                'transaction_type' => 'income',
                'balance_change' => fake()->randomElement([100, 150, 200])
            ]);
        }

        for ($i = 1; $i < 100; $i++) {
            CardTransaction::factory()->create([
                'card_id' => rand(1, 3),
                'created_at' => date("Y-m-d h:m:s", rand(Carbon::create(2024, 3)->unix(), Carbon::now()->unix())),
                'transaction_type' => 'outcome'
            ]);
        }
    }
}

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
use Illuminate\Support\Facades\DB;

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
            'transport_type' => "Автобус",
            'ticket_type' => "Стандартний",
            'price' => 14
        ]);
        Ticket::factory()->create([
            'city_id' => 1,
            'transport_type' => "Тролейбус",
            'ticket_type' => "Студентський",
            'price' => 4
        ]);

        TransportRoute::factory()->create([
            'city_id' => 1,
            'route_number' => 32,
            'transport_type' => "Автобус",
            'route_endpoint_1' => "с. Липини",
            'route_endpoint_2' => "сел. Вересневе",
        ]);
        TransportRoute::factory()->create([
            'city_id' => 1,
            'route_number' => 12,
            'transport_type' => "Тролейбус",
            'route_endpoint_1' => "вул. Володимирська",
            'route_endpoint_2' => "КРЗ",
        ]);

        Card::factory(2)->create();
        DB::table('cards')->insert([
            'number' => 11111111111,
            'type' => "Спеціальний",
            'current_balance' => 250
        ]);

        CardTransaction::factory(20)->create();
        for ($i = 1; $i < 4; $i++) {
            CardTransaction::factory()->create([
                'card_id' => $i,
                'transaction_type' => 1,
                'balance_change' => fake()->randomElement([100, 150, 200])
            ]);
        }

        for ($i = 1; $i < 100; $i++) {
            CardTransaction::factory()->create([
                'card_id' => 1,
                'created_at' => date("Y-m-d h:m:s", rand(Carbon::create(2024, 3)->unix(), Carbon::now()->unix()))
            ]);
        }
    }
}

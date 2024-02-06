<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'login' => 'admin',
            'is_admin' => '1',
            'password' => 'password',
        ]);
        \App\Models\User::factory(10)->create();

        DB::table('cities')->insert([
            'name' => 'Луцьк',
            'region' => 'Волинська'
        ]);

        DB::table('tickets')->insert([
            'city_id' => 1,
            'transport_type' => "Автобус",
            'ticket_type' => "Стандартний",
            'price' => 14
        ]);
        DB::table('tickets')->insert([
            'city_id' => 1,
            'transport_type' => "Тролейбус",
            'ticket_type' => "Стандартний",
            'price' => 8
        ]);
        DB::table('tickets')->insert([
            'city_id' => 1,
            'transport_type' => "Тролейбус",
            'ticket_type' => "Студентський",
            'price' => 4
        ]);

        DB::table('transport_routes')->insert([
            'city_id' => 1,
            'route_number' => 32,
            'transport_type' => "Автобус",
            'route_endpoint_1' => "с. Липини",
            'route_endpoint_2' => "сел. Вересневе",
        ]);

        DB::table('transport_routes')->insert([
            'city_id' => 1,
            'route_number' => 12,
            'transport_type' => "Тролейбус",
            'route_endpoint_1' => "вул. Володимирська",
            'route_endpoint_2' => "КРЗ",
        ]);

        \App\Models\Card::factory(10)->create();
        \App\Models\CardTransaction::factory(40)->create();
        for ($i = 1; $i < 11; $i++) {
            \App\Models\CardTransaction::factory()->create([
                'card_id' => $i,
                'transaction_type' => 1,
                'balance_change' => fake()->randomElement([100, 150, 200])
            ]);
        }

        DB::table('cards')->insert([
            'city_id' => 1,
            'number' => 11111111111,
            'type' => "Спеціальний",
            'current_balance' => 250
        ]);
    }
}

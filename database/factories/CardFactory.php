<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement(range(1, 10)),
            'city_id' => 1,
            'number' =>
                $this->faker->randomDigitNotNull() .
                $this->faker->randomDigit() .
                $this->faker->unique()->randomNumber(9, true),
            'type' => $this->faker->randomElement(['Стандартний', 'Дитячий', 'Студентський', 'Пільговий', 'Спеціальний']),
            'current_balance' => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}

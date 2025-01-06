<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardTransaction>
 */
class CardTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'card_id' => $this->faker->randomElement(range(1, 3)),
            'transaction_type' => $this->faker->randomElement(['income', 'outcome']),
            'balance_change' => $this->faker->randomElement([8, 14])
        ];
    }
}

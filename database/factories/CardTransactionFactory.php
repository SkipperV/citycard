<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'card_id'=>$this->faker->randomElement(range(1,10)),
            'transaction_type'=>0,
            'balance_change'=>$this->faker->randomElement([8, 14])
        ];
    }
}

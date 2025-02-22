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
            'user_id' => 2,
            'number' => $this->faker->unique()->numerify('###########'),
            'type' => $this->faker
                ->randomElement(['regular', 'child', 'student', 'preferential', 'special']),
            'current_balance' => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DiscountRule>
 */
class DiscountRuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'condition' => fake()->randomElement(['GREATER THAN', 'LESS THAN', 'GREATER THAN OR EQUAL', 'LESS THAN OR EQUAL','EQUAL']),
            'dependent' => fake()->randomElement(['ITEM', 'PRICE']),
            'value' => fake()->numberBetween(1, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

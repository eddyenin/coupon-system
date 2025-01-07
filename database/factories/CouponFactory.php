<?php

namespace Database\Factories;

use App\Models\Discounts;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'discount_id' => Discounts::factory(),
            'coupon_code' => strtoupper(fake()->bothify('??##??##')),
            'max' => fake()->numberBetween(0,1),
            'expires_at' => fake()->dateTimeBetween('now', '+3 days'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

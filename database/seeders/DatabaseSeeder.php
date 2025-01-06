<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\DiscountRule;
use App\Models\Discounts;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::factory(10)->create();
        Discounts::factory(10)->create();
        Coupon::factory(6)->create();

        DiscountRule::factory(7)->create();

        // User::factory(10)->create();
        // Discounts::factory(8)->create()->each(function($discount){
        //     $rule = DiscountRule::factory(5)->create();
        //     $discount->discountRule()->attach($rule->pluck('id'));
        // });

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

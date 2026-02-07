<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 5, 500),
            'category' => $this->faker->randomElement(['Food', 'Toys', 'Beds', 'Clothing', 'Accessories']),
            'pet_type' => $this->faker->randomElement(['Dog', 'Cat', 'Bird', 'Rabbit', 'Fish']),
            'location' => str_pad($this->faker->numberBetween(1, 69), 2, '0', STR_PAD_LEFT),
            'image_path' => 'media/images/default.png',
            'status' => 'accepted',
        ];
    }
}

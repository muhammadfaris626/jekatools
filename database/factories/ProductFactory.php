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
        $type = $this->faker->randomElement(['langganan', 'non-langganan']);
        $price = $this->faker->numberBetween(10000, 200000);

        // Jika langganan, ambil durasi secara acak
        $duration = $type === 'langganan' ? $this->faker->randomElement([30, 60, 90]) : null;

        return [
            'name' => $type === 'langganan'
                ? 'Langganan ' . $duration . ' Hari'
                : 'Akun ' . $this->faker->randomElement(['Gmail', 'Tiktok', 'Shopee']),
            'desc' => $this->faker->sentence(),
            'type' => $type,
            'price' => $price,
            'duration_days' => $duration,
            'stock' => $type === 'non-langganan' ? $this->faker->numberBetween(1, 100) : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

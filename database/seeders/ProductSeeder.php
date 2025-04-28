<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 5 produk langganan
        Product::factory()->count(15)->state(['type' => 'langganan'])->create();

        // Buat 5 produk non-langganan
        Product::factory()->count(10)->state(['type' => 'non-langganan'])->create();
    }
}

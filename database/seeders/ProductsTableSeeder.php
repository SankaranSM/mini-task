<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Sample Product 1',
            'product_id' => 'PROD1',
            'available_stocks' => 100,
            'price' => 49.99,
            'tax_percentage' => 5.0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Product::create([
            'name' => 'Sample Product 2',
            'product_id' => 'PROD2',
            'available_stocks' => 200,
            'price' => 79.99,
            'tax_percentage' => 10.0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Product::create([
            'name' => 'Sample Product 3',
            'product_id' => 'PROD3',
            'available_stocks' => 50,
            'price' => 99.99,
            'tax_percentage' => 15.0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

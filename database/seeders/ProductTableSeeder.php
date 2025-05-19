<?php

namespace Database\Seeders;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            Product::create([
                'name' => 'Product ' . $i,
                'code' => 'P' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'price' => rand(100, 10000) / 100,
                'created_at' => Carbon::now(),
                'created_by' => 1,
            ]);
        }
    }
}

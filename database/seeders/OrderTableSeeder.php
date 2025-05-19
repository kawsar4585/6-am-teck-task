<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Services\User\OrderService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Auth::shouldReceive('id')->andReturn(2);
        Auth::shouldReceive('user')->andReturn((object)['id' => 2]);

        $orderService = App::make(OrderService::class);

        for ($i = 0; $i < 2000; $i++) {
            $products = Product::inRandomOrder()->limit(rand(3, 6))->pluck('id')->toArray();

            $productData = [];
            foreach ($products as $productId) {
                $productData[$productId] = rand(1, 5);
            }

            $request = new \Illuminate\Http\Request();
            $request->replace(['products' => $productData]);

            $orderService->createOrder($request);
        }

        $this->command->info('50 orders seeded for user_id 2.');
    }
}

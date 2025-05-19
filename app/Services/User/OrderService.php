<?php

namespace App\Services\User;

use App\Enums\Deleted;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class OrderService
{
    protected $pagination_limit;
    protected $userId;
    protected $cache_duration;

    public function __construct()
    {
        $this->pagination_limit = env('PAGINATION_LIMIT', 20);
        $this->userId = Auth::id();
        $this->cache_duration = (int) env('ORDER_CACHE_DURATION', 5);
    }

    public function createOrder($request)
    {
        $products = $request->input('products', []);

        if (empty($products)) {
            throw new \Exception('No products selected for the order.');
        }

        DB::beginTransaction();

        try {
            $total = 0;

            $order = new Order();
            $order->user_id = $this->userId;
            $order->total_amount = 0;
            $order->created_at = Carbon::now();
            $order->created_by = $this->userId;
            $order->save();

            foreach ($products as $productId => $quantity) {

                $product = Product::where('id',$productId)
                    ->where('deleted', Deleted::NO->value)
                    ->first();
                if(empty($product)){
                    continue;
                }

                $total += $product->price * $quantity;

                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $productId;
                $orderDetail->user_id = $this->userId;
                $orderDetail->amount = $product->price * $quantity;
                $orderDetail->created_at = Carbon::now();
                $orderDetail->created_by = $this->userId;
                $orderDetail->save();
            }

            $order->total_amount = $total;
            $order->updated_by = $this->userId;
            $order->updated_at = Carbon::now();
            $order->save();

            Cache::forget("user_orders_{$this->userId}_page_1");

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function getUserOrders($request)
    {
        $page = $request->input('page', 1);
        $cacheKey = "user_orders_{$this->userId}_page_{$page}";

        $data['orders'] = Cache::remember($cacheKey, now()->addMinutes($this->cache_duration), function () {
            return Order::with([
                'orderDetails' => function ($q) {
                    $q->select('id', 'order_id', 'product_id', 'amount');
                },
                'orderDetails.product' => function ($q) {
                    $q->select('id', 'name', 'price', 'code');
                }
            ])
            ->select('id', 'user_id', 'status', 'created_at', 'total_amount')
            ->where('user_id', $this->userId)
            ->where('deleted', Deleted::NO->value)
            ->orderByDesc('id')
            ->paginate($this->pagination_limit);
        });

        return $data;
    }
}

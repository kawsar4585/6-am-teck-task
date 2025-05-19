<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\User\StoreOrderRequest;
use App\Models\Product;
use App\Services\User\OrderService;
use Illuminate\Http\Request;

class OrderController extends BackendController
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->addBreadcrumbs('Home', route('user.dashboard'), 'fa fa-home');
    }

    public function index(Request $request)
    {
        $this->setPageTitle('Order List');
        $this->setActiveMenu('orders');
        $this->setPageHeaderTitle('Order List');

        $start = microtime(true);
        $data = $this->orderService->getUserOrders($request);
        $end = microtime(true);
        $data['executionTime'] = $end - $start;
        return $this->view('user.orders.index')->with($data);
    }

    public function create()
    {
        $this->setPageTitle('Order Create');
        $this->setPageHeaderTitle('Order Crete');
        $this->setActiveMenu('orders');

        $data['products'] = Product::paginate(20);

        return $this->view('user.orders.create')->with($data);
    }

    public function store(StoreOrderRequest $request)
    {
        $this->orderService->createOrder($request);

        return redirect()->route('user.orders.index')->with('success', 'Order created!');
    }
}

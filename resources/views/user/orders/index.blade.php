@extends('user.layouts.layout')

@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="{{ route('user.orders.create') }}" class="btn add-btn erp-add-employee ms-2" ><i class="fa-solid fa-plus"></i> Create</a>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Orders</div>
                <div class="card-body">
                    @if($orders->isEmpty())
                        <div class="alert alert-info">No data yet.</div>
                    @else
                        <p><strong>Query Execution Time:</strong> {{ $executionTime }} seconds</p>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Total Amount</th>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                @foreach($order->orderDetails as $index => $detail)
                                    <tr>
                                        @if($index == 0)
                                            <td rowspan="{{ $order->orderDetails->count() }}">#{{ $order->id }}</td>
                                            <td rowspan="{{ $order->orderDetails->count() }}">${{ $order->total_amount }}</td>
                                        @endif
                                        <td>{{ $detail->product->name ?? '-' }}</td>
                                        <td>${{ number_format($detail->product->price, 2) ?? '0.00' }}</td>
                                        <td>${{ number_format($detail->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>

                        {{ $orders->links('vendor.pagination.common_pagination') }}

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

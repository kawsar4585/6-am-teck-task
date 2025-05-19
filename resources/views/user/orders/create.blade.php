@extends('user.layouts.layout')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Create New Order</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.orders.store') }}" onsubmit="return validateOrder();">
                        @csrf

                        <h5 class="mb-3">Select Products</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Select</th>
                                        <th>Product</th>
                                        <th>Code</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="product-check" data-id="{{ $product->id }}">
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->code }}</td>
                                            <td>${{ number_format($product->price, 2) }}</td>
                                            <td>
                                                <input type="number"
                                                       name="products[{{ $product->id }}]"
                                                       class="form-control qty-input"
                                                       min="1"
                                                       value="1"
                                                       data-id="{{ $product->id }}"
                                                       disabled>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Place Order</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Enable/disable quantity field when checkbox is clicked
    document.querySelectorAll('.product-check').forEach((checkbox) => {
        checkbox.addEventListener('change', function () {
            const id = this.dataset.id;
            const qtyInput = document.querySelector(`.qty-input[data-id="${id}"]`);
            qtyInput.disabled = !this.checked;
        });
    });

    function validateOrder() {
        const checked = document.querySelectorAll('.product-check:checked');
        if (checked.length === 0) {
            alert('Please select at least one product to order.');
            return false;
        }
        return true;
    }
</script>
@endsection

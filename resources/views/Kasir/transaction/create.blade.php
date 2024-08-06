@extends('layouts.sidebar')

@section('content')

@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                confirmButtonColor: "#3085d6",
                text: '{{ session('error') }}'
            });
        });
    </script>
@endif

<div class="" style="margin: 50px">
    <div class=" w-full h-full p-6 bg-transparent">
        <form action="{{ route('kasir.transaction.store') }}" method="POST">
        @csrf
        <div class="flex justify-between">
            <h1 class="text-2xl font-semibold">Add New Transaction</h1>
            <div>
                <a href="{{ route('kasir.transaction.index') }}" class="border-2 px-3 py-2 text-sm rounded-2xl">Cancel</a>
                <button type="submit" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600">Save</button>
            </div>
        </div>
        <div class="mt-10 border-2 p-6 rounded-lg w-full bg-[#f9f9f9] shadow-2xl border-none">
            <div class="flex justify-center">
                <div class="w-full">
                    <label for="product_id" class="text-sm font-semibold">Product</label>
                    <select name="product_id" id="product_id" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mb-4">
                        <option value="" disabled selected>Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->product_id }}" data-brand="{{ $product->brand->brand_name ?? '' }}" data-category="{{ $product->categories->category_name ?? '' }}" data-price="{{ $product->unit_price }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <label for="brand" class="text-sm font-semibold">Brand</label>
            <input type="text" name="brand" id="brand" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mb-4" readonly>
            <label for="category" class="text-sm font-semibold">Category</label>
            <input type="text" name="category" id="category" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mb-4" readonly>
            <label for="unit_price" class="text-sm font-semibold">Unit Price</label>
            <input type="text" name="unit_price" id="unit_price" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mb-4" readonly>
            <label for="qty" class="text-sm font-semibold">Quantity</label>
            <input type="number" name="qty" id="qty" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mb-4" required>
            <label for="total" class="text-sm font-semibold">Total</label>
            <input type="text" name="total" id="total" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mb-4" readonly>
        </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const productSelect = document.getElementById('product_id');
    const brandInput = document.getElementById('brand');
    const categoryInput = document.getElementById('category');
    const unitPriceInput = document.getElementById('unit_price');
    const qtyInput = document.getElementById('qty');
    const totalInput = document.getElementById('total');

    productSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const brand = selectedOption.getAttribute('data-brand');
        const category = selectedOption.getAttribute('data-category');
        const price = selectedOption.getAttribute('data-price');

        brandInput.value = brand;
        categoryInput.value = category;
        unitPriceInput.value = price;
        calculateTotal();
    });

    qtyInput.addEventListener('input', calculateTotal);

    function calculateTotal() {
        const quantity = parseFloat(qtyInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        totalInput.value = total.toFixed(2);
    }
});
</script>
@endsection

@extends('layouts.master')

@section('content')
<div class="mt-10">
    <div class="w-full h-full p-6 bg-transparent">
        <form action="{{ route('receivingNotes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-between items-center space-x-1">
                <h1 class="text-2xl font-semibold">Add New Receiving Notes</h1>
                <div>
                    <a href="{{ route('admin.receivingNotes.index') }}" class="border-2 px-3 py-2 text-sm rounded-2xl">Cancel</a>
                    <button type="submit" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600">Save</button>
                </div>
            </div>

            <div class="mt-10 border-2 p-6 rounded-lg w-full bg-[#f9f9f9] shadow-2xl border-none">

                <label for="receiver" class="text-sm font-semibold mt-4 block">Receiver</label>
                <input type="text" name="receiver" id="receiver" class="bg-gray-300 h-10 mb-4 px-4 w-full border-none rounded-md" placeholder="Receiver">

                <label for="input_date" class="text-sm font-semibold">Date</label>
                <div class="relative">
                    <input type="date" name="input_date" id="input_date" class="bg-gray-300 h-10 mb-4 px-4 w-full border-none rounded-md" placeholder="Select date" required>
                </div>

                <label for="references" class="text-sm font-semibold mt-4 block">References</label>
                <input type="text" name="references" id="references" class="bg-gray-100 h-10 mb-4 px-4 w-full border-none rounded-md" placeholder="References">

                <label for="products" class="text-sm font-semibold">Products</label>
                <div id="products-container">
                    <div class="flex items-center mb-4">
                        <select name="products[]" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mr-4" required>
                            @foreach($products as $product)
                                <option value="{{ $product->product_id }}">
                                    {{ $product->product_name }} | {{ $product->brand->brand_name ?? '' }} | {{ $product->categories->category_name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="quantity[]" class="bg-gray-300 h-10 px-4 w-32 border-none rounded-md mr-4" placeholder="Quantity" required>
                        <input type="text" name="description[]" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mr-4" placeholder="Description">
                        <button type="button" class="remove-product bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600">Remove</button>
                    </div>
                </div>

                <button type="button" id="add-product" class="bg-blue-500 text-white px-3 py-2 rounded-md mt-4">Add Product</button>

            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let productIndex = 1;

        document.getElementById('add-product').addEventListener('click', function () {
            const container = document.getElementById('products-container');
            const newRow = document.createElement('div');
            newRow.classList.add('flex', 'items-center', 'mb-4');
            newRow.id = `product-row-${productIndex}`;

            newRow.innerHTML = `
                <select name="products[]" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mr-4" required>
                    @foreach($products as $product)
                        <option value="{{ $product->product_id }}">
                            {{ $product->product_name }} | {{ $product->brand->brand_name ?? '' }} | {{ $product->categories->category_name ?? '' }}
                        </option>
                    @endforeach
                </select>
                <input type="number" name="quantity[]" class="bg-gray-300 h-10 px-4 w-32 border-none rounded-md mr-4" placeholder="Quantity" required>
                <input type="text" name="description[]" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mr-4" placeholder="Description">
                <button type="button" class="remove-product bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600">Remove</button>
            `;

            container.appendChild(newRow);
            productIndex++;
        });

        document.getElementById('products-container').addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-product')) {
                e.target.parentElement.remove();
            }
        });
    });
</script>
@endsection

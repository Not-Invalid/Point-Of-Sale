@extends('layouts.master')

@section('content')
<div class="" style="margin: 50px">
    <div class=" w-full h-full p-6 bg-transparent">
        <form action="{{ route('receivingNotes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-between">
                <h1 class="text-2xl font-semibold">Add New Stock</h1>
                <div>
                    <a href="{{ route('admin.receivingNotes.index') }}" class="border-2 px-3 py-2 text-sm rounded-2xl">Cancel</a>
                    <button type="submit" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600">Save</button>
                </div>
            </div>
            <div class="mt-10 border-2 p-6 rounded-lg w-full bg-[#f9f9f9] shadow-2xl border-none">
                <label for="input_date" class="text-sm font-semibold">Date</label>
                <div class="relative">
                    <input type="date" name="input_date" id="input_date" class="bg-gray-300 h-10 mb-4 px-4 w-full border-none rounded-md" placeholder="Select date" required>
                </div>
                <label for="product_id" class="text-sm font-semibold">Product</label>
                <select id="product_id" name="product_id" class="bg-gray-300 h-10 mb-4 px-4 w-full border-none rounded-md" required onchange="fillDetails()">
                    <option selected disabled hidden>Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->product_id }}" data-brand="{{ $product->brand->brand_name ?? '' }}" data-category="{{ $product->categories->category_name ?? '' }}">{{ $product->product_name }}</option>
                    @endforeach
                </select>
                <label for="brand_name" class="text-sm font-semibold">Brand</label>
                <input type="text" name="brand_name" id="brand_name" class="bg-gray-300 h-10 mb-4 px-4 w-full border-none rounded-md" placeholder="Brand" readonly>
                <label for="category_name" class="text-sm font-semibold">Category</label>
                <input type="text" name="category_name" id="category_name" class="bg-gray-300 h-10 mb-4 px-4 w-full border-none rounded-md" placeholder="Category" readonly>
                <label for="quantity" class="text-sm font-semibold">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="bg-gray-300 h-10 mb-4 px-4 w-full border-none rounded-md" placeholder="Quantity" required>
                <label for="description" class="text-sm font-semibold">Description</label>
                <input type="text" name="description" id="description" class="bg-gray-300 h-10 mb-4 px-4 w-full border-none rounded-md" placeholder="Description">
            </div>
        </form>
    </div>
</div>

<script>
    function fillDetails() {
        const productSelect = document.getElementById('product_id');
        const selectedProduct = productSelect.options[productSelect.selectedIndex];
        document.getElementById('brand_name').value = selectedProduct.getAttribute('data-brand');
        document.getElementById('category_name').value = selectedProduct.getAttribute('data-category');
    }
</script>
@endsection

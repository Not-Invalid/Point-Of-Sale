@extends('layouts.master')

@section('content')
<div class="" style="margin: 50px">
    <div class=" w-full h-full p-6 bg-transparent">
        <form action="{{ route('admin.products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex justify-between">
                <h1 class="text-2xl font-semibold">Edit Product</h1>
                <div>
                    <a href="{{ route('admin.products.index') }}" id="backButton" class="border-2 px-3 py-2 text-sm rounded-2xl">Back</a>
                    <button type="button" id="editButton" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600">Edit</button>
                    
                    <a href="" id="cancelButton" class="border-2 px-3 py-2 text-sm rounded-2xl hidden">Cancel</a>
                    <button type="submit" id="saveButton" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600 hidden">Save</button>
                </div>
            </div>
            <div class="mt-10 border-2 p-6 rounded-lg w-full bg-[#f9f9f9] shadow-2xl border-none">
                <div class="flex justify-center">
                    <div class="w-72 ">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-36 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                @if($product->product_image)
                                    <img src="{{ asset($product->product_image) }}" id="preview-image" alt="Product Image" class="w-full h-36  object-cover rounded-lg">
                                @else
                                    <i class="fa-solid fa-plus"></i>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                @endif
                            </div>
                            <input id="dropzone-file" type="file" name="product_image" class="hidden" accept="image/*" disabled />
                        </label>
                    </div>
                </div>
                <label for="product_name" class="text-sm font-semibold">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md" placeholder="Product Name" value="{{ $product->product_name }}" required disabled>
                <label for="id_brand" class="text-sm font-semibold">Brand</label>
                <select id="id_brand" name="id_brand" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md" required disabled>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->brand_id }}" {{ $product->id_brand == $brand->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                    @endforeach
                </select>
                <label for="id_category" class="text-sm font-semibold">Category</label>
                <select id="id_category" name="id_category" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md" required disabled>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}" {{ $product->id_category == $category->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                    @endforeach
                </select>
                <label for="unit_price" class="text-sm font-semibold">Unit Price</label>
                <input type="text" name="unit_price" id="unit_price" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md" placeholder="Unit Price" value="{{ $product->unit_price }}" required disabled>
                <label for="stock" class="text-sm font-semibold">Stock</label>
                <input type="number" name="stock" id="stock" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md" placeholder="Stock" value="{{ $product->stock }}" required disabled>
                <label for="desc_product" class="text-sm font-semibold">Description</label>
                <textarea name="desc_product" id="desc_product" class="bg-gray-300 h-40 px-4 w-full border-none rounded-md resize-none" placeholder="Description Product" required disabled>{{ $product->desc_product }}</textarea>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/previewImage.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const backButton = document.getElementById('backButton');
    const editButton = document.getElementById('editButton');
    const saveButton = document.getElementById('saveButton');
    const cancelButton = document.getElementById('cancelButton');

    const formElements = [
        document.getElementById('dropzone-file'),
        document.getElementById('product_name'),
        document.getElementById('id_brand'),
        document.getElementById('id_category'),
        document.getElementById('unit_price'),
        document.getElementById('desc_product')
    ];

    editButton.addEventListener('click', () => {
        formElements.forEach(element => {
            element.disabled = false;
        });

        backButton.classList.add('hidden');
        editButton.classList.add('hidden');
        saveButton.classList.remove('hidden');
        cancelButton.classList.remove('hidden');
    });

    cancelButton.addEventListener('click', () => {
        formElements.forEach(element => {
            element.disabled = true;
        });
        backButton.classList.remove('hidden');
        editButton.classList.remove('hidden');
        saveButton.classList.add('hidden');
        cancelButton.classList.add('hidden');
    });
});
</script>
@endsection

@extends('layouts.master')

@section('content')
<div class="mt-10">
    <div class=" w-full h-full p-6 bg-transparent">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
        <div class="flex justify-between">
                <h1 class="text-2xl font-semibold">Add New Product</h1>
                <div class="flex justify-between space-x-1">
                    <a href="{{ route ('admin.products.index')}}" class="border-2  px-3 py-2  text-sm rounded-2xl">Cancel</a>                
                    <button type="submit" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600">Save</button>
                </div>
        </div>
            <div class="mt-10 border-2 p-6 rounded-lg w-full bg-[#f9f9f9] shadow-2xl border-none ">
                <div class="flex justify-center">
                    <div class="w-72 relative">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer object-cover overflow-hidden">
                            <img id="preview-image" class="hidden w-full h-32 absolute top-0 left-0" />
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10">
                               <i class="fa-solid fa-plus" ></i>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                            </div>
                            <input id="dropzone-file" type="file" name="product_image" class="hidden" accept="image/*" />
                        </label>
                    </div>  
                </div>
                <label for="product_name" class="text-sm font-semibold">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="bg-gray-300 h-10 mb-4 px-4 w-full border-none rounded-md " placeholder="Product Name" required>
                <label for="id_brand" class="text-sm font-semibold">Brand</label>
                <select id="id_brand" name="id_brand" class="bg-gray-300 h-10 px-4 mb-4 w-full border-none rounded-md " required>
                    <option selected disabled hidden>Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                    @endforeach
                </select>
                <label for="id_category" class="text-sm font-semibold">Category</label>
                <select id="id_category" name="id_category" class="bg-gray-300 h-10 px-4 mb-4 w-full border-none rounded-md " required>
                    <option selected disabled hidden>Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
                <label for="unit_price" class="text-sm font-semibold">Unit Price</label>
                <input type="text" name="unit_price" id="unit_price" class="bg-gray-300 mb-4 h-10 px-4 w-full border-none rounded-md " placeholder="Unit Price" required>
                <label for="stock" class="text-sm font-semibold">Stock</label>
                <input type="number" name="stock" id="stock" class="bg-gray-300 h-10 px-4 mb-4 w-full border-none rounded-md " placeholder="Stock" required>
                <label for="desc_product" class="text-sm font-semibold">Description</label>
                <textarea type="text" name="desc_product" id="desc_product" class="bg-gray-300 mb-4 h-40 px-4 w-full border-none rounded-md  resize-none" placeholder="Description Product" required></textarea>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('js/previewImage.js') }}"></script>
@endsection
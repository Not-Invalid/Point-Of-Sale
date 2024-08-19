@extends('layouts.master')

@section('content')
<div class="mt-10">
    <div class=" w-full h-full p-6 bg-transparent">
        <form action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-between">
                <h1 class="text-sm font-semibold sm:text-2xl">Add New Brand</h1>
                <div class="flex space-x-1 max-sm:flex max-sm:space-x-2">
                    <a href="{{ route ('admin.brand.index')}}" class="border-2 px-3 py-2 text-sm rounded-2xl flex max-sm:py-1 max-sm:px-3 max-sm:items-center">Cancel</a>                
                    <button type="submit" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600">Save</button>
                </div>
            </div>
            <div class="mt-10 border-2 p-6 rounded-lg w-full bg-[#f9f9f9] shadow-2xl border-none ">
                <div class="flex justify-center">
                    <div class="w-72 relative">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer object-cover overflow-hidden">
                            <img id="preview-image" class="hidden w-full h-40 absolute top-0 left-0" />
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10">
                               <i class="fa-solid fa-plus" ></i>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                            </div>
                            <input id="dropzone-file" type="file" name="brand_image" class="hidden" accept="image/*" />
                        </label>
                    </div>
                </div>
                <label for="brand_name" class="block mb-2 text-sm font-semibold mt-4">Brand Name</label>
                <input type="text" name="brand_name" id="brand_name" class="bg-gray-300 text-sm focus:ring-slate-400 rounded-lg border-none px-4 w-full" placeholder="Brand Name" required="">
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/previewImage.js') }}"></script>
@endsection

@extends('layouts.master')

@section('content')
<div class="mt-10">
    <div class=" w-full h-full p-6 bg-transparent">
        <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
        <div class="flex justify-between">
                <h1 class="text-sm font-semibold sm:text-2xl">Add New Category</h1>
                <div class="flex space-x-1 max-sm:flex max-sm:space-x-2">
                    <a href="{{ route ('admin.category.index')}}" class="border-2  px-3 py-2  text-sm rounded-2xl flex max-sm:py-1 max-sm:px-3 max-sm:items-center">Cancel</a>                
                    <button type="submit" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600">Save</button>
                </div>
        </div>

        <div class="mt-10 border-2 p-6 rounded-lg w-full bg-[#f9f9f9] shadow-2xl border-none ">
            <label for="category_name" class="block mb-2 text-sm font-normal mt-4">Category Name</label>
            <input type="text" name="category_name" id="category_name" class="bg-gray-300 text-sm focus:ring-slate-400 rounded-lg border-none px-4 w-full" placeholder="Category Name" required="">
        </div>
    </form>
    </div>
</div>
@endsection
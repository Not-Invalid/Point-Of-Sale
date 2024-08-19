@extends('layouts.master')

@section('content')
<div class="mt-10">
    <div class=" w-full h-full p-6 bg-transparent">
        <form action="{{ route('admin.warehouse.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
        <div class="flex justify-between">
                <h1 class="text-sm font-semibold sm:text-2xl">Add New Warehouse</h1>
                <div class="flex space-x-1 max-sm:flex max-sm:space-x-2">
                    <a href="{{ route ('admin.warehouse.index')}}" class="border-2  px-3 py-2  text-sm rounded-2xl flex max-sm:py-1 max-sm:px-3 max-sm:items-center">Cancel</a>                
                    <button type="submit" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600">Save</button>
                </div>
        </div>

        <div class="mt-10 border-2 p-6 rounded-lg w-full bg-[#f9f9f9] shadow-2xl border-none ">
            <label for="warehouse_name" class="block mb-2 text-sm font-semibold mt-4">Warehouse Name</label>
            <input type="text" name="warehouse_name" id="warehouse_name" class="bg-gray-300 h-10 px-4 mb-4 w-full border-none rounded-md" placeholder="Warehouse Name" required="">
        
            <label for="location" class="text-sm font-semibold">Location</label>
            <textarea type="text" name="location" id="location" class="bg-gray-300 mb-4 h-40 px-4 w-full border-none rounded-md  resize-none" placeholder="Location" required></textarea>
        </div>
    </form>
    </div>
</div>
@endsection
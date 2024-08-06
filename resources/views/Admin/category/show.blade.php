@extends('layouts.master')

@section('content')
<div class="" style="margin: 50px">
    <div class=" w-full h-full p-6 bg-transparent">
        <form action="{{ route('admin.category.update', $categories->category_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="flex justify-between">
                <h1 class="text-2xl font-semibold">Edit</h1>
                <div>
                    <a href="{{ route('admin.category.index') }}" id="backButton" class="border-2 px-3 py-2 text-sm rounded-2xl">Back</a>
                    <button type="button" id="editButton" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600">Edit</button>
                    
                    <a href="" id="cancelButton" class="border-2 px-3 py-2 text-sm rounded-2xl hidden">Cancel</a>
                    <button type="submit" id="saveButton" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600 hidden">Save</button>
                </div>
        </div>
            <div class="mt-10 border-2 p-6 rounded-lg w-full bg-[#f9f9f9] shadow-2xl border-none ">
                <label for="category_name" class="text-sm font-semibold">Category Name</label>
                <input type="text" name="category_name" id="category_name" placeholder="Category Name" value="{{$categories->category_name}}" class="bg-gray-300 h-10 px-4 w-full mt-2 border-none rounded-md " disabled/>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const backButton = document.getElementById('backButton');
        const editButton = document.getElementById('editButton');
        const saveButton = document.getElementById('saveButton');
        const cancelButton = document.getElementById('cancelButton');
    
        const formElements = [
            document.getElementById('category_name')
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
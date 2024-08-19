@extends('layouts.master')

@section('content')
<div class="mt-10">
    <div class=" w-full h-full p-6 bg-transparent">
        <form action="{{ route('admin.warehouse.update', $warehouses->warehouse_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="flex justify-between">
                <h1 class="text-2xl font-semibold">Edit</h1>
                <div>
                    <a href="{{ route('admin.warehouse.index') }}" id="backButton" class="border-2 px-3 py-2 text-sm rounded-2xl">Back</a>
                    <button type="button" id="editButton" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600">Edit</button>
                    
                    <a href="" id="cancelButton" class="border-2 px-3 py-2 text-sm rounded-2xl hidden">Cancel</a>
                    <button type="submit" id="saveButton" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600 hidden">Save</button>
                </div>
        </div>
            <div class="mt-10 border-2 p-6 rounded-lg w-full bg-[#f9f9f9] shadow-2xl border-none ">
                <label for="warehouse_name" class="text-sm font-semibold">Warehouse Name</label>
                <input type="text" name="warehouse_name" id="warehouse_name" placeholder="Warehouse Name" value="{{$warehouses->warehouse_name}}" class="bg-gray-300 h-10 px-4 mb-4 w-full border-none rounded-md" disabled/>

                <label for="location" class="text-sm font-semibold">Location</label>
                <textarea type="text" name="location" id="location" class="bg-gray-300 mb-4 h-40 px-4 w-full border-none rounded-md  resize-none" placeholder="Location" disabled> {{$warehouses->location}}</textarea>            
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
            document.getElementById('warehouse_name'),
            document.getElementById('location'),
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
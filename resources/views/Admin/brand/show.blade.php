@extends('layouts.master')

@section('content')
<div class="" style="margin: 50px">
    <div class=" w-full h-full p-6 bg-transparent">
        <form action="{{ route('admin.brand.update', $brand->brand_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex justify-between">
                <h1 class="text-2xl font-semibold">Edit brand</h1>
                <div>
                    <a href="{{ route('admin.brand.index') }}" id="backButton" class="border-2 px-3 py-2 text-sm rounded-2xl">Back</a>
                    <button type="button" id="editButton" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600">Edit</button>
                    
                    <a href="" id="cancelButton" class="border-2 px-3 py-2 text-sm rounded-2xl hidden">Cancel</a>
                    <button type="submit" id="saveButton" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600 hidden">Save</button>
                </div>
            </div>
            <div class="mt-10 border-2 p-6 rounded-lg w-full bg-[#f9f9f9] shadow-2xl border-none">
                <div class="flex justify-center">
                    <div class="w-72 ">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                @if($brand->brand_image)
                                    <img src="{{ asset($brand->brand_image) }}" alt="Brand Image" id="preview-image" class="h-40 w-full object-cover rounded-lg">
                                @else
                                    <i class="fa-solid fa-plus"></i>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                @endif
                            </div>
                            <input id="dropzone-file" type="file" name="brand_image" class="hidden" accept="image/*" disabled />
                        </label>
                    </div>
                </div>
                <label for="brand_name" class="text-sm font-semibold">Brand Name</label>
                <input type="text" name="brand_name" id="brand_name" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md" placeholder="Brand Name" value="{{ $brand->brand_name }}" required disabled>
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
        document.getElementById('brand_name')
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

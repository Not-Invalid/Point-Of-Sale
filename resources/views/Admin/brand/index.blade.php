@extends('layouts.master')

@section('content')

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                confirmButtonColor: "#3085d6",
                text: '{{ session('success') }}'
            });
        });
    </script>
@endif

<div class="flex justify-between mt-8">
    <div class="flex justify-start mb-4 mt-10">
        <input type="text" id="search" class="h-10 px-4 w-60 border rounded-md" placeholder="Search">
    </div>
    <div class="flex justify-end mb-4 mt-10">
        <a href="#" class="bg-red-600 text-white px-4 font-medium text-base py-2 rounded-lg drop-shadow-lg" data-modal-target="add" data-modal-toggle="add">Add Brand</a>
    </div>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow-lg">
    <table class="min-w-full leading-normal text-center">
        <thead>
            <tr class="bg-[#272626] text-white">
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">No</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Brand Name</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Brand Image</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Tools</th>
            </tr>
        </thead>
        <tbody class="text-center" id="brand-table-body">
            @foreach($brands as $brand)
            <tr class="border-b border-gray-200">
                <td class="px-5 py-5 bg-white text-sm">{{ $loop->iteration }}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ $brand->brand_name }}</td>
                <td class="px-5 py-5 bg-white text-sm ">
                    <div class="flex justify-center">
                        @if($brand->brand_image)
                        <img src="{{ asset(  $brand->brand_image) }}" alt="Brand Image" class="w-11 h-11">
                        @else
                        <span>No Image</span>
                        @endif
                    </div>
                </td>
                
                <td class="px-5 py-5 bg-white text-sm flex space-x-2 items-center justify-center">
                    <a href="#" class="text-green-500 hover:text-green-700 text-base" data-modal-target="edit{{ $brand->id }}" data-modal-toggle="edit{{ $brand->id }}"><i class="fas fa-pen"></i></a>
                    <form action="{{ route('admin.brand.delete', $brand->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-lg"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="flex justify-end mt-4">
    <nav aria-label="Page navigation">
        <ul class="inline-flex space-x-2">
            @if ($brands->onFirstPage())
                <li><span class="px-3 py-1 bg-gray-200 rounded-lg"> <i class="fa-solid fa-chevron-left "></i></span></li>
            @else
                <li><a href="{{ $brands->previousPageUrl() }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg"> <i class="fa-solid fa-chevron-left "></i></a></li>
            @endif

            @foreach ($brands->getUrlRange(1, $brands->lastPage()) as $page => $url)
                @if ($page == $brands->currentPage())
                    <li><span class="px-3 py-1 bg-red-600 text-white rounded-lg">{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($brands->hasMorePages())
                <li><a href="{{ $brands->nextPageUrl() }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg"> <i class="fa-solid fa-chevron-right "></i></a></li>
            @else
                <li><span class="px-3 py-1 bg-gray-200 rounded-lg"> <i class="fa-solid fa-chevron-right "></i></span></li>
            @endif
        </ul>
    </nav>
</div>


<!-- Modal for adding a new brand -->
<div id="add" tabindex="-1"  aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-[#272626] rounded-2xl shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-center p-1 md:p-0 rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-white mt-5">
                    Add New Brand
                </h3>
            </div>
            <!-- Modal body -->
            <form class="p-2 md:p-5" action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">

                @csrf
                <hr class="mb-3">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center mx-auto w-32 h-32 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer bg-[#3D4142] hover:bg-gray-700">
                            <div id="file-info" class="flex flex-col items-center justify-center">
                                <img id="preview-image" width="80" height="80" src="https://static-00.iconduck.com/assets.00/no-image-icon-512x512-lfoanl0w.png" alt="Uploaded Image">
                                <p class="mb-2 text-xs text-gray-500 dark:text-gray-400"><span class="font-light">Add Brand Image</span></p>
                            </div>
                            <input id="dropzone-file" type="file" name="brand_image" class="hidden" accept="image/*" />
                        </label>
                    </div>
                    <div class="col-span-2">
                        <label for="brand_name" class="block mb-2 text-sm font-normal text-white">Brand Name</label>
                        <input type="text" name="brand_name" id="brand_name" class="bg-[#3D4142]  text-white text-sm focus:ring-slate-400 rounded-lg  border-none px-4 w-full" placeholder="Brand Name" required="">
                    </div>
                </div>
                <hr class="mb-7">
                <div class="col-span-2 mb-2 text-center">
                    <button type="button" class="text-white bg-transparent hover:bg-red-700 text-sm px-5 py-2.5 rounded-lg ms-auto inline-flex justify-center items-center " data-modal-toggle="add">
                        Cancel
                        <span class="sr-only">Close modal</span>
                    </button>
                    <button type="submit" class="text-white inline-flex  justify-end items-center bg-[#EB2929] hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Add Brand
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($brands as $brand)
<div id="edit{{ $brand->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-[#272626] rounded-2xl shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-center p-1 md:p-0 rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-white mt-5">Edit Brand</h3>
            </div>
            <!-- Modal body -->
            <form class="p-2 md:p-5" action="{{ route('admin.brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <hr class="mb-3">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="dropzone-file-{{ $brand->id }}" class="flex flex-col items-center justify-center mx-auto w-32 h-32 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer bg-[#3D4142] hover:bg-gray-700">
                            <div id="file-info" class="flex flex-col items-center justify-center">
                                <img id="preview-image-{{ $brand->id }}" width="80" height="80" src="{{ asset($brand->brand_image) }}" alt="Brand Image" class="absolute opacity-40">
                                <p class="mb-2 text-xs text-gray-500 dark:text-gray-400 text-center relative"><span class="font-bold text-neutral-200 text-base z-10"><i class="fa-solid fa-pen fa-xl"></i></span></p>
                            </div>
                            <input id="dropzone-file-{{ $brand->id }}" type="file" name="brand_image" class="hidden" accept="image/*" />
                        </label>
                    </div>
                    <div class="col-span-2">
                        <label for="brand_name" class="block mb-2 text-sm font-normal text-white">Brand Name</label>
                        <input type="text" name="brand_name" id="brand_name" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" value="{{ $brand->brand_name }}" required="">
                    </div>
                </div>
                <hr class="mb-7">
                <div class="col-span-2 mb-2 text-center">
                    <button type="button" class="text-white bg-transparent hover:bg-red-700 text-sm px-5 py-2.5 rounded-lg ms-auto inline-flex justify-center items-center" data-modal-toggle="edit{{ $brand->id }}">
                        Cancel
                        <span class="sr-only">Close modal</span>
                    </button>
                    <button type="submit" class="text-white inline-flex justify-end items-center bg-[#EB2929] hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Update Brand
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<script src="{{ asset('js/previewImage.js') }}"></script>
<script src="{{ asset('js/search.js') }}"></script>
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

</script>
@endsection

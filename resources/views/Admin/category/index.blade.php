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
        <a href="#" class="bg-red-600 text-white px-4 font-medium text-base py-2 rounded-lg drop-shadow-lg" data-modal-target="add" data-modal-toggle="add">Add Category</a>
    </div>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow-lg">
    <table class="min-w-full leading-normal text-center">
        <thead>
            <tr class="bg-[#272626] text-white">
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">No</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Category Name</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Tools</th>
            </tr>
        </thead>
        <tbody id="category-table-body">
            @foreach($categories as $cat)
                <tr class="border-b border-gray-200">
                    <td class="px-5 py-5 bg-white text-sm">{{ $loop->iteration }}</td>
                    <td class="px-5 py-5 bg-white text-sm">{{ $cat->category_name }}</td>
                    <td class="px-5 py-5 bg-white text-sm flex space-x-2 items-center justify-center">
                        <a href="#" class="text-green-500 hover:text-green-700 text-base" data-modal-target="edit{{ $cat->id }}" data-modal-toggle="edit{{ $cat->id }}"><i class="fas fa-pen"></i></a>

                        <form action="{{ route('admin.category.delete', $cat->id) }}" method="POST" class="delete-form">
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
            @if ($categories->onFirstPage())
                <li><span class="px-3 py-1 bg-gray-200 rounded-lg"><i class="fa-solid fa-chevron-left "></i></span></li>
            @else
                <li><a href="{{ $categories->previousPageUrl() }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg"><i class="fa-solid fa-chevron-left "></i></a></li>
            @endif

            @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                @if ($page == $categories->currentPage())
                    <li><span class="px-3 py-1 bg-red-600 text-white rounded-lg">{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($categories->hasMorePages())
                <li><a href="{{ $categories->nextPageUrl() }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg"><i class="fa-solid fa-chevron-right "></i></a></li>
            @else
                <li><span class="px-3 py-1 bg-gray-200 rounded-lg"><i class="fa-solid fa-chevron-right "></i></span></li>
            @endif
        </ul>
    </nav>
</div>

<div id="add" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-[#272626] rounded-2xl shadow">
            <div class="flex items-center justify-center p-1 md:p-0 rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-white mt-5">Add New Category</h3>
            </div>
            <form class="p-2 md:p-5" action="{{ route('admin.category.store') }}" method="POST">
                @csrf
                <hr class="mb-3">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2 text-white font-semibold mb-3"></div>
                    <div class="col-span-2">
                        <label for="category_name" class="text-white text-sm font-semibold">Category Name</label>
                        <input type="text" name="category_name" id="category_name" placeholder="Write the name here" class="bg-[#3D4142] h-10 px-4 w-full border-none rounded-md text-white"/>
                    </div>
                </div>
                <hr class="mb-3">
                <div class="col-span-2 mb-2 text-center">
                    <button type="button" class="text-white bg-transparent hover:bg-red-700 text-sm px-5 py-2.5 rounded-lg ms-auto inline-flex justify-center items-center" data-modal-toggle="add">Cancel</button>
                    <button type="submit" class="text-white inline-flex justify-end items-center bg-[#EB2929] hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($categories as $cat)
    <div id="edit{{ $cat->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-[#272626] rounded-2xl shadow">
                <div class="flex items-center justify-center p-1 md:p-0 rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-white mt-5">Edit Category</h3>
                </div>
                <form class="p-2 md:p-5" action="{{ route('admin.category.update', $cat->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_method" value="PUT">
                    <hr class="mb-3">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="category_name" class="text-white text-sm font-semibold">Category Name</label>
                            <input type="text" name="category_name" id="category_name" value="{{ $cat->category_name }}" class="h-10 px-4 w-full border-none rounded-md text-white bg-[#3D4142]"/>
                        </div>
                    </div>
                    <hr class="mb-3">
                    <div class="col-span-2 mb-2 text-center">
                        <button type="button" class="text-white bg-transparent hover:bg-red-700 text-sm px-5 py-2.5 rounded-lg ms-auto inline-flex justify-center items-center" data-modal-toggle="edit{{ $cat->id }}">Cancel</button>
                        <button type="submit" class="text-white inline-flex justify-end items-center bg-[#EB2929] hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/search.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action cannot be undone!',
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
    });
</script>

@endsection

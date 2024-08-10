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
        <a href="{{ route('category.create')}}" class="bg-red-600 text-white flex items-center px-4 font-medium text-xs sm:text-sm md:text-base py-1 sm:py-2 rounded-lg drop-shadow-lg">Add Category</a>
    </div>
</div>
<div class="overflow-x-auto bg-white rounded-lg shadow-lg">
    <table class="min-w-full leading-normal text-center">
        <thead>
            <tr class="bg-[#272626] text-white">
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">No</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">ID</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Category Name</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Tools</th>
            </tr>
        </thead>
        <tbody id="category-table-body">
            @foreach($categories as $cat)
                <tr class="border-b border-gray-200" onclick="handleRowClick(event, '{{ route('admin.category.show', ['category_id' => $cat->category_id]) }}')">
                    <td class="px-5 py-5 bg-white text-sm">{{ $loop->iteration }}</td>
                    <td class="px-5 py-5 bg-white text-sm">{{ $cat->category_id }}</td>
                    <td class="px-5 py-5 bg-white text-sm">{{ $cat->category_name }}</td>
                    <td class="px-5 py-5 bg-white text-sm flex space-x-2 items-center justify-center">
                    <form action="{{ route('admin.category.delete', $cat->category_id) }}" method="POST" class="delete-form">
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

    function handleRowClick(event, url) {
        if (event.target.closest('.delete-form') || event.target.closest('a')) {
            event.stopPropagation();
        } else {
            window.location.href = url;
        }
    }
</script>

@endsection

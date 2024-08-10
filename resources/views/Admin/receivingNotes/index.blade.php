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
        <a href="{{ route('receivingNotes.create')}}" class="bg-red-600 text-white px-4 font-medium text-base py-2 rounded-lg drop-shadow-lg">Add Stock</a>
    </div>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow-lg">
    <table class="min-w-full leading-normal">
        <thead>
            <tr class="bg-[#272626] text-white">
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">No</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Date</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Products Name</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Brands</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Category</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Stock</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Keterangan</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Tools</th>
            </tr>
        </thead>
        <tbody class="text-center" id="stok-management-table-body">
            @foreach ($receivingNotes as $receivingNote)
            <tr class="border-b border-gray-200">
                <td class="px-5 py-5 bg-white text-sm">{{ $loop->iteration }}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ date('d-m-Y', strtotime($receivingNote->input_date)) }}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ $receivingNote->product->product_name }}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ $receivingNote->brand->brand_name }}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ $receivingNote->category->category_name }}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ $receivingNote->quantity }}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ $receivingNote->description }}</td>
                <td class="px-5 py-5 bg-white text-sm flex space-x-2 items-center justify-center">
                <form action="{{ route('receivingNotes.destroy', $receivingNote->id) }}" method="POST" class="delete-form">
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
            @if ($receivingNotes->onFirstPage())
                <li><span class="px-3 py-1 bg-gray-200 rounded-lg"> <i class="fa-solid fa-chevron-left "></i></span></li>
            @else
                <li><a href="{{ $receivingNotes->previousPageUrl() }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg"> <i class="fa-solid fa-chevron-left "></i></a></li>
            @endif

            @foreach ($receivingNotes->getUrlRange(1, $receivingNotes->lastPage()) as $page => $url)
                @if ($page == $receivingNotes->currentPage())
                    <li><span class="px-3 py-1 bg-red-600 text-white rounded-lg">{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($receivingNotes->hasMorePages())
                <li><a href="{{ $receivingNotes->nextPageUrl() }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg"> <i class="fa-solid fa-chevron-right "></i></a></li>
            @else
                <li><span class="px-3 py-1 bg-gray-200 rounded-lg"> <i class="fa-solid fa-chevron-right "></i></span></li>
            @endif
        </ul>
    </nav>
</div>

<script src="{{ asset('js/search.js') }}"></script>
<script src="{{ asset('js/previewImage.js') }}"></script>
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
<script>
    function handleRowClick(event, url) {
        if (event.target.closest('.delete-form') || event.target.closest('a')) {
            event.stopPropagation();
        } else {
            window.location.href = url;
        }
    }
</script>
@endsection

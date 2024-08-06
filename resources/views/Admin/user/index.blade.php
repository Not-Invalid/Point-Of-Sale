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
        <a href="{{route('user.create')}}" class="bg-red-600 text-white px-4 font-medium text-base py-2 rounded-lg drop-shadow-lg">Add User</a>
    </div>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow-lg">
    <table class="min-w-full leading-normal text-center">
        <thead>
            <tr class="bg-[#272626] text-white">
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">ID</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Username</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Role</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Tools</th>
            </tr>
        </thead>
        <tbody id="user-table-body">
            @foreach($users as $user)
            <tr class="border-b border-gray-200"  onclick="handleRowClick(event, '{{ route('admin.user.show', ['id' => $user->id]) }}')" >
                <td class="px-5 py-5 bg-white text-sm">{{$user->id}}</td>
                <td class="px-5 py-5 bg-white text-sm">{{$user->username}}</td>
                <td class="px-5 py-5 bg-white text-sm">{{$user->role}}</td>
                <td class="px-5 py-5  bg-white text-sm flex space-x-2 items-center justify-center">
                    <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" class="delete-form">
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
            @if ($users->onFirstPage())
                <li><span class="px-3 py-1 bg-gray-200 rounded-lg"> <i class="fa-solid fa-chevron-left "></i></span></li>
            @else
                <li><a href="{{ $users->previousPageUrl() }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg"> <i class="fa-solid fa-chevron-left "></i></a></li>
            @endif

            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                @if ($page == $users->currentPage())
                    <li><span class="px-3 py-1 bg-red-600 text-white rounded-lg">{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($users->hasMorePages())
                <li><a href="{{ $users->nextPageUrl() }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg"> <i class="fa-solid fa-chevron-right "></i></a></li>
            @else
                <li><span class="px-3 py-1 bg-gray-200 rounded-lg"> <i class="fa-solid fa-chevron-right "></i></span></li>
            @endif
        </ul>
    </nav>
</div>

<script src="{{ asset('js/search.js') }}"></script>

<!--script password-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('toggle-password').addEventListener('click', function() {
            var passwordInput = document.getElementById('password');    
            var icon = this;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    
    </script>
    
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

        function handleRowClick(event, url) {
        if (event.target.closest('.delete-form') || event.target.closest('a')) {
            event.stopPropagation();
        } else {
            window.location.href = url;
        }
    }
    </script>
    
@endsection
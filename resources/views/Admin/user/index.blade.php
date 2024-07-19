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
        <a href="#" class="bg-red-600 text-white px-4 font-medium text-base py-2 rounded-lg drop-shadow-lg" data-modal-target="add" data-modal-toggle="add">Add User</a>
    </div>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow-lg">
    <table class="min-w-full leading-normal text-center">
        <thead>
            <tr class="bg-[#272626] text-white">
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">No</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Username</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Role</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Tools</th>
            </tr>
        </thead>
        <tbody id="user-table-body">
            @foreach($users as $user)
            <tr class="border-b border-gray-200" >
                <td class="px-5 py-5 bg-white text-sm">{{$loop->iteration}}</td>
                <td class="px-5 py-5 bg-white text-sm">{{$user->username}}</td>
                <td class="px-5 py-5 bg-white text-sm">{{$user->role}}</td>
                <td class="px-5 py-5  bg-white text-sm flex space-x-2 items-center justify-center">
                    <a href="#" class="text-blue-500 hover:text-blue-700 text-lg" data-modal-target="info{{$user->id}}" data-modal-toggle="info{{$user->id}}"><i class="fas fa-info-circle"></i></a>
                    <a href="#" class="text-green-500 hover:text-green-700 text-lg" data-modal-target="edit{{$user->id}}" data-modal-toggle="edit{{$user->id}}"><i class="fas fa-pencil"></i></a>
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

  

@foreach ($users as $user)
<div id="info{{$user->id}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-[#272626] rounded-2xl shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-2 md:p-5 rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-white">
                   User detail
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="info{{$user->id}}">
                  <i class="fa-solid fa-x"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-2 md:p-5">
                <hr class="mb-3">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="dropzone-file-{{ $user->id }}" class="flex flex-col items-center justify-center mx-auto w-32 h-32 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer bg-[#3D4142] hover:bg-gray-700">
                            <div class="file-info flex flex-col items-center justify-center">
                                <img id="preview-image-info-{{ $user->id }}" width="80" height="80" src="{{ asset($user->user_image) }}" alt="User Image" class="absolute">
                            </div>
                        </label>
                    </div>
                    
                    <div class="col-span-2">
                        <label for="username" class="block mb-2 text-sm font-normal text-white">Username</label>
                        <input type="text" name="username" id="username" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" value="{{$user->username}}" readonly>
                    </div>
                    <div class="col-span-2">
                        <label for="email" class="block mb-2 text-sm font-normal text-white">Email</label>
                        <input type="email" name="email" id="email" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" value="{{$user->email}}" readonly>
                    </div>
                    <div class="col-span-2 sm:col-span-1 relative">
                        <label for="password" class="block mb-2 text-sm font-normal text-white">Password</label>
                        <input type="password" name="password" id="password-{{ $user->id }}" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" value="{{$user->password}}" readonly>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="role" class="block mb-2 text-sm font-normal text-white">Role</label>
                        <input type="text" name="role" id="role" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" value="{{$user->role}}" readonly>
                    </div>
                    <div class="col-span-2">
                        <label for="address" class="block mb-2 text-sm font-normal text-white">Address</label>
                        <textarea name="address" id="address" class="bg-[#3D4142] text-white text-sm h-30 resize-none focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" readonly>{{$user->address}}</textarea>
                    </div>
                </div>
                <hr class="my-6">
            </form>
        </div>
    </div>
</div>
@endforeach




<!--modal add-->
<div id="add" tabindex="-1"  aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-5 w-full max-w-md max-h-full">
        <div class="relative bg-[#272626]  rounded-2xl shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-2 md:p-5 rounded-t border-gray-600">
                <h3 class="text-lg font-semibold text-white">
                   Add User 
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="add">
                  <i class="fa-solid fa-x"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-2 md:p-5" action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center mx-auto w-32 h-32 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer bg-[#3D4142] hover:bg-gray-700">
                                <div id="file-info" class="flex flex-col items-center justify-center">
                                    <img id="preview-image" width="80" height="80" src="https://static-00.iconduck.com/assets.00/no-image-icon-512x512-lfoanl0w.png" alt="Uploaded Image">
                                    <p class="mb-2 text-xs text-gray-500 dark:text-gray-400"><span class="font-light">Add User Image</span></p>
                                </div>
                                <input id="dropzone-file" type="file" name="user_image" class="hidden" accept="image/*" />
                            </label>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="username" class="block mb-2 text-sm font-normal text-white">Username</label>
                            <input type="text" name="username" id="username" class="bg-[#3D4142]  text-white text-sm focus:ring-slate-400 rounded-lg  border-none block w-full p-2.5" placeholder="Username" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="Email" class="block mb-2 text-sm font-normal text-white">Email</label>
                            <input type="email" name="email" id="email" class="bg-[#3D4142]  text-white text-sm focus:ring-slate-400 rounded-lg  border-none block w-full p-2.5" placeholder="Email" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1 relative">
                            <label for="Password" class="block mb-2 text-sm font-normal text-white">Password</label>
                            <input type="password" name="password" id="password" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" placeholder="Password" required="">
                            <i id="toggle-password" class="fa fa-eye absolute right-3 top-10 cursor-pointer text-white"></i>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                          <label for="role" class="block mb-2 text-sm font-normal text-white">Role</label>
                          <select id="role" name="role" class="bg-[#3D4142]  text-white text-sm focus:ring-slate-400 rounded-lg  border-none block w-full p-2.5">
                            <option selected disabled hidden>Select Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Kasir">Kasir</option>
                        </select>
                       </div>
                       <div class="col-span-2">
                          <label for="address" class="block mb-2 text-sm font-normal text-white">Address</label>
                          <textarea name="address" id="address" class="resize-none bg-[#3D4142]  text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full  p-2.5" placeholder="Address" required=""></textarea>
                       </div>
                       <div class="col-span-2 flex justify-end">
                       <button type="submit" class="text-white  bg-[#EB2929] hover:bg-red-700 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                         Save
                      </button>
                       </div>
                      </div>
            </form>
        </div>
    </div>
</div>

<!--modal add end-->

<!--modal edit-->
@foreach($users as $user)
<div id="edit{{$user->id}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-5 w-full max-w-md max-h-full">
        <div class="relative bg-[#272626] rounded-2xl shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-2 md:p-5 rounded-t border-gray-600">
                <h3 class="text-lg font-semibold text-white">
                   Edit User 
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="edit{{$user->id}}">
                  <i class="fa-solid fa-x"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-2 md:p-5" action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <hr class="mb-3">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="dropzone-file-{{ $user->id }}" class="flex flex-col items-center justify-center mx-auto w-32 h-32 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer bg-[#3D4142] hover:bg-gray-700">
                            <div id="file-info" class="flex flex-col items-center justify-center">
                                @if($user->user_image)
                                    <img id="preview-image-{{ $user->id }}" width="80" height="80" src="{{ asset($user->user_image) }}" alt="User Image" class="absolute opacity-40">
                                @else
                                    <img id="preview-image-{{ $user->id }}" width="80" height="80" src="{{ asset('path/to/default/image.png') }}" alt="Default User Image" class="absolute opacity-40">
                                @endif
                                <p class="mb-2 text-xs text-gray-500 dark:text-gray-400 text-center relative"><span class="font-bold text-neutral-200 text-base z-10"><i class="fa-solid fa-pen fa-xl"></i></span></p>
                            </div>
                            <input id="dropzone-file-{{ $user->id }}" type="file" name="user_image" class="hidden" accept="image/*" />
                        </label>
                    </div>        
                    <div class="col-span-2 sm:col-span-1">
                        <label for="username" class="block mb-2 text-sm font-normal text-white">Username</label>
                        <input type="text" name="username" id="username" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" value="{{ $user->username }}" placeholder="Username" required>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="Email" class="block mb-2 text-sm font-normal text-white">Email</label>
                        <input type="email" name="email" id="email" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" value="{{ $user->email }}" placeholder="Email" required>
                    </div>
                    <div class="col-span-2 sm:col-span-1 relative">
                        <label for="Password" class="block mb-2 text-sm font-normal text-white">Password</label>
                        <input type="password" name="password" id="password" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" value="{{ $user->password }}" placeholder="Password" readonly>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="role" class="block mb-2 text-sm font-normal text-white">Role</label>
                        <select name="role" id="role" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5">
                            <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Kasir" {{ $user->role == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="address" class="block mb-2 text-sm font-normal text-white">Address</label>
                        <textarea name="address" id="address" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg resize-none border-none block w-full p-2.5" placeholder="Address" required>{{ $user->address }}</textarea>
                    </div>
                    <div class="col-span-2 flex justify-end">
                        <button type="submit" class="text-white bg-[#EB2929] hover:bg-red-700 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!--modal edit end-->

<script src="{{ asset('js/previewImage.js') }}"></script>
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
    </script>
    
@endsection
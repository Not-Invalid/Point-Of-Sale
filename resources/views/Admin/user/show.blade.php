@extends('layouts.master')

@section('content')
<div class="" style="margin: 50px">
    <div class="w-full h-full p-6 bg-transparent">
        <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex justify-between">
                <h1 class="text-2xl font-semibold">Edit User</h1>
                <div>
                    <a href="{{ route('admin.user.index') }}" id="backButton" class="border-2 px-3 py-2 text-sm rounded-2xl">Back</a>
                    <button type="button" id="editButton" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600">Edit</button>
                    <a href="" id="cancelButton" class="border-2 px-3 py-2 text-sm rounded-2xl hidden">Cancel</a>
                    <button type="submit" id="saveButton" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600 hidden">Save</button>
                </div>
            </div>
            <div class="mt-10 border-2 p-6 rounded-lg w-full bg-[#f9f9f9] shadow-2xl border-none">
                <div class="flex justify-center">
                    <div class="w-32 ">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                @if($user->image)
                                    <img src="{{ asset($user->image) }}" alt="User Image" id="preview-image" class="h-32 w-full object-cover rounded-lg">
                                @else
                                    <i class="fa-solid fa-image"></i>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">No Image</span></p>
                                @endif
                            </div>
                            <input id="dropzone-file" type="file" name="image" class="hidden" accept="image/*" disabled />
                        </label>
                    </div>
                </div>
                <label for="username" class="text-sm font-semibold">Username</label>
                <input type="text" name="username" id="username" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mb-4" value="{{ $user->username }}" placeholder="Username" required disabled>
                <label for="Email" class="text-sm font-semibold">Email</label>
                <input type="email" name="email" id="email" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mb-4" value="{{ $user->email }}" placeholder="Email" required disabled>
                <div class="relative">
                    <label for="Password" class="text-sm font-semibold">Password</label>
                    <input type="password" name="password" id="password" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mb-4" value="{{ $user->password }}" placeholder="Password" required disabled>
                    <i id="toggle-password" class="fa fa-eye absolute right-3 top-8 cursor-pointer"></i>
                </div>
                <label for="role" class="text-sm font-semibold">Role</label>
                <select id="role" name="role" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mb-4" required disabled>
                    <option selected disabled hidden>Select Role</option>
                    <option class="bg-white" value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option class="bg-white" value="Kasir" {{ $user->role == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                </select>
                <label for="address" class="text-sm font-semibold">Address</label>
                <textarea name="address" id="address" class="resize-none bg-gray-300 h-40 px-4 w-full border-none rounded-md p-2.5" placeholder="Address" required disabled>{{ $user->address }}</textarea>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/previewImage.js') }}"></script>
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

    document.addEventListener('DOMContentLoaded', (event) => {
        const backButton = document.getElementById('backButton');
        const editButton = document.getElementById('editButton');
        const saveButton = document.getElementById('saveButton');
        const cancelButton = document.getElementById('cancelButton');

        const formElements = [
            document.getElementById('dropzone-file'),
            document.getElementById('role')
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

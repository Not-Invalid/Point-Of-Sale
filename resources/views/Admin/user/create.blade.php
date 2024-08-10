@extends('layouts.master')

@section('content')
<div class="mt-10">
    <div class=" w-full h-full p-6 bg-transparent">
        <form  action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
        <div class="flex justify-between">
                <h1 class="text-2xl font-semibold">Add New User</h1>
                <div class="flex justify-between space-x-1">
                    <a href="{{ route ('admin.user.index')}}" class="border-2  px-3 py-2  text-sm rounded-2xl">Cancel</a>                
                    <button type="submit" class="bg-[#eb2929] px-3 py-2 text-white text-sm rounded-2xl hover:bg-red-600">Save</button>
                </div>
        </div>
            <div class="mt-10 border-2 p-6 rounded-lg w-full bg-[#f9f9f9] shadow-2xl border-none ">
                <div class="flex justify-center">
                    <div class="w-32 relative">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer object-cover overflow-hidden">
                            <img id="preview-image" class="hidden w-full h-32 absolute top-0 left-0" />
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10">
                               <i class="fa-solid fa-plus" ></i>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                            </div>
                            <input id="dropzone-file" type="file" name="image" class="hidden" accept="image/*" />
                        </label>
                    </div>    
                </div>
                <label for="username" class="text-sm font-semibold">Username</label>
                <input type="text" name="username" id="username" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mb-4" placeholder="Username" required="">
                <label for="Email" class="text-sm font-semibold">Email</label>
                <input type="email" name="email" id="email" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mb-4" placeholder="Email" required="">
                <div class="relative">
                    <label for="Password" class="text-sm font-semibold">Password</label>
                    <input type="password" name="password" id="password" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mb-4" placeholder="Password" required="">
                    <i id="toggle-password" class="fa fa-eye absolute right-3 top-8 cursor-pointer"></i>
                </div>
                <label for="role" class="text-sm font-semibold">Role</label>
                <select id="role" name="role" class="bg-gray-300 h-10 px-4 w-full border-none rounded-md mb-4">
                  <option selected disabled hidden>Select Role</option>
                  <option value="Admin">Admin</option>
                  <option value="Kasir">Kasir</option>
              </select>
              <label for="address" class="text-sm font-semibold">Address</label>
              <textarea name="address" id="address" class="resize-none bg-gray-300 h-40 px-4 w-full border-none rounded-md p-2.5" placeholder="Address" required=""></textarea>
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

    
    </script>
    
@endsection
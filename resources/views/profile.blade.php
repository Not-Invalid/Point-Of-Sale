@extends('layouts.app')

@section('content')    
<div class="flex justify-center items-center h-screen">
    <div class="bg-white p-5 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Info Profile</h2>
        <div class="flex justify-center mb-3">
            <img id="profile-picture-preview" 
                 src="{{ $user->user_image ? asset('user_image/' . $user->user_image) : 'https://via.placeholder.com/150' }}" 
                 alt="Profile Picture" 
                 class="rounded w-32 h-32 object-cover mb-4">
        </div>
        <div class="flex justify-center mb-6">
            <input type="file" id="profile-picture" class="hidden" accept="image/*" onchange="previewImage(event)">
            <button class="bg-[#eb2929] text-white py-2 px-4 rounded-md" onclick="document.getElementById('profile-picture').click()">Change picture</button>
        </div>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="username">Your username</label>
                    <input type="text" id="username" name="username" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 sm:text-sm" value="{{ $user->username }}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="email">Your email</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 sm:text-sm" value="{{ $user->email }}" required>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700" for="address">Address</label>
                <textarea id="address" name="address" rows="4" class="mt-1 block resize-none w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 sm:text-sm">{{ $user->address }}</textarea>
            </div>
            <div class="flex justify-end">
                <a href="{{ route('kasir.dashboard') }}" class="bg-transparent border-2 py-2 px-4 mx-2 rounded-md ">Cancel</a>
                <button type="submit" class="bg-blue-500 py-2 px-4 rounded-md text-white">Save</button>
            </div>
        </form>
    </div>
</div>
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profile-picture-preview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection

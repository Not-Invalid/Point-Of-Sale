@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center h-screen">
    <div class="bg-white p-5 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Info Profile</h2>
        <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex justify-center mb-8">
                <div class="w-32">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-collapse rounded-lg cursor-pointer">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            @if($user->image)
                                <img src="{{ asset($user->image) }}" alt="User Image" id="preview-image" class="h-32 w-full object-cover rounded-lg">
                            @else
                                <img id="preview-image" class="h-32 w-full object-cover rounded-lg hidden" alt="Image Preview">
                                <i id="upload-icon" class="fa-solid fa-plus"></i>
                                <p id="upload-text" class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                            @endif
                        </div>
                        <input id="dropzone-file" type="file" name="image" class="hidden" accept="image/*"/>
                    </label>
                </div>
            </div>
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
                @if($user->role == 'Kasir')
                    <a href="{{ route('kasir.dashboard') }}" class="bg-transparent border-2 py-2 px-4 mx-2 rounded-md">Cancel</a>
                @else
                    <a href="{{ route('admin.dashboard') }}" class="bg-transparent border-2 py-2 px-4 mx-2 rounded-md">Cancel</a>
                @endif
                <button type="submit" class="bg-blue-500 py-2 px-4 rounded-md text-white">Save</button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/previewImage.js') }}"></script>
@endsection

@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center h-screen">
    <div class="bg-[#F5f5f5] w-[427px] h-[360px] p-6 rounded-lg border-[0.79px] border-[#c4c4c4]">
        <div class="text-center mb-6">
            <h2 class="font-semibold text-3xl leading-10">Login</h2>
        </div>
        <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
            @csrf
            <input type="email" name="email" id="email" placeholder="Email" class="w-full p-3 border[#c4c4c4] border-[0.6px] rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-400" required>
            <div class="relative">
                <input type="password" name="password" id="password" placeholder="Password" class="w-full p-3 border[#c4c4c4] border-[0.6px] rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-400" required>
                <span class="absolute inset-y-0 right-3 flex items-center">
                    <i class="far fa-eye-slash cursor-pointer" id="togglePassword" onclick="togglePasswordVisibility('password')"></i>
                </span>
            </div>
            <button type="submit" class="w-full h-[48px] bg-[#eb2929] text-white py-[8px] px-[24px] rounded-xl hover:bg-red-500 -tracking-tighter">Login</button>
        </form>
        
    </div>
</div>
<script>
    function togglePasswordVisibility(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
</script>
@endsection

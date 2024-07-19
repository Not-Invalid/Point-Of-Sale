<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi POS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>
    <body style="font-family: Poppins" class="bg-[#F9F9F9]">
        <div class="fixed inset-y-0 left-0 w-64 bg-white text-[#9197B3] shadow-2xl flex flex-col justify-between">
            <div class="p-1">
                <div class="p-5 text-2xl font-semibold text-black"><i class="fa-solid fa-money-bill mx-3"></i>POS</div>
                <ul class="m-[10px] font-medium text-sm">
                    <a href="{{ route('kasir.dashboard') }}" class="mb-2"><li class="p-4 rounded-md hover:bg-red-600 hover:text-white"><i class="fa-solid fa-lg fa-house-chimney mx-3"></i>Dashboard</li></a>
                    <a href="{{ route ('kasir.transaction.index')}}" class="block mb-2">
                        <li class="p-4 rounded-md hover:bg-red-600 hover:text-white flex items-center justify-between">
                            <div>
                                <i class="fa-solid fa-lg fa-wallet mx-3"></i>
                                Transaction
                            </div>
                            <span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                        </li>
                    </a>   
                    <a href="{{route('profile')}}" class="block mb-2">
                        <li class="p-4 rounded-md hover:bg-red-600 hover:text-white flex items-center justify-between">
                            <div>
                                <i class="fa-solid fa-lg fa-circle-user mx-3"></i>
                                Profile
                            </div>
                            <span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                        </li>
                    </a>  
                </ul>
            </div>
            <div class="p-4 font-medium text-sm">
                <form action="{{ route('logout') }}" method="POST" class="block mb-2">
                    @csrf
                    <button type="submit" class="p-4 rounded-md hover:bg-red-600 hover:text-white flex items-center justify-between w-full">
                        <div>
                            <i class="fa-solid fa-chevron-left mx-3"></i>
                            Logout
                        </div>
                    </button>
                </form>
            </div>
        </div>
    
        <div class="ml-64 p-5 h-screen"> 
            @yield('content')
        </div>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>
</html>

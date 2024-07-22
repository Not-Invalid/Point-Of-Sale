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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head> 
    <body style="font-family: Inter" class="bg-[#F9F9F9]">
        <nav class="fixed top-0 z-30 max-sm:z-50 w-full bg-neutral-100 text-black border-b border-gray-200">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start rtl:justify-end">
                        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                            </svg>
                        </button>
                        <div class="text-2xl font-semibold text-black"><i class="fa-solid fa-money-bill mx-3"></i>POS</div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center ms-3">
                            <div>
                                <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-2 focus:ring-gray-500" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="w-8 h-8 rounded-full" src="{{ asset('default/profile.png')}}" alt="User Image">
                                </button>
                            </div>
                            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 text-black rounded shadow" id="dropdown-user">
                                <div class="px-4 py-3" role="none">
                                    <p class="text-sm text-gray-900 " role="none">
                                        {{ Auth::user()->username }}
                                    </p>
                                    <p class="text-sm font-medium text-gray-900 truncate" role="none">
                                        {{ Auth::user()->email }}
                                    </p>
                                </div>
                                <ul class="py-1" role="none">
                                    <li>
                                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 " role="menuitem">Profile</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 " role="menuitem" 
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </nav>
          
          <aside id="logo-sidebar" class="fixed top-0 left-0 z-20  max-sm:z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-neutral-100 sm:translate-x-0 border-r" aria-label="Sidebar">
            <div class="h-full px-3 pb-4 overflow-y-auto bg-neutral-100 border-r">
                <ul class="space-y-2 font-medium text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="mb-2">
                        <li class="p-4 rounded-md hover:bg-red-600 hover:text-white">
                            <i class="fa-solid fa-house-chimney mx-3"></i>Dashboard
                        </li>
                    </a>
                    <li class="p-4 rounded-md hover:bg-red-600 hover:text-white flex items-center justify-between cursor-pointer" id="master-data-toggle">
                        <div>
                            <i class="fa-solid fa-database mx-3"></i>
                            Master Data
                        </div>
                        <span>
                            <i class="fa-solid fa-chevron-right" id="master-data-icon"></i>
                        </span>
                    </li>
                    <ul class="space-y-2 ml-8 hidden" id="master-data-menu">
                        <a href="{{ route('admin.brand.index') }}" class="block mb-2">
                            <li class="p-2 rounded-md hover:bg-red-600 hover:text-white">
                                <i class="fa-solid fa-store mx-3"></i>
                                Brand
                            </li>
                        </a>
                        <a href="{{ route('admin.category.index') }}" class="block mb-2">
                            <li class="p-2 rounded-md hover:bg-red-600 hover:text-white">
                                <i class="fa-solid fa-tag mx-3"></i>
                                Category
                            </li>
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="block mb-2">
                            <li class="p-2 rounded-md hover:bg-red-600 hover:text-white">
                                <i class="fa-solid fa-box mx-3"></i>
                                Product
                            </li>
                        </a>
                    </ul>
                    <a href="{{ route('admin.transaction.index') }}" class="block mb-2">
                        <li class="p-4 rounded-md hover:bg-red-600 hover:text-white flex items-center justify-between">
                            <div>
                                <i class="fa-solid fa-wallet mx-3"></i>
                                Transaction
                            </div>
                            <span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                        </li>
                    </a>
                    <a href="{{ route('admin.user.index') }}" class="block mb-2">
                        <li class="p-4 rounded-md hover:bg-red-600 hover:text-white flex items-center justify-between">
                            <div>
                                <i class="fa-solid fa-users mx-3"></i>
                                User
                            </div>
                            <span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                        </li>
                    </a>
                    <a href="{{ route('admin.report') }}" class="block mb-2">
                        <li class="p-4 rounded-md hover:bg-red-600 hover:text-white flex items-center justify-between">
                            <div>
                                <i class="fa-solid fa-clipboard-list mx-3"></i>
                                Report
                            </div>
                            <span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                        </li>
                    </a>
                </ul>
            </div>
        </aside>
        
          
          <div class="p-4 mt-3 sm:ml-64">
             @yield('content')
          </div>
          
</div>

  
          <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/search.js') }}"></script>
        <script>
            document.getElementById('master-data-toggle').addEventListener('click', function() {
                var menu = document.getElementById('master-data-menu');
                var icon = document.getElementById('master-data-icon');
                menu.classList.toggle('hidden');
                icon.classList.toggle('fa-chevron-right');
                icon.classList.toggle('fa-chevron-down');
            });
        </script>
    </body>
</html>
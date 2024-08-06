@extends('layouts.master')

@section('content')

<div class="bg-white h-[151px] shadow-none drop-shadow-lg rounded-3xl mt-10 p-6 flex justify-center space-x-16">
    <div class="flex items-center space-x-4">
        <div class="bg-gradient-to-b from-green-200 to-green-50 rounded-full w-16 h-16 flex items-center justify-center">
            <i class="fas fa-box fa-2x text-green-500"></i>
        </div>
        <div>
            <div class="text-black font-semibold">Product Report</div>
            <a href="{{ route('product_report') }}">
                <div class="text-sm font-bold text-red-700">
                    <span><i class="fa-solid fa-download text-green-500 mx-auto"></i></span> Download
                </div>
            </a>
        </div>
    </div>

    <div class="border-r border-gray-200"></div>

    <div class="border-r border-gray-200"></div>

    <div class="flex items-center space-x-4">
        <div class="bg-gradient-to-b from-green-200 to-green-50 rounded-full w-16 h-16 flex items-center justify-center">
            <i class="fa-solid fa-dollar-sign fa-2x text-green-600"></i>
        </div>
        <div>
            <div class="text-black font-semibold"> Sales Report</div>
            <a href="{{ route('sales_report') }}">
                <div class="text-sm font-bold text-red-700">
                    <span><i class="fa-solid fa-download text-green-500 mx-auto"></i></span> Download
                </div>
            </a>
        </div>
    </div>
</div>

@endsection

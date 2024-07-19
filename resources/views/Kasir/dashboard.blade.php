@extends('layouts.sidebar')

@section('content')

<h1 class="font-medium text-2xl mt-10">Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-5">
    <!-- Card 1 -->
    <div class="bg-white rounded-xl shadow-lg p-6 ">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-gray-500 text-sm font-medium">Total Transaction</h2>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($totalTransactions) }}</p>
            </div>
            <div class="bg-purple-100 rounded-xl h-16 w-16 flex justify-center items-center">
                <i class="fa-solid fa-chart-line text-purple-600 text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-xl shadow-lg p-6 ">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-gray-500 text-sm font-medium">Total Pemasukan</h2>
                <p class="text-3xl font-bold text-gray-900">{{ formatRupiah($income)}}</p>
            </div>
            <div class="bg-yellow-100 rounded-xl h-16 w-16 flex justify-center items-center">
                <i class="fa-solid fa-dollar-sign text-yellow-600 text-3xl"></i>
            </div>
        </div>
    </div>
@endsection



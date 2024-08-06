@extends('layouts.master')

@section('content')

<style>
    canvas {
        width: 100% !important;
        height: auto !important;
    }
</style>

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

<h1 class="font-medium text-2xl">Dashboard</h1>
<div class="bg-white shadow-none drop-shadow-lg rounded-3xl mt-10 p-6 block justify-center items-center space-y-4 md:space-y-10 md:flex lg:flex lg:space-x-10">
    <div class="flex items-center space-x-8 mt-8 h-full">
        <div class="bg-gradient-to-b from-green-200 to-green-50 rounded-full w-16 h-16 flex items-center justify-center">
            <i class="fas fa-box fa-2x text-green-500"></i>
        </div>
        <div>
            <div class="text-[#272626]">Total Barang</div>
            <div class="text-2xl font-semibold text-gray-800">{{ number_format($totalProducts) }}</div>
        </div>
    </div>

    <div class="border-r border-gray-200"></div>
    <div class="flex items-center space-x-8 h-full">
        <div class="bg-gradient-to-b from-green-200 to-green-50 rounded-full w-16 h-16 flex items-center justify-center">
            <i class="fa-solid fa-chart-line fa-2x text-green-600"></i>
        </div>
        <div>
            <div class="text-[#272626]">Total Transaksi</div>
            <div class="text-2xl font-semibold text-gray-800">{{ number_format($totalTransactions) }}</div>
        </div>
    </div>

    <div class="border-r border-gray-200"></div>

    <div class="flex items-center space-x-8 h-full">
        <div class="bg-gradient-to-b from-green-200 to-green-50 rounded-full w-16 h-16 flex items-center justify-center">
            <i class="fa-solid fa-dollar-sign fa-2x text-green-600"></i>
        </div>
        <div>
            <div class="text-[#272626] font-light text-[14px]">Total Pemasukan</div>
            <div class="text-2xl font-semibold text-gray-800">{{$income}}</div>
        </div>
    </div>
</div>


{{--Chart--}}
<div class="bg-white shadow-none drop-shadow-lg rounded-xl mt-5">
    <canvas id="transactionsChart" class="w-full h-full"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('transactionsChart').getContext('2d');
        var months = {!! json_encode($months) !!}; 
        var transactionData = {!! json_encode($transactionData) !!};

        var transactionsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Transaksi per Bulan',
                    data: transactionData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    });
</script>

@endsection
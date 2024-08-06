@extends('layouts.master')
@section('content')

<div>
    <div class="flex justify-between mt-6">
        <h1 class="mt-10 text-black font-medium text-2xl py-2  drop-shadow-lg">Transaction List</h1>
        <div class="flex justify-start mb-4 mt-10">
            <input type="text" id="search" class="h-10 px-4 w-60 border rounded-md" placeholder="Search">
        </div>
    </div>
<div class="overflow-x-auto bg-white rounded-lg shadow-lg mt-2">
    <table class="min-w-full leading-normal text-center">
        <thead>
            <tr class="bg-[#272626] text-white">
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Transaction Date</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Transaction Number</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Product Name</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Brand</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Category</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Quantity</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Unit Price</th>
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Total</th>
            </tr>
        </thead>
        <tbody class="text-center" id="transactions-table-body">
            @foreach($transactions as $transaction)
            <tr class="border-b border-gray-200">
                <td class="px-5 py-5 bg-white text-sm">{{ $transaction->created_at->format('d-m-Y') }}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ $transaction->transaction_number }}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ $transaction->product_name }}</td> 
                <td class="px-5 py-5 bg-white text-sm">{{ $transaction->brand->brand_name }}</td> 
                <td class="px-5 py-5 bg-white text-sm">{{ $transaction->category->category_name }}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ $transaction->qty }}</td> 
                <td class="px-5 py-5 bg-white text-sm">{{ formatCurrency($transaction->unit_price, session('selectedCurrency', 'IDR')) }}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ formatCurrency($transaction->total, session('selectedCurrency', 'IDR')) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="flex justify-end mt-4">
    <nav aria-label="Page navigation">
        <ul class="inline-flex space-x-2">
            @if ($transactions->onFirstPage())
                <li><span class="px-3 py-1 bg-gray-200 rounded-lg"><i class="fa-solid fa-chevron-left"></i></span></li>
            @else
                <li><a href="{{ $transactions->previousPageUrl() }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg"><i class="fa-solid fa-chevron-left"></i></a></li>
            @endif

            @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                @if ($page == $transactions->currentPage())
                    <li><span class="px-3 py-1 bg-red-600 text-white rounded-lg">{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($transactions->hasMorePages())
                <li><a href="{{ $transactions->nextPageUrl() }}" class="px-3 py-1 bg-gray-200 hover:bg-red-500 rounded-lg"><i class="fa-solid fa-chevron-right"></i></a></li>
            @else
                <li><span class="px-3 py-1 bg-gray-200 rounded-lg"><i class="fa-solid fa-chevron-right"></i></span></li>
            @endif
        </ul>
    </nav>
</div>

</div>

<script src="{{ asset('js/search.js') }}"></script>
@endsection

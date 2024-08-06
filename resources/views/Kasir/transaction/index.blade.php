@extends('layouts.sidebar')

@section('content')

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

@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                confirmButtonColor: "#3085d6",
                text: '{{ session('error') }}'
            });
        });
    </script>
@endif

<div class="flex justify-between mt-8">
    <div class="flex justify-start mb-4 mt-10">
        <input type="text" id="search" class="h-10 px-4 w-60 border rounded-md" placeholder="Search">
    </div>
    <div class="flex justify-end mb-4 mt-10">
        <a href="{{route('transaction.create')}}" class="bg-red-600 text-white px-4 font-medium text-base py-2 rounded-lg drop-shadow-lg" >Add Transaction</a>
    </div>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow-lg">
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
                <th class="px-5 py-3 border-b border-gray-200 text-center text-xs font-semibold tracking-wider">Tools</th>
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
                <td class="px-5 py-5 bg-white text-sm" id="unit-price-{{ $transaction->id }}">{{ formatCurrency($transaction->unit_price, $selectedCurrency) }}</td>
                <td class="px-5 py-5 bg-white text-sm" id="total-{{ $transaction->id }}">{{ formatCurrency($transaction->total, $selectedCurrency) }}</td>
                <td class="px-5 py-5 bg-white text-sm">
                    <a href="{{ route('invoice.download', ['transaction_number' => $transaction->transaction_number]) }}"  class="text-red-500 hover:text-red-700 text-lg">
                        <i class="fa-solid fa-file-pdf"></i>
                    </a>
                </td>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/search.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
     const selectedCurrency = '{{ $selectedCurrency }}';

    function formatCurrency(amount, currencyCode) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: currencyCode
        }).format(amount);
    }

    transactions.forEach(transaction => {
        const unitPriceElement = document.getElementById(`unit-price-${transaction.id}`);
        const totalElement = document.getElementById(`total-${transaction.id}`);

        if (unitPriceElement && totalElement) {
            unitPriceElement.textContent = formatCurrency(transaction.unit_price, selectedCurrency);
            totalElement.textContent = formatCurrency(transaction.total, selectedCurrency);
        }
    }); const transactions = @json($transactions);

});

</script>

@endsection

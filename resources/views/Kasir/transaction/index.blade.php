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
        <a href="#" class="bg-red-600 text-white px-4 font-medium text-base py-2 rounded-lg drop-shadow-lg" data-modal-target="add" data-modal-toggle="add">Add Transaction</a>
    </div>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow-lg">
    <table class="min-w-full leading-normal text-center">
        <thead>
            <tr class="bg-[#272626] text-white">
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
                <td class="px-5 py-5 bg-white text-sm">{{ $transaction->transaction_number }}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ $transaction->product_name }}</td> 
                <td class="px-5 py-5 bg-white text-sm">{{ $transaction->brand->brand_name }}</td> 
                <td class="px-5 py-5 bg-white text-sm">{{ $transaction->category->category_name }}</td> 
                <td class="px-5 py-5 bg-white text-sm">{{ $transaction->qty }}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ formatRupiah($transaction->unit_price) }}</td>
                <td class="px-5 py-5 bg-white text-sm">{{ formatRupiah($transaction->total) }}</td>
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

<!--modal add-->
<!-- Modal Add -->
<div id="add" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-5 w-full max-w-md max-h-full">
        <div class="relative bg-[#272626] rounded-2xl shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-2 md:p-5 rounded-t border-gray-600">
                <h3 class="text-lg font-semibold text-white">
                   Add Transaction
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="add">
                  <i class="fa-solid fa-x"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('kasir.transaction.store') }}" method="POST" class="p-2 md:p-5">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="product_id" class="block mb-2 text-sm font-normal text-white">Product</label>
                        <select name="product_id" id="product_id" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5">
                            <option value="" disabled selected>Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-brand="{{ $product->brand->brand_name ?? '' }}" data-category="{{ $product->categories->category_name ?? '' }}" data-price="{{ $product->unit_price }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="brand" class="block mb-2 text-sm font-normal text-white">Brand</label>
                        <input type="text" name="brand" id="brand" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" readonly>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="category" class="block mb-2 text-sm font-normal text-white">Category</label>
                        <input type="text" name="category" id="category" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" readonly>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="unit_price" class="block mb-2 text-sm font-normal text-white">Unit Price</label>
                        <input type="text" name="unit_price" id="unit_price" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" readonly>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="qty" class="block mb-2 text-sm font-normal text-white">Quantity</label>
                        <input type="number" name="qty" id="qty" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" required>
                    </div>
                    <div class="col-span-2">
                        <label for="total" class="block mb-2 text-sm font-normal text-white">Total</label>
                        <input type="text" name="total" id="total" class="bg-[#3D4142] text-white text-sm focus:ring-slate-400 rounded-lg border-none block w-full p-2.5" readonly>
                    </div>
                    <div class="col-span-2 flex justify-end">
                        <button type="submit" class="text-white bg-[#EB2929] hover:bg-red-700 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/search.js') }}"></script>

<script>
    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID', { style: 'decimal', minimumFractionDigits: 0 }).format(angka);
    }

    $(document).ready(function() {
        $('#product_id').change(function() {
            var selectedOption = $(this).find('option:selected');
            var brand = selectedOption.data('brand');
            var category = selectedOption.data('category');
            var price = selectedOption.data('price');

            $('#brand').val(brand);
            $('#category').val(category);
            $('#unit_price').val(formatRupiah(price));
        });

        $('#qty').on('input', function() {
            var unitPrice = $('#unit_price').val().replace(/\D/g, '');
            var qty = $(this).val();
            var total = unitPrice * qty;
            $('#total').val(formatRupiah(total));
        });
    });
</script>
<!--modal add end-->
@endsection

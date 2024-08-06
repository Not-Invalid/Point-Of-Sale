@extends('layouts.master')

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

<div class="flex justify-center items-center">
    <div class="text-center">
        <h1 class="text-black mt-16 font-semibold text-3xl mb-4">Currency Settings</h1>
        <label for="currency" class="text-base font-medium">Select Currency</label>
        <form action="{{ route('currency.update') }}" method="POST">
            @csrf
            <div class="block mt-4">
                @php
                    $selectedCurrency = session('selectedCurrency', 'IDR');
                @endphp
                <select name="currency" id="currency-select" class="rounded w-[270px] h-10 text-center border-red-700 focus:border-red-600 focus:ring-0" onchange="this.form.submit()">
                    <option value="IDR" data-flag="{{ asset('images/flags/indonesia.png') }}" {{ $selectedCurrency == 'IDR' ? 'selected' : '' }}>IDR - Indonesian Rupiah</option>
                    <option value="USD" data-flag="{{ asset('images/flags/us.png') }}" {{ $selectedCurrency == 'USD' ? 'selected' : '' }}>USD - United States Dollar</option>
                    <option value="EUR" data-flag="{{ asset('images/flags/euro.png') }}" {{ $selectedCurrency == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                    <option value="JPY" data-flag="{{ asset('images/flags/japan.png') }}" {{ $selectedCurrency == 'JPY' ? 'selected' : '' }}>JPY - Japanese Yen</option>
                    <option value="GBP" data-flag="{{ asset('images/flags/british.png') }}" {{ $selectedCurrency == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                    <option value="AUD" data-flag="{{ asset('images/flags/australia.png') }}" {{ $selectedCurrency == 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                    <option value="CAD" data-flag="{{ asset('images/flags/canada.png') }}" {{ $selectedCurrency == 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                    <option value="CNY" data-flag="{{ asset('images/flags/china.png') }}" {{ $selectedCurrency == 'CNY' ? 'selected' : '' }}>CNY - Chinese Yuan</option>
                    <option value="MYR" data-flag="{{ asset('images/flags/malaysia.png') }}" {{ $selectedCurrency == 'MYR' ? 'selected' : '' }}>MYR - Malaysian Ringgit</option>
                    <option value="SGD" data-flag="{{ asset('images/flags/singapore.png') }}" {{ $selectedCurrency == 'SGD' ? 'selected' : '' }}>SGD - Singapore Dollar</option>
                    <option value="INR" data-flag="{{ asset('images/flags/india.png') }}" {{ $selectedCurrency == 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                </select>

                <span class="ml-4">
                    <input type="text" name="currency_example" id="currency-example" class="w-50 rounded border-red-700" disabled>
                </span>
            </div>

            <button type="submit" class="bg-red-500 text-white w-24 h-10 rounded-md mt-8">Save</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currencySelect = document.getElementById('currency-select');
        const currencyExample = document.getElementById('currency-example');

        function updateCurrencyExample() {
            const selectedOption = currencySelect.options[currencySelect.selectedIndex];
            const currencyCode = selectedOption.value;

            const exampleValue = 100000;

            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: currencyCode
            });

            currencyExample.value = formatter.format(exampleValue);

            const flag = selectedOption.getAttribute('data-flag');
            currencySelect.style.backgroundImage = `url('${flag}')`;
            currencySelect.style.backgroundSize = '25px 25px';
            currencySelect.style.backgroundRepeat = 'no-repeat';
            currencySelect.style.backgroundPosition = 'left center';
            currencySelect.style.paddingLeft = '30px';
        }

        currencySelect.addEventListener('change', updateCurrencyExample);
        updateCurrencyExample(); 
    });
</script>
@endsection

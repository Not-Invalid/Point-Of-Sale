<?php

// if (!function_exists('convertToSelectedCurrency')) {
//     function convertToSelectedCurrency($value, $exchangeRates)
//     {
//         $selectedCurrency = session('selectedCurrency', 'IDR');
//         $rate = $exchangeRates[$selectedCurrency] ?? 1;
//         return $value * $rate;
//     }
// }

if (!function_exists('formatCurrency')) {
    function formatCurrency($value, $currencyCode)
    {
        $currencySymbols = [
            'IDR' => 'Rp',
            'USD' => '$',
            'EUR' => '€',
            'JPY' => '¥',
            'GBP' => '£',
            'AUD' => 'A$',
            'CAD' => 'C$',
            'CNY' => '¥',
            'MYR' => 'RM',
            'SGD' => 'S$',
            'INR' => '₹',
        ];

        $symbol = $currencySymbols[$currencyCode] ?? '';
        return $symbol . ' ' . number_format($value, 2);
    }
}

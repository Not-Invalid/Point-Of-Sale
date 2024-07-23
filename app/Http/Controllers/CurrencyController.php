<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    public function index()
    {
        $selectedCurrency = session('selectedCurrency', 'IDR');
        $exchangeRates = $this->getExchangeRates();

        return view('admin.currency.index', [
            'selectedCurrency' => $selectedCurrency,
            'exchangeRates' => $exchangeRates
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'currency' => 'required|string'
        ]);

        $selectedCurrency = $request->input('currency');
        session(['selectedCurrency' => $selectedCurrency]);

        $exchangeRates = $this->getExchangeRates();
        session(['exchangeRates' => $exchangeRates]);

        return redirect()->route('admin.currency.index')->with('success', 'Currency updated successfully.');
    }

    private function getExchangeRates()
    {
        try {
            $response = Http::get('https://api.exchangerate-api.com/v4/latest/IDR');
            $data = $response->json();

            if (!isset($data['rates'])) {
                throw new \Exception('Rates key not found in API response.');
            }

            return $data['rates'];
        } catch (\Exception $e) {

            \Log::error('Error fetching exchange rates:', ['error' => $e->getMessage()]);
            return [];
        }
    }
}
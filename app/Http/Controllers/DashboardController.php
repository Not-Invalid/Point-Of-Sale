<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function indexAdmin()
    {

        $user = Auth::user(); 
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $totalIncome = Transaction::sum('total');

        $currency = session('selectedCurrency', 'IDR');

        // $exchangeRates = session('exchangeRates', []);
        // $rate = $exchangeRates[$selectedCurrency] ?? 1;

        // $formattedIncome = $totalIncome * $rate;

        $income = formatCurrency($totalIncome, $currency);

        $months = [];
        $transactionData = [];

        $transactionsPerMonth = Transaction::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as data_count')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        foreach ($transactionsPerMonth as $transaction) {
            $monthName = date('F', mktime(0, 0, 0, $transaction->month, 1));
            $months[] = $monthName;
            $transactionData[] = $transaction->data_count;
        }

        return view('admin.dashboard', compact('totalProducts', 'totalTransactions', 'income', 'months', 'transactionData', 'currency', 'user'));
    }

    public function indexKasir()
    {
        $totalTransactions = Transaction::count();
        $totalIncome = Transaction::sum('total');

        $currency = session('selectedCurrency', 'IDR');

        // $exchangeRates = session('exchangeRates', []);
        // $rate = $exchangeRates[$selectedCurrency] ?? 1;

        // $formattedIncome = $totalIncome * $rate;

        $income = formatCurrency($totalIncome, $currency);

        return view('kasir.dashboard', compact('totalTransactions', 'income', 'currency'));
    }
}
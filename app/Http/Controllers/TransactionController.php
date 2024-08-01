<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Currency;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::all();
        $currencySetting = Currency::first();
        $selectedCurrency = $currencySetting ? $currencySetting->currency_code : 'IDR';
        // $exchangeRates = $request->session()->get('exchangeRates', []);
        
        // $rate = $exchangeRates[$currency] ?? 1;

        $transactions = Transaction::orderBy('created_at', 'DESC');

        if ($request->has('search')) {
            $search = $request->query('search');
            $transactions->where('transaction_number', 'like', '%' . $search . '%')->orWhere('product_name', 'like', '%' . $search . '%');
        }

        $transactions = $transactions->paginate(10);
        $products = Product::all();

        // foreach ($transactions as $transaction) {
        //     $transaction->unit_price = $transaction->unit_price * $rate;
        //     $transaction->total = $transaction->total * $rate;
        // }

        return view('kasir.transaction.index', compact('transactions', 'products', 'selectedCurrency'));
    }

    public function indexAdmin(Request $request)
    {
        $currency = session('selectedCurrency', 'IDR');
        // $exchangeRates = session('exchangeRates', []);
        
        // $rate = $exchangeRates[$currency] ?? 1;

        $transactions = Transaction::orderBy('created_at', 'DESC')->paginate(10);
        if ($request->has('search')) {
            $search = $request->query('search');
            $transactions->where('transaction_number', 'like', '%' . $search . '%')->orWhere('product_name', 'like', '%' . $search . '%');
        }
        $products = Product::all();

        // foreach ($transactions as $transaction) {
        //     $transaction->unit_price = $transaction->unit_price * $rate;
        //     $transaction->total = $transaction->total * $rate;
        // }

        return view('admin.transaction.index', compact('transactions', 'products', 'currency'));
    }

    public function add()
    {
        $products = Product::all();
        $transactions = Transaction::orderBy('created_at', 'DESC')->paginate(10);
        return view('kasir.transaction.create', compact('products', 'transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'qty' => 'required|integer|min:1',
        ]);

        $products = Product::find($request->product_id);

        if ($request->qty > $products->stock) {
            return redirect()->route('transaction.create')
                                ->with('error', 'Quantity is more than stock.');
        }

        $currency = session('selectedCurrency', 'IDR');
        // $exchangeRates = session('exchangeRates', []);
        // $rate = $exchangeRates[$currency] ?? 1;


        $today = date('d/m/Y');

        $todayTransactionCount = Transaction::whereDate('created_at', now()->format('Y-m-d'))->count();
        $transactionNumberSuffix = $todayTransactionCount + 1;

        $transactionNumber = 'TRA/' . $today . '/' . $transactionNumberSuffix;

        $transaction = new Transaction();
        $transaction->transaction_number = $transactionNumber;
        $transaction->product_name = $products->product_name;
        $transaction->unit_price = $products->unit_price;
        $transaction->id_brand = $products->id_brand;
        $transaction->id_category = $products->id_category;
        $transaction->qty = $request->qty;
        $transaction->total = $transaction->unit_price * $transaction->qty;

        $transaction->save();

        $products->stock -= $request->qty;
        $products->save();

        return redirect()->route('kasir.transaction.index')->with('success', 'Transaction added successfully.');
    }
}

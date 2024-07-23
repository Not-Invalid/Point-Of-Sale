<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $currency = $request->session()->get('selectedCurrency', 'IDR');
        $exchangeRates = $request->session()->get('exchangeRates', []);
        
        $rate = $exchangeRates[$currency] ?? 1;

        $transactions = Transaction::orderBy('created_at', 'DESC');

        if ($request->has('search')) {
            $search = $request->query('search');
            $transactions->where('transaction_number', 'like', '%' . $search . '%');
        }

        $transactions = $transactions->paginate(10);
        $products = Product::all();

        foreach ($transactions as $transaction) {
            $transaction->unit_price = $transaction->unit_price * $rate;
            $transaction->total = $transaction->total * $rate;
        }

        return view('kasir.transaction.index', compact('transactions', 'products', 'currency'));
    }

    public function indexAdmin()
    {
        $currency = session('selectedCurrency', 'IDR');
        $exchangeRates = session('exchangeRates', []);
        
        $rate = $exchangeRates[$currency] ?? 1;

        $transactions = Transaction::orderBy('created_at', 'DESC')->paginate(10);
        $products = Product::all();

        foreach ($transactions as $transaction) {
            $transaction->unit_price = $transaction->unit_price * $rate;
            $transaction->total = $transaction->total * $rate;
        }

        return view('admin.transaction.index', compact('transactions', 'products', 'currency'));
    }

    public function add()
    {
        $products = Product::all();
        $transactions = Transaction::orderBy('created_at', 'DESC')->paginate(10);
        return view('kasir.transaction.index', compact('products', 'transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);

        if ($request->qty > $product->stock) {
            return redirect()->route('kasir.transaction.add')
                                ->with('error', 'Quantity is more than stock.');
        }

        $currency = session('selectedCurrency', 'IDR');
        $exchangeRates = session('exchangeRates', []);
        $rate = $exchangeRates[$currency] ?? 1;

        $transaction = new Transaction();
        $transaction->transaction_number = 'TRX-' . uniqid();
        $transaction->product_name = $product->product_name;
        $transaction->unit_price = $product->unit_price * $rate;
        $transaction->id_brand = $product->id_brand;
        $transaction->id_category = $product->id_category;
        $transaction->qty = $request->qty;
        $transaction->total = $transaction->unit_price * $transaction->qty;

        $transaction->save();

        $product->stock -= $request->qty;
        $product->save();

        return redirect()->route('kasir.transaction.index')->with('success', 'Transaction added successfully.');
    }
}

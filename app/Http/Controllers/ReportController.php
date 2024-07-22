<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Brand;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function downloadSalesReport()
{
    $transactions = Transaction::all();
    $brand = Brand::all();
    $categories = Category::all();

    $totalQty = $transactions->sum('qty');

    $data = [
        'title' => 'Laporan Penjualan',
        'date' => date('m/d/Y'),
        'transactions' => $transactions,
        'totalQty' => $totalQty
    ];

    $pdf = PDF::loadView('pdf.sales_report', $data);
    return $pdf->stream('sales_report.pdf');
}

    public function downloadIncomeReport()
    {
        $transactions = Transaction::all();

        $totalIncome = $transactions->sum('total');

        $data = [
            'title' => 'Laporan Pemasukan',
            'date' => date('m/d/Y'),
            'transactions' => $transactions,
            'totalIncome' => $totalIncome
        ];

        $pdf = PDF::loadView('pdf.income_report', $data);

        return $pdf->stream('income_report.pdf');
    }

    public function invoice(Request $request)
    {
        $transactionNumber = $request->query('transaction_number');

        $transaction = Transaction::where('transaction_number', $transactionNumber)->first();

        if (!$transaction) {
            return redirect()->back()->with('error', 'Transaction not found');
        }

        $invoiceData = [
            'invoiceId' => 'INV' . str_pad($transaction->id, 6, 'Crg000', STR_PAD_LEFT),
            'transactionDate' => $transaction->created_at->format('d-m-Y'),
            'productName' => $transaction->product_name,
            'quantity' => $transaction->qty,
            'unitPrice' => $transaction->unit_price,
            'total' => $transaction->total
        ];

        $pdf = PDF::loadView('pdf.invoice', compact('invoiceData'));

        return $pdf->stream('invoice.pdf');
    }


}

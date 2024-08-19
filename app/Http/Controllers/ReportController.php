<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\ReceivingNotes;
use App\Models\Brand;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function ProductReport()
{
    $transactions = Transaction::all();
    $brand = Brand::all();
    $categories = Category::all();

    $totalQty = $transactions->sum('qty');

    $data = [
        'title' => 'Product Report',
        'date' => date('m/d/Y'),
        'transactions' => $transactions,
        'totalQty' => $totalQty
    ];

    $pdf = PDF::loadView('pdf.product_report', $data)->setPaper('A4');
    return $pdf->stream('product_report.pdf');
}

    public function salesReport(Request $request)
    {
        $currency = $request->session()->get('selectedCurrency', 'IDR');

        $transactions = Transaction::all();
        $brand = Brand::all();
        $categories = Category::all();

        $totalIncome = $transactions->sum('total');

        $data = [
            'title' => 'Sales Report',
            'date' => date('m/d/Y'),
            'transactions' => $transactions,
            'totalIncome' => $totalIncome
        ];

        $pdf = PDF::loadView('pdf.sales_report', $data)->setPaper('A4');

        return $pdf->stream('sales_report.pdf');
    }

    public function invoice(Request $request)
    {
        $currency = $request->session()->get('selectedCurrency', 'IDR');


        $products = Product::all();
        $transactionNumber = $request->query('transaction_number');

        $transaction = Transaction::where('transaction_number', $transactionNumber)->first();

        if (!$transaction) {
            return redirect()->back()->with('error', 'Transaction not found');
        }

        $transactionParts = explode('/', $transactionNumber);
        $datePart = $transactionParts[1] . '/' . $transactionParts[2] . '/' . $transactionParts[3];
        $transactionNumberPart = $transactionParts[4];

        $invoiceNumber = 'INV/' . $datePart . '/' . $transactionNumberPart;

        $invoiceData = [
            'invoiceId' => $invoiceNumber,
            'transactionDate' => $transaction->created_at->format('d-m-Y'),
            'productName' => $transaction->product_name,
            'quantity' => $transaction->qty,
            'unitPrice' => $transaction->unit_price, session('selectedCurrency', 'IDR'),
            'total' => $transaction->total, session('selectedCurrency', 'IDR'),
            'id_brand' => $transaction->brand->brand_name,
            'id_category' => $transaction->category->category_name
        ];
        

        $pdf = PDF::loadView('pdf.invoice', compact('invoiceData'))->setPaper('A4');

        return $pdf->stream('invoice.pdf');
    }

    public function receivingNotes($id)
    {
        $receivingNotes = ReceivingNotes::where('id', $id)->get(); 

        $data = [
            'receivingNotes' => $receivingNotes,
        ];

        $pdf = Pdf::loadView('pdf.receiving_notes', $data);
        return $pdf->stream('receiving_note.pdf');
    }    

}

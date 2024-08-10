<?php

namespace App\Http\Controllers;

use App\Models\ReceivingNotes;
use App\Models\Product;
use Illuminate\Http\Request;

class ReceivingNotesController extends Controller 
{
    public function index(Request $request)
    {
        $receivingNotes = ReceivingNotes::orderBy('id', 'DESC')->paginate(10); 
        if ($request->has('search')) {
            $search = $request->query('search');
            $receivingNotes->where('input_date', 'like', '%' . $search . '%'); 
        }
        return view('admin.receivingNotes.index', compact('receivingNotes')); 
    }

    public function add()
    {
        $products = Product::all();
        return view('admin.receivingNotes.create', compact('products')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'input_date' => 'required|date',
            'product_id' => 'required|string|exists:products,product_id',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        $receivingNote = new ReceivingNotes([ 
            'input_date' => $request->input_date,
            'product_id' => $request->product_id,
            'id_brand' => $product->id_brand,
            'id_category' => $product->id_category,
            'quantity' => $request->quantity,
            'description' => $request->description,
        ]);
        $receivingNote->save(); 

        $product->stock += $request->quantity;
        $product->save();

        return redirect()->route('admin.receivingNotes.index')->with('success', 'Receiving note added successfully'); 
    }

    public function destroy($id)
    {
        $receivingNote = ReceivingNotes::findOrFail($id); 
        $product = Product::findOrFail($receivingNote->product_id); 
        $product->stock -= $receivingNote->quantity; 
        $product->save();

        $receivingNote->delete(); 

        return redirect()->route('admin.receivingNotes.index')->with('success', 'Receiving note deleted successfully'); 
    }
}
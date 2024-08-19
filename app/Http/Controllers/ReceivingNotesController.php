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
            'receiver' => 'nullable|string',
            'input_date' => 'required|date',
            'products' => 'required|array',
            'products.*' => 'required|string|exists:products,product_id',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:1',
            'description' => 'required|array',
            'description.*' => 'nullable|string',
            'references' => 'nullable|string',
        ]);
    
        foreach ($request->products as $index => $product_id) {
            $product = Product::findOrFail($product_id);
    
            $quantity = $request->quantity[$index];
            $description = $request->description[$index];
    
            $receivingNote = new ReceivingNotes([ 
                'receiver' => $request->receiver,
                'input_date' => $request->input_date,
                'product_id' => $product_id,
                'id_brand' => $product->id_brand,
                'id_category' => $product->id_category,
                'quantity' => $quantity,
                'description' => $description,
                'references' => $request->references,
            ]);
            $receivingNote->save(); 
    
            $product->stock += $quantity;
            $product->save();
        }
    
        return redirect()->route('admin.receivingNotes.index')->with('success', 'Receiving notes added successfully');
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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $selectedCurrency = session('selectedCurrency', 'IDR');
        $exchangeRates = session('exchangeRates', []);
        
        $products = Product::with('brand', 'categories')->orderBy('id', 'DESC')->paginate(10);
        $brands = Brand::all();
        $categories = Category::all();
        
        if ($request->has('search')) {
            $search = $request->query('search');
            $products->where('product_name', 'like', '%' . $search . '%');
        }

        return view('admin.products.index', compact('products', 'brands', 'categories', 'selectedCurrency', 'exchangeRates'));
    }

    public function show($id)
    {
        $selectedCurrency = session('selectedCurrency', 'IDR');
        $exchangeRates = session('exchangeRates', []);

        $product = Product::with(['brand', 'categories'])->find($id);

        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Product not found.');
        }

        return view('admin.products.detail', compact('product', 'selectedCurrency', 'exchangeRates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|unique:products,product_name',
            'desc_product' => 'required',
            'stock' => 'required|integer',
            'unit_price' => 'required|numeric',
            'id_brand' => 'required|exists:brand,id',
            'id_category' => 'required|exists:categories,id',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $product = new Product;
        $product->product_name = $request->product_name;
        $product->desc_product = $request->desc_product;
        $product->stock = $request->stock;
        $product->unit_price = $request->unit_price;
        $product->id_brand = $request->id_brand;
        $product->id_category = $request->id_category;

        if($request->hasFile('product_image')){
            $imageName = time().'.'.$request->product_image->extension();  
            $request->product_image->move(public_path('products'), $imageName);
            $product->product_image = 'products/'.$imageName;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|unique:products,product_name,'.$id,
            'desc_product' => 'required',
            'stock' => 'required|integer',
            'unit_price' => 'required|numeric',
            'id_brand' => 'required|exists:brand,id',
            'id_category' => 'required|exists:categories,id',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $product = Product::find($id);
        $product->product_name = $request->product_name;
        $product->desc_product = $request->desc_product;
        $product->stock = $request->stock;
        $product->unit_price = $request->unit_price;
        $product->id_brand = $request->id_brand;
        $product->id_category = $request->id_category;

        if($request->hasFile('product_image')){
            $imageName = time().'.'.$request->product_image->extension();  
            $request->product_image->move(public_path('images'), $imageName);
            $product->product_image = 'images/'.$imageName;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product->product_image && file_exists(public_path($product->product_image))) {
            unlink(public_path($product->product_image));
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}

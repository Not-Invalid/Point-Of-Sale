<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $currency = $request->session()->get('selectedCurrency', 'IDR');
        // $selectedCurrency = session('selectedCurrency', 'IDR');
        // $exchangeRates = session('exchangeRates', []);
        
        $products = Product::with('brand', 'categories')->orderBy('product_id', 'DESC')->paginate(10);
        $brands = Brand::all();
        $categories = Category::all();
        
        if ($request->has('search')) {
            $search = $request->query('search');
            $products->where('product_id', 'like', '%' . $search . '%')->orWhere('product_name', 'like', '%' . $search . '%');
        }

        return view('admin.products.index', compact('products', 'brands', 'categories', 'currency'));
    }

    public function show(Request $request, $product_id)
    {
        // $selectedCurrency = session('selectedCurrency', 'IDR');
        // $exchangeRates = session('exchangeRates', []);

        $product = Product::with(['brand', 'categories'])->find($product_id);
        $brands = Brand::all();
        $categories = Category::all();
        $currency = $request->session()->get('selectedCurrency', 'IDR');
        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Product not found.');
        }

        return view('admin.products.show', compact('product', 'currency', 'brands', 'categories'));
    }

    public function add()
    {
        $product = Product::with(['brand', 'categories']);
        $brands = Brand::all();
        $categories = Category::all();
        return view('admin.products.create', compact('product', 'brands', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|unique:products,product_name',
            'desc_product' => 'required',
            'stock' => 'required|integer',
            'unit_price' => 'required|numeric',
            'id_brand' => 'required|exists:brand,brand_id',
            'id_category' => 'required|exists:categories,category_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $lastProduct = Product::orderBy('product_id', 'DESC')->first();
        if ($lastProduct) {
            $lastId = intval(substr($lastProduct->product_id, 4));
            $newId = 'PRO-' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newId = 'PRO-001';
        }


        $product = new Product;
        $product->product_id = $newId;
        $product->product_name = $request->product_name;
        $product->desc_product = $request->desc_product;
        $product->stock = $request->stock;
        $product->unit_price = $request->unit_price;
        $product->id_brand = $request->id_brand;
        $product->id_category = $request->id_category;

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('products'), $imageName);
            $product->product_image = 'products/' . $imageName;
        }


        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
    }

    public function update(Request $request, $product_id)
    {
        $request->validate([
            'product_name' => 'required|unique:products,product_name,' . $product_id . ',product_id',
            'desc_product' => 'required',
            'unit_price' => 'required|numeric',
            'id_brand' => 'required|exists:brand,brand_id',
            'id_category' => 'required|exists:categories,category_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $product = Product::where('product_id', $product_id)->firstOrFail();
        $product->product_name = $request->product_name;
        $product->desc_product = $request->desc_product;
        $product->unit_price = $request->unit_price;
        $product->id_brand = $request->id_brand;
        $product->id_category = $request->id_category;

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('products'), $imageName);
            $product->product_image = 'products/' . $imageName;
        }
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }


    public function destroy($product_id)
    {
        $product = Product::find($product_id);
        if ($product->product_image && file_exists(public_path($product->product_image))) {
            unlink(public_path($product->product_image));
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}

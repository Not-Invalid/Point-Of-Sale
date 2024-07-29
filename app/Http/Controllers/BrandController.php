<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Pagination\Paginator;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::orderBy('brand_id', 'DESC')->paginate(10);
        if ($request->has('search')) {
            $search = $request->query('search');
            $brands->where('brand_name', 'like', '%' . $search . '%');
        }
        return view('admin.brand.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|unique:brand,brand_name',
            'brand_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $lastBrand = Brand::orderBy('brand_id', 'desc')->first();
        if ($lastBrand) {
            $lastIdNumber = (int) substr($lastBrand->brand_id, 4); 
            $newIdNumber = $lastIdNumber + 1;
        } else {
            $newIdNumber = 1; 
        }
        $newId = 'BRA-' . str_pad($newIdNumber, 3, '0', STR_PAD_LEFT);

        $brand = new Brand();
        $brand->brand_id = $newId; 
        $brand->brand_name = $request->brand_name;

        if ($request->hasFile('brand_image')) {
            $image = $request->file('brand_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('brands'), $imageName);
            $brand->brand_image = 'brands/' . $imageName;
        }

        $brand->save();

        return redirect()->route('admin.brand.index')->with('success', 'Brand added successfully');
    }

    public function edit($brand_id)
    {
        $brands = Brand::orderBy('brand_id', 'DESC')->get();
        $brand = Brand::where('brand_id', $brand_id)->firstOrFail();
        return view('admin.brand.index', compact('brands', 'brand'));
    }

    public function update(Request $request, $brand_id)
    {
        $request->validate([
            'brand_name' => 'required',
            'brand_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brand = Brand::where('brand_id', $brand_id)->firstOrFail();
        $brand->brand_name = $request->brand_name;

        if ($request->hasFile('brand_image')) {
            $image = $request->file('brand_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('brands'), $imageName);
            $brand->brand_image = 'brands/' . $imageName;
        }

        $brand->save();

        return redirect()->route('admin.brand.index')->with('success', 'Brand updated successfully');
    }

    public function destroy($brand_id)
    {
        $brand = Brand::findOrFail($brand_id);
        $brand->delete();

        return redirect()->route('admin.brand.index')->with('success', 'Brand deleted successfully');
    }
}
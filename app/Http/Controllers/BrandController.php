<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Brand;
use Illuminate\Pagination\Paginator;

class BrandController extends Controller
{
    public function index(Request $request)
{
    $brands = Brand::orderBy('id', 'DESC')->paginate(10);
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
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brand = new Brand();
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

    public function edit($id)
    {
        $brands = Brand::orderBy('id', 'DESC')->get();
        $brand = Brand::findOrFail($id);
        return view('admin.brand.index', compact('brands', 'brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'brand_name' => 'required',
            'brand_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brand = Brand::findOrFail($id);
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

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->route('admin.brand.index')->with('success', 'Category deleted successfully');
    }
}

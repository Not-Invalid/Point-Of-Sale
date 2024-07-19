<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('id', 'DESC');

        if ($request->has('search')) {
            $search = $request->query('search');
            $categories->where('category_name', 'like', '%' . $search . '%');
        }

        $categories = $categories->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);
    
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->save();
    
        return redirect()->route('admin.category.index')->with('success', 'Category added successfully');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('admin.category.index', compact('categories', 'category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        $category = Category::findOrFail($id);
        $category->category_name = $request->category_name;
        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully');
    }
}

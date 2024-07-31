<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('category_id', 'DESC');

        if ($request->has('search')) {
            $search = $request->query('search');
            $categories->where('category_id', 'like', '%' . $search . '%') ->orWhere('category_name', 'like', '%' . $search . '%');
        }

        $categories = $categories->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function show(Request $request, $category_id)
    {
        $categories = Category::all()->find($category_id);
        if (!$categories) {
            return redirect()->route('admin.category.index')->with('error', 'Category not found.');
        }

        return view('admin.category.show', compact('categories'));
    }

    public function add()
    {
        $categories = Category::all();
        return view('admin.category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        $lastCategory = Category::orderBy('category_id', 'DESC')->first();
        if ($lastCategory) {
            $lastId = intval(substr($lastCategory->category_id, 4));
            $newId = 'CAT-' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newId = 'CAT-001';
        }

        $category = new Category();
        $category->category_id = $newId;
        $category->category_name = $request->category_name;
        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'Category added successfully');
    }

    public function edit($category_id)
    {
        $category = Category::findOrFail($category_id);
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('admin.category.index', compact('categories', 'category'));
    }

    public function update(Request $request, $category_id)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        $category = Category::findOrFail($category_id);
        $category->category_name = $request->category_name;
        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully');
    }

    public function destroy($category_id)
    {
        $category = Category::findOrFail($category_id);
        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully');
    }
}

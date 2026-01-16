<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,category_id',
            'is_active' => 'sometimes|boolean',
        ]);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        \App\Models\Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(\App\Models\Category $category)
    {
        $categories = \App\Models\Category::where('category_id','<>',$category->category_id)->get();
        return view('admin.categories.edit', compact('category','categories'));
    }

    public function update(Request $request, \App\Models\Category $category)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,category_id',
            'is_active' => 'sometimes|boolean',
        ]);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(\App\Models\Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }
}

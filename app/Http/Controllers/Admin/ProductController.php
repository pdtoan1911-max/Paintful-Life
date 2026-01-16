<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::with('category');

        if ($search = request()->get('q')) {
            $products->where(function ($query) use ($search) {
                $query->where('product_name', 'like', '%' . $search . '%');
            });
        }

        if ($brand = request()->get('brand')) {
            $products->where('brand_id', $brand);
        }

        $products = $products->paginate(10);

        $brands = \App\Models\Brand::all();
        return view('admin.products.index', compact('products', 'brands'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        $brands = \App\Models\Brand::all();
        return view('admin.products.form', compact('categories','brands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'brand_id' => 'nullable|exists:brands,brand_id',
            'category_id' => 'nullable|exists:categories,category_id',
            'product_code' => 'nullable|string|max:255',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'paint_base' => 'nullable|string|max:255',
            'finish_type' => 'nullable|string|max:255',
            'volume' => 'nullable|numeric|max:255',
            'coverage_area' => 'nullable|numeric|max:255',
            'cost_price' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'stock_quantity' => 'nullable|integer',
            'low_stock_alert' => 'nullable|integer',
            'rating_avg' => 'nullable|numeric',
            'total_sold' => 'nullable|integer',
            'is_featured' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'image' => 'nullable|file|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/products'), $filename);
            $data['image_url'] = 'images/products/' . $filename;
        }

        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        \App\Models\Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(\App\Models\Product $product)
    {
        $categories = \App\Models\Category::all();
        $brands = \App\Models\Brand::all();
        return view('admin.products.form', compact('product', 'categories','brands'));
    }

    public function update(Request $request, \App\Models\Product $product)
    {
        $data = $request->validate([
            'brand_id' => 'nullable|exists:brands,brand_id',
            'category_id' => 'nullable|exists:categories,category_id',
            'product_code' => 'nullable|string|max:255',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'paint_base' => 'nullable|string|max:255',
            'finish_type' => 'nullable|string|max:255',
            'volume' => 'nullable|string|max:255',
            'coverage_area' => 'nullable|string|max:255',
            'cost_price' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'stock_quantity' => 'nullable|integer',
            'low_stock_alert' => 'nullable|integer',
            'rating_avg' => 'nullable|numeric',
            'total_sold' => 'nullable|integer',
            'is_featured' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'image' => 'nullable|file|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_url && file_exists(public_path($product->image_url))) {
                @unlink(public_path($product->image_url));
            }
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/products'), $filename);
            $data['image_url'] = 'images/products/' . $filename;
        }

        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(\App\Models\Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}

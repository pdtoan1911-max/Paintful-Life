<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', 1);

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', 1)->get();

        // Suggested / featured products for lower suggestion section
        $suggested = Product::where('is_active',1)->where('is_featured',1)->take(8)->get();

        return view('products.index', compact('products', 'categories', 'suggested'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $related = Product::where('category_id', $product->category_id)->where('product_id', '<>', $product->product_id)->take(6)->get();

        return view('products.show', compact('product', 'related'));
    }
}

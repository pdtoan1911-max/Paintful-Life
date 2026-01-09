<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_active', 1)->where('is_featured', 1)->take(4)->get();

        return view('home', compact('featuredProducts'));
    }
}

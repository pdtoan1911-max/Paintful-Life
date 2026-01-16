<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = \App\Models\Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'brand_name' => 'required|string|max:255',
            'country_origin' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
            'logo' => 'nullable|file|image|max:5120',
        ]);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/brands'), $filename);
            $data['logo_url'] = 'images/brands/' . $filename;
        }
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        \App\Models\Brand::create($data);
        return redirect()->route('admin.brands.index')->with('success', 'Brand created.');
    }

    public function edit(\App\Models\Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, \App\Models\Brand $brand)
    {
        $data = $request->validate([
            'brand_name' => 'required|string|max:255',
            'country_origin' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
            'logo' => 'nullable|file|image|max:5120',
        ]);
        if ($request->hasFile('logo')) {
            if ($brand->logo_url && file_exists(public_path($brand->logo_url))) {
                @unlink(public_path($brand->logo_url));
            }
            $file = $request->file('logo');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/brands'), $filename);
            $data['logo_url'] = 'images/brands/' . $filename;
        }
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $brand->update($data);
        return redirect()->route('admin.brands.index')->with('success', 'Brand updated.');
    }

    public function destroy(\App\Models\Brand $brand)
    {
        if ($brand->logo_url && file_exists(public_path($brand->logo_url))) {
            @unlink(public_path($brand->logo_url));
        }
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted.');
    }
}

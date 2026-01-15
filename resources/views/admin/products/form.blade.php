@extends('admin.layout')

@php
  $isEdit = isset($product);
@endphp

@section('title', $isEdit ? 'Edit Product' : 'Create Product')

@section('content')
  <form action="{{ $isEdit ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
      @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Left: Basic Info -->
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Product Code</label>
          <input name="product_code" value="{{ old('product_code', $isEdit ? $product->product_code : '') }}" class="w-full mt-1 p-2 border rounded">
          @error('product_code') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Name</label>
          <input name="product_name" value="{{ old('product_name', $isEdit ? $product->product_name : '') }}" class="w-full mt-1 p-2 border rounded" required>
          @error('product_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Category</label>
          <select name="category_id" class="w-full mt-1 p-2 border rounded">
            <option value="">Select category</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->category_id }}" {{ old('category_id', $isEdit ? $product->category_id : '') == $cat->category_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
            @endforeach
          </select>
          @error('category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Brand</label>
          <select name="brand_id" class="w-full mt-1 p-2 border rounded">
            <option value="">Select brand</option>
            @isset($brands)
              @foreach($brands as $b)
                <option value="{{ $b->brand_id }}" {{ old('brand_id', $isEdit ? $product->brand_id : '') == $b->brand_id ? 'selected' : '' }}>{{ $b->brand_name }}</option>
              @endforeach
            @endisset
          </select>
          @error('brand_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Price</label>
          <input type="number" step="0.01" name="price" value="{{ old('price', $isEdit ? $product->price : '') }}" class="w-full mt-1 p-2 border rounded">
          @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Cost Price</label>
          <input type="number" step="0.01" name="cost_price" value="{{ old('cost_price', $isEdit ? $product->cost_price : '') }}" class="w-full mt-1 p-2 border rounded">
          @error('cost_price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Paint base</label>
          <input type="text" step="0.01" name="paint_base" value="{{ old('paint_base', $isEdit ? $product->paint_base : '') }}" class="w-full mt-1 p-2 border rounded">
          @error('paint_base') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Finish type</label>
          <input type="text" step="0.01" name="finish_type" value="{{ old('finish_type', $isEdit ? $product->finish_type : '') }}" class="w-full mt-1 p-2 border rounded">
          @error('finish_type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <!-- Right: Details -->
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Volume</label>
          <input name="volume" value="{{ old('volume', $isEdit ? $product->volume : '') }}" class="w-full mt-1 p-2 border rounded">
          @error('volume') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Coverage Area</label>
          <input name="coverage_area" value="{{ old('coverage_area', $isEdit ? $product->coverage_area : '') }}" class="w-full mt-1 p-2 border rounded">
          @error('coverage_area') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Description</label>
          <textarea name="description" rows="4" class="w-full mt-1 p-2 border rounded">{{ old('description', $isEdit ? $product->description : '') }}</textarea>
          @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Stock quantity</label>
          <input name="stock_quantity" value="{{ old('stock_quantity', $isEdit ? $product->stock_quantity : '') }}" class="w-full mt-1 p-2 border rounded">
          @error('stock_quantity') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Low stock alert</label>
          <input name="low_stock_alert" value="{{ old('low_stock_alert', $isEdit ? $product->low_stock_alert : '') }}" class="w-full mt-1 p-2 border rounded">
          @error('low_stock_alert') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Image</label>
          <div class="mt-1 flex items-center space-x-4">
            @php
              $preview = old('image_preview');
              if (!$preview) {
                $preview = $isEdit && isset($product->image_url) && $product->image_url ? asset($product->image_url) : asset('images/products/placeholder.png');
              }
            @endphp
            <img id="imagePreview" src="{{ $preview }}" alt="Preview" class="w-24 h-24 rounded object-cover border border-gray-200">
            <div class="flex-1">
              <input id="imageInput" type="file" name="image" class="block w-full">
              @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
          </div>
        </div>

        <div class="flex items-center gap-4">
          <label class="flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $isEdit ? $product->is_featured : false) ? 'checked' : '' }}> Featured</label>
          <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $isEdit ? $product->is_active : true) ? 'checked' : '' }}> Active</label>
        </div>
      </div>
    </div>

    <div class="mt-6 flex items-center space-x-3">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Save</button>
      <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-200 rounded-md text-sm text-gray-700">Cancel</a>
    </div>
  </form>

  <script>
    (function(){
      const input = document.getElementById('imageInput');
      const preview = document.getElementById('imagePreview');
      if (!input) return;
      input.addEventListener('change', function(e){
        const file = e.target.files && e.target.files[0];
        if (!file) return;
        const url = URL.createObjectURL(file);
        preview.src = url;
      });
    })();
  </script>

@endsection

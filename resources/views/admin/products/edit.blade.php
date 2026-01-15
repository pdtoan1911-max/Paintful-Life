@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 max-w-3xl">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Edit Product</h2>

    <form action="{{ route('admin.products.update', $product) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Product Name</label>
        <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" class="w-full mt-1 p-2 border rounded" required>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Price</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full mt-1 p-2 border rounded" required>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Category</label>
        <select name="category_id" class="w-full mt-1 p-2 border rounded">
          <option value="">-- None --</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
          @endforeach
        </select>
      </div>

      <div class="flex items-center">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
        <a href="{{ route('admin.products.index') }}" class="ml-3 text-gray-600 hover:underline">Cancel</a>
      </div>
    </form>
  </div>
@endsection

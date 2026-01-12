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
          <label class="block text-sm font-medium text-gray-700">Name</label>
          <input name="name" value="{{ old('name', $product->name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm">
          @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Category</label>
          <select name="category_id" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm">
            <option value="">Select category</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
          @error('category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Price</label>
          <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm">
          @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <!-- Right: Details -->
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Coverage</label>
          <input name="coverage" value="{{ old('coverage', $product->coverage ?? '') }}" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm">
          @error('coverage') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Volume</label>
          <input name="volume" value="{{ old('volume', $product->volume ?? '') }}" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm">
          @error('volume') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Description</label>
          <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm">{{ old('description', $product->description ?? '') }}</textarea>
          @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Image</label>
          <div class="mt-1 flex items-center space-x-4">
            <img src="{{ old('image_preview', $product->thumbnail ?? asset('images/products/placeholder.png')) }}" alt="Preview" class="w-24 h-24 rounded object-cover border border-gray-200">
            <div class="flex-1">
              <input type="file" name="image" class="block w-full">
              @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-6 flex items-center space-x-3">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Save</button>
      <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-200 rounded-md text-sm text-gray-700">Cancel</a>
    </div>
  </form>

@endsection

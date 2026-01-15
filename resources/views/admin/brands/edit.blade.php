@extends('admin.layout')

@section('title','Edit Brand')

@section('content')
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 max-w-2xl">
    <h2 class="text-lg font-medium mb-4">Edit Brand</h2>

    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input name="brand_name" value="{{ old('brand_name', $brand->brand_name) }}" class="w-full mt-1 p-2 border rounded" required>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Country Origin</label>
        <input name="country_origin" value="{{ old('country_origin', $brand->country_origin) }}" class="w-full mt-1 p-2 border rounded">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Logo</label>
        <div class="flex items-center gap-4 mt-1">
          <img src="{{ $brand->logo_url ? asset($brand->logo_url) : asset('images/brands/placeholder.png') }}" class="w-24 h-24 object-cover rounded border">
          <input type="file" name="logo" class="block w-full">
        </div>
      </div>

      <div class="mb-4">
        <label class="inline-flex items-center">
          <input type="checkbox" name="is_active" value="1" {{ old('is_active', $brand->is_active) ? 'checked' : '' }}>
          <span class="ml-2">Active</span>
        </label>
      </div>

      <div class="flex items-center gap-3">
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
        <a href="{{ route('admin.brands.index') }}" class="text-gray-600 ml-2">Cancel</a>
      </div>
    </form>
  </div>
@endsection

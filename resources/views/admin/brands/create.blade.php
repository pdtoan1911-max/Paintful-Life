@extends('admin.layout')

@section('title','Create Brand')

@section('content')
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 max-w-2xl">
    <h2 class="text-lg font-medium mb-4">Create Brand</h2>

    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input name="brand_name" value="{{ old('brand_name') }}" class="w-full mt-1 p-2 border rounded" required>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Country Origin</label>
        <input name="country_origin" value="{{ old('country_origin') }}" class="w-full mt-1 p-2 border rounded">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Logo</label>
        <input type="file" name="logo" class="mt-1 block w-full">
      </div>

      <div class="mb-4">
        <label class="inline-flex items-center">
          <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
          <span class="ml-2">Active</span>
        </label>
      </div>

      <div class="flex items-center gap-3">
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
        <a href="{{ route('admin.brands.index') }}" class="text-gray-600 ml-2">Cancel</a>
      </div>
    </form>
  </div>
@endsection

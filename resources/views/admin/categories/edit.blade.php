@extends('admin.layout')

@section('title', 'Edit Category')

@section('content')
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 max-w-2xl">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Edit Category</h2>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
      </div>

      <div class="flex items-center">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
        <a href="{{ route('admin.categories.index') }}" class="ml-3 text-gray-600 hover:underline">Cancel</a>
      </div>
    </form>
  </div>
@endsection

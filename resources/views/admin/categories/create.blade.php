@extends('admin.layout')

@section('title', 'Create Category')

@section('content')
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 max-w-2xl">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Create Category</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST">
      @csrf

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="category_name" value="{{ old('category_name') }}" class="w-full mt-1 p-2 border rounded" required>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Slug</label>
        <input type="text" name="slug" value="{{ old('slug') }}" class="w-full mt-1 p-2 border rounded" required>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Parent</label>
        <select name="parent_id" class="w-full mt-1 p-2 border rounded">
          <option value="">-- None --</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-4 flex items-center gap-3">
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
        <label for="is_active" class="text-sm text-gray-700">Active</label>
      </div>

      <div class="flex items-center">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
        <a href="{{ route('admin.categories.index') }}" class="ml-3 text-gray-600 hover:underline">Cancel</a>
      </div>
    </form>
  </div>
@endsection

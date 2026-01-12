@extends('admin.layout')

@section('title', 'Categories')

@section('content')
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">ID</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Name</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Slug</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
          @foreach ($categories as $category)
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-3 text-sm text-gray-700">{{ $category->category_id }}</td>
              <td class="px-4 py-3 text-sm text-gray-900">{{ $category->category_name }}</td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ $category->slug }}</td>
              <td class="px-4 py-3 text-sm">
                <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:underline">Edit</a>
                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="ml-3 text-red-600 hover:underline">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection

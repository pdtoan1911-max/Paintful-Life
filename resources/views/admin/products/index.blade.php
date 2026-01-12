@extends('admin.layout')

@section('title', 'Products')

@section('content')
  <div class="mb-6 flex items-center justify-between">
    <h2 class="text-lg font-semibold text-gray-900">Products</h2>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">Add Product</a>
  </div>

  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Thumbnail</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Product</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Category</th>
            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">Price</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
          @foreach ($products as $product)
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-3">
                <img src="{{ $product->image_url ?asset($product->image_url): asset('images/products/placeholder.png') }}" alt="" class="w-12 h-12 rounded object-cover">
              </td>
              <td class="px-4 py-3 text-sm text-gray-900">{{ $product->product_name }}</td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ $product->category->category_name ?? '-' }}</td>
              <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ $product->price }}</td>
              <td class="px-4 py-3 text-sm">
                <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:underline">Edit</a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
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

@extends('admin.layout')

@section('title', 'Products')
@php
    $selectedBrand = request('brand');
@endphp
@section('content')
  <div class="mb-6 flex items-center justify-between">
    <h2 class="text-lg font-semibold text-gray-900">Products</h2>
    <a href="{{ route('admin.products.create') }}"
      class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">Add
      Product</a>
  </div>

  <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
    <div class="flex items-center justify-between gap-4 mb-4">
      <form method="GET" class="flex items-center gap-2">
        @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
        <div>
          <label class="block text-sm font-medium text-gray-600 mb-2">
            Thương hiệu
          </label>

          <select name="brand" class="brandfilter w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-[var(--pf-accent)]">

            <option value="">Tất cả</option>

            @foreach ($brands as $cat)
              <option value="{{ $cat->brand_id }}" {{ (string) $selectedBrand === (string) $cat->brand_id ? 'selected' : '' }}>
                {{ $cat->brand_name }}
              </option>
            @endforeach
          </select>
        </div>
      </form>

      <form method="GET" class="ml-auto">
        {{-- @if(request('start_date'))<input type="hidden" name="start_date" value="{{ request('start_date') }}">@endif --}}
        @if(request('brand'))<input type="hidden" name="brand" value="{{ request('brand') }}">@endif
        <div class="flex items-center">
          <input type="search" name="q" placeholder="Tìm theo tên sản phẩm" value="{{ request('q') }}"
            class="px-3 py-1 border w-64">
          <button type="submit" class="px-3 py-1 h-[25px] border bg-gray-100 cursor-pointer hover:bg-gray-200">Tìm kiếm</button>
        </div>
      </form>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Thumbnail</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Product</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Brand</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Category</th>
            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">Price</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
          @foreach ($products as $product)
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-3">
                <img src="{{ $product->image_url ? asset($product->image_url) : asset('images/products/placeholder.png') }}"
                  alt="" class="w-12 h-12 rounded object-cover">
              </td>
              <td class="px-4 py-3 text-sm text-gray-900">{{ $product->product_name }}</td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ $product->brand->brand_name ?? '-' }}</td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ $product->category->category_name ?? '-' }}</td>
              <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ $product->price }}</td>
              <td class="px-4 py-3 text-sm flex items-center gap-3">
                <!-- Edit -->
                <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800"
                  title="Chỉnh sửa">
                  <!-- Pencil icon -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.125 19.588l-4.5 1.318 1.318-4.5L16.862 3.487z" />
                  </svg>
                </a>

                <!-- Delete -->
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')

                  <button type="submit" class="text-red-600 hover:text-red-800 border-none bg-white" title="Xoá"
                    onclick="return confirm('Bạn có chắc muốn xoá sản phẩm này?')">
                    <!-- Trash icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 7h12M9 7V4h6v3M10 11v6M14 11v6M5 7l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12" />
                    </svg>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="mt-4 flex items-center justify-center">
      @php $products->appends(request()->query());
        $cur = $products->currentPage();
      $last = $products->lastPage(); @endphp

      {{-- Back 1 page --}}
      <a href="{{ $products->previousPageUrl() ?: '#' }}"
        class="px-3 py-1 mx-1 rounded {{ $products->previousPageUrl() ? 'bg-white' : 'bg-gray-100' }}" aria-label="Prev">
        ‹
      </a>

      {{-- Prev page if exists --}}
      @if($cur > 1)
        <a href="{{ $products->url($cur - 1) }}" class="px-3 py-1 mx-1 rounded bg-white">{{ $cur - 1 }}</a>
      @endif

      {{-- Current page --}}
      <span class="px-3 py-1 mx-1 rounded bg-[var(--pf-accent)] text-white">{{ $cur }}</span>

      {{-- Next page if exists --}}
      @if($cur < $last)
        <a href="{{ $products->url($cur + 1) }}" class="px-3 py-1 mx-1 rounded bg-white">{{ $cur + 1 }}</a>
      @endif

      {{-- Forward 1 page --}}
      <a href="{{ $products->nextPageUrl() ?: '#' }}"
        class="px-3 py-1 mx-1 rounded {{ $products->nextPageUrl() ? 'bg-white' : 'bg-gray-100' }}" aria-label="Next">
        ›
      </a>
    </div>
  @endif
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      const dateInputs = document.querySelectorAll('.brandfilter');
      dateInputs.forEach(input => {
        input.addEventListener('change', function () {
          this.form.submit();
        });
      });
    });
  </script>
@endsection
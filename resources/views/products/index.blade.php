@extends('layouts.app')

@section('content')

@php
    $selectedCategory = request('category');
    $selectedVolumes  = (array) request()->input('volume', []);
    $selectedFinishes = (array) request()->input('finish', []);
    $minPrice = request('min_price');
    $maxPrice = request('max_price');
@endphp

<div class="max-w-7xl mx-auto px-4 py-10">

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center gap-2 list-none pl-0">
            <li>
                <a href="{{ route('home') }}" class="hover:text-[var(--pf-accent)]">
                    Trang chủ
                </a>
            </li>
            <li>/</li>
            <li>
                <a href="{{ route('products.index') }}" class="hover:text-[var(--pf-accent)]">
                    Sản phẩm
                </a>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- ================= SIDEBAR FILTER ================= -->
        <aside class="lg:col-span-3">
            <div class="pf-card p-5 sticky top-24">

                <h3 class="font-semibold text-lg text-gray-800">
                    Bộ lọc
                </h3>

                <form method="GET"
                      action="{{ route('products.index') }}"
                      class="mt-4 space-y-6">

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            Danh mục
                        </label>

                        <div class="space-y-2">
                            @foreach($categories as $cat)
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio"
                                           name="category"
                                           value="{{ $cat->category_id }}"
                                           {{ (string)$selectedCategory === (string)$cat->category_id ? 'checked' : '' }}>
                                    <span class="text-gray-700">
                                        {{ $cat->category_name }}
                                    </span>
                                </label>
                            @endforeach

                            <label class="flex items-center gap-2 text-sm">
                                <input type="radio" name="category" value="">
                                <span class="text-gray-700">Tất cả</span>
                            </label>
                        </div>
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            Khoảng giá
                        </label>

                        <div class="flex items-center gap-2">
                            <input type="number"
                                   name="min_price"
                                   value="{{ $minPrice }}"
                                   placeholder="Từ"
                                   class="w-1/2 px-3 py-2 rounded-md border border-gray-200 text-sm">

                            <input type="number"
                                   name="max_price"
                                   value="{{ $maxPrice }}"
                                   placeholder="Đến"
                                   class="w-1/2 px-3 py-2 rounded-md border border-gray-200 text-sm">
                        </div>
                    </div>

                    <!-- Volume -->
                    @if($volumes->count())
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Dung tích
                            </label>

                            <div class="grid grid-cols-1 gap-2">
                                @foreach($volumes as $volume)
                                    <label class="flex items-center gap-2 text-sm">
                                        <input type="checkbox"
                                               name="volume[]"
                                               value="{{ $volume }}"
                                               {{ in_array($volume, $selectedVolumes, true) ? 'checked' : '' }}>
                                        <span class="text-gray-700">{{ $volume }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Finish -->
                    @if($finishes->count())
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Độ bóng
                            </label>

                            <div class="grid grid-cols-1 gap-2">
                                @foreach($finishes as $finish)
                                    <label class="flex items-center gap-2 text-sm">
                                        <input type="checkbox"
                                               name="finish[]"
                                               value="{{ $finish }}"
                                               {{ in_array($finish, $selectedFinishes, true) ? 'checked' : '' }}>
                                        <span class="text-gray-700">{{ $finish }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <button type="submit" class="pf-btn w-full">
                        Áp dụng
                    </button>
                </form>
            </div>
        </aside>

        <!-- ================= PRODUCT LIST ================= -->
        <main class="lg:col-span-9">

            <!-- Header -->
            {{-- <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold">
                    Tất cả sản phẩm
                </h2>

                <div class="text-sm text-gray-500">
                    Hiển thị {{ $products->firstItem() ?? 0 }}
                    – {{ $products->lastItem() ?? 0 }}
                    / {{ $products->total() }}
                </div>
            </div> --}}

            <!-- Product Grid -->
            <div id="product-list"
                 class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @forelse($products as $product)

                    @php
                        $rating = is_numeric($product->rating_avg ?? null)
                            ? max(1, min(5, (int) round($product->rating_avg)))
                            : 0;

                        $reviewsCount = is_numeric($product->reviews_count ?? null)
                            ? (int) $product->reviews_count
                            : null;
                    @endphp

                    <div class="pf-product-card flex flex-col h-full">

                        <a href="{{ route('products.show', $product->product_id) }}"
                           class="block pf-product-image aspect-[4/3]">
                            <img src="{{ $product->image_url ?: asset('images/products/placeholder.png') }}"
                                 alt="{{ $product->product_name }}">
                        </a>

                        <div class="pf-product-body flex flex-col flex-1">

                            <a href="{{ route('products.show', $product->product_id) }}"
                               class="pf-product-title line-clamp-1">
                                {{ $product->product_name }}
                            </a>

                            @if($rating > 0)
                                <div class="flex items-center gap-1 mt-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                             viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.97c.3.92-.755 1.688-1.54 1.118l-3.38-2.455a1 1 0 00-1.176 0l-3.38 2.455c-.784.57-1.84-.197-1.54-1.118l1.287-3.97a1 1 0 00-.364-1.118L2.045 9.397c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.97z"/>
                                        </svg>
                                    @endfor

                                    @if($reviewsCount)
                                        <span class="text-xs text-gray-500">
                                            ({{ $reviewsCount }})
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div class="mt-auto pt-3 flex items-center gap-2">
                                <div class="pf-product-price">
                                    {{ number_format($product->price, 0, ',', '.') }}₫
                                </div>

                                <button class="btn-add pf-product-cta ml-auto"
                                        data-id="{{ $product->product_id }}">
                                    Thêm
                                </button>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-span-full text-center text-gray-500 py-10">
                        Không tìm thấy sản phẩm phù hợp
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>

            <!-- Suggested -->
            @if($suggested->count())
                <section class="mt-12">
                    <h3 class="text-lg font-semibold mb-4">
                        Gợi ý cho bạn
                    </h3>

                    <div class="flex gap-4 overflow-x-auto">
                        @foreach($suggested as $s)
                            <a href="{{ route('products.show', $s->product_id) }}"
                               class="min-w-[160px] pf-card p-3 flex flex-col">

                                <div class="aspect-square bg-gray-50 rounded overflow-hidden">
                                    <img src="{{ $s->image_url ?: asset('images/products/placeholder.png') }}"
                                         class="w-full h-full object-cover">
                                </div>

                                <div class="mt-2 text-sm font-medium line-clamp-2">
                                    {{ $s->product_name }}
                                </div>

                                <div class="mt-auto text-sm font-semibold text-[var(--pf-accent)]">
                                    {{ number_format($s->price, 0, ',', '.') }}₫
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

        </main>
    </div>
</div>

@endsection

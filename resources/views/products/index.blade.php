@extends('layouts.app')

@section('content')
    <!-- Hero / Breadcrumb -->
    <section class=""> 
        <div class="max-w-7xl mx-auto py-10">
            <div class="rounded-2xl overflow-hidden relative bg-[var(--pf-primary)]/10 pf-card p-8">
                <h1 class="text-3xl md:text-4xl font-semibold text-[var(--pf-accent)]">Sản phẩm</h1>
                <nav class="text-sm text-gray-500 mt-2" aria-label="Breadcrumb">
                    <ol class="flex items-center gap-2 list-none pl-0">
                        <li><a href="{{ route('home') }}" class="hover:text-[var(--pf-accent)]">Trang chủ</a></li>
                        <li>/</li>
                        <li class="text-gray-700">Sản phẩm</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Main -->
    <div class="max-w-7xl mx-auto py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Sidebar -->
            <aside class="lg:col-span-3">
                <div class="pf-card p-5 sticky top-24">
                    <h3 class="font-semibold text-lg text-gray-800">Bộ lọc</h3>
                    <form method="GET" action="{{ route('products.index') }}" class="mt-4 space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-2">Danh mục</label>
                            <div class="space-y-2">
                                @foreach($categories as $cat)
                                    <label class="flex items-center gap-2 text-sm">
                                        <input type="radio" name="category" value="{{ $cat->category_id }}" class="text-[var(--pf-accent)]" {{ request('category') == $cat->category_id ? 'checked' : '' }} />
                                        <span class="text-gray-700">{{ $cat->category_name }}</span>
                                    </label>
                                @endforeach
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="category" value="" class="text-[var(--pf-accent)]" {{ request()->filled('category') ? '' : 'checked' }} />
                                    <span class="text-gray-700">Tất cả</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-2">Khoảng giá</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="min_price" placeholder="Từ" value="{{ request('min_price') }}" class="w-1/2 px-3 py-2 rounded-md border border-gray-200 text-sm" />
                                <input type="number" name="max_price" placeholder="Đến" value="{{ request('max_price') }}" class="w-1/2 px-3 py-2 rounded-md border border-gray-200 text-sm" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-2">Thuộc tính</label>
                            <div class="grid grid-cols-1 gap-2">
                                <label class="flex items-center gap-2 text-sm text-gray-700">
                                    <input type="checkbox" disabled class="opacity-60"/> <span class="text-xs">(Placeholder) Màu sắc</span>
                                </label>
                                <label class="flex items-center gap-2 text-sm text-gray-700">
                                    <input type="checkbox" disabled class="opacity-60"/> <span class="text-xs">(Placeholder) Finish</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="submit" class="pf-btn w-full text-center">Áp dụng</button>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Product Grid -->
            <main class="lg:col-span-9">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">Tất cả sản phẩm</h2>
                    <div class="text-sm text-gray-500">
                        Hiển thị {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} / {{ $products->total() }}
                    </div>
                </div>

                <div class="flex items-center justify-end mb-6">
                    @if($products->hasPages())
                        <nav class="inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                            {{-- Previous Page Link --}}
                            @if($products->onFirstPage())
                                <span class="pf-card px-3 py-2 rounded-l-md text-gray-400">
                                    ‹
                                </span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" class="pf-card px-3 py-2 rounded-l-md hover:bg-gray-50">
                                    ‹
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($products->elements() as $element)
                                @if (is_string($element))
                                    <span class="pf-card px-3 py-2">{{ $element }}</span>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $products->currentPage())
                                            <span aria-current="page" class="pf-card px-4 py-2 bg-[var(--pf-accent)] text-white">{{ $page }}</span>
                                        @else
                                            <a href="{{ $url }}" class="pf-card px-4 py-2 hover:bg-gray-50">{{ $page }}</a>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" class="pf-card px-3 py-2 rounded-r-md hover:bg-gray-50">
                                    ›
                                </a>
                            @else
                                <span class="pf-card px-3 py-2 rounded-r-md text-gray-400">›</span>
                            @endif
                        </nav>
                    @endif
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="pf-product-card flex flex-col h-full">

                        <!-- IMAGE -->
                        <a href="{{ route('products.show', $product->product_id) }}"
                        class="block pf-product-image aspect-[4/3]">
                            <img
                                src="{{ $product->image_url ?: asset('images/products/placeholder.png') }}"
                                alt="{{ $product->product_name }}"
                            >
                        </a>

                        <!-- BODY -->
                        <div class="pf-product-body flex flex-col flex-1">

                            <a href="{{ route('products.show', $product->product_id) }}" class="block">
                                <div class="pf-product-title line-clamp-2">
                                    {{ $product->product_name }}
                                </div>
                            </a>

                            <!-- PRICE + CTA -->
                            <div class="mt-auto pt-3 flex items-center gap-2">
                                <div class="pf-product-price whitespace-nowrap">
                                    {{ number_format($product->price,0,',','.') }}₫
                                </div>

                                <button
                                    class="btn-add pf-product-cta ml-auto flex-shrink-0"
                                    data-id="{{ $product->product_id }}">
                                    Thêm
                                </button>
                            </div>

                        </div>
                    </div>
                @endforeach
                </div>

                <div class="mt-8">
                    @if($products->hasPages())
                        <div class="flex justify-center">
                            <nav class="inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                @if($products->onFirstPage())
                                    <span class="pf-card px-3 py-2 rounded-l-md text-gray-400">‹</span>
                                @else
                                    <a href="{{ $products->previousPageUrl() }}" class="pf-card px-3 py-2 rounded-l-md hover:bg-gray-50">‹</a>
                                @endif

                                @foreach ($products->elements() as $element)
                                    @if (is_string($element))
                                        <span class="pf-card px-3 py-2">{{ $element }}</span>
                                    @endif

                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $products->currentPage())
                                                <span aria-current="page" class="pf-card px-4 py-2 bg-[var(--pf-accent)] text-white">{{ $page }}</span>
                                            @else
                                                <a href="{{ $url }}" class="pf-card px-4 py-2 hover:bg-gray-50">{{ $page }}</a>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                @if($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}" class="pf-card px-3 py-2 rounded-r-md hover:bg-gray-50">›</a>
                                @else
                                    <span class="pf-card px-3 py-2 rounded-r-md text-gray-400">›</span>
                                @endif
                            </nav>
                        </div>
                    @endif
                </div>

                @if(isset($suggested) && $suggested->count())
                    <section class="mt-12">
                        <h3 class="text-lg font-semibold mb-4">Gợi ý cho bạn</h3>

                        <div class="flex gap-4 overflow-x-auto py-2">
                            @foreach($suggested as $s)
                                <a href="{{ route('products.show',$s->product_id) }}"
                                class="min-w-[160px] max-w-[160px] shrink-0
                                        pf-card p-3
                                        flex flex-col h-full
                                        transition hover:shadow-lg">

                                    <!-- IMAGE -->
                                    <div class="relative aspect-square bg-gray-50 overflow-hidden rounded-md">
                                        <img
                                            src="{{ $s->image_url ?: asset('images/products/placeholder.png') }}"
                                            class="absolute inset-0 w-full h-full object-cover"
                                            alt="{{ $s->product_name }}"
                                        />
                                    </div>

                                    <!-- BODY -->
                                    <div class="mt-2 flex flex-col flex-1">
                                        <div class="text-sm font-medium text-gray-800 line-clamp-2">
                                            {{ $s->product_name }}
                                        </div>

                                        <div class="mt-auto text-sm text-[var(--pf-accent)] font-semibold">
                                            {{ number_format($s->price,0,',','.') }}₫
                                        </div>
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

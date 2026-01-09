@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-10">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2 list-none pl-0">
                <li><a href="{{ route('home') }}" class="hover:text-[var(--pf-accent)]">Trang chủ</a></li>
                <li>/</li>
                <li><a href="{{ route('products.index') }}" class="hover:text-[var(--pf-accent)]">Sản phẩm</a></li>
                <li>/</li>
                <li class="text-gray-700">{{ $product->product_name }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Gallery -->
            <div class="lg:col-span-6">
                <div class="pf-card p-4">
                    <div class="bg-gray-50 rounded-md overflow-hidden">
                        <img id="mainImage" src="{{ $product->image_url ? asset($product->image_url) : asset('images/products/placeholder.png') }}" alt="{{ $product->product_name }}" class="w-full h-[520px] object-cover transition-transform duration-300 hover:scale-105" />
                    </div>

                    <div class="mt-4 grid grid-cols-5 gap-3">
                        @for($i=0;$i<3;$i++)
                            <button class="thumbnail border border-gray-100 rounded-md overflow-hidden">
                                <img src="{{ $product->image_url ? asset($product->image_url) : asset('images/products/placeholder.png') }}" class="w-full h-20 object-cover" />
                            </button>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="lg:col-span-6">
                <div class="pf-card p-6">
                    <h1 class="text-2xl font-semibold text-gray-800">{{ $product->product_name }}</h1>
                    <div class="mt-3 text-2xl font-bold text-[var(--pf-accent)]">{{ number_format($product->price,0,',','.') }}₫</div>

                    <div class="mt-4 text-sm text-gray-700 space-y-1">
                        <div><span class="font-medium">Dòng sơn:</span> {{ $product->paint_base ?? '—' }}</div>
                        <div><span class="font-medium">Độ phủ:</span> {{ $product->coverage_area ?? '—' }}</div>
                        <div><span class="font-medium">Thể tích:</span> {{ $product->volume ?? '—' }}</div>
                    </div>

                    <p class="mt-4 text-gray-600">{{ $product->description }}</p>

                    <div class="mt-6 flex items-center gap-4">
                        <div class="flex items-center border border-gray-200 rounded-md">
                            <button type="button" class="px-3 py-2 text-gray-600 qty-decrease">−</button>
                            <input id="qty" type="number" value="1" min="1" class="w-16 text-center px-2 py-2 outline-none" />
                            <button type="button" class="px-3 py-2 text-gray-600 qty-increase">＋</button>
                        </div>

                        <button class="btn-add pf-btn text-white px-6 py-3" data-id="{{ $product->product_id }}">Thêm vào giỏ</button>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="mt-6 pf-card p-4">
                    <div class="flex gap-4 border-b border-gray-100 pb-3">
                        <button class="tab text-sm text-gray-700 font-medium" data-target="desc">Mô tả</button>
                        <button class="tab text-sm text-gray-700 font-medium" data-target="spec">Thông số</button>
                        <button class="tab text-sm text-gray-700 font-medium" data-target="usage">Hướng dẫn</button>
                    </div>

                    <div class="mt-4 tab-content" id="desc">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                    <div class="mt-4 tab-content hidden" id="spec">
                        <ul class="text-sm text-gray-700 space-y-2">
                            <li><strong>Mã sản phẩm:</strong> {{ $product->product_code ?? '—' }}</li>
                            <li><strong>Finish:</strong> {{ $product->finish_type ?? '—' }}</li>
                            <li><strong>Thể tích:</strong> {{ $product->volume ?? '—' }}</li>
                        </ul>
                    </div>
                    <div class="mt-4 tab-content hidden" id="usage">
                        <p class="text-sm text-gray-700">Hướng dẫn sử dụng</p>
                    </div>
                </div>

                <!-- Related -->
                @if($related->count())
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-3">Sản phẩm liên quan</h3>
                        <div class="flex gap-4 overflow-x-auto py-2">
                            @foreach($related as $s)
                                <a href="{{ route('products.show',$s->product_id) }}"
                                class="min-w-[160px] max-w-[160px] shrink-0
                                        pf-card p-3
                                        flex flex-col h-full
                                        transition hover:shadow-lg">

                                    <!-- IMAGE -->
                                    <div class="relative aspect-square bg-gray-50 overflow-hidden rounded-md">
                                        <img
                                            src="{{ $s->image_url ? asset($s->image_url): asset('images/products/placeholder.png') }}"
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
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Simple tab switching and thumbnail swap
        document.addEventListener('click', function(e){
            if(e.target.matches('.tab')){
                document.querySelectorAll('.tab-content').forEach(c=>c.classList.add('hidden'));
                document.querySelectorAll('.tab').forEach(t=>t.classList.remove('text-[var(--pf-accent)]'));
                const target = e.target.dataset.target;
                document.getElementById(target).classList.remove('hidden');
                e.target.classList.add('text-[var(--pf-accent)]');
            }

            if(e.target.closest('.thumbnail')){
                const img = e.target.closest('.thumbnail').querySelector('img');
                if(img){ document.getElementById('mainImage').src = img.src; }
            }

            if(e.target.matches('.qty-decrease')){
                const input = document.getElementById('qty');
                input.value = Math.max(1, Number(input.value || 1) - 1);
            }
            if(e.target.matches('.qty-increase')){
                const input = document.getElementById('qty');
                input.value = Number(input.value || 1) + 1;
            }
        });
    </script>

@endsection

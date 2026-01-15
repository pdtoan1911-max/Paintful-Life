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
                            <button type="button" class="px-3 py-2 min-w-[40px] min-h-[40px] text-gray-600 qty-decrease">−</button>
                            <input id="qty" type="number" value="1" min="1" class="w-16 min-h-[40px] text-center px-2 py-2 outline-none" />
                            <button type="button" class="px-3 py-2 min-w-[40px] min-h-[40px] text-gray-600 qty-increase">＋</button>
                        </div>

                        <button class="btn-add pf-btn text-white px-6 py-3" data-id="{{ $product->product_id }}">Thêm vào giỏ</button>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="mt-6 pf-card p-4">
                    <div class="flex gap-4 border-b border-gray-100 pb-3">
                        <button class="tab text-sm text-gray-700 px-4 py-2 rounded-lg font-medium" data-target="desc">Mô tả</button>
                        <button class="tab text-sm text-gray-700 px-4 py-2 rounded-lg font-medium" data-target="spec">Thông số</button>
                        <button class="tab text-sm text-gray-700 px-4 py-2 rounded-lg font-medium" data-target="usage">Hướng dẫn</button>
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

    <!-- Reviews -->
    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="pf-card p-4">
            <h2 class="text-lg font-semibold mb-3">Đánh giá sản phẩm</h2>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-50 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="flex items-start gap-6">
                <div class="flex-1">
                    <h3 class="text-xl font-semibold mb-2">Khách hàng nhận xét</h3>

                    @if(isset($reviews) && $reviews->count())
                        <div class="space-y-4">
                            @foreach($reviews as $r)
                                <div class="border-b pb-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-sm font-semibold text-gray-600">{{ strtoupper(substr($r->user->full_name ?? ($r->user->email ?? 'U'),0,1)) }}</div>
                                            <div>
                                                <div class="font-medium">{{ $r->user->full_name ?? $r->user->email }}</div>
                                                <div class="text-xs text-gray-500">{{ $r->created_at->format('d/m/Y') }}</div>
                                            </div>
                                        </div>

                                        <div class="flex items-center">
                                            @for($i=1;$i<=5;$i++)
                                                <svg class="w-4 h-4 {{ $i <= $r->rating ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.97c.3.92-.755 1.688-1.54 1.118l-3.38-2.455a1 1 0 00-1.176 0l-3.38 2.455c-.784.57-1.84-.197-1.54-1.118l1.287-3.97a1 1 0 00-.364-1.118L2.045 9.397c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.97z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>

                                    <div class="mt-2 text-gray-700">{{ $r->content }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">{{ $reviews->links() }}</div>
                    @else
                        <div class="p-4 bg-yellow-50 text-gray-700 rounded">Chưa có đánh giá</div>
                    @endif
                </div>

                <div class="w-100 flex flex-col items-center justify-center">
                    @auth
                        <div id="reviewActions">
                            <button id="openReviewBtn" class="pf-btn w-full text-white">Viết đánh giá của bạn</button>
                        </div>

                        <div id="reviewForm" class="mt-4 hidden">
                            <form action="{{ route('products.reviews.store', $product->product_id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm text-gray-700 mb-2">Chọn đánh giá của bạn</label>
                                    <div id="starWrap" class="flex items-center gap-1">
                                        @for($i=1;$i<=5;$i++)
                                            <button type="button" class="star-btn border-none bg-white" data-value="{{ $i }}" aria-label="{{ $i }} stars">
                                                <svg class="w-6 h-6 text-gray-300" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.97c.3.92-.755 1.688-1.54 1.118l-3.38-2.455a1 1 0 00-1.176 0l-3.38 2.455c-.784.57-1.84-.197-1.54-1.118l1.287-3.97a1 1 0 00-.364-1.118L2.045 9.397c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.97z" />
                                                </svg>
                                            </button>
                                        @endfor
                                    </div>
                                    @error('rating') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm text-gray-700 mb-2">Nhập đánh giá về sản phẩm</label>
                                    <textarea name="content" rows="4" class="w-full p-2 border rounded" required>{{ old('content') }}</textarea>
                                    @error('content') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                                </div>

                                <input type="hidden" name="rating" id="ratingInput" />

                                <div class="flex items-center gap-2">
                                    <button type="submit" class="pf-btn w-full text-white">Gửi đánh giá</button>
                                    <button type="button" id="closeReviewBtn" class="inline-block bg-[var(--pf-warning)] text-white px-4 py-2 rounded-lg transition transform hover:-translate-y-0.5 w-50">Đóng</button>
                                </div>
                            </form>
                        </div>

                        <div class="mt-3 text-xs text-gray-500">Bạn đang đánh giá với tài khoản: <strong>{{ auth()->user()->full_name ?? auth()->user()->email }}</strong></div>
                    @else
                        <a href="{{ route('login') }}" class="pf-btn w-full text-white">Đăng nhập để viết đánh giá</a>
                    @endauth
                </div>
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

        @push('scripts')
        <script>
            (function(){
                // Review form toggling and star behavior
                const openBtn = document.getElementById('openReviewBtn');
                const reviewForm = document.getElementById('reviewForm');
                const closeBtn = document.getElementById('closeReviewBtn');
                const starWrap = document.getElementById('starWrap');
                const ratingInput = document.getElementById('ratingInput');
                let currentRating = 0;

                function paintStars(n){
                    Array.from(starWrap.querySelectorAll('.star-btn')).forEach(btn=>{
                        const v = Number(btn.dataset.value);
                        const svg = btn.querySelector('svg');
                        if(v <= n){ svg.classList.remove('text-gray-300'); svg.classList.add('text-yellow-400'); }
                        else { svg.classList.remove('text-yellow-400'); svg.classList.add('text-gray-300'); }
                    });
                }

                if(openBtn){
                    openBtn.addEventListener('click', function(){
                        reviewForm.classList.remove('hidden');
                        openBtn.classList.add('hidden');
                        window.scrollTo({ top: reviewForm.offsetTop - 80, behavior: 'smooth' });
                    });
                }
                if(closeBtn){
                    closeBtn.addEventListener('click', function(){
                        reviewForm.classList.add('hidden');
                        if(openBtn) openBtn.classList.remove('hidden');
                    });
                }

                if(starWrap){
                    starWrap.addEventListener('click', function(e){
                        const btn = e.target.closest('.star-btn');
                        if(!btn) return;
                        const v = Number(btn.dataset.value);
                        currentRating = v;
                        ratingInput.value = v;
                        paintStars(v);
                    });
                    // hover preview
                    starWrap.addEventListener('mouseover', function(e){
                        const btn = e.target.closest('.star-btn');
                        if(!btn) return;
                        const v = Number(btn.dataset.value);
                        paintStars(v);
                    });
                    starWrap.addEventListener('mouseleave', function(){
                        paintStars(currentRating);
                    });
                }
            })();
        </script>
        @endpush

@endsection

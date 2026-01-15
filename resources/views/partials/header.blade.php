<header id="site-header" class="sticky top-0 z-150 bg-white transition-shadow">
    <!-- Main bar -->
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Brand -->
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-[var(--pf-accent)] text-white flex items-center justify-center font-bold">
                    PL
                </div>
                <span class="text-lg font-semibold hidden sm:inline">
                    Paintful Life
                </span>
            </a>

            <!-- Desktop nav -->
            <nav class="hidden md:flex items-center">
                <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-gray-100">
                    <a href="{{ route('home') }}"
                    class="px-4 py-2 text-sm rounded-full transition
                    {{ request()->routeIs('home')
                            ? 'bg-white text-[var(--pf-accent)] font-medium shadow-sm'
                            : 'text-gray-700 hover:bg-white/70 hover:text-[var(--pf-accent)]' }}">
                        Trang chủ
                    </a>

                    <a href="{{ route('products.index') }}"
                    class="px-4 py-2 text-sm rounded-full transition
                    {{ request()->routeIs('products.*')
                            ? 'bg-white text-[var(--pf-accent)] font-medium shadow-sm'
                            : 'text-gray-700 hover:bg-white/70 hover:text-[var(--pf-accent)]' }}">
                        Sản phẩm
                    </a>
                    <a href="{{ route('aboutus') }}"
                    class="px-4 py-2 text-sm rounded-full transition {{ request()->routeIs('aboutus')
                            ? 'bg-white text-[var(--pf-accent)] font-medium shadow-sm'
                            : 'text-gray-700 hover:bg-white/70 hover:text-[var(--pf-accent)]' }}">
                        Giới thiệu
                    </a>
                    <a href="{{ route('contactus') }}"
                    class="px-4 py-2 text-sm rounded-full transition {{ request()->routeIs('contactus')
                            ? 'bg-white text-[var(--pf-accent)] font-medium shadow-sm'
                            : 'text-gray-700 hover:bg-white/70 hover:text-[var(--pf-accent)]' }}">
                        Tư vấn
                    </a>
                </div>
            </nav>


            <!-- Actions -->
            <div class="flex items-center gap-3">
                <!-- Cart -->
                <a href="{{ route('cart.index') }}"
                   class="relative p-2 rounded-xl hover:bg-gray-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7 13L6 21m0 0a1 1 0 001 1h10a1 1 0 001-1l-1-8"/>
                    </svg>

                    {{-- @if(($cartCount ?? 0) > 0) --}}
                        <span id="cart-badge"
                            class="absolute -top-1 -right-1 min-w-[18px] h-[18px]
                                    bg-[var(--pf-accent)] text-white text-[11px]
                                    rounded-full flex items-center justify-center
                                    {{ ($cartCount ?? 0) > 0 ? '' : 'hidden' }}">
                            {{ $cartCount ?? 0 }}
                        </span>
                    {{-- @endif --}}
                </a>

                <!-- Auth -->
                @auth
                    <div class="relative">
                        <!-- Toggle -->
                        <button id="userToggle"
                                class="group flex items-center gap-2 px-2 py-1 rounded-full
                                    hover:bg-gray-100 transition cursor-pointer border-none">
                            <img src="{{ auth()->user()->avatar ?? asset('images/avatar-placeholder.png') }}"
                                class="w-8 h-8 rounded-full object-cover" />

                            <span class="hidden sm:inline text-sm font-medium text-gray-700">
                                {{ auth()->user()->full_name ?? auth()->user()->email }}
                            </span>

                            <svg class="flex-shrink-0 w-4 h-4 text-gray-400 hidden sm:block transition-transform group-hover:rotate-180"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div id="userMenu"
                            class="hidden absolute right-0 mt-3 w-64 bg-white rounded-2xl
                                    shadow-[0_20px_40px_rgba(0,0,0,0.12)]
                                    transition-all duration-150 origin-top-right
                                    scale-95">

                            <!-- Header -->
                            <div class="flex items-center gap-3 px-4 py-4 bg-gray-50">
                                <img src="{{ auth()->user()->avatar ?? asset('images/avatar-placeholder.png') }}"
                                    class="w-10 h-10 rounded-full object-cover" />
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-[var(--pf-primary)] truncate">
                                        {{ auth()->user()->full_name ?? 'User' }}
                                    </p>
                                    <p class="text-xs text-gray-500 truncate">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>
                            </div>

                            <!-- Menu -->
                            <div class="py-2">
                                <a href="{{ route('profile') }}"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700
                                        cursor-pointer transition
                                        hover:bg-gray-100 hover:translate-x-1">
                                    <svg class="flex-shrink-0 w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A9 9 0 1118.88 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Thông tin tài khoản
                                </a>

                                <a href="{{ route('orders') }}"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700
                                        cursor-pointer transition
                                        hover:bg-gray-100 hover:translate-x-1">
                                    <svg class="flex-shrink-0 w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h18l-2 13H5L3 3z"/>
                                    </svg>
                                    Lịch sử mua hàng
                                </a>
                            </div>

                            <!-- Logout -->
                            <form method="POST" action="/logout" class="p-2">
                                @csrf
                                <button
                                    class="flex items-center gap-3 w-full px-4 py-2 text-sm text-red-600
                                        rounded-lg cursor-pointer transition
                                        hover:bg-red-50 hover:translate-x-1 border-none">
                                    <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                                    </svg>
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>

                @else
                    <div class="hidden sm:flex items-center gap-3">
                        <a href="{{ route('login') }}"
                           class="text-sm text-gray-700 hover:text-pf-accent">
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="pf-btn">
                            Đăng ký
                        </a>
                    </div>
                @endauth

                <!-- Mobile toggle -->
                <button id="mobileToggle" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6 text-gray-700"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile drawer -->
    <div id="mobileNav"
         class="fixed inset-0 bg-black/40 hidden z-50">
        <div class="absolute right-0 top-0 h-full w-72 bg-white shadow-xl p-5">
            <div class="flex justify-between items-center mb-4">
                <span class="font-semibold">Menu</span>
                <button id="mobileClose" class="p-2">✕</button>
            </div>

            <nav class="flex flex-col gap-3">
                <a href="{{ route('home') }}" class="py-2">Trang chủ</a>
                <a href="{{ route('products.index') }}" class="py-2">Sản phẩm</a>
                <a href="{{ route('cart.index') }}" class="py-2">
                    Giỏ hàng ({{ $cartCount ?? 0 }})
                </a>
            </nav>
        </div>
    </div>
</header>

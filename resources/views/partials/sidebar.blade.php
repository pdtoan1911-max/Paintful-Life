<div class="bg-white rounded-xl shadow-sm p-5 sticky top-24">
    <div class="flex flex-col items-center text-center">
        <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center text-3xl font-semibold text-gray-500">
            {{ strtoupper(substr(auth()->user()->full_name ?? auth()->user()->email, 0, 1)) }}
        </div>
        <h4 class="mt-3 font-semibold">
            {{ auth()->user()->full_name ?? auth()->user()->email }}
        </h4>
        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
    </div>

    <nav class="mt-6 space-y-2">
        <a href="{{ route('profile') }}"
           class="block px-4 py-2 rounded-lg
           {{ request()->routeIs('profile')
                ? 'bg-indigo-50 text-indigo-600 font-medium'
                : 'text-gray-600 hover:bg-gray-100' }}">
            Thông tin tài khoản
        </a>

        <a href="{{ route('orders') }}"
           class="block px-4 py-2 rounded-lg
           {{ request()->routeIs('orders')
                ? 'bg-indigo-50 text-indigo-600 font-medium'
                : 'text-gray-600 hover:bg-gray-100' }}">
            Lịch sử mua hàng
        </a>
    </nav>
</div>

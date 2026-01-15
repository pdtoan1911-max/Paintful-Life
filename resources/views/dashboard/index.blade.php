@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <aside class="lg:col-span-1">
            @include('partials.sidebar')
        </aside>

        <section class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4">Thông tin tài khoản</h3>

                            @if(session('success'))
                                <div class="mb-4 p-3 bg-green-50 text-green-800 rounded">{{ session('success') }}</div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-medium">{{ auth()->user()->email }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Họ và tên</p>
                        <p class="font-medium">{{ auth()->user()->full_name ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Số điện thoại</p>
                        <p class="font-medium">{{ auth()->user()->phone_number ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Địa chỉ</p>
                        <p class="font-medium">{{ auth()->user()->address ?? '—' }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <button id="editProfileBtn" class="inline-flex items-center px-4 py-2 rounded-lg bg-[var(--pf-accent)] text-white text-sm hover:bg-indigo-700 transition">
                        Chỉnh sửa thông tin
                    </button>
                </div>

                <!-- Overlay -->
                <div id="editProfileForm"
                    class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center px-4">

                    <!-- Modal -->
                    <div class="w-full max-w-lg rounded-2xl bg-white text-[var(--pf-primary)] shadow-2xl">

                        <!-- Header -->
                        <div class="flex items-center justify-between px-6 py-4">
                            <h3 class="text-lg font-semibold">Chỉnh sửa thông tin</h3>
                            <button id="cancelEditBtn" class="text-[var(--pf-danger)] hover:text-black text-xl border-none bg-white">✕</button>
                        </div>

                        <!-- Body -->
                        <form action="{{ route('profile.update') }}" method="POST" class="px-3 py-5 space-y-5">
                            @csrf

                            <!-- Group input -->
                            <div class="rounded-xl border border-white/10 overflow-hidden bg-white">

                                <!-- Full name -->
                                <div class="flex flex-col px-2 py-3"> 
                                    <label class="text-gray-600">Họ và tên</label> 
                                    <input name="full_name" value="{{ old('full_name', auth()->user()->full_name) }}" 
                                    class="w-full mt-1 p-2 border rounded" /> 
                                    @error('full_name') 
                                    <div class="text-red-600 text-sm">{{ $message }}</div> 
                                    @enderror 
                                </div>

                                <!-- Phone -->
                                <div class="flex flex-col px-2 py-3"> 
                                    <label class="text-gray-600">Số điện thoại</label> 
                                    <input name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}" 
                                    class="w-full mt-1 p-2 border rounded" /> 
                                    @error('phone_number') 
                                    <div class="text-red-600 text-sm">{{ $message }}</div> 
                                    @enderror 
                                </div>

                                <!-- Address -->
                                <div class="flex flex-col px-2 py-3"> 
                                    <label class="text-gray-600">Địa chỉ</label> 
                                    <input name="address" value="{{ old('address', auth()->user()->address) }}" 
                                    class="w-full mt-1 p-2 border rounded" /> 
                                    @error('address') 
                                    <div class="text-red-600 text-sm">{{ $message }}</div> 
                                    @enderror 
                                </div>
                            </div>

                            <!-- Hint -->
                            <p class="text-xs text-gray-600 leading-relaxed">
                                Lưu ý: Thông tin cá nhân cần chính xác để phục vụ cho việc giao hàng
                                và hỗ trợ khách hàng khi cần thiết.
                            </p>

                            <!-- Action -->
                            <button
                                type="submit"
                                class="w-full rounded-full bg-[var(--pf-accent)] py-2.5 text-white font-medium
                                    transition hover:opacity-90 active:scale-95">
                                Xem lại thay đổi
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </section>

    </div>
</div>
@endsection
@push('scripts') 
<script>
(() => {
    const open = document.getElementById('editProfileBtn');
    const modal = document.getElementById('editProfileForm');
    const close = document.getElementById('cancelEditBtn');

    open?.addEventListener('click', () => {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });

    close?.addEventListener('click', () => {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
})();
</script>
@endpush
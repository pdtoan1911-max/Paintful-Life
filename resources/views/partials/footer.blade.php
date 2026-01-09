<footer class="mt-16">
    <div class="bg-slate-900">
        <div class="max-w-7xl mx-auto px-6 py-14 text-slate-300
            [&_a]:text-slate-400
            [&_a:hover]:text-white
            [&_a]:transition
        ">
            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Brand -->
                <div>
                    <a href="{{ route('home') }}" class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-[var(--pf-accent)] text-white flex items-center justify-center font-bold text-lg">
                            PL
                        </div>
                        <div>
                            <div class="text-lg font-semibold text-white">Paintful Life</div>
                            <div class="text-sm text-slate-400">Color your space</div>
                        </div>
                    </a>

                    <p class="text-slate-400 leading-relaxed mb-4">
                        Paintful Life cung cấp sơn chất lượng cao, bền màu và an toàn cho gia đình.
                        Đồng hành cùng bạn tạo nên không gian sống đầy cảm hứng.
                    </p>

                <div class="flex items-center gap-4">
                    <!-- Facebook -->
                    <a href="#"
                    aria-label="Facebook"
                    class="group w-10 h-10 flex items-center justify-center rounded-full
                            bg-white/10 hover:bg-blue-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="w-5 h-5 text-gray-300 group-hover:text-white">
                            <path d="M22 12a10 10 0 10-11.56 9.87v-6.99H8.07V12h2.37V9.8c0-2.34 1.4-3.63 3.54-3.63 1.03 0 2.1.18 2.1.18v2.3h-1.18c-1.17 0-1.54.73-1.54 1.48V12h2.62l-.42 2.88h-2.2v6.99A10 10 0 0022 12z"/>
                        </svg>
                    </a>

                    <!-- Instagram -->
                    <a href="#"
                    aria-label="Instagram"
                    class="group w-10 h-10 flex items-center justify-center rounded-full
                            bg-white/10 hover:bg-pink-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="w-5 h-5 text-gray-300 group-hover:text-white">
                            <path d="M12 2.2c3.2 0 3.6.01 4.86.07 1.17.06 1.97.25 2.43.42.61.23 1.05.5 1.5.95.45.45.72.89.95 1.5.17.46.36 1.26.42 2.43.06 1.26.07 1.66.07 4.86s-.01 3.6-.07 4.86c-.06 1.17-.25 1.97-.42 2.43-.23.61-.5 1.05-.95 1.5-.45.45-.89.72-1.5.95-.46.17-1.26.36-2.43.42-1.26.06-1.66.07-4.86.07s-3.6-.01-4.86-.07c-1.17-.06-1.97-.25-2.43-.42-.61-.23-1.05-.5-1.5-.95-.45-.45-.72-.89-.95-1.5-.17-.46-.36-1.26-.42-2.43-.06-1.26-.07-1.66-.07-4.86s.01-3.6.07-4.86c.06-1.17.25-1.97.42-2.43.23-.61.5-1.05.95-1.5.45-.45.89-.72 1.5-.95.46-.17 1.26-.36 2.43-.42C8.4 2.21 8.8 2.2 12 2.2zm0 3.38a6.42 6.42 0 100 12.84 6.42 6.42 0 000-12.84zm0 10.6a4.18 4.18 0 110-8.36 4.18 4.18 0 010 8.36zm6.68-11.13a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        </svg>
                    </a>

                    <!-- Zalo (icon custom) -->
                    <a href="#"
                    aria-label="Zalo"
                    class="group w-10 h-10 flex items-center justify-center rounded-full
                            bg-white/10 hover:bg-blue-500 transition">
                        <span class="text-sm font-bold text-gray-300 group-hover:text-white">
                            Z
                        </span>
                    </a>
                </div>

                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Liên kết nhanh</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Liên hệ</h4>
                    <ul class="space-y-3">
                        <li>📍 Địa chỉ: (placeholder)</li>
                        <li>📞 Hotline: (placeholder)</li>
                        <li>
                            ✉️ <a href="mailto:contact@paintful.example">
                                contact@paintful.example
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom -->
            <div class="mt-10 pt-6 border-t border-slate-700 flex flex-col md:flex-row items-center justify-between text-sm text-slate-400">
                <div>© {{ date('Y') }} Paintful Life. All rights reserved.</div>
                <div class="mt-3 md:mt-0 flex gap-4">
                    <a href="#">Privacy</a>
                    <a href="#">Terms</a>
                </div>
            </div>
        </div>
    </div>
</footer>

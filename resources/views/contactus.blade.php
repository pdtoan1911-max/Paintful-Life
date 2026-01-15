@extends('layouts.app')

@section('title', 'Tư vấn & Báo giá')

@section('content')
    <div class="bg-gray-50">

        <!-- Hero -->
        <section class="bg-white border-b">
            <div class="max-w-6xl mx-auto px-4 py-14 text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                    Tư vấn & Báo giá sơn số lượng lớn
                </h1>
                <p class="mt-4 text-gray-600 max-w-3xl mx-auto">
                    Dành cho khách hàng có nhu cầu mua sơn với số lượng lớn, sơn công trình
                    hoặc cần tư vấn chi tiết trước khi đưa ra quyết định.
                </p>
            </div>
        </section>

        <!-- Content -->
        <section class="max-w-5xl mx-auto px-4 py-16" x-data="{ submitted: false }">

            <!-- Intro -->
            <div class="mb-12 text-center">
                <p class="text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Paintful Life hiểu rằng mỗi công trình và mỗi không gian đều có yêu cầu riêng.
                    Việc lựa chọn đúng loại sơn, đúng màu sắc và đúng định mức sẽ giúp tối ưu chi phí
                    và đảm bảo chất lượng lâu dài.
                </p>
                <p class="text-gray-600 mt-3">
                    Vui lòng để lại thông tin bên dưới, đội ngũ của chúng tôi sẽ liên hệ tư vấn
                    và báo giá phù hợp với nhu cầu của bạn.
                </p>
            </div>

            <!-- Form -->
            <!-- Form -->
            <div class="bg-white rounded-2xl shadow-sm p-8 md:p-10">

                <!-- FORM -->
                <form x-show="!submitted" @submit.prevent="submitted = true" class="space-y-6">

                    <!-- Thông tin liên hệ -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Họ và tên
                            </label>
                            <input type="text" required class="w-full mt-1 p-2 border rounded" placeholder="Nguyễn Văn A">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Số điện thoại
                            </label>
                            <input type="text" required class="w-full mt-1 p-2 border rounded" placeholder="09xxxxxxxx">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email (không bắt buộc)
                        </label>
                        <input type="email" class="w-full mt-1 p-2 border rounded" placeholder="email@example.com">
                    </div>

                    <!-- Nhu cầu -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Bạn là
                            </label>
                            <select class="w-full mt-1 p-2 border rounded">
                                <option value="">-- Chọn --</option>
                                <option>Chủ nhà / cá nhân</option>
                                <option>Nhà thầu / đội thi công</option>
                                <option>Doanh nghiệp / công trình</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Loại sơn quan tâm
                            </label>
                            <select class="w-full mt-1 p-2 border rounded">
                                <option value="">-- Chọn --</option>
                                <option>Sơn nội thất</option>
                                <option>Sơn ngoại thất</option>
                                <option>Sơn chống thấm</option>
                                <option>Khác</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Quy mô / số lượng dự kiến
                        </label>
                        <input type="text" class="w-full mt-1 p-2 border rounded"
                            placeholder="Ví dụ: 200m², 20 thùng, nhà 3 tầng...">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nội dung cần tư vấn
                        </label>
                        <textarea rows="4" class="w-full mt-1 p-2 border rounded"
                            placeholder="Mô tả ngắn gọn nhu cầu của bạn"></textarea>
                    </div>

                    <div class="text-center pt-4">
                        <button type="submit" class="px-8 py-3 rounded-xl bg-[var(--pf-accent)] text-white hover:opacity-90 font-medium transition">
                            Gửi yêu cầu tư vấn
                        </button>
                    </div>
                </form>
            </div>

        </section>
    </div>
@endsection
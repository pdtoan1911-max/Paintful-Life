@extends('layouts.app')

@section('title', 'Giới thiệu')

@section('content')
<div class="bg-gray-50">

    <!-- Hero -->
    <section class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-4 py-16 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                Về Paintful Life
            </h1>
            <p class="mt-4 text-gray-600 max-w-3xl mx-auto">
                Paintful Life là thương hiệu bán lẻ sơn, cung cấp các dòng sơn chất lượng cao
                và giải pháp màu sắc phù hợp cho mọi không gian sống và làm việc.
            </p>
        </div>
    </section>

    <!-- Giới thiệu chung -->
    <section class="max-w-6xl mx-auto px-4 py-16 space-y-16">

        <div class="grid md:grid-cols-2 gap-10 items-center">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                    Chúng tôi là ai
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    <strong>Paintful Life</strong> chuyên bán lẻ các sản phẩm sơn dùng trong nhà và ngoài trời,
                    phục vụ nhu cầu sơn sửa, hoàn thiện và làm mới không gian sống.
                    Chúng tôi hướng đến việc cung cấp sản phẩm chính hãng, đa dạng màu sắc,
                    đáp ứng tiêu chuẩn chất lượng và độ bền cao.
                </p>
                <p class="text-gray-600 leading-relaxed mt-3">
                    Với Paintful Life, việc lựa chọn sơn không chỉ đơn giản là chọn màu,
                    mà còn là lựa chọn giải pháp phù hợp cho từng bề mặt và mục đích sử dụng.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <ul class="space-y-4 text-sm text-gray-700">
                    <li class="flex items-start gap-3">
                        <span class="text-indigo-500 font-bold">•</span>
                        Sơn nội thất và ngoại thất
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-indigo-500 font-bold">•</span>
                        Đa dạng bảng màu và dung tích
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-indigo-500 font-bold">•</span>
                        Phù hợp nhà ở, văn phòng, công trình
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sứ mệnh -->
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                Sứ mệnh
            </h2>
            <p class="text-gray-600 leading-relaxed">
                Sứ mệnh của Paintful Life là cung cấp các sản phẩm sơn chất lượng,
                an toàn và bền bỉ theo thời gian, đồng thời hỗ trợ khách hàng lựa chọn
                màu sắc và giải pháp sơn phù hợp nhất cho từng không gian.
            </p>
        </div>

        <!-- Tầm nhìn & Giá trị -->
        <div class="grid md:grid-cols-2 gap-8">

            <div class="bg-white rounded-2xl shadow-sm p-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    Tầm nhìn
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    Paintful Life hướng tới trở thành đơn vị bán lẻ sơn uy tín,
                    là lựa chọn tin cậy của khách hàng khi có nhu cầu sơn sửa
                    và hoàn thiện không gian sống.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    Giá trị cốt lõi
                </h2>
                <ul class="space-y-3 text-gray-600">
                    <li>• Chất lượng sản phẩm đặt lên hàng đầu</li>
                    <li>• Tư vấn rõ ràng, đúng nhu cầu</li>
                    <li>• Minh bạch về thông tin và giá cả</li>
                    <li>• Lấy sự hài lòng của khách hàng làm trọng tâm</li>
                </ul>
            </div>

        </div>

        <!-- Cam kết -->
        <div class="bg-[var(--pf-primary)] text-white rounded-2xl p-10 text-center">
            <h2 class="text-2xl font-semibold mb-4">
                Cam kết của Paintful Life
            </h2>
            <p class="max-w-3xl mx-auto leading-relaxed">
                Chúng tôi cam kết cung cấp sản phẩm sơn chính hãng, đúng chất lượng,
                thông tin rõ ràng và dịch vụ hỗ trợ chuyên nghiệp,
                giúp khách hàng yên tâm trong suốt quá trình lựa chọn và sử dụng.
            </p>
        </div>

    </section>
</div>
@endsection

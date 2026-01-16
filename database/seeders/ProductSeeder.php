<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $finishTypes = ['Bóng', 'Mờ', 'Mịn', 'Nhám'];
        $paintBases  = ['Gốc nước', 'Gốc dầu', 'Epoxy', 'PU'];

        $images = [
            [
                'images/products/son-dulux-1.jpg',
                'images/products/son-dulux-2.jpg',
                'images/products/son-dulux-3.jpg',
                'images/products/son-dulux-4.jpg',
                'images/products/son-dulux-5.jpg',
                'images/products/son-dulux-6.jpg',
            ],
            [
                'images/products/son-nippon-1.jpg',
                'images/products/son-nippon-2.jpg',
                'images/products/son-nippon-3.jpg',
                'images/products/son-nippon-4.jpg',
            ],
            [
                'images/products/son-jotun-1.jpg',
                'images/products/son-jotun-2.jpg',
                'images/products/son-jotun-3.jpg',
                'images/products/son-jotun-4.jpg',
            ],
            [
                'images/products/son-kova-1.jpg',
                'images/products/son-kova-2.jpg',
                'images/products/son-kova-3.jpg',
                'images/products/son-kova-4.jpg',
            ],
            [
                'images/products/son-toa-1.jpg',
                'images/products/son-toa-2.jpg',
                'images/products/son-toa-3.jpg',
                'images/products/son-toa-4.jpg',
            ],
            [
                'images/products/son-mykolor-1.jpg',
                'images/products/son-mykolor-2.jpg',
                'images/products/son-mykolor-3.jpg',
                'images/products/son-mykolor-4.jpg',
            ],
            [
                'images/products/son-spec-1.jpg',
                'images/products/son-spec-2.jpg',
                'images/products/son-spec-3.jpg',
                'images/products/son-spec-4.jpg',
            ],
            [
                'images/products/son-kaisan-1.jpg',
                'images/products/son-kaisan-2.jpg',
                'images/products/son-kaisan-3.jpg',
                'images/products/son-kaisan-4.jpg',
            ],
            [
                'images/products/son-maxilite-1.jpg',
                'images/products/son-maxilite-2.jpg',
                'images/products/son-maxilite-3.jpg',
                'images/products/son-maxilite-4.jpg',
            ],
            [
                'images/products/son-oexpo-1.jpg',
                'images/products/son-oexpo-2.jpg',
                'images/products/son-oexpo-3.jpg',
                'images/products/son-oexpo-4.jpg',
            ]
        ];

        $categoryNames = [
            1 => 'Sơn nội thất',
            2 => 'Sơn ngoại thất',
            3 => 'Sơn Lót',
            4 => 'Sơn chống thấm',
        ];

        $brandPrefixes = [
            1 => 'DLX', 2 => 'NIP', 3 => 'JTN', 4 => 'KVA', 5 => 'TOA',
            6 => 'MYK', 7 => 'SPC', 8 => 'KAN', 9 => 'MAX', 10 => 'OEX',
        ];

        $brandNames = [
            1 => 'Dulux',
            2 => 'Nippon Paint',
            3 => 'Jotun',
            4 => 'Kova',
            5 => 'Toa',
            6 => 'Mykolor',
            7 => 'Spec',
            8 => 'Kansai',
            9 => 'Maxilite',
            10 => 'Oexpo',
        ];

        for ($i = 1; $i <= 40; $i++) {

            $brandId    = rand(1, 10);
            $categoryId = rand(1, 4);
            $volume     = [1, 5, 20][array_rand([1, 5, 20])];
            $coverage   = rand(20, 150);

            Product::create([
                'brand_id' => $brandId,
                'category_id' => $categoryId,
                'product_code' => $brandPrefixes[$brandId] . '-' . $categoryId . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'product_name' => $categoryNames[$categoryId] . ' '.$brandNames[$brandId] .' cao cấp ',
                'description' => 'Sản phẩm ' . strtolower($categoryNames[$categoryId]) . ' chất lượng cao, độ bền tốt, dễ thi công và an toàn cho người sử dụng.',
                'paint_base' => $paintBases[array_rand($paintBases)],
                'finish_type' => $finishTypes[array_rand($finishTypes)],
                'volume' => $volume,
                'coverage_area' => $coverage,
                'cost_price' => rand(200, 1500)*1000,
                'price' => rand(300, 2500)*1000,
                'stock_quantity' => rand(20, 150),
                'low_stock_alert' => rand(3, 15),
                'image_url' => $images[$brandId - 1][array_rand($images[$brandId - 1])] ?? null,
                'rating_avg' => 0,
                'total_sold' => 0,
                'is_featured' => 0,
                'is_active' => true,
            ]);
        }
    }
}

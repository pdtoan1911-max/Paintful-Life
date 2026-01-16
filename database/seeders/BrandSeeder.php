<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'brand_name' => 'Dulux',
                'country_origin' => 'Netherlands', // AkzoNobel
                'is_active' => true,
                'logo_url' => 'images/brands/dulux.jpg',
            ],
            [
                'brand_name' => 'Nippon Paint',
                'country_origin' => 'Japan',
                'is_active' => true,
                'logo_url' => 'images/brands/nippon.jpg',
            ],
            [
                'brand_name' => 'Jotun',
                'country_origin' => 'Norway',
                'is_active' => true,
                'logo_url' => 'images/brands/jotun.jpg',
            ],
            [
                'brand_name' => 'Kova',
                'country_origin' => 'Vietnam',
                'is_active' => true,
                'logo_url' => 'images/brands/kova.jpg',
            ],
            [
                'brand_name' => 'TOA',
                'country_origin' => 'Thailand',
                'is_active' => true,
                'logo_url' => 'images/brands/toa.jpg',
            ],
            [
                'brand_name' => 'Mykolor',
                'country_origin' => 'Singapore',
                'is_active' => true,
                'logo_url' => 'images/brands/mykolor.jpg',
            ],
            [
                'brand_name' => 'Spec',
                'country_origin' => 'Vietnam',
                'is_active' => true,
                'logo_url' => 'images/brands/spec.jpg',
            ],
            [
                'brand_name' => 'Kansai',
                'country_origin' => 'Japan',
                'is_active' => true,
                'logo_url' => 'images/brands/kansai.jpg',
            ],
            [
                'brand_name' => 'Maxilite',
                'country_origin' => 'Vietnam',
                'is_active' => true,
                'logo_url' => 'images/brands/maxilite.jpg',
            ],
            [
                'brand_name' => 'Oexpo',
                'country_origin' => 'Vietnam',
                'is_active' => true,
                'logo_url' => 'images/brands/oexpo.jpg',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}

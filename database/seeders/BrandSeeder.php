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
        Brand::create(['brand_name' => 'Dulux', 'country_origin' => 'Australia', 'is_active' => true]);
        Brand::create(['brand_name' => 'Nippon Paint', 'country_origin' => 'Japan', 'is_active' => true]);
        Brand::create(['brand_name' => 'Jotun', 'country_origin' => 'Norway', 'is_active' => true]);
    }
}

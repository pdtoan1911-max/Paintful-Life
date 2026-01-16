<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['category_name' => 'Sơn nội thất', 'slug' => 'interior-paint', 'parent_id' => null, 'is_active' => true]);
        Category::create(['category_name' => 'Sơn ngoại thất', 'slug' => 'exterior-paint', 'parent_id' => null, 'is_active' => true]);
        Category::create(['category_name' => 'Sơn lót', 'slug' => 'primer', 'parent_id' => null, 'is_active' => true]);
        Category::create(['category_name' => 'Sơn chống thấm', 'slug' => 'waterproof-paint', 'parent_id' => null, 'is_active' => true]);
    }
}

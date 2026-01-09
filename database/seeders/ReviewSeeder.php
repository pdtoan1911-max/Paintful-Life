<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = [
            [
                'product_id' => 1,
                'user_id' => 1,
                'rating' => 5,
                'content' => 'Excellent paint! Easy to apply and great coverage.',
            ],
            [
                'product_id' => 1,
                'user_id' => 2,
                'rating' => 4,
                'content' => 'Good quality, but a bit pricey.',
            ],
            [
                'product_id' => 2,
                'user_id' => 1,
                'rating' => 4,
                'content' => 'Durable exterior paint, withstands weather well.',
            ],
            [
                'product_id' => 3,
                'user_id' => 2,
                'rating' => 5,
                'content' => 'Beautiful finish, highly recommend!',
            ],
            [
                'product_id' => 4,
                'user_id' => 1,
                'rating' => 3,
                'content' => 'Works okay, but takes time to dry.',
            ],
            [
                'product_id' => 5,
                'user_id' => 2,
                'rating' => 4,
                'content' => 'Low odor is a plus for indoor use.',
            ],
            [
                'product_id' => 6,
                'user_id' => 1,
                'rating' => 5,
                'content' => 'Perfect for outdoor projects.',
            ],
            [
                'product_id' => 7,
                'user_id' => 2,
                'rating' => 4,
                'content' => 'Easy to clean, great for kitchen.',
            ],
            [
                'product_id' => 8,
                'user_id' => 1,
                'rating' => 3,
                'content' => 'Decent primer, does the job.',
            ],
            [
                'product_id' => 9,
                'user_id' => 2,
                'rating' => 5,
                'content' => 'Unique effect, love it!',
            ],
            [
                'product_id' => 10,
                'user_id' => 1,
                'rating' => 4,
                'content' => 'Good for roof protection.',
            ],
            [
                'product_id' => 11,
                'user_id' => 2,
                'rating' => 5,
                'content' => 'Eco-friendly and high quality.',
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}

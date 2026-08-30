<?php

namespace Database\Seeders;

use App\Models\Magasin;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    public function run(): void
    {
        // Make sure we have clients to write reviews
        $clientPool = User::where('role', 'client')->where('status', 'active')->get();
        if ($clientPool->isEmpty()) {
            $this->call(ExtraUsersSeeder::class);
            $clientPool = User::where('role', 'client')->where('status', 'active')->get();
        }

        // Only review products that are NOT Product B (user-created) and belong to non-demo stores.
        $products = Product::where('name', '!=', 'Product B')
            ->whereHas('magasin.user', fn($q) => $q->where('email', '!=', 'vendor@demo.com'))
            ->get();

        if ($products->isEmpty() || $clientPool->isEmpty()) {
            return;
        }

        $reviewSnippets = [
            5 => ['Excellent product, exactly as described!', 'Highly recommend, fast shipping.', 'Top quality, will buy again.'],
            4 => ['Very good, minor packaging issue.', 'Good value for the price.', 'Satisfied overall, would recommend.'],
            3 => ['Decent product, average quality.', 'Okay for the price, nothing special.'],
            2 => ['Not quite as advertised.', 'A bit disappointed with the quality.'],
            1 => ['Poor quality, would not recommend.', 'Stopped working after a week.'],
        ];

        foreach ($products as $product) {
            // Each product gets 1-4 reviews
            $reviewCount = rand(1, 4);
            for ($i = 0; $i < $reviewCount; $i++) {
                $rate = rand(3, 5);
                $content = $reviewSnippets[$rate][array_rand($reviewSnippets[$rate])];
                $client = $clientPool->random();

                Review::create([
                    'rate' => $rate,
                    'content' => $content,
                    'user_id' => $client->id,
                    'product_id' => $product->id,
                ]);
            }

            // Update product's aggregate rate_average and rate_count
            $product->refresh();
            $reviews = $product->reviews ?? collect();
            $count = $reviews->count();
            if ($count > 0) {
                $product->rate_count = $count;
                $product->rate_average = round($reviews->avg('rate'), 2);
                $product->save();
            }
        }
    }
}

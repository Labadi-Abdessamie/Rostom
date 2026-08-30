<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Magasin;
use App\Models\Product;
use Illuminate\Database\Seeder;

class RealProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Do NOT delete categories — CategorySeeder has already created them.
        // Product B and its category/magasin are left untouched.

        // Build the category-id lookup from whatever CategorySeeder created.
        $catIds = [];
        foreach (Category::whereNull('parentId')->with('childrens')->get() as $mainCat) {
            foreach ($mainCat->childrens as $subCat) {
                $catIds[$subCat->name] = $subCat->id;
            }
        }

        // Get all stores EXCEPT vendor@demo.com so products go to other vendors.
        $otherMagasins = Magasin::whereHas('user', fn($q) => $q->where('email', '!=', 'vendor@demo.com'))
            ->where('status', 'active')
            ->get();

        // Fallback: if no other stores exist, use factory to create some.
        if ($otherMagasins->isEmpty()) {
            $this->call(StoresSeeder::class);
            $otherMagasins = Magasin::whereHas('user', fn($q) => $q->where('email', '!=', 'vendor@demo.com'))
                ->where('status', 'active')
                ->get();
        }

        // Real products with DZ market prices.
        // Each entry's 'imgs' lists the file(s) to copy into the product's folder.
        $products = [
            // Electronics
            ['name' => 'Samsung Galaxy S23', 'price' => 125000, 'category' => 'Smartphones', 'imgs' => ['product-1.png', 'mobile_1.jpg', 'mobile_2.jpg'], 'qty' => 15, 'short' => 'Latest Samsung flagship with stunning display and powerful camera.'],
            ['name' => 'Apple iPhone 15', 'price' => 148000, 'category' => 'Smartphones', 'imgs' => ['product-2.png', 'mobile_1.jpg'], 'qty' => 10, 'short' => 'iPhone 15 with Dynamic Island, USB-C, and improved camera system.'],
            ['name' => 'HP Pavilion Laptop', 'price' => 95000, 'category' => 'Laptops', 'imgs' => ['product-3.png'], 'qty' => 8, 'short' => 'Reliable everyday laptop with 16GB RAM and SSD storage.'],
            ['name' => 'Sony WH-1000XM5 Headphones', 'price' => 32000, 'category' => 'Headphones', 'imgs' => ['headphone_1.jpg', 'headphone_2.jpg'], 'qty' => 20, 'short' => 'Industry-leading noise cancellation with 30h battery life.'],
            ['name' => 'Wireless Charger Pad', 'price' => 8500, 'category' => 'Accessories', 'imgs' => ['charger_1.jpg', 'charger_2.jpg'], 'qty' => 30, 'short' => 'Fast wireless charging pad compatible with all Qi devices.'],

            // Fashion
            ['name' => 'Men Formal Blazer', 'price' => 18500, 'category' => "Men's Wear", 'imgs' => ['blazer_1.jpg', 'blazer_2.jpg'], 'qty' => 12, 'short' => 'Premium tailored blazer for formal occasions.'],
            ['name' => 'Women Casual Dress', 'price' => 9200, 'category' => "Women's Wear", 'imgs' => ['wemans_1.jpg', 'wemans_2.jpg'], 'qty' => 18, 'short' => 'Comfortable everyday dress with modern cut.'],
            ['name' => 'Nike Air Max Shoes', 'price' => 22500, 'category' => 'Shoes', 'imgs' => ['product-4.png'], 'qty' => 14, 'short' => 'Iconic Air Max cushioning with sleek design.'],
            ['name' => 'Classic Denim Jacket', 'price' => 12800, 'category' => "Men's Wear", 'imgs' => ['product-5.png'], 'qty' => 22, 'short' => 'Timeless denim jacket, perfect for any season.'],

            // Beauty
            ['name' => 'Luxury Perfume Set', 'price' => 18500, 'category' => 'Perfumes', 'imgs' => ['product-6.png'], 'qty' => 25, 'short' => 'Elegant fragrance set, ideal for gifts.'],
            ['name' => 'Organic Face Cream', 'price' => 6500, 'category' => 'Skincare', 'imgs' => ['product-7.png'], 'qty' => 40, 'short' => 'Natural ingredients for glowing, healthy skin.'],
            ['name' => 'Lipstick Collection', 'price' => 3200, 'category' => 'Makeup', 'imgs' => ['product-8.png'], 'qty' => 50, 'short' => 'Vibrant long-lasting colors for every occasion.'],

            // Home
            ['name' => 'Stainless Steel Pot Set', 'price' => 15800, 'category' => 'Kitchen', 'imgs' => ['product-9.jpg'], 'qty' => 10, 'short' => 'Durable 6-piece cookware set for everyday cooking.'],
            ['name' => 'Decorative Wall Clock', 'price' => 7200, 'category' => 'Decor', 'imgs' => ['product-10.jpg'], 'qty' => 16, 'short' => 'Modern silent wall clock for living room or office.'],
            ['name' => 'Cotton Bed Sheet Set', 'price' => 9800, 'category' => 'Bedding', 'imgs' => ['product-11.jpg'], 'qty' => 20, 'short' => 'Soft 100% cotton bed sheets, king size.'],
            ['name' => 'LED Desk Lamp', 'price' => 4500, 'category' => 'Decor', 'imgs' => ['product-12.jpg'], 'qty' => 35, 'short' => 'Adjustable LED desk lamp with USB charging port.'],
            ['name' => 'Ceramic Dinner Set', 'price' => 12500, 'category' => 'Kitchen', 'imgs' => ['product-1.png'], 'qty' => 9, 'short' => '12-piece ceramic dinnerware for family meals.'],
        ];

        // Source pool for images
        $sourcePool = glob('storage/app/public/products_images/*/*.png') ?: [];
        $sourcePool = array_merge($sourcePool, glob('storage/app/public/products_images/*/*.jpg') ?: []);
        $sourcePool = array_values(array_unique($sourcePool));

        $magasinPool = $otherMagasins->pluck('id')->toArray();
        $poolIndex = 0;

        foreach ($products as $item) {
            $magasinId = $magasinPool[$poolIndex % count($magasinPool)] ?? 1;
            $poolIndex++;

            $product = Product::create([
                'name' => $item['name'],
                'short_description' => $item['short'],
                'actual_quantity' => $item['qty'],
                'price' => $item['price'],
                'principalImage' => $item['imgs'][0],
                'category_id' => $catIds[$item['category']] ?? reset($catIds),
                'magasin_id' => $magasinId,
            ]);

            // Copy images into this product's folder
            $folder = 'storage/app/public/products_images/' . $product->id;
            if (!is_dir($folder)) {
                mkdir($folder, 0755, true);
            }
            $copied = 0;
            foreach ($item['imgs'] as $imgName) {
                $src = $this->findSourceImage($imgName, $sourcePool);
                if ($src) {
                    copy($src, $folder . '/' . $imgName);
                    $copied++;
                }
            }
            if ($copied === 0 && !empty($sourcePool)) {
                copy($sourcePool[array_rand($sourcePool)], $folder . '/' . $item['imgs'][0]);
            }

            // Refresh principalImage to whatever is actually in the folder
            $files = array_values(array_diff(scandir($folder) ?: ['.', '..'], ['.', '..']));
            if (!empty($files)) {
                $product->principalImage = $files[0];
                $product->save();
            }
        }
    }

    private function findSourceImage($name, $pool)
    {
        foreach ($pool as $path) {
            if (basename($path) === $name) {
                return $path;
            }
        }
        return null;
    }
}

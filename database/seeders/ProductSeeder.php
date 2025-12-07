<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Pastries', 'slug' => 'pastries', 'description' => 'Fresh baked pastries and breads'],
            ['name' => 'Beverages', 'slug' => 'beverages', 'description' => 'Hot and cold drinks'],
            ['name' => 'Prepared Foods', 'slug' => 'prepared-foods', 'description' => 'Ready-to-eat meals and sides'],
            ['name' => 'Desserts', 'slug' => 'desserts', 'description' => 'Sweet treats and cakes'],
            ['name' => 'Specialty Items', 'slug' => 'specialty-items', 'description' => 'Special imported and local items'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name'], 'description' => $category['description']]
            );
        }

        // Create brands
        $brands = [
            ['name' => 'Istanbul House', 'slug' => 'istanbul-house', 'description' => 'Our signature house brand'],
            ['name' => 'Gourmet Selection', 'slug' => 'gourmet-selection', 'description' => 'Premium imported selections'],
            ['name' => 'Local Artisan', 'slug' => 'local-artisan', 'description' => 'Local artisan partners'],
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(
                ['slug' => $brand['slug']],
                ['name' => $brand['name'], 'description' => $brand['description']]
            );
        }

        // Get category and brand IDs
        $pastries = Category::where('slug', 'pastries')->first();
        $beverages = Category::where('slug', 'beverages')->first();
        $prepared = Category::where('slug', 'prepared-foods')->first();
        $desserts = Category::where('slug', 'desserts')->first();
        $specialty = Category::where('slug', 'specialty-items')->first();

        $house = Brand::where('slug', 'istanbul-house')->first();
        $gourmet = Brand::where('slug', 'gourmet-selection')->first();
        $artisan = Brand::where('slug', 'local-artisan')->first();

        // Create sample products
        $products = [
            // Pastries
            [
                'name' => 'Spinach and Cheese Borek',
                'category_id' => $pastries->id,
                'brand_id' => $house->id,
                'price' => 8.99,
                'short_description' => 'Crispy phyllo pastry filled with fresh spinach and creamy cheese',
                'description' => 'Traditional Turkish borek made with layers of thin phyllo dough, fresh spinach, and a blend of cheeses. Baked until golden and served warm.',
                'stock' => 15,
            ],
            [
                'name' => 'Meat Borek',
                'category_id' => $pastries->id,
                'brand_id' => $house->id,
                'price' => 9.99,
                'short_description' => 'Golden pastry with spiced meat filling',
                'description' => 'Flaky phyllo pastry wrapped around seasoned ground lamb and beef with onions and herbs.',
                'stock' => 12,
            ],
            [
                'name' => 'Baklava Assortment',
                'category_id' => $pastries->id,
                'brand_id' => $gourmet->id,
                'price' => 14.99,
                'short_description' => 'Mix of pistachios, walnuts, and honey-soaked pastries',
                'description' => 'Premium selection of baklava varieties including pistachio, walnut, and cashew, each drizzled with aromatic honey and orange blossom water.',
                'stock' => 20,
            ],

            // Beverages
            [
                'name' => 'Turkish Coffee (1lb)',
                'category_id' => $beverages->id,
                'brand_id' => $gourmet->id,
                'price' => 12.99,
                'short_description' => 'Finely ground traditional Turkish coffee',
                'description' => 'Premium, extra-fine ground Turkish coffee. Perfect for preparing traditional Turkish coffee in a cezve. Authentic taste and rich aroma.',
                'stock' => 25,
            ],
            [
                'name' => 'Turkish Tea Blend',
                'category_id' => $beverages->id,
                'brand_id' => $house->id,
                'price' => 7.99,
                'short_description' => 'Special blend of black tea with dried fruits',
                'description' => 'Signature Turkish tea blend with hints of apple, rose hips, and orange peel. Serves 50+ cups per box.',
                'stock' => 30,
            ],
            [
                'name' => 'Pomegranate Juice (1L)',
                'category_id' => $beverages->id,
                'brand_id' => $artisan->id,
                'price' => 6.99,
                'short_description' => 'Fresh pomegranate juice, no added sugar',
                'description' => 'Pure pomegranate juice from local orchards. No added sugar or preservatives. Refreshing and packed with antioxidants.',
                'stock' => 18,
            ],

            // Prepared Foods
            [
                'name' => 'Homemade Hummus',
                'category_id' => $prepared->id,
                'brand_id' => $house->id,
                'price' => 5.99,
                'short_description' => 'Creamy chickpea dip with tahini and lemon',
                'description' => 'Made fresh daily with premium chickpeas, tahini, olive oil, and fresh lemon juice. Perfect for dipping or spreading.',
                'stock' => 16,
            ],
            [
                'name' => 'Stuffed Grape Leaves',
                'category_id' => $prepared->id,
                'brand_id' => $house->id,
                'price' => 7.49,
                'short_description' => 'Tender grape leaves wrapped with rice and herbs',
                'description' => 'Dolmas: tender grape leaves from our supplier, hand-rolled with jasmine rice, fresh herbs, and a touch of lemon. Served cold.',
                'stock' => 14,
            ],
            [
                'name' => 'Spiced Chickpea Salad',
                'category_id' => $prepared->id,
                'brand_id' => $artisan->id,
                'price' => 6.49,
                'short_description' => 'Mediterranean chickpea salad with fresh vegetables',
                'description' => 'Roasted chickpeas mixed with cucumber, tomato, red onion, parsley, and a tangy vinaigrette. Ready to serve.',
                'stock' => 19,
            ],

            // Desserts
            [
                'name' => 'Honey Cake',
                'category_id' => $desserts->id,
                'brand_id' => $house->id,
                'price' => 4.99,
                'short_description' => 'Moist honey cake with layers of walnuts',
                'description' => 'Traditional honey cake soaked in honey syrup with layers of crushed walnuts and warming spices. Perfect with tea or coffee.',
                'stock' => 22,
            ],
            [
                'name' => 'Pistachio Turkish Delight',
                'category_id' => $desserts->id,
                'brand_id' => $gourmet->id,
                'price' => 11.99,
                'short_description' => 'Premium Turkish delight with crushed pistachios',
                'description' => 'Silky Turkish delight (Lokum) made with real pistachios, rose water, and dusted with powdered sugar. 1lb box.',
                'stock' => 17,
            ],
            [
                'name' => 'Date and Walnut Cookies',
                'category_id' => $desserts->id,
                'brand_id' => $artisan->id,
                'price' => 6.99,
                'short_description' => 'Soft cookies filled with dates and walnuts',
                'description' => 'Handmade cookies with a tender crumb, filled with Medjool dates and roasted walnuts. Perfect for snacking.',
                'stock' => 28,
            ],

            // Specialty Items
            [
                'name' => 'Za\'atar Spice Blend',
                'category_id' => $specialty->id,
                'brand_id' => $gourmet->id,
                'price' => 8.99,
                'short_description' => 'Traditional Middle Eastern herb and spice mix',
                'description' => 'Blend of thyme, sumac, sesame seeds, and salt. Perfect for breads, salads, and dips. 3 oz bag.',
                'stock' => 24,
            ],
            [
                'name' => 'Pomegranate Molasses',
                'category_id' => $specialty->id,
                'brand_id' => $gourmet->id,
                'price' => 9.99,
                'short_description' => 'Tangy reduction of pomegranate juice',
                'description' => 'Thick, tart pomegranate reduction. Essential ingredient in Middle Eastern cooking. Adds depth to sauces and dressings.',
                'stock' => 13,
            ],
            [
                'name' => 'Rose Water (8 oz)',
                'category_id' => $specialty->id,
                'brand_id' => $gourmet->id,
                'price' => 10.99,
                'short_description' => 'Premium rose water for culinary use',
                'description' => 'Pure, food-grade rose water distilled from rose petals. Used in Middle Eastern and South Asian cooking and desserts.',
                'stock' => 20,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['name' => $product['name']],
                array_merge($product, [
                    'slug' => Str::slug($product['name'] . '-' . Str::random(4)),
                    'sku' => strtoupper(Str::random(6)),
                    'currency' => 'CAD',
                    'track_inventory' => true,
                    'is_active' => true,
                    'price_cents' => (int) round($product['price'] * 100),
                ])
            );
        }
    }
}

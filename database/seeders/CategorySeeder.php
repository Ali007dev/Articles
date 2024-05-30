<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'politic', 'sub_categories' => ['Asia', 'Africa']],
            ['id' => 2, 'name' => 'economy', 'sub_categories' => ['Crypto', 'Banking']],
            ['id' => 3, 'name' => 'sport', 'sub_categories' => ['Football', 'Basketball']],
            ['id' => 4, 'name' => 'technology', 'sub_categories' => ['AI', 'Cybersecurity']],
            ['id' => 5, 'name' => 'entertainment', 'sub_categories' => ['Movies', 'Music']],
            ['id' => 6, 'name' => 'science and Health', 'sub_categories' => ['Physics', 'Medicine']],
            ['id' => 7, 'name' => 'society', 'sub_categories' => ['Demographics', 'Sociology']],
            ['id' => 8, 'name' => 'environment and Nature', 'sub_categories' => ['Ecology', 'Climate']],
            ['id' => 9, 'name' => 'business', 'sub_categories' => ['Management', 'Entrepreneurship']],
            ['id' => 10, 'name' => 'world News', 'sub_categories' => ['International Politics', 'Global Economy']],
            ['id' => 11, 'name' => 'local News', 'sub_categories' => ['City', 'Regional']],
            ['id' => 12, 'name' => 'lifestyle', 'sub_categories' => ['Health', 'Fashion']],
            ['id' => 13, 'name' => 'travel', 'sub_categories' => ['Destinations', 'Tourism']],
            ['id' => 14, 'name' => 'automotive', 'sub_categories' => ['Cars', 'Motorcycles']],
            ['id' => 15, 'name' => 'fashion and Beauty', 'sub_categories' => ['Trends', 'Cosmetics']],
            ['id' => 16, 'name' => 'food and Dining', 'sub_categories' => ['Cuisine', 'Restaurants']],
            ['id' => 17, 'name' => 'education', 'sub_categories' => ['Schools', 'Universities']],
            ['id' => 18, 'name' => 'media and Streaming', 'sub_categories' => ['TV', 'Streaming']],
            ['id' => 19, 'name' => 'gaming', 'sub_categories' => ['Video Games', 'Esports']],
            ['id' => 20, 'name' => 'human Interest', 'sub_categories' => ['Inspirational', 'Quirky']]
        ];

        foreach ($categories as $category) {
            $mainCategory = Category::create([
                'id' => $category['id'],
                'name' => $category['name']
            ]);

            foreach ($category['sub_categories'] as $subCategoryName) {
                SubCategory::create([
                    'name' => $subCategoryName,
                    'category_id' => $mainCategory->id
                ]);
            }
        }
    }

}

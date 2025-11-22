<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Music', 'description' => 'Concerts, festivals, and music events'],
            ['name' => 'Sports', 'description' => 'Sporting events and competitions'],
            ['name' => 'Technology', 'description' => 'Tech conferences and workshops'],
            ['name' => 'Business', 'description' => 'Business seminars and networking'],
            ['name' => 'Art & Culture', 'description' => 'Art exhibitions and cultural events'],
            ['name' => 'Food & Drink', 'description' => 'Food festivals and culinary events'],
            ['name' => 'Education', 'description' => 'Educational workshops and seminars'],
            ['name' => 'Entertainment', 'description' => 'Comedy, theater, and shows'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ Categories seeded successfully!');
    }
}
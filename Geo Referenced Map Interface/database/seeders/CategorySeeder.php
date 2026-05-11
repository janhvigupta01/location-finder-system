<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default categories
        $categories = [
            'Hospital',
            'School',
            'Tourist Place',
            'Restaurant',
            'Office',
            'Park',
            'Library',
            'Museum',
            'Shopping Mall',
            'Other',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['category_name' => $category]);
        }
    }
}

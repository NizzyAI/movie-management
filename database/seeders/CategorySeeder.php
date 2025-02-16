<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder {
    public function run() {
        $categories = ['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi', 'Thriller', 'War', 'Fantasy', 'Animation'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}

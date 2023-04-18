<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuCategory;

class MenuCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Entrada'],
            ['name' => 'Prato Principal'],
            ['name' => 'Sobremesa'],
            ['name' => 'Happy Hour'],
        ];

        foreach ($categories as $category) {
            MenuCategory::create($category);
        }
    }
}
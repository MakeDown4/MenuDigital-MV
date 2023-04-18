<?php

namespace Database\Seeders;

use App\Models\MenuCategory;
use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $categories = MenuCategory::all();
    
        // Cria 50 itens de menu aleatórios com o category_id definido
        $menuItems = [];
        for ($i = 0; $i < 50; $i++) {
            $categoryId = $categories->random()->id;
            $menuItems[] = [
                'name' => $faker->word(),
                'description' => $faker->sentence(),
                'price' => $faker->randomFloat(2, 10, 50),
                'category_id' => $categoryId,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        MenuItem::insert($menuItems);
    
        // Atualiza os itens de menu existentes com o category_id
        $randomCategoryIds = $categories->pluck('id')->shuffle();
        MenuItem::whereNull('category_id')->chunk(350, function ($items) use ($randomCategoryIds) {
            foreach ($items as $item) {
                $item->category_id = $randomCategoryIds->pop();
                $item->save();
            }
        });
    }    
}
<?php

namespace Database\Seeders;

use App\Models\RecipeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::deleteDirectory('public/recipes_category');

        if (!Storage::exists('public/recipes_category')) {
            Storage::makeDirectory('public/recipes_category');
        }
        $categories = [
            [
                'name' => 'Dessert',
                'image' => $this->storeImage('dessert.jpeg')
            ],
            [
                'name' => 'International Food',
                'image' => $this->storeImage('internasional_food.jpeg')
            ],
            [
                'name' => 'Traditional Food',
                'image' => $this->storeImage('tradisional.jpeg')
            ],
            [
                'name' => 'Vegetarian food',
                'image' => $this->storeImage('vegetarian.jpeg')
            ],
            [
                'name' => 'Main Course',
                'image' => $this->storeImage('utama.jpeg')
            ],
            [
                'name' => 'Snacks',
                'image' => $this->storeImage('ringan.jpeg')
            ],
            [
                'name' => 'Drinks',
                'image' => $this->storeImage('minuman.jpeg')
            ],
            [
                'name' => 'Fast Food',
                'image' => $this->storeImage('cepatsaji.jpeg')
            ],
        ];

        foreach ($categories as $category) {
            RecipeCategory::create($category);
        }
    }

    private function storeImage($filename)
    {
        $sourcePath = database_path('seeders/images/' . $filename);

        Storage::putFileAs(
            'public/recipes_category',
            $sourcePath,
            $filename
        );

        return 'recipes_category/' . $filename;
    }
}

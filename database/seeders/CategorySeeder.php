<?php

namespace Database\Seeders;

use App\Models\RecipeCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $folderPath = 'public/recipeCategory';
        if (!Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->makeDirectory($folderPath);
            $this->command->info("Folder '{$folderPath}' berhasil dibuat.");
        } else {
            $this->command->info("Folder '{$folderPath}' sudah ada.");
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
        if (!file_exists($sourcePath)) {
            $this->command->error("File gambar sumber tidak ditemukan: {$sourcePath}");
            return null;
        }
        $disk = Storage::disk('public');
        $destinationFolder = 'recipeCategory';
        $disk->put($destinationFolder . '/' . $filename, file_get_contents($sourcePath));
        return $destinationFolder . '/' . $filename;
    }
}

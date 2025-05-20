<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            'Hematologia', 'Biochemia', 'Hormony', 'Mocz', 'Kał', 'Wirusologia',
            'Immunologia', 'Onkologia', 'Diagnostyka ogólna', 'Alergologia'
        ])->map(fn($name) => Category::create(['name' => $name]));

        Product::factory(50)->create()->each(function ($test) use ($categories) {
            $randomCategories = $categories->random(rand(2, 4))->pluck('id');
            $test->categories()->attach($randomCategories);
        });
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Define the number of recipes you want to create
         $numberOfRecipes = 1;

         // Create fake recipes and associate them with a specific category
         Recipe::factory()->count($numberOfRecipes)->create(['user_id' => 1])->each(function ($recipe) {
             // Get a random category ID or set it to 0 for no category
             $categoryId = rand(1, Category::count()) ?: 0;
             
             // Attach the category to the recipe through the pivot table
             $recipe->categories()->attach($categoryId);
         });
    }
}

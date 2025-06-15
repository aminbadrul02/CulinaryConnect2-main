<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MalaysianRecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Malaysian cuisine category if it doesn't exist
        $malaysianCategory = Category::firstOrCreate(['name' => 'Malaysian']);
        
        // Get a user for the recipes
        $user = User::first() ?? User::factory()->create();
        
        // Malaysian recipes with simple image names
        $recipes = [
            [
                'name' => 'Nasi Lemak',
                'ingredients' => "2 cups jasmine rice\n1 cup coconut milk\n2 cups water\n2 pandan leaves, knotted\n1 teaspoon salt\n\nFor sambal:\n10 dried red chilies\n1 onion, sliced\n3 cloves garlic\n1 teaspoon belacan (shrimp paste)\n2 tablespoons oil\n1 tablespoon tamarind juice\n1 teaspoon sugar\n\nServe with:\nCucumber slices\nHard-boiled eggs\nFried anchovies\nRoasted peanuts",
                'instructions' => "1. Rinse rice until water runs clear, then drain.\n2. In a rice cooker, add rice, coconut milk, water, salt, and pandan leaves.\n3. Cook rice until done, about 20-25 minutes.\n\nFor sambal:\n1. Soak dried chilies in hot water for 10 minutes, then drain and blend with onion, garlic, and belacan.\n2. Heat oil in a pan and stir-fry the blended ingredients until fragrant.\n3. Add tamarind juice and sugar, cooking until oil separates.\n\nServe rice with sambal, cucumber slices, hard-boiled eggs, fried anchovies, and roasted peanuts.",
                'cooking_time' => 45,
                'difficulty' => 'Medium',
                'cuisine_type' => 'Malaysian',
                'image_path' => 'nasi_lemak.jpg',
            ],
            [
                'name' => 'Roti Canai',
                'ingredients' => "3 cups all-purpose flour\n1 teaspoon salt\n1 tablespoon sugar\n1/2 cup ghee or clarified butter\n1 egg\n3/4 cup warm water\nExtra ghee for cooking",
                'instructions' => "1. Mix flour, salt, and sugar in a bowl.\n2. Add ghee and egg, then gradually add warm water until a soft dough forms.\n3. Knead for 5 minutes until smooth and elastic.\n4. Divide into 8 balls, coat with oil, and let rest for at least 6 hours or overnight.\n5. On an oiled surface, flatten each ball, stretch and fold repeatedly until very thin.\n6. Heat a skillet, add a little ghee, and cook the roti until golden brown on both sides.\n7. Clap the roti between your hands to separate the layers before serving.",
                'cooking_time' => 30,
                'difficulty' => 'Hard',
                'cuisine_type' => 'Malaysian',
                'image_path' => 'roti_canai.jpg',
            ],
            [
                'name' => 'Laksa',
                'ingredients' => "200g rice noodles\n500ml chicken stock\n400ml coconut milk\n2 tablespoons laksa paste\n200g chicken breast, sliced\n200g prawns, peeled\n100g tofu puffs\n2 eggs, hard-boiled and halved\nBean sprouts\nMint leaves\nLime wedges\nSliced red chili",
                'instructions' => "1. Cook rice noodles according to package instructions, then drain and set aside.\n2. In a large pot, bring chicken stock to a boil.\n3. Add laksa paste and simmer for 2 minutes.\n4. Add coconut milk and bring to a gentle simmer.\n5. Add chicken and cook for 5 minutes, then add prawns and cook for 2 more minutes.\n6. Add tofu puffs and warm through.\n7. To serve, place noodles in bowls, ladle over the soup and top with eggs, bean sprouts, mint leaves, lime wedges, and sliced chili.",
                'cooking_time' => 40,
                'difficulty' => 'Medium',
                'cuisine_type' => 'Malaysian',
                'image_path' => 'laksa.jpg',
            ],
            [
                'name' => 'Satay',
                'ingredients' => "500g chicken thighs, cut into strips\n\nFor marinade:\n3 tablespoons lemongrass, finely chopped\n2 shallots, minced\n2 cloves garlic, minced\n1 tablespoon ground coriander\n1 teaspoon ground turmeric\n1 tablespoon ground cumin\n2 tablespoons brown sugar\n2 tablespoons vegetable oil\n2 tablespoons soy sauce\n\nFor peanut sauce:\n1 cup roasted peanuts, ground\n1 tablespoon tamarind paste\n1 tablespoon palm sugar\n1 teaspoon chili paste\n400ml coconut milk\nSalt to taste",
                'instructions' => "1. Combine all marinade ingredients in a bowl and mix well.\n2. Add chicken strips and marinate for at least 2 hours, or overnight for best flavor.\n3. Thread marinated chicken onto bamboo skewers (soaked in water for 30 minutes).\n4. Grill skewers over medium-high heat for 3-4 minutes each side until charred and cooked through.\n\nFor peanut sauce:\n1. In a saucepan, mix ground peanuts, tamarind paste, palm sugar, and chili paste.\n2. Add coconut milk gradually while stirring.\n3. Bring to a simmer and cook for 5-10 minutes until thickened.\n4. Season with salt to taste.\n\nServe satay with peanut sauce, cucumber slices, and rice cakes.",
                'cooking_time' => 60,
                'difficulty' => 'Medium',
                'cuisine_type' => 'Malaysian',
                'image_path' => 'satay.jpg',
            ],
            [
                'name' => 'Rendang',
                'ingredients' => "1kg beef chuck, cut into 3cm cubes\n5 tablespoons cooking oil\n1 cinnamon stick\n3 cloves\n3 star anise\n3 cardamom pods\n1 lemongrass stalk, bruised\n1 cup coconut milk\n1 cup water\n2 teaspoons tamarind paste\n5 kaffir lime leaves\n1 tablespoon palm sugar\nSalt to taste\n\nSpice paste:\n12 dried chilies, soaked in warm water\n5 shallots\n3 cloves garlic\n5cm piece ginger\n5cm piece galangal\n5cm piece turmeric root (or 1 tablespoon powder)",
                'instructions' => "1. Blend all spice paste ingredients in a food processor until smooth.\n2. Heat oil in a large pot over medium heat. Add cinnamon, cloves, star anise, and cardamom. Stir until fragrant.\n3. Add the spice paste and lemongrass, cooking until the paste darkens and oil separates.\n4. Add beef, stirring to coat with the spices.\n5. Add coconut milk, water, tamarind paste, and bring to a boil.\n6. Reduce heat to low, add kaffir lime leaves, and simmer uncovered for 2-3 hours, stirring occasionally.\n7. When meat is tender and sauce has thickened, add salt and palm sugar to taste.\n8. The rendang is ready when the meat is dark brown and the sauce has mostly been absorbed.\n9. Serve with steamed rice.",
                'cooking_time' => 180,
                'difficulty' => 'Hard',
                'cuisine_type' => 'Malaysian',
                'image_path' => 'rendang.jpg',
            ]
        ];
        
        foreach ($recipes as $recipeData) {
            // Create the recipe with the simple image path
            $recipe = Recipe::create([
                'user_id' => $user->id,
                'name' => $recipeData['name'],
                'ingredients' => $recipeData['ingredients'],
                'instructions' => $recipeData['instructions'],
                'cooking_time' => $recipeData['cooking_time'],
                'difficulty' => $recipeData['difficulty'],
                'cuisine_type' => $recipeData['cuisine_type'],
                'image_path' => $recipeData['image_path'],
            ]);
            
            // Attach the Malaysian category
            $recipe->categories()->attach($malaysianCategory->id);
            
            $this->command->info("Recipe '{$recipeData['name']}' created with image: {$recipeData['image_path']}");
        }
    }
}
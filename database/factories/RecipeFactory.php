<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'image_path'=>$this->faker->imageUrl(),
            'cooking_time' => $this->faker->numberBetween(10, 120),
            'instructions' => $this->faker->paragraph,
            'cuisine_type' => $this->faker->randomElement(['Italian', 'Mexican', 'Chinese', 'Indian', 'French', 'Japanese']),
            'ingredients' => $this->faker->text,
        ];
    }
}
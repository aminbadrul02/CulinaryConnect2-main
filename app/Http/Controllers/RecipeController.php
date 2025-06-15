<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use App\Notifications\NewRecipeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;


class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $allRecipes = Recipe::with('categories')->get(); // load related categories
    $allCategories = Category::all();    // load all categories
    return view('recipes', compact('allRecipes', 'allCategories'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
    
        // Check if there are no categories available
        if ($categories->isEmpty()) {
            // Redirect the user to a page for creating a new category
            return redirect()->route('create-category')->with('warning', 'Please create a category first cz you r the first user that will add a recipe.');
        }
    
        // Render the view with the add recipe form
        return view('recipes.addRecipeForm', compact('categories'));
    }
    

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request) // done
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required',
            'ingredients' => 'required',
            'cooking_time' => 'required',
            'cuisine_type' => 'required',
            'instructions' => 'required',
            'difficulty' => 'required',
            'image' => 'required|image|max:2048', // Assuming image size limit is 2MB
            'categories' => 'required|array|min:1', // At least one category must be selected
            'categories.*' => 'exists:categories,id', // Ensure each category exists in the categories table
        ]);
    
        // Store the image
        // Generate a unique name for the file to prevent conflicts
        $new_image_name = uniqid().'-'.time().'.'.$request->image->extension();      
        // If the image was successfully stored, update the user's image_path
    
        // Create the recipe
        $recipe = Recipe::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'ingredients' => $request->ingredients,
            'cooking_time' => $request->cooking_time,
            'cuisine_type' => $request->cuisine_type,
            'instructions' => $request->instructions,
            'difficulty' => $request->difficulty,
            'image_path' => $new_image_name,
        ]);
        $request->image->move(public_path('uploaded_img_recipes'),$new_image_name);
    
        // Attach categories to the recipe
        $recipe->categories()->attach($request->categories);
        // Notify users about the new recipe
        $newRecipe = $recipe; // Assuming $recipe is the newly created recipe object
        Notification::send(User::all(), new NewRecipeNotification($newRecipe));
    
        // Redirect to a success page or back to the form with a success message
        return redirect()->route('index')->with('success', 'Recipe created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $recipe = Recipe::findOrFail($id);
        if(!$recipe){
            return redirect()->back();
        }
        return view('recipes.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $recipe = Recipe::findOrFail($id);
        if(!$recipe){
            return redirect()->back();
        }
        $categories = Category::all();
        return view('recipes.edit', compact('recipe' ,'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       
        // Validate the request data
        $request->validate([
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming image is optional, adjust validation rules as needed
            'ingredients' => 'required',
            'categories' => 'required|array',
            'cooking_time' => 'required',
            'cuisine_type' => 'required',
            'instructions' => 'required',
            'difficulty' => 'required',
        ]);

        // Find the recipe by ID
        $recipe = Recipe::findOrFail($id);
        // Check if the authenticated user owns the recipe
        if (auth()->user()->id !== $recipe->user_id) {
            return redirect()->back()->with('error', 'You do not have permission to update this recipe.');
        }

        // Update recipe details
        $recipe->name = $request->name;
        $recipe->ingredients = $request->ingredients;
        $recipe->cooking_time = $request->cooking_time;
        $recipe->cuisine_type = $request->cuisine_type;
        $recipe->instructions = $request->instructions;
        $recipe->difficulty = $request->difficulty;

        // Update image if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($recipe->image_path) {
                Storage::delete('public/uploaded_img_recipes/' . $recipe->image_path);
            }

            // Store new image
            $new_image_name = uniqid().'-'.time().'.'.$request->image->extension();      
            $recipe->image_path = $new_image_name;
            $request->image->move(public_path('uploaded_img_recipes'),$new_image_name);

        }

        // Sync categories
        $recipe->categories()->sync($request->categories);

        // Save the recipe
        $recipe->save();
        

        // Redirect back with success message
        return redirect()->back()->with('success', 'Recipe updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        // Check if the authenticated user owns the recipe
        if (auth()->user()->id !== $recipe->user->id) {
            return redirect()->back()->with('error', 'You do not have permission to delete this recipe.');
        }

        // Delete the associated records in the pivot table (recipe_category)
        $recipe->categories()->detach();

        // Delete the recipe
        $recipe->delete();
        Storage::delete('public/uploaded_img_recipes/' . $recipe->image_path);


        // Redirect back with a success message
        return redirect()->route('myProfile')->with('success', 'Recipe deleted successfully.');
    }
}

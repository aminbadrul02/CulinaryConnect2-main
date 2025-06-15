<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $ratedRecipes =Recipe::join('recipe_ratings', 'recipes.id', '=', 'recipe_ratings.recipe_id')
        ->select('recipes.id', 'recipes.user_id', 'recipes.name' ,'recipes.image_path', DB::raw('AVG(recipe_ratings.rating) as average_rating'))
        ->groupBy('recipes.id', 'recipes.user_id', 'recipes.name', 'recipes.image_path')
        ->orderByDesc('average_rating')
        ->get();
        //dd($ratedRecipes);
        return view('rating.index' , compact('ratedRecipes'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'rating' => 'required|integer|min:1|max:100',
        ]);

        // Get the user's ID from the authenticated user
        $userId = auth()->id();

        // Check if the user has already rated the recipe
        $existingRating = Rating::where('user_id', $userId)
                                ->where('recipe_id', $request->get('recipe_id'))
                                ->first();

        // If the user has already rated the recipe, update the rating
        if ($existingRating) {
            $existingRating->rating = $request->input('rating');
            $existingRating->save();
            return redirect()->back()->with('success', 'Rating updated successfully.');
        } else {
            // If the user hasn't rated the recipe yet, create a new rating record
            Rating::create([
                'user_id' => $userId,
                'recipe_id' => $request->get('recipe_id'),
                'rating' => $request->input('rating'),
            ]);
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Rating saved successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the recipe with its ratings count and average rating
        $recipe = Recipe::withCount('ratings')
            ->with(['ratings' => function ($query) {
                $query->select('recipe_id', DB::raw('AVG(rating) as average_rating'))
                    ->groupBy('recipe_id');
            }])
            ->findOrFail($id);
    
        // Calculate the average rating or set it to 0 if no ratings exist
        $averageRating = $recipe->ratings->isEmpty() ? 0 : $recipe->ratings->first()->average_rating;
    
        // Retrieve all the ratings associated with the recipe
        $allRecipeRatings = $recipe->ratings()->get();

        // Dump and die to inspect the ratings
        //dd($allRecipeRatings[0]->user()->get());
    
        // Return the view with the recipe details, average rating, and all ratings
        return view('rating.show', compact('recipe', 'averageRating', 'allRecipeRatings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

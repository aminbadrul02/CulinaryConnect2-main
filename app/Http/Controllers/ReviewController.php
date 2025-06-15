<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Validate the request data
        $request->validate([
            'review_text' => 'required',
        ]);
        
        // Create a new review
        $review = new Review();
        $review->review_text = $request->input('review_text');
        $review->user_id = auth()->user()->id; // Assuming the user is authenticated
        $review->recipe_id = $request->input('recipe_id');
        $review->save();


        return redirect()->route('recipeReview' , ['id' => $request->input('recipe_id')])->with('success', 'Review added successfully.');
        
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Query to retrieve reviews for a specific recipe
        $reviews = DB::table('recipe_reviews')
            ->join('users', 'recipe_reviews.user_id', '=', 'users.id')
            ->select('recipe_reviews.*', 'users.name as reviewer_name')
            ->where('recipe_reviews.recipe_id', $id)
            ->orderBy('recipe_reviews.created_at', 'desc')
            ->get();
        //dd($reviews);
        $recipe = Recipe::findOrFail($id);
        //dd($reviews);

        return view('reviews.show' , compact('recipe', 'reviews'));
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

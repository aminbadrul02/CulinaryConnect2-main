<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
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
        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'recipe_id' => 'required|exists:recipes,id',
        ]);
    
        // Check if the favorite already exists for the user and recipe
        $existingFavorite = Favorite::where('user_id', $request->user_id)
            ->where('recipe_id', $request->recipe_id)
            ->first();
    
        if ($existingFavorite) {
            // If the favorite already exists, delete it
            $existingFavorite->delete();
            return redirect()->back()->with('message', 'Favorite deleted successfully for this recipe ^_^');
        }
    
        // Create a new favorite
        $favorite = Favorite::create([
            'user_id' => $request->user_id,
            'recipe_id' => $request->recipe_id,
        ]);
    
        // Return a success response
        return redirect()->back()->with('message', 'Favorite added successfully for this recipe ^_^');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

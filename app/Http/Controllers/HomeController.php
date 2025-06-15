<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
public function index()
{
    $allCategories = Category::all();
    // other logic (e.g. loading recipes)
    return view('home', compact('allCategories'));
}

    public function search(Request $request) //done
    {
        $query = Recipe::query();
        //dd($request->all());
        if ($request->filled('category') && $request->category != '') {
            $query->join('recipe_category', 'recipes.id', '=', 'recipe_category.recipe_id')
            ->join('categories', 'recipe_category.category_id', '=', 'categories.id')
            ->select('recipes.*', 'categories.name as category_name')
            ->where('recipe_category.category_id', $request->category);

        }

        if ($request->filled('cuisine_type') && $request->cuisine_type != '') {
            $query->where('cuisine_type','like', '%' . $request->cuisine_type . '%');
        }

        if ($request->filled('ingredients') && $request->ingredients != '') {
            $query->where('ingredients', 'like', '%' . $request->ingredients . '%');
        }

        if ($request->filled('cooking_time') && $request->cooking_time != '') {
            if ($request->cooking_time == 30) {
                $query->where('cooking_time', '<', 30);
            }
            elseif ($request->cooking_time == 60) {
                $query->where('cooking_time', '>', 60);
            }
            // Otherwise, filter recipes with cooking_time between 30 and 60
            else {
                $query->whereBetween('cooking_time', [30, 60]);
            }
        }
        if ($request->filled('level') && $request->level != '') {
            $query->where('difficulty', $request->level);
        }

        $filteredRecipes = $query->get();
        $allRecipes = $filteredRecipes;
        $allCategories = Category::all();
        //dd($filteredRecipes->toArray());

        return view('home', compact('allRecipes', 'allCategories'));
    }
    public function favorite()//done
    {
        $user = auth()->user();

        // Fetch all favorite recipes for the user
        $favoriteRecipes = $user->favorites;
        $allRecipes = $favoriteRecipes;

        $allCategories = Category::all();

        return view('home', compact('allRecipes', 'allCategories'));
    }

}

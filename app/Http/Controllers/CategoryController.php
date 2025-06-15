<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
    $AllCategories = Category::all(); // This variable goes to the Blade view
    return view('recipes.addCategory', compact('AllCategories'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'categoryName' => 'required'
        ]);
    
        // Check if a category with the same name already exists
        $categoryWithSameName = Category::where('name', $request->input('categoryName'))->first();
    
        if ($categoryWithSameName) {
            return redirect()->route('add-category')->with('danger', 'A category with the same name already exists.');
        }
    
        // Create a new category if it doesn't already exist
        Category::create([
            'name' => $request->input('categoryName')
        ]);

        $categories = Category::all();
        $success = true;
        return redirect()->route('showForm')->with(['categories' => $categories]);

    }
    
    

    /**
     * Display the specified resource.
     */
public function show($id)
{
    $category = Category::findOrFail($id);
    $recipes = $category->recipes()->latest()->get(); // You can modify sorting

    return view('category.show', compact('category', 'recipes'));
}


    /**
     * Show the form for editing the specified resource.
     */
 public function edit($id)
{
    $category = Category::findOrFail($id);
    return view('recipes.editCategory', compact('category'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'categoryName' => 'required|string|max:255'
    ]);

    $category = Category::findOrFail($id);
    $category->name = $request->categoryName;
    $category->save();

    return redirect()->route('create-category')->with('success', 'Category updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $category = Category::findOrFail($id);
    
    // Optional: check if the category has recipes and handle accordingly
    if ($category->recipes()->exists()) {
        return redirect()->back()->with('error', 'Cannot delete category with associated recipes.');
    }

    $category->delete();

    return redirect()->back()->with('success', 'Category deleted successfully.');
}
}

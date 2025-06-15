<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Models\Recipe;
use App\Models\User;
use App\Notifications\NewRecipeNotification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

Route::prefix('/')->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::post('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/favorites' ,[HomeController::class , 'favorite'])->middleware('auth')->name('favorites');// fetching favorite recipes
});


Route::prefix('/profile')->middleware('auth')->group(function(){
    Route::get('/', [UserController::class , 'index'])->name('myProfile');
    Route::get('/edit/{id}' , [UserController::class , 'edit'])->name('edit_profile');
    Route::post('/update/{id}' , [UserController::class , 'update'])->name('updateprofile');
    Route::post('/updateprofilePrivacy/{id}', [UserController::class, 'updateprofilePrivacy'])->name('updateprofilePrivacy');

});
Route::get('profile/{id}', [UserController::class , 'show'])->name('ownerProfile'); // for other users 

//! TODO : routes for recipes 
Route::get('/recipe/{id}' , [RecipeController::class , 'show'])->name('showRecipe');;

Route::prefix('/recipe')->middleware('auth')->group(function(){
    Route::get('/',[RecipeController::class , 'create'])->name('showForm');//showing form for creating a new recipe
    Route::post('/' ,[RecipeController::class, 'store'])->name('addrecipe');//adding recipe
    Route::delete('/{recipe}',[RecipeController::class , 'destroy'])->name('destroyRecipe');//delete recipes
    Route::get('/form/{id}' , [RecipeController::class , 'edit'])->name('showEditingFormForRecipe');//update recipe
    Route::put('/{id}' ,[RecipeController::class , 'update'])->name('updatingRecipe');//update editing recipe
    //fetching recipes already done in the home controller 
});

Route::prefix('/category')->middleware('auth')->group(function () {
    Route::get('/', [CategoryController::class, 'create'])->name('create-category'); // Show form
    Route::post('/', [CategoryController::class, 'store'])->name('add-category'); // Add
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('edit-category');
Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('update-category');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('delete-category'); // Delete
    Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show'); // Public view
});

Route::prefix('/favorite')->middleware('auth')->group(function (){
    Route::post('/' , [FavoriteController::class , 'store'])->name('favorite'); //create new category
});

// for rating 
Route::get('/rated' , [RatingController::class , 'index'])->name('rated');//showing all rated recipes
Route::prefix('/rated')->middleware('auth')->group(function (){
    Route::get('/{id}' ,[RatingController::class , 'show'])->name('showRating');//rate a recipe
    Route::post('/' ,[RatingController::class , 'store'])->name('storeRating');//rate a recipe
    /**
     *     we can also create an update route and delete route but it is not required from the requirements Project
     */
});
// end rating routing 


Route::get('/review/{id}' , [ReviewController::class, 'show'])->name('recipeReview');
Route::prefix('/review')->middleware('auth')->group(function (){
    Route::post('/' , [ReviewController::class , 'store'])->name('createReview');
    /*
    we can also create an update route and delete route but it is not required from the requirements Project
    */
});


//route for testing the custom mail notification 
Route::get('/mailing' , function(){
    $recipe = Recipe::first(); // Get the first recipe for demonstration

    Notification::send(User::all() , new NewRecipeNotification($recipe));
});


Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes');

/*
Everything is set up and functioning as expected, except for the user notification feature. I haven't figured out why it's not working yet.

I will submit the project to you now. Thank you for your assistance. I'm open to any guidance on how to implement email notifications for users.
*/
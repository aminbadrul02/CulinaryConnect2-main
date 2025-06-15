<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Recipe extends Model
{
    //protected $table = 'favorite_recipes'; // correct table name

    use HasFactory;
    protected $fillable = [
        'name',
        'cooking_time',
        'instructions', 
        'cuisine_type', 
        'ingredients' , 
        'image_path' ,
        'difficulty' , 
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'recipe_category')->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'recipe_id');
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'recipe_id');
    }
    
    public function isFavorite()
    {
        // Check if the current user has favorited this recipe
        if (Auth::check()) {
            return $this->favorites()->where('user_id', Auth::id())->exists();
        }

        return false;
    }
}
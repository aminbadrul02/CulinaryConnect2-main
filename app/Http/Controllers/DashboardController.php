<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use App\Models\Category;
use App\Models\Review;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        try {
            // Get counts for dashboard cards
            $totalRecipes = Recipe::count() ?? 0;
            $totalCategories = Category::count() ?? 0;
            $totalComments = Review::count() ?? 0;
            $totalUsers = User::count() ?? 0;
            
            // Get latest comments/reviews
            $latestComments = Review::with(['user', 'recipe'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
                
            // Get latest ratings
            $latestRatings = Rating::with(['user', 'recipe'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            // Log error
            Log::error('Dashboard data error: ' . $e->getMessage());
            
            // Set default values
            $totalRecipes = 0;
            $totalCategories = 0;
            $totalComments = 0;
            $totalUsers = 0;
            $latestComments = collect();
            $latestRatings = collect();
        }
            
        return view('dashboard', compact(
            'totalRecipes', 
            'totalCategories', 
            'totalComments', 
            'totalUsers', 
            'latestComments', 
            'latestRatings'
        ));
    }
}
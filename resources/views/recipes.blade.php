@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
<div class="container">
   <div class="filteringSorting">
      <form action="{{ route('search') }}" method="POST">
         @csrf
         <!-- Filter by Cuisine Type -->
         <select name="category">
            <option value="">Select Category</option>
            @foreach ($allCategories as $category)
            <option value="{{ $category->id }}"> {{$category->name}} </option>
            @endforeach
         </select>


         <!-- Filter by Ingredients -->
         <input type="text" name="ingredients" placeholder="Filter by ingredients">

         <!-- Filter by Cooking Time -->
         <select name="cooking_time">
            <option value="">Select Cooking Time</option>
            <option value="30">Under 30 minutes</option>
            <option value="30_to_60">30 to 60 minutes</option>
            <option value="60">Over 60 minutes</option>
         </select>
          <!-- Filter by level -->
          <select name="level">
            <option value="">Select recipe level</option>
            <option value="easy">easy</option>
            <option value="meduim">meduim</option>
            <option value="hard">hard</option>            
         </select>

         <!-- Submit Button -->
         <button type="submit">Apply Filters</button>
      </form>
      @auth
      <form action="{{route('favorites')}}" method="GET">
         @csrf
         <button style="background-color: brown">Favorites</button>
      </form>
      @endauth
   </div>

   <div class="mt-3">
      @if ($allRecipes->isEmpty())
      <div class="alert alert-info">No recipes found</div>
      @else
      <table class="table table-bordered">
         <thead>
            <tr>
               <th>image</th>
               <th>Name</th>
               <th>Cooking Time</th>
               <th>Category</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
            @foreach($allRecipes as $recipe)
            <tr>
               <td><img src="{{asset('uploaded_img_recipes/' .  $recipe->image_path)}}" alt="img" width="70px"></td>
               <td>{{ $recipe->name }}</td>

               <td>{{ $recipe->cooking_time }}</td>

               <td>
                  @foreach($recipe->categories as $category)
                  {{ $category->name }}
                  @if (!$loop->last)
                  ,
                  @endif
                  @endforeach
               </td>

               <td>
                  <a href="{{ route('showRecipe', $recipe->id) }}" class="btn btn-sm btn-primary">View</a>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
      @endif
   </div>
</div>
@endsection
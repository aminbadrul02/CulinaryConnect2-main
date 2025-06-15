@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
<div class="container">
    <h1>Add a Recipe</h1>
    <form action="{{ route('addrecipe') }}" method="post" enctype="multipart/form-data">
        @csrf

        <!-- Input for the name (required) -->
        <div class="form-group mb-2">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Input for the image of the recipe (required) -->
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image" required>
        </div>

        <!-- Input for the ingredients (required) -->
        <div class="form-group mt-2 mb-3">
            <label for="ingredients">Ingredients</label>
            <textarea class="form-control" id="ingredients" name="ingredients" rows="3" required></textarea>
        </div>

        <!-- Input for selecting categories -->
        <div class="form-group">
            <label for="categories">Categories or <a href="{{route('create-category')}}">add category</a> </label>
            <select class="form-control" id="categories" name="categories[]" multiple required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Hold down the Ctrl (Windows) / Command (Mac) button to select multiple options.</small>
        </div>

        <!-- Input for selecting the cooking time (required) -->
        <div class="form-group mt-2 mb-2">
            <label for="cooking_time">Cooking Time</label>
            <input type="number" class="form-control" name="cooking_time" required>
        </div>

        <!-- Input for the instructions (required) -->
        <div class="form-group">
            <label for="instructions">Instructions</label>
            <textarea class="form-control" id="instructions" name="instructions" rows="5" required></textarea>
        </div>

        <!-- Input for the difficulty level (required) -->
        <div class="form-group mb-3 mt-1">
            <label for="difficulty">Difficulty Level</label>
            <select class="form-control" id="difficulty" name="difficulty" required>
                <option value="">Select Difficulty Level</option>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
            </select>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection

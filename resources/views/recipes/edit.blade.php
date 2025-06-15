@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Recipe</h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('updatingRecipe' , ['id' => $recipe->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Input for the name (required) -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $recipe->name }}" required>
        </div>
        <!-- Input for the image of the recipe (required) -->
        <div class="form-group">
            <label for="image">Image <span style="color: rgb(130, 104, 71)">(not requied)</span></label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <!-- Input for the ingredients (required) -->
        <div class="form-group">
            <label for="ingredients">Ingredients</label>
            <textarea class="form-control" id="ingredients" name="ingredients" rows="3"
                required>{{ $recipe->ingredients }}</textarea>
        </div>
        <!-- Input for selecting categories -->
        <div class="form-group">
            <label for="categories">Categories or <a href="{{ route('create-category') }}">add category</a></label>
            <select class="form-control" id="categories" name="categories[]" multiple required>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $recipe->categories->contains($category) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>

            <small class="form-text text-muted">Hold down the Ctrl (Windows) / Command (Mac) button to select multiple
                options.</small>
        </div>
        <!-- Input for selecting the cooking time (required) -->
        <div class="form-group">
            <label for="cooking_time">Cooking Time (minutes)</label>
            <input type="number" class="form-control" id="cooking_time" name="cooking_time"
                value="{{ $recipe->cooking_time }}" required>
        </div>
        <!-- Input for selecting the cuisine type (required) -->

        <!-- Input for the instructions (required) -->
        <div class="form-group">
            <label for="instructions">Instructions</label>
            <textarea class="form-control" id="instructions" name="instructions" rows="5"
                required>{{ $recipe->instructions }}</textarea>
        </div>
        <!-- Input for the difficulty level (required) -->
        <div class="form-group">
            <label for="difficulty">Difficulty Level</label>
            <select class="form-control" id="difficulty" name="difficulty" required>
                <option value="">Select Difficulty Level</option>
                <option value="easy" {{ $recipe->difficulty == 'Easy' ? 'selected' : '' }}>Easy</option>
                <option value="medium" {{ $recipe->difficulty == 'Medium' ? 'selected' : '' }}>Medium</option>
                <option value="hard" {{ $recipe->difficulty == 'Hard' ? 'selected' : '' }}>Hard</option>
            </select>
        </div>
        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">{{ $category->name }} Recipes</h2>

    @if($recipes->isEmpty())
        <p>No recipes found in this category.</p>
    @else
        <div class="row">
            @foreach($recipes as $recipe)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        @if($recipe->image_path)
                            <img src="{{ asset('uploaded_img_recipes/' . $recipe->image_path) }}" class="card-img-top" alt="{{ $recipe->name }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $recipe->name }}</h5>
                            <p class="card-text">{{ Str::limit($recipe->description, 100) }}</p>
                            <a href="{{ route('showRecipe', $recipe->id) }}" class="btn btn-sm btn-primary mt-auto">View Recipe</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection


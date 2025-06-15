@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Search Results for "{{ $query }}"</h2>

    @if($recipes->isEmpty())
        <p>No recipes found.</p>
    @else
        <div class="row">
            @foreach($recipes as $recipe)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('uploaded_img_recipes/' . $recipe->image_path) }}" class="card-img-top" alt="{{ $recipe->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $recipe->name }}</h5>
                            <a href="{{ route('showRecipe', $recipe->id) }}" class="btn btn-primary">View Recipe</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@extends('layouts.app')
@section('styles')
<!-- -->
@endsection
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{$recipe->name}}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{asset('uploaded_img_recipes/'.$recipe->image_path)}}" alt="Recipe Image" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong>Difficulty:</strong>
                        <span class="badge {{$recipe->difficulty === 'hard' ? 'bg-danger' : ($recipe->difficulty === 'medium' ? 'bg-warning' : 'bg-success')}}">{{$recipe->difficulty}}</span>
                    </div>
                    <div class="mb-3">
                        <strong>cooking_time:</strong>
                        <p>{{$recipe->cooking_time}}</p>
                    </div> 
                   <div class="mb-3">
    <strong>Category:</strong>
    @if ($recipe->categories && $recipe->categories->count())
        <ul class="list-unstyled mb-0">
            @foreach ($recipe->categories as $category)
                <li class="badge bg-secondary me-1">{{ $category->name }}</li>
            @endforeach
        </ul>
    @else
        <p class="text-muted">No category assigned</p>
    @endif
</div>

                    <div class="mb-3">
                        <strong>Ingredients:</strong>
                        <p>{{$recipe->ingredients}}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Instructions:</strong>
                        <p>{{$recipe->instructions}}</p>
                    </div>
                    @auth
                        <div class="mb-3">
                            <a href="{{route('recipeReview',['id' => $recipe->id])}}" class="btn btn-danger">Review</a>
                            <a href="{{route('showRating',['id' => $recipe->id])}}" class="btn btn-primary">Rating</a>
                        </div> 
                        <div class="mb-3">
                            <form action="{{ route('favorite' , ['id' => $recipe->id]) }}" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
                                @if ($recipe->isFavorite())
                                    <button type="submit">REMOVE FROM FAVORITES</button>
                                @else
                                    <button type="submit">ADD TO FAVORITES</button>
                                @endif
                            </form>
                        </div>                          
                    @endauth
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="owner">
                owner : <a href="{{route('ownerProfile' , ['id' => $recipe->user->id])}}" class="btn btn-primary">{{$recipe->user->name}}</a>
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')
@section('styles')
<!-- -->
@endsection
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{$recipe->name}}</h5>
            @if (isset($averageRating) && $averageRating != 0)
                <h3>AVERAGE RATE  = {{$averageRating}}</h3>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{asset('uploaded_img_recipes/'.$recipe->image_path)}}" alt="Recipe Image"
                        class="img-fluid">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('storeRating') }}" method="post">
                        @csrf
                        <div class="form-group mt-2">
                            <label for="rate">Enter the rate</label>
                            <input type="hidden" name="recipe_id" value="{{$recipe->id}}">
                            <input type="number" name="rating" id="rating" class="form-control" required min="1" max="100">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2 mb-2">Rate</button>
                    </form>                    
                </div>
            </div>
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success">                    
                        {{session('success')}}
                    </div>
                @endif
                @if (isset($allRecipeRatings) && $allRecipeRatings->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User Profile</th>
                                <th>Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allRecipeRatings as $rateInfo)
                                <tr>
                                    <td>
                                        <a href="{{route('ownerProfile' , ['id' => $rateInfo->user->id ])}}">{{$rateInfo->user->name}}</a>
                                    </td>
                                    <td>
                                        {{$rateInfo->rating}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info mt-2">No rates found yet</div>
                @endif
            </div>            
        </div>
    </div>
</div>

@endsection
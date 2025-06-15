@extends('layouts.app')
@section('styles')
<!-- -->
@endsection
@section('content')
<div class="container">
    @if ($ratedRecipes->count() < 0)
        <div class="alert alert-info">
            no rated recipes found yet
            <hr>
            you can add rate when 
            @guest
            you are logged in and    
            @endguest
            you <span class="" style="color: brown">show</span> the recipe itself 
        </div>
    @else    
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ratedRecipes as $rateInfo)
                    <tr>
                        <td><img src="{{ asset('uploaded_img_recipes/' . $rateInfo->image_path) }}" alt="Recipe Image" class="img-thumbnail" width="70px"></td>
                        <td>{{ $rateInfo->name }}</td>
                        <td>{{ $rateInfo->average_rating }}</td>
                        <td>
                            <a href="{{route('showRecipe' , ['id' => $rateInfo->id])}}" class="btn btn-primary">Show</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    @endif
</div>
@endsection
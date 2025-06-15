@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title">{{ $userHimSelf->name }}</h4>
                    <p class="card-text">{{ $userHimSelf->email }}</p>
                </div>
                <div class="col-md-6 text-right">
                    <img src="{{ asset('uploaded_img_profilePicture/' . $userHimSelf->image_path) }}" alt="{{ $userHimSelf->name }}"
                        class="img-fluid rounded-circle" style="width: 100px;">
                    @auth
                    @if ($userHimSelf->id == auth()->user()->id)
                    <div class="mt-2">
                        <a href="{{ url('/profile/edit' , ['id' => $userHimSelf->id]) }}" class="btn btn-primary">Edit
                            Profile</a>
                    </div>
                    @endif
                    @endauth

                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h5 class="mb-2">@auth
            My
        @endauth Recipes</h5>
        @if($userHimSelf->recipes->isEmpty())
        <div class="mt-2 alert alert-info">no recipes found , you should <a href="{{route('showForm')}}">add</a> recipes
        </div>
        @else
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

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>image</th>
                        <th>Recipe Name</th>
                        <th>Cuisine Type</th>
                        <th>Cooking Time</th>
                        <th>Ingredients</th>
                        <th>Instructions</th>
                        <th>Categories</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through user's recipes and display them here -->
                    @foreach ($userHimSelf->recipes as $recipe)
                    <tr>
                        <td><img src="{{asset('uploaded_img_recipes/' .  $recipe->image_path)}}" alt="img" width="70px"></td>
                        <td>{{ $recipe->name }}</td>
                        <td>{{ $recipe->cuisine_type }}</td>
                        <td>{{ $recipe->cooking_time }}</td>
                        
                        <td>{{ $recipe->ingredients }}</td>
                        <td>{{ $recipe->instructions }}</td>
                        <td>
                            @foreach($recipe->categories as $category)
                            {{ $category->name }}
                            @if (!$loop->last)
                            ,
                            @endif
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('showRecipe', $recipe->id) }}" class="btn btn-info btn-sm">View</a>
                            @auth
                            @if ($recipe->user->id == auth()->user()->id)
                            <a href="{{route('showEditingFormForRecipe' , ['id' => $recipe->id])}}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('destroyRecipe', $recipe) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mr-1 mt-4">Delete</button>
                            </form>
                            @endif
                            @endauth
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

@endsection
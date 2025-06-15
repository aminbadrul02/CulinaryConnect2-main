@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<style>
    .hero {
        position: relative;
        background-image: url('{{ asset('images/banner.png') }}');
        background-size: cover;
        background-position: center;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .hero .overlay {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: white;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        padding: 30px;
    }

    .category-card {
        background-color: #111;
        color: white;
        border-radius: 8px;
        overflow: hidden;
        text-align: center;
        height: 150px;
        width: 150px;
        margin: auto;
        transition: transform 0.2s ease;
        text-decoration: none;
    }

    .category-card:hover {
        transform: scale(1.05);
    }

    .category-card img {
        width: 100%;
        height: 100px;
        object-fit: cover;
    }

    .category-card p {
        margin: 5px 0;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<div class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
        <h1 class="display-5 fw-bold">YOUR BEST MULTIPLE RECIPE GUIDE IN MALAYSIA.</h1>
    </div>
</div>

<!-- Browse by Category -->
<h2 class="text-center mt-5">Browse by Category</h2>
<div class="category-grid">
    @foreach ($allCategories as $category)
        @php
            $filename = strtolower(preg_replace('/[^a-z0-9]/', '', str_replace(' ', '', $category->name))) . '.jpg';
            $imagePath = public_path('images/' . $filename);
            $imageUrl = file_exists($imagePath) 
                        ? asset('images/' . $filename) 
                        : asset('images/default.jpg');
        @endphp
        <a href="{{ route('category.show', $category->id) }}" class="category-card">
            <img src="{{ $imageUrl }}" alt="{{ $category->name }}">
            <p>{{ strtoupper($category->name) }}</p>
        </a>
    @endforeach
</div>
@endsection

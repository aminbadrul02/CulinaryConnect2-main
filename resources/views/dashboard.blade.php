@extends('layouts.app')

@section('content')
<div class="dashboard-content">
    <div class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-item active">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <!-- Update these routes to match your actual route names -->
        <a href="{{ route('index') }}" class="sidebar-item">
            <i class="fas fa-utensils"></i> All Recipes
        </a>
        <a href="{{ route('index') }}" class="sidebar-item">
            <i class="fas fa-comment"></i> Comments & Reviews
        </a>
        <a href="{{ route('index') }}" class="sidebar-item">
            <i class="fas fa-users"></i> Users
        </a>
        <a href="{{ route('index') }}" class="sidebar-item">
            <i class="fas fa-cog"></i> Settings
        </a>
        <a href="{{ route('logout') }}" class="sidebar-item" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="main-content">
        <h1>DASHBOARD</h1>

        <div class="stats-container">
            <div class="stat-card recipes-card">
                <h3>Total Recipes</h3>
                <div class="number">{{ $totalRecipes }}</div>
            </div>
            <div class="stat-card categories-card">
                <h3>Total Categories</h3>
                <div class="number">{{ $totalCategories }}</div>
            </div>
            <div class="stat-card comments-card">
                <h3>Comment & Reviews</h3>
                <div class="number">{{ $totalComments }}</div>
            </div>
            <div class="stat-card users-card">
                <h3>Total User</h3>
                <div class="number">{{ $totalUsers }}</div>
            </div>
        </div>

        <div class="data-tables">
            <div class="table-container">
                <div class="section-header">
                    <h2>Latest Comment</h2>
                    <div>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-calendar"></i> May
                        </button>
                    </div>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>USER NAME</th>
                            <th>RECIPE</th>
                            <th>COMMENT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestComments as $index => $comment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ optional($comment->user)->name ?? 'Unknown' }}</td>
                            <td>{{ optional($comment->recipe)->name ?? 'Unknown' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($comment->review_text ?? $comment->comment ?? '', 30) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No comments found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-container">
                <div class="section-header">
                    <h2>Latest review</h2>
                    <div>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-calendar"></i> May
                        </button>
                    </div>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>USER NAME</th>
                            <th>RECIPE</th>
                            <th>RATING</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestRatings as $index => $rating)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ optional($rating->user)->name ?? 'Unknown' }}</td>
                            <td>{{ optional($rating->recipe)->name ?? 'Unknown' }}</td>
                            <td>{{ $rating->rating ?? 0 }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No ratings found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-content {
        display: flex;
        min-height: calc(100vh - 60px);
    }
    .sidebar {
        width: 250px;
        background-color: #2c3e50;
        color: white;
        padding: 20px 0;
    }
    .sidebar-item {
        padding: 12px 20px;
        display: flex;
        align-items: center;
        color: white;
        text-decoration: none;
        transition: background-color 0.3s;
    }
    .sidebar-item:hover, .sidebar-item.active {
        background-color: #34495e;
        text-decoration: none;
        color: white;
    }
    .sidebar-item i {
        margin-right: 10px;
    }
    .main-content {
        flex: 1;
        padding: 20px;
        background-color: #f5f5f5;
    }
    .stats-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        flex: 1;
        min-width: 200px;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .stat-card h3 {
        font-size: 18px;
        color: #555;
        margin-bottom: 10px;
    }
    .stat-card .number {
        font-size: 48px;
        font-weight: bold;
    }
    .recipes-card {
        background-color: #e8f5e9;
    }
    .categories-card {
        background-color: #fff8e1;
    }
    .comments-card {
        background-color: #e3f2fd;
    }
    .users-card {
        background-color: #fce4ec;
    }
    .data-tables {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    .table-container {
        flex: 1;
        min-width: 45%;
    }
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .data-table th, .data-table td {
        padding: 12px 15px;
        text-align: left;
    }
    .data-table thead {
        background-color: #f5f5f5;
        border-bottom: 2px solid #ddd;
    }
    .data-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>
@endsection
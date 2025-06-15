@extends('layouts.app')

@section('styles')
<!-- Add custom styles if needed -->
@endsection

@section('content')
<div class="container mt-4">

    <!-- Add New Category Form -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add New Category</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('add-category') }}" method="POST">
                @csrf

                @if(session('warning'))
                    <div class="alert alert-warning">{{ session('warning') }}</div>
                @endif

                @if(session('danger'))
                    <div class="alert alert-danger">{{ session('danger') }}</div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="form-group mb-3">
                    <label for="name">Category Name</label>
                    <input type="text" class="form-control" id="name" name="categoryName" required>
                </div>

                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>

    <!-- List Existing Categories -->
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Existing Categories</h5>
        </div>
        <div class="card-body p-0">
            @if($AllCategories->isEmpty())
                <div class="p-3">
                    <p class="text-muted">No categories found.</p>
                </div>
            @else
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($AllCategories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td class="d-flex gap-1">
                                <!-- Edit Button -->

                                <!-- Delete Form -->
                                <form action="{{ route('delete-category', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</div>
@endsection


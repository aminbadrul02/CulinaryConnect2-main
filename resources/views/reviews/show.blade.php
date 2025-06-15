@extends('layouts.app')

@section('styles')
    <!-- Additional styles for this page -->
    <style>
        .card-header img {
            float: right;
            margin-left: 10px;
        }

        .review-form {
            margin-bottom: 20px;
        }

        .review-form label {
            font-weight: bold;
        }

        .review-form textarea {
            resize: vertical;
        }

        .review-table th, .review-table td {
            vertical-align: middle;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <img src="{{ asset('uploaded_img_recipes/' . $recipe->image_path) }}" alt="Recipe Image" width="100">
            <h5 class="card-title">{{ $recipe->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('createReview') }}" method="post" class="review-form">
                        @csrf
                        <div class="form-group">
                            <label for="review">Write a Review</label>
                            <input type="hidden" name="recipe_id" value="{{$recipe->id}}">
                            <textarea name="review_text" id="review" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Send</button>
                    </form>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-md-12">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (isset($reviews) && $reviews->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped review-table">
                                <thead>
                                    <tr>
                                        <th>User Profile</th>
                                        <th>Review</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reviews as $reviewInfo)
                                        <tr>
                                            <td>
                                                <a href="{{ route('ownerProfile', ['id' => $reviewInfo->user_id ]) }}">{{ $reviewInfo->reviewer_name }}</a>
                                            </td>
                                            <td>{{ $reviewInfo->review_text }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">No Reviews Found Yet</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

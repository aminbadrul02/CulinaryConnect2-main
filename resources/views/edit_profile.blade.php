@extends('layouts.app')
@section('styles')
<!-- -->
@endsection
@section('content')
<div class="container">
    <form action="{{ route('updateprofile', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
        </div>
        <div class="form-group mt-3 mb-2">
            <label for="email">profilePicture</label>
            <input type="file" class="form-control" id="image" name="image" value="{{ $user->email }}">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Save Profile</button>
    </form>
    <hr>
    <form action="{{ route('updateprofilePrivacy', ['id' => $user->id]) }}" method="POST">
        @csrf
        @if(session('successPassword'))
            <div class="alert alert-success">
                {{ session('successPassword') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="form-group">
            <label for="old">Old Password</label>
            <input type="password" class="form-control" id="old" name="old">
        </div>
        <div class="form-group">
            <label for="new">New Password</label>
            <input type="password" class="form-control" id="new" name="new">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Save Password</button>
    </form>
</div>

@endsection
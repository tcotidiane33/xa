@extends('layouts.app')

@section('content')
    <h1>Create Post</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="3" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="user_id">User ID</label>
            <input type="number" name="user_id" id="user_id" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection

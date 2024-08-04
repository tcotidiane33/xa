@extends('layouts.app')

@section('content')
    <h1>Edit Post</h1>

    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="3" class="form-control" required>{{ $post->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="user_id">User ID</label>
            <input type="number" name="user_id" id="user_id" class="form-control" value="{{ $post->user_id }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection

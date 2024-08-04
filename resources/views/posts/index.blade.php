@extends('layouts.app')


@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
    </div>

    @foreach($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->description }}</p>
                <p class="card-text"><small class="text-muted">Posted by {{ $post->user->name }}</small></p>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">View Post</a>
            </div>
        </div>
    @endforeach

    <h1>Posts</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>

    <div>
        @foreach ($posts as $post)
            <div>
                <h3>{{ $post->title }}</h3>
                <p>{{ $post->description }}</p>
                <p>Posted by {{ $post->user->name }}</p>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">View Post</a>
            </div>
        @endforeach
    </div>

    <div class="container">

        @foreach ($posts as $post)
            <div>
                <h3>Post Id : {{ $post->id }}</h3>
                <p>Post title : {{ $post->title }}</p>
                <p>Post description : {{ $post->description }}</p>
                <p>Post status : {{ $post->status }}</p>
                <p>Post created date : {{ $post->created_at }}</p>
                <p>Post created by User : {{ $post->user->name }}</p>
                <p>Comments on Post:
                    @foreach ($post->comments as $comment)
                        <ul>
                            <li>Comment : {{ $comment->content }}</li>
                            <li>Comment created date: {{ $comment->created_at }}</li>
                            <li>Comment created by User: {{ $comment->user->name }}</li>
                            <li>Reply on comment :
                                @foreach ($comment->replies as $reply)
                                    <ul>
                                        <li>Reply : {{ $reply->content }}</li>
                                        <li>Reply created date: {{ $reply->created_at }}</li>
                                        <li>Reply created by User: {{ $reply->user->name }}</li>
                                    </ul>
                                @endforeach
                            </li>
                        </ul>
                    @endforeach
                </p>
            </div>
        @endforeach

    </div>
@endsection

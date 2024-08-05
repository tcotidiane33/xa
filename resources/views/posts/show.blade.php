@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ $post->description }}</p>
            <p class="card-text"><small class="text-muted">Posted by {{ $post->user->name }}</small></p>
        </div>
    </div>

    <h3>Comments</h3>
    @foreach($post->comments as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <p class="card-text">{{ $comment->content }}</p>
                <p class="card-text"><small class="text-muted">Commented by {{ $comment->user->name }}</small></p>

                <h5>Replies</h5>
                @foreach($comment->replies as $reply)
                    <div class="card mb-3 ml-3">
                        <div class="card-body">
                            <p class="card-text">{{ $reply->content }}</p>
                            <p class="card-text"><small class="text-muted">Replied by {{ $reply->user->name }}</small></p>
                        </div>
                    </div>
                @endforeach

                <form action="{{ route('comments.replies.store', $comment->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="replyContent">Add Reply</label>
                        <textarea name="content" id="replyContent" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="replyAttachment">Attach File</label>
                        <input type="file" name="attachment" id="replyAttachment" class="form-control">
                    </div>
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <button type="submit" class="btn btn-primary">Reply</button>
                </form>
            </div>
        </div>
    @endforeach

    <form action="{{ route('posts.comments.store', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="commentContent">Add Comment</label>
            <textarea name="content" id="commentContent" rows="3" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="commentAttachment">Attach File</label>
            <input type="file" name="attachment" id="commentAttachment" class="form-control">
        </div>
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <button type="submit" class="btn btn-primary">Comment</button>
    </form>
@endsection


{{-- @extends('layouts.app')

@section('content')

<div>
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->description }}</p>
    <p>Posted by {{ $post->user->name }}</p>

    <h2>Comments</h2>
    @foreach ($post->comments as $comment)
        <div>
            <p>{{ $comment->content }}</p>
            <p>Commented by {{ $comment->user->name }}</p>

            <h3>Replies</h3>
            @foreach ($comment->replies as $reply)
                <div>
                    <p>{{ $reply->content }}</p>
                    <p>Replied by {{ $reply->user->name }}</p>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ $post->description }}</p>
            <p class="card-text"><small class="text-muted">Posted by {{ $post->user->name }}</small></p>
        </div>
    </div>

    <h3>Comments</h3>
    @foreach($post->comments as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <p class="card-text">{{ $comment->content }}</p>
                <p class="card-text"><small class="text-muted">Commented by {{ $comment->user->name }}</small></p>

                <h5>Replies</h5>
                @foreach($comment->replies as $reply)
                    <div class="card mb-3 ml-3">
                        <div class="card-body">
                            <p class="card-text">{{ $reply->content }}</p>
                            <p class="card-text"><small class="text-muted">Replied by {{ $reply->user->name }}</small></p>
                        </div>
                    </div>
                @endforeach

                <form action="{{ route('comments.replies.store', $comment->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="replyContent">Add Reply</label>
                        <textarea name="content" id="replyContent" rows="3" class="form-control"></textarea>
                    </div>
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <button type="submit" class="btn btn-primary">Reply</button>
                </form>
            </div>
        </div>
    @endforeach

    <form action="{{ route('posts.comments.store', $post->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="commentContent">Add Comment</label>
            <textarea name="content" id="commentContent" rows="3" class="form-control"></textarea>
        </div>
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <button type="submit" class="btn btn-primary">Comment</button>
    </form>
@endsection --}}

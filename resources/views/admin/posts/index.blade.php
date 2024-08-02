@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($posts as $post)
        <div class="post">
            <div class="user-info">
                <strong>{{ $post->user->name }}</strong> 
                <span>{{ $post->created_at->diffForHumans() }}</span>
            </div>
            <div class="content">
                {{ $post->content }}
            </div>
            @if($post->mentions)
                <div class="mentions">
                    Mentions: 
                    @foreach(json_decode($post->mentions) as $mention)
                        <a href="{{ route('admin.users.show', $mention->id) }}">{{ $mention->name }}</a>
                    @endforeach
                </div>
            @endif
            @if($post->attachments)
                <div class="attachments">
                    @foreach(json_decode($post->attachments) as $attachment)
                        <a href="{{ Storage::url($attachment) }}" target="_blank">View Attachment</a>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>
@endsection

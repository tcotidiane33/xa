<!-- resources/views/notifications/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Notifications</h1>
    <ul class="list-group">
        @foreach($notifications as $notification)
            <li class="list-group-item">
                {{ $notification->data['message'] }}
                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">Marquer comme lu</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection

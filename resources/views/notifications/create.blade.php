@extends('layouts.app')

@section('content')
    <h1>Send Notification</h1>

    <form action="{{ route('notifications.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" rows="3" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Notification</button>
    </form>
@endsection

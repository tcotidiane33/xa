@extends('layouts.admin')

@section('title', 'Admin Settings')

@section('content')
    <div class="main-content">
        <div class="main-page">
            <div class="row">
                <br>
                <br>
            </div>
            <div class="row">
                <div class="container">
                    <form action="{{ route('profile.update-settings') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="theme">Theme</label>
                            <select name="theme" id="theme" class="form-control">
                                <option value="light" {{ $settings->theme == 'light' ? 'selected' : '' }}>Light</option>
                                <option value="dark" {{ $settings->theme == 'dark' ? 'selected' : '' }}>Dark</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notifications">
                                <input type="checkbox" name="notifications" id="notifications" {{ $settings->notifications ? 'checked' : '' }}>
                                Enable Notifications
                            </label>
                        </div>
                        <!-- Ajoutez d'autres champs de configuration ici -->
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
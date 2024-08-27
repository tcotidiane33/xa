@extends('layouts.main')

@section('content')
<div class="main-page login-page flow-container">
    <h2 class="title1">{{ __('Login') }}</h2>
    <div class="widget-shadow flow-card">
        <div class="login-body flow-form">
            @include('components.auth-session-status', ['status' => session('status')])

            @include('components.validation-form', [
                'action' => route('login'),
                'fields' => [
                    [
                        'type' => 'email',
                        'name' => 'email',
                        'label' => __('Email'),
                        'placeholder' => 'Enter Your Email',
                        'required' => true,
                        'autofocus' => true,
                        'autocomplete' => 'username'
                    ],
                    [
                        'type' => 'password',
                        'name' => 'password',
                        'label' => __('Password'),
                        'placeholder' => 'Enter Your Password',
                        'required' => true,
                        'autocomplete' => 'current-password'
                    ],
                    [
                        'type' => 'checkbox',
                        'name' => 'remember',
                        'label' => __('Remember me')
                    ]
                ],
                'submit_text' => __('Log in')
            ])

            <div class="forgot-grid">
                @if (Route::has('password.request'))
                    <div class="forgot flow-link">
                        <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                    </div>
                @endif
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
</div>
@endsection
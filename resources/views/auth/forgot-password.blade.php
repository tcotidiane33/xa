@extends('layouts.main')

@section('content')
<div class="main-page">
    <h2 class="title1">{{ __('Forgot Password') }}</h2>
    <div class="widget-shadow">
        <div class="login-body">
            <div class="mb-4">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            @include('components.auth-session-status', ['status' => session('status')])

            @include('components.validation-form', [
                'action' => route('password.email'),
                'fields' => [
                    [
                        'type' => 'email',
                        'name' => 'email',
                        'label' => __('Email'),
                        'placeholder' => 'Enter Your Email',
                        'required' => true,
                        'autofocus' => true
                    ]
                ],
                'submit_text' => __('Email Password Reset Link')
            ])
        </div>
    </div>
</div>
@endsection

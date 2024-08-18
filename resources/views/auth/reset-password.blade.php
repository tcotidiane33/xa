@extends('layouts.main')

@section('content')
<div class="main-page">
    <h2 class="title1">{{ __('Reset Password') }}</h2>
    <div class="widget-shadow">
        <div class="login-body">
            @include('components.validation-form', [
                'action' => route('password.store'),
                'fields' => [
                    [
                        'type' => 'hidden',
                        'name' => 'token',
                        'value' => $request->route('token')
                    ],
                    [
                        'type' => 'email',
                        'name' => 'email',
                        'label' => __('Email'),
                        'value' => old('email', $request->email),
                        'required' => true,
                        'autofocus' => true,
                        'autocomplete' => 'username'
                    ],
                    [
                        'type' => 'password',
                        'name' => 'password',
                        'label' => __('Password'),
                        'required' => true,
                        'autocomplete' => 'new-password'
                    ],
                    [
                        'type' => 'password',
                        'name' => 'password_confirmation',
                        'label' => __('Confirm Password'),
                        'required' => true,
                        'autocomplete' => 'new-password'
                    ]
                ],
                'submit_text' => __('Reset Password')
            ])
        </div>
    </div>
</div>
@endsection

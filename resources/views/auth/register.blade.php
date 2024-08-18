@extends('layouts.main')

@section('content')
<div class="main-page signup-page">
    <h2 class="title1">{{ __('Register') }}</h2>
    <div class="sign-up-row widget-shadow">
        @include('components.validation-form', [
            'action' => route('register'),
            'fields' => [
                [
                    'type' => 'text',
                    'name' => 'name',
                    'label' => __('Name'),
                    'placeholder' => 'Enter Your Name',
                    'required' => true,
                    'autofocus' => true,
                    'autocomplete' => 'name'
                ],
                [
                    'type' => 'email',
                    'name' => 'email',
                    'label' => __('Email'),
                    'placeholder' => 'Enter Your Email',
                    'required' => true,
                    'autocomplete' => 'username'
                ],
                [
                    'type' => 'password',
                    'name' => 'password',
                    'label' => __('Password'),
                    'placeholder' => 'Enter Your Password',
                    'required' => true,
                    'autocomplete' => 'new-password'
                ],
                [
                    'type' => 'password',
                    'name' => 'password_confirmation',
                    'label' => __('Confirm Password'),
                    'placeholder' => 'Confirm Your Password',
                    'required' => true,
                    'autocomplete' => 'new-password'
                ]
            ],
            'submit_text' => __('Register')
        ])

        <div class="registration">
            {{ __('Already registered?') }}
            <a class="" href="{{ route('login') }}">
                {{ __('Login') }}
            </a>
        </div>
    </div>
</div>
@endsection

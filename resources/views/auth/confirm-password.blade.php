@extends('layouts.main')

@section('content')
<div class="main-page">
    <h2 class="title1">{{ __('Confirm Password') }}</h2>
    <div class="widget-shadow">
        <div class="login-body">
            <div class="mb-4">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            @include('components.validation-form', [
                'action' => route('password.confirm'),
                'fields' => [
                    [
                        'type' => 'password',
                        'name' => 'password',
                        'label' => __('Password'),
                        'placeholder' => 'Enter Your Password',
                        'required' => true,
                        'autocomplete' => 'current-password'
                    ]
                ],
                'submit_text' => __('Confirm')
            ])
        </div>
    </div>
</div>
@endsection

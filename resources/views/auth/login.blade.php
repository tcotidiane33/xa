@extends('layouts.main')

@section('content')
    <section class="bg-white-50 dark:bg-white-900 mt-10 ">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex bg-white p-1 rounded-lg items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-100 h-50 mr-2" src="https://externalliance.fr/wp-content/uploads/2023/01/logo-externalliance.png" alt="logo">
                {{-- ExternAlliance --}}
            </a>
            <div
                class=" bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700 mb-3">
                <div class="p-6 space-y-4 align-center md:space-y-6 sm:p-8">
                    <h1 class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Connectez-vous à votre compte
                    </h1>
                    @include('components.auth-session-status', ['status' => session('status')])

                    @include('components.validation-form', [
                        'action' => route('login'),
                        'fields' => [
                            [
                                'type' => 'email',
                                'name' => 'email',
                                'label' => __('Email'),
                                'placeholder' => 'Entrer votre Email',
                                'required' => true,
                                'autofocus' => true,
                                'autocomplete' => 'username',
                            ],
                            [
                                'type' => 'password',
                                'name' => 'password',
                                'label' => __('Password'),
                                'placeholder' => 'Entrer votre Mot de passe',
                                'required' => true,
                                'autocomplete' => 'current-password',
                            ],
                            // [
                            //     'type' => 'checkbox',
                            //     'name' => 'remember',
                            //     'label' => __('Remember me'),
                            // ],
                        ],
                        'submit_text' => __('Connexion'),
                    ])
                      <div class="forgot-grid">
                        @if (Route::has('password.request'))
                            <div class="forgot flow-link">
                                {{-- <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a> --}}
                                <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">{{ __('Mot de passe oublié ?') }}</a>
                            </div>
                        @endif
                        {{-- <div class="clearfix"> </div> --}}
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                              <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                            </div>
                            <div class="ml-3 mb-2 text-sm">
                              <label for="remember" class="text-gray-500 dark:text-gray-300">Se souvenir de moi !</label>
                            </div>
                        </div>
                    </div>
                     <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Vous n’avez pas encore de compte ? <a href="{{ route('register')}}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">S'inscrire</a>
                    </p>
                   
                </div>
            </div>
        </div>
    </section>
@endsection

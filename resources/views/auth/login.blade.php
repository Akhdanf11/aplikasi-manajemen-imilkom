{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="max-w-md w-full p-6 bg-white bg-opacity-40 rounded-lg shadow-md backdrop-blur-md border border-gray-300">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __('Login') }}</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-medium">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 sm:text-sm" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-medium">{{ __('Password') }}</label>
                    <input id="password" type="password" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 sm:text-sm" name="password" required>
                </div>

                <div class="mb-4 flex items-center">
                    <input id="remember" type="checkbox" class="h-4 w-4 text-primary-600 border-gray-300 rounded" name="remember">
                    <label for="remember" class="ml-2 text-gray-700 text-sm">{{ __('Remember Me') }}</label>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.auth')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100  lg:mx-0 mx-4">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg border border-gray-200 max-h-screen flex flex-col justify-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ __('Login') }}</h2>
        <form method="POST" action="{{ route('login') }}" class="flex flex-col">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-medium">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-medium">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">{{ __('Remember Me') }}</label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700">{{ __('Forgot Your Password?') }}</a>
                @endif
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition mt-4">
                {{ __('Login') }}
            </button>
        </form>
    </div>
</div>
@endsection

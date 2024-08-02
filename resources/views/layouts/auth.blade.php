<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">

    <!-- Flowbite CDN -->
    <link href="https://unpkg.com/flowbite@latest/dist/flowbite.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div id="app">
        <nav class="bg-white shadow-md">
            <div class="container mx-auto flex items-center justify-between p-4">
                <a class="text-xl font-semibold text-gray-800" href="{{ url('/') }}">
                    {{ config('app.name', 'IMILKOM') }}
                </a>
                <button class="text-gray-600 focus:outline-none lg:hidden" data-collapse-toggle="navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <div class="hidden lg:flex lg:items-center lg:space-x-6" id="navbarSupportedContent">
                    <ul class="flex space-x-4">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li>
                                    <a class="text-gray-700 hover:text-gray-900" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

    <!-- Flowbite JavaScript -->
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuButton = document.getElementById('user-menu-button');
            const menu = document.getElementById('user-menu');

            menuButton.addEventListener('click', function () {
                menu.classList.toggle('hidden');
            });

            // Close the menu when clicking outside
            document.addEventListener('click', function (event) {
                if (!menu.contains(event.target) && !menuButton.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>

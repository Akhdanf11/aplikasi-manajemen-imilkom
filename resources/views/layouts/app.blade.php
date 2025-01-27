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
                    {{ config('app.name', 'Laravel') }}
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
                        @else
                            <li>
                                <a href="{{ route('projects.index') }}" class="text-gray-700 hover:text-gray-900">Projects</a>
                            </li>
                            @can('viewAny', App\Models\User::class)
                            <li>
                                <a href="{{ route('users.index') }}" class="text-gray-700 hover:text-gray-900">Users</a>
                            </li>
                            <li>
                                <a href="{{ route('attendance.report') }}" class="text-gray-700 hover:text-gray-900">Report</a>
                            </li>
                            @endcan
                            <li>
                                <a href="{{ route('attendance.schedule') }}" class="text-gray-700 hover:text-gray-900">Schedule</a>
                            </li>
                            <li>
                                <a href="{{ route('inventories.index') }}" class="text-gray-700 hover:text-gray-900">Inventory</a>
                            </li>
                            <li>
                                <a href="{{ route('leave_requests.index') }}" class="text-gray-700 hover:text-gray-900">Leave</a>
                            </li>

                            <li class="relative">
                                <button id="user-menu-button" class="text-gray-700 hover:text-gray-900 flex items-center" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>

                                <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden">
                                    <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Flowbite JS -->
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.js"></script>
    <script>
        document.getElementById('user-menu-button').addEventListener('click', function () {
            const userMenu = document.getElementById('user-menu');
            userMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .mykost-orange {
                color: #f97316;
            }
            .mykost-blue {
                color: #1e40af;
            }
            .nav-active {
                background: #3b82f6;
                color: white;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen">
            <!-- Top Navigation -->
            <nav class="bg-white shadow-lg border-b-2 border-blue-600">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo and Brand -->
                        <div class="flex items-center space-x-8">
                            <div class="flex items-center">
                                <h1 class="text-2xl font-bold">
                                    <span class="mykost-orange">MY</span><span class="mykost-blue">KOST</span>
                                </h1>
                            </div>

                            <!-- Main Navigation Links -->
                            <div class="hidden md:flex space-x-1">
                                <a href="{{ route('user.dashboard') }}" 
                                   class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-200 {{ request()->routeIs('user.dashboard') ? 'nav-active' : '' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2H3v2zm9 0v2m0 4v2m-4-3h8"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Dashboard</span>
                                </a>

                                <a href="{{ route('user.rooms.index') }}" 
                                   class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-200 {{ request()->routeIs('user.rooms.*') ? 'nav-active' : '' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Booking</span>
                                </a>

                                @if(Auth::user()->hasActivePenghuni())
                                    <a href="{{ route('penghuni.pengaduan.index') }}" 
                                       class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-200 {{ request()->routeIs('penghuni.pengaduan.*') ? 'nav-active' : '' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Pengaduan</span>
                                    </a>

                                    <a href="{{ route('penghuni.history.index') }}" 
                                       class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-200 {{ request()->routeIs('penghuni.history.*') ? 'nav-active' : '' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Invoice</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Right Side: User Info & Actions -->
                        <div class="flex items-center space-x-4">
                            <!-- Current Time -->
                            <div class="hidden md:block text-right text-sm">
                                <p id="current-time-user" class="text-gray-900 font-medium"></p>
                                <p id="current-date-user" class="text-gray-500"></p>
                            </div>

                            <!-- User Greeting & Logout -->
                            <div class="flex items-center space-x-3">
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">Hi, {{ Auth::user()->nama }}!!</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->role }}</p>
                                </div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center space-x-2 px-3 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Logout</span>
                                    </button>
                                </form>
                            </div>

                            <!-- Mobile Menu Toggle -->
                            <div class="md:hidden">
                                <button id="mobile-menu-toggle" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Navigation Menu -->
                    <div id="mobile-menu" class="hidden md:hidden pb-4">
                        <div class="space-y-1">
                            <a href="{{ route('user.dashboard') }}" 
                               class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-200 {{ request()->routeIs('user.dashboard') ? 'nav-active' : '' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2H3v2zm9 0v2m0 4v2m-4-3h8"></path>
                                </svg>
                                <span class="text-sm font-medium">Dashboard</span>
                            </a>

                            <a href="{{ route('user.rooms.index') }}" 
                               class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-200 {{ request()->routeIs('user.rooms.*') ? 'nav-active' : '' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                                </svg>
                                <span class="text-sm font-medium">Booking</span>
                            </a>

                            @if(Auth::user()->hasActivePenghuni())
                                <a href="{{ route('penghuni.pengaduan.index') }}" 
                                   class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-200 {{ request()->routeIs('penghuni.pengaduan.*') ? 'nav-active' : '' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Pengaduan</span>
                                </a>

                                <a href="{{ route('penghuni.history.index') }}" 
                                   class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-200 {{ request()->routeIs('penghuni.history.*') ? 'nav-active' : '' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Invoice</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Header -->
            @isset($header)
                <header class="bg-white shadow-sm">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Main Content -->
            <main>
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        <!-- Mobile Menu Toggle Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toggleButton = document.getElementById('mobile-menu-toggle');
                const mobileMenu = document.getElementById('mobile-menu');
                
                if (toggleButton && mobileMenu) {
                    toggleButton.addEventListener('click', function() {
                        mobileMenu.classList.toggle('hidden');
                    });
                }
            });

            // Real-time Clock Function
            function updateUserClock() {
                const now = new Date();
                
                // Format time (24-hour format)
                const timeOptions = {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                };
                const timeString = now.toLocaleTimeString('id-ID', timeOptions);
                
                // Format date
                const dateOptions = {
                    year: 'numeric',
                    month: 'short',
                    day: '2-digit'
                };
                const dateString = now.toLocaleDateString('en-US', dateOptions);
                
                // Update DOM elements
                const timeElement = document.getElementById('current-time-user');
                const dateElement = document.getElementById('current-date-user');
                
                if (timeElement) {
                    timeElement.textContent = timeString;
                }
                
                if (dateElement) {
                    dateElement.textContent = dateString;
                }
            }

            // Update clock immediately and then every second
            updateUserClock();
            setInterval(updateUserClock, 1000);
        </script>
    </body>
</html> 
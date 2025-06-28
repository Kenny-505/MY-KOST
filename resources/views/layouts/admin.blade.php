<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

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
            .sidebar-bg {
                background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            }
            .sidebar-active {
                background: rgba(255, 255, 255, 0.15);
                border-right: 3px solid #f97316;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="flex h-screen">
            <!-- Sidebar -->
            <div class="w-64 sidebar-bg shadow-xl flex flex-col">
                <!-- Logo Section -->
                <div class="p-6 border-b border-white border-opacity-20">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold text-white">
                            <span class="text-orange-400">MY</span><span class="text-white">KOST</span>
                        </h1>
                        <p class="text-blue-200 text-sm mt-1">Admin Panel</p>
                    </div>
                </div>

                <!-- User Info Section -->
                <div class="p-4 border-b border-white border-opacity-20">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-medium text-sm">Hi, {{ Auth::user()->nama }}!!</p>
                            <p id="sidebar-date" class="text-blue-200 text-xs"></p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 p-4 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center space-x-3 px-4 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10 transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2H3v2zm9 0v2m0 4v2m-4-3h8"></path>
                        </svg>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.kamar.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10 transition duration-200 {{ request()->routeIs('admin.kamar.*') ? 'sidebar-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                        </svg>
                        <span class="text-sm font-medium">Kamar</span>
                    </a>

                    <a href="{{ route('admin.penghuni.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10 transition duration-200 {{ request()->routeIs('admin.penghuni.*') ? 'sidebar-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Penghuni</span>
                    </a>

                    <a href="{{ route('admin.pengaduan.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10 transition duration-200 {{ request()->routeIs('admin.pengaduan.*') ? 'sidebar-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span class="text-sm font-medium">Pengaduan</span>
                    </a>

                    <a href="#" 
                       class="flex items-center space-x-3 px-4 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-10 transition duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-sm font-medium">Invoice</span>
                    </a>
                </nav>

                <!-- Logout Section -->
                <div class="p-4 border-t border-white border-opacity-20">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center space-x-3 px-4 py-3 text-white rounded-lg hover:bg-red-500 hover:bg-opacity-20 transition duration-200 w-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="text-sm font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Header -->
                <header class="bg-white shadow-sm border-b border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <!-- Page Title -->
                        <div>
                            @isset($pageTitle)
                                <h1 class="text-2xl font-bold text-gray-900">{{ $pageTitle }}</h1>
                            @elseif(isset($title))
                                <h1 class="text-2xl font-bold text-gray-900">@yield('title', 'Admin Dashboard')</h1>
                            @else
                                <h1 class="text-2xl font-bold text-gray-900">@yield('title', 'Admin Dashboard')</h1>
                            @endisset
                            
                            @isset($breadcrumb)
                                <nav class="flex mt-1" aria-label="Breadcrumb">
                                    <ol class="flex items-center space-x-1 text-sm text-gray-500">
                                        {!! $breadcrumb !!}
                                    </ol>
                                </nav>
                            @endisset
                        </div>

                        <!-- Header Actions -->
                        <div class="flex items-center space-x-4">
                            <!-- Current Time -->
                            <div class="text-right text-sm">
                                <p id="current-time" class="text-gray-900 font-medium"></p>
                                <p id="current-date" class="text-gray-500"></p>
                            </div>

                            <!-- Header Actions -->
                            @isset($addButton)
                                <div class="flex items-center">
                                    <a href="{{ $addButtonUrl ?? '#' }}" 
                                       class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center transition duration-200 shadow-lg hover:shadow-xl">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </a>
                                </div>
                            @else
                                @yield('header-actions')
                            @endisset
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-auto p-6">
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    @isset($slot)
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endisset
                </main>
            </div>
        </div>

        <!-- Real-time Clock Script -->
        <script>
            function updateClock() {
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
                const timeElement = document.getElementById('current-time');
                const dateElement = document.getElementById('current-date');
                const sidebarDateElement = document.getElementById('sidebar-date');
                
                if (timeElement) {
                    timeElement.textContent = timeString;
                }
                
                if (dateElement) {
                    dateElement.textContent = dateString;
                }
                
                if (sidebarDateElement) {
                    sidebarDateElement.textContent = dateString;
                }
            }

            // Update clock immediately and then every second
            updateClock();
            setInterval(updateClock, 1000);
        </script>
    </body>
</html> 
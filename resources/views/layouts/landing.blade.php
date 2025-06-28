<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Welcome</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .mykost-orange {
                color: #f97316 !important;
            }
            .mykost-blue {
                color: #1e40af !important;
            }
            
            .landing-page {
                min-height: 100vh;
                background-color: #f9fafb;
            }
            
            .landing-nav {
                background-color: #ffffff;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }
            
            .hero-gradient {
                background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #3b82f6 100%) !important;
                color: white;
            }
            
            .features-section {
                background-color: #ffffff;
            }
            
            .footer-section {
                background-color: #1f2937;
                color: #ffffff;
            }

            /* Mobile menu styles */
            .mobile-menu {
                display: none;
            }
            
            .mobile-menu.active {
                display: block;
            }

            /* Responsive text sizes */
            @media (max-width: 640px) {
                .hero-title {
                    font-size: 2.5rem !important;
                }
                .hero-subtitle {
                    font-size: 1.125rem !important;
                }
                .hero-description {
                    font-size: 1rem !important;
                }
                .section-title {
                    font-size: 1.875rem !important;
                }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Landing Page Layout -->
        <div class="landing-page">
            <!-- Navigation for Landing Page -->
            <nav class="landing-nav">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <h1 class="text-xl sm:text-2xl font-bold">
                                <span class="mykost-orange">MY</span><span class="mykost-blue">KOST</span>
                            </h1>
                        </div>

                        <!-- Desktop Navigation Links -->
                        <div class="hidden md:flex space-x-8">
                            <a href="#" class="text-gray-700 hover:text-blue-600 font-medium text-sm transition duration-200">Beranda</a>
                            <a href="#" class="text-gray-700 hover:text-blue-600 font-medium text-sm transition duration-200">Tentang</a>
                            <a href="#" class="text-gray-700 hover:text-blue-600 font-medium text-sm transition duration-200">Kamar</a>
                            <a href="#" class="text-gray-700 hover:text-blue-600 font-medium text-sm transition duration-200">Kontak</a>
                        </div>

                        <!-- Desktop Auth Buttons -->
                        <div class="hidden md:flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm transition duration-200">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition duration-200">
                                Daftar
                            </a>
                        </div>

                        <!-- Mobile Menu Button -->
                        <div class="md:hidden">
                            <button id="mobile-menu-btn" class="text-gray-700 hover:text-blue-600 p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Menu -->
                    <div id="mobile-menu" class="mobile-menu md:hidden pb-4">
                        <div class="space-y-2">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Beranda</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Tentang</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Kamar</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">Kontak</a>
                            <div class="border-t pt-4 mt-4">
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                                    Masuk
                                </a>
                                <a href="{{ route('register') }}" class="block px-4 py-2 bg-blue-600 text-white rounded-lg mt-2">
                                    Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <section class="hero-gradient py-12 sm:py-16 lg:py-20 text-center">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 class="hero-title text-4xl sm:text-5xl lg:text-6xl font-bold mb-4 sm:mb-6 leading-tight">
                        <span class="text-orange-400">MY</span><span class="text-white">KOST</span>
                    </h1>
                    <p class="hero-description text-base sm:text-lg lg:text-xl mb-8 sm:mb-10 text-blue-100 max-w-3xl mx-auto leading-relaxed">
                        Temukan kamar kost impian Anda dengan mudah. Booking online, pembayaran aman, dan layanan terpercaya.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center max-w-md mx-auto">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 sm:px-8 py-3 rounded-lg transition duration-200 transform hover:scale-105">
                            Mulai Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto bg-white bg-opacity-10 hover:bg-opacity-20 text-white font-semibold px-6 sm:px-8 py-3 rounded-lg border border-white border-opacity-30 transition duration-200">
                            Sudah Punya Akun?
                        </a>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section class="features-section py-12 sm:py-16 lg:py-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12 sm:mb-16">
                        <h2 class="section-title text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Mengapa Memilih MYKOST?</h2>
                        <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">Solusi lengkap untuk kebutuhan hunian kost Anda</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3">Pencarian Mudah</h3>
                            <p class="text-gray-600 leading-relaxed">Temukan kamar sesuai budget dan preferensi Anda dengan mudah</p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3">Booking Aman</h3>
                            <p class="text-gray-600 leading-relaxed">Sistem booking online yang aman dengan pembayaran digital</p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3">Layanan 24/7</h3>
                            <p class="text-gray-600 leading-relaxed">Customer service siap membantu Anda kapan saja</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Additional Content from Page -->
            {{ $slot }}

            <!-- Footer -->
            <footer class="footer-section py-8 sm:py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h3 class="text-xl sm:text-2xl font-bold mb-2">
                        <span class="text-orange-400">MY</span><span class="text-white">KOST</span>
                    </h3>
                    <p class="text-gray-400 mb-6">Platform kost terpercaya untuk hunian impian Anda</p>
                    <div class="border-t border-gray-700 pt-6">
                        <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} MYKOST. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Mobile Menu Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuBtn = document.getElementById('mobile-menu-btn');
                const mobileMenu = document.getElementById('mobile-menu');
                
                if (mobileMenuBtn && mobileMenu) {
                    mobileMenuBtn.addEventListener('click', function() {
                        mobileMenu.classList.toggle('active');
                    });
                }
            });
        </script>
    </body>
</html> 
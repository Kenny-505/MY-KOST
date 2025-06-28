<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MYKOST') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Landing page specific styles */
            .landing-page {
                background-color: #f8fafc;
            }
            
            /* Enhanced Modern Navigation */
            .landing-nav {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 50;
                backdrop-filter: blur(20px);
                background: rgba(255, 255, 255, 0.85);
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .landing-nav.scrolled {
                backdrop-filter: blur(20px);
                background: rgba(255, 255, 255, 0.95);
                box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }
            
            /* Modern Logo Styling */
            .nav-logo {
                background: linear-gradient(135deg, #f97316, #ea580c);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                font-weight: 800;
                font-size: 1.75rem;
                letter-spacing: -0.025em;
                position: relative;
            }
            
            .nav-logo::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 100%;
                height: 2px;
                background: linear-gradient(90deg, #f97316, #1e40af);
                border-radius: 1px;
                transform: scaleX(0);
                transition: transform 0.3s ease;
            }
            
            .nav-logo:hover::after {
                transform: scaleX(1);
            }
            
            /* Navigation Links */
            .nav-link {
                position: relative;
                color: #374151;
                font-weight: 500;
                font-size: 0.95rem;
                padding: 0.5rem 1rem;
                border-radius: 0.75rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                text-decoration: none;
            }
            
            .nav-link::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(249, 115, 22, 0.1), rgba(30, 64, 175, 0.1));
                border-radius: 0.75rem;
                opacity: 0;
                transform: scale(0.8);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .nav-link:hover::before {
                opacity: 1;
                transform: scale(1);
            }
            
            .nav-link:hover {
                color: #1e40af;
                transform: translateY(-1px);
            }
            
            /* Modern Button Styles */
            .btn-primary {
                background: linear-gradient(135deg, #3b82f6, #1e40af);
                color: white;
                font-weight: 600;
                padding: 0.75rem 1.5rem;
                border-radius: 1rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border: none;
                position: relative;
                overflow: hidden;
            }
            
            .btn-primary::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.6s;
            }
            
            .btn-primary:hover::before {
                left: 100%;
            }
            
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px -3px rgba(59, 130, 246, 0.3), 0 4px 6px -2px rgba(59, 130, 246, 0.15);
            }
            
            .btn-secondary {
                color: #1e40af;
                font-weight: 600;
                padding: 0.75rem 1.5rem;
                border-radius: 1rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border: 2px solid transparent;
                background: linear-gradient(white, white) padding-box, linear-gradient(135deg, #3b82f6, #f97316) border-box;
                position: relative;
            }
            
            .btn-secondary:hover {
                transform: translateY(-1px);
                box-shadow: 0 8px 20px -3px rgba(59, 130, 246, 0.2);
            }
            
            /* Mobile Menu Enhancement */
            .mobile-menu {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border-bottom-left-radius: 1.5rem;
                border-bottom-right-radius: 1.5rem;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .mobile-menu.active {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
            
            .mobile-menu-link {
                display: block;
                padding: 1rem 1.5rem;
                color: #374151;
                font-weight: 500;
                transition: all 0.3s ease;
                border-radius: 0.75rem;
                margin: 0.25rem;
            }
            
            .mobile-menu-link:hover {
                background: linear-gradient(135deg, rgba(249, 115, 22, 0.1), rgba(30, 64, 175, 0.1));
                color: #1e40af;
                transform: translateX(8px);
            }
            
            /* Hamburger Animation */
            .hamburger {
                width: 24px;
                height: 24px;
                position: relative;
                cursor: pointer;
            }
            
            .hamburger span {
                display: block;
                width: 100%;
                height: 2px;
                background: #374151;
                border-radius: 1px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: absolute;
            }
            
            .hamburger span:nth-child(1) { top: 6px; }
            .hamburger span:nth-child(2) { top: 11px; }
            .hamburger span:nth-child(3) { top: 16px; }
            
            .hamburger.active span:nth-child(1) {
                top: 11px;
                transform: rotate(45deg);
            }
            
            .hamburger.active span:nth-child(2) {
                opacity: 0;
            }
            
            .hamburger.active span:nth-child(3) {
                top: 11px;
                transform: rotate(-45deg);
            }
            
            /* Body padding for fixed nav */
            .landing-page {
                padding-top: 5rem;
            }
            
            /* Hero Section Adjustments */
            .hero-gradient {
                background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #3b82f6 100%) !important;
                color: white;
                position: relative;
                overflow: hidden;
            }
            
            .hero-gradient::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" style="stop-color:rgba(255,255,255,0.1)"/><stop offset="100%" style="stop-color:rgba(255,255,255,0)"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>') no-repeat center center;
                background-size: cover;
                opacity: 0.3;
            }
            
            .features-section {
                background-color: #ffffff;
            }
            
            .footer-section {
                background-color: #1f2937;
                color: #ffffff;
            }
            
            /* Responsive Design */
            @media (max-width: 768px) {
                .landing-page {
                    padding-top: 4rem;
                }
                
                .nav-logo {
                    font-size: 1.5rem;
                }
                
                .btn-primary, .btn-secondary {
                    padding: 0.625rem 1.25rem;
                    font-size: 0.9rem;
                }
            }
            
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
            <!-- Enhanced Modern Navigation -->
            <nav class="landing-nav" id="navbar">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <!-- Enhanced Logo -->
                        <div class="flex items-center">
                            <a href="/" class="nav-logo flex items-center">
                                <span class="text-3xl font-extrabold">MYKOST</span>
                            </a>
                        </div>

                        <!-- Desktop Navigation Links -->
                        <div class="hidden lg:flex items-center space-x-1">
                            <a href="#beranda" class="nav-link text-lg">Beranda</a>
                            <a href="#tentang" class="nav-link text-lg">Tentang</a>
                            <a href="#kamar" class="nav-link text-lg">Kamar</a>
                            <a href="#fitur" class="nav-link text-lg">Fitur</a>
                            <a href="#kontak" class="nav-link text-lg">Kontak</a>
                        </div>

                        <!-- Desktop Auth Buttons -->
                        <div class="hidden lg:flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="btn-secondary text-lg">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="btn-primary text-lg">
                                Daftar Sekarang
                            </a>
                        </div>

                        <!-- Mobile Menu Button -->
                        <div class="lg:hidden">
                            <button id="mobile-menu-btn" class="hamburger p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>

                    <!-- Enhanced Mobile Menu -->
                    <div id="mobile-menu" class="mobile-menu lg:hidden">
                        <div class="p-4 space-y-2">
                            <a href="#beranda" class="mobile-menu-link">Beranda</a>
                            <a href="#tentang" class="mobile-menu-link">Tentang</a>
                            <a href="#kamar" class="mobile-menu-link">Kamar</a>
                            <a href="#fitur" class="mobile-menu-link">Fitur</a>
                            <a href="#kontak" class="mobile-menu-link">Kontak</a>
                            
                            <div class="border-t border-gray-200 pt-4 mt-4 space-y-3">
                                <a href="{{ route('login') }}" class="block w-full text-center py-3 px-4 bg-gray-100 text-blue-600 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
                                    Masuk
                                </a>
                                <a href="{{ route('register') }}" class="block w-full text-center py-3 px-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                                    Daftar Sekarang
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

        <!-- Enhanced Interactive Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const navbar = document.getElementById('navbar');
                const mobileMenuBtn = document.getElementById('mobile-menu-btn');
                const mobileMenu = document.getElementById('mobile-menu');
                const hamburger = document.querySelector('.hamburger');
                
                // Navbar scroll effect
                let scrollTimeout;
                function handleScroll() {
                    if (scrollTimeout) {
                        clearTimeout(scrollTimeout);
                    }
                    
                    scrollTimeout = setTimeout(() => {
                        if (window.scrollY > 50) {
                            navbar.classList.add('scrolled');
                        } else {
                            navbar.classList.remove('scrolled');
                        }
                    }, 10);
                }
                
                window.addEventListener('scroll', handleScroll, { passive: true });
                
                // Mobile menu toggle
                if (mobileMenuBtn && mobileMenu && hamburger) {
                    mobileMenuBtn.addEventListener('click', function() {
                        mobileMenu.classList.toggle('active');
                        hamburger.classList.toggle('active');
                    });
                    
                    // Close mobile menu when clicking outside
                    document.addEventListener('click', function(event) {
                        if (!mobileMenuBtn.contains(event.target) && !mobileMenu.contains(event.target)) {
                            mobileMenu.classList.remove('active');
                            hamburger.classList.remove('active');
                        }
                    });
                    
                    // Close mobile menu when clicking on menu links
                    const mobileLinks = mobileMenu.querySelectorAll('.mobile-menu-link');
                    mobileLinks.forEach(link => {
                        link.addEventListener('click', function() {
                            mobileMenu.classList.remove('active');
                            hamburger.classList.remove('active');
                        });
                    });
                }
                
                // Smooth scrolling for anchor links
                const anchorLinks = document.querySelectorAll('a[href^="#"]');
                anchorLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        const targetId = this.getAttribute('href');
                        if (targetId !== '#' && targetId !== '#beranda') {
                            const targetElement = document.querySelector(targetId);
                            if (targetElement) {
                                e.preventDefault();
                                const offsetTop = targetElement.offsetTop - 100;
                                window.scrollTo({
                                    top: offsetTop,
                                    behavior: 'smooth'
                                });
                            }
                        }
                    });
                });
                
                // Button hover effects enhancement
                const buttons = document.querySelectorAll('.btn-primary, .btn-secondary');
                buttons.forEach(button => {
                    button.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-2px)';
                    });
                    
                    button.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0)';
                    });
                });
                
                // Add loading animation for auth buttons
                const authButtons = document.querySelectorAll('a[href*="login"], a[href*="register"]');
                authButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        if (!this.classList.contains('loading')) {
                            this.classList.add('loading');
                            const originalText = this.innerHTML;
                            this.innerHTML = '⏳ Memuat...';
                            
                            // Reset after navigation
                            setTimeout(() => {
                                this.innerHTML = originalText;
                                this.classList.remove('loading');
                            }, 2000);
                        }
                    });
                });
            });
        </script>
    </body>
</html> 
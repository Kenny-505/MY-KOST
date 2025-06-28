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
                color: #f97316 !important;
            }
            .mykost-blue {
                color: #1e40af !important;
            }
            
            /* Auth layout container */
            .auth-container {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }
            
            @media (min-width: 1024px) {
                .auth-container {
                    flex-direction: row;
                }
            }
            
            /* Auth background image */
            .auth-bg-image {
                background-image: url('{{ asset('images/kost-background.png') }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                position: relative;
                min-height: 200px;
                border-radius: 0.75rem;
                overflow: hidden;
            }
            
            @media (min-width: 1024px) {
                .auth-bg-image {
                    min-height: 100vh;
                    border-radius: 2rem;
                }
            }
            
            /* Auth form panel */
            .auth-form-panel {
                flex: 1;
                padding: 2rem;
                background: white;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            @media (min-width: 1024px) {
                .auth-form-panel {
                    flex: 0 0 50%;
                    padding: 3rem;
                }
                
                .auth-bg-image {
                    flex: 0 0 50%;
                }
            }
            
            /* Form styling */
            .auth-form {
                width: 100%;
                max-width: 28rem;
            }
            
            .form-input {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid #d1d5db;
                border-radius: 0.5rem;
                background-color: #f9fafb;
                transition: all 0.2s;
            }
            
            .form-input:focus {
                outline: none;
                ring: 2px;
                ring-color: #3b82f6;
                border-color: #3b82f6;
            }
            
            .btn-primary {
                width: 100%;
                background-color: #2563eb;
                color: white;
                padding: 0.75rem 1rem;
                border-radius: 0.5rem;
                font-weight: 600;
                transition: all 0.2s;
                border: none;
                cursor: pointer;
            }
            
            .btn-primary:hover {
                background-color: #1d4ed8;
                transform: translateY(-1px);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Auth Pages Layout (Login, Register, etc.) -->
        <div class="auth-container">
            {{ $slot }}
        </div>
    </body>
</html>


<x-guest-layout>
    <!-- Left Panel - Login Form -->
    <div class="auth-form-panel">
    <div class="auth-form">
        <!-- MYKOST Logo -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold">
                <span class="mykost-orange">MY</span><span class="mykost-blue">KOST</span>
            </h1>
        </div>

        <!-- Welcome Message -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back !!</h2>
            <p class="text-gray-600">Please enter your credentials to log in</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input id="email" 
                       type="email" 
                       name="email" 
                       :value="old('email')" 
                       required 
                       autofocus 
                       autocomplete="username"
                       placeholder="Example@email.com"
                       class="form-input" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input id="password" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="current-password"
                       placeholder="At least 8 characters"
                       class="form-input" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Forgot Password Link -->
            <div class="text-right">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" name="remember">
                <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember me</label>
            </div>

            <!-- Sign In Button -->
            <button type="submit" class="btn-primary">
                Sign In
            </button>
        </form>

        <!-- Register Link -->
        <div class="mt-8 text-center">
            <p class="text-gray-600">
                New to our platform? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Sign Up now.
                </a>
            </p>
        </div>
    </div>
</div>

<!-- Right Panel - Background Image -->
<div class="auth-bg-image hidden lg:flex lg:items-center lg:justify-center relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    <div class="relative z-10 text-center text-white p-8">
        <h1 class="text-6xl font-bold mb-8">
            MY<span class="text-white">KOST</span>
        </h1>
        <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 border border-white border-opacity-20">
            <p class="text-xl mb-4">New to our platform? Sign Up now.</p>
            <a href="{{ route('register') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200 transform hover:scale-105">
                Sign Up
            </a>
        </div>
    </div>
</div>
</x-guest-layout>

<x-guest-layout>
    <!-- Left Panel - Forgot Password Form -->
    <div class="auth-form-panel">
        <div class="auth-form">
            <!-- MYKOST Logo -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold">
                    <span class="mykost-orange">MY</span><span class="mykost-blue">KOST</span>
                </h1>
            </div>

            <!-- Reset Password Message -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Reset Password</h2>
                <p class="text-gray-600 leading-relaxed">
                    Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Forgot Password Form -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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
                           placeholder="Example@email.com"
                           class="form-input" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Send Reset Link Button -->
                <button type="submit" class="btn-primary">
                    Email Password Reset Link
                </button>
            </form>

            <!-- Back to Login Link -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Remember your password? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        Back to Sign In
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
                <p class="text-xl mb-4">Need help accessing your account?</p>
                <p class="text-base opacity-90">We'll help you get back in securely.</p>
            </div>
        </div>
    </div>
</x-guest-layout>

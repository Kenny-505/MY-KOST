<x-guest-layout>
    <!-- Left Panel - Reset Password Form -->
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
                <h2 class="text-3xl font-bold text-gray-900 mb-2">New Password</h2>
                <p class="text-gray-600">Create a new secure password for your account</p>
            </div>

            <!-- Reset Password Form -->
            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           :value="old('email', $request->email)" 
                           required 
                           autofocus 
                           autocomplete="username"
                           placeholder="Example@email.com"
                           class="form-input" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="new-password"
                           placeholder="At least 8 characters"
                           class="form-input" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <input id="password_confirmation" 
                           type="password" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password"
                           placeholder="At least 8 characters"
                           class="form-input" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Reset Password Button -->
                <button type="submit" class="btn-primary">
                    Reset Password
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
                <p class="text-xl mb-4">Secure your account</p>
                <p class="text-base opacity-90">Choose a strong password to protect your data.</p>
            </div>
        </div>
    </div>
</x-guest-layout>

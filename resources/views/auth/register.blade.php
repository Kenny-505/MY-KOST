<x-guest-layout>
    <!-- Left Panel - Background Image -->
    <div class="auth-bg-image hidden lg:flex lg:items-center lg:justify-center relative overflow-hidden">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="relative z-10 text-center text-white p-8">
            <h1 class="text-6xl font-bold mb-8">
                MY<span class="text-white">KOST</span>
            </h1>
            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 border border-white border-opacity-20">
                <p class="text-xl mb-4">Already have an account? Sign in now.</p>
                <a href="{{ route('login') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200 transform hover:scale-105">
                    Sign In
                </a>
            </div>
        </div>
    </div>

    <!-- Right Panel - Register Form -->
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
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Hi, Welcome!!</h2>
                <p class="text-gray-600">Create your account to get started</p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Username (Nama) -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input id="nama" 
                           type="text" 
                           name="nama" 
                           :value="old('nama')" 
                           required 
                           autofocus 
                           autocomplete="name"
                           placeholder="@Example123"
                           class="form-input" />
                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           :value="old('email')" 
                           required 
                           autocomplete="username"
                           placeholder="Example@email.com"
                           class="form-input" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- No HP -->
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">No. Handphone</label>
                    <input id="no_hp" 
                           type="tel" 
                           name="no_hp" 
                           :value="old('no_hp')" 
                           required 
                           autocomplete="tel"
                           placeholder="08123456789"
                           class="form-input" />
                    <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
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
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input id="password_confirmation" 
                           type="password" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password"
                           placeholder="At least 8 characters"
                           class="form-input" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Register Button -->
                <button type="submit" class="btn-primary mt-6">
                    Register
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        Sign in now.
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>

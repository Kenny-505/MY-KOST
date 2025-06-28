<x-guest-layout>
    <!-- Left Panel - Confirm Password Form -->
    <div class="auth-form-panel">
        <div class="auth-form">
            <!-- MYKOST Logo -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold">
                    <span class="mykost-orange">MY</span><span class="mykost-blue">KOST</span>
                </h1>
            </div>

            <!-- Security Message -->
            <div class="text-center mb-8">
                <div class="mx-auto mb-4 w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Konfirmasi Password</h2>
                <p class="text-gray-600 leading-relaxed">
                    Ini adalah area aman aplikasi. Silakan konfirmasi password Anda sebelum melanjutkan.
                </p>
            </div>

            <!-- Confirm Password Form -->
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           placeholder="Masukkan password Anda"
                           class="form-input" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Button -->
                <button type="submit" class="btn-primary">
                    Konfirmasi
                </button>
            </form>

            <!-- Back Link -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        Kembali ke Dashboard
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
                <p class="text-xl mb-4">Keamanan Terjamin</p>
                <p class="text-base opacity-90">Verifikasi identitas untuk melindungi akun Anda.</p>
            </div>
        </div>
    </div>
</x-guest-layout>

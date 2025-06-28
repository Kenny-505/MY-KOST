<x-guest-layout>
    <!-- Left Panel - Email Verification Form -->
    <div class="auth-form-panel">
        <div class="auth-form">
            <!-- MYKOST Logo -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold">
                    <span class="mykost-orange">MY</span><span class="mykost-blue">KOST</span>
                </h1>
            </div>

            <!-- Verification Message -->
            <div class="text-center mb-8">
                <div class="mx-auto mb-4 w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Verifikasi Email Anda</h2>
                <p class="text-gray-600 leading-relaxed">
                    Terima kasih telah mendaftar di MYKOST! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik link yang telah kami kirimkan. Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan ulang.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                Link verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="space-y-4">
                <!-- Resend Verification Email -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn-primary">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-lg transition duration-200">
                        Keluar
                    </button>
                </form>
            </div>

            <!-- Help Text -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    Belum menerima email? Cek folder spam atau tunggu beberapa menit.
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
                <p class="text-xl mb-4">Hampir selesai!</p>
                <p class="text-base opacity-90">Verifikasi email Anda untuk mengakses semua fitur MYKOST.</p>
            </div>
        </div>
    </div>
</x-guest-layout>

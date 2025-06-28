<x-landing-layout>
    <!-- Stats Section -->
    <section class="bg-white py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">MYKOST dalam Angka</h2>
                <p class="text-gray-600 text-base sm:text-lg">Data real-time sistem kami</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <div class="text-center bg-gray-50 p-6 sm:p-8 rounded-xl border border-gray-200">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-blue-600 mb-2">
                        {{ $stats['total_rooms'] }}
                    </div>
                    <p class="text-gray-700 font-medium">Total Kamar</p>
                </div>

                <div class="text-center bg-green-50 p-6 sm:p-8 rounded-xl border border-green-200">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-green-600 mb-2">
                        {{ $stats['available_rooms'] }}
                    </div>
                    <p class="text-gray-700 font-medium">Kamar Tersedia</p>
                </div>

                <div class="text-center bg-purple-50 p-6 sm:p-8 rounded-xl border border-purple-200 sm:col-span-2 lg:col-span-1">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-purple-600 mb-2">
                        {{ $stats['room_types'] }}
                    </div>
                    <p class="text-gray-700 font-medium">Tipe Kamar</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Room Types Section -->
    <section class="bg-gray-50 py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Tipe Kamar Tersedia</h2>
                <p class="text-gray-600 text-base sm:text-lg">Pilih kamar yang sesuai dengan kebutuhan Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
                @forelse($roomTypes as $roomType)
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        
                        <!-- Room Image Placeholder -->
                        <div class="bg-gradient-to-br from-blue-500 to-purple-600 h-48 sm:h-52 flex items-center justify-center relative">
                            <div class="text-white text-center">
                                <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-sm opacity-90">Foto Kamar</p>
                            </div>
                        </div>

                        <!-- Room Info -->
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg sm:text-xl font-semibold text-gray-900">
                                    {{ $roomType->tipe_kamar }}
                                </h3>
                                
                                @if($roomType->available_rooms_count > 0)
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1 rounded-full">
                                        {{ $roomType->available_rooms_count }} Tersedia
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-1 rounded-full">
                                        Penuh
                                    </span>
                                @endif
                            </div>

                            <!-- Facilities Icons -->
                            <div class="flex flex-wrap gap-3 mb-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2H3v2zm9 0v2m0 4v2m-4-3h8"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-600">AC</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-600">WiFi</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5M9 7h6m-6 4h6m-6 4h6"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-600">Kasur</span>
                                </div>
                            </div>

                            <!-- Room Stats -->
                            <div class="grid grid-cols-3 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                                <div class="text-center">
                                    <p class="text-lg sm:text-xl font-semibold text-gray-900">{{ $roomType->kamars_count }}</p>
                                    <p class="text-xs text-gray-600">Total Kamar</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-lg sm:text-xl font-semibold text-green-600">{{ $roomType->available_rooms_count }}</p>
                                    <p class="text-xs text-gray-600">Tersedia</p>
                                </div>
                                <div class="text-center">
                                    @if($roomType->paketKamars->count() > 0)
                                        <p class="text-lg sm:text-xl font-semibold text-blue-600">
                                            Rp {{ number_format($roomType->paketKamars->first()->harga / 1000000, 1) }}M
                                        </p>
                                        <p class="text-xs text-gray-600">Per Bulan</p>
                                    @else
                                        <p class="text-lg sm:text-xl font-semibold text-gray-500">-</p>
                                        <p class="text-xs text-gray-600">Hubungi Admin</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="text-center">
                                @if($roomType->available_rooms_count > 0)
                                    <a href="{{ route('login') }}" class="w-full inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105">
                                        Pesan Sekarang
                                    </a>
                                @else
                                    <button class="w-full bg-gray-300 text-gray-500 font-medium py-3 px-6 rounded-lg cursor-not-allowed" disabled>
                                        Tidak Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                            </svg>
                            <p class="text-lg font-medium">Belum ada tipe kamar tersedia</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="bg-white py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Apa Kata Mereka?</h2>
                <p class="text-gray-600 text-base sm:text-lg">Testimoni dari pengguna MYKOST</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <div class="bg-blue-50 p-6 rounded-xl border-l-4 border-blue-600">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-semibold">A</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Ahmad Rizki</h4>
                            <p class="text-gray-600 text-sm">Mahasiswa</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic">"MYKOST sangat memudahkan saya mencari kost yang sesuai budget. Prosesnya cepat dan aman!"</p>
                </div>

                <div class="bg-green-50 p-6 rounded-xl border-l-4 border-green-600">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-semibold">S</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Sari Dewi</h4>
                            <p class="text-gray-600 text-sm">Karyawan</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic">"Interface yang user-friendly dan customer service yang responsif. Recommended!"</p>
                </div>

                <div class="bg-purple-50 p-6 rounded-xl border-l-4 border-purple-600 md:col-span-2 lg:col-span-1">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-semibold">B</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Budi Santoso</h4>
                            <p class="text-gray-600 text-sm">Freelancer</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic">"Fitur pembayaran digital sangat membantu. Tidak perlu ribet bayar cash!"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-700 text-white py-12 sm:py-16 lg:py-20 text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 sm:mb-6">Siap Menemukan Kost Impian?</h2>
            <p class="text-base sm:text-lg lg:text-xl mb-8 sm:mb-10 text-blue-100 leading-relaxed">Bergabunglah dengan ribuan pengguna MYKOST dan temukan hunian yang tepat untuk Anda</p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center max-w-md mx-auto">
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 sm:px-8 py-3 rounded-lg transition duration-200 transform hover:scale-105">
                    Daftar Gratis Sekarang
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto bg-white bg-opacity-10 hover:bg-opacity-20 text-white font-semibold px-6 sm:px-8 py-3 rounded-lg border border-white border-opacity-30 transition duration-200">
                    Sudah Punya Akun?
                </a>
            </div>
        </div>
    </section>
</x-landing-layout>

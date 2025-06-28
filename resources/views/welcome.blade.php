<x-landing-layout>
    <!-- Enhanced Hero Section with Search -->
    <section id="beranda" class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white py-20 overflow-hidden">
        <!-- Background Animation -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-10 left-10 w-72 h-72 bg-orange-400 rounded-full filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-80 h-80 bg-blue-400 rounded-full filter blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-400 rounded-full filter blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Main Hero Content -->
            <div class="mb-12">
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold mb-6 leading-tight">
                    <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">MY</span><span class="text-white">KOST</span>
                </h1>
                <p class="text-xl sm:text-2xl lg:text-3xl mb-4 text-blue-100 font-light">
                    Temukan Rumah Kedua Anda
                </p>
                <p class="text-lg sm:text-xl text-blue-200 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Platform terdepan untuk mencari dan memesan kamar kost dengan mudah, aman, dan terpercaya
                </p>
            </div>

            <!-- Quick Search Bar -->
            <div class="max-w-2xl mx-auto mb-12">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <h3 class="text-lg font-semibold mb-4 text-white">Cari Kamar Impian Anda</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <select class="w-full px-4 py-3 rounded-lg bg-white/90 text-gray-800 font-medium focus:ring-4 focus:ring-orange-300 transition duration-200">
                            <option>Pilih Tipe Kamar</option>
                            <option>Standar</option>
                            <option>Elite</option>
                            <option>Exclusive</option>
                        </select>
                        <select class="w-full px-4 py-3 rounded-lg bg-white/90 text-gray-800 font-medium focus:ring-4 focus:ring-orange-300 transition duration-200">
                            <option>Range Harga</option>
                            <option>< 1 Juta</option>
                            <option>1-3 Juta</option>
                            <option>> 3 Juta</option>
                        </select>
                        <button class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 shadow-lg">
                            Cari Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center max-w-md mx-auto">
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold px-8 py-4 rounded-xl transition duration-200 transform hover:scale-105 shadow-xl">
                    Mulai Sekarang
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 text-white font-semibold px-8 py-4 rounded-xl border border-white/30 transition duration-200 backdrop-blur-sm">
                    Sudah Punya Akun?
                </a>
            </div>
        </div>
    </section>

    <!-- Enhanced Features Section -->
    <section id="fitur" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                    Mengapa <span class="bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">MYKOST</span>?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Kami memberikan pengalaman terbaik dalam mencari dan mengelola hunian kost
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="group">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform group-hover:-translate-y-2 border border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Pencarian Smart</h3>
                        <p class="text-gray-600 leading-relaxed">Filter cerdas berdasarkan lokasi, harga, dan fasilitas untuk menemukan kamar yang perfect</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="group">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform group-hover:-translate-y-2 border border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Booking Instan</h3>
                        <p class="text-gray-600 leading-relaxed">Sistem booking real-time dengan konfirmasi otomatis dan pembayaran digital yang aman</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="group">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform group-hover:-translate-y-2 border border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Keamanan Terjamin</h3>
                        <p class="text-gray-600 leading-relaxed">Data dan transaksi Anda dilindungi dengan enkripsi tingkat bank dan verifikasi berlapis</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="group">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform group-hover:-translate-y-2 border border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Support 24/7</h3>
                        <p class="text-gray-600 leading-relaxed">Tim customer service siap membantu Anda kapan saja melalui berbagai channel komunikasi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section with Animation -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 py-20 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold mb-6">MYKOST dalam Angka</h2>
                <p class="text-xl text-blue-100">Kepercayaan ribuan pengguna adalah prioritas kami</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 hover:bg-white/20 transition duration-300">
                        <div class="text-5xl font-bold text-orange-400 mb-2 group-hover:scale-110 transition duration-300">
                            {{ $stats['total_rooms'] }}+
                        </div>
                        <p class="text-blue-100 font-medium text-lg">Total Kamar</p>
                        <p class="text-blue-200 text-sm mt-1">Tersebar di berbagai lokasi</p>
                    </div>
                </div>

                <div class="text-center group">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 hover:bg-white/20 transition duration-300">
                        <div class="text-5xl font-bold text-green-400 mb-2 group-hover:scale-110 transition duration-300">
                        {{ $stats['available_rooms'] }}
                        </div>
                        <p class="text-blue-100 font-medium text-lg">Kamar Tersedia</p>
                        <p class="text-blue-200 text-sm mt-1">Siap untuk ditempati</p>
                    </div>
                </div>

                <div class="text-center group">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 hover:bg-white/20 transition duration-300">
                        <div class="text-5xl font-bold text-purple-400 mb-2 group-hover:scale-110 transition duration-300">
                        {{ $stats['room_types'] }}
                        </div>
                        <p class="text-blue-100 font-medium text-lg">Tipe Kamar</p>
                        <p class="text-blue-200 text-sm mt-1">Sesuai kebutuhan Anda</p>
                    </div>
                </div>

                <div class="text-center group">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 hover:bg-white/20 transition duration-300">
                        <div class="text-5xl font-bold text-yellow-400 mb-2 group-hover:scale-110 transition duration-300">
                            99%
                        </div>
                        <p class="text-blue-100 font-medium text-lg">Kepuasan User</p>
                        <p class="text-blue-200 text-sm mt-1">Rating dari pengguna</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Room Types Section -->
    <section id="kamar" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">Pilihan Kamar Premium</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Dari standar hingga mewah, temukan kamar yang sesuai dengan gaya hidup Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @forelse($roomTypes as $roomType)
                    <div class="group bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100">
                        
                        <!-- Enhanced Room Image -->
                        <div class="relative bg-gradient-to-br 
                            @if($roomType->tipe_kamar == 'Standar') from-green-500 to-green-600
                            @elseif($roomType->tipe_kamar == 'Elite') from-blue-500 to-blue-600
                            @else from-purple-500 to-purple-600 @endif 
                            h-56 flex items-center justify-center overflow-hidden">
                            
                            <!-- Floating Elements -->
                            <div class="absolute top-4 left-4 w-8 h-8 bg-white/20 rounded-full animate-bounce"></div>
                            <div class="absolute top-8 right-6 w-4 h-4 bg-white/30 rounded-full animate-pulse"></div>
                            <div class="absolute bottom-6 left-8 w-6 h-6 bg-white/25 rounded-full animate-bounce" style="animation-delay: 1s;"></div>
                            
                            <div class="text-white text-center z-10 group-hover:scale-110 transition duration-300">
                                <svg class="w-16 h-16 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-lg font-semibold">{{ $roomType->tipe_kamar }}</p>
                            </div>
                            
                            <!-- Premium Badge -->
                            @if($roomType->tipe_kamar == 'Exclusive')
                                <div class="absolute top-4 right-4 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-sm font-bold">
                                    Premium
                                </div>
                            @endif
                        </div>

                        <!-- Enhanced Room Info -->
                        <div class="p-8">
                            <div class="flex justify-between items-start mb-6">
                                <h3 class="text-2xl font-bold text-gray-900">
                                    {{ $roomType->tipe_kamar }}
                                </h3>
                                
                                @if($roomType->available_rooms_count > 0)
                                    <span class="bg-green-100 text-green-800 text-sm font-bold px-3 py-1 rounded-full animate-pulse">
                                        {{ $roomType->available_rooms_count }} Tersedia
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-sm font-bold px-3 py-1 rounded-full">
                                        Penuh
                                    </span>
                                @endif
                            </div>

                            <!-- Enhanced Facilities -->
                            <div class="grid grid-cols-3 gap-4 mb-6">
                                <div class="text-center p-3 bg-blue-50 rounded-xl">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2H3v2zm9 0v2m0 4v2m-4-3h8"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium text-blue-600">AC</span>
                                </div>

                                <div class="text-center p-3 bg-yellow-50 rounded-xl">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium text-yellow-600">WiFi</span>
                                </div>

                                <div class="text-center p-3 bg-green-50 rounded-xl">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5M9 7h6m-6 4h6m-6 4h6"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium text-green-600">Kasur</span>
                                </div>
                            </div>

                            <!-- Enhanced Stats -->
                            <div class="bg-gray-50 rounded-2xl p-6 mb-6">
                                <div class="grid grid-cols-3 gap-4">
                                <div class="text-center">
                                        <p class="text-2xl font-bold text-gray-900">{{ $roomType->kamars_count }}</p>
                                        <p class="text-xs text-gray-600 font-medium">Total</p>
                                </div>
                                <div class="text-center">
                                        <p class="text-2xl font-bold text-green-600">{{ $roomType->available_rooms_count }}</p>
                                        <p class="text-xs text-gray-600 font-medium">Tersedia</p>
                                </div>
                                <div class="text-center">
                                    @if($roomType->paketKamars->count() > 0)
                                            <p class="text-xl font-bold text-blue-600">
                                                {{ number_format($roomType->paketKamars->first()->harga / 1000000, 1) }}M
                                        </p>
                                            <p class="text-xs text-gray-600 font-medium">Per Bulan</p>
                                    @else
                                            <p class="text-xl font-bold text-gray-500">-</p>
                                            <p class="text-xs text-gray-600 font-medium">Hubungi</p>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Action Button -->
                            <div class="text-center">
                                @if($roomType->available_rooms_count > 0)
                                    <a href="{{ route('login') }}" class="w-full inline-block bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg">
                                        Pesan Sekarang
                                    </a>
                                @else
                                    <button class="w-full bg-gray-200 text-gray-500 font-bold py-4 px-6 rounded-xl cursor-not-allowed" disabled>
                                        Tidak Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="text-gray-400">
                            <svg class="w-24 h-24 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                            </svg>
                            <p class="text-2xl font-bold mb-2">Belum ada kamar tersedia</p>
                            <p class="text-gray-500">Segera hadir untuk Anda</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-20 bg-gradient-to-br from-blue-50 to-indigo-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-8">
                        Tentang <span class="bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">MYKOST</span>
                    </h2>
                    <p class="text-xl text-gray-700 mb-6 leading-relaxed">
                        MYKOST adalah platform digital terdepan yang menghubungkan pencari hunian dengan penyedia kost terpercaya. Kami berkomitmen memberikan pengalaman terbaik dalam mencari, memesan, dan mengelola hunian kost.
                    </p>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Dengan teknologi modern dan tim customer service yang berpengalaman, kami memastikan setiap transaksi berjalan aman dan nyaman.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-orange-200">
                            <div class="text-3xl font-bold text-orange-600 mb-2">2019</div>
                            <p class="text-gray-600 font-medium">Tahun Berdiri</p>
                        </div>
                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-blue-200">
                            <div class="text-3xl font-bold text-blue-600 mb-2">10K+</div>
                            <p class="text-gray-600 font-medium">Pengguna Aktif</p>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="bg-gradient-to-br from-orange-500 to-blue-600 rounded-3xl p-8 transform rotate-3 shadow-2xl">
                        <div class="bg-white rounded-2xl p-8 transform -rotate-3">
                            <div class="text-center mb-6">
                                <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="text-white font-bold text-2xl">MK</span>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">MYKOST</h3>
                                <p class="text-gray-600">Platform Kost Terpercaya</p>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-gray-700">Proses booking mudah & cepat</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-gray-700">Pembayaran 100% aman</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-gray-700">Customer service 24/7</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-gray-700">Kamar berkualitas terjamin</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontak" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                    Hubungi <span class="bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">Kami</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Tim customer service kami siap membantu Anda 24/7</p>
            </div>

            <!-- Contact Info Cards - Horizontal Layout -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Telepon -->
                <div class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Telepon</h3>
                    <p class="text-gray-600 mb-2">Hubungi kami langsung</p>
                    <p class="text-blue-600 font-bold text-lg">+62 812-3456-7890</p>
                </div>

                <!-- Email -->
                <div class="group bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Email</h3>
                    <p class="text-gray-600 mb-2">Kirim pesan email</p>
                    <p class="text-green-600 font-bold text-lg">info@mykost.com</p>
                </div>

                <!-- Alamat -->
                <div class="group bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Alamat</h3>
                    <p class="text-gray-600 mb-2">Kantor pusat kami</p>
                    <p class="text-purple-600 font-bold text-lg">Jakarta, Indonesia</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Testimonials Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                    Cerita <span class="bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">Sukses</span> Pengguna
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Ribuan pengguna telah merasakan kemudahan MYKOST</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="group bg-white p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-orange-100">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition duration-300">
                            <span class="text-white font-bold text-xl">A</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">Ahmad Rizki</h4>
                            <p class="text-orange-600 text-sm font-medium">Mahasiswa UI</p>
                            <div class="flex mt-1">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 italic leading-relaxed">
                        "MYKOST sangat memudahkan saya mencari kost yang sesuai budget. Interface-nya intuitif dan proses booking-nya super cepat!"
                    </p>
                </div>

                <div class="group bg-white p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-green-100">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition duration-300">
                            <span class="text-white font-bold text-xl">S</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">Sari Dewi</h4>
                            <p class="text-green-600 text-sm font-medium">Fresh Graduate</p>
                            <div class="flex mt-1">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 italic leading-relaxed">
                        "Customer service yang responsif dan kamar yang bersih sesuai foto. Pengalaman yang sangat memuaskan!"
                    </p>
                </div>

                <div class="group bg-white p-8 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-purple-100">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition duration-300">
                            <span class="text-white font-bold text-xl">B</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">Budi Santoso</h4>
                            <p class="text-purple-600 text-sm font-medium">Digital Nomad</p>
                            <div class="flex mt-1">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 italic leading-relaxed">
                        "Sistem pembayaran digital yang modern dan aman. Cocok banget buat yang sering pindah-pindah kota!"
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced CTA Section -->
    <section class="relative bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 text-white py-24 overflow-hidden">
        <!-- Background Animation -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-20 w-64 h-64 bg-orange-400 rounded-full filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-20 w-72 h-72 bg-purple-400 rounded-full filter blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>
        
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-5xl sm:text-6xl font-bold mb-8">
                Siap Menemukan <span class="bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">Rumah Baru</span>?
            </h2>
            <p class="text-xl sm:text-2xl mb-12 text-blue-100 max-w-4xl mx-auto leading-relaxed">
                Bergabunglah dengan ribuan pengguna MYKOST dan rasakan kemudahan mencari hunian impian
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center max-w-lg mx-auto mb-12">
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold px-10 py-5 rounded-2xl transition duration-200 transform hover:scale-105 shadow-2xl">
                    Daftar Gratis Sekarang
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 text-white font-bold px-10 py-5 rounded-2xl border border-white/30 transition duration-200 backdrop-blur-sm">
                    Sudah Punya Akun?
                </a>
            </div>

            <!-- Trust Indicators -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-3xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl mb-2">🔒</div>
                    <p class="text-sm text-blue-200">Keamanan Terjamin</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl mb-2">⚡</div>
                    <p class="text-sm text-blue-200">Booking Instan</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl mb-2">💯</div>
                    <p class="text-sm text-blue-200">100% Terpercaya</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl mb-2">🎯</div>
                    <p class="text-sm text-blue-200">Pilihan Terbaik</p>
                </div>
            </div>
        </div>
    </section>
</x-landing-layout>

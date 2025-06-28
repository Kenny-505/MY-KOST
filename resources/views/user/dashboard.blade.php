<x-user-layout>
    <!-- Main Content -->
    <div class="flex-1 bg-gray-50 p-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
            <p class="text-gray-600">Selamat datang kembali di MYKOST, {{ Auth::user()->nama }}!</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Available Rooms -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Kamar Tersedia</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $availableRooms }}</p>
                    </div>
                </div>
            </div>

            <!-- Room Types -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Tipe Kamar</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $roomTypes->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Your Bookings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Booking Saya</p>
                        <p class="text-2xl font-bold text-gray-900">{{ Auth::user()->penghuni()->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Room Types -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Tipe Kamar Tersedia</h2>
                    <p class="text-gray-600 text-sm">Pilih tipe kamar yang sesuai dengan kebutuhan Anda</p>
                </div>
                <a href="{{ route('user.rooms.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition duration-200">
                    <span>Lihat Semua</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            @if($roomTypes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($roomTypes as $type)
                        <div class="border border-gray-200 rounded-lg p-6 hover:border-blue-300 hover:shadow-md transition duration-200">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $type->tipe_kamar }}</h3>
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ $type->kamars()->where('status', 'Kosong')->count() }} tersedia
                                </span>
                            </div>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2H3v2zm9 0v2m0 4v2m-4-3h8"></path>
                                    </svg>
                                    {{ $type->fasilitas ?? 'Fasilitas standar' }}
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Tipe: {{ $type->tipe_kamar }}
                                </div>
                            </div>

                            @if($type->paketKamars()->count() > 0)
                                <div class="border-t pt-4">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Harga mulai dari:</p>
                                    <p class="text-2xl font-bold text-blue-600">
                                        Rp {{ number_format($type->paketKamars()->min('harga'), 0, ',', '.') }}
                                        <span class="text-sm font-normal text-gray-500">/bulan</span>
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Tipe Kamar</h3>
                    <p class="text-gray-500">Tipe kamar belum tersedia saat ini.</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Menu Cepat</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Browse Rooms -->
                <a href="{{ route('user.rooms.index') }}" class="group p-6 border border-gray-200 rounded-xl hover:border-blue-300 hover:bg-blue-50 transition duration-200 text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition duration-200">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Cari Kamar</h3>
                    <p class="text-xs text-gray-600">Temukan kamar yang sesuai</p>
                </a>

                <!-- Make Booking -->
                <a href="{{ route('user.booking.create') }}" class="group p-6 border border-gray-200 rounded-xl hover:border-green-300 hover:bg-green-50 transition duration-200 text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition duration-200">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Booking Baru</h3>
                    <p class="text-xs text-gray-600">Pesan kamar sekarang</p>
                </a>

                @if(Auth::user()->hasActivePenghuni())
                    <!-- Complaint -->
                    <a href="{{ route('penghuni.pengaduan.index') }}" class="group p-6 border border-gray-200 rounded-xl hover:border-orange-300 hover:bg-orange-50 transition duration-200 text-center">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-200 transition duration-200">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Pengaduan</h3>
                        <p class="text-xs text-gray-600">Laporkan masalah</p>
                    </a>

                    <!-- Invoice History -->
                    <a href="{{ route('penghuni.history.index') }}" class="group p-6 border border-gray-200 rounded-xl hover:border-purple-300 hover:bg-purple-50 transition duration-200 text-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-200 transition duration-200">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Riwayat Invoice</h3>
                        <p class="text-xs text-gray-600">Lihat pembayaran</p>
                    </a>
                @else
                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}" class="group p-6 border border-gray-200 rounded-xl hover:border-gray-400 hover:bg-gray-50 transition duration-200 text-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:bg-gray-200 transition duration-200">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Profil</h3>
                        <p class="text-xs text-gray-600">Kelola akun</p>
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-user-layout> 
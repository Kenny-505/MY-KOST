@extends('layouts.user')

@section('content')
<!-- Hero Section with Gradient Background -->
<div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-orange-600 overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Welcome Header -->
        <div class="text-center text-white mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Selamat Datang, <span class="text-orange-300">{{ Auth::user()->nama }}</span>
            </h1>
            <div class="flex items-center justify-center text-blue-100 mb-6">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-lg">User Verified</span>
            </div>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                Temukan kamar kost impian Anda dengan fasilitas terbaik dan harga terjangkau
            </p>
        </div>

        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Available Rooms -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 text-center">
                <svg class="w-12 h-12 text-white mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                </svg>
                <p class="text-blue-100 text-sm font-medium mb-2">Kamar Tersedia</p>
                <p class="text-4xl font-bold text-white mb-1">{{ $availableRooms }}</p>
                <p class="text-blue-200 text-xs">Siap untuk dihuni</p>
            </div>

            <!-- Room Types -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 text-center">
                <svg class="w-12 h-12 text-white mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                <p class="text-blue-100 text-sm font-medium mb-2">Tipe Kamar</p>
                <p class="text-4xl font-bold text-white mb-1">{{ $roomTypes->count() }}</p>
                <p class="text-blue-200 text-xs">Pilihan berbeda</p>
            </div>

            <!-- Your Bookings -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 text-center">
                <svg class="w-12 h-12 text-white mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-blue-100 text-sm font-medium mb-2">Booking Saya</p>
                <p class="text-4xl font-bold text-white mb-1">{{ Auth::user()->penghuni()->count() }}</p>
                <p class="text-blue-200 text-xs">Total reservasi</p>
            </div>
        </div>

        <!-- CTA Button -->
        <div class="text-center">
            <a href="{{ route('user.rooms.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-white text-blue-600 text-lg font-semibold rounded-xl hover:bg-gray-50 transition duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Jelajahi Kamar Sekarang
            </a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Available Room Types Section -->
        <div class="mb-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Tipe Kamar Pilihan</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Dapatkan pengalaman menginap terbaik dengan berbagai pilihan kamar yang sesuai dengan kebutuhan dan budget Anda
                </p>
            </div>

            @if($roomTypes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($roomTypes as $type)
                        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden border border-gray-100">
                            <!-- Card Header with Type Badge -->
                            <div class="relative p-6 bg-gradient-to-r @if($type->tipe_kamar === 'Standar') from-green-400 to-green-600 @elseif($type->tipe_kamar === 'Elite') from-blue-400 to-blue-600 @else from-purple-400 to-purple-600 @endif">
                                <div class="flex items-center justify-between text-white">
                                    <h3 class="text-xl font-bold">{{ $type->tipe_kamar }}</h3>
                                    <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $type->kamars()->where('status', 'Kosong')->count() }} tersedia
                                    </span>
                                </div>
                                <div class="mt-3">
                                    <div class="flex items-center text-white/90 text-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ Str::limit($type->fasilitas ?? 'Fasilitas lengkap dan modern', 50) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6">
                                <!-- Facilities List -->
                                <div class="mb-6">
                                    @php
                                        $facilities = [
                                            'Standar' => ['AC', 'WiFi Gratis', 'Kamar Mandi Dalam', 'Tempat Tidur', 'Lemari'],
                                            'Elite' => ['AC', 'WiFi Gratis', 'TV 32"', 'Minibar', 'Balkon', 'Queen Bed'],
                                            'Exclusive' => ['AC Premium', 'WiFi Unlimited', 'TV 43"', 'Bathtub', 'Dapur Kecil', 'King Bed']
                                        ];
                                        $typeFacilities = $facilities[$type->tipe_kamar] ?? ['Fasilitas Lengkap'];
                                    @endphp
                                    
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach(array_slice($typeFacilities, 0, 4) as $facility)
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-3 h-3 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                {{ $facility }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Pricing -->
                                @if($type->paketKamars()->count() > 0)
                                    <div class="border-t pt-4 mb-6">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm text-gray-500">Mulai dari</p>
                                                <p class="text-2xl font-bold text-gray-900">
                                                    Rp {{ number_format($type->paketKamars()->min('harga'), 0, ',', '.') }}
                                                </p>
                                                <p class="text-sm text-gray-500">per bulan</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm text-gray-500">Hingga</p>
                                                <p class="text-lg font-semibold text-gray-700">
                                                    Rp {{ number_format($type->paketKamars()->max('harga'), 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Action Button -->
                                <a href="{{ route('user.rooms.index', ['type' => $type->id_tipe_kamar]) }}" 
                                   class="block w-full text-center py-3 px-4 bg-gradient-to-r @if($type->tipe_kamar === 'Standar') from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 @elseif($type->tipe_kamar === 'Elite') from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 @else from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 @endif text-white font-semibold rounded-xl transition duration-300 transform group-hover:scale-105">
                                    Lihat Kamar {{ $type->tipe_kamar }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                    <svg class="w-20 h-20 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-3">Belum Ada Tipe Kamar</h3>
                    <p class="text-gray-500 mb-6">Tipe kamar belum tersedia saat ini. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions Menu -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Menu Cepat</h2>
                <p class="text-lg text-gray-600">Akses fitur utama dengan mudah dan cepat</p>
            </div>
            
                         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Browse Rooms -->
                <a href="{{ route('user.rooms.index') }}" 
                   class="group bg-white p-6 rounded-2xl border border-gray-200 hover:border-blue-300 hover:shadow-lg transition duration-300 transform hover:scale-105 text-center">
                    <svg class="w-12 h-12 text-blue-500 mx-auto mb-4 group-hover:text-blue-600 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Cari Kamar</h3>
                    <p class="text-sm text-gray-600">Temukan kamar yang sesuai dengan kebutuhan Anda</p>
                </a>

                <!-- Make Booking -->
                <a href="{{ route('user.booking.create') }}" 
                   class="group bg-white p-6 rounded-2xl border border-gray-200 hover:border-green-300 hover:shadow-lg transition duration-300 transform hover:scale-105 text-center">
                    <svg class="w-12 h-12 text-green-500 mx-auto mb-4 group-hover:text-green-600 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Booking Baru</h3>
                    <p class="text-sm text-gray-600">Pesan kamar favorit Anda sekarang juga</p>
                </a>

                @if(Auth::user()->hasActivePenghuni())
                    <!-- Complaint -->
                    <a href="{{ route('penghuni.pengaduan.index') }}" 
                       class="group bg-white p-6 rounded-2xl border border-gray-200 hover:border-orange-300 hover:shadow-lg transition duration-300 transform hover:scale-105 text-center">
                        <svg class="w-12 h-12 text-orange-500 mx-auto mb-4 group-hover:text-orange-600 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Pengaduan</h3>
                        <p class="text-sm text-gray-600">Laporkan masalah atau keluhan Anda</p>
                    </a>

                    <!-- Invoice History -->
                    <a href="{{ route('penghuni.history.index') }}" 
                       class="group bg-white p-6 rounded-2xl border border-gray-200 hover:border-purple-300 hover:shadow-lg transition duration-300 transform hover:scale-105 text-center">
                        <svg class="w-12 h-12 text-purple-500 mx-auto mb-4 group-hover:text-purple-600 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Riwayat Invoice</h3>
                        <p class="text-sm text-gray-600">Lihat riwayat pembayaran dan tagihan</p>
                    </a>
                @else
                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}" 
                       class="group bg-white p-6 rounded-2xl border border-gray-200 hover:border-gray-400 hover:shadow-lg transition duration-300 transform hover:scale-105 text-center">
                        <svg class="w-12 h-12 text-gray-500 mx-auto mb-4 group-hover:text-gray-600 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Profil Saya</h3>
                        <p class="text-sm text-gray-600">Kelola informasi akun Anda</p>
                    </a>
                @endif
            </div>
        </div>

                 <!-- Footer CTA -->
         <div class="mt-12 text-center bg-gradient-to-r from-blue-600 to-orange-600 rounded-2xl p-8 text-white">
             <div class="flex items-center justify-center mb-4">
                 <svg class="w-8 h-8 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                 </svg>
                 <h3 class="text-2xl font-bold">Butuh Bantuan?</h3>
             </div>
             <p class="text-blue-100 mb-6 max-w-2xl mx-auto">
                 Tim customer service kami siap membantu Anda 24/7. Jangan ragu untuk menghubungi kami jika ada pertanyaan.
             </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:+628123456789" 
                   class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-50 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Hubungi Kami
                </a>
                <a href="https://wa.me/628123456789" 
                   class="inline-flex items-center px-6 py-3 bg-green-500 text-white font-semibold rounded-xl hover:bg-green-600 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                    </svg>
                    WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 
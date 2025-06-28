@extends('layouts.user')

@section('title', 'Detail Kamar ' . $room->no_kamar)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center space-x-2 text-sm text-gray-500">
                <a href="{{ route('user.dashboard') }}" class="hover:text-blue-600 transition duration-200">Dashboard</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('user.rooms.index') }}" class="hover:text-blue-600 transition duration-200">Cari Kamar</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-900 font-medium">Kamar {{ $room->no_kamar }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Room Header -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-3xl font-bold text-gray-900">Kamar {{ $room->no_kamar }}</h1>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($room->tipeKamar->tipe_kamar == 'Standar') bg-green-100 text-green-800
                            @elseif($room->tipeKamar->tipe_kamar == 'Elite') bg-blue-100 text-blue-800
                            @else bg-purple-100 text-purple-800 @endif">
                            {{ $room->tipeKamar->tipe_kamar }}
                        </span>
                    </div>
                    <p class="text-lg text-gray-600">{{ $room->tipeKamar->tipe_kamar }} - Fasilitas Lengkap</p>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                        @if($room->status === 'Kosong') bg-green-100 text-green-800
                        @elseif($room->status === 'Dipesan') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        @if($room->status === 'Kosong')
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Tersedia
                        @else
                            {{ $room->status }}
                        @endif
                    </span>
                    
                    <a href="{{ route('user.rooms.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Images & Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Image Gallery -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    @php
                        $photos = $room->getPhotoUrls();
                        $availablePhotos = array_filter([$photos['foto1'], $photos['foto2'], $photos['foto3']]);
                    @endphp
                    
                    @if(count($availablePhotos) > 0)
                        <div class="relative">
                            <!-- Main Image -->
                            <div class="relative h-96 bg-gray-200">
                                <img id="mainImage" 
                                     src="{!! $availablePhotos[0] !!}" 
                                     alt="Foto Utama Kamar {{ $room->no_kamar }}"
                                     class="w-full h-full object-cover cursor-pointer"
                                     onclick="openImageModal('{!! addslashes($availablePhotos[0]) !!}', 'Foto Utama Kamar {{ $room->no_kamar }}')">
                                
                                <!-- Image Counter -->
                                <div class="absolute top-4 right-4 bg-black bg-opacity-50 text-white px-3 py-1 rounded-lg text-sm">
                                    <span id="currentImageIndex">1</span> / {{ count($availablePhotos) }}
                                </div>
                                
                                <!-- Navigation Arrows -->
                                @if(count($availablePhotos) > 1)
                                <button onclick="previousImage()" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                <button onclick="nextImage()" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                                @endif
                            </div>
                            
                            <!-- Thumbnail Gallery -->
                            @if(count($availablePhotos) > 1)
                            <div class="p-4 bg-gray-50">
                                <div class="flex space-x-2 overflow-x-auto">
                                    @foreach($availablePhotos as $index => $photo)
                                    <img src="{!! $photo !!}" 
                                         alt="Thumbnail {{ $index + 1 }}"
                                         class="thumbnail w-20 h-16 object-cover rounded-lg cursor-pointer border-2 {{ $index === 0 ? 'border-blue-500' : 'border-gray-200' }} hover:border-blue-400 transition duration-200"
                                         data-index="{{ $index }}"
                                         onclick="setMainImage({{ $index }}, '{!! addslashes($photo) !!}')">
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    @else
                        <!-- Placeholder when no images -->
                        <div class="h-96 bg-gradient-to-br 
                            @if($room->tipeKamar->tipe_kamar == 'Standar') 
                                from-green-400 to-green-600
                            @elseif($room->tipeKamar->tipe_kamar == 'Elite')
                                from-blue-400 to-blue-600
                            @else
                                from-purple-400 to-purple-600
                            @endif flex items-center justify-center">
                            <div class="text-center text-white">
                                <div class="text-6xl font-bold mb-4">{{ $room->no_kamar }}</div>
                                <div class="text-xl">{{ $room->tipeKamar->tipe_kamar }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Room Details -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Detail Kamar
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Info -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                                    </svg>
                                    <span class="text-gray-600">Nomor Kamar:</span>
                                    <span class="font-medium text-gray-900 ml-2">{{ $room->no_kamar }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span class="text-gray-600">Tipe:</span>
                                    <span class="font-medium text-gray-900 ml-2">{{ $room->tipeKamar->tipe_kamar }}</span>
                                </div>
                                @if($availablePackages->isNotEmpty())
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="text-gray-600">Kapasitas:</span>
                                    <span class="font-medium text-gray-900 ml-2">{{ $availablePackages->max('kapasitas_kamar') }} Orang</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Status Info -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status & Ketersediaan</h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-600">Status:</span>
                                    <span class="font-medium ml-2
                                        @if($room->status === 'Kosong') text-green-600
                                        @elseif($room->status === 'Dipesan') text-yellow-600
                                        @else text-red-600 @endif">
                                        {{ $room->status }}
                                    </span>
                                </div>
                                @if($availablePackages->isNotEmpty())
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    <span class="text-gray-600">Harga Mulai:</span>
                                    <span class="font-bold text-blue-600 ml-2">Rp {{ number_format($availablePackages->min('harga'), 0, ',', '.') }}</span>
                                </div>
                                @endif
                                @if($advanceBookings->isNotEmpty())
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-yellow-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <div>
                                        <span class="text-gray-600">Booking Mendatang:</span>
                                        <div class="mt-1 text-sm text-yellow-600">
                                            @foreach($advanceBookings as $booking)
                                                <div>{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Facilities -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                        Fasilitas
                    </h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($room->tipeKamar->fasilitas)) !!}
                    </div>

                    @if($room->deskripsi)
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi Khusus</h3>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($room->deskripsi)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Booking & Pricing -->
            <div class="space-y-6">
                <!-- Pricing Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Paket & Harga
                    </h2>
                    
                    @if($availablePackages->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($availablePackages as $package)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 hover:bg-blue-50 transition duration-200">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $package->jenis_paket }}</h3>
                                            <p class="text-sm text-gray-600">
                                                {{ $package->kapasitas_kamar }} orang • {{ $package->jumlah_penghuni }} penghuni
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xl font-bold text-blue-600">
                                                Rp {{ number_format($package->harga, 0, ',', '.') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                per {{ strtolower($package->jenis_paket) }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($package->jenis_paket === 'Tahunan')
                                        <div class="text-xs text-green-600 font-medium">
                                            Hemat hingga 20% dengan paket tahunan!
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            <p class="text-gray-500">Paket harga belum tersedia</p>
                        </div>
                    @endif

                    <!-- Availability Checker -->
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Cek Ketersediaan
                        </h3>
                        <form id="availability-form" class="space-y-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                <input type="date" id="start_date" name="start_date" 
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                       required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                                <input type="date" id="end_date" name="end_date" 
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                       required min="{{ date('Y-m-d', strtotime('+2 day')) }}">
                            </div>
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 px-4 rounded-lg hover:from-blue-600 hover:to-blue-700 transition duration-200 font-medium">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Cek Ketersediaan
                            </button>
                        </form>
                        
                        <!-- Availability Result -->
                        <div id="availability-result" class="mt-4 hidden">
                            <div id="availability-message" class="p-4 rounded-lg"></div>
                        </div>
                    </div>

                    <!-- Book Now Button -->
                    @if($room->status === 'Kosong')
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <a href="{{ route('user.booking.create', $room) }}" 
                               class="block w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white text-center py-4 px-6 rounded-lg hover:from-orange-600 hover:to-orange-700 transition duration-200 font-bold text-lg shadow-lg">
                                <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Booking Sekarang
                            </a>
                            <p class="text-xs text-gray-500 text-center mt-2">
                                Proses booking aman dan mudah
                            </p>
                        </div>
                    @else
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <button disabled 
                                    class="block w-full bg-gray-300 text-gray-500 text-center py-4 px-6 rounded-lg cursor-not-allowed font-bold text-lg">
                                <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Kamar Tidak Tersedia
                            </button>
                            <p class="text-xs text-gray-500 text-center mt-2">
                                Kamar sedang {{ strtolower($room->status) }}
                            </p>
                        </div>
                    @endif

                    <!-- Contact Info -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Butuh Bantuan?</h3>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>+62 812-3456-7890</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>info@mykost.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 flex items-center justify-center p-4">
        <div class="relative max-w-5xl max-h-full">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10 bg-black bg-opacity-50 rounded-full p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
            <p id="modalCaption" class="text-white text-center mt-4 text-lg"></p>
        </div>
    </div>
</div>

<script>
// Image gallery functionality
let currentImageIndex = 0;
const images = @json(array_values(array_filter([$photos['foto1'], $photos['foto2'], $photos['foto3']])));

function setMainImage(index, src) {
    currentImageIndex = index;
    document.getElementById('mainImage').src = src;
    document.getElementById('currentImageIndex').textContent = index + 1;
    
    // Update thumbnail borders
    document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
        thumb.classList.toggle('border-blue-500', i === index);
        thumb.classList.toggle('border-gray-200', i !== index);
    });
}

function nextImage() {
    if (currentImageIndex < images.length - 1) {
        setMainImage(currentImageIndex + 1, images[currentImageIndex + 1]);
    } else {
        setMainImage(0, images[0]);
    }
}

function previousImage() {
    if (currentImageIndex > 0) {
        setMainImage(currentImageIndex - 1, images[currentImageIndex - 1]);
    } else {
        setMainImage(images.length - 1, images[images.length - 1]);
    }
}

// Image modal
function openImageModal(src, caption) {
    document.getElementById('modalImage').src = src;
    document.getElementById('modalCaption').textContent = caption;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Availability checker
document.getElementById('availability-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const resultDiv = document.getElementById('availability-result');
    const messageDiv = document.getElementById('availability-message');
    
    if (!startDate || !endDate) {
        return;
    }
    
    // Show loading state
    resultDiv.classList.remove('hidden');
    messageDiv.className = 'p-4 rounded-lg bg-blue-50 border border-blue-200';
    messageDiv.innerHTML = `
        <div class="flex items-center">
            <svg class="animate-spin w-5 h-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-blue-800">Memeriksa ketersediaan...</span>
        </div>
    `;
    
    try {
        const response = await fetch(`{{ route('user.rooms.check-availability', $room) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ start_date: startDate, end_date: endDate })
        });
        
        const data = await response.json();
        
        if (data.available) {
            messageDiv.className = 'p-4 rounded-lg bg-green-50 border border-green-200';
            messageDiv.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <div class="font-medium text-green-800">Kamar Tersedia!</div>
                        <div class="text-green-700 text-sm">${data.message}</div>
                    </div>
                </div>
            `;
        } else {
            messageDiv.className = 'p-4 rounded-lg bg-red-50 border border-red-200';
            messageDiv.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <div class="font-medium text-red-800">Tidak Tersedia</div>
                        <div class="text-red-700 text-sm">${data.message}</div>
                    </div>
                </div>
            `;
        }
    } catch (error) {
        messageDiv.className = 'p-4 rounded-lg bg-red-50 border border-red-200';
        messageDiv.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <div class="font-medium text-red-800">Terjadi Kesalahan</div>
                    <div class="text-red-700 text-sm">Gagal memeriksa ketersediaan kamar</div>
                </div>
            </div>
        `;
    }
});

// Set minimum dates for date inputs
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    startDateInput.addEventListener('change', function() {
        const startDate = new Date(this.value);
        const minEndDate = new Date(startDate);
        minEndDate.setDate(minEndDate.getDate() + 1);
        endDateInput.min = minEndDate.toISOString().split('T')[0];
        
        if (endDateInput.value && new Date(endDateInput.value) <= startDate) {
            endDateInput.value = '';
        }
    });
    
    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
    
    // Close modal on outside click
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });
});
</script>
@endsection 
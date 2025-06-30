@extends('layouts.user')

@section('title', 'Detail Kamar ' . $room->no_kamar)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
            <a href="{{ route('user.dashboard') }}" class="hover:text-gray-700">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('user.rooms.index') }}" class="hover:text-gray-700">Cari Kamar</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900">Kamar {{ $room->no_kamar }}</span>
        </nav>
        
        <h1 class="text-3xl font-bold text-gray-900">Detail Kamar {{ $room->no_kamar }}</h1>
        <p class="text-gray-600 mt-2">Lihat informasi lengkap tentang kamar ini</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Room Info & Booking -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-6 sticky top-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Kamar</h2>
                
                <!-- Room Image -->
                @php
                    $photos = $room->getPhotoUrls();
                    $availablePhotos = array_filter([$photos['foto1'], $photos['foto2'], $photos['foto3']]);
                @endphp
                
                @if(count($availablePhotos) > 0)
                    <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden mb-4">
                        <img src="{!! $availablePhotos[0] !!}" 
                             alt="Kamar {{ $room->no_kamar }}"
                             class="w-full h-full object-cover">
                    </div>
                @else
                    <!-- Placeholder when no images -->
                    <div class="aspect-video bg-gradient-to-br 
                        @if($room->tipeKamar->tipe_kamar == 'Standar') 
                            from-green-400 to-green-600
                        @elseif($room->tipeKamar->tipe_kamar == 'Elite')
                            from-blue-400 to-blue-600
                        @else
                            from-purple-400 to-purple-600
                        @endif rounded-lg flex items-center justify-center mb-4">
                        <div class="text-center text-white">
                            <div class="text-4xl font-bold mb-2">{{ $room->no_kamar }}</div>
                            <div class="text-lg">{{ $room->tipeKamar->tipe_kamar }}</div>
                        </div>
                    </div>
                @endif

                <!-- Room Details -->
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Nomor Kamar</span>
                        <span class="font-medium text-gray-900">{{ $room->no_kamar }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Tipe Kamar</span>
                        <span class="font-medium text-gray-900">{{ $room->tipeKamar->tipe_kamar }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($room->status === 'Kosong') bg-green-100 text-green-800
                            @elseif($room->status === 'Dipesan') bg-yellow-100 text-yellow-800
                            @elseif($room->status === 'Terisi') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            @if($room->status === 'Kosong')
                                Tersedia
                            @elseif($room->status === 'Dipesan')
                                Dipesan
                            @elseif($room->status === 'Terisi')
                                Sedang Ditempati
                            @else
                                {{ $room->status }}
                            @endif
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Kapasitas Maksimal</span>
                        <span class="font-medium text-gray-900">{{ $room->kapasitas_max }} Orang</span>
                    </div>
                </div>

                <!-- Facilities -->
                <div class="mt-6">
                    <h3 class="font-medium text-gray-900 mb-2">Fasilitas</h3>
                    <p class="text-sm text-gray-600">{{ $room->tipeKamar->fasilitas }}</p>
                </div>

                @if($room->deskripsi)
                <div class="mt-6">
                    <h3 class="font-medium text-gray-900 mb-2">Deskripsi</h3>
                    <p class="text-sm text-gray-600">{{ $room->deskripsi }}</p>
                </div>
                @endif

                <!-- Booking Button -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    @if($room->isAvailableForBooking())
                        <a href="{{ route('user.booking.create', ['kamar_id' => $room->id_kamar]) }}" 
                           class="w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-3 px-4 rounded-lg text-center block transition duration-200">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Booking Sekarang
                        </a>
                        <p class="text-xs text-gray-500 text-center mt-2">
                            Klik untuk melakukan booking kamar ini
                        </p>
                    @else
                        <button disabled 
                                class="w-full bg-gray-300 text-gray-500 font-medium py-3 px-4 rounded-lg text-center cursor-not-allowed">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            @if($room->status === 'Terisi')
                                Sedang Ditempati
                            @elseif($room->status === 'Dipesan')
                                Dipesan
                            @else
                                Kamar Tidak Tersedia
                            @endif
                        </button>
                        <p class="text-xs text-gray-500 text-center mt-2">
                            @if($room->status === 'Terisi')
                                Kamar sedang ditempati oleh penghuni lain
                            @elseif($room->status === 'Dipesan')
                                Kamar sudah dipesan dan menunggu konfirmasi
                            @else
                                Status kamar: {{ $room->status }}
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Detailed Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Image Gallery -->
            @if(count($availablePhotos) > 1)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Galeri Foto</h3>
                
                <!-- Main Image -->
                <div class="relative mb-4">
                    <div class="relative h-96 bg-gray-200 rounded-lg overflow-hidden">
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
                    </div>
                </div>
                
                <!-- Thumbnail Gallery -->
                <div class="flex space-x-2 overflow-x-auto">
                    @foreach($availablePhotos as $index => $photo)
                    <img src="{!! $photo !!}" 
                         alt="Thumbnail {{ $index + 1 }}"
                         class="thumbnail w-20 h-16 object-cover rounded-lg cursor-pointer border-2 {{ $index === 0 ? 'border-blue-500' : 'border-gray-200' }} hover:border-blue-400 transition duration-200 flex-shrink-0"
                         data-index="{{ $index }}"
                         onclick="setMainImage({{ $index }}, '{!! addslashes($photo) !!}')">
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Package Information -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Paket & Harga</h3>
                
                @if($paketKamar->isEmpty())
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m14 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m14 0H6m14 0a2 2 0 01-2 2H6a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada paket tersedia</h3>
                        <p class="mt-1 text-sm text-gray-500">Tidak ada paket kamar untuk tipe {{ $room->tipeKamar->tipe_kamar }}</p>
                    </div>
                @else
                    <div class="mt-4 space-y-4">
                        @foreach($paketKamar as $paket)
                            @if($room->kapasitas_max >= $paket->kapasitas_kamar)
                            <div class="flex justify-between items-center p-4 border border-gray-200 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $paket->jenis_paket }}</h4>
                                    <p class="text-sm text-gray-500">Kapasitas {{ $paket->kapasitas_kamar }} Orang</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Room Features -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Fitur Kamar</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Room Type Features -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">Tipe & Status</h4>
                        <div class="space-y-2">
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span class="text-gray-600">Tipe: </span>
                                <span class="font-medium text-gray-900 ml-1">{{ $room->tipeKamar->tipe_kamar }}</span>
                            </div>
                                                        <div class="flex items-center text-sm">
                                @if($room->status === 'Kosong')
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-600">Status: </span>
                                    <span class="font-medium ml-1 text-green-600">Tersedia</span>
                                @elseif($room->status === 'Dipesan')
                                    <svg class="w-4 h-4 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-600">Status: </span>
                                    <span class="font-medium ml-1 text-yellow-600">Dipesan</span>
                                @elseif($room->status === 'Terisi')
                                    <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="text-gray-600">Status: </span>
                                    <span class="font-medium ml-1 text-red-600">Sedang Ditempati</span>
                                @else
                                    <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-600">Status: </span>
                                    <span class="font-medium ml-1 text-gray-600">{{ $room->status }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Capacity Info -->
                    @if($paketKamar->isNotEmpty())
                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">Kapasitas</h4>
                        <div class="space-y-2">
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 715.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="text-gray-600">Maksimal: </span>
                                <span class="font-medium text-gray-900 ml-1">{{ $paketKamar->max('kapasitas_kamar') }} Orang</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                <span class="text-gray-600">Tersedia untuk: </span>
                                <span class="font-medium text-gray-900 ml-1">{{ $paketKamar->min('jumlah_penghuni') }}-{{ $paketKamar->max('jumlah_penghuni') }} Penghuni</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Room Availability Info -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Kamar</h3>
                
                @if($room->status === 'Kosong')
                    <!-- Available Status -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-green-800">Kamar Tersedia</h4>
                                <p class="text-sm text-green-700 mt-1">
                                    Kamar ini tersedia untuk booking dan siap ditempati.
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($room->status === 'Dipesan')
                    <!-- Booked Status -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-yellow-800">Kamar Dipesan</h4>
                                <p class="text-sm text-yellow-700 mt-1">
                                    Kamar ini sudah dipesan dan menunggu konfirmasi pembayaran.
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($room->status === 'Terisi')
                    <!-- Occupied Status -->
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-red-800">Kamar Sedang Ditempati</h4>
                                <p class="text-sm text-red-700 mt-1">
                                    Kamar ini sedang dihuni oleh penghuni dan tidak dapat di-booking saat ini.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Unknown Status -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-800">Status: {{ $room->status }}</h4>
                                <p class="text-sm text-gray-700 mt-1">
                                    Status kamar tidak diketahui. Silakan hubungi admin untuk informasi lebih lanjut.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Status Legend -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Keterangan Status:</h4>
                    <div class="space-y-2">
                        <div class="flex items-center text-sm">
                            <div class="w-3 h-3 bg-green-500 rounded mr-3"></div>
                            <span class="text-gray-700">Tersedia - Kamar kosong dan siap untuk booking</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <div class="w-3 h-3 bg-yellow-500 rounded mr-3"></div>
                            <span class="text-gray-700">Dipesan - Kamar sudah dipesan, menunggu konfirmasi</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <div class="w-3 h-3 bg-red-500 rounded mr-3"></div>
                            <span class="text-gray-700">Sedang Ditempati - Kamar dihuni oleh penghuni aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
        <div id="modalCaption" class="absolute bottom-4 left-4 bg-black bg-opacity-50 text-white px-3 py-1 rounded-lg"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image gallery functionality
    const images = @json($availablePhotos ?? []);
    let currentIndex = 0;

    window.setMainImage = function(index, imageSrc) {
        currentIndex = index;
        document.getElementById('mainImage').src = imageSrc;
        document.getElementById('currentImageIndex').textContent = index + 1;
        
        // Update thumbnail borders
        document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
            thumb.classList.toggle('border-blue-500', i === index);
            thumb.classList.toggle('border-gray-200', i !== index);
        });
    };

    window.previousImage = function() {
        if (images.length > 0) {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            setMainImage(currentIndex, images[currentIndex]);
        }
    };

    window.nextImage = function() {
        if (images.length > 0) {
            currentIndex = (currentIndex + 1) % images.length;
            setMainImage(currentIndex, images[currentIndex]);
        }
    };

    window.openImageModal = function(imageSrc, caption) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('modalCaption').textContent = caption;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    window.closeImageModal = function() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    };

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });

    // Close modal on backdrop click
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });
});
</script>
@endsection 
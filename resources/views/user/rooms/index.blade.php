@extends('layouts.user')

@section('title', 'Cari Kamar Kos')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <!-- Hero Section with Search -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Temukan Kamar Kos Impian Anda</h1>
                <p class="text-xl text-blue-100 mb-8">Dapatkan kamar dengan fasilitas terbaik dan harga terjangkau</p>
                
                <!-- Quick Search Bar -->
                <div class="max-w-3xl mx-auto">
                    <form action="{{ route('user.rooms.index') }}" method="GET" class="bg-white rounded-xl shadow-lg p-2">
                        <div class="flex flex-col md:flex-row gap-2">
                            <div class="flex-1">
                                <input type="text" name="search" 
                                       placeholder="Cari nomor kamar, fasilitas, atau lokasi..."
                                       value="{{ request('search') }}"
                                       class="w-full px-4 py-3 border-0 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-900">
                            </div>
                            <div class="md:w-auto">
                                <button type="submit" 
                                        class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:from-orange-600 hover:to-orange-700 transition duration-200 font-medium">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                    Filter & Urutkan
                </h2>
                <button onclick="toggleFilters()" id="filterToggle" class="md:hidden text-blue-600 hover:text-blue-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('user.rooms.index') }}" method="GET" id="filterForm">
                <input type="hidden" name="search" value="{{ request('search') }}">
                
                <div id="filterContent" class="space-y-6">
                    <!-- Filter Row 1 -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Room Type Filter -->
                            <div>
                            <label for="tipe" class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                                </svg>
                                Tipe Kamar
                            </label>
                            <select id="tipe" name="tipe" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Tipe</option>
                                    @foreach($tipeKamar as $tipe)
                                        <option value="{{ $tipe->tipe_kamar }}" {{ request('tipe') == $tipe->tipe_kamar ? 'selected' : '' }}>
                                            {{ $tipe->tipe_kamar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Capacity Filter -->
                            <div>
                            <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Kapasitas
                            </label>
                            <select id="kapasitas" name="kapasitas" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Kapasitas</option>
                                    <option value="1" {{ request('kapasitas') == '1' ? 'selected' : '' }}>1 Orang</option>
                                    <option value="2" {{ request('kapasitas') == '2' ? 'selected' : '' }}>2 Orang</option>
                                </select>
                            </div>

                            <!-- Sort By -->
                            <div>
                            <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                </svg>
                                Urutkan
                            </label>
                            <select id="sort_by" name="sort_by" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Harga</option>
                                <option value="no_kamar" {{ request('sort_by') == 'no_kamar' ? 'selected' : '' }}>No. Kamar</option>
                            </select>
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                                Arah
                            </label>
                            <select id="sort_order" name="sort_order" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>A-Z / Rendah-Tinggi</option>
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Z-A / Tinggi-Rendah</option>
                                </select>
                            </div>
                        </div>

                    <!-- Price Range Filter -->
                                <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Rentang Harga
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="number" name="min_price" 
                                        placeholder="Harga Minimum"
                                       value="{{ request('min_price') }}"
                                       class="w-full pl-12 pr-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">Rp</span>
                                </div>
                            </div>
                            <div class="relative">
                                <input type="number" name="max_price" 
                                        placeholder="Harga Maksimum"
                                       value="{{ request('max_price') }}"
                                       class="w-full pl-12 pr-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">Rp</span>
                                </div>
                            </div>
                        </div>
                        @if($priceRange)
                        <div class="mt-2 text-sm text-gray-600">
                            Range harga: Rp {{ number_format($priceRange->min_price, 0, ',', '.') }} - Rp {{ number_format($priceRange->max_price, 0, ',', '.') }}
                        </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-200">
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition duration-200 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Terapkan Filter
                        </button>
                        
                        <a href="{{ route('user.rooms.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset Filter
                        </a>

                        @if(request()->hasAny(['search', 'tipe', 'kapasitas', 'min_price', 'max_price', 'sort_by', 'sort_order']))
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                                </svg>
                                Filter Aktif
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Summary -->
        <div class="flex items-center justify-between mb-6">
            <div class="text-gray-600">
                <span class="text-lg font-medium text-gray-900">{{ $rooms->total() }}</span> kamar ditemukan
                @if(request('search'))
                    untuk "<span class="font-medium text-blue-600">{{ request('search') }}</span>"
                @endif
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">View:</span>
                <button onclick="setGridView('grid')" id="gridView" class="p-2 rounded-lg bg-blue-100 text-blue-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </button>
                <button onclick="setGridView('list')" id="listView" class="p-2 rounded-lg text-gray-400 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                </div>
            </div>

            <!-- Room Cards Grid -->
        @if($rooms->count() > 0)
            <div id="roomsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($rooms as $room)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1 h-full flex flex-col">
                        <!-- Room Image -->
                        <div class="relative h-48 bg-gray-200">
                            @php
                                $photos = $room->getPhotoUrls();
                                $primaryPhoto = $photos['foto1'] ?? $photos['foto2'] ?? $photos['foto3'] ?? null;
                            @endphp
                            
                            @if($primaryPhoto)
                                <img src="{!! $primaryPhoto !!}" 
                                     alt="Kamar {{ $room->no_kamar }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br 
                                    @if($room->tipeKamar->tipe_kamar == 'Standar') 
                                        from-green-400 to-green-600
                                    @elseif($room->tipeKamar->tipe_kamar == 'Elite')
                                        from-blue-400 to-blue-600
                                    @else
                                        from-purple-400 to-purple-600
                                    @endif">
                                    <span class="text-white text-3xl font-bold">{{ $room->no_kamar }}</span>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    @if($room->status === 'Kosong') bg-green-100 text-green-800
                                    @elseif($room->status === 'Dipesan') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    @if($room->status === 'Kosong')
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                    {{ $room->status }}
                                </span>
                            </div>

                            <!-- Room Type Badge -->
                            <div class="absolute top-4 right-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    @if($room->tipeKamar->tipe_kamar == 'Standar') bg-green-100 text-green-800
                                    @elseif($room->tipeKamar->tipe_kamar == 'Elite') bg-blue-100 text-blue-800
                                    @else bg-purple-100 text-purple-800 @endif">
                                    {{ $room->tipeKamar->tipe_kamar }}
                                </span>
                            </div>
                        </div>

                        <!-- Room Content -->
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-xl font-bold text-gray-900">Kamar {{ $room->no_kamar }}</h3>
                                @if($room->tipeKamar && $room->tipeKamar->paketKamar->isNotEmpty())
                                    <div class="text-right">
                                        <span class="text-sm text-gray-500">Mulai dari</span>
                                        <p class="text-lg font-bold text-blue-600">
                                            Rp {{ number_format($room->tipeKamar->paketKamar->min('harga'), 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <!-- Room Features -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    @if($room->tipeKamar && $room->tipeKamar->paketKamar->isNotEmpty())
                                        Kapasitas: {{ $room->tipeKamar->paketKamar->max('kapasitas_kamar') }} orang
                                    @else
                                        Kapasitas tidak tersedia
                                    @endif
                                </div>
                                
                                @if($room->tipeKamar && $room->tipeKamar->paketKamar->isNotEmpty())
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Paket: {{ $room->tipeKamar->paketKamar->pluck('jenis_paket')->unique()->implode(', ') }}
                                </div>
                                @endif
                                
                                @if($room->deskripsi)
                                <p class="text-sm text-gray-600 line-clamp-2">
                                    {{ Str::limit($room->deskripsi, 100) }}
                                </p>
                                @endif
                            </div>

                            <!-- Spacer to push buttons to bottom -->
                            <div class="flex-grow"></div>

                            <!-- Action Buttons - Fixed at bottom -->
                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('user.rooms.show', $room) }}" 
                                   class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-center py-2 px-4 rounded-lg transition duration-200 text-sm font-medium">
                                    Lihat Detail
                                </a>
                                
                                @if($room->status === 'Kosong')
                                    <a href="{{ route('user.booking.create', ['kamar_id' => $room->id_kamar]) }}" 
                                       class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white text-center py-2 px-4 rounded-lg transition duration-200 text-sm font-medium">
                                        Booking Sekarang
                                    </a>
                                @else
                                    <button disabled 
                                            class="flex-1 bg-gray-300 text-gray-500 text-center py-2 px-4 rounded-lg text-sm font-medium cursor-not-allowed">
                                        Tidak Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-center">
                {{ $rooms->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Tidak ada kamar yang ditemukan</h3>
                <p class="text-gray-600 mb-6">
                    @if(request()->hasAny(['search', 'tipe', 'kapasitas', 'min_price', 'max_price']))
                        Coba ubah filter pencarian Anda atau hapus beberapa filter.
                    @else
                        Saat ini belum ada kamar yang tersedia.
                    @endif
                </p>
                
                @if(request()->hasAny(['search', 'tipe', 'kapasitas', 'min_price', 'max_price']))
                    <a href="{{ route('user.rooms.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset dan Lihat Semua Kamar
                    </a>
                @endif
        </div>
        @endif
    </div>
</div>

<script>
// Toggle filters on mobile
function toggleFilters() {
    const filterContent = document.getElementById('filterContent');
    const toggleButton = document.getElementById('filterToggle');
    
    if (filterContent.classList.contains('hidden')) {
        filterContent.classList.remove('hidden');
        toggleButton.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>';
    } else {
        filterContent.classList.add('hidden');
        toggleButton.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
    }
}

// Set grid/list view
function setGridView(viewType) {
    const container = document.getElementById('roomsContainer');
    const gridBtn = document.getElementById('gridView');
    const listBtn = document.getElementById('listView');
    
    if (viewType === 'grid') {
        container.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8';
        gridBtn.className = 'p-2 rounded-lg bg-blue-100 text-blue-600';
        listBtn.className = 'p-2 rounded-lg text-gray-400 hover:bg-gray-100';
    } else {
        container.className = 'space-y-4 mb-8';
        gridBtn.className = 'p-2 rounded-lg text-gray-400 hover:bg-gray-100';
        listBtn.className = 'p-2 rounded-lg bg-blue-100 text-blue-600';
    }
}

// Auto-submit form when filters change
document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('#filterForm select');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            // Optional: Auto-submit on filter change
            // document.getElementById('filterForm').submit();
        });
    });
    
    // Hide filters on mobile by default
    if (window.innerWidth < 768) {
        document.getElementById('filterContent').classList.add('hidden');
    }
});

// Handle window resize
window.addEventListener('resize', function() {
    if (window.innerWidth >= 768) {
        document.getElementById('filterContent').classList.remove('hidden');
    }
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection 
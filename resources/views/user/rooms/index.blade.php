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
                                       placeholder="Cari nomor kamar, tipe kamar, fasilitas, atau paket..."
                                       value="{{ request('search') }}"
                                       class="w-full px-4 py-3 border-0 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-900">
                            </div>
                            <div class="md:w-auto">
                                <button type="submit" id="searchButton"
                                        class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:from-orange-600 hover:to-orange-700 transition duration-200 font-medium">
                                    <svg id="searchIcon" class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <svg id="loadingIcon" class="w-5 h-5 inline-block mr-2 animate-spin hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    <span id="searchText">Cari</span>
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
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <!-- Room Type Filter -->
                            <div>
                            <label for="tipe" class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                                </svg>
                                Tipe Kamar
                            </label>
                            <select id="type" name="type" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Tipe</option>
                                    @foreach($roomTypes as $tipe)
                                        <option value="{{ $tipe }}" {{ request('type') == $tipe ? 'selected' : '' }}>
                                            {{ $tipe }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Capacity Filter -->
                            <div>
                            <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 715.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Kapasitas
                            </label>
                            <select id="capacity" name="capacity" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Kapasitas</option>
                                    @foreach($capacities as $capacity)
                                        <option value="{{ $capacity }}" {{ request('capacity') == $capacity ? 'selected' : '' }}>
                                            {{ $capacity }} Orang
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Status
                            </label>
                            <select id="status" name="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Status</option>
                                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Dipesan</option>
                                    <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Sedang Ditempati</option>
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
                            <select id="sort" name="sort" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="no_kamar" {{ request('sort') == 'no_kamar' ? 'selected' : '' }}>No. Kamar</option>
                                    <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Harga</option>
                                    <option value="type" {{ request('sort') == 'type' ? 'selected' : '' }}>Tipe Kamar</option>
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
                            <select id="direction" name="direction" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>A-Z / Rendah-Tinggi</option>
                                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Z-A / Tinggi-Rendah</option>
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
                            Range harga: Rp {{ number_format($priceRange->min, 0, ',', '.') }} - Rp {{ number_format($priceRange->max, 0, ',', '.') }}
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

                        @if(request()->hasAny(['search', 'type', 'capacity', 'status', 'min_price', 'max_price', 'sort', 'direction']))
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
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 result-summary">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <!-- Results Info -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="flex items-center">
                        <div class="bg-blue-50 rounded-lg p-3 mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0v-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ $rooms->total() }} Kamar Ditemukan
                            </h3>
                            <p class="text-sm text-gray-600">
                @if(request('search'))
                                    Hasil pencarian untuk "<span class="font-medium text-blue-600">{{ request('search') }}</span>"
                                    @if(request()->hasAny(['type', 'capacity', 'status', 'min_price', 'max_price']))
                                        dengan filter yang diterapkan
                                    @endif
                                @elseif(request()->hasAny(['type', 'capacity', 'status', 'min_price', 'max_price']))
                                    Dengan filter yang diterapkan
                                @else
                                    Menampilkan semua kamar tersedia
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Active Filters Indicator -->
                    @if(request()->hasAny(['search', 'type', 'capacity', 'status', 'min_price', 'max_price', 'sort', 'direction']))
                        <div class="flex flex-wrap gap-2">
                            @if(request('type'))
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200 filter-badge cursor-default">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                    </svg>
                                    Tipe: {{ request('type') }}
                                </span>
                            @endif
                                                         @if(request('capacity'))
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200 filter-badge cursor-default">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                    </svg>
                                    Kapasitas: {{ request('capacity') }} orang
                                </span>
                            @endif
                                                         @if(request('status'))
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-200 filter-badge cursor-default">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Status: 
                                    @if(request('status') == 'available')
                                        Tersedia
                                    @elseif(request('status') == 'booked')
                                        Dipesan
                                    @elseif(request('status') == 'occupied')
                                        Sedang Ditempati
                                    @else
                                        {{ request('status') }}
                                    @endif
                                </span>
                            @endif
                                                         @if(request('min_price') || request('max_price'))
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200 filter-badge cursor-default">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.51-1.31c-.562-.649-1.413-1.076-2.353-1.253V5z" clip-rule="evenodd"></path>
                                    </svg>
                                    Harga: 
                                    @if(request('min_price') && request('max_price'))
                                        Rp {{ number_format(request('min_price'), 0, ',', '.') }} - Rp {{ number_format(request('max_price'), 0, ',', '.') }}
                                    @elseif(request('min_price'))
                                        Min Rp {{ number_format(request('min_price'), 0, ',', '.') }}
                                    @else
                                        Max Rp {{ number_format(request('max_price'), 0, ',', '.') }}
                                    @endif
                                </span>
                            @endif
                        </div>
                @endif
            </div>

                <!-- View Options -->
                <div class="flex items-center justify-between sm:justify-end gap-4">
                    <!-- Sorting Info -->
                    @if(request('sort'))
                        <div class="hidden sm:flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                            </svg>
                            Urutkan: 
                            @if(request('sort') === 'harga') Harga
                            @elseif(request('sort') === 'no_kamar') No. Kamar
                            @elseif(request('sort') === 'created_at') Terbaru
                            @else {{ request('sort') }}
                            @endif
                            ({{ request('direction', 'asc') === 'asc' ? 'A-Z' : 'Z-A' }})
                        </div>
                    @endif

                    <!-- View Toggle -->
                    <div class="flex items-center space-x-1 bg-gray-100 rounded-lg p-1">
                        <span class="text-xs text-gray-600 px-2">Tampilan:</span>
                        <button onclick="setGridView('grid')" id="gridView" 
                                class="p-2 rounded-md bg-blue-500 text-white shadow-sm transition-all duration-200 view-toggle-btn">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </button>
                        <button onclick="setGridView('list')" id="listView" 
                                class="p-2 rounded-md text-gray-400 hover:bg-gray-200 transition-all duration-200 view-toggle-btn">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                    </div>
                </div>
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
                                    @elseif($room->status === 'Terisi') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    @if($room->status === 'Kosong')
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                            Tersedia
                                    @elseif($room->status === 'Dipesan')
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Dipesan
                                    @elseif($room->status === 'Terisi')
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Sedang Ditempati
                                        @else
                                            {{ $room->status }}
                                    @endif
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
                                        @if($room->status === 'Terisi')
                                            Sedang Ditempati
                                        @elseif($room->status === 'Dipesan')
                                            Sudah Dipesan
                                        @else
                                        Tidak Tersedia
                                        @endif
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <!-- Pagination Info -->
                    <div class="flex items-center text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="font-medium">
                                Menampilkan {{ $rooms->firstItem() ?? 0 }} - {{ $rooms->lastItem() ?? 0 }} 
                                dari {{ $rooms->total() }} kamar
                            </span>
                        </div>
                        @if($rooms->hasPages())
                            <span class="hidden sm:inline-block mx-2 text-gray-300">|</span>
                            <span class="hidden sm:inline-block">
                                Halaman {{ $rooms->currentPage() }} dari {{ $rooms->lastPage() }}
                            </span>
                        @endif
                    </div>

                    <!-- Pagination Links -->
                    @if($rooms->hasPages())
                        <div class="flex items-center justify-center sm:justify-end">
                            <nav class="relative z-0 inline-flex rounded-lg shadow-sm -space-x-px" aria-label="Pagination">
                                <!-- Previous Page Link -->
                                @if ($rooms->onFirstPage())
                                    <span class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-300 bg-gray-50 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="sr-only">Previous</span>
                                    </span>
                                @else
                                    <a href="{{ $rooms->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                @endif

                                <!-- Pagination Elements -->
                                @foreach ($rooms->getUrlRange(1, $rooms->lastPage()) as $page => $url)
                                    @if ($page == $rooms->currentPage())
                                        <span class="relative inline-flex items-center px-4 py-2 border border-blue-500 bg-blue-500 text-sm font-medium text-white cursor-default">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600 hover:border-blue-300 transition-colors duration-200">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                <!-- Next Page Link -->
                                @if ($rooms->hasMorePages())
                                    <a href="{{ $rooms->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200">
                                        <span class="sr-only">Next</span>
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @else
                                    <span class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-300 bg-gray-50 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        <span class="sr-only">Next</span>
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @endif
                            </nav>
                        </div>
                    @endif
                </div>
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
                    @if(request()->hasAny(['search', 'type', 'capacity', 'status', 'min_price', 'max_price']))
                        Coba ubah filter pencarian Anda atau hapus beberapa filter.
                    @else
                        Saat ini belum ada kamar yang tersedia.
                    @endif
                </p>
                
                @if(request()->hasAny(['search', 'type', 'capacity', 'status', 'min_price', 'max_price']))
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
        gridBtn.className = 'p-2 rounded-md bg-blue-500 text-white shadow-sm transition-all duration-200 view-toggle-btn';
        listBtn.className = 'p-2 rounded-md text-gray-400 hover:bg-gray-200 transition-all duration-200 view-toggle-btn';
    } else {
        container.className = 'space-y-4 mb-8';
        gridBtn.className = 'p-2 rounded-md text-gray-400 hover:bg-gray-200 transition-all duration-200 view-toggle-btn';
        listBtn.className = 'p-2 rounded-md bg-blue-500 text-white shadow-sm transition-all duration-200 view-toggle-btn';
    }
}

// Auto-submit form when filters change
document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('#filterForm select');
    const searchInput = document.querySelector('input[name="search"]');
    let searchTimeout;
    
    // Auto-submit on filter change
    selects.forEach(select => {
        select.addEventListener('change', function() {
            // Uncomment to enable auto-submit on filter change
            // document.getElementById('filterForm').submit();
        });
    });
    
    // Auto-submit search with debounce (main search bar)
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Show loading state
                showSearchLoading();
                
                // Update the hidden search input in filter form
                const filterSearchInput = document.querySelector('#filterForm input[name="search"]');
                if (filterSearchInput) {
                    filterSearchInput.value = this.value;
                }
                // Submit the main search form
                this.closest('form').submit();
            }, 800); // 800ms debounce
        });
    }
    
    // Show loading state for search
    function showSearchLoading() {
        const searchIcon = document.getElementById('searchIcon');
        const loadingIcon = document.getElementById('loadingIcon');
        const searchText = document.getElementById('searchText');
        
        if (searchIcon && loadingIcon && searchText) {
            searchIcon.classList.add('hidden');
            loadingIcon.classList.remove('hidden');
            searchText.textContent = 'Mencari...';
        }
    }
    
    // Handle form submissions to show loading
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            showSearchLoading();
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

/* Custom pagination styles */
.pagination-info {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}

/* Enhanced hover effects */
.filter-badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* View toggle animation */
.view-toggle-btn {
    position: relative;
    overflow: hidden;
}

.view-toggle-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.view-toggle-btn:hover::before {
    left: 100%;
}

/* Smooth transitions for result cards */
.result-summary {
    transition: all 0.3s ease;
}

.result-summary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

/* Responsive pagination */
@media (max-width: 640px) {
    .pagination-info {
        text-align: center;
    }
    
    .pagination-links {
        justify-content: center;
        margin-top: 1rem;
    }
}
</style>
@endsection 
@extends('layouts.user')

@section('title', 'Tambah Penghuni - MYKOST')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border-l-4 border-orange-500 p-6 mb-6">
        <div class="flex items-center gap-x-3">
            <div class="p-3 bg-orange-100 rounded-full">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-2.239" />
                </svg>
            </div>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-800">Tambah Penghuni</h1>
                <p class="text-gray-600 mt-1">Tambahkan teman untuk berbagi kamar {{ $booking->kamar->no_kamar }}</p>
            </div>
        </div>
    </div>

    <form id="addPenghuniForm" action="{{ route('penghuni.addPenghuni.store', $booking) }}" method="POST">
        @csrf
        
        <div class="grid lg:grid-cols-2 gap-x-6 gap-y-6">
            <!-- Left Column: Form -->
            <div class="space-y-6">
                <!-- Current Booking Info -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-x-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Booking Saat Ini
                    </h3>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm">
                        <div>
                            <span class="text-gray-600">Kamar:</span>
                            <p class="font-medium text-gray-800">{{ $booking->kamar->no_kamar }} ({{ $booking->kamar->tipeKamar->tipe_kamar }})</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Paket Saat Ini:</span>
                            <p class="font-medium text-gray-800">{{ $booking->paketKamar->jenis_paket }} - {{ $booking->paketKamar->jumlah_penghuni }} Orang</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Tanggal Mulai:</span>
                            <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Tanggal Selesai:</span>
                            <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}</p>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-600">Sisa Hari:</span>
                            <p class="font-medium text-blue-600">{{ \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($booking->tanggal_selesai)) }} hari</p>
                        </div>
                    </div>
                </div>

                <!-- Friend Information -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-x-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Data Teman
                    </h3>

                    <div class="space-y-4">
                        <!-- Friend Email -->
                        <div>
                            <label for="friend_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Teman *
                            </label>
                            <input 
                                type="email" 
                                id="friend_email" 
                                name="friend_email"
                                value="{{ old('friend_email') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('friend_email') border-red-500 @enderror"
                                placeholder="contoh@email.com"
                                required
                            >
                            @error('friend_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Email teman harus sudah terdaftar dalam sistem MYKOST</p>
                        </div>
                    </div>
                </div>

                <!-- Package Selection -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-x-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Pilih Paket 2 Penghuni
                    </h3>

                    <div class="space-y-3">
                        @foreach($doublePackages as $package)
                        <label class="block cursor-pointer">
                            <input 
                                type="radio" 
                                name="id_paket_kamar_double" 
                                value="{{ $package->id_paket_kamar }}"
                                data-price="{{ $package->harga }}"
                                data-current-price="{{ $booking->paketKamar->harga }}"
                                class="sr-only package-radio"
                                {{ old('id_paket_kamar_double') == $package->id_paket_kamar ? 'checked' : '' }}
                                required
                            >
                            <div class="package-option p-4 border border-gray-300 rounded-lg hover:border-orange-500 transition-colors">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="font-medium text-gray-800">{{ $package->jenis_paket }} - {{ $package->jumlah_penghuni }} Orang</h4>
                                        <p class="text-sm text-gray-600">Kapasitas kamar: {{ $package->kapasitas_kamar }} orang</p>
                                        <p class="text-lg font-bold text-orange-600 mt-1">Rp {{ number_format($package->harga, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="package-check hidden">
                                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                        @error('id_paket_kamar_double')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Terms Agreement -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Syarat & Ketentuan</h3>
                    
                    <div class="space-y-3 text-sm text-gray-600 mb-4">
                        <div class="flex items-start gap-x-3">
                            <svg class="w-4 h-4 text-orange-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <p>Teman yang ditambahkan akan menjadi penghuni resmi dengan hak dan kewajiban yang sama</p>
                        </div>
                        <div class="flex items-start gap-x-3">
                            <svg class="w-4 h-4 text-orange-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <p>Biaya tambahan dihitung secara proporsional berdasarkan sisa periode booking aktif</p>
                        </div>
                        <div class="flex items-start gap-x-3">
                            <svg class="w-4 h-4 text-orange-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <p>Kedua penghuni bertanggung jawab atas semua aktivitas di kamar</p>
                        </div>
                        <div class="flex items-start gap-x-3">
                            <svg class="w-4 h-4 text-orange-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <p>Penambahan penghuni tidak dapat dibatalkan setelah pembayaran</p>
                        </div>
                    </div>

                    <label class="flex items-start gap-x-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="agree_terms" 
                            value="1"
                            class="mt-1 w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500 @error('agree_terms') border-red-500 @enderror"
                            {{ old('agree_terms') ? 'checked' : '' }}
                            required
                        >
                        <span class="text-sm text-gray-700">
                            Saya setuju dengan <strong>syarat dan ketentuan</strong> penambahan penghuni
                        </span>
                    </label>
                    @error('agree_terms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Right Column: Summary -->
            <div class="lg:sticky lg:top-6">
                <div class="bg-gradient-to-br from-orange-50 to-blue-50 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-x-2">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Ringkasan Biaya
                    </h3>

                    <div class="space-y-4">
                        <!-- Current Package -->
                        <div class="bg-white rounded-lg p-4">
                            <h4 class="font-medium text-gray-800 mb-2">Paket Saat Ini</h4>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ $booking->paketKamar->jenis_paket }} (1 Orang)</span>
                                <span class="font-medium">Rp {{ number_format($booking->paketKamar->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- New Package -->
                        <div id="newPackageSection" class="bg-white rounded-lg p-4 hidden">
                            <h4 class="font-medium text-gray-800 mb-2">Paket Baru</h4>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600" id="newPackageName">-</span>
                                <span class="font-medium" id="newPackagePrice">-</span>
                            </div>
                        </div>

                        <!-- Calculation -->
                        <div id="calculationSection" class="bg-white rounded-lg p-4 hidden">
                            <h4 class="font-medium text-gray-800 mb-3">Perhitungan</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Sisa hari:</span>
                                    <span id="remainingDays">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Total durasi:</span>
                                    <span id="totalDays">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Selisih paket:</span>
                                    <span id="priceDifference">-</span>
                                </div>
                                <hr>
                                <div class="flex justify-between font-medium">
                                    <span class="text-gray-800">Biaya tambahan:</span>
                                    <span id="additionalCost" class="text-orange-600">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Total -->
                        <div id="totalSection" class="bg-gradient-to-r from-orange-500 to-blue-600 rounded-lg p-4 text-white hidden">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium">Total Tambahan:</span>
                                <span id="totalAmount" class="text-2xl font-bold">Rp 0</span>
                            </div>
                            <p class="text-orange-100 text-xs mt-1">*Akan diarahkan ke halaman pembayaran</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        id="submitBtn"
                        class="w-full mt-6 bg-gradient-to-r from-orange-500 to-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:from-orange-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200"
                    >
                        <span class="flex items-center justify-center gap-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Penghuni
                        </span>
                    </button>

                    <!-- Cancel Link -->
                    <a 
                        href="{{ route('penghuni.history.show', $booking) }}" 
                        class="block w-full mt-3 text-center py-2 px-4 text-gray-600 hover:text-gray-800 transition-colors"
                    >
                        Batalkan
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const packageRadios = document.querySelectorAll('.package-radio');
    
    // Constants for calculation (FAIR FORMULA)
    const now = new Date();
    const bookingStart = new Date('{{ $booking->tanggal_mulai }}');
    const bookingEnd = new Date('{{ $booking->tanggal_selesai }}');
    
    // Start counting from the later of: now OR booking start date
    const effectiveStart = new Date(Math.max(now.getTime(), bookingStart.getTime()));
    const remainingDays = Math.ceil((bookingEnd - effectiveStart) / (1000 * 60 * 60 * 24));
    const totalBookingDays = Math.ceil((bookingEnd - bookingStart) / (1000 * 60 * 60 * 24));

    // Package selection handling
    packageRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Update visual selection
            document.querySelectorAll('.package-option').forEach(option => {
                option.classList.remove('border-orange-500', 'bg-orange-50');
                option.querySelector('.package-check').classList.add('hidden');
            });
            
            if (this.checked) {
                const option = this.closest('.package-option');
                option.classList.add('border-orange-500', 'bg-orange-50');
                option.querySelector('.package-check').classList.remove('hidden');
                
                updateCalculation(this);
            }
        });
    });

    // Check if package is already selected (old input)
    const checkedRadio = document.querySelector('.package-radio:checked');
    if (checkedRadio) {
        const option = checkedRadio.closest('.package-option');
        option.classList.add('border-orange-500', 'bg-orange-50');
        option.querySelector('.package-check').classList.remove('hidden');
        updateCalculation(checkedRadio);
    }

    function updateCalculation(radio) {
        const newPrice = parseFloat(radio.dataset.price);
        const currentPrice = parseFloat(radio.dataset.currentPrice);
        const priceDifference = newPrice - currentPrice;
        
        // Use FAIR FORMULA: only count remaining days in booking period
        const additionalCost = parseFloat(((priceDifference * remainingDays) / totalBookingDays).toFixed(3));

        // Update package info
        const packageName = radio.closest('.package-option').querySelector('h4').textContent;
        document.getElementById('newPackageName').textContent = packageName;
        document.getElementById('newPackagePrice').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(newPrice);
        document.getElementById('newPackageSection').classList.remove('hidden');

        // Update calculation display
        document.getElementById('remainingDays').textContent = remainingDays + ' hari';
        document.getElementById('totalDays').textContent = totalBookingDays + ' hari';
        document.getElementById('priceDifference').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(priceDifference);
        document.getElementById('additionalCost').textContent = 'Rp ' + new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 3,
            maximumFractionDigits: 3
        }).format(additionalCost);
        document.getElementById('calculationSection').classList.remove('hidden');

        // Update total
        document.getElementById('totalAmount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 3,
            maximumFractionDigits: 3
        }).format(additionalCost);
        document.getElementById('totalSection').classList.remove('hidden');
    }
});
</script>
@endpush
@endsection 
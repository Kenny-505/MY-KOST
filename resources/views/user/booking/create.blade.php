@extends('layouts.user')

@section('title', 'Booking Kamar')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Booking Kamar {{ $kamar->no_kamar }}</h1>
                <p class="text-gray-600">Lengkapi informasi booking Anda</p>
            </div>
        </div>
    </div>

    <form action="{{ route('user.booking.store') }}" method="POST" id="bookingForm" class="space-y-8">
        @csrf
        <input type="hidden" name="id_kamar" value="{{ $kamar->id_kamar }}">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Room Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Room Card -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="relative">
                        @if($kamar->foto_kamar1)
                            <img src="{{ $kamar->getPhotoUrls()['foto1'] }}" 
                                 alt="Kamar {{ $kamar->no_kamar }}"
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center">
                                <div class="text-center text-white">
                                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-sm">Foto Tidak Tersedia</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $kamar->status === 'Kosong' ? 'bg-green-100 text-green-800' : 
                                   ($kamar->status === 'Dipesan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $kamar->status }}
                            </span>
                        </div>

                        <!-- Room Number Badge -->
                        <div class="absolute bottom-4 left-4">
                            <div class="w-12 h-12 bg-gradient-to-br 
                                @if($kamar->tipeKamar->tipe_kamar == 'Standar') 
                                    from-green-400 to-green-600
                                @elseif($kamar->tipeKamar->tipe_kamar == 'Elite')
                                    from-blue-400 to-blue-600
                                @else
                                    from-purple-400 to-purple-600
                                @endif
                                rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold">{{ $kamar->no_kamar }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-900">Kamar {{ $kamar->no_kamar }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium 
                                @if($kamar->tipeKamar->tipe_kamar == 'Standar') bg-green-100 text-green-800
                                @elseif($kamar->tipeKamar->tipe_kamar == 'Elite') bg-blue-100 text-blue-800
                                @else bg-purple-100 text-purple-800 @endif">
                                {{ $kamar->tipeKamar->tipe_kamar }}
                            </span>
                        </div>

                        @if($kamar->deskripsi)
                        <p class="text-gray-600 text-sm mb-4">{{ $kamar->deskripsi }}</p>
                        @endif

                        <!-- Facilities -->
                        <div class="border-t pt-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Fasilitas</h4>
                            <p class="text-sm text-gray-600">{{ $kamar->tipeKamar->fasilitas }}</p>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <a href="{{ route('user.rooms.show', $kamar) }}" 
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Detail Kamar
                </a>
            </div>

            <!-- Right Column - Booking Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Package Selection -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilih Paket Kamar</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($paketKamar as $paket)
                        <label class="relative cursor-pointer">
                            <input type="radio" name="id_paket_kamar" value="{{ $paket->id_paket_kamar }}" 
                                   class="sr-only paket-radio" 
                                   data-harga="{{ $paket->harga }}"
                                   data-jenis="{{ $paket->jenis_paket }}"
                                   data-kapasitas="{{ $paket->kapasitas_kamar }}"
                                   data-penghuni="{{ $paket->jumlah_penghuni }}"
                                   {{ old('id_paket_kamar') == $paket->id_paket_kamar ? 'checked' : '' }}>
                            
                            <div class="p-4 border-2 border-gray-200 rounded-lg hover:border-orange-300 transition-all duration-200 paket-card">
                                <div class="text-center">
                                    <!-- Package Type -->
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $paket->jenis_paket }}</h4>
                                    
                                    <!-- Price -->
                                    <div class="text-2xl font-bold text-orange-600 mb-3">
                                        Rp {{ number_format($paket->harga, 0, ',', '.') }}
                                    </div>
                                    
                                    <!-- Details -->
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <div class="flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                                            </svg>
                                            <span>Kapasitas {{ $paket->kapasitas_kamar }} orang</span>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <span>{{ $paket->jumlah_penghuni }} penghuni</span>
                                        </div>
                                    </div>

                                    <!-- Selected Indicator -->
                                    <div class="mt-3 hidden selected-indicator">
                                        <div class="w-6 h-6 bg-orange-600 rounded-full mx-auto flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    
                    @error('id_paket_kamar')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Booking Dates -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tanggal Check-in</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
                                   value="{{ old('tanggal_mulai') }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('tanggal_mulai') border-red-300 @enderror" 
                                   required>
                            @error('tanggal_mulai')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Selesai (Otomatis)
                            </label>
                            <input type="text" id="tanggal_selesai_display" readonly
                                   class="w-full rounded-md border-gray-300 bg-gray-50 shadow-sm" 
                                   placeholder="Pilih paket dan tanggal mulai">
                        </div>
                    </div>
                    
                    <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-blue-700">
                                <p class="font-medium">Informasi Penting:</p>
                                <ul class="mt-1 list-disc list-inside space-y-1">
                                    <li>Tanggal selesai dihitung otomatis berdasarkan paket yang dipilih</li>
                                    <li>Check-in dapat dilakukan mulai pukul 14:00</li>
                                    <li>Check-out harus dilakukan sebelum pukul 12:00</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Multi-Tenant Option -->
                <div class="bg-white rounded-xl shadow-sm p-6" id="multi-tenant-section" style="display: none;">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Booking Bersama Teman</h3>
                    
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="with_friend" name="with_friend" value="1" 
                               class="rounded border-gray-300 text-orange-600 shadow-sm focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50">
                        <label for="with_friend" class="ml-2 text-sm text-gray-900">
                            Saya ingin booking bersama teman (2 orang)
                        </label>
                    </div>

                    <div id="friend-selection" style="display: none;">
                        <label for="friend_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Teman
                        </label>
                        <input type="email" name="friend_email" id="friend_email" 
                               value="{{ old('friend_email') }}"
                               placeholder="Masukkan email teman yang sudah terdaftar"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('friend_email') border-red-300 @enderror">
                        @error('friend_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Teman harus sudah memiliki akun di sistem MYKOST
                        </p>
                    </div>
                </div>

                <!-- Booking Summary -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Booking</h3>
                    
                    <div class="space-y-3" id="booking-summary">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Kamar</span>
                            <span class="font-medium text-gray-900">{{ $kamar->no_kamar }} ({{ $kamar->tipeKamar->tipe_kamar }})</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Paket</span>
                            <span class="font-medium text-gray-900" id="summary-paket">Belum dipilih</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Tanggal</span>
                            <span class="font-medium text-gray-900" id="summary-dates">Belum dipilih</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Jumlah Penghuni</span>
                            <span class="font-medium text-gray-900" id="summary-occupants">-</span>
                        </div>

                        <hr class="border-gray-200">
                        
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-900">Total Pembayaran</span>
                            <span class="text-2xl font-bold text-green-600" id="summary-total">Rp 0</span>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            <p>Dengan melanjutkan, Anda menyetujui syarat dan ketentuan yang berlaku</p>
                        </div>
                        
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                id="submit-booking" disabled>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Lanjutkan ke Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('bookingForm');
    const paketRadios = document.querySelectorAll('.paket-radio');
    const tanggalMulaiInput = document.getElementById('tanggal_mulai');
    const tanggalSelesaiDisplay = document.getElementById('tanggal_selesai_display');
    const withFriendCheckbox = document.getElementById('with_friend');
    const friendSelection = document.getElementById('friend-selection');
    const multiTenantSection = document.getElementById('multi-tenant-section');
    const submitButton = document.getElementById('submit-booking');

    // Update package selection visual
    paketRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Reset all cards
            document.querySelectorAll('.paket-card').forEach(card => {
                card.classList.remove('border-orange-500', 'bg-orange-50');
                card.classList.add('border-gray-200');
                card.querySelector('.selected-indicator').classList.add('hidden');
            });

            if (this.checked) {
                // Highlight selected card
                const card = this.closest('label').querySelector('.paket-card');
                card.classList.remove('border-gray-200');
                card.classList.add('border-orange-500', 'bg-orange-50');
                card.querySelector('.selected-indicator').classList.remove('hidden');

                // Show multi-tenant section only for capacity 2 AND intended for 2 people
                const kapasitas = parseInt(this.dataset.kapasitas);
                const penghuni = parseInt(this.dataset.penghuni);
                if (kapasitas === 2 && penghuni === 2) {
                    multiTenantSection.style.display = 'block';
                } else {
                    multiTenantSection.style.display = 'none';
                    withFriendCheckbox.checked = false;
                    friendSelection.style.display = 'none';
                }

                updateSummary();
                updateEndDate();
            }
        });
    });

    // Handle friend checkbox
    withFriendCheckbox.addEventListener('change', function() {
        if (this.checked) {
            friendSelection.style.display = 'block';
        } else {
            friendSelection.style.display = 'none';
            document.getElementById('friend_email').value = '';
        }
        updateSummary();
    });

    // Handle date change
    tanggalMulaiInput.addEventListener('change', function() {
        updateEndDate();
        updateSummary();
    });

    function updateEndDate() {
        const selectedPackage = document.querySelector('.paket-radio:checked');
        const startDate = tanggalMulaiInput.value;

        if (selectedPackage && startDate) {
            const jenisPaket = selectedPackage.dataset.jenis;
            const start = new Date(startDate);
            let endDate;

            switch(jenisPaket) {
                case 'Mingguan':
                    endDate = new Date(start.getTime() + (7 * 24 * 60 * 60 * 1000));
                    break;
                case 'Bulanan':
                    endDate = new Date(start.getFullYear(), start.getMonth() + 1, start.getDate());
                    break;
                case 'Tahunan':
                    endDate = new Date(start.getFullYear() + 1, start.getMonth(), start.getDate());
                    break;
            }

            if (endDate) {
                tanggalSelesaiDisplay.value = endDate.toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }
        } else {
            tanggalSelesaiDisplay.value = '';
        }
    }

    function updateSummary() {
        const selectedPackage = document.querySelector('.paket-radio:checked');
        const startDate = tanggalMulaiInput.value;
        const withFriend = withFriendCheckbox.checked;

        // Update package in summary
        const summaryPaket = document.getElementById('summary-paket');
        if (selectedPackage) {
            summaryPaket.textContent = selectedPackage.dataset.jenis;
        } else {
            summaryPaket.textContent = 'Belum dipilih';
        }

        // Update dates in summary
        const summaryDates = document.getElementById('summary-dates');
        if (selectedPackage && startDate) {
            const endDate = tanggalSelesaiDisplay.value;
            if (endDate) {
                const startFormatted = new Date(startDate).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short'
                });
                summaryDates.textContent = `${startFormatted} - ${endDate.split(' ').slice(0, 2).join(' ')}`;
            } else {
                summaryDates.textContent = 'Tanggal belum lengkap';
            }
        } else {
            summaryDates.textContent = 'Belum dipilih';
        }

        // Update occupants
        const summaryOccupants = document.getElementById('summary-occupants');
        if (selectedPackage) {
            const jumlahPenghuni = parseInt(selectedPackage.dataset.penghuni);
            if (jumlahPenghuni === 2 && withFriend) {
                summaryOccupants.textContent = '2 orang';
            } else {
                summaryOccupants.textContent = '1 orang';
            }
        } else {
            summaryOccupants.textContent = '-';
        }

        // Update total price
        const summaryTotal = document.getElementById('summary-total');
        if (selectedPackage) {
            const harga = parseInt(selectedPackage.dataset.harga);
            summaryTotal.textContent = `Rp ${harga.toLocaleString('id-ID')}`;
        } else {
            summaryTotal.textContent = 'Rp 0';
        }

        // Enable/disable submit button
        const canSubmit = selectedPackage && startDate;
        submitButton.disabled = !canSubmit;
        
        if (canSubmit) {
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            submitButton.classList.add('hover:bg-orange-700');
        } else {
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            submitButton.classList.remove('hover:bg-orange-700');
        }
    }

    // Form validation
    form.addEventListener('submit', function(e) {
        const selectedPackage = document.querySelector('.paket-radio:checked');
        const startDate = tanggalMulaiInput.value;

        if (!selectedPackage || !startDate) {
            e.preventDefault();
            alert('Mohon lengkapi semua data yang diperlukan');
            return;
        }

        // Validate friend selection if multi-tenant
        if (withFriendCheckbox.checked) {
            const friendEmail = document.getElementById('friend_email').value;
            if (!friendEmail) {
                e.preventDefault();
                alert('Mohon masukkan email teman untuk booking bersama');
                return;
            }
        }

        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Memproses...
        `;
    });

    // Initialize
    updateSummary();
});
</script>
@endsection 
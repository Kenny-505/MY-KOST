@extends('layouts.user')

@section('title', 'Booking Kamar ' . $kamar->no_kamar)

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
            <span class="text-gray-900">Booking Kamar {{ $kamar->no_kamar }}</span>
        </nav>
        
        <h1 class="text-3xl font-bold text-gray-900">Booking Kamar {{ $kamar->no_kamar }}</h1>
        <p class="text-gray-600 mt-2">Lengkapi informasi booking Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:items-start">
        <!-- Left Column: Room Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-6 sticky top-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Kamar</h2>
                
                <!-- Room Image -->
                @if($kamar->foto_kamar1)
                <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden mb-4">
                    <img src="{!! $kamar->getPhotoUrl('foto_kamar1') !!}" 
                         alt="Kamar {{ $kamar->no_kamar }}"
                         class="w-full h-full object-cover">
                </div>
                @endif

                <!-- Room Details -->
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Nomor Kamar</span>
                        <span class="font-medium text-gray-900">{{ $kamar->no_kamar }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Tipe Kamar</span>
                        <span class="font-medium text-gray-900">{{ $kamar->tipeKamar->tipe_kamar }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ $kamar->status }}
                        </span>
                    </div>
                </div>

                <!-- Facilities -->
                <div class="mt-6">
                    <h3 class="font-medium text-gray-900 mb-2">Fasilitas</h3>
                    <p class="text-sm text-gray-600">{{ $kamar->tipeKamar->fasilitas }}</p>
                </div>

                @if($kamar->deskripsi)
                <div class="mt-6">
                    <h3 class="font-medium text-gray-900 mb-2">Deskripsi</h3>
                    <p class="text-sm text-gray-600">{{ $kamar->deskripsi }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Booking Form -->
        <div class="lg:col-span-2">
            <form id="bookingForm" action="{{ route('user.booking.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_kamar" value="{{ $kamar->id_kamar }}">
                <input type="hidden" name="tanggal_selesai" id="tanggal_selesai">

                <div class="space-y-6">
                    <!-- Step 1: Package Selection -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-600 text-sm font-medium mr-3">1</span>
                            Pilih Paket Kamar
                        </h3>
                        
                        @if($paketKamar->isEmpty())
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m14 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m14 0H6m14 0a2 2 0 01-2 2H6a2 2 0 01-2-2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada paket tersedia</h3>
                                <p class="mt-1 text-sm text-gray-500">Tidak ada paket kamar untuk tipe {{ $kamar->tipeKamar->tipe_kamar }}</p>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($paketKamar as $paket)
                                    @if($kamar->kapasitas_max >= $paket->kapasitas_kamar)
                                    <label class="block cursor-pointer">
                                        <input type="radio" 
                                               name="id_paket_kamar" 
                                               value="{{ $paket->id_paket_kamar }}"
                                               data-jenis="{{ $paket->jenis_paket }}"
                                               data-harga="{{ $paket->harga }}"
                                               data-kapasitas="{{ $paket->kapasitas_kamar }}"
                                               data-penghuni="{{ $paket->jumlah_penghuni }}"
                                               data-durasi="{{ $paket->durasi_hari ?? 0 }}"
                                               class="sr-only paket-radio"
                                               {{ old('id_paket_kamar') == $paket->id_paket_kamar ? 'checked' : '' }}>
                                        <div class="relative border-2 border-gray-200 rounded-lg p-4 hover:border-orange-300 transition-colors duration-200 package-card">
                                            <div class="flex items-center">
                                                <div class="flex-grow">
                                                    <h4 class="text-lg font-semibold text-gray-900">{{ $paket->jenis_paket }}</h4>
                                                    <p class="text-sm text-gray-600 mt-1">
                                                        Kapasitas {{ $paket->kapasitas_kamar }} orang • 
                                                        {{ $paket->jumlah_penghuni }} penghuni •
                                                        @if($paket->jenis_paket == 'Mingguan')
                                                            7 hari
                                                        @elseif($paket->jenis_paket == 'Bulanan')
                                                            30 hari
                                                        @else
                                                            365 hari
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0 ml-4">
                                                    <div class="text-xl font-bold text-orange-600">
                                                        Rp {{ number_format($paket->harga, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0 ml-6">
                                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center package-radio-indicator">
                                                        <svg class="w-4 h-4 text-white hidden checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        
                        @error('id_paket_kamar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Step 2: Date Selection -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-600 text-sm font-medium mr-3">2</span>
                            Pilih Tanggal Mulai
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="tanggal_mulai" 
                                       id="tanggal_mulai" 
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
                                    Tanggal Selesai
                                </label>
                                <input type="text" 
                                       id="tanggal_selesai_display" 
                                       class="w-full rounded-md border-gray-300 shadow-sm bg-gray-50 cursor-not-allowed" 
                                       readonly
                                       placeholder="Pilih paket dan tanggal mulai">
                                <p class="mt-1 text-sm text-gray-500">
                                    Akan dihitung otomatis berdasarkan paket yang dipilih
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Friend Email (conditional) -->
                    <div class="bg-white rounded-xl shadow-sm p-6" id="friend-section" style="display: none;">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-600 text-sm font-medium mr-3">3</span>
                            Email Teman (Booking 2 Orang)
                        </h3>
                        
                        <div class="max-w-md">
                            <label for="friend_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Teman <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="email" 
                                       name="friend_email" 
                                       id="friend_email" 
                                       value="{{ old('friend_email') }}"
                                       placeholder="Masukkan email teman yang sudah terdaftar"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('friend_email') border-red-300 @enderror pr-10">
                                
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <div id="email-loading" class="hidden">
                                        <svg class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                    <div id="email-valid" class="hidden">
                                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div id="email-invalid" class="hidden">
                                        <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p id="email-message" class="mt-1 text-sm hidden"></p>
                        @error('friend_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Booking Summary -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Booking</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Kamar</span>
                                <span class="font-medium text-gray-900">{{ $kamar->no_kamar }} ({{ $kamar->tipeKamar->tipe_kamar }})</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Paket</span>
                                <span class="font-medium text-gray-900" id="summary-paket">-</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Tanggal Mulai</span>
                                <span class="font-medium text-gray-900" id="summary-start">-</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Tanggal Selesai</span>
                                <span class="font-medium text-gray-900" id="summary-end">-</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Jumlah Penghuni</span>
                                <span class="font-medium text-gray-900" id="summary-occupants">1 orang</span>
                            </div>
                            
                            <div class="pt-3 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Total Pembayaran</span>
                                    <span class="text-2xl font-bold text-orange-600" id="summary-total">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <button type="submit" 
                                id="submit-btn"
                                class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                                disabled>
                            <span id="btn-text">Lanjutkan ke Pembayaran</span>
                            <svg class="w-5 h-5 ml-2" id="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                        <p class="text-xs text-gray-500 mt-4 text-center">
                            Dengan melanjutkan, Anda menyetujui syarat dan ketentuan yang berlaku.
                        </p>
                    </div>

                    @if($errors->any())
                    <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Terjadi kesalahan!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Custom styling for package selection */
.package-card {
    transition: all 0.2s ease;
}

.package-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.paket-radio:checked + .package-card {
    border-color: #f97316;
    background-color: #fff7ed;
}

.paket-radio:checked + .package-card .package-radio-indicator {
    border-color: #f97316;
    background-color: #f97316;
}

.paket-radio:checked + .package-card .package-radio-indicator .checkmark {
    display: block;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Booking system initializing...');
    
    // Elements
    const form = document.getElementById('bookingForm');
    const paketRadios = document.querySelectorAll('.paket-radio');
    const tanggalMulaiInput = document.getElementById('tanggal_mulai');
    const tanggalSelesaiDisplay = document.getElementById('tanggal_selesai_display');
    const tanggalSelesaiHidden = document.getElementById('tanggal_selesai');
    const friendSection = document.getElementById('friend-section');
    const friendEmailInput = document.getElementById('friend_email');
    const submitBtn = document.getElementById('submit-btn');
    
    // Summary elements
    const summaryPaket = document.getElementById('summary-paket');
    const summaryStart = document.getElementById('summary-start');
    const summaryEnd = document.getElementById('summary-end');
    const summaryOccupants = document.getElementById('summary-occupants');
    const summaryTotal = document.getElementById('summary-total');
    
    // Email validation elements
    const emailLoading = document.getElementById('email-loading');
    const emailValid = document.getElementById('email-valid');
    const emailInvalid = document.getElementById('email-invalid');
    const emailMessage = document.getElementById('email-message');
    
    // State
    let selectedPackage = null;
    let isEmailValid = false;
    let emailTimeout = null;
    
    // Functions
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', { 
            day: 'numeric', 
            month: 'long', 
            year: 'numeric' 
        });
    }
    
    function formatPrice(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount).replace('IDR', 'Rp');
    }
    
    function calculateEndDate() {
        const startDate = tanggalMulaiInput.value;
        if (!selectedPackage || !startDate) {
            tanggalSelesaiDisplay.value = 'Pilih paket dan tanggal mulai';
            tanggalSelesaiHidden.value = '';
            return null;
        }
        
        const durasi = parseInt(selectedPackage.dataset.durasi);
        if (!durasi) {
            console.error('Durasi tidak valid:', selectedPackage.dataset.durasi);
            return null;
        }
        
        const start = new Date(startDate);
        const end = new Date(start);
        end.setDate(start.getDate() + durasi);
        
        const endDateString = end.toISOString().split('T')[0];
        const endDateDisplay = formatDate(endDateString);
        
        tanggalSelesaiDisplay.value = endDateDisplay;
        tanggalSelesaiHidden.value = endDateString;
        
        console.log('End date calculated:', endDateString);
        return endDateString;
    }
    
    function updateSummary() {
        const startDate = tanggalMulaiInput.value;
        const endDate = calculateEndDate();
        
        // Update package info
        if (selectedPackage) {
            summaryPaket.textContent = selectedPackage.dataset.jenis;
            summaryTotal.textContent = formatPrice(selectedPackage.dataset.harga);
            
            // Update occupants based on package
            const penghuni = parseInt(selectedPackage.dataset.penghuni);
            summaryOccupants.textContent = penghuni + ' orang';
        } else {
            summaryPaket.textContent = '-';
            summaryTotal.textContent = 'Rp 0';
            summaryOccupants.textContent = '1 orang';
        }
        
        // Update dates
        summaryStart.textContent = formatDate(startDate);
        summaryEnd.textContent = formatDate(endDate);
        
        console.log('Summary updated');
    }
    
    function showFriendSection() {
        if (selectedPackage && parseInt(selectedPackage.dataset.penghuni) === 2) {
            friendSection.style.display = 'block';
            return true;
        } else {
            friendSection.style.display = 'none';
            friendEmailInput.value = '';
            resetEmailValidation();
            isEmailValid = false;
            return false;
        }
    }
    
    function validateForm() {
        const hasPackage = !!selectedPackage;
        const hasStartDate = !!tanggalMulaiInput.value;
        const needsFriend = selectedPackage && parseInt(selectedPackage.dataset.penghuni) === 2;
        
        let hasValidEmail = true;
        if (needsFriend) {
            const friendEmail = friendEmailInput.value.trim();
            hasValidEmail = friendEmail !== '' && isEmailValid;
        }
        
        const isValid = hasPackage && hasStartDate && hasValidEmail;
        
        submitBtn.disabled = !isValid;
        
        console.log('Form validation:', {
            hasPackage,
            hasStartDate,
            needsFriend,
            friendEmail: needsFriend ? friendEmailInput.value : 'not needed',
            isEmailValid,
            hasValidEmail,
            isValid
        });
        
        return isValid;
    }
    
    function resetEmailValidation() {
        emailLoading.classList.add('hidden');
        emailValid.classList.add('hidden');
        emailInvalid.classList.add('hidden');
        emailMessage.classList.add('hidden');
    }
    
    function validateEmail(email) {
        if (!email.trim()) {
            resetEmailValidation();
            isEmailValid = false;
            validateForm();
            return;
        }
        
        // Show loading
        resetEmailValidation();
        emailLoading.classList.remove('hidden');
        
        // Make API request
        fetch('/user/validate-friend-email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            resetEmailValidation();
            if (data.valid) {
                emailValid.classList.remove('hidden');
                emailMessage.textContent = `Pengguna ditemukan: ${data.name}`;
                emailMessage.className = 'mt-1 text-sm text-green-600';
                emailMessage.classList.remove('hidden');
                isEmailValid = true;
            } else {
                emailInvalid.classList.remove('hidden');
                emailMessage.textContent = data.message || 'Email tidak ditemukan';
                emailMessage.className = 'mt-1 text-sm text-red-600';
                emailMessage.classList.remove('hidden');
                isEmailValid = false;
            }
            validateForm();
        })
        .catch(error => {
            console.error('Email validation error:', error);
            resetEmailValidation();
            emailInvalid.classList.remove('hidden');
            emailMessage.textContent = 'Terjadi kesalahan validasi email';
            emailMessage.className = 'mt-1 text-sm text-red-600';
            emailMessage.classList.remove('hidden');
            isEmailValid = false;
            validateForm();
        });
    }
    
    // Event Listeners
    paketRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            selectedPackage = this;
            console.log('Package selected:', this.dataset.jenis);
            showFriendSection();
            updateSummary();
            validateForm();
        });
    });
    
    tanggalMulaiInput.addEventListener('change', function() {
        console.log('Start date changed:', this.value);
        updateSummary();
        validateForm();
    });
    
    friendEmailInput.addEventListener('input', function() {
        clearTimeout(emailTimeout);
        emailTimeout = setTimeout(() => {
            validateEmail(this.value);
        }, 500);
    });
    
    form.addEventListener('submit', function(e) {
        const formValid = validateForm();
        console.log('Form submission attempt:', {
            formValid,
            selectedPackage: selectedPackage ? selectedPackage.dataset.jenis : null,
            startDate: tanggalMulaiInput.value,
            needsFriend: selectedPackage && parseInt(selectedPackage.dataset.penghuni) === 2,
            isEmailValid,
            friendEmail: friendEmailInput.value
        });
        
        if (!formValid) {
            e.preventDefault();
            
            // Enhanced error message
            let errorMessage = 'Harap lengkapi data berikut:\n';
            if (!selectedPackage) errorMessage += '- Pilih paket kamar\n';
            if (!tanggalMulaiInput.value) errorMessage += '- Pilih tanggal mulai\n';
            if (selectedPackage && parseInt(selectedPackage.dataset.penghuni) === 2 && !isEmailValid) {
                errorMessage += '- Masukkan email teman yang valid\n';
            }
            
            alert(errorMessage);
            return;
        }
        
        // Log form data before submission
        const formData = new FormData(form);
        console.log('Form data being submitted:', Object.fromEntries(formData));
        
        // Disable button and show loading
        submitBtn.disabled = true;
        document.getElementById('btn-text').textContent = 'Memproses...';
        document.getElementById('btn-icon').innerHTML = '<svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    });
    
    // Initialize
    const checkedRadio = document.querySelector('.paket-radio:checked');
    if (checkedRadio) {
        selectedPackage = checkedRadio;
        showFriendSection();
        updateSummary();
    }
    validateForm();
    
    console.log('Booking system initialized successfully');
});
</script>
@endsection 
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

    <form action="{{ route('user.booking.store') }}" method="POST" id="bookingForm" class="space-y-8">
        @csrf
        <input type="hidden" name="id_kamar" value="{{ $kamar->id_kamar }}">
        <input type="hidden" name="tanggal_selesai" id="tanggal_selesai_hidden">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
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
            <div class="lg:col-span-2 space-y-6">
                <!-- Package Selection -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilih Paket Kamar</h3>
                    
                    @if($paketKamar->isEmpty())
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m14 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m14 0H6m14 0a2 2 0 01-2 2H6a2 2 0 01-2-2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada paket tersedia</h3>
                            <p class="mt-1 text-sm text-gray-500">Tidak ada paket kamar untuk tipe {{ $kamar->tipeKamar->tipe_kamar }}</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($paketKamar as $paket)
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-orange-300 hover:bg-orange-50 transition-colors duration-200">
                                    <input type="radio" name="id_paket_kamar" value="{{ $paket->id_paket_kamar }}" 
                                           class="paket-radio sr-only" 
                                           data-jenis="{{ $paket->jenis_paket }}"
                                           data-harga="{{ $paket->harga }}"
                                           data-kapasitas="{{ $paket->kapasitas_kamar }}"
                                           data-penghuni="{{ $paket->jumlah_penghuni }}"
                                           {{ old('id_paket_kamar') == $paket->id_paket_kamar ? 'checked' : '' }}
                                           required>
                                    
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="text-lg font-medium text-gray-900">{{ $paket->jenis_paket }}</h4>
                                                <p class="text-sm text-gray-600">
                                                    Kapasitas {{ $paket->kapasitas_kamar }} orang • {{ $paket->jumlah_penghuni }} penghuni
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
                                                <p class="text-sm text-gray-500">per {{ strtolower($paket->jenis_paket) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="radio-indicator ml-4 w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                        <div class="w-2.5 h-2.5 bg-orange-600 rounded-full hidden"></div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @endif
                    
                    @error('id_paket_kamar')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Selection -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilih Tanggal Booking</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Check-in <span class="text-red-500">*</span>
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
                            <label for="tanggal_selesai_display" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Check-out <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="tanggal_selesai_display" 
                                   class="w-full rounded-md border-gray-300 shadow-sm bg-gray-50 focus:border-orange-500 focus:ring-orange-500 @error('tanggal_selesai') border-red-300 @enderror" 
                                   readonly
                                   placeholder="Akan dihitung otomatis">
                            @error('tanggal_selesai')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                Akan dihitung otomatis berdasarkan paket yang dipilih
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Multi-Tenant Option -->
                <div class="bg-white rounded-xl shadow-sm p-6" id="multi-tenant-section" style="display: none;">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Booking Bersama Teman</h3>
                    
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="with_friend" name="with_friend" value="1" 
                               {{ old('with_friend') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-orange-600 shadow-sm focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50">
                        <label for="with_friend" class="ml-2 text-sm text-gray-900">
                            Saya ingin booking bersama teman (2 orang)
                        </label>
                    </div>

                    <div id="friend-selection" style="display: none;">
                        <label for="friend_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Teman
                        </label>
                        <div class="relative">
                            <input type="email" name="friend_email" id="friend_email" 
                                   value="{{ old('friend_email') }}"
                                   placeholder="Masukkan email teman yang sudah terdaftar"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('friend_email') border-red-300 @enderror pr-10">
                            
                            <!-- Loading/Status indicator -->
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <div id="email-loading" class="hidden">
                                    <svg class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                <div id="email-valid" class="hidden text-green-500">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div id="email-invalid" class="hidden text-red-500">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Validation message -->
                        <div id="email-validation-message" class="mt-1 text-sm hidden"></div>
                        
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
                        
                        <!-- Friend info will only be shown when email is valid -->
                        <div id="summary-friend-info" style="display: none;">
                            <div class="flex justify-between items-start">
                                <div class="text-right">
                                    <span class="font-medium text-gray-900" id="summary-friend-name"></span>
                                    <div class="text-xs text-gray-500" id="summary-friend-email"></div>
                                </div>
                            </div>
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
    console.log('DOM loaded, initializing booking form...');
    const form = document.getElementById('bookingForm');
    const paketRadios = document.querySelectorAll('.paket-radio');
    const tanggalMulaiInput = document.getElementById('tanggal_mulai');
    const tanggalSelesaiDisplay = document.getElementById('tanggal_selesai_display');
    const withFriendCheckbox = document.getElementById('with_friend');
    const friendSelection = document.getElementById('friend-selection');
    const multiTenantSection = document.getElementById('multi-tenant-section');
    const submitButton = document.getElementById('submit-booking');
    
    // Initialize form validity on page load
    submitButton.disabled = true;
    submitButton.classList.add('opacity-50', 'cursor-not-allowed');

    // Handle package selection
    paketRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                // Update radio button visual
                paketRadios.forEach(r => {
                    const indicator = r.closest('label').querySelector('.radio-indicator div');
                    if (r === this) {
                        indicator.classList.remove('hidden');
                        r.closest('label').classList.add('border-orange-500', 'bg-orange-50');
                    } else {
                        indicator.classList.add('hidden');
                        r.closest('label').classList.remove('border-orange-500', 'bg-orange-50');
                    }
                });

                // Show multi-tenant section only for capacity 2 AND intended for 2 people
                const kapasitas = parseInt(this.dataset.kapasitas);
                const penghuni = parseInt(this.dataset.penghuni);
                if (kapasitas === 2 && penghuni === 2) {
                    multiTenantSection.style.display = 'block';
                } else {
                    multiTenantSection.style.display = 'none';
                    withFriendCheckbox.checked = false;
                    friendSelection.style.display = 'none';
                    // Reset email validation when switching to single tenant package
                    resetEmailValidation();
                }

                updateSummary();
                updateEndDate();
                checkFormValidity();
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
            resetEmailValidation();
        }
        updateSummary();
        checkFormValidity();
    });

    // Email validation variables
    const friendEmailInput = document.getElementById('friend_email');
    const emailLoadingIcon = document.getElementById('email-loading');
    const emailValidIcon = document.getElementById('email-valid');
    const emailInvalidIcon = document.getElementById('email-invalid');
    const emailValidationMessage = document.getElementById('email-validation-message');
    let emailValidationTimeout;
    let isEmailValid = false;

    // Real-time email validation
    friendEmailInput.addEventListener('input', function() {
        const email = this.value.trim();
        
        // Clear previous timeout
        clearTimeout(emailValidationTimeout);
        
        // Reset validation state
        resetEmailValidation();
        
        if (!email) {
            return;
        }

        // Show loading after 500ms delay
        emailValidationTimeout = setTimeout(() => {
            validateEmailAsync(email);
        }, 500);
    });

    function resetEmailValidation() {
        isEmailValid = false;
        emailLoadingIcon.classList.add('hidden');
        emailValidIcon.classList.add('hidden');
        emailInvalidIcon.classList.add('hidden');
        emailValidationMessage.classList.add('hidden');
        friendEmailInput.classList.remove('border-green-500', 'border-red-500');
        friendEmailInput.classList.add('border-gray-300');
        
        // Hide friend info in summary
        const summaryFriendInfo = document.getElementById('summary-friend-info');
        if (summaryFriendInfo) {
            summaryFriendInfo.style.display = 'none';
        }
        
        // Reset teman field in summary
        const summaryTemanField = document.querySelector('[data-summary-field="teman"]');
        if (summaryTemanField) {
            summaryTemanField.textContent = '-';
        }
        
        checkFormValidity();
    }

    function showEmailLoading() {
        emailLoadingIcon.classList.remove('hidden');
        emailValidIcon.classList.add('hidden');
        emailInvalidIcon.classList.add('hidden');
        emailValidationMessage.classList.add('hidden');
    }

    function showEmailValid(message, userName) {
        isEmailValid = true;
        emailLoadingIcon.classList.add('hidden');
        emailValidIcon.classList.remove('hidden');
        emailInvalidIcon.classList.add('hidden');
        emailValidationMessage.classList.remove('hidden');
        emailValidationMessage.textContent = message;
        emailValidationMessage.className = 'mt-1 text-sm text-green-600';
        friendEmailInput.classList.remove('border-gray-300', 'border-red-500');
        friendEmailInput.classList.add('border-green-500');
        
        // Update summary with friend name
        updateSummaryWithFriend(userName);
        checkFormValidity();
    }

    function showEmailInvalid(message) {
        isEmailValid = false;
        emailLoadingIcon.classList.add('hidden');
        emailValidIcon.classList.add('hidden');
        emailInvalidIcon.classList.remove('hidden');
        emailValidationMessage.classList.remove('hidden');
        emailValidationMessage.textContent = message;
        emailValidationMessage.className = 'mt-1 text-sm text-red-600';
        friendEmailInput.classList.remove('border-gray-300', 'border-green-500');
        friendEmailInput.classList.add('border-red-500');
        
        // Reset teman field in summary when invalid
        const summaryTemanField = document.querySelector('[data-summary-field="teman"]');
        if (summaryTemanField) {
            summaryTemanField.textContent = '-';
        }
        
        checkFormValidity();
    }

    async function validateEmailAsync(email) {
        showEmailLoading();
        
        try {
            const response = await fetch('{{ route("user.booking.validateEmail") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: email })
            });

            const data = await response.json();
            
            if (data.valid) {
                showEmailValid(data.message, data.user_name);
            } else {
                showEmailInvalid(data.message);
            }
        } catch (error) {
            console.error('Email validation error:', error);
            showEmailInvalid('Terjadi kesalahan saat memvalidasi email');
        }
    }

    function updateSummaryWithFriend(friendName) {
        const friendInfo = document.getElementById('summary-friend-info');
        const friendNameElement = document.getElementById('summary-friend-name');
        const friendEmailElement = document.getElementById('summary-friend-email');
        
        if (friendName && withFriendCheckbox.checked && isEmailValid) {
            friendInfo.style.display = 'block';
            friendNameElement.textContent = friendName;
            friendEmailElement.textContent = friendEmailInput.value;
        } else {
            friendInfo.style.display = 'none';
            friendNameElement.textContent = '';
            friendEmailElement.textContent = '';
        }
        
        updateSummary();
        checkFormValidity();
    }

    function checkFormValidity() {
        const selectedPackage = document.querySelector('.paket-radio:checked');
        const startDate = tanggalMulaiInput.value;
        const submitButton = document.getElementById('submit-booking');
        
        // Initialize all validation flags
        let isPackageValid = selectedPackage !== null;
        let isDateValid = startDate && startDate.trim() !== '';
        let isFriendValid = true; // Default true for non-friend booking
        
        // Additional validation for friend booking
        if (selectedPackage) {
            const kapasitas = parseInt(selectedPackage.dataset.kapasitas);
            const penghuni = parseInt(selectedPackage.dataset.penghuni);
            
            if (kapasitas === 2 && penghuni === 2) {
                // This is a package that allows/requires friend booking
                if (!withFriendCheckbox.checked) {
                    // User must check the friend checkbox for this package
                    isFriendValid = false;
                } else {
                    // Friend checkbox is checked, validate email
                    isFriendValid = isEmailValid && friendEmailInput.value.trim() !== '';
                }
            } else if (withFriendCheckbox.checked) {
                // Wrong package selected for friend booking
                isFriendValid = false;
            }
        }
        
        // All conditions must be true
        const isValid = isPackageValid && isDateValid && isFriendValid;
        
        // Update button state
        submitButton.disabled = !isValid;
        
        if (isValid) {
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            submitButton.classList.add('hover:bg-orange-700');
        } else {
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            submitButton.classList.remove('hover:bg-orange-700');
        }
        
        // Debug log to help track validation state
        console.log('Form Validation State:', {
            isPackageValid,
            isDateValid,
            isFriendValid,
            isEmailValid,
            withFriendChecked: withFriendCheckbox.checked,
            finalValid: isValid
        });
    }

    // Handle date change
    tanggalMulaiInput.addEventListener('change', function() {
        updateEndDate();
        updateSummary();
        checkFormValidity();
    });

    function updateEndDate() {
        const selectedPackage = document.querySelector('.paket-radio:checked');
        const startDate = tanggalMulaiInput.value;
        const tanggalSelesaiHidden = document.getElementById('tanggal_selesai_hidden');

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
                // Update display field
                tanggalSelesaiDisplay.value = endDate.toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                // Update hidden field for form submission
                tanggalSelesaiHidden.value = endDate.toISOString().split('T')[0];
            }
        } else {
            tanggalSelesaiDisplay.value = '';
            tanggalSelesaiHidden.value = '';
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
        const summaryFriendInfo = document.getElementById('summary-friend-info');
        
        if (selectedPackage) {
            const jumlahPenghuni = parseInt(selectedPackage.dataset.penghuni);
            if (jumlahPenghuni === 2 && withFriend) {
                summaryOccupants.textContent = '2 orang';
                // Only show friend info if email is valid
                if (isEmailValid) {
                    summaryFriendInfo.style.display = 'flex';
                }
            } else {
                summaryOccupants.textContent = '1 orang';
                summaryFriendInfo.style.display = 'none';
            }
        } else {
            summaryOccupants.textContent = '-';
            summaryFriendInfo.style.display = 'none';
        }

        // Update total price
        const summaryTotal = document.getElementById('summary-total');
        if (selectedPackage) {
            const harga = parseInt(selectedPackage.dataset.harga);
            summaryTotal.textContent = `Rp ${harga.toLocaleString('id-ID')}`;
        } else {
            summaryTotal.textContent = 'Rp 0';
        }

        // Check form validity and update submit button state
        checkFormValidity();
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
            
            if (!isEmailValid) {
                e.preventDefault();
                alert('Email teman tidak valid atau tidak terdaftar di sistem MYKOST');
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

    // Initialize on page load
    updateSummary();
    
    // Restore state if there are old values (after validation error)
    const oldPackage = '{{ old("id_paket_kamar") }}';
    const oldDate = '{{ old("tanggal_mulai") }}';
    const oldWithFriend = '{{ old("with_friend") }}' === '1';
    
    if (oldPackage) {
        const packageRadio = document.querySelector(`input[value="${oldPackage}"]`);
        if (packageRadio) {
            packageRadio.checked = true;
            packageRadio.dispatchEvent(new Event('change'));
        }
    }
    
    if (oldDate) {
        tanggalMulaiInput.value = oldDate;
        updateEndDate();
        updateSummary();
    }
    
    if (oldWithFriend) {
        withFriendCheckbox.checked = true;
        withFriendCheckbox.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection 
@extends('layouts.user')

@section('title', 'Perpanjang Booking')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <a href="{{ route('penghuni.history.show', $booking->id_booking) }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
            &larr; Kembali ke Detail Booking
        </a>

        <h1 class="text-3xl font-bold text-gray-800 mb-6">Perpanjang Booking Kamar {{ $booking->kamar->no_kamar }}</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Form Perpanjangan -->
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Perpanjangan</h2>
                
                <form action="{{ route('penghuni.extension.store', $booking->id_booking) }}" method="POST" id="extensionForm">
                    @csrf
                    
                    <!-- Info Booking Saat Ini -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="font-semibold text-gray-700 mb-2">Booking Saat Ini</h3>
                        <p class="text-sm text-gray-600">Periode: {{ $booking->tanggal_mulai->isoFormat('D MMM YYYY') }} - {{ $booking->tanggal_selesai->isoFormat('D MMM YYYY') }}</p>
                        <p class="text-sm text-gray-600">Paket: {{ $booking->paketKamar->jenis_paket }} ({{ $booking->paketKamar->jumlah_penghuni }} Orang)</p>
                        @php
                            $currentEndDate = $booking->tanggal_selesai;
                            $today = \Carbon\Carbon::now();
                            $remainingDays = $today->diffInDays($currentEndDate, false);
                            
                            // Format remaining time
                            $remainingText = '';
                            if ($remainingDays > 0) {
                                switch($booking->paketKamar->jenis_paket) {
                                    case 'Mingguan':
                                        $weeks = round($remainingDays / 7, 3);
                                        $remainingText = "Sisa {$weeks} minggu lagi";
                                        $textColor = 'text-green-600';
                                        break;
                                    case 'Bulanan':
                                        $months = round($remainingDays / 30, 3);
                                        $remainingText = "Sisa {$months} bulan lagi";
                                        $textColor = 'text-green-600';
                                        break;
                                    case 'Tahunan':
                                        $years = round($remainingDays / 365, 3);
                                        $remainingText = "Sisa {$years} tahun lagi";
                                        $textColor = 'text-green-600';
                                        break;
                                }
                            } elseif ($remainingDays == 0) {
                                $remainingText = 'Berakhir hari ini';
                                $textColor = 'text-yellow-600';
                            } else {
                                $absDays = abs($remainingDays);
                                switch($booking->paketKamar->jenis_paket) {
                                    case 'Mingguan':
                                        $weeks = round($absDays / 7, 3);
                                        $remainingText = "Sudah berakhir {$weeks} minggu yang lalu";
                                        $textColor = 'text-red-600';
                                        break;
                                    case 'Bulanan':
                                        $months = round($absDays / 30, 3);
                                        $remainingText = "Sudah berakhir {$months} bulan yang lalu";
                                        $textColor = 'text-red-600';
                                        break;
                                    case 'Tahunan':
                                        $years = round($absDays / 365, 3);
                                        $remainingText = "Sudah berakhir {$years} tahun yang lalu";
                                        $textColor = 'text-red-600';
                                        break;
                                }
                            }
                        @endphp
                        <p class="text-sm {{ $textColor }} font-medium">{{ $remainingText }}</p>
                    </div>

                    <!-- Pilihan Paket -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Paket Perpanjangan</label>
                        <div class="space-y-3">
                            @php
                                $currentOccupancy = $booking->id_teman ? 2 : 1;
                            @endphp
                            @foreach($availablePackages as $package)
                                @if($package->jumlah_penghuni == $currentOccupancy)
                                <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200 package-option" 
                                     data-package-id="{{ $package->id_paket_kamar }}"
                                     data-package-type="{{ $package->jenis_paket }}"
                                     data-package-price="{{ $package->harga }}"
                                     data-package-duration="{{ $package->jenis_paket }}">
                                    <div class="flex items-center">
                                        <input type="radio" 
                                               name="id_paket_kamar" 
                                               value="{{ $package->id_paket_kamar }}" 
                                               id="package_{{ $package->id_paket_kamar }}"
                                               class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300" 
                                               data-package-type="{{ $package->jenis_paket }}"
                                               data-package-price="{{ $package->harga }}"
                                               required>
                                        <label for="package_{{ $package->id_paket_kamar }}" class="ml-3 flex-1 cursor-pointer">
                                            <div class="flex justify-between items-center">
                                                <span class="font-semibold text-gray-900">{{ $package->jenis_paket }}</span>
                                                <span class="text-lg font-bold text-orange-600">Rp {{ number_format($package->harga, 0, ',', '.') }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600">Kapasitas: {{ $package->jumlah_penghuni }} Orang</p>
                                        </label>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Hidden inputs untuk tanggal yang akan dihitung otomatis -->
                    <input type="hidden" name="tanggal_mulai_extension" id="tanggal_mulai_extension">
                    <input type="hidden" name="tanggal_selesai_extension" id="tanggal_selesai_extension">

                    <!-- Info Tanggal Perpanjangan (Read-only) -->
                    <div class="mb-6 bg-blue-50 p-4 rounded-lg" id="dateInfo" style="display: none;">
                        <h3 class="font-semibold text-gray-700 mb-2">Periode Perpanjangan</h3>
                        <p class="text-sm text-gray-600" id="extensionPeriodDisplay">-</p>
                        <p class="text-sm text-gray-600" id="extensionDurationDisplay">-</p>
                    </div>

                    <button type="submit" id="submitBtn" 
                            class="w-full bg-orange-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Lanjutkan ke Pembayaran
                    </button>
                </form>
            </div>

            <!-- Ringkasan Perpanjangan -->
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Perpanjangan</h2>
                
                <div id="extensionSummary" class="bg-gray-50 p-6 rounded-lg space-y-4 hidden">
                    <div class="border-b pb-4">
                        <h3 class="font-semibold text-gray-700 mb-2">Detail Kamar</h3>
                        <p class="text-sm text-gray-600">Kamar {{ $booking->kamar->no_kamar }} - {{ $booking->kamar->tipeKamar->tipe_kamar }}</p>
                    </div>
                    
                    <div class="border-b pb-4">
                        <h3 class="font-semibold text-gray-700 mb-2">Paket Terpilih</h3>
                        <p class="text-sm text-gray-600" id="selectedPackageType">-</p>
                        <p class="text-sm text-gray-600">Kapasitas: {{ $currentOccupancy }} Orang</p>
                    </div>
                    
                    <div class="border-b pb-4">
                        <h3 class="font-semibold text-gray-700 mb-2">Periode Perpanjangan</h3>
                        <p class="text-sm text-gray-600" id="extensionPeriod">-</p>
                        <p class="text-sm text-gray-600" id="extensionDuration">-</p>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Total Pembayaran</h3>
                        <p class="text-2xl font-bold text-orange-600" id="totalPrice">Rp 0</p>
                    </div>
                </div>

                <div id="noSummary" class="bg-gray-50 p-6 rounded-lg text-center text-gray-500">
                    <p>Pilih paket untuk melihat ringkasan perpanjangan</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const packageOptions = document.querySelectorAll('input[name="id_paket_kamar"]');
    const submitBtn = document.getElementById('submitBtn');
    const summary = document.getElementById('extensionSummary');
    const noSummary = document.getElementById('noSummary');
    const dateInfo = document.getElementById('dateInfo');
    const startDateHidden = document.getElementById('tanggal_mulai_extension');
    const endDateHidden = document.getElementById('tanggal_selesai_extension');
    
    // Tanggal selesai booking saat ini (format: YYYY-MM-DD) - konversi Carbon ke string
    const currentEndDateStr = '{{ $booking->tanggal_selesai->format("Y-m-d") }}';
    console.log('Current end date string from PHP:', currentEndDateStr);
    console.log('Date string length:', currentEndDateStr.length);
    console.log('Date string format check:', /^\d{4}-\d{2}-\d{2}$/.test(currentEndDateStr));
    
    // Validasi format tanggal dari PHP
    if (!currentEndDateStr || !/^\d{4}-\d{2}-\d{2}$/.test(currentEndDateStr)) {
        console.error('Invalid date format from PHP:', currentEndDateStr);
        alert('Error: Format tanggal booking tidak valid. Silakan refresh halaman.');
        return;
    }

    function calculateDates(packageType) {
        // Parse tanggal dengan format yang lebih robust
        console.log('Original date string:', currentEndDateStr);
        
        // Split date string dan parse manual untuk menghindari timezone issues
        const dateParts = currentEndDateStr.split('-');
        const year = parseInt(dateParts[0]);
        const month = parseInt(dateParts[1]) - 1; // Month is 0-indexed
        const day = parseInt(dateParts[2]);
        
        const currentEndDate = new Date(year, month, day);
        console.log('Current end date parsed:', currentEndDate, 'Valid:', !isNaN(currentEndDate.getTime()));
        
        // Perpanjangan mulai dari hari setelah booking saat ini berakhir
        const startDate = new Date(year, month, day + 1);
        console.log('Extension start date:', startDate, 'Valid:', !isNaN(startDate.getTime()));
        
        // Hitung tanggal selesai berdasarkan tipe paket
        let endDate;
        
        switch(packageType) {
            case 'Mingguan':
                // Tambah 7 hari dari tanggal mulai
                endDate = new Date(year, month, day + 1 + 7);
                break;
            case 'Bulanan':
                // Tambah 1 bulan dari tanggal mulai
                endDate = new Date(year, month + 1, day + 1);
                break;
            case 'Tahunan':
                // Tambah 1 tahun dari tanggal mulai
                endDate = new Date(year + 1, month, day + 1);
                break;
            default:
                endDate = new Date(year, month, day + 1 + 7); // Default mingguan
        }
        
        console.log('Package type:', packageType, 'End date:', endDate, 'Valid:', !isNaN(endDate.getTime()));
        
        return { startDate, endDate };
    }

    function formatDate(date) {
        // Cek apakah date valid
        if (!date || isNaN(date.getTime())) {
            console.error('Invalid date passed to formatDate:', date);
            return 'Invalid Date';
        }
        
        // Format tanggal untuk display (DD MMMM YYYY)
        const options = { 
            day: 'numeric', 
            month: 'long', 
            year: 'numeric',
            timeZone: 'Asia/Jakarta'
        };
        
        try {
            return date.toLocaleDateString('id-ID', options);
        } catch (error) {
            console.error('Error formatting date:', error, date);
            return 'Invalid Date';
        }
    }

    function formatDateForInput(date) {
        // Cek apakah date valid
        if (!date || isNaN(date.getTime())) {
            console.error('Invalid date passed to formatDateForInput:', date);
            return '';
        }
        
        // Format tanggal untuk input hidden (YYYY-MM-DD)
        try {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        } catch (error) {
            console.error('Error formatting date for input:', error, date);
            return '';
        }
    }

    function updateDisplay() {
        const selectedPackage = document.querySelector('input[name="id_paket_kamar"]:checked');
        
        if (selectedPackage) {
            const packageType = selectedPackage.getAttribute('data-package-type');
            const packagePriceStr = selectedPackage.getAttribute('data-package-price');
            const packagePrice = parseInt(packagePriceStr) || 0;
            
            console.log('Selected package:', packageType, 'Price string:', packagePriceStr, 'Price parsed:', packagePrice);
            
            // Hitung tanggal
            const { startDate, endDate } = calculateDates(packageType);
            
            // Validasi bahwa tanggal berhasil dihitung
            if (!startDate || !endDate || isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
                console.error('Failed to calculate valid dates:', { startDate, endDate, packageType });
                return;
            }
            
            // Update hidden inputs
            startDateHidden.value = formatDateForInput(startDate);
            endDateHidden.value = formatDateForInput(endDate);
            
            console.log('Hidden inputs updated:', startDateHidden.value, endDateHidden.value);
            
            // Tentukan durasi berdasarkan tipe paket
            let durationText = '';
            switch(packageType) {
                case 'Mingguan':
                    durationText = '1 minggu';
                    break;
                case 'Bulanan':
                    durationText = '1 bulan';
                    break;
                case 'Tahunan':
                    durationText = '1 tahun';
                    break;
                default:
                    durationText = '1 minggu'; // default
            }
            
            // Format tanggal untuk display
            const formattedStartDate = formatDate(startDate);
            const formattedEndDate = formatDate(endDate);
            const periodText = formattedStartDate + ' - ' + formattedEndDate;
            
            console.log('Formatted dates:', { formattedStartDate, formattedEndDate, periodText });
            
            // Update date info section
            const extensionPeriodDisplay = document.getElementById('extensionPeriodDisplay');
            const extensionDurationDisplay = document.getElementById('extensionDurationDisplay');
            
            if (extensionPeriodDisplay) {
                extensionPeriodDisplay.textContent = periodText;
            }
            if (extensionDurationDisplay) {
                extensionDurationDisplay.textContent = 'Durasi: ' + durationText;
            }
            dateInfo.style.display = 'block';
            
            // Update summary section
            const selectedPackageType = document.getElementById('selectedPackageType');
            const extensionPeriod = document.getElementById('extensionPeriod');
            const extensionDuration = document.getElementById('extensionDuration');
            const totalPrice = document.getElementById('totalPrice');
            
            if (selectedPackageType) {
                selectedPackageType.textContent = packageType;
            }
            if (extensionPeriod) {
                extensionPeriod.textContent = periodText;
            }
            if (extensionDuration) {
                extensionDuration.textContent = 'Durasi: ' + durationText;
            }
                         if (totalPrice) {
                 // Format harga dengan lebih baik
                 const formattedPrice = new Intl.NumberFormat('id-ID', {
                     style: 'currency',
                     currency: 'IDR',
                     minimumFractionDigits: 0,
                     maximumFractionDigits: 0
                 }).format(packagePrice);
                 totalPrice.textContent = formattedPrice;
             }
            
            // Show summary
            summary.classList.remove('hidden');
            noSummary.classList.add('hidden');
            submitBtn.disabled = false;
            
            console.log('Display updated successfully');
        } else {
            // Hide everything when no package selected
            dateInfo.style.display = 'none';
            summary.classList.add('hidden');
            noSummary.classList.remove('hidden');
            submitBtn.disabled = true;
            
            console.log('No package selected, hiding displays');
        }
    }

    // Event listeners untuk setiap radio button
    packageOptions.forEach(option => {
        option.addEventListener('change', function() {
            console.log('Package option changed:', this.value, 'Type:', this.getAttribute('data-package-type'), 'Price:', this.getAttribute('data-package-price'));
            updateDisplay();
        });
    });
    
    // Event listeners untuk package option divs (untuk memudahkan klik)
    document.querySelectorAll('.package-option').forEach(div => {
        div.addEventListener('click', function(e) {
            // Jangan trigger jika langsung klik radio button atau label
            if (e.target.type !== 'radio' && e.target.tagName !== 'LABEL' && !e.target.closest('label')) {
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    console.log('Package option div clicked:', radio.value, 'Type:', radio.getAttribute('data-package-type'), 'Price:', radio.getAttribute('data-package-price'));
                    updateDisplay();
                }
            }
        });
    });
    
    // Debug: Log available packages
    console.log('Available packages on page:', packageOptions.length);
    packageOptions.forEach((option, index) => {
        console.log(`Package ${index + 1}:`, {
            value: option.value,
            type: option.getAttribute('data-package-type'),
            price: option.getAttribute('data-package-price')
        });
    });
    
    // Initial call to set correct state
    updateDisplay();
});
</script>
@endsection 
@extends('layouts.user')

@section('title', 'Konfirmasi Pesanan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-indigo-400 to-indigo-600 rounded-full mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Konfirmasi Pesanan</h1>
            <p class="text-lg text-gray-600">Periksa kembali detail booking Anda sebelum melanjutkan pembayaran</p>
        </div>

        <!-- Booking Confirmation Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"></path>
                    </svg>
                    Detail Booking
                </h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Room Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kamar</h3>
                        
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <div class="flex items-center mb-4">
                                <div class="w-16 h-16 bg-gradient-to-br 
                                    @if($booking->kamar->tipeKamar->tipe_kamar == 'Standar') 
                                        from-green-400 to-green-600
                                    @elseif($booking->kamar->tipeKamar->tipe_kamar == 'Elite')
                                        from-blue-400 to-blue-600
                                    @else
                                        from-purple-400 to-purple-600
                                    @endif
                                    rounded-lg flex items-center justify-center mr-4">
                                    <span class="text-white font-bold text-lg">{{ $booking->kamar->no_kamar }}</span>
                                </div>
                                <div>
                                    <h4 class="text-xl font-semibold text-gray-900">Kamar {{ $booking->kamar->no_kamar }}</h4>
                                    <p class="text-gray-600">{{ $booking->kamar->tipeKamar->tipe_kamar }}</p>
                                </div>
                            </div>
                            
                            <!-- Room Images -->
                            @if($booking->kamar->getPhotoUrls())
                            <div class="grid grid-cols-2 gap-2 mb-4">
                                @foreach(array_slice($booking->kamar->getPhotoUrls(), 0, 4) as $index => $photoUrl)
                                <div class="aspect-w-16 aspect-h-12">
                                    <img src="{{ $photoUrl }}" 
                                         alt="Foto Kamar {{ $booking->kamar->no_kamar }} - {{ $index + 1 }}"
                                         class="w-full h-24 object-cover rounded-lg">
                                </div>
                                @endforeach
                            </div>
                            @endif
                            
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Luas Kamar</span>
                                    <span class="font-medium text-gray-900">{{ $booking->kamar->luas_kamar ?? 'Tidak tersedia' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Fasilitas</span>
                                    <span class="font-medium text-gray-900">{{ $booking->kamar->fasilitas ?? 'Standar' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">Paket</span>
                                <span class="font-semibold text-gray-900">{{ $booking->paketKamar->jenis_paket }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">Kapasitas</span>
                                <span class="font-medium text-gray-900">{{ $booking->paketKamar->jumlah_penghuni }} Orang</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">Harga per {{ strtolower($booking->paketKamar->jenis_paket) }}</span>
                                <span class="font-medium text-gray-900">Rp {{ number_format($booking->paketKamar->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pemesanan</h3>
                        
                        <div class="bg-blue-50 rounded-lg p-4 mb-6">
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-gray-900">Check-in</p>
                                        <p class="text-blue-700">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-gray-900">Check-out</p>
                                        <p class="text-blue-700">{{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-gray-900">Durasi</p>
                                        <p class="text-blue-700">{{ $booking->total_durasi ?? 'Belum dihitung' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">Status Booking</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    @if($booking->status_booking == 'Aktif')
                                        bg-green-100 text-green-800
                                    @elseif($booking->status_booking == 'Selesai')
                                        bg-blue-100 text-blue-800
                                    @elseif($booking->status_booking == 'Dibatalkan')
                                        bg-red-100 text-red-800
                                    @else
                                        bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $booking->status_booking }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">Booking ID</span>
                                <span class="font-mono font-medium text-gray-900">{{ $booking->id_booking }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">Tanggal Booking</span>
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Summary Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Ringkasan Pembayaran
                </h2>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Harga {{ $booking->paketKamar->jenis_paket }}</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($booking->paketKamar->harga, 0, ',', '.') }}</span>
                    </div>
                    
                    @if($booking->total_durasi && is_numeric(explode(' ', $booking->total_durasi)[0]))
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Durasi ({{ $booking->total_durasi }})</span>
                        <span class="font-medium text-gray-900">× {{ explode(' ', $booking->total_durasi)[0] }}</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($payment->jumlah_pembayaran * 0.9, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span>Biaya Admin (10%)</span>
                        <span>Rp {{ number_format($payment->jumlah_pembayaran * 0.1, 0, ',', '.') }}</span>
                    </div>
                    
                    <hr class="border-gray-200">
                    
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-green-600">Rp {{ number_format($payment->jumlah_pembayaran, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8">
            <h3 class="text-lg font-semibold text-yellow-900 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Syarat dan Ketentuan
            </h3>
            <div class="text-yellow-800 text-sm space-y-2">
                <label class="flex items-start cursor-pointer">
                    <input type="checkbox" id="agreeTerms" class="mt-1 mr-3 h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                    <span>Saya telah membaca dan menyetujui <a href="#" class="text-yellow-900 underline hover:text-yellow-700">syarat dan ketentuan</a> yang berlaku</span>
                </label>
                <label class="flex items-start cursor-pointer">
                    <input type="checkbox" id="agreeCancellation" class="mt-1 mr-3 h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                    <span>Saya memahami <a href="#" class="text-yellow-900 underline hover:text-yellow-700">kebijakan pembatalan</a> dan pengembalian dana</span>
                </label>
                <label class="flex items-start cursor-pointer">
                    <input type="checkbox" id="agreeData" class="mt-1 mr-3 h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                    <span>Saya menyetujui penggunaan data pribadi sesuai <a href="#" class="text-yellow-900 underline hover:text-yellow-700">kebijakan privasi</a></span>
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('user.rooms.show', $booking->kamar) }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            
            <button onclick="proceedToPayment()" 
                    id="paymentButton"
                    disabled
                    class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gray-400 cursor-not-allowed transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Lanjutkan Pembayaran
            </button>
        </div>

        <!-- Contact Information -->
        <div class="mt-8 text-center">
            <p class="text-gray-600 mb-2">Ada pertanyaan? Hubungi kami</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="tel:+6281234567890" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    +62 812-3456-7890
                </a>
                <span class="text-gray-400 hidden sm:block">•</span>
                <a href="mailto:support@mykost.com" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    support@mykost.com
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Check if all checkboxes are checked
function checkAllAgreements() {
    const agreeTerms = document.getElementById('agreeTerms').checked;
    const agreeCancellation = document.getElementById('agreeCancellation').checked;
    const agreeData = document.getElementById('agreeData').checked;
    
    const paymentButton = document.getElementById('paymentButton');
    
    if (agreeTerms && agreeCancellation && agreeData) {
        paymentButton.disabled = false;
        paymentButton.className = 'inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200';
    } else {
        paymentButton.disabled = true;
        paymentButton.className = 'inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gray-400 cursor-not-allowed transition duration-200';
    }
}

// Add event listeners to checkboxes
document.getElementById('agreeTerms').addEventListener('change', checkAllAgreements);
document.getElementById('agreeCancellation').addEventListener('change', checkAllAgreements);
document.getElementById('agreeData').addEventListener('change', checkAllAgreements);

function proceedToPayment() {
    if (!document.getElementById('paymentButton').disabled) {
        window.location.href = "{{ route('payment.form', $payment) }}";
    }
}
</script>
@endsection 
@extends('layouts.user')

@section('title', 'Pembayaran Gagal')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-red-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Failed Animation Container -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-r from-red-400 to-red-600 rounded-full mx-auto mb-6 animate-pulse">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Pembayaran Gagal</h1>
            <p class="text-lg text-gray-600">Maaf, terjadi kesalahan dalam proses pembayaran Anda</p>
        </div>

        <!-- Error Details Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    Detail Pembayaran Yang Gagal
                </h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Payment Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembayaran</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Order ID</span>
                                <span class="text-sm text-gray-900 font-mono bg-gray-100 px-2 py-1 rounded">{{ $payment->midtrans_order_id }}</span>
                            </div>
                            
                            @if($payment->midtrans_transaction_id)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Transaction ID</span>
                                <span class="text-sm text-gray-900 font-mono bg-gray-100 px-2 py-1 rounded">{{ $payment->midtrans_transaction_id }}</span>
                            </div>
                            @endif
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600">Total yang Gagal Dibayar</span>
                                <span class="text-lg font-bold text-red-600">Rp {{ number_format($payment->jumlah_pembayaran, 3, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Status</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $payment->status_pembayaran }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-gray-600">Waktu Percobaan</span>
                                <span class="text-sm text-gray-900">{{ $payment->tanggal_pembayaran->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Booking</h3>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 bg-gradient-to-br 
                                    @if($booking->kamar->tipeKamar->tipe_kamar == 'Standar') 
                                        from-green-400 to-green-600
                                    @elseif($booking->kamar->tipeKamar->tipe_kamar == 'Elite')
                                        from-blue-400 to-blue-600
                                    @else
                                        from-purple-400 to-purple-600
                                    @endif
                                    rounded-lg flex items-center justify-center mr-4">
                                    <span class="text-white font-bold">{{ $booking->kamar->no_kamar }}</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Kamar {{ $booking->kamar->no_kamar }}</h4>
                                    <p class="text-sm text-gray-600">{{ $booking->kamar->tipeKamar->tipe_kamar }}</p>
                                </div>
                            </div>
                            
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Paket</span>
                                    <span class="font-medium text-gray-900">{{ $booking->paketKamar->jenis_paket }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kapasitas</span>
                                    <span class="font-medium text-gray-900">{{ $booking->paketKamar->jumlah_penghuni }} Orang</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tanggal Mulai</span>
                                    <span class="font-medium text-gray-900">{{ $booking->tanggal_mulai->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tanggal Selesai</span>
                                    <span class="font-medium text-gray-900">{{ $booking->tanggal_selesai->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Explanation Card -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8">
            <h3 class="text-lg font-semibold text-yellow-900 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                Kemungkinan Penyebab Kegagalan
            </h3>
            <ul class="text-yellow-800 space-y-2">
                <li class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Saldo tidak mencukupi atau kartu tidak valid
                </li>
                <li class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Transaksi ditolak oleh bank atau sistem pembayaran
                </li>
                <li class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Gangguan jaringan atau timeout pada sistem
                </li>
                <li class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Pembayaran dibatalkan atau expired
                </li>
            </ul>
        </div>

        <!-- Solution Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
            <h3 class="text-lg font-semibold text-blue-900 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Langkah Selanjutnya
            </h3>
            <div class="text-blue-800 space-y-3">
                <div class="flex items-start">
                    <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-600 text-white text-sm font-medium rounded-full mr-3 mt-0.5">1</span>
                    <div>
                        <p class="font-medium">Periksa metode pembayaran Anda</p>
                        <p class="text-sm text-blue-700">Pastikan saldo mencukupi dan kartu masih berlaku</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-600 text-white text-sm font-medium rounded-full mr-3 mt-0.5">2</span>
                    <div>
                        <p class="font-medium">Coba ulangi pembayaran</p>
                        <p class="text-sm text-blue-700">Gunakan tombol "Coba Lagi" atau kembali ke halaman booking</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-600 text-white text-sm font-medium rounded-full mr-3 mt-0.5">3</span>
                    <div>
                        <p class="font-medium">Hubungi dukungan</p>
                        <p class="text-sm text-blue-700">Jika masalah berlanjut, hubungi admin atau customer service</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('user.rooms.show', $booking->kamar) }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Coba Lagi
            </a>
            
            <a href="{{ route('user.rooms.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5"></path>
                </svg>
                Pilih Kamar Lain
            </a>
            
            <a href="{{ route('user.dashboard') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        <!-- Support Contact -->
        <div class="mt-8 text-center">
            <p class="text-gray-600 mb-2">Butuh bantuan?</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="tel:+6281234567890" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Hubungi Admin
                </a>
                <span class="text-gray-400 hidden sm:block">•</span>
                <a href="mailto:support@mykost.com" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Email Support
                </a>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translate3d(0, -40px, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

.animate-slideInDown {
    animation: slideInDown 0.6s ease-out;
}
</style>

<script>
// Add slide in animation to cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.bg-white, .bg-yellow-50, .bg-blue-50');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('animate-slideInDown');
        }, index * 150);
    });
});
</script>
@endsection 
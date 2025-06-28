@extends('layouts.user')

@section('title', 'Memproses Pembayaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Processing Animation Container -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full mx-auto mb-6 animate-spin">
                <svg class="w-12 h-12 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Memproses Pembayaran</h1>
            <p class="text-lg text-gray-600">Mohon tunggu, pembayaran Anda sedang diproses...</p>
        </div>

        <!-- Progress Steps -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Progress Pembayaran
                </h2>
            </div>
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-8">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center step completed">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-green-600">Validasi</span>
                    </div>

                    <!-- Progress Line 1 -->
                    <div class="flex-1 h-1 bg-green-500 mx-4"></div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center step processing">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mb-2 animate-pulse">
                            <svg class="w-5 h-5 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-blue-600">Pemrosesan</span>
                    </div>

                    <!-- Progress Line 2 -->
                    <div class="flex-1 h-1 bg-gray-200 mx-4"></div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center step">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-400">Konfirmasi</span>
                    </div>
                </div>

                <!-- Status Messages -->
                <div class="space-y-3">
                    <div class="flex items-center p-3 bg-green-50 border border-green-200 rounded-lg">
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-green-800 font-medium">Data pembayaran telah divalidasi</span>
                    </div>

                    <div class="flex items-center p-3 bg-blue-50 border border-blue-200 rounded-lg animate-pulse">
                        <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                            <div class="w-2 h-2 bg-white rounded-full animate-bounce"></div>
                        </div>
                        <span class="text-blue-800 font-medium">Menghubungi gateway pembayaran...</span>
                    </div>

                    <div class="flex items-center p-3 bg-gray-50 border border-gray-200 rounded-lg">
                        <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                            <div class="w-2 h-2 bg-gray-500 rounded-full"></div>
                        </div>
                        <span class="text-gray-600">Menunggu konfirmasi pembayaran</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Details Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Detail Transaksi
                </h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Order Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Order</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Order ID</span>
                                <span class="text-sm text-gray-900 font-mono bg-gray-100 px-2 py-1 rounded">{{ $payment->midtrans_order_id }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Total Pembayaran</span>
                                <span class="text-lg font-bold text-purple-600">Rp {{ number_format($payment->jumlah_pembayaran, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Metode Pembayaran</span>
                                <span class="text-sm text-gray-900">{{ $payment->payment_method ?? 'Midtrans Gateway' }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-gray-600">Status</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <div class="w-2 h-2 bg-yellow-600 rounded-full mr-2 animate-pulse"></div>
                                    Memproses...
                                </span>
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
                                    <span class="text-gray-600">Durasi</span>
                                    <span class="font-medium text-gray-900">{{ $booking->total_durasi ?? 'Belum dihitung' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Check-in</span>
                                    <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Check-out</span>
                                    <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Important Notice -->
        <div class="bg-orange-50 border border-orange-200 rounded-xl p-6 mb-8">
            <h3 class="text-lg font-semibold text-orange-900 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                Harap Diperhatikan
            </h3>
            <ul class="text-orange-800 space-y-2">
                <li class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Jangan menutup halaman ini selama proses pembayaran berlangsung
                </li>
                <li class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Proses pembayaran dapat memakan waktu hingga 5 menit
                </li>
                <li class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Anda akan diarahkan otomatis setelah pembayaran selesai
                </li>
            </ul>
        </div>

        <!-- Cancel Button -->
        <div class="text-center">
            <button onclick="confirmCancel()" 
                    class="inline-flex items-center px-6 py-3 border border-red-300 text-base font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Batalkan Pembayaran
            </button>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="cancelModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <div class="flex items-center mb-4">
            <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900">Batalkan Pembayaran?</h3>
        </div>
        <p class="text-gray-600 mb-6">
            Apakah Anda yakin ingin membatalkan pembayaran ini? Proses yang sedang berjalan akan dihentikan.
        </p>
        <div class="flex space-x-4">
            <button onclick="closeModal()" 
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Tidak, Lanjutkan
            </button>
            <a href="{{ route('user.dashboard') }}" 
               class="flex-1 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-center">
                Ya, Batalkan
            </a>
        </div>
    </div>
</div>

<script>
// Check payment status periodically
let checkInterval;
let timeoutTimer;

document.addEventListener('DOMContentLoaded', function() {
    startPaymentCheck();
    startTimeout();
});

function startPaymentCheck() {
    checkInterval = setInterval(function() {
        checkPaymentStatus();
    }, 3000); // Check every 3 seconds
}

function startTimeout() {
    // Auto timeout after 5 minutes
    timeoutTimer = setTimeout(function() {
        clearInterval(checkInterval);
        window.location.href = "{{ route('payment.failed', $payment) }}";
    }, 300000); // 5 minutes
}

function checkPaymentStatus() {
    fetch(`/payment/status/{{ $payment->id_pembayaran }}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'Lunas') {
                clearInterval(checkInterval);
                clearTimeout(timeoutTimer);
                updateProgressToComplete();
                setTimeout(() => {
                    window.location.href = "{{ route('payment.success', $payment) }}";
                }, 2000);
            } else if (data.status === 'Gagal') {
                clearInterval(checkInterval);
                clearTimeout(timeoutTimer);
                window.location.href = "{{ route('payment.failed', $payment) }}";
            }
        })
        .catch(error => {
            console.error('Error checking payment status:', error);
        });
}

function updateProgressToComplete() {
    // Update step 3 to completed
    document.querySelector('.step:last-child .w-10').className = 'w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mb-2';
    document.querySelector('.step:last-child .w-10 svg').className = 'w-5 h-5 text-white';
    document.querySelector('.step:last-child span').className = 'text-sm font-medium text-green-600';
    
    // Update progress line
    document.querySelector('.flex-1.h-1.bg-gray-200').className = 'flex-1 h-1 bg-green-500 mx-4';
    
    // Update status
    document.querySelector('.bg-gray-50.border-gray-200').className = 'flex items-center p-3 bg-green-50 border border-green-200 rounded-lg';
    document.querySelector('.bg-gray-50 .bg-gray-300').className = 'w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3';
    document.querySelector('.text-gray-600').className = 'text-green-800 font-medium';
    document.querySelector('.text-gray-600').textContent = 'Pembayaran berhasil dikonfirmasi!';
}

function confirmCancel() {
    document.getElementById('cancelModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('cancelModal').classList.add('hidden');
}

// Close modal on outside click
document.getElementById('cancelModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection 
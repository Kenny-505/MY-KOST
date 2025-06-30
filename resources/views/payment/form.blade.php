@extends('layouts.user')

@section('title', 'Pembayaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-orange-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-purple-400 to-purple-600 rounded-full mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Pembayaran</h1>
            <p class="text-lg text-gray-600">Pilih metode pembayaran yang Anda inginkan</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Methods -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Summary -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Ringkasan Pesanan
                        </h2>
                    </div>
                    
                    <div class="p-6">
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
                                <h3 class="text-xl font-semibold text-gray-900">Kamar {{ $booking->kamar->no_kamar }}</h3>
                                <p class="text-gray-600">{{ $booking->kamar->tipeKamar->tipe_kamar }}</p>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Paket</span>
                                    <span class="font-medium text-gray-900">{{ $booking->paketKamar->jenis_paket }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kapasitas</span>
                                    <span class="font-medium text-gray-900">{{ $booking->paketKamar->jumlah_penghuni }} Orang</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Check-in</span>
                                    <span class="font-medium text-gray-900">{{ $booking->tanggal_mulai->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Check-out</span>
                                    <span class="font-medium text-gray-900">{{ $booking->tanggal_selesai->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Durasi</span>
                                    <span class="font-medium text-gray-900">{{ $booking->getFormattedTotalDurasi() }}</span>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Total Pembayaran</span>
                                    <span class="text-2xl font-bold text-purple-600">Rp {{ number_format($payment->jumlah_pembayaran, 3, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Metode Pembayaran
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <!-- Payment Method Selection -->
                        <form id="paymentForm">
                            @csrf
                            <input type="hidden" name="payment_id" value="{{ $payment->id_pembayaran }}">
                            
                            <div class="space-y-4">
                                <!-- Bank Transfer -->
                                <div class="border border-gray-200 rounded-lg hover:border-orange-300 transition duration-200">
                                    <label class="block p-4 cursor-pointer">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <input type="radio" name="payment_method" value="bank_transfer" class="mr-4">
                                                <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900">Bank Transfer</h3>
                                                    <p class="text-sm text-gray-600">BCA, BNI, BRI, Mandiri</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- E-Wallet -->
                                <div class="border border-gray-200 rounded-lg hover:border-orange-300 transition duration-200">
                                    <label class="block p-4 cursor-pointer">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <input type="radio" name="payment_method" value="ewallet" class="mr-4">
                                                <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-green-600 rounded-lg flex items-center justify-center mr-4">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900">E-Wallet</h3>
                                                    <p class="text-sm text-gray-600">GoPay, OVO, DANA, LinkAja</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Credit Card -->
                                <div class="border border-gray-200 rounded-lg hover:border-orange-300 transition duration-200">
                                    <label class="block p-4 cursor-pointer">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <input type="radio" name="payment_method" value="credit_card" class="mr-4">
                                                <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900">Kartu Kredit/Debit</h3>
                                                    <p class="text-sm text-gray-600">Visa, Mastercard, JCB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mt-8">
                                <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-4 px-6 rounded-lg text-lg font-semibold hover:from-orange-600 hover:to-orange-700 transition duration-200 transform hover:scale-105">
                                    Bayar Sekarang - Rp {{ number_format($payment->jumlah_pembayaran, 3, ',', '.') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="space-y-6">
                <!-- Payment Details -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-500 to-gray-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">Detail Pembayaran</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID Pembayaran</span>
                                <span class="font-medium text-gray-900">#{{ $payment->id_pembayaran }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status</span>
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    @if($payment->status_pembayaran == 'Belum bayar') bg-yellow-100 text-yellow-800
                                    @elseif($payment->status_pembayaran == 'Lunas') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $payment->status_pembayaran }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tipe Pembayaran</span>
                                <span class="font-medium text-gray-900">
                                    @if($payment->payment_type == 'Extension')
                                        Extension Booking
                                    @else
                                        {{ $payment->payment_type }}
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal</span>
                                <span class="font-medium text-gray-900">{{ $payment->tanggal_pembayaran->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-blue-900 mb-2">Pembayaran Aman</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Transaksi dilindungi SSL</li>
                                <li>• Data kartu tidak disimpan</li>
                                <li>• Verifikasi 3D Secure</li>
                                <li>• Support 24/7</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Informasi Kontak
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Telepon</p>
                                    <p class="font-medium text-gray-900">+62 812-3456-7890</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Email</p>
                                    <p class="font-medium text-gray-900">info@mykost.com</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Jam Operasional</p>
                                    <p class="font-medium text-gray-900">24/7 Customer Support</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">WhatsApp</p>
                                    <p class="font-medium text-gray-900">+62 812-3456-7890</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500 text-center">
                                Jika mengalami kesulitan dalam pembayaran, silakan hubungi customer service kami
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
    
    if (!selectedMethod) {
        alert('Silakan pilih metode pembayaran terlebih dahulu');
        return;
    }
    
    // Here you would typically integrate with actual payment gateway
    // For now, we'll show a simple message
    alert('Fitur pembayaran akan diintegrasikan dengan Midtrans di fase selanjutnya');
});
</script>
@endsection 
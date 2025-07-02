@extends('layouts.user')

@section('title', 'Detail Booking')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <a href="{{ route('penghuni.history.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
            &larr; Kembali ke Riwayat Booking
        </a>

        <h1 class="text-3xl font-bold text-gray-800">Detail Booking Kamar {{ $booking->kamar->no_kamar }}</h1>
        <p class="text-gray-600 mb-6">ID Booking: {{ $booking->id_booking }}</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Kolom Kiri: Detail Booking & Kamar -->
            <div class="space-y-4">
                <div>
                    <h3 class="font-semibold text-lg text-gray-800">Informasi Booking</h3>
                    <div class="mt-2 text-sm text-gray-600 space-y-2">
                        <p><strong class="font-medium text-gray-700">Tanggal Mulai:</strong> {{ $booking->tanggal_mulai->isoFormat('dddd, D MMMM YYYY') }}</p>
                        <p><strong class="font-medium text-gray-700">Tanggal Selesai:</strong> {{ $booking->tanggal_selesai->isoFormat('dddd, D MMMM YYYY') }}</p>
                        <p><strong class="font-medium text-gray-700">Total Durasi:</strong> {{ $booking->getFormattedTotalDurasi() }}</p>
                        <p><strong class="font-medium text-gray-700">Status:</strong> 
                           <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($booking->status_booking == 'Aktif') bg-green-200 text-green-800
                                @elseif($booking->status_booking == 'Selesai') bg-gray-200 text-gray-800
                                @else bg-red-200 text-red-800
                                @endif">
                                {{ $booking->status_booking }}
                            </span>
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-lg text-gray-800">Informasi Kamar</h3>
                    <div class="mt-2 text-sm text-gray-600 space-y-2">
                        <p><strong class="font-medium text-gray-700">Tipe Kamar:</strong> {{ $booking->kamar->tipeKamar->tipe_kamar }}</p>
                        <p><strong class="font-medium text-gray-700">Fasilitas:</strong> {{ $booking->kamar->tipeKamar->fasilitas }}</p>
                        <p><strong class="font-medium text-gray-700">Status Kamar:</strong> 
                           <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($booking->kamar->status == 'Terisi') bg-blue-200 text-blue-800
                                @elseif($booking->kamar->status == 'Dipesan') bg-yellow-200 text-yellow-800
                                @elseif($booking->kamar->status == 'Kosong') bg-gray-200 text-gray-800
                                @else bg-red-200 text-red-800
                                @endif">
                                {{ $booking->kamar->status }}
                            </span>
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-lg text-gray-800">Informasi Paket</h3>
                    <div class="mt-2 text-sm text-gray-600 space-y-2">
                        <p><strong class="font-medium text-gray-700">Jenis Paket:</strong> {{ $booking->paketKamar->jenis_paket }}</p>
                        <p><strong class="font-medium text-gray-700">Kapasitas:</strong> {{ $booking->paketKamar->jumlah_penghuni }} Orang</p>
                         <p><strong class="font-medium text-gray-700">Harga Paket:</strong> Rp {{ number_format($booking->paketKamar->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                
                 <div>
                    <h3 class="font-semibold text-lg text-gray-800">Informasi Penghuni</h3>
                    <div class="mt-2 text-sm text-gray-600 space-y-2">
                        <p><strong class="font-medium text-gray-700">Penghuni Utama:</strong> {{ $booking->penghuni->user->nama }} ({{ $booking->penghuni->user->email }})</p>
                        @if($booking->teman)
                            <p><strong class="font-medium text-gray-700">Penghuni Kedua:</strong> {{ $booking->teman->user->nama }} ({{ $booking->teman->user->email }})</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Detail Pembayaran -->
            <div class="space-y-4">
                <h3 class="font-semibold text-lg text-gray-800">Riwayat Pembayaran</h3>
                 @forelse($booking->pembayaran as $payment)
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold">Rp {{ number_format($payment->jumlah_pembayaran, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500">
                                @if($payment->payment_type == 'Extension')
                                    Extension Booking
                                @else
                                    {{ $payment->payment_type }}
                                @endif
                                - {{ $payment->tanggal_pembayaran->isoFormat('D MMMM YYYY') }}
                            </p>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full
                            @if($payment->status_pembayaran == 'Lunas') bg-green-200 text-green-800
                            @elseif($payment->status_pembayaran == 'Belum bayar') bg-yellow-200 text-yellow-800
                            @else bg-red-200 text-red-800
                            @endif">
                            {{ $payment->status_pembayaran }}
                        </span>
                    </div>
                    @if($payment->status_pembayaran == 'Lunas')
                    <div class="mt-2 text-right">
                         <a href="{{ route('penghuni.history.invoice', $payment->id_pembayaran) }}" class="text-sm text-blue-600 hover:underline">Lihat Invoice</a>
                    </div>
                    @endif
                </div>
                 @empty
                    <div class="text-center py-8 border rounded-lg">
                        <p class="text-gray-500">Tidak ada riwayat pembayaran untuk booking ini.</p>
                    </div>
                 @endforelse

                 @if($booking->status_booking == 'Aktif')
                     <div class="pt-4 border-t">
                         <h3 class="font-semibold text-lg text-gray-800 mb-3">Tindakan</h3>
                         <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                              <a href="{{ route('penghuni.extension.create', $booking->id_booking) }}" class="inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">
                                 Perpanjang Sewa
                             </a>
                             @if(!$booking->teman)
                                 <a href="{{ route('penghuni.addPenghuni.form', $booking->id_booking) }}" class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                                     Tambah Teman
                                 </a>
                             @endif
                              <button onclick="confirmCheckout({{ $booking->id_booking }})" class="inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition">
                                 Checkout
                             </button>
                         </div>
                     </div>
                 @endif
            </div>
        </div>
    </div>
</div>

<!-- Checkout Confirmation Modal -->
<div id="checkoutModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Konfirmasi Checkout</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin melakukan checkout dari kamar <strong>{{ $booking->kamar->no_kamar }}</strong>?
                </p>
                <p class="text-sm text-red-600 mt-2">
                    Aksi ini akan mengakhiri sewa kamar Anda dan mengubah status booking menjadi selesai.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="checkoutForm" method="POST" action="{{ route('penghuni.checkout', $booking) }}">
                    @csrf
                    <div class="flex gap-x-3">
                        <button type="button" 
                                onclick="closeCheckoutModal()" 
                                class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Ya, Checkout
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmCheckout(bookingId) {
    document.getElementById('checkoutModal').classList.remove('hidden');
}

function closeCheckoutModal() {
    document.getElementById('checkoutModal').classList.add('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('checkoutModal');
    if (event.target == modal) {
        closeCheckoutModal();
    }
}
</script>
@endpush 
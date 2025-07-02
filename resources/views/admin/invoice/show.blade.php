@extends('layouts.admin')

@section('header')
    Detail Invoice #{{ str_pad($pembayaran->id_pembayaran, 6, '0', STR_PAD_LEFT) }}
@endsection

@section('breadcrumb')
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-600 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('admin.invoice.index') }}" class="text-gray-600 hover:text-blue-600 ml-1 md:ml-2 font-medium">
                        Invoice & Transaksi
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-500 ml-1 md:ml-2 font-medium">Detail Invoice</span>
                </div>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <div class="flex items-center">
                    <div class="mr-4">
                        <div class="h-12 w-12 rounded-full 
                            {{ $pembayaran->status_pembayaran === 'Lunas' ? 'bg-green-100' : 
                            ($pembayaran->status_pembayaran === 'Belum bayar' ? 'bg-yellow-100' : 'bg-red-100') }} 
                            flex items-center justify-center">
                            <svg class="h-6 w-6 
                                {{ $pembayaran->status_pembayaran === 'Lunas' ? 'text-green-600' : 
                                ($pembayaran->status_pembayaran === 'Belum bayar' ? 'text-yellow-600' : 'text-red-600') }}" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Invoice #{{ str_pad($pembayaran->id_pembayaran, 6, '0', STR_PAD_LEFT) }}</h1>
                        <div class="flex items-center space-x-3 mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $pembayaran->status_pembayaran === 'Lunas' ? 'bg-green-100 text-green-800' : 
                                ($pembayaran->status_pembayaran === 'Belum bayar' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $pembayaran->status_pembayaran }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $pembayaran->payment_type === 'Booking' ? 'bg-blue-100 text-blue-800' : 
                                ($pembayaran->payment_type === 'Extension' ? 'bg-purple-100 text-purple-800' : 'bg-indigo-100 text-indigo-800') }}">
                                {{ $pembayaran->payment_type }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 lg:mt-0 flex flex-col sm:flex-row gap-x-3 gap-y-2">
                <button onclick="showUpdateStatusModal()" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Update Status
                </button>
                
                <a href="{{ route('admin.invoice.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-6 gap-y-6">
        <!-- Left Column: Payment Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Payment Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Pembayaran</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">ID Pembayaran</label>
                            <p class="mt-1 text-sm text-gray-900 font-mono">#{{ str_pad($pembayaran->id_pembayaran, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $pembayaran->tanggal_pembayaran->format('d/m/Y H:i') }} WIB</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $pembayaran->status_pembayaran === 'Lunas' ? 'bg-green-100 text-green-800' : 
                                ($pembayaran->status_pembayaran === 'Belum bayar' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $pembayaran->status_pembayaran }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Pembayaran</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $pembayaran->payment_type === 'Booking' ? 'bg-blue-100 text-blue-800' : 
                                ($pembayaran->payment_type === 'Extension' ? 'bg-purple-100 text-purple-800' : 'bg-indigo-100 text-indigo-800') }}">
                                {{ $pembayaran->payment_type }}
                            </span>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
                            <p class="mt-1 text-xl font-bold text-gray-900">Rp {{ number_format($pembayaran->jumlah_pembayaran, 0, ',', '.') }}</p>
                        </div>
                        @if($pembayaran->admin_note)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Catatan Admin</label>
                            <p class="mt-1 text-sm bg-gray-50 p-3 border border-gray-200 rounded-md">{{ $pembayaran->admin_note }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Midtrans Integration -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Midtrans</h3>
                </div>
                <div class="p-6">
                    @if($pembayaran->midtrans_order_id || $pembayaran->midtrans_transaction_id)
                    <div class="space-y-4">
                        @if($pembayaran->midtrans_order_id)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Midtrans Order ID</label>
                            <p class="mt-1 text-sm font-mono bg-gray-50 p-2 rounded border border-gray-200">{{ $pembayaran->midtrans_order_id }}</p>
                        </div>
                        @endif

                        @if($pembayaran->midtrans_transaction_id)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Midtrans Transaction ID</label>
                            <p class="mt-1 text-sm font-mono bg-gray-50 p-2 rounded border border-gray-200">{{ $pembayaran->midtrans_transaction_id }}</p>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="py-4 text-center">
                        <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-500">Tidak ada data Midtrans untuk transaksi ini.</p>
                        <p class="text-xs text-gray-400 mt-1">Transaksi dilakukan secara manual atau belum diproses melalui Midtrans.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Booking Information -->
            @if($pembayaran->booking)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Booking</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">ID Booking</label>
                            <p class="mt-1 text-sm text-gray-900 font-mono">#{{ str_pad($pembayaran->booking->id_booking, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status Booking</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $pembayaran->booking->status_booking === 'Aktif' ? 'bg-green-100 text-green-800' : 
                                ($pembayaran->booking->status_booking === 'Selesai' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                                {{ $pembayaran->booking->status_booking }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $pembayaran->booking->tanggal_mulai ? \Carbon\Carbon::parse($pembayaran->booking->tanggal_mulai)->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $pembayaran->booking->tanggal_selesai ? \Carbon\Carbon::parse($pembayaran->booking->tanggal_selesai)->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Durasi</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $pembayaran->booking->total_durasi ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Paket</label>
                            <p class="mt-1 text-sm text-gray-900">{{ optional($pembayaran->booking->paketKamar)->jenis_paket ?? '-' }} ({{ optional($pembayaran->booking->paketKamar)->jumlah_penghuni ?? '-' }} orang)</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column: User & Room Info -->
        <div class="space-y-6">
            <!-- User Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi User</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">{{ $pembayaran->user->nama ?? '-' }}</h4>
                            <p class="text-sm text-gray-500">{{ $pembayaran->user->email ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <div class="space-y-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor HP</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pembayaran->user->no_hp ?? '-' }}</p>
                            </div>
                            @if($pembayaran->booking && $pembayaran->booking->penghuni)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status Penghuni</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ optional($pembayaran->booking->penghuni)->status_penghuni === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ optional($pembayaran->booking->penghuni)->status_penghuni ?? '-' }}
                                </span>
                            </div>
                            @endif
                            @if($pembayaran->booking && $pembayaran->booking->teman)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Teman Sekamar</label>
                                <p class="mt-1 text-sm text-gray-900">{{ optional(optional($pembayaran->booking->teman)->user)->nama ?? '-' }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Information -->
            @if($pembayaran->kamar)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Kamar</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Kamar</label>
                        <p class="mt-1 text-sm text-gray-900 font-medium">{{ $pembayaran->kamar->no_kamar ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipe Kamar</label>
                        <p class="mt-1 text-sm text-gray-900">{{ optional($pembayaran->kamar->tipeKamar)->tipe_kamar ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status Kamar</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $pembayaran->kamar->status === 'Kosong' ? 'bg-green-100 text-green-800' : 
                            ($pembayaran->kamar->status === 'Dipesan' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ $pembayaran->kamar->status ?? '-' }}
                        </span>
                    </div>
                    @if($pembayaran->kamar->foto_kamar1)
                    <div class="mt-4">
                        <img src="data:image/jpeg;base64,{{ $pembayaran->kamar->foto_kamar1 }}"
                             class="h-40 w-full object-cover rounded-lg"
                             alt="{{ $pembayaran->kamar->no_kamar }}">
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Print Invoice Button -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <a href="{{ route('admin.invoice.generatePDF', $pembayaran) }}" target="_blank" class="flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H7a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H7a2 2 0 00-2 2v4a2 2 0 002 2h2" />
                    </svg>
                    Cetak Invoice
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div id="updateStatusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Update Status Pembayaran</h3>
            <form method="POST" action="{{ route('admin.invoice.updateStatus', $pembayaran) }}">
                @csrf
                @method('PATCH')
                <div class="space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="statusSelect" name="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="Belum bayar" {{ $pembayaran->status_pembayaran === 'Belum bayar' ? 'selected' : '' }}>Belum bayar</option>
                            <option value="Gagal" {{ $pembayaran->status_pembayaran === 'Gagal' ? 'selected' : '' }}>Gagal</option>
                            <option value="Lunas" {{ $pembayaran->status_pembayaran === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>
                    <div>
                        <label for="admin_note" class="block text-sm font-medium text-gray-700">Catatan Admin (Opsional)</label>
                        <textarea id="admin_note" name="admin_note" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Tambahkan catatan...">{{ $pembayaran->admin_note }}</textarea>
                    </div>
                </div>
                <div class="flex gap-x-3 mt-6">
                    <button type="button" 
                            onclick="closeUpdateStatusModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Update Status Modal
function showUpdateStatusModal() {
    document.getElementById('updateStatusModal').classList.remove('hidden');
}

function closeUpdateStatusModal() {
    document.getElementById('updateStatusModal').classList.add('hidden');
}

// Close modals when clicking outside
window.onclick = function(event) {
    const updateModal = document.getElementById('updateStatusModal');
    if (event.target == updateModal) {
        closeUpdateStatusModal();
    }
}
</script>
@endpush

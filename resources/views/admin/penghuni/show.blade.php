@extends('layouts.admin')

@section('header')
    Detail Penghuni - {{ $penghuni->user->nama }}
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
                    <a href="{{ route('admin.penghuni.index') }}" class="text-gray-600 hover:text-blue-600 ml-1 md:ml-2 font-medium">
                        Kelola Penghuni
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-500 ml-1 md:ml-2 font-medium">{{ $penghuni->user->nama }}</span>
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
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="h-16 w-16 rounded-full bg-{{ $penghuni->status_penghuni === 'Aktif' ? 'green' : 'gray' }}-100 flex items-center justify-center">
                        <svg class="h-8 w-8 text-{{ $penghuni->status_penghuni === 'Aktif' ? 'green' : 'gray' }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $penghuni->user->nama }}</h1>
                    <div class="flex items-center space-x-3 mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $penghuni->status_penghuni === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $penghuni->status_penghuni }}
                        </span>
                        <span class="text-sm text-gray-500">ID: {{ str_pad($penghuni->id_penghuni, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 lg:mt-0 flex flex-col sm:flex-row gap-x-3 gap-y-2">
                @if($penghuni->status_penghuni === 'Aktif' && $penghuni->booking->where('status_booking', 'Aktif')->count() > 0)
                <button onclick="confirmForceCheckout({{ $penghuni->id_penghuni }}, '{{ $penghuni->user->nama }}')" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Force Checkout
                </button>
                @endif
                
                <a href="{{ route('admin.penghuni.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Overview Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-4">
        @php
            $totalBookings = $penghuni->booking->count();
            $activeBookings = $penghuni->booking->where('status_booking', 'Aktif')->count();
            $completedBookings = $penghuni->booking->where('status_booking', 'Selesai')->count();
            $totalComplaints = $penghuni->pengaduan->count();
        @endphp
        
        <x-stat-box 
            title="Total Booking" 
            :value="$totalBookings" 
            icon="calendar" 
            color="blue"
            subtitle="Sepanjang masa"
        />
        
        <x-stat-box 
            title="Booking Aktif" 
            :value="$activeBookings" 
            icon="calendar-check" 
            color="green"
            subtitle="Sedang berlangsung"
        />
        
        <x-stat-box 
            title="Booking Selesai" 
            :value="$completedBookings" 
            icon="check-circle" 
            color="gray"
            subtitle="Telah checkout"
        />
        
        <x-stat-box 
            title="Total Pengaduan" 
            :value="$totalComplaints" 
            icon="exclamation-triangle" 
            color="orange"
            subtitle="Sepanjang masa"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-6 gap-y-6">
        <!-- Left Column: Personal Information -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Personal Info -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Personal</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $penghuni->user->nama }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $penghuni->user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor HP</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $penghuni->user->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status Penghuni</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $penghuni->status_penghuni === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $penghuni->status_penghuni }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Daftar</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $penghuni->created_at->format('d F Y H:i') }}</p>
                        <p class="text-xs text-gray-500">{{ $penghuni->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Current Active Bookings -->
            @if($activeBookings > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Booking Aktif</h3>
                </div>
                <div class="p-6">
                    @foreach($penghuni->booking->where('status_booking', 'Aktif') as $booking)
                    <div class="border border-green-200 rounded-lg p-4 {{ !$loop->last ? 'mb-4' : '' }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-900">{{ $booking->kamar->no_kamar ?? '-' }}</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Aktif
                            </span>
                        </div>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><strong>Tipe:</strong> {{ $booking->kamar->tipeKamar->tipe_kamar ?? '-' }}</p>
                            <p><strong>Paket:</strong> {{ $booking->paketKamar->jenis_paket ?? '-' }}</p>
                            <p><strong>Mulai:</strong> {{ $booking->tanggal_mulai ? \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d/m/Y') : '-' }}</p>
                            <p><strong>Selesai:</strong> {{ $booking->tanggal_selesai ? \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d/m/Y') : '-' }}</p>
                            @if($booking->tanggal_selesai)
                            @php
                                $remaining = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($booking->tanggal_selesai), false);
                            @endphp
                            <p><strong>Sisa:</strong> 
                                @if($remaining > 0)
                                    {{ $remaining }} hari
                                @elseif($remaining == 0)
                                    <span class="text-orange-600 font-medium">Berakhir hari ini</span>
                                @else
                                    <span class="text-red-600 font-medium">Expired</span>
                                @endif
                            </p>
                            @endif
                            @if($booking->teman)
                            <p><strong>Teman:</strong> {{ $booking->teman->user->nama ?? '-' }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column: Booking History & Complaints -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Booking History -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Riwayat Booking</h3>
                </div>
                <div class="overflow-x-auto">
                    @if($penghuni->booking->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kamar</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paket</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teman</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($penghuni->booking->sortByDesc('created_at') as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->kamar->no_kamar ?? '-' }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->kamar->tipeKamar->tipe_kamar ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->paketKamar->jenis_paket ?? '-' }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->paketKamar->jumlah_penghuni ?? '-' }} orang</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>{{ $booking->tanggal_mulai ? \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d/m/Y') : '-' }}</div>
                                    <div class="text-gray-500">{{ $booking->tanggal_selesai ? \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d/m/Y') : '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $booking->status_booking === 'Aktif' ? 'bg-green-100 text-green-800' : 
                                           ($booking->status_booking === 'Selesai' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $booking->status_booking }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $booking->teman->user->nama ?? '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="px-6 py-12 text-center">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 12v-2m0 0V9m0 2h8m-8 0H4" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada booking</h3>
                        <p class="text-gray-500">Penghuni ini belum pernah melakukan booking.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Complaints History -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Riwayat Pengaduan</h3>
                </div>
                <div class="overflow-x-auto">
                    @if($penghuni->pengaduan->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kamar</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($penghuni->pengaduan->sortByDesc('tanggal_pengaduan') as $pengaduan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($pengaduan->tanggal_pengaduan)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($pengaduan->judul_pengaduan, 40) }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($pengaduan->isi_pengaduan, 60) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $pengaduan->kamar->no_kamar ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $pengaduan->status === 'Menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($pengaduan->status === 'Diproses' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                        {{ $pengaduan->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="px-6 py-12 text-center">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pengaduan</h3>
                        <p class="text-gray-500">Penghuni ini belum pernah mengajukan pengaduan.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Force Checkout Confirmation Modal -->
<div id="forceCheckoutModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Konfirmasi Force Checkout</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin melakukan force checkout untuk penghuni <strong id="penghuniName">{{ $penghuni->user->nama }}</strong>?
                </p>
                <p class="text-sm text-red-600 mt-2">
                    Aksi ini akan mengubah status penghuni menjadi Non-aktif dan mengakhiri semua booking yang sedang berlangsung.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="forceCheckoutForm" method="POST" action="{{ route('admin.penghuni.force-checkout', $penghuni) }}">
                    @csrf
                    <div class="flex gap-x-3">
                        <button type="button" 
                                onclick="closeForceCheckoutModal()" 
                                class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Ya, Force Checkout
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
function confirmForceCheckout(penghuniId, penghuniName) {
    document.getElementById('forceCheckoutModal').classList.remove('hidden');
}

function closeForceCheckoutModal() {
    document.getElementById('forceCheckoutModal').classList.add('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('forceCheckoutModal');
    if (event.target == modal) {
        closeForceCheckoutModal();
    }
}
</script>
@endpush 
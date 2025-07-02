@extends('layouts.admin')

@section('header')
    Kelola Penghuni
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
                    <span class="text-gray-500 ml-1 md:ml-2 font-medium">Kelola Penghuni</span>
                </div>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-4">
        @php
            $totalPenghuni = $penghuni->total();
            $activePenghuni = $penghuni->where('status_penghuni', 'Aktif')->count();
            $inactivePenghuni = $penghuni->where('status_penghuni', 'Non-aktif')->count();
            $activeBookings = $penghuni->filter(function($p) { 
                return $p->booking->where('status_booking', 'Aktif')->count() > 0; 
            })->count();
        @endphp
        
        <x-stat-box 
            title="Total Penghuni" 
            :value="$totalPenghuni" 
            icon="users" 
            color="blue"
            subtitle="Terdaftar di sistem"
        />
        
        <x-stat-box 
            title="Penghuni Aktif" 
            :value="$activePenghuni" 
            icon="user-check" 
            color="green"
            subtitle="Sedang menghuni"
        />
        
        <x-stat-box 
            title="Penghuni Non-Aktif" 
            :value="$inactivePenghuni" 
            icon="user-x" 
            color="red"
            subtitle="Sudah checkout"
        />
        
        <x-stat-box 
            title="Booking Aktif" 
            :value="$activeBookings" 
            icon="calendar-check" 
            color="orange"
            subtitle="Sedang berlangsung"
        />
    </div>

    <!-- Filter and Search -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.penghuni.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-x-4 gap-y-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Nama, email, atau nomor HP..." 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="Aktif" {{ request('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Non-aktif" {{ request('status') === 'Non-aktif' ? 'selected' : '' }}>Non-aktif</option>
                        </select>
                    </div>

                    <!-- Has Booking Filter -->
                    <div>
                        <label for="has_booking" class="block text-sm font-medium text-gray-700 mb-1">Status Booking</label>
                        <select id="has_booking" name="has_booking" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua</option>
                            <option value="yes" {{ request('has_booking') === 'yes' ? 'selected' : '' }}>Ada Booking</option>
                            <option value="no" {{ request('has_booking') === 'no' ? 'selected' : '' }}>Tidak Ada Booking</option>
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <select id="sort" name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Tanggal Daftar</option>
                            <option value="nama" {{ request('sort') === 'nama' ? 'selected' : '' }}>Nama</option>
                            <option value="status_penghuni" {{ request('sort') === 'status_penghuni' ? 'selected' : '' }}>Status</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-x-3 gap-y-2">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>
                    
                    <a href="{{ route('admin.penghuni.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </a>
                    

                </div>
            </form>
        </div>
    </div>

    <!-- Penghuni Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Daftar Penghuni</h3>
            <p class="text-sm text-gray-600 mt-1">Menampilkan {{ $penghuni->firstItem() ?? 0 }} - {{ $penghuni->lastItem() ?? 0 }} dari {{ $penghuni->total() }} penghuni</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penghuni</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($penghuni as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-{{ $p->status_penghuni === 'Aktif' ? 'green' : 'gray' }}-100 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-{{ $p->status_penghuni === 'Aktif' ? 'green' : 'gray' }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $p->user->nama }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ str_pad($p->id_penghuni, 4, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $p->user->email }}</div>
                            <div class="text-sm text-gray-500">{{ $p->user->no_hp ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $p->status_penghuni === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $p->status_penghuni }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $activeBookings = $p->booking->where('status_booking', 'Aktif');
                                $totalBookings = $p->booking->count();
                            @endphp
                            <div class="text-sm text-gray-900">
                                @if($activeBookings->count() > 0)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $activeBookings->count() }} Aktif
                                    </span>
                                @else
                                    <span class="text-gray-500">Tidak ada</span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500">Total: {{ $totalBookings }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $p->created_at->format('d/m/Y') }}
                            <br>
                            <span class="text-xs text-gray-400">{{ $p->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('admin.penghuni.show', $p) }}" 
                               class="inline-flex items-center px-3 py-1 border border-blue-300 text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-md text-xs transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Detail
                            </a>
                            
                            @if($p->status_penghuni === 'Aktif' && $activeBookings->count() > 0)
                            <button onclick="confirmForceCheckout({{ $p->id_penghuni }}, '{{ $p->user->nama }}')" 
                                    class="inline-flex items-center px-3 py-1 border border-red-300 text-red-700 bg-red-50 hover:bg-red-100 rounded-md text-xs transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Force Checkout
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada penghuni</h3>
                                <p class="text-gray-500">Tidak ada data penghuni yang sesuai dengan filter yang diterapkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($penghuni->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $penghuni->links() }}
        </div>
        @endif
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
                    Apakah Anda yakin ingin melakukan force checkout untuk penghuni <strong id="penghuniName"></strong>?
                </p>
                <p class="text-sm text-red-600 mt-2">
                    Aksi ini akan mengubah status penghuni menjadi Non-aktif dan mengakhiri semua booking yang sedang berlangsung.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="forceCheckoutForm" method="POST">
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
    document.getElementById('penghuniName').textContent = penghuniName;
    document.getElementById('forceCheckoutForm').action = `/admin/penghuni/${penghuniId}/force-checkout`;
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
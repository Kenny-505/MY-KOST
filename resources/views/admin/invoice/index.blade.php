@extends('layouts.admin')

@section('header')
    Kelola Invoice & Transaksi
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
                    <span class="text-gray-500 ml-1 md:ml-2 font-medium">Invoice & Transaksi</span>
                </div>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Financial Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-4">
        <x-stat-box 
            title="Total Transaksi" 
            :value="$statistics['total_transactions']" 
            icon="document-text" 
            color="blue"
            subtitle="Semua transaksi"
        />
        
        <x-stat-box 
            title="Total Pendapatan" 
            :value="'Rp ' . number_format($statistics['paid_amount'], 0, ',', '.')" 
            icon="cash" 
            color="green"
            subtitle="Pembayaran lunas"
        />
        
        <x-stat-box 
            title="Pending Payment" 
            :value="'Rp ' . number_format($statistics['pending_amount'], 0, ',', '.')" 
            icon="clock" 
            color="orange"
            subtitle="Menunggu pembayaran"
        />
        
        <x-stat-box 
            title="Success Rate" 
            :value="$statistics['payment_success_rate'] . '%'" 
            icon="badge-check" 
            color="green"
            subtitle="Tingkat keberhasilan"
        />
    </div>

    <!-- Payment Type Breakdown -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4">
        <x-stat-box 
            title="Booking Payment" 
            :value="'Rp ' . number_format($statistics['booking_payments'], 0, ',', '.')" 
            icon="home" 
            color="blue"
            subtitle="Pembayaran booking awal"
        />
        
        <x-stat-box 
            title="Extension Payment" 
            :value="'Rp ' . number_format($statistics['extension_payments'], 0, ',', '.')" 
            icon="calendar-check" 
            color="purple"
            subtitle="Perpanjangan booking"
        />
        
        <x-stat-box 
            title="Additional Payment" 
            :value="'Rp ' . number_format($statistics['additional_payments'], 0, ',', '.')" 
            icon="user-plus" 
            color="indigo"
            subtitle="Tambah penghuni"
        />
    </div>

    <!-- Advanced Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.invoice.index') }}" class="space-y-4">
                <!-- Primary Filters Row -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-x-4 gap-y-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Nama, email, Order ID..." 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            @foreach($statusOptions as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Payment Type -->
                    <div>
                        <label for="payment_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                        <select id="payment_type" name="payment_type" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Jenis</option>
                            @foreach($paymentTypeOptions as $type)
                            <option value="{{ $type }}" {{ request('payment_type') === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" 
                               id="date_from" 
                               name="date_from" 
                               value="{{ request('date_from') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" 
                               id="date_to" 
                               name="date_to" 
                               value="{{ request('date_to') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Secondary Filters Row -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-x-4 gap-y-4">
                    <!-- Room Type -->
                    <div>
                        <label for="room_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Kamar</label>
                        <select id="room_type" name="room_type" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Tipe</option>
                            @foreach($roomTypeOptions as $roomType)
                            <option value="{{ $roomType->id_tipe_kamar }}" {{ request('room_type') == $roomType->id_tipe_kamar ? 'selected' : '' }}>
                                {{ $roomType->tipe_kamar }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Amount Min -->
                    <div>
                        <label for="amount_min" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Min</label>
                        <input type="number" 
                               id="amount_min" 
                               name="amount_min" 
                               value="{{ request('amount_min') }}"
                               placeholder="Rp 0" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Amount Max -->
                    <div>
                        <label for="amount_max" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Max</label>
                        <input type="number" 
                               id="amount_max" 
                               name="amount_max" 
                               value="{{ request('amount_max') }}"
                               placeholder="Rp 999,999,999" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Sort -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <select id="sort" name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="tanggal_pembayaran" {{ request('sort') === 'tanggal_pembayaran' ? 'selected' : '' }}>Tanggal</option>
                            <option value="jumlah_pembayaran" {{ request('sort') === 'jumlah_pembayaran' ? 'selected' : '' }}>Jumlah</option>
                            <option value="status_pembayaran" {{ request('sort') === 'status_pembayaran' ? 'selected' : '' }}>Status</option>
                            <option value="user_name" {{ request('sort') === 'user_name' ? 'selected' : '' }}>Nama User</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-x-3 gap-y-2">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>
                    
                    <a href="{{ route('admin.invoice.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </a>
                    
                    <button type="button" 
                            onclick="exportData()" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export PDF
                    </button>


                </div>
            </form>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Daftar Transaksi</h3>
            <p class="text-sm text-gray-600 mt-1">Menampilkan {{ $payments->firstItem() ?? 0 }} - {{ $payments->lastItem() ?? 0 }} dari {{ $payments->total() }} transaksi</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>

                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID & User</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis & Kamar</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Midtrans</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">#{{ str_pad($payment->id_pembayaran, 6, '0', STR_PAD_LEFT) }}</div>
                            <div class="text-sm text-gray-500">{{ $payment->user->nama ?? '-' }}</div>
                            <div class="text-xs text-gray-400">{{ $payment->user->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $payment->payment_type === 'Booking' ? 'bg-blue-100 text-blue-800' : 
                                       ($payment->payment_type === 'Extension' ? 'bg-purple-100 text-purple-800' : 'bg-indigo-100 text-indigo-800') }}">
                                    {{ $payment->payment_type }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-500">{{ $payment->kamar->no_kamar ?? '-' }}</div>
                            <div class="text-xs text-gray-400">{{ $payment->kamar->tipeKamar->tipe_kamar ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Rp {{ number_format($payment->jumlah_pembayaran, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $payment->status_pembayaran === 'Lunas' ? 'bg-green-100 text-green-800' : 
                                   ($payment->status_pembayaran === 'Belum bayar' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $payment->status_pembayaran }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($payment->tanggal_pembayaran)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($payment->midtrans_order_id)
                            <div class="text-xs text-gray-600">{{ Str::limit($payment->midtrans_order_id, 15) }}</div>
                            @endif
                            @if($payment->midtrans_transaction_id)
                            <div class="text-xs text-gray-400">{{ Str::limit($payment->midtrans_transaction_id, 15) }}</div>
                            @endif
                            @if(!$payment->midtrans_order_id && !$payment->midtrans_transaction_id)
                            <span class="text-xs text-gray-400">Manual</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('admin.invoice.show', $payment) }}" 
                               class="inline-flex items-center px-3 py-1 border border-blue-300 text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-md text-xs transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada transaksi</h3>
                                <p class="text-gray-500">Tidak ada data transaksi yang sesuai dengan filter yang diterapkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($payments->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $payments->links() }}
        </div>
        @endif
    </div>
</div>





@endsection

@push('scripts')
<script>
// Export function
function exportData() {
    console.log('Export function called');
    
    // Create form to collect all filter values
    const form = document.createElement('form');
    form.method = 'GET';
    form.action = '{{ route('admin.invoice.export') }}';
    form.style.display = 'none';
    
    // Get all filter values from the form inputs
    const filterInputs = [
        { name: 'search', selector: 'input[name="search"]' },
        { name: 'status', selector: 'select[name="status"]' },
        { name: 'payment_type', selector: 'select[name="payment_type"]' },
        { name: 'date_from', selector: 'input[name="date_from"]' },
        { name: 'date_to', selector: 'input[name="date_to"]' },
        { name: 'amount_min', selector: 'input[name="amount_min"]' },
        { name: 'amount_max', selector: 'input[name="amount_max"]' },
        { name: 'room_type', selector: 'select[name="room_type"]' },
        { name: 'sort', selector: 'select[name="sort"]' }
    ];
    
    // Add current sort direction from URL if exists
    const urlParams = new URLSearchParams(window.location.search);
    const currentDirection = urlParams.get('direction') || 'desc';
    
    filterInputs.forEach(filter => {
        const element = document.querySelector(filter.selector);
        if (element && element.value && element.value !== '' && element.value !== 'all') {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = filter.name;
            input.value = element.value;
            form.appendChild(input);
            console.log(`Adding filter: ${filter.name} = ${element.value}`);
        }
    });
    
    // Add sort direction
    const directionInput = document.createElement('input');
    directionInput.type = 'hidden';
    directionInput.name = 'direction';
    directionInput.value = currentDirection;
    form.appendChild(directionInput);
    console.log(`Adding direction: ${currentDirection}`);
    
    // Add export parameter
    const exportInput = document.createElement('input');
    exportInput.type = 'hidden';
    exportInput.name = 'export';
    exportInput.value = 'pdf';
    form.appendChild(exportInput);
    
    console.log('Form created with filters:', form);
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}


</script>
@endpush 
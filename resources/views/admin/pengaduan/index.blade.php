<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Kelola Pengaduan') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Kelola dan tanggapi pengaduan dari penghuni</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.pengaduan.export', request()->query()) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 border-l-4 border-blue-500">
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</div>
                    <div class="text-sm text-gray-600">Total Pengaduan</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 border-l-4 border-yellow-500">
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
                    <div class="text-sm text-gray-600">Menunggu</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 border-l-4 border-orange-500">
                    <div class="text-2xl font-bold text-orange-600">{{ $stats['in_progress'] }}</div>
                    <div class="text-sm text-gray-600">Diproses</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 border-l-4 border-green-500">
                    <div class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</div>
                    <div class="text-sm text-gray-600">Selesai</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 border-l-4 border-purple-500">
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['with_response'] }}</div>
                    <div class="text-sm text-gray-600">Ada Response</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 border-l-4 border-red-500">
                    <div class="text-2xl font-bold text-red-600">{{ $stats['without_response'] }}</div>
                    <div class="text-sm text-gray-600">Belum Response</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                                <input type="text" 
                                       name="search" 
                                       id="search"
                                       value="{{ request('search') }}" 
                                       placeholder="Cari judul, isi, nama penghuni, atau no kamar..."
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="">Semua Status</option>
                                    @foreach($statusOptions as $status)
                                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Response Status -->
                            <div>
                                <label for="has_response" class="block text-sm font-medium text-gray-700 mb-1">Status Response</label>
                                <select name="has_response" id="has_response" class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="">Semua</option>
                                    <option value="yes" {{ request('has_response') === 'yes' ? 'selected' : '' }}>Sudah Ada Response</option>
                                    <option value="no" {{ request('has_response') === 'no' ? 'selected' : '' }}>Belum Ada Response</option>
                                </select>
                            </div>

                            <!-- Room Type Filter -->
                            <div>
                                <label for="tipe_kamar" class="block text-sm font-medium text-gray-700 mb-1">Tipe Kamar</label>
                                <select name="tipe_kamar" id="tipe_kamar" class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="">Semua Tipe</option>
                                    @foreach($tipeKamarOptions as $tipe)
                                        <option value="{{ $tipe->id_tipe_kamar }}" {{ request('tipe_kamar') == $tipe->id_tipe_kamar ? 'selected' : '' }}>
                                            {{ $tipe->tipe_kamar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Date Range -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                <input type="date" 
                                       name="start_date" 
                                       id="start_date"
                                       value="{{ request('start_date') }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                                <input type="date" 
                                       name="end_date" 
                                       id="end_date"
                                       value="{{ request('end_date') }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            </div>
                            <div class="flex items-end space-x-2">
                                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Filter
                                </button>
                                <a href="{{ route('admin.pengaduan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bulk Actions -->
            @if($pengaduan->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-4 border-b border-gray-200">
                    <form id="bulkForm" method="POST" action="{{ route('admin.pengaduan.bulkUpdateStatus') }}">
                        @csrf
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-orange-600 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                <label for="selectAll" class="ml-2 text-sm text-gray-700">Pilih Semua</label>
                            </div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center" disabled id="bulkSubmit">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Proses Pengaduan Terpilih
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Pengaduan Table -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="overflow-x-auto">
                    @if($pengaduan->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <input type="checkbox" class="rounded border-gray-300 text-orange-600 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'tanggal_pengaduan', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center hover:text-gray-700">
                                            Tanggal
                                            @if(request('sort') === 'tanggal_pengaduan')
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if(request('direction') === 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    @endif
                                                </svg>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'penghuni_nama', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center hover:text-gray-700">
                                            Penghuni
                                            @if(request('sort') === 'penghuni_nama')
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if(request('direction') === 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    @endif
                                                </svg>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'kamar_no', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center hover:text-gray-700">
                                            Kamar
                                            @if(request('sort') === 'kamar_no')
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if(request('direction') === 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    @endif
                                                </svg>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Judul Pengaduan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center hover:text-gray-700">
                                            Status
                                            @if(request('sort') === 'status')
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if(request('direction') === 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    @endif
                                                </svg>
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Response
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pengaduan as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="pengaduan_ids[]" value="{{ $item->id_pengaduan }}" form="bulkForm" class="pengaduan-checkbox rounded border-gray-300 text-orange-600 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->tanggal_pengaduan->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->penghuni->user->nama }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->penghuni->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->kamar->no_kamar }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->kamar->tipeKamar->tipe_kamar }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($item->judul_pengaduan, 50) }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($item->isi_pengaduan, 80) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item->status === 'Menunggu')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Menunggu
                                            </span>
                                        @elseif($item->status === 'Diproses')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                Diproses
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($item->hasResponse())
                                            <span class="inline-flex items-center text-green-600">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Ada Response
                                            </span>
                                        @else
                                            <span class="inline-flex items-center text-red-600">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Belum Response
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.pengaduan.show', $item) }}" 
                                               class="text-orange-600 hover:text-orange-900 transition duration-200">
                                                Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            {{ $pengaduan->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L5.482 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pengaduan</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if(request()->hasAny(['search', 'status', 'start_date', 'end_date', 'tipe_kamar', 'has_response']))
                                    Tidak ada pengaduan yang sesuai dengan filter yang dipilih.
                                @else
                                    Belum ada pengaduan yang masuk dari penghuni.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Handle select all checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.pengaduan-checkbox');
            const bulkSubmit = document.getElementById('bulkSubmit');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            
            bulkSubmit.disabled = !this.checked;
        });

        // Handle individual checkboxes
        document.querySelectorAll('.pengaduan-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedBoxes = document.querySelectorAll('.pengaduan-checkbox:checked');
                const bulkSubmit = document.getElementById('bulkSubmit');
                const selectAll = document.getElementById('selectAll');
                
                bulkSubmit.disabled = checkedBoxes.length === 0;
                selectAll.checked = checkedBoxes.length === document.querySelectorAll('.pengaduan-checkbox').length;
            });
        });

        // Handle bulk form submission
        document.getElementById('bulkForm').addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.pengaduan-checkbox:checked');
            
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu pengaduan untuk diproses.');
                return;
            }
            
            if (!confirm(`Apakah Anda yakin ingin memproses ${checkedBoxes.length} pengaduan terpilih? Hanya pengaduan dengan status "Menunggu" yang akan diubah menjadi "Diproses".`)) {
                e.preventDefault();
            }
        });
    </script>
    @endpush
</x-admin-layout> 
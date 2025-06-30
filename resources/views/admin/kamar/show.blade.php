<x-admin-layout>
    <x-slot name="pageTitle">Detail Kamar {{ $kamar->no_kamar }}</x-slot>
    <x-slot name="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a></li>
        <li class="text-gray-500">/</li>
        <li><a href="{{ route('admin.kamar.index') }}" class="text-blue-600 hover:text-blue-800">Kamar</a></li>
        <li class="text-gray-500">/</li>
        <li class="text-gray-900 font-medium">{{ $kamar->no_kamar }}</li>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Kamar {{ $kamar->no_kamar }}</h2>
                    <div class="flex items-center space-x-4">
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            {{ $kamar->status === 'Kosong' ? 'bg-green-100 text-green-800' : 
                               ($kamar->status === 'Dipesan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            @if($kamar->status === 'Kosong')
                                Tersedia
                            @elseif($kamar->status === 'Dipesan')
                                Dipesan
                            @elseif($kamar->status === 'Terisi')
                                Sedang Ditempati
                            @else
                            {{ $kamar->status }}
                            @endif
                        </span>
                        <span class="text-sm text-gray-500">
                            Tipe: <span class="font-medium text-gray-900">{{ $kamar->tipeKamar->tipe_kamar }}</span>
                        </span>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.kamar.edit', $kamar) }}" 
                       class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit Kamar</span>
                    </a>
                    <a href="{{ route('admin.kamar.index') }}" 
                       class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                        </svg>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Room Photos -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Photos Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Foto Kamar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @php
                            $photos = $kamar->getPhotoUrls();
                        @endphp
                        
                        @foreach(['foto1', 'foto2', 'foto3'] as $index => $photoKey)
                            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                                @if($photos[$photoKey])
                                    <img src="{!! $photos[$photoKey] !!}" 
                                         alt="Foto Kamar {{ $index + 1 }}"
                                         class="w-full h-full object-cover cursor-pointer hover:scale-105 transition duration-300"
                                         onclick="openImageModal('{!! addslashes($photos[$photoKey]) !!}', 'Foto Kamar {{ $index + 1 }}')">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="text-sm text-gray-500">Foto {{ $index + 1 }}</p>
                                            <p class="text-xs text-gray-400">Tidak ada</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Description Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi Kamar</h3>
                    @if($kamar->deskripsi)
                        <div class="prose prose-gray max-w-none">
                            <p class="text-gray-700 leading-relaxed">{{ $kamar->deskripsi }}</p>
                        </div>
                    @else
                        <p class="text-gray-500 italic">Tidak ada deskripsi tersedia.</p>
                    @endif
                </div>

                <!-- Facilities Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Fasilitas Tipe {{ $kamar->tipeKamar->tipe_kamar }}</h3>
                    <div class="prose prose-gray max-w-none">
                        <p class="text-gray-700 leading-relaxed">{{ $kamar->tipeKamar->fasilitas }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Info & Statistics -->
            <div class="space-y-6">
                <!-- Room Info Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kamar</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                            <span class="text-sm text-gray-600">Nomor Kamar</span>
                            <span class="text-sm font-medium text-gray-900">{{ $kamar->no_kamar }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                            <span class="text-sm text-gray-600">Tipe Kamar</span>
                            <span class="text-sm font-medium text-gray-900">{{ $kamar->tipeKamar->tipe_kamar }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                            <span class="text-sm text-gray-600">Status</span>
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $kamar->status === 'Kosong' ? 'bg-green-100 text-green-800' : 
                                   ($kamar->status === 'Dipesan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                @if($kamar->status === 'Kosong')
                                    Tersedia
                                @elseif($kamar->status === 'Dipesan')
                                    Dipesan
                                @elseif($kamar->status === 'Terisi')
                                    Sedang Ditempati
                                @else
                                {{ $kamar->status }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                            <span class="text-sm text-gray-600">Dibuat</span>
                            <span class="text-sm font-medium text-gray-900">{{ $kamar->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-600">Terakhir Update</span>
                            <span class="text-sm font-medium text-gray-900">{{ $kamar->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Booking History -->
                @if($kamar->bookings->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Booking</h3>
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @foreach($kamar->bookings->take(5) as $booking)
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $booking->penghuni->user->nama }}
                                </span>
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $booking->status_booking === 'Aktif' ? 'bg-green-100 text-green-800' : 
                                       ($booking->status_booking === 'Selesai' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $booking->status_booking }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-600">
                                {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Complaints -->
                @if($kamar->pengaduan->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengaduan Terkait</h3>
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @foreach($kamar->pengaduan->take(5) as $pengaduan)
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $pengaduan->judul_pengaduan }}
                                </span>
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $pengaduan->status === 'Menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($pengaduan->status === 'Diproses' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $pengaduan->status }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-600">
                                {{ \Carbon\Carbon::parse($pengaduan->tanggal_pengaduan)->format('d M Y H:i') }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Statistics Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Booking</span>
                            <span class="text-sm font-medium text-gray-900">{{ $kamar->bookings->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Booking Aktif</span>
                            <span class="text-sm font-medium text-gray-900">{{ $kamar->bookings->where('status_booking', 'Aktif')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Pengaduan</span>
                            <span class="text-sm font-medium text-gray-900">{{ $kamar->pengaduan->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Pengaduan Pending</span>
                            <span class="text-sm font-medium text-gray-900">{{ $kamar->pengaduan->where('status', 'Menunggu')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
            <p id="modalCaption" class="text-white text-center mt-4"></p>
        </div>
    </div>

    <script>
        function openImageModal(src, caption) {
            document.getElementById('modalImage').src = src;
            document.getElementById('modalCaption').textContent = caption;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal on outside click
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</x-admin-layout> 
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Detail Pengaduan') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Lihat detail dan tanggapi pengaduan penghuni</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.pengaduan.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Pengaduan Details -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Informasi Pengaduan</h3>
                                <div class="flex items-center space-x-2">
                                    @if($pengaduan->status === 'Menunggu')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Menunggu
                                        </span>
                                    @elseif($pengaduan->status === 'Diproses')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            Diproses
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Selesai
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tanggal Pengaduan</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->tanggal_pengaduan->format('d F Y, H:i') }} WIB</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">ID Pengaduan</label>
                                        <p class="mt-1 text-sm text-gray-900 font-mono">#{{ str_pad($pengaduan->id_pengaduan, 6, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Judul Pengaduan</label>
                                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $pengaduan->judul_pengaduan }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Isi Pengaduan</label>
                                    <div class="mt-1 bg-gray-50 rounded-lg p-4">
                                        <p class="text-gray-900 whitespace-pre-wrap">{{ $pengaduan->isi_pengaduan }}</p>
                                    </div>
                                </div>

                                @if($pengaduan->foto_pengaduan)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Pengaduan</label>
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <img src="data:image/jpeg;base64,{{ $pengaduan->foto_pengaduan }}" 
                                             alt="Foto Pengaduan" 
                                             class="max-w-full h-auto rounded-lg shadow-sm cursor-pointer"
                                             onclick="openImageModal(this.src)">
                                        <p class="text-xs text-gray-500 mt-2">Klik gambar untuk memperbesar</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Admin Response Section -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Response Admin</h3>
                            
                            @if($pengaduan->hasResponse())
                                <!-- Existing Response -->
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-blue-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.405L3 21l1.405-5.094A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <div class="text-sm text-blue-700 mb-2">
                                                <strong>Response Admin</strong> - {{ $pengaduan->tanggal_response->format('d F Y, H:i') }} WIB
                                            </div>
                                            <p class="text-blue-800 whitespace-pre-wrap">{{ $pengaduan->response_admin }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-600 bg-gray-50 rounded-lg p-3">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Response sudah dikirim ke penghuni. Admin hanya dapat memberikan response satu kali per pengaduan.
                                </div>
                            @elseif($pengaduan->status === 'Menunggu')
                                <!-- Response Form - Only available if status is "Menunggu" -->
                                <form method="POST" action="{{ route('admin.pengaduan.respond', $pengaduan) }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="response_admin" class="block text-sm font-medium text-gray-700">Response untuk Penghuni</label>
                                        <textarea name="response_admin" 
                                                  id="response_admin" 
                                                  rows="5" 
                                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('response_admin') border-red-300 @enderror"
                                                  placeholder="Tulis response untuk pengaduan ini..."
                                                  required>{{ old('response_admin') }}</textarea>
                                        @error('response_admin')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-sm text-gray-500">Maksimal 1000 karakter. Response hanya dapat dikirim satu kali dan akan mengubah status menjadi "Diproses".</p>
                                    </div>
                                    
                                    <div class="flex justify-end">
                                        <button type="submit" 
                                                class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center"
                                                onclick="return confirm('Apakah Anda yakin ingin mengirim response ini? Status akan berubah menjadi Diproses dan response tidak dapat diubah.')">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                            Kirim Response
                                        </button>
                                    </div>
                                </form>
                            @else
                                <!-- No response form if status is not "Menunggu" -->
                                <div class="text-sm text-gray-600 bg-gray-50 rounded-lg p-3">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Tidak ada response dari admin untuk pengaduan ini.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    
                    <!-- Penghuni Information -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Penghuni</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->penghuni->user->nama }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->penghuni->user->email }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No. HP</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->penghuni->user->no_hp ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Penghuni</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pengaduan->penghuni->status_penghuni === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $pengaduan->penghuni->status_penghuni }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Room Information -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kamar</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No. Kamar</label>
                                    <p class="mt-1 text-sm text-gray-900 font-medium">{{ $pengaduan->kamar->no_kamar }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tipe Kamar</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->kamar->tipeKamar->tipe_kamar }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Kamar</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($pengaduan->kamar->status === 'Kosong') bg-green-100 text-green-800
                                        @elseif($pengaduan->kamar->status === 'Dipesan') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        @if($pengaduan->kamar->status === 'Kosong')
                                            Tersedia
                                        @elseif($pengaduan->kamar->status === 'Dipesan')
                                            Dipesan
                                        @elseif($pengaduan->kamar->status === 'Terisi')
                                            Sedang Ditempati
                                        @else
                                        {{ $pengaduan->kamar->status }}
                                        @endif
                                    </span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.kamar.show', $pengaduan->kamar) }}" 
                                       class="text-orange-600 hover:text-orange-800 text-sm font-medium">
                                        Lihat Detail Kamar →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Management -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Kelola Pengaduan</h3>
                            
                            @if($pengaduan->status === 'Menunggu')
                                <div class="space-y-4">
                                    <div class="text-sm text-gray-600 bg-blue-50 rounded-lg p-3 mb-4">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Anda dapat memproses pengaduan ini secara langsung atau membalas pesan terlebih dahulu.
                                    </div>
                                    
                                    <form method="POST" action="{{ route('admin.pengaduan.updateStatus', $pengaduan) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center justify-center"
                                                onclick="return confirm('Apakah Anda yakin ingin memproses pengaduan ini tanpa mengirim pesan?')">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            Proses Pengaduan
                                        </button>
                                    </form>
                                </div>
                            @elseif($pengaduan->status === 'Diproses')
                                <div class="text-sm text-gray-600 bg-orange-50 rounded-lg p-3">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Pengaduan sedang diproses. Menunggu konfirmasi selesai dari penghuni.
                                </div>
                            @else
                                <div class="text-sm text-gray-600 bg-green-50 rounded-lg p-3">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Pengaduan sudah selesai ditangani dan dikonfirmasi oleh penghuni.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Timeline</h3>
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    <li>
                                        <div class="relative pb-8">
                                            @if($pengaduan->status !== 'Menunggu')
                                                <div class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></div>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-900 font-medium">Pengaduan dibuat</p>
                                                        <p class="text-sm text-gray-500">{{ $pengaduan->tanggal_pengaduan->format('d F Y, H:i') }} WIB</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    
                                    @if($pengaduan->status !== 'Menunggu')
                                    <li>
                                        <div class="relative pb-8">
                                            @if($pengaduan->status === 'Selesai')
                                                <div class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></div>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div class="h-8 w-8 rounded-full bg-orange-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-900 font-medium">
                                                            @if($pengaduan->hasResponse())
                                                                Admin memberikan response dan memproses
                                                            @else
                                                                Admin memproses pengaduan
                                                            @endif
                                                        </p>
                                                        <p class="text-sm text-gray-500">
                                                            @if($pengaduan->hasResponse())
                                                                {{ $pengaduan->tanggal_response->format('d F Y, H:i') }} WIB
                                                            @else
                                                                {{ $pengaduan->updated_at->format('d F Y, H:i') }} WIB
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif

                                    @if($pengaduan->status === 'Selesai')
                                    <li>
                                        <div class="relative">
                                            <div class="relative flex space-x-3">
                                                <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-900 font-medium">Penghuni konfirmasi selesai</p>
                                                        <p class="text-sm text-gray-500">{{ $pengaduan->updated_at->format('d F Y, H:i') }} WIB</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="modalImage" src="" alt="Foto Pengaduan" class="max-w-full max-h-full object-contain rounded-lg">
        </div>
    </div>

    @push('scripts')
    <script>
        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
    @endpush
</x-admin-layout> 